<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login')->unique()->comment('登录名');
            $table->string('password')->comment('密码');
            $table->string('name')->nullable()->comment('昵称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('phone')->index()->nullable()->comment('手机号码');
            $table->unsignedBigInteger('money')->default(0)->comment('可用金额');
            $table->unsignedBigInteger('processing')->default(0)->comment('在途金额(充值+提现)');
            $table->unsignedBigInteger('frozen_pay')->default(0)->comment('已冻结');
            $table->unsignedBigInteger('frozen_rec')->default(0)->comment('将收入金额');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->unsignedInteger('role_id')->default(0)->comment('用户角色ID');
            $table->string('pay_pass')->nullable()->comment('支付密码');
            $table->unsignedInteger('main_id')->default(0)->index()->comment('超级账户 ID');
            $table->string('auth_code')->nullable()->comment('双重验证密钥');
            $table->integer('invite_user_id')->nullable()->comment('推荐人 ID');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
