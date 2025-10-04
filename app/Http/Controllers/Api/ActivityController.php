<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityOrganizationsRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Organization;
use App\Services\ActivityService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ActivityController extends Controller
{
    #[OA\Get(
        path: "/api/activities/{activity}/organizations",
        description: "Returns organizations for the specified activity. Use include_descendants parameter to include child activities.",
        summary: "Get organizations by activity",
        security: [["apiKey" => []]],
        tags: ["Activities"],
        parameters: [
            new OA\Parameter(
                name: "activity",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "include_descendants",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "boolean", default: false)
            ),
            new OA\Parameter(
                name: "search",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "building",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer")
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/OrganizationResource")
                )
            ),
            new OA\Response(response: 404, description: "Activity not found"),
            new OA\Response(response: 422, description: "Validation error"),
            new OA\Response(response: 401, description: "Unauthorized - Invalid API key")
        ]
    )]
    public function getOrganizations(
        ActivityOrganizationsRequest $request,
        Activity $activity,
        ActivityService $activityService
    ): AnonymousResourceCollection {
        $includeDescendants = $request->boolean('include_descendants', false);

        $activityIds = $includeDescendants
            ? $activityService->getActivityWithDescendantsIds($activity)
            : [$activity->id];

        $organizations = Organization::filter($request->all())
            ->with(['building', 'phones', 'activities'])
            ->whereHas('activities', function ($query) use ($activityIds) {
                $query->whereIn('activities.id', $activityIds);
            })
            ->get();

        return OrganizationResource::collection($organizations);
    }
}
