<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RadiusScopeRequest;
use App\Http\Requests\RectangleScopeRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class BuildingController extends Controller
{
    #[OA\Get(
        path: '/api/buildings/in-radius',
        summary: 'Get buildings within radius from coordinates',
        security: [['apiKey' => []]],
        tags: ['Buildings'],
        parameters: [
            new OA\Parameter(name: 'latitude', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'longitude', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'radius', in: 'query', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/BuildingResource')
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthorized - Invalid API key'),
        ]
    )]
    public function inRadius(RadiusScopeRequest $request): AnonymousResourceCollection
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        $buildings = Building::with([
            'organizations.phones',
            'organizations.activities',
        ])
            ->whereRaw('
                    (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?))
                    + sin(radians(?)) * sin(radians(latitude)))) < ?', [$latitude, $longitude, $latitude, $radius])
            ->get();

        return BuildingResource::collection($buildings);
    }

    #[OA\Get(
        path: '/api/buildings/in-rectangle',
        summary: 'Get buildings within rectangular area',
        security: [['apiKey' => []]],
        tags: ['Buildings'],
        parameters: [
            new OA\Parameter(name: 'south', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'north', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'west', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'east', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/BuildingResource')
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthorized - Invalid API key'),
        ]
    )]
    public function inRectangle(RectangleScopeRequest $request): AnonymousResourceCollection
    {
        $south = $request->get('south');
        $north = $request->get('north');
        $west = $request->get('west');
        $east = $request->get('east');

        $buildings = Building::with([
            'organizations.phones',
            'organizations.activities',
        ])
            ->whereBetween('latitude', [$south, $north])
            ->whereBetween('longitude', [$west, $east])
            ->get();

        return BuildingResource::collection($buildings);
    }
}
