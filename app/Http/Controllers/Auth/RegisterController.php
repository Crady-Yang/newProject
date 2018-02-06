<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\Scope;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\CryptKey;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->login = $data['phone'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->invite_user_id = $data['invite_user_id'];
        $user->save();
        return $user;
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data,[
            'email' => 'string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|digits:11',
            'name' => 'string|max:30',
            'invite_user_id' => 'integer'
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors()->first(),400);
        }


        $phone = $request->phone; //手机号码
        if (!$this->is_phone_number_pass($request->phone)) {
            return $this->errorResponse("手机号格式不对", 301);
        }
        if (User::where('login', $request->phone)->first()) {
            return $this->errorResponse("手机号已经存在", 201);
        }

        //验证数据
        $dataHandle = [
            'name' => array_get($request, 'name', null),
            'login' => $phone,
            'phone' => $phone,
            'password' => bcrypt($request->password),
            'email' => array_get($request, 'email', ''),
            'invite_user_id' => array_get($request, 'invite_user_id', '8')
        ];
        try {
            $user = $this->create($dataHandle);
        } catch (\Exception $e) {
            return $this->errorResponse("注册失败", 300);
        }

        return $this->login($user);
    }

    /**
     * 登录
     * @param $user
     * @return mixed
     */
    private function login($user)
    {
        $token = new AccessToken($user->id);
        $token->setIdentifier(generateUniqueIdentifier());
        $token->setClient(new \Laravel\Passport\Bridge\Client(2, null, null));
        $token->setExpiryDateTime(Carbon::now()->addDay());
        $token->addScope(new Scope('activity'));
        $privateKey = new CryptKey('file://' . storage_path('oauth-private.key'));

        $accessTokenRepository = new AccessTokenRepository(new TokenRepository(), new Dispatcher());
        $accessTokenRepository->persistNewAccessToken($token);
        $expireDateTime = $token->getExpiryDateTime()->getTimestamp();

        $jwtAccessToken = $token->convertToJWT($privateKey);

        $responseParams = [
            'token_type' => 'Bearer',
            'expires_in' => $expireDateTime - (new \DateTime())->getTimestamp(),
            'access_token' => (string)$jwtAccessToken,
            'user' => $this->userInfo($user)
        ];

        return $this->successResponse($responseParams);
    }

    /**
     * 手机正则验证
     * @param $phone
     * @return bool
     */
    function is_phone_number_pass($phone){
        return (bool)preg_match('/^1[34578]\d{9}$/', $phone);
    }

}
