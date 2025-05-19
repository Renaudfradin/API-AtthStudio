<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->withProgressBar(1, fn () => User::factory(1)
            ->create([
                'name' => 'Renaud',
                'email' => 'renaud@gmail.com',
                'role' => Role::Admin,
            ])
        );
        $this->command->info('Admin Renaud created.');

        $this->withProgressBar(1, fn () => User::factory(1)
            ->create([
                'name' => 'Annie',
                'email' => 'annie@gmail.com',
                'role' => Role::Admin,
            ])
        );
        $this->command->info('Admin Annie created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
