<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Builder\TradeBuilder;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\Trade
 *
 * pay_type_text(交易类型描述){
 *  recharge:充值(进)
 *  withdraw:提现(出)
 *  input:转入
 *  output:转出
 *  pay_frozen:支付冻结(出)
 *  multiple_settle:分批支付结算(出)
 * }
 *
 * 下面的100-199这样的数字 100代表一个子类型   101-199代表这个类型被回到执行失败的次数
 *
 * trade_type(交易类型){
 *  10000:充值
 *      100-199 支付宝
 *      200-299 微信
 *  20000:提现
 *      1-99 银行卡
 *      100-199 传化提现
 *  30000:转入(
 *      30000:卡充值,
 *      30001:卡支付,
 *      30002:支付宝当面付,
 *      30003:微信当面付,
 *      30004:订单结算,
 *      30005:退款,
 *      30006:直接转账,
 *      30007:一码付-支付宝,
 *      30008:一码付-微信,
 *      30020:购卡收入(平台)
 *      30021:用户充值收入(平台)
 *      30022:货款冻结收入(平台)
 *      30023:台卡代理收入(平台)
 *      30100:用户支付宝充值收入(平台)
 *
 *      代理
 *      30010:普通代理收入
 *      30011:新入网代理收入
 *      30012:优质代理收入
 *      ...
 *      30018:惩罚代理收入
 *      30019:台卡代理收入(代理)
 *      30200:用户一码付渠道收入(平台)
 *
 *      外卖
 *      30300:外卖系统结算到资金池（平台）
 *      30301:外卖系统结算到用户余额（用户）
 *
 *      五味到家
 *      30400~30499:结算到用户余额（用户）
 *      30500~30599:用户转账到用户余额（用户）
 *
 * )
 *  40000:转出(
 *      40001:购买充值卡,
 *      40002:购买购物卡,
 *      40003:货款冻结
 *      40004:直接转账
 *      40005:用户退款
 *      40006:购买台卡
 *      40020:用户使用卡(平台)
 *      40021:用户提现(平台)
 *      40022:冻结货款结算给买方(平台)
 *      40023:冻结货款结算给卖方(平台)
 *      40024:外卖资金池结算到个人账户（平台）
 *      40025:五味到家系统划拨资金到个人账户（平台）
 *
 *      五味到家
 *      40100~40199
 * )
 *  50000:订单支付
 *
 *  60000:订单收入
 *
 *  70000:多笔订单支付
 *
 *  80000:收银机收款
 *  85000:收银机退款
 *
 * edit_status(修改状态){
 *  false:默认,记录不可修改
 *  true:待结算
 * }
 *
 * trade_status(记录总状态){
 *  0：默认 待支付
 *  1：交易成功
 *  2：交易拒绝
 *  3：交易取消
 *  4：已提交平台
 *  5：平台已受理
 *  6: 平台处理中
 *  7: 平台处理完成
 *  8: 交易失败
 * }
 */


class Trade extends Model
{
    //交易类型

    //平台默认交易ID
    const PLATFORM_CARD      = 1;  //平台卡用户 ID
    const PLATFORM_MONEY_ALI = 2;  //平台支付宝账户 ID
    const PLATFORM_MONEY_WX  = 3;  //平台微信账户 ID
    const PLATFORM_FROZEN    = 4;  //平台货款冻结账户 ID
    const PLATFORM_ACTIVE    = 5;  //平台激活码账户 ID
    const PLATFORM_FY        = 6;  //平台富有账户ID
    const PLATFORM_CH        = 7;  //平台传化提现账户ID
    const PLATFORM_CASH      = 8;  //平台余额，用于收取手续费
    const PLATFORM_OC        = 9;  //一码付账户
    const PLATFORM_TAKEOUT   = 10; //外卖结算账户

    //结算
    const EDIT_YES = 1; //可以修改
    const EDIT_NO = 0; //不可修改

    const TRADE_CREATE = 0;
    const TRADE_SUCCESS = 1;

    //交易角色
    const ROLE_PLATFORM = 0; //平台，默认
    const ROLE_USER     = 1; //用户
    const ROLE_MERCHANT = 2; //商家
    const ROLE_STORAGE  = 3; //代理商
    const ROLE_AGENCY  = 4; //代理商
}
