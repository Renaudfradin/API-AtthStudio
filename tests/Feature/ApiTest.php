<?php

use App\Models\Archive;
use App\Models\Article;
use App\Models\Category;
use App\Models\Project;

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
});

it('lists only active categories', function () {
    Category::factory()->create(['active' => true, 'slug' => 'visible-category']);
    Category::factory()->create(['active' => false, 'slug' => 'hidden-category']);

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'visible-category');
});
