<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OrganizationResource",
    title: "Organization Resource",
    properties: [
        new OA\Property(property: "id", description: "ID организации", type: "integer"),
        new OA\Property(property: "name", description: "Название организации", type: "string"),
        new OA\Property(property: "building", ref: "#/components/schemas/BuildingResource", description: "Здание, в котором находится организация"),
        new OA\Property(
            property: "phones",
            description: "Телефоны организации",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/OrganizationPhoneResource")
        ),
        new OA\Property(
            property: "activities",
            description: "Виды деятельности организации",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/ActivityResource")
        ),
    ],
    type: "object"
)]
class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'phones' => OrganizationPhoneResource::collection($this->whenLoaded('phones')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
