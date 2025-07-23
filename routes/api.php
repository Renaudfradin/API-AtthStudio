<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/projects', [ProjectController::class, 'index']);

Route::get('/project/{project:slug}', [ProjectController::class, 'show']);

Route::get('/archives', [ArchiveController::class, 'index']);

Route::get('/archive/{archive:slug}', [ArchiveController::class, 'show']);

Route::get('/articles', [ArticleController::class, 'index']);

Route::get('/article/{article:slug}', [ArticleController::class, 'show']);

Route::get('/suggest-articles/{article:category_id}', [ArticleController::class, 'suggestArticles']);

Route::get('/categories', [CategoryController::class, 'index']);
