<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ActivityResource',
    title: 'Activity Resource',
    properties: [
        new OA\Property(property: 'id', description: 'ID вида деятельности', type: 'integer'),
        new OA\Property(property: 'name', description: 'Название вида деятельности', type: 'string'),
        new OA\Property(property: 'parent', ref: '#/components/schemas/ActivityResource', description: 'Родительский вид деятельности'),
        new OA\Property(
            property: 'children',
            description: 'Дочерние виды деятельности',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ActivityResource')
        ),
    ],
    type: 'object'
)]
class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'organizations' => OrganizationResource::collection($this->whenLoaded('organizations')),
            'parent' => new ActivityResource($this->whenLoaded('parent')),
            'children' => ActivityResource::collection($this->whenLoaded('children')),
        ];
    }
}
