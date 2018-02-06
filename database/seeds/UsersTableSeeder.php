<?php

use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //平台卡账户
        $user = new User();
        $user->id   = Trade::PLATFORM_CARD;
        $user->login = '23916728776';
        $user->name = '平台卡账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '23916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();


        //平台支付宝账户
        $user = new User();
        $user->id   = Trade::PLATFORM_MONEY_ALI;
        $user->login = '33916728776';
        $user->name = '平台支付宝账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '33916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        //平台微信账户
        $user = new User();
        $user->id   = Trade::PLATFORM_MONEY_WX;
        $user->login = '43916728776';
        $user->name = '平台微信账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '43916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();


        //平台货款冻结账户
        $user = new User();
        $user->id   = Trade::PLATFORM_FROZEN;
        $user->login = '53916728776';
        $user->name = '平台货款冻结余额';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '53916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();


        //平台激活码账户
        $user = new User();
        $user->id   = Trade::PLATFORM_ACTIVE;
        $user->login = '63916728776';
        $user->name = '平台激活码账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '63916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        //平台富有账户
        $user = new User();
        $user->id   = Trade::PLATFORM_FY;
        $user->login = '73916728776';
        $user->name = '平台富有账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '73916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        //平台传化账户
        $user = new User();
        $user->id   = Trade::PLATFORM_CH;
        $user->login = '83916728776';
        $user->name = '平台传化提现账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '83916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        //平台余额，用于收取手续费
        $user = new User();
        $user->id   = Trade::PLATFORM_CASH;
        $user->login = '93916728776';
        $user->name = '平台余额账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '93916728776';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        //一码付账户
        $user = new User();
        $user->id   = Trade::PLATFORM_OC;
        $user->login = '512315256426';
        $user->name = '一码付账户';
        $user->password = bcrypt('nhIqe9lPjElTTqHIn/S5G/zrtQM=');
        $user->phone = '512315256426';
        $user->email = 'crady@yang.com';
        $user->money = 0;
        $user->save();

        DB::select("ALTER TABLE users AUTO_INCREMENT = 1001;");
    }
}
