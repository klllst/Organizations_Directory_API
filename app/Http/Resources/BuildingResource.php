<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "BuildingResource",
    title: "Building Resource",
    properties: [
        new OA\Property(property: "id", description: "ID здания", type: "integer"),
        new OA\Property(
            property: "address",
            description: "Адрес здания",
            properties: [
                new OA\Property(property: "city", type: "string"),
                new OA\Property(property: "street", type: "string"),
                new OA\Property(property: "house", type: "string"),
            ],
            type: "object"
        ),
        new OA\Property(property: "latitude", description: "Географическая широта", type: "number", format: "float"),
        new OA\Property(property: "longitude", description: "Географическая долгота", type: "number", format: "float")
    ],
    type: "object"
)]
class BuildingResource extends JsonResource
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
            'address.city' => $this->address['city'],
            'address.street' => $this->address['street'],
            'address.house' => $this->address['house'],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'organizations' => $this->whenLoaded('organizations')
        ];
    }
}
