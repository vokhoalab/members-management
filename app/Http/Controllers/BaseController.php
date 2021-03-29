<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;

class BaseController extends Controller
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }

    /**
     * @param  array|mixed  $result
     * @param  string  $message
     * @param  array  $extraFields
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $message, $extraFields = [])
    {
        $response = $this->makeResponse($message, $result);
        $response = array_merge($extraFields, $response);

        return Response::json($response);
    }

    /**
     * @param  string  $error
     * @param  int  $code
     * @return JsonResponse
     */
    public function sendError($error, $code = 500)
    {
        return Response::json($this->makeError($error), $code);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    /**
     * @param Eloquent|string $model
     * @param array $input
     * @param array $records
     *
     * @return array
     */
    public function getTotalRecords($model, $input = [], $records = [])
    {
        if (!empty($input['search'])) {
            return ['totalRecords' => count($records)];
        }

        return ['totalRecords' => $model::count()];
    }
}
