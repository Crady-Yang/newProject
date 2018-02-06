<?php
/**
 * Created by PhpStorm.
 * User: crady_yang
 * Date: 2018/2/5
 * Time: 下午5:17
 */

/**
 * 获取唯一Token Id
 * @param int $length
 * @return string
 */
function generateUniqueIdentifier($length = 40)
{
    try {
        $id = bin2hex(random_bytes($length));
        if(DB::table('oauth_access_tokens')->where('id',$id)->exists()){
            return $this->generateUniqueIdentifier($length);
        }
        return $id;
    }catch (\Exception $e) {
        return $this->generateUniqueIdentifier($length);
    }
}

/**
 * 获取主帐号 Model
 * @param \App\Models\User $user
 * @return \App\Models\User
 */
function getAdminUser(\App\Models\User $user){
    if( $user->main_id != 0 && $user->main_id != $user->id && (config('app.with_main') == 'true')){
        return \App\Models\User::find($user->main_id);
    }else{
        return $user;
    }
}
