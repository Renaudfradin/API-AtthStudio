<?php

use App\Models\Archive;
use App\Models\Article;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

it('returns the api home message', function () {
    $this->getJson('/api')
        ->assertOk()
        ->assertJsonStructure(['message']);
});

it('reports a healthy api and database', function () {
    $this->getJson('/api/health')
        ->assertOk()
        ->assertJsonPath('status', 'healthy')
        ->assertJsonPath('database', 'connected')
        ->assertJsonStructure(['timestamp']);
});

it('reports an unhealthy api when the database is disconnected', function () {
    DB::shouldReceive('connection')->andThrow(new PDOException('down'));

    $this->getJson('/api/health')
        ->assertServiceUnavailable()
        ->assertJsonPath('status', 'unhealthy')
        ->assertJsonPath('database', 'disconnected');
});

it('lists only active articles', function () {
    Article::factory()->create(['active' => true, 'slug' => 'visible-article']);
    Article::factory()->create(['active' => false, 'slug' => 'hidden-article']);

    $this->getJson('/api/articles')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'visible-article');
});

it('shows an article by slug and returns 404 when missing', function () {
    Article::factory()->create(['active' => true, 'slug' => 'known-article']);

    $this->getJson('/api/article/known-article')
        ->assertOk()
        ->assertJsonPath('data.slug', 'known-article');

    $this->getJson('/api/article/missing-article')->assertNotFound();
});

it('hides inactive articles on the detail route', function () {
    Article::factory()->create(['active' => false, 'slug' => 'hidden-article']);

    $this->getJson('/api/article/hidden-article')->assertNotFound();
});

it('suggests active articles that share a category', function () {
    $category = Category::factory()->create(['active' => true]);
    $other = Category::factory()->create(['active' => true]);

    Article::factory()->create([
        'active' => true,
        'slug' => 'suggested-one',
        'category_id' => $category->id,
    ]);
    Article::factory()->create([
        'active' => true,
        'slug' => 'suggested-two',
        'category_id' => $category->id,
    ]);
    Article::factory()->create([
        'active' => false,
        'slug' => 'suggested-hidden',
        'category_id' => $category->id,
    ]);
    Article::factory()->create([
        'active' => true,
        'slug' => 'other-category',
        'category_id' => $other->id,
    ]);

    $this->getJson('/api/suggest-articles/'.$category->id)
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('returns an empty list when a category has no active articles', function () {
    $category = Category::factory()->create(['active' => true]);

    $this->getJson('/api/suggest-articles/'.$category->id)
        ->assertOk()
        ->assertJsonCount(0, 'data');
});

it('returns 404 when suggesting articles for a missing or inactive category', function () {
    $inactive = Category::factory()->create(['active' => false]);

    $this->getJson('/api/suggest-articles/'.$inactive->id)->assertNotFound();
    $this->getJson('/api/suggest-articles/999999')->assertNotFound();
});

it('lists only active projects and shows one by slug', function () {
    Project::factory()->create(['active' => true, 'slug' => 'visible-project']);
    Project::factory()->create(['active' => false, 'slug' => 'hidden-project']);

    $this->getJson('/api/projects')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'visible-project');

    $this->getJson('/api/project/visible-project')
        ->assertOk()
        ->assertJsonPath('data.slug', 'visible-project');

    $this->getJson('/api/project/missing-project')->assertNotFound();
    $this->getJson('/api/project/hidden-project')->assertNotFound();
});

it('lists only active archives and shows one by slug', function () {
    Archive::factory()->create(['active' => true, 'slug' => 'visible-archive']);
    Archive::factory()->create(['active' => false, 'slug' => 'hidden-archive']);

    $this->getJson('/api/archives')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'visible-archive');

    $this->getJson('/api/archive/visible-archive')
        ->assertOk()
        ->assertJsonPath('data.slug', 'visible-archive');

    $this->getJson('/api/archive/missing-archive')->assertNotFound();
    $this->getJson('/api/archive/hidden-archive')->assertNotFound();
});

it('lists only active categories', function () {
    Category::factory()->create(['active' => true, 'slug' => 'visible-category']);
    Category::factory()->create(['active' => false, 'slug' => 'hidden-category']);

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'visible-category');
});
