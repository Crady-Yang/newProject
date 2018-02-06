<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login 登录名
 * @property string $password 密码
 * @property string|null $name 昵称
 * @property string|null $email 邮箱
 * @property string|null $phone 手机号码
 * @property int $money 可用金额
 * @property int $processing 在途金额(充值+提现)
 * @property int $frozen_pay 已冻结
 * @property int $frozen_rec 将收入金额
 * @property string|null $avatar 用户头像
 * @property int $role_id 用户角色ID
 * @property string|null $pay_pass 支付密码
 * @property int $main_id 超级账户 ID
 * @property string|null $auth_code 双重验证密钥
 * @property int|null $invite_user_id 推荐人 ID
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFrozenPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFrozenRec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereInviteUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePayPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProcessing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
 *
 */
	class Trade extends \Eloquent {}
}

