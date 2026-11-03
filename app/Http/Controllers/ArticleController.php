<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use OpenApi\Attributes as OA;

class ArticleController extends Controller
{
    #[OA\Get(
        path: '/api/articles',
        summary: 'Get all articles',
        tags: ['Articles'],
        responses: [
            new OA\Response(response: 200, description: 'Get all articles'),
        ],
    )]
    public function index()
    {
        return ArticleResource::collection(Article::active()->paginate(12));
    }

    #[OA\Get(
        path: '/api/article/{article}',
        summary: 'Get an article by slug',
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(
                name: 'article',
                in: 'path',
                required: true,
                description: 'Article slug',
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Get an article by slug'),
        ],
    )]
    public function show(Article $article)
    {
        $article->load('categorie');

        return ArticleDetailResource::make($article);
    }

    #[OA\Get(
        path: '/api/suggest-articles/{category_id}',
        summary: 'Get articles by category id',
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(
                name: 'category_id',
                in: 'path',
                required: true,
                description: 'Article category id',
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Get articles by category id'),
        ],
    )]
    public function suggestArticles(Category $category)
    {
        abort_unless($category->active, 404);

        return ArticleResource::collection(
            $category->articles()->active()->orderBy('id')->get()
        );
    }
}
