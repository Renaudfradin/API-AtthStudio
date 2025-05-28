<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get all categories"
     *     )
     * )
     */
    public function index()
    {
        return CategoryResource::collection(Category::active()->get());
    }
}
