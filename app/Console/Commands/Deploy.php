<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute all deployment and optimization commands';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting deployment process...');

        $commands = [
            ['optimize:clear', [], 'Clearing all optimized files...'],
            ['migrate', ['--force' => true], 'Running database migrations...'],
            ['storage:link', [], 'Creating storage symbolic links...'],
            ['l5-swagger:generate', [], 'Generating OpenAPI documentation...'],
            ['config:cache', [], 'Caching configuration...'],
            ['route:cache', [], 'Caching routes...'],
            ['view:cache', [], 'Caching views...'],
        ];

        foreach ($commands as [$command, $parameters, $description]) {
            $this->info($description);

            try {
                $exitCode = Artisan::call($command, $parameters);
            } catch (Throwable $exception) {
                $this->error("✗ {$command} threw exception: ".$exception->getMessage());
                Log::error("Deploy command exception: {$command}", ['exception' => $exception]);

                return Command::FAILURE;
            }

            if ($exitCode !== Command::SUCCESS) {
                $this->error("✗ {$command} failed with exit code {$exitCode}");
                $output = trim(Artisan::output());

                if ($output !== '') {
                    $this->line($output);
                }

                Log::error("Deploy command failed: {$command}", [
                    'exit_code' => $exitCode,
                    'output' => $output,
                ]);

                return Command::FAILURE;
            }

            $this->info("✓ {$command} executed successfully");
            $this->newLine();
        }

        $this->info('Deployment process completed!');

        return Command::SUCCESS;
    }
}
