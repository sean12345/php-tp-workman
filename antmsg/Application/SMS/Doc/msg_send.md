## Ant-Nest 蚁巢服务平台
### 短信发送服务
主要提供业务短信通知、短信验证码等服务

------

###### 接口访问地址
> [http://domain/sms/api/shortmsg](/sms/api/shortmsg)

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

------

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|number   |ture    |int    |短信编号                          |
|phone    |ture    |int    |短信接收人电话                          |
|content_params    |true    |array   |短信模板参数|


###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 3. 接口访问DEMO
```php
<?php
/*准备入参*/
$params = array(
    'number' => '1',
    'phone' => '15029911001',
    'content_params' => array('username' => '', 'password' => '')
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
post($url, $params);
```

###### 接口返回值示例
> 地址：[http://local.antnest.clcw.com.cn/sms/api/note]
``` javascript
{
    "error_code": "170010",
    "msg": "入参模板ID(1001)无效",
    "data": array(),
}
```

###### 请根据应用场景选择正确的短信类型。
> |number|content_params|备注                              |
|:-----:  |:-------------------------------------------   |
|1   |array('username' => '', 'password' => '')   |通知车主登陆用户中心查看拍卖结果|
|2   |array('address' => '', 'emp' => '', 'mob' => '', 'date' => '')   |通知车主到店交车验车|
|3   |array('per' => '')   |提醒车主查收首款|
|4   |array('per' => '')   |提醒车主查收尾款|
|5   |array()   |通知车主领取过户手续|
|6   |array('order_no' => '')   |通知车商拍卖成功|
|7   |array('order_no' => '', 'datetime' => '')   |通知车商及时到店验车付款|
|8   |array('order_no' => '', 'price' => '')   |通知车商由于违约已扣除违约金|
|9   |array('username' => '', 'password' => '')   |通知车商由于违约已扣除违约金|
|10    |array('add_price' => '', 'remain' => '')   |车商充值保证金后成功提醒|
|11    |array('scene_name' => '', 'carlist' => '')   |车商群发短信通知|
|12    |array('code' => '',)   |手机验证码|
|13    |array('code' => '')   |注册验证码|
|14    |array('code' => '')   |找回密码验证码|
|15    |array('code' => '')   |车来车往验证码|
|16    |array('mob' => '', 'pwd' => '')   |审核成功创建用户发送给用户账户密码|
|17    |array()   |审核成功发送给用户提醒信息|
|18    |array('realname' => '', 'username' => '', 'password' => '')   |4s账号添加通知|
|19    |array('realname' => '', 'username' => '', 'password' => '')   |集团账号添加通知|
|20    |array('order_number' => '', 'check_limit_time' => '', 'check_addr' => '')   |车商验车通知|

----------

