<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArchiveDetailResource;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use OpenApi\Attributes as OA;

class ArchiveController extends Controller
{
    #[OA\Get(
        path: '/api/archives',
        summary: 'Get all archives',
        tags: ['Archives'],
        responses: [
            new OA\Response(response: 200, description: 'Get all archives'),
        ],
    )]
    public function index()
    {
        return ArchiveResource::collection(Archive::active()->paginate(12));
    }

    #[OA\Get(
        path: '/api/archive/{archive}',
        summary: 'Get an archive by slug',
        tags: ['Archives'],
        parameters: [
            new OA\Parameter(
                name: 'archive',
                in: 'path',
                required: true,
                description: 'Archive slug',
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Get an archive by slug'),
        ],
    )]
    public function show(Archive $archive)
    {
        $archive->load('documents');

        return ArchiveDetailResource::make($archive);
    }
}
