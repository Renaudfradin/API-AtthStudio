<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use OpenApi\Attributes as OA;

class ProjectController extends Controller
{
    #[OA\Get(
        path: '/api/projects',
        summary: 'Get all projects',
        tags: ['Projects'],
        responses: [
            new OA\Response(response: 200, description: 'Get all projects'),
        ],
    )]
    public function index()
    {
        return ProjectResource::collection(Project::active()->paginate(12));
    }

    #[OA\Get(
        path: '/api/project/{project}',
        summary: 'Get an project by slug',
        tags: ['Projects'],
        parameters: [
            new OA\Parameter(
                name: 'project',
                in: 'path',
                required: true,
                description: 'Project slug',
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Get an project by slug'),
        ],
    )]
    public function show(Project $project)
    {
        $project->load('documents');

        return ProjectDetailResource::make($project);
    }
}
