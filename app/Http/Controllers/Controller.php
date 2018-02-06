<?php

namespace App\Http\Controllers;

use App\Models\User;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

/**
 * @property Response response
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(Response $response)
    {
        $this->response = $response;

    }

    public function userInfo(User $user){
        $user_arr = $user->toArray();
        $admin = getAdminUser($user);
//        $user_arr['roles'] = $admin->roles()->pluck('name');
        $user_arr['main_money'] = $admin->money;
        $user_arr['main_frozen_rec'] = $admin->frozen_rec;
        $user_arr['main_frozen_pay'] = $admin->frozen_pay;
        $user_arr['main_processing'] = $admin->processing;
        $user_arr['is_pay_pass'] = array_get($user, 'pay_pass','') != '';
        return $user_arr;
    }

    /**
     * 返回逻辑错误
     * @param $message
     * @param $errorCode
     * @return mixed
     */
    public function errorResponse($message, $errorCode){
        return $this->response->withArray([
            'code' => $errorCode,
            'http_code' => 200,
            'message' => $message
        ],[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 返回成功信息及内容
     * @param array $data
     * @param string $message
     * @return mixed
     */
    public function successResponse(array $data = [], $message = 'OK'){
        return $this->response->withArray([
            'code' => 200,
            'http_code' => 200,
            'message' => $message,
            'data' => $data
        ],[],JSON_UNESCAPED_UNICODE);
    }
}
