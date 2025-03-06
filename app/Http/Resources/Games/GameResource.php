<?php

namespace App\Http\Resources\Games;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'is_enable' => $this->is_enable,
            'color' => $this->color,
            'order' => $this->order,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'levels' => LevelResource::collection($this->whenLoaded('levels')),
            'progresses' => ProgressResource::collection($this->whenLoaded('progresses')),
        ];
    }
}
