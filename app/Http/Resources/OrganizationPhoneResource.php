<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OrganizationPhoneResource",
    title: "Organization Phone Resource",
    properties: [
        new OA\Property(property: "id", description: "ID телефона", type: "integer"),
        new OA\Property(property: "number", description: "Номер телефона", type: "string")
    ],
    type: "object"
)]
class OrganizationPhoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
        ];
    }
}
