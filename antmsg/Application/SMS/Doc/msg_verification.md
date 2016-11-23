## Ant-Nest 蚁巢服务平台
### 短信验证码校验服务
校验短信验证码是否有效

------

###### 接口访问地址
> [http://domain/sms/api/verification]

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

------

###### 请求参数[^templatelist]
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|phone    |ture    |int    |短信接收人电话                          |
|ver_code    |ture    |int    |短信验证码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误                    |
|msg |string |错误描述                         |
|data |array |数据                         |

###### 3. 接口访问DEMO
```php
<?php
/*准备入参*/
$params = array(
    'phone' => '15029911001',
    'ver_code' => '5555'
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
----------

