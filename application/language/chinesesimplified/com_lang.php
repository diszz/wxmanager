<?php

/******************************
 * 站点配置
 *******************************/

$lang['request_ip_forbidden'] = "您所在的IP访问异常, 已被列入黑名单, 请稍后再试";
$lang['forbidden_words'] = "";


$lang['request_noip'] = "请通过浏览器方式访问";
$lang['add_word_form_valid_name'] = "旅行者, 请填写词条名.";
$lang['add_word_name_exist'] = "这个词条已经存在";
$lang['add_word_create_succ'] = "这个词条添加成功, 与您的ID永远绑定到了一起";
$lang['activity_name_forbidden_word'] = "警告, 该词条包含敏感词汇!!";
$lang['activity_notexist'] = "这个活动不存在";
$lang['activity_isjoin'] = "您已参加这个活动";
$lang['activity_join_succ'] = "您成功参加了这个活动";



//site 
$lang['site_notexist'] = '站点不存在';
$lang['site_notserver'] = '站点不是服务号';
$lang['site_notverify'] = '站点没有认证';

$lang['form_edit_succ'] = '编辑成功';
$lang['form_add_succ'] = '添加成功';
$lang['form_del_succ'] = '删除成功';
$lang['operation_succ'] = '操作成功';
$lang['cmd_running_succ'] = '已加入后台运行模式';


$lang['user_notexist'] = '用户不存在';
$lang['user_nologin'] = '您没有登录';
$lang['user_noauth'] = '您没有权限';

//公共
$lang['request_error'] = '请求错误';
$lang['request_exception'] = '请求异常';
$lang['system_exception'] = '系统异常';
$lang['error_pagenotfound'] = '您访问的页面不存在';
$lang['error_pageforbidden'] = '您访问的页面暂未开放';
$lang['params_error'] = '参数错误';

$lang['form_edit_succ'] = '编辑成功';
$lang['form_edit_repeat'] = '此次编辑无改动';
$lang['form_add_succ'] = '添加成功';
$lang['form_del_succ'] = '删除成功';
$lang['operation_succ'] = '操作成功';
$lang['cmd_running_succ'] = '已加入后台运行模式';


//---www--------------------------------------------

//微信号
$lang['weixin_notexist'] = '对不起,该微信号不存在.';
$lang['weixin_setting_error'] = '对不起,该微信号无法使用.';
$lang['weixin_auth_err'] = '对不起,认证错误.';
$lang['weixin_unauthorized'] = '微信公众号未认证, 无法操作.';
$lang['oauth_error'] = '授权失败，请返回并重新授权';
$lang['oauth_type_error'] = '授权方式错误，请在微信服务号窗口点击菜单或发送"社区"';
$lang['oauth_site_error'] = '站点错误';
$lang['oauth_getUser_error'] = '获取授权信息失败，请返回微信并重新授权';
$lang['oauth_domain_error'] = '您的访问受限，请检查后重试';

$lang['user_notexist'] = '该用户不存在';
$lang['user_merge_repeat'] = '账号合并已执行完毕';
$lang['user_merge_repeat1'] = '微信账号已被绑定';
$lang['bindAccount_token_err'] = '微信身份识别码错误，请检查是否复制完整。';
$lang['bindAccount_merge_err'] = '合并失败';
$lang['bindAccount_stop'] = 'MT之家微信绑定维护中暂时停用，谢谢支持';

//红包
$lang['redpack_rest'] = '微信红包打烊了，打烊时间0：00-8：00，请8点后再来。感谢您的参与！';
$lang['redpack_limited'] = '您已连续输错5次，请明天再试，感谢您的参与！';
$lang['redpack_referrer_error'] = '请通过正确的方式参与活动';
$lang['redpack_params_error'] = '请通过正确的方式参与活动';
$lang['redpack_token_empty'] = '请重新授权';
$lang['redpack_token_error'] = '请通过正确的方式参与活动';
$lang['redpack_send_error'] = '系统繁忙，请稍后再试！';
$lang['redpack_get_none'] = '很遗憾，您没有抢到红包。感谢您的参与！';
$lang['redpack_get_succ'] = '恭喜您，成功抢到红包！';
$lang['redpack_get_repeat'] = '您已获取过红包，把机会让给其他小伙伴吧。感谢您的参与！';

