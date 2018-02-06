<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\Client;
use Laravel\Passport\Bridge\Scope;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\CryptKey;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function loginPass(Request $request)
    {
        //验证参数
        $this->validate($request, [
            'phone' => 'required|integer',
            'password' => 'required|string'
        ]);
        $key = "user_login_fail_number_".$request->phone;


        /**
         * 连续输入错误5次,直接报错
         */
        if (Cache::get($key) > 10) {
            return $this->errorResponse('该账号已经被冻结,请24小时候重试',203);
        }

        $user  = User::whereLogin($request->phone)->first();
        if(!$user){
            return $this->errorResponse("用户名和密码不匹配", 201);
        }

        if(!Hash::check($request->password, $user->password)){
            if (Cache::has($key)) {
                Cache::increment($key, 1);
            } else {
                Cache::put($key, 1, 24*60);
            }
            return $this->errorResponse("用户名和密码不匹配", 201);
        }
        /**
         * 登陆成功,次数清零
         */
        Cache::forget($key);
        return $this->successResponse($this->getToken($user));
    }

    /**
     * 获取 Token 及其相关信息
     * @param User $user
     * @return array
     */
    public function getToken(User $user){
        $token = new AccessToken($user->id);
        $token->setIdentifier(generateUniqueIdentifier());
        $token->setClient(new Client(2, null, null));
        $token->setExpiryDateTime(Carbon::now()->addDay());
        $token->addScope(new Scope('activity'));
        $privateKey = new CryptKey('file://'.storage_path('oauth-private.key'));

        $accessTokenRepository = new AccessTokenRepository(new TokenRepository, new Dispatcher);
        $accessTokenRepository->persistNewAccessToken($token);
        $expireDateTime = $token->getExpiryDateTime()->getTimestamp();

        $jwtAccessToken = $token->convertToJWT($privateKey);
        $user_arr = $user->toArray();
//        if( $user->main_id!=0 ){
//            $user_arr['roles'] = User::find($user->main_id)->roles()->pluck('name');
//        }else{
//            $user_arr['roles'] = $user->roles()->pluck('name');
//        }
        $user_arr['is_pay_pass'] = array_get($user, 'pay_pass','') != '';
        return [
            'token_type'   => 'Bearer',
            'expires_in'   => $expireDateTime - (new \DateTime())->getTimestamp(),
            'access_token' => (string) $jwtAccessToken,
            'user'         => $user_arr
        ];
    }
}
