<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Get all articles",
     *     tags={"Articles"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get all articles"
     *     )
     * )
     */
    public function index()
    {
        return ArticleResource::collection(Article::active()->paginate(12));
    }

    /**
     * @OA\Get(
     *     path="/api/article/{article:slug}",
     *     summary="Get an article by slug",
     *     tags={"Articles"},
     *
     *     @OA\Parameter(
     *         name="article",
     *         in="path",
     *         required=true,
     *         description="Article slug",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get an article by slug"
     *     )
     * )
     */
    public function show(Article $article)
    {
        return ArticleDetailResource::make($article);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/{article:category_id}",
     *     summary="Get articles by category id",
     *     tags={"Articles"},
     *
     *     @OA\Parameter(
     *         name="article",
     *         in="path",
     *         required=true,
     *         description="Article category id",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get articles by category id"
     *     )
     * )
     */
    public function suggestArticles(Article $article)
    {
        return ArticleResource::collection(
            Article::active()
                ->where('category_id', $article->category_id)
                ->get()
        );
    }
}