$lang['redpack_exchange_weixin_seterr'] = '该微信公众号不支持红包功能';
//红包活动
$lang['redpack_exchange_not_exist'] = '您的兑换码已经失效，感谢您的参与！';
$lang['redpack_exchange_not_open'] = '您的兑换码已经失效，感谢您的参与！';
$lang['redpack_exchange_not_code'] = '您的兑换码已经失效，感谢您的参与！';
$lang['redpack_exchange_not_start'] = '您的兑换码已经失效，感谢您的参与！';
$lang['redpack_exchange_is_end'] = '您的兑换码已经失效，感谢您的参与！';
//红包兑换码
$lang['redpack_exchange_code_notexist'] = '您的红包兑换码输入错误或已经被兑换，感谢您的参与！';
$lang['redpack_exchange_code_isused'] = '您的红包兑换码已经被领取过了，感谢您的参与！注:如未出现微信红包，请咨询微信客服。';
$lang['redpack_exchange_user_repeat'] = '您已参加过本次活动，感谢您的参与！';
$lang['redpack_exchange_money_less'] = '红包码金额不合法，感谢您的参与！';


$lang['redpack_not_exist'] = '红包活动不存在！';
$lang['redpack_not_open'] = '红包活动未开启！';
$lang['redpack_not_start'] = '红包活动未开始！';
$lang['redpack_is_end'] = '红包活动已结束！';
$lang['redpack_not_code'] = '红包活动没有剩余红包码了！';
$lang['redpack_code_noremain'] = '红包活动没有剩余红包码了！';
$lang['redpack_user_grantedlist'] = '您已领取，请把机会让给其他玩家！';
$lang['redpack_user_limitedlist'] = '您已领取，请把机会让给其他玩家！';


$lang['redpack_NO_AUTH'] = '红包发放失败，您的请求可能存在风险，已被微信拦截！请检查自身帐号是否异常，使用常用的活跃的微信号可避免这种情况。';
$lang['redpack_TIME_LIMITED'] = '微信红包打烊了，打烊时间0：00-8：00，请8点后再来。感谢您的参与！';
$lang['redpack_SYSTEMERROR'] = '您的请求已受理，请稍后使用原单号查询发放结果！';
$lang['redpack_FREQ_LIMIT'] = '超过频率限制,请稍后再试！';
$lang['redpack_NOTENOUGH'] = '帐号余额不足，请到商户平台充值后再重试！';
$lang['redpack_PARAM_ERROR'] = '系统错误，请稍后重试！';

$lang['redpack_ip_empty'] = '您的请求不存在！';
$lang['redpack_ip_error'] = '您的请求不存在！';
$lang['redpack_params_error'] = 'appid 或 redpack_id 错误！';
$lang['redpack_sign_error'] = 'sign错误！';
//api/
$lang['redpack_not_exist'] = '红包活动不存在！';
$lang['redpack_not_open'] = '红包活动未开启！';
$lang['redpack_not_start'] = '红包活动未开始！';
$lang['redpack_is_end'] = '红包活动已结束！';
$lang['redpack_not_code'] = '红包码已经被领完了！';
$lang['redpack_code_noremain'] = '红包码已经被领完了！';
$lang['redpack_user_grantedlist'] = '您已领取，请把机会让给其他玩家！';
$lang['redpack_user_limitedlist'] = '您已领取，请把机会让给其他玩家！';

//资讯
$lang['article_noremain_cycle'] = '没有资讯了，再次点击将从头开始';
$lang['article_noremain_over'] = '没有资讯了，感谢您的关注！';
$lang['article_limited'] = '操作频繁，请稍后重试';
$lang['article_notexist'] = '文章不存在，感谢您的关注！';

//签到
$lang['signin_nosetting'] = '暂未开放，感谢您的关注！';
$lang['signin_notexist'] = '该签到不存在，感谢您的参与！';
$lang['signin_done'] = '您今天已签到，请明天再来！';
$lang['signin_over'] = '所有签到均已执行，感谢您的参与！';
$lang['signin_code_item_noremain'] = '签到成功，礼包码已经被领完了，请明天再来！';
$lang['signin_code_item_done'] = '您今天已签到，您的礼包码是%s，感谢您的参与！';

//发礼包
$lang['code_item_noremain'] = '礼包码已经被领完了，感谢您的参与！';
$lang['code_item_done'] = '您获得的礼包码是%s，感谢您的参与！';
$lang['code_get_repeat'] = '您已领取，感谢您的参与！';
$lang['code_notexist'] = '礼包活动不存在，感谢您的参与！';


//抽奖
$lang['lottery_nosetting'] = '暂未开放，感谢您的关注！';
$lang['lottery_notexist'] = '该抽奖不存在，感谢您的参与！';
$lang['lottery_done'] = '您今天已抽奖，请明天再来！';
$lang['lottery_notwin'] = '您未中奖，请再接再厉！';
$lang['lottery_code_item_noremain'] = '签到成功，礼包码已经被领完了，请明天再来！';
$lang['lottery_code_item_done'] = '您今天已签到，您的礼包码是%s，感谢您的参与！';


/* End of file date_lang.php */
/* Location: ./system/language/chinesesimplified/com_lang.php */