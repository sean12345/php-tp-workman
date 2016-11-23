## <h3 id="0">[Ant-Nest 蚁巢服务平台](/)</h3>
## 
---

######
> |SMS短信服务模块接口文档|
|:-----  |
|[1.1 短信通知服务](#1)|
|[1.2 短信验证码服务](#2)|
|[1.3 短信验证码校验服务](#3)|
--------------------------------------------------

### <h3 id="1">1.1 [短信通知服务](#0)</h3>
> 主要提供业务短信通知服务

###### 接口访问地址
> [http://domain/sms/api/notify](/sms/api/notify)

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|示例|
|:-----  |:-------|:-----|-----|-----  |
|number   |ture    |int    |短信编号  |       |
|mobile    |ture    |int    |短信接收人电话  |  |
|content_params    |true    |json   |短信模板参数|{"number":"3","mobile":"15055558888","content_params":{"per":"80"}}   |


###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |json |数据                         |

###### 接口访问DEMO
```
<?php
/*准备入参*/
$params = array(
    'number' => '1',
    'mobile' => '15029911001',
    'content_params' => array('username' => '', 'password' => '')
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
地址：[http://local.antnest.clcw.com.cn/sms/api/notify]
``` javascript
{
    "code": "170010",
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
|16    |array('mob' => '', 'pwd' => '')   |审核成功创建用户发送给用户账户密码|
|17    |array()   |审核成功发送给用户提醒信息|
|18    |array('realname' => '', 'username' => '', 'password' => '')   |4s账号添加通知|
|19    |array('realname' => '', 'username' => '', 'password' => '')   |集团账号添加通知|
|20    |array('order_number' => '', 'check_limit_time' => '', 'check_addr' => '')   |车商验车通知|
|22    |array('pwd' => '')   |运营平台新添加来拍车账号时短信通知|
--------------------------------------------------

### <h3 id="2">1.2 [短信验证码服务](#0)</h3>
> 主要提供短信验证码服务

###### 接口访问地址
> [http://domain/sms/api/codesend](/sms/api/codesend)

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|示例|
| :----- | :------- | :----- | -----   | ----- |
| number | ture     | int    | 短信编号    |      |
| mobile | ture     | int    | 短信接收人电话 | {"number":"12","mobile":"15055558888"}      |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |json |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$params = array(
    'number' => '1',
    'mobile' => '15029911001',
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
地址：[http://local.antnest.clcw.com.cn/sms/api/codesend]
``` javascript
{
    "code": "000000",
    "msg": "ok",
    "data": {
        "ver_code": "292006"
    }
}
```

###### 请根据应用场景选择正确的短信类型。
> |number|备注                              |
|:-----:  |:-------------------------------------------   |
|12     |手机验证码|
|13    |注册验证码|
|14    |找回密码验证码|
|15    |车来车往验证码|
|21    |运营平台登录验证码|
--------------------------------------------------

### <h3 id="3">1.3 [短信验证码校验服务](#0)</h3>
校验短信验证码是否有效

###### 接口访问地址
> [http://domain/sms/api/verify]

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数[^templatelist]
> |参数|必选|类型|说明|示例|
|:-----  |:-------|:-----|-----|----- |
|number   |ture    |int    |短信编号    |  |
|mobile    |ture    |int    |短信接收人电话 |  |
|ver_code    |ture    |int    |短信验证码    |{"number":"12","mobile":"15055558888","ver_code":"111222"}  |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误                    |
|msg |string |错误描述                         |
|data |json |数据                         |

###### 请根据应用场景选择正确的短信类型。
> |number|备注|
|:-----  |:-----  |:------   |
|12     |手机验证码|
|13    |注册验证码|
|14    |找回密码验证码|
|15    |车来车往验证码|
|21    |运营平台登录验证码|

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$params = array(
    'number' => '12',
    'mobile' => '15029911001',
    'ver_code' => '5555'
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
地址：[http://local.antnest.clcw.com.cn/sms/api/verify]
``` javascript
{
    "code": "170010",
    "msg": "入参模板ID(1001)无效",
    "data": array(),
}
```