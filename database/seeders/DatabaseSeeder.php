<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Archive;
use App\Models\Article;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->withProgressBar(1, fn () => User::factory(1)
            ->create([
                'name' => 'Renaud',
                'email' => 'renaud@gmail.com',
                'role' => Role::Admin,
                'password' => 'renaud@gmail.comrenaud@gmail.com',
            ])
        );
        $this->command->info('Admin Renaud created.');

        $this->withProgressBar(1, fn () => User::factory(1)
            ->create([
                'name' => 'Annie',
                'email' => 'annie@gmail.com',
                'role' => Role::Admin,
                'password' => 'annie@gmail.comannie@gmail.com',
            ])
        );
        $this->command->info('Admin Annie created.');

        $categoryNames = ['Stratégie design', 'Ux design', 'Culture branding', 'Psychologie design', 'Seo'];
        $this->withProgressBar(count($categoryNames), function ($i) use ($categoryNames) {
            Category::factory()->create([
                'title' => $categoryNames[$i],
                'slug' => str($categoryNames[$i])->slug(),
                'active' => true,
            ]);
        });
        $this->command->info('categories created.');

        Archive::factory(20)->create();
        Article::factory(20)->create();
        Project::factory(25)->create();
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $collection = new Collection;
        for ($i = 0; $i < $amount; $i++) {
            $collection[] = $createCollectionOfOne($i);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln('');

        return $collection;
    }
}
