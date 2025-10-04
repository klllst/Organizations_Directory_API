<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationIndexRequest;
use App\Http\Requests\RadiusScopeRequest;
use App\Http\Requests\RectangleScopeRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class OrganizationController extends Controller
{
    #[OA\Get(
        path: '/api/organizations',
        summary: 'Get all organizations with optional filtering',
        security: [['apiKey' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'building', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'activity', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizationResource')
                )
            ),
            new OA\Response(response: 401, description: 'Unauthorized - Invalid API key'),
        ]
    )]
    public function index(OrganizationIndexRequest $request): JsonResponse
    {
        $organizations = Organization::filter($request->all())
            ->with([
                'building',
                'phones',
                'activities',
            ])
            ->get();

        return response()->json(OrganizationResource::collection($organizations));
    }

    #[OA\Get(
        path: '/api/organizations/{organization}',
        summary: 'Get organization by ID',
        security: [['apiKey' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizationResource')
            ),
            new OA\Response(response: 404, description: 'Organization not found'),
            new OA\Response(response: 401, description: 'Unauthorized - Invalid API key'),
        ]
    )]
    public function show(Organization $organization): JsonResponse
    {
        $organization->load([
            'activities',
            'building',
            'phones',
        ]);

        return response()->json(new OrganizationResource($organization));
    }

    #[OA\Get(
        path: '/api/organizations/in-radius',
        summary: 'Get organizations within radius from coordinates',
        security: [['apiKey' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'latitude', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'longitude', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'radius', in: 'query', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'building', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'activity', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizationResource')
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

        $organizations = Organization::filter($request->all())
            ->with([
                'building',
                'phones',
                'activities',
            ])
            ->whereHas('building', function ($query) use ($latitude, $longitude, $radius) {
                $query->whereRaw('
                    (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?))
                    + sin(radians(?)) * sin(radians(latitude)))) < ?', [$latitude, $longitude, $latitude, $radius]);
            })
            ->get();

        return OrganizationResource::collection($organizations);
    }

    #[OA\Get(
        path: '/api/organizations/in-rectangle',
        summary: 'Get organizations within rectangular area',
        security: [['apiKey' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'north', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'south', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'east', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'west', in: 'query', required: true, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'building', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'activity', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizationResource')
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthorized - Invalid API key'),
        ]
    )]
    public function inRectangle(RectangleScopeRequest $request): AnonymousResourceCollection
    {
        $north = $request->get('north');
        $south = $request->get('south');
        $east = $request->get('east');
        $west = $request->get('west');

        $organizations = Organization::filter($request->all())
            ->with([
                'building',
                'phones',
                'activities',
            ])
            ->whereHas('building', function ($query) use ($north, $south, $east, $west) {
                $query->whereBetween('latitude', [$south, $north])
                    ->whereBetween('longitude', [$west, $east]);
            })
            ->get();

        return OrganizationResource::collection($organizations);
    }
}
