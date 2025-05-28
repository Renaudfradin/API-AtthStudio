<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArchiveDetailResource;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;

class ArchiveController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/archives",
     *     summary="Get all archives",
     *     tags={"Archives"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get all archives"
     *     )
     * )
     */
    public function index()
    {
        return ArchiveResource::collection(Archive::active()->get());
    }

    /**
     * @OA\Get(
     *     path="/api/archives/{archive:slug}",
     *     summary="Get an archive by slug",
     *     tags={"Archives"},
     *
     *     @OA\Parameter(
     *         name="archive",
     *         in="path",
     *         required=true,
     *         description="Archive slug",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get an archive by slug"
     *     )
     * )
     */
    public function show(Archive $archive)
    {
        return ArchiveDetailResource::make($archive);
    }
}
