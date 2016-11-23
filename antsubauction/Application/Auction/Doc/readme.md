## <h3 id="0">[Ant-Nest 蚁巢服务平台](/)</h3>
## 
---

######
> |来拍车拍单订阅模块接口文档|
|:-----  |
|[1.1 jpush消息推送](#1)|
|[1.2 添加订阅拍单源](#2)|
--------------------------------------------------

### <h3 id="1">1.1 [jpush消息推送](#0)</h3>
> 主要提供基于jpush的消息通知服务

###### 接口访问地址
> http://domain/auctionsub/api/notice/send

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|示例|
|:-----  |:-------|:-----|-----|-----  |
|mobile   |true    |int    |消息接收人手机号  |       |
|jpush_id   |true    |int    |jqushID  |       |
|jpush_type   |true    |int    |打开类型(例如 0:打开APP, 1:打开活动, 2:打开拍单详情, 3:打开维修保养详情, 4:打开维修保养查询历史列表)  |       |
|jpush_data   |true    |array    |消息解析参数集合  |       |
|jpush_content   |true    |string    |消息内容  |       |


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
    'mobile' => '18613890000',
    'jpush_id' => '18071adc030ebd04b96',
    'jpush_type' => '2',
    'jpush_data' => array('order_id'=>'P1611070003'),
    'jpush_content' => 'xxxxxxx'
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
地址：[http://local.antnest.clcw.com.cn/auctionsub/api/notice/send]
``` javascript
{
    "code": "170010",
    "msg": "",
    "data": array(),
}
```

-----

### <h3 id="2">1.2 [添加订阅拍单源](#0)</h3>
> 主要提供业务短信通知服务

###### 接口访问地址
> http://domain/auctionsub/api/order/add

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|示例|
|:-----  |:-------|:-----|-----|-----  |
|account_id   |true    |int    |添加人账号ID  |       |
|order_id   |true    |int    |order_id  |       |
|sub_type   |true    |int    |订阅类型(1:车商订阅)  |       |


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
    'account_id' => '101',
    'order_id' => '1001',
    'sub_type' => '1'
);
$params = json_encode($params);
/*post方式请求接口，并以JSON格式传递入参*/
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
地址：[http://local.antnest.clcw.com.cn/auctionsub/api/order/add]
``` javascript
{
    "code": "170010",
    "msg": "",
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
--------------------------------------------------
