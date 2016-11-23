<?php
/**
 * 第三方短信网关配置
 *
 * 备注： 在客户端没有指定网关的情况下，系统默认调用排在第一位的网关
 */
return array(
    'SMS_API' => array(
            'YUNPIAN' => array(
                    /*第三方短信接口地址*/
                    'API_URL'    => "http://yunpian.com/v1/sms/tpl_send.json",
                    /*第三方短信接口访问秘钥*/
                    'API_KEY'    => "39d0d4be2ea6df430503158d61488bae",
                    /*短信模板*/
                    'TPL' => array(
                            '1' => array('tpl_id' => '1124141', 'var_list' => array('username' => '', 'password' => '')) //通知车主登陆用户中心查看拍卖结果
                            , '2' => array('tpl_id' => '1124143', 'var_list' => array('address' => '', 'emp' => '', 'mob' => '', 'date' => '')) //通知车主到店交车验车
                            , '3' => array('tpl_id' => '1124155', 'var_list' => array('per' => '')) //提醒车主查收首款
                            , '4' => array('tpl_id' => '1124159', 'var_list' => array('per' => '')) //提醒车主查收尾款
                            , '5' => array('tpl_id' => '1124163', 'var_list' => array()) //通知车主领取过户手续
                            , '6' => array('tpl_id' => '1124165', 'var_list' => array('order_no' => '')) //通知车商拍卖成功
                            , '7' => array('tpl_id' => '1124167', 'var_list' => array('order_no' => '', 'datetime' => '')) //通知车商及时到店验车付款
                            , '8' => array('tpl_id' => '1124169', 'var_list' => array('order_no' => '', 'price' => '')) //通知车商由于违约已扣除违约金
                            , '9' => array('tpl_id' => '1124171', 'var_list' => array('username' => '', 'password' => '')) //通知车商由于违约已扣除违约金
                            , '10' => array('tpl_id' => '1124175', 'var_list' => array('add_price' => '', 'remain' => '')) //车商充值保证金后成功提醒
                            , '11' => array('tpl_id' => '1178591', 'var_list' => array('scene_name' => '', 'carlist' => '')) //车商群发短信通知
                            , '12' => array('tpl_id' => '1281455', 'var_list' => array('code' => '',)) // 手机验证码
                            , '13' => array('tpl_id' => '1281447', 'var_list' => array('code' => '')) //注册验证码
                            , '14' => array('tpl_id' => '1281451', 'var_list' => array('code' => '')) //找回密码验证码
                            , '15' => array('tpl_id' => '1281455', 'var_list' => array('code' => '')) //车来车往验证码
                            , '16' => array('tpl_id' => '1330857', 'var_list' => array('mob' => '', 'pwd' => '')) //审核成功创建用户发送给用户账户密码
                            , '17' => array('tpl_id' => '1330859', 'var_list' => array()) //审核成功发送给用户提醒信息
                            , '18' => array('tpl_id' => '1350031', 'var_list' => array('realname' => '', 'username' => '', 'password' => '')) //4s账号添加通知
                            , '19' => array('tpl_id' => '1350033', 'var_list' => array('realname' => '', 'username' => '', 'password' => '')) //集团账号添加通知
                            , '20' => array('tpl_id' => '1427585', 'var_list' => array('order_number' => '', 'check_limit_time' => '', 'check_addr' => '')) //车商验车通知
                            , '21' => array('tpl_id' => '1520936', 'var_list' => array('code' => '')) //运营平台登录验证码
                            , '22' => array('tpl_id' => '1598814', 'var_list' => array('pwd' => '')) //运营平台新添加来拍车账号时短信通知
                            , '50' => array('tpl_id' => '1540652', 'var_list' => array('system_name' => '', 'level' => '', 'content' => '')) //服务器报警
                    ),
            ),
            'CHINAMSG' => array(
                    /*第三方短信接口地址*/
                    'API_URL'    => "http://120.55.242.177/OpenPlatform/OpenApi",
                    /*第三方短信接口访问秘钥*/
                    // 'API_KEY'    => "D6CC2239A35BCA75EA7132687A36255B",
                    'API_KEY'    => "17663070E70EC7CD91BA07DEDBB9C0E1",
                    /*公司账号*/
                    // 'API_AC'    => "1001@800111980001",
                    'API_AC'    => "1001@800111980003",
                    /*短信通道*/
                    // 'API_CGID'    => "6",
                    'API_CGID'    => "152",
                    /*短信通道*/
                    'API_CSID'    => "",
                    /*短信模板*/
                    'TPL' => array(
                             '1' => array('tpl_id' => '1124141', 'var_list' => array('username' => '', 'password' => '')) //通知车主登陆用户中心查看拍卖结果
                            , '2' => array('tpl_id' => '1124143', 'var_list' => array('address' => '', 'emp' => '', 'mob' => '', 'date' => '')) //通知车主到店交车验车
                            , '3' => array('tpl_id' => '1124155', 'var_list' => array('per' => '')) //提醒车主查收首款
                            , '4' => array('tpl_id' => '1124159', 'var_list' => array('per' => '')) //提醒车主查收尾款
                            , '5' => array('tpl_id' => '1124163', 'var_list' => array()) //通知车主领取过户手续
                            , '6' => array('tpl_id' => '1124165', 'var_list' => array('order_no' => '')) //通知车商拍卖成功
                            , '7' => array('tpl_id' => '1124167', 'var_list' => array('order_no' => '', 'datetime' => '')) //通知车商及时到店验车付款
                            , '8' => array('tpl_id' => '1124169', 'var_list' => array('order_no' => '', 'price' => '')) //通知车商由于违约已扣除违约金
                            , '9' => array('tpl_id' => '1124171', 'var_list' => array('username' => '', 'password' => '')) //通知车商由于违约已扣除违约金
                            , '10' => array('tpl_id' => '1124175', 'var_list' => array('add_price' => '', 'remain' => '')) //车商充值保证金后成功提醒
                            , '11' => array('tpl_id' => '1178591', 'var_list' => array('scene_name' => '', 'carlist' => '')) //车商群发短信通知
                            , '12' => array('tpl_id' => '1281455', 'var_list' => array('code' => '',)) // 手机验证码
                            , '13' => array('tpl_id' => '1281447', 'var_list' => array('code' => '')) //注册验证码
                            , '14' => array('tpl_id' => '1281451', 'var_list' => array('code' => '')) //找回密码验证码
                            , '15' => array('tpl_id' => '1281455', 'var_list' => array('code' => '')) //车来车往验证码
                            , '16' => array('tpl_id' => '1330857', 'var_list' => array('mob' => '', 'pwd' => '')) //审核成功创建用户发送给用户账户密码
                            , '17' => array('tpl_id' => '1330859', 'var_list' => array()) //审核成功发送给用户提醒信息
                            , '18' => array('tpl_id' => '1350031', 'var_list' => array('realname' => '', 'username' => '', 'password' => '')) //4s账号添加通知
                            , '19' => array('tpl_id' => '1350033', 'var_list' => array('realname' => '', 'username' => '', 'password' => '')) //集团账号添加通知
                            , '20' => array('tpl_id' => '1427585', 'var_list' => array('order_number' => '', 'check_limit_time' => '', 'check_addr' => '')) //车商验车通知
                            , '21' => array('tpl_id' => '1520936', 'var_list' => array('code' => '')) //运营平台登录验证码
                            , '22' => array('tpl_id' => '1598814', 'var_list' => array('pwd' => '')) //运营平台新添加来拍车账号时短信通知
                            , '50' => array('tpl_id' => '1540652', 'var_list' => array('system_name' => '', 'level' => '', 'content' => '')) //服务器报警
                    ),
            ),
            'COMMON' => array(
                    'TPL' => array(
                                         '1124171' => '【来拍车】尊敬的客户，恭喜您已成功开通“来拍车”拍卖账户，账户名：#username#密码：#password#'
                                        ,'1124155' => '【来拍车】尊敬的用户，您出售爱车的首付款（全车款的#per#）已经转到您提供的相应账户，请您注意查收。咨询电话400-6688-365'
                                        ,'1124159' => '【来拍车】尊敬的用户，您出售爱车的尾款（全车款的#per#）已经转到您提供的相应账户，请您注意查收。咨询电话400-6688-365'
                                        ,'1124163' => '【来拍车】尊敬的用户，您的爱车已过户成功，请尽快来店里领取您的过户手续。咨询电话400-6688-365'
                                        ,'1124165' => '【来拍车】尊敬的客户，恭喜您拍单编号：#order_no#拍卖成功，我们的客服人员正在给车主进行确认，敬请等待结果。咨询电话400-6688-365'
                                        ,'1124167' => '【来拍车】尊敬的客户，恭喜您拍单编号：#order_no#确认成功，请于#datetime#前到店验车付款，。咨询电话400-6688-365'
                                        ,'1124169' => '【来拍车】尊敬的客户，拍单编号：#order_no# ，已扣除违约金#price#。如有异议请致电仲裁部。咨询电话400-6688-365'
                                        ,'1124141' => '【车来车往】尊敬的用户，您的爱车已拍卖成功，请及时登录个人中心（www.clcw.com.cn）确认，用户名：#username#，密码：#password#。咨询电话400-6688-365'
                                        ,'1124143' => '【车来车往】尊敬的用户，请您于#date#到店交付，地址：#address#。交付顾问：#emp# #mob#.咨询电话400-6688-365'
                                        ,'1427585' => '【来拍车】尊敬的客户，恭喜您拍单#order_number#确认成交，请于#check_limit_time#前到#check_addr#验车。咨询电话400-6688-365'
                                        ,'1350031' => '【车来车往】#realname#您好，您在车来车往的4S店账号已开通，用户名#username#,密码#password#，登陆地址：spm.clcw.com.cn'
                                        ,'1350033' => '【车来车往】#realname#您好，您在车来车往的集团账号已开通，用户名#username#,密码#password#，登陆地址：spm.clcw.com.cn'
                                        ,'1281451' => '【车来车往】验证码：#code#。您正在使用该手机号找回密码，30分钟内有效。如非本人操作，请忽略本短信。'
                                        ,'1281447' => '【车来车往】验证码：#code#。您正在使用该手机号进行注册，30分钟内有效。如非本人操作，请忽略本短信。'
                                        ,'1330857' => '【车来车往】尊敬的用户，请登录个人中心（www.clcw.com.cn）查看爱车检测报告，用户名：#mob#，密码：#pwd#。咨询电话400-6688-365'
                                        ,'1330859' => '【车来车往】尊敬的用户，您爱车的检测报告已生成，请登录个人中心（www.clcw.com.cn）查看。咨询电话400-6688-365'
                                        ,'1281455' => '【车来车往】尊敬的用户您的手机验证码是#code#        '
                                        ,'1178591' => '【来拍车】尊敬的会员： 您关注的#carlist#等车型,将于#scene_name#的时间开拍，敬请关注！'
                                        ,'1124175' => '【来拍车】尊敬的客户：您的保证金已充值成功，充值金额为#add_price#元，余额为#remain#元，请登录您的账户中心查看，网址：http://www.lpaiche.com。咨询电话400-6688-365'
                                        ,'1520936' => '【车来车往】验证码:#code#,您正在登录运营平台，平台数据内部保密，且勿泄露！'
                                        ,'1598814' => '【来拍车】您已经注册成为初级买家，密码为#pwd#。您可以通过手机号和密码登录，请及时修改密码。网址：http://www.lpaiche.com。'
                                        //服务器报警
                                        ,'1540652' => '系统:#system_name#,报警级别:#level#, 描述:#content#'
                                        ),
                    'VAR_LIST' => array(
                                              '1' => array('username' => '', 'password' => '') //通知车主登陆用户中心查看拍卖结果
                                              ,'2' => array('address' => '', 'emp' => '', 'mob' => '', 'date' => '') //通知车主到店交车验车
                                              ,'3' => array('per' => '') //提醒车主查收首款
                                              ,'4' => array('per' => '') //提醒车主查收尾款
                                              ,'5' => array() //通知车主领取过户手续
                                              ,'6' => array('order_no' => '') //通知车商拍卖成功
                                              ,'7' => array('order_no' => '', 'datetime' => '') //通知车商及时到店验车付款
                                              ,'8' => array('order_no' => '', 'price' => '') //通知车商由于违约已扣除违约金
                                              ,'9' => array('username' => '', 'password' => '') //通知车商由于违约已扣除违约金
                                              ,'10' => array('add_price' => '', 'remain' => '') //车商充值保证金后成功提醒
                                              ,'11' => array('scene_name' => '', 'carlist' => '') //车商群发短信通知
                                              ,'12' => array('code' => '',) // 手机验证码
                                              ,'13' => array('code' => '') //注册验证码
                                              ,'14' => array('code' => '') //找回密码验证码
                                              ,'15' => array('code' => '') //车来车往验证码
                                              ,'16' => array('mob' => '', 'pwd' => '') //审核成功创建用户发送给用户账户密码
                                              ,'17' => array() //审核成功发送给用户提醒信息
                                              ,'18' => array('realname' => '', 'username' => '', 'password' => '') //4s账号添加通知
                                              ,'19' => array('realname' => '', 'username' => '', 'password' => '') //集团账号添加通知
                                              ,'20' => array('order_number' => '', 'check_limit_time' => '', 'check_addr' => '') //车商验车通知
                                              ,'21' => array('code' => '') //运营平台登录验证码
                                              ,'22' => array('pwd' => '') //运营平台新添加来拍车账号时短信通知
                                              ,'50' => array('system_name' => '', 'level' => '', 'content' => '') //服务器报警
                                              ),
            ),
      
    ),
);
