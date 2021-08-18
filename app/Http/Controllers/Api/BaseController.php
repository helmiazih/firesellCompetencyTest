<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use App\Http\Responses\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        $response = (preg_match('(store|create|update|delete)', $method) === 1) ?
            DB::transaction(function () use ($method, $parameters) {
                return call_user_func_array([$this, $method], $parameters);
            }) :
            call_user_func_array([$this, $method], $parameters);

        if ($response instanceof MessageBag) {
            return JsonResponse::error(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        }

        return JsonResponse::success($response);
    }
}
