<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 *   host="api.datlichviet.dev",
 *   basePath="/v1",
 *   schemes={"https"},
 *   @SWG\Info(
 *     title="Dat Lich Viet API",
 *     version="1.0.0"
 *   ),
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="api_key"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
