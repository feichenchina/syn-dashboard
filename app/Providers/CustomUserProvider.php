<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Model;

// class CustomUserProvider extends EloquentUserProvider
class CustomUserProvider implements UserProvider
{
    /**
     * The Mongo User Model
     */
    private $model;

    /**
     * Create a new mongo user provider.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @return void
     */
    public function __construct(Model $userModel = null)
    {

        $this->model = $userModel;
    }
    public function retrieveById($identifier)
    {
        return $this->model->where('id', $identifier)->first();
    }

    public function retrieveByToken($identifier, $token)
    {}

    public function updateRememberToken(Authenticatable $user, $token)
    {}

    public function retrieveByCredentials(array $credentials)
    {
        if (\Encore\Admin\Facades\Admin::user()) {
            return \Encore\Admin\Facades\Admin::user();
        }
        // 用$credentials里面的用户名密码去获取用户信息，然后返回Illuminate\Contracts\Auth\Authenticatable对象
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))) {
            return null;
        }

        // 解析给定的凭证，例如用户名和密码
        $username = $credentials['username'];
        // 在这里你可以根据需要处理其他凭证

        // 从数据库中查找用户信息
        $user = $this->model->where('email', $username)->first();
        return $user; // 返回用户对象或者 null
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (\Encore\Admin\Facades\Admin::user()) {
            return true;
        }
        // 用$credentials里面的用户名密码校验用户，返回true或false
        $username = $credentials['username'];
        $password = $credentials['password'];

        // 从数据库中获取用户信息
        $user = $this->model->where('email', $username)->first();
        if (!$user) {
            return false; // 如果用户不存在，返回验证失败
        }

//        if ($this->model instanceof  Teacher){
//            if ($password == $user['password']){
//                return true;
//            }
//        }
        // 验证密码是否匹配
        if (\Hash::check($password, $user->password)) {
            return true; // 返回用户对象
        }

        return false; // 密码不匹配，返回验证失败
    }
}
