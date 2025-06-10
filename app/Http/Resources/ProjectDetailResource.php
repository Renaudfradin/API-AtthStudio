<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => Storage::disk('scaleway')->url($this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'documents' => DocumentResource::collection($this->documents),
        ];
    }
}
