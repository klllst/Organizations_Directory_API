<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "API for get information about organizations", title: "Organizations Directory Api"),
    OA\Server(url: 'http://webserver:7020', description: "local server"),
    OA\SecurityScheme(
        securityScheme: "apiKey",
        type: "apiKey",
        name: "X-API-Key",
        in: "header"
    )
]
abstract class Controller
{
    //
}
