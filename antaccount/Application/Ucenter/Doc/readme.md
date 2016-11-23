## <h3 id="0">[Ant-Nest 蚁巢服务平台](/)</h3>

### 用户中心
---------

###### 
> 用户活动接口文档|
|:-----  |
|[1.1 用户注册](#1)|
|[1.2 用户登录](#2)|
|[1.3 用户退出](#3)|
|[1.4 找回密码](#4)|
|[1.5 设置密码](#5)|
|[1.6 修改账号信息](#6)|
|[1.7 获取账号信息](#7)|
|[1.8 获取账号密码(临时接口)](#8)|
|[1.9 检查账号是否已存在](#9)|
|[1.10 批量获取账号信息](#10)|

> 用户操作接口文档|
|:-----  |
|[2.1 添加用户](#21)|
|[2.2 修改用户资料](#22)|
|[2.3 启用用户](#23)|
|[2.4 禁用用户](#24)|
|[2.5 销毁用户](#25)|
|[2.6 重置用户密码](#26)|
|[2.7 获取账号信息](#7)|
|[2.8 批量获取账号信息](#10)|

> 其它资料|
|:-----  |
|[3.1 Ucenter错误码](#31)|

---------

### <h3 id="1">1.1 [用户注册](#0)</h3>
> 注册新用户账号，提供用户名、用户类型、手机号、密码等信息

###### 接口访问地址
> **domain/ucenter/api/accounts/regist**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_name   |false    |int    |账号名称                          |
|mobile   |true    |string    |手机号码                          |
|email   |false    |string    |email                          |
|pwd   |true    |string    |密码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130101   |用户名称不能为空
|130102   |用户名格式错误
|130103   |用户名已使用
|130104   |手机号不能为空
|130105   |手机号格式错误
|130106   |手机号已使用
|130107   |邮箱不能为空
|130108   |邮箱格式错误
|130109   |邮箱已使用
|130110   |用户类型不能为空
|130111   |用户类型无效
|130112   |密码不能为空
|130113   |密码格式错误
|130115   |日志写入失败

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/regist";
$params = {"account_name":"sean_21","account_type":"1","pwd":"123456","mobile":"15029911706","email":""};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": 130007,
    "msg": "该账号已使用!",
    "data": []
}
```

---------

### <h3 id="2">1.2 [用户登录](#0)</h3>
> 账号登录

###### 接口访问地址
> **domain/ucenter/api/accounts/login**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|user_name   |false    |int    |用户名(账号名称、手机号码、email)                          |
|pwd   |true    |string    |密码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130201   |用户名不能为空
|130202   |用户不存在
|130203   |手机号不能为空
|130204   |手机号不存在
|130205   |邮箱不能为空
|130206   |邮箱不存在
|130207   |用户类型不能为空
|130208   |用户类型无效
|130209   |密码不能为空
|130210   |手机验证码输入错误
|130211   |用户名或密码错误


###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/login";
$params = {"account_name":"sean","pwd":"123456"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "code": "000000",
    "msg": "ok",
    "data": {
        "info": {
            "account_id": "3",
            "account_name": "sean_3",
            "mobile": "15029911702",
            "account_type": "1",
            "status": "0",
            "account_avatar": "a"
        }
    }
}
```

---------

### <h3 id="3">1.3 [用户退出](#0)</h3>
> 账号退出

###### 接口访问地址
> **domain/ucenter/api/accounts/logout**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130301   |用户ID无效
|130302   |用户已退出
|130303   |用户类型不能为空
|130304   |用户类型无效


###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/logout";
$params = {"account_id":"1001","account_type":"1"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "code": "000000",
    "msg": "ok",
    "data": []
}
```

---------

### <h3 id="4">1.4 [找回密码](#0)</h3>
> 找回密码

###### 接口访问地址
> **domain/ucenter/api/accounts/retrievepwd**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|pwd_new   |true    |string    |新密码                          |
|number   |true    |string    |验证码类型编号                          |
|mobile   |true    |string    |手机号码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130701   |手机号不能为空
|130702   |手机号不存在
|130704   |新密码不能为空
|130705   |新密码格式错误
|130706   |用户类型不能为空
|130707   |用户类型无效
|130708   |新密码与原始密码重复

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/retrievepwd";
$params = {"account_id":"1001","pwd_new":"111111","ver_code":"0000"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "code": 130022,
    "msg": "新密码与原始密码重复！",
    "data": []
}
```

---------

### <h3 id="5">1.5 [修改账号密码](#0)</h3>
> 修改账号密码

###### 接口访问地址
> **domain/ucenter/api/accounts/changepwd**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |
|pwd_old   |true    |string    |原始密码                          |
|pwd_new   |true    |string    |新密码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130801   |用户ID不能为空
|130802   |用户ID无效
|130803   |原始密码不能为空
|130804   |原始密码错误
|130805   |新密码不能为空
|130806   |新密码格式错误
|130807   |新密码与原始密码重复

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/changepwd";
$params = {"account_id":"1001","pwd_old":"111111","pwd_new":"666666"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "code": 130022,
    "msg": "新密码与原始密码重复！",
    "data": []
}
```

---------

### <h3 id="6">1.6 [修改账号信息](#0)</h3>
> 修改账号头像

###### 接口访问地址
> **domain/ucenter/api/accounts/changeinfo**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |
|account_name   |false    |int    |账号名称                          |
|mobile   |false    |string    |手机号码                          |
|email   |false    |string    |email                          |
|account_avatar   |false    |string    |用户账号头像                          |
|nick_name   |false    |string    |昵称                      |
|real_name   |false    |string    |真实姓名                      |
|account_avatar   |false    |string    |个人头像             |
|sex   |false    |init    |性别 (1男 2女)                      |
|province_id   |false    |int    |省份                      |
|city_id   |false    |int    |城市                      |
|address   |false    |string    |地址                      |
|u_idcard   |false    |string    |身份证                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |


###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130901    | 用户ID不能为空
|130902    | 用户ID无效
|130903    | 邮箱格式错误
|130904    | 用户头像上传失败
|130905    | 昵称格式错误
|130906    | 真实姓名格式错误
|130907    | 性别格式错误
|130908    | 省份格式错误
|130909    | 城市格式错误
|130910    | 地址格式错误
|130911    | 用户名称不能为空
|130912    | 用户名格式错误
|130913    | 用户名已使用
|130914    | 手机号不能为空
|130915    | 手机号格式错误
|130916    | 手机号已使用
|130917    | 邮箱不能为空
|130918    | 邮箱格式错误
|130919    | 邮箱已使用



###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/changeinfo";
$params = {"account_id":"1001","account_avatar":"","mobile":""};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "error_code": "170010",
    "msg": "******",
    "data": array(),
}
```

---------

### <h3 id="7">1.7 [获取账号信息](#0)</h3>
> 根据账号ID/账号名称获取账号信息

###### 接口访问地址
> **domain/ucenter/api/accounts/info**

###### HTTP请求方式
> GET

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |false    |int    |账号ID                          |
|account_name   |false    |int    |账号名称                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|131102   |用户ID无效

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/info";
$params = {"account_id":"***"};
$isPost = 0;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": "000000",
    "msg": "ok",
    "data": {
        "account_id": "112",
        "account_name": "sean_38",
        "mobile": "15029911737",
        "account_type": "1",
        "status": "0",
        "account_avatar": "a"
    }
}
```

---------

### <h3 id="8">1.8 [获取账号密码](#0)</h3>
> 按用户类型和用户名获取用户账号密码

###### 接口访问地址
> **domain/ucenter/api/accounts/getpwd**

###### HTTP请求方式
> GET

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|user_name   |true    |int    |用户名称(account_name 或 mobile)                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|131101   |用户ID不能为空
|131102   |用户ID无效

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/getpwd";
$params = {"account_id":"***"};
$isPost = 0;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": "000000",
    "msg": "ok",
    "data": {
        "account_id": "10604",
        "account_name": "wangji",
        "mobile": "15210067568",
        "pwd": "96e79218965eb72c92a549dd5a330112"
    }
}
```

---------

### <h3 id="9">1.9 [检查账号是否已存在](#0)</h3>
> 根据手机号或账号名检查账号是否已存在

###### 接口访问地址
> **domain/ucenter/api/accounts/check**

###### HTTP请求方式
> GET

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |false    |int    |账号ID                          |
|mobile   |false    |int    |手机号码                          |
|account_name   |false    |int    |账号名称                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|131102   |用户ID无效

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/check";
$params =  {"account_id":[10745,10784]};
$isPost = 0;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": "000000",
    "msg": "ok",
    "data": {
    }
}
```

### <h3 id="10">1.10 [批量获取账号信息](#0)</h3>
> 根据账号ID批量获取账号信息

###### 接口访问地址
> **domain/ucenter/api/accounts/batchinfo**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |false    |array    |多个账号ID    
|account_name   |false    |string    |账号名称 模糊搜索 account_id存在优先匹配account_id  |
|page   |false    |int    |当前第几页  |
|page_size   |false    |int    |空值或者0 则不分页返回所有数据  |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|131102   |用户ID无效

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/batchinfo";
$params = {"account_id":"***"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
  "code": "000000",
  "msg": "ok",
  "data": {
    "total": "74",      //总条数
    "page_now": "3",    //当前页
    "page_total": 37,   //总页数
    "list": {           //数据
      "10081": {
        "account_id": "10081",
        "account_name": "amigo123",
        "pwd": "e10adc3949ba59abbe56e057f20f883e",
        "status": "1",
        "email": "",
        "mobile": "asdfasdf",
        "nick_name": "",
        "real_name": "asdfasdf",
        "u_idcard": null,
        "account_avatar": "",
        "sex": "0",
        "province_id": "0",
        "city_id": "0",
        "address": "",
        "las_login_time": "2015-12-03 05:08:55",
        "createtime": "2015-12-03 05:08:55",
        "updatetime": "2015-12-03 05:08:55"
      },
      "10085": {
        "account_id": "10085",
        "account_name": "dealer_sam_test12",
        "pwd": "e10adc3949ba59abbe56e057f20f883e",
        "status": "1",
        "email": "",
        "mobile": "13111112222",
        "nick_name": "",
        "real_name": "dealer_sam_test12",
        "u_idcard": null,
        "account_avatar": "",
        "sex": "0",
        "province_id": "0",
        "city_id": "0",
        "address": "",
        "las_login_time": "2015-12-03 08:25:19",
        "createtime": "2015-12-03 08:25:19",
        "updatetime": "2015-12-03 08:25:19"
      }
    }
  }
}
```

---------


> 用户操作接口文档|
|:-----  |
|[2.1 添加用户](#21)|
|[2.2 修改用户资料](#22)|
|[2.3 启用用户](#23)|
|[2.4 禁用用户](#24)|
|[2.5 销毁用户](#25)|
|[2.6 重置用户密码](#26)|


---------

### <h3 id="21">2.1 [添加新用户账号](#0)</h3>
> 添加新用户账号，提供用户名、用户类型、手机号、密码等信息

###### 接口访问地址
> **domain/ucenter/api/accounts/add**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_name   |false    |int    |账号名称                          |
|pwd   |false    |int    |密码                          |
|mobile   |true    |string    |手机号码                          |
|email   |false    |string    |email                          |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135001   |用户名称不能为空
|135002   |用户名格式错误
|135003   |用户名已使用
|135004   |手机号不能为空
|135005   |手机号格式错误
|135006   |手机号已使用
|135007   |邮箱不能为空
|135008   |邮箱格式错误
|135009   |邮箱已使用
|135010   |用户类型不能为空
|135011   |用户类型格式错误
|135012   |用户类型已使用
|135013   |密码不能为空
|135014   |密码格式错误


###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/add";
$params = {"account_name":"sean_21","account_type":"1","pwd":"*******","mobile":"15029911706","email":"","manager_account_id":"0000","manager_ip":""};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": 130007,
    "msg": "该账号已使用!",
    "data": []
}
```

---------

### <h3 id="22">2.2 [修改用户账号资料](#0)</h3>

###### 接口访问地址
> **domain/ucenter/api/accounts/changeuserinfo**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |
|account_name   |false    |int    |账号名称                          |
|mobile   |false    |string    |手机号码                          |
|email   |false    |string    |email                          |
|account_avatar   |false    |string    |用户账号头像                          |
|nick_name   |false    |string    |昵称                      |
|real_name   |false    |string    |真实姓名                      |
|account_avatar   |false    |string    |个人头像             |
|sex   |false    |init    |性别 (1男 2女)                      |
|province_id   |false    |int    |省份                      |
|city_id   |false    |int    |城市                      |
|address   |false    |string    |地址                      |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |
|u_idcard   |false    |string    |身份证                          |


###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135101   |用户ID不能为空
|135102   |用户ID无效'
|135103   |邮箱格式错误
|135104   |邮箱已使用
|135105   |用户头像上传失败
|135106   |昵称格式错误
|135107   |真实姓名格式错误
|135108   |性别格式错误
|135109   |省份格式错误
|135110   |城市格式错误
|135111   |地址格式错误
|135112   |用户名称不能为空
|135113   |用户名已使用
|135114   |手机号不能为空
|135115   |'手机号格式错误
|135116   |手机号已使用
|135117   |邮箱不能为空
|135118   |邮箱格式错误
|135120   |性别格式错误
|135121   |身份证格式错误

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/changeuserinfo";
$params = {"account_id":"1001","account_avatar":"","mobile":""};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "error_code": "170010",
    "msg": "******",
    "data": array(),
}
```

---------

### <h3 id="23">2.3 [启用用户账号](#0)</h3>
> 启用新注册用户账号

###### 接口访问地址
> **domain/ucenter/api/accounts/active**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135201   |用户ID无效
|135202   |已启用

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/active";
$params = {"account_id":"21"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` 
{
    "code": 130010,
    "msg": "该账号已更新过!",
    "data": []
}
```

---------

### <h3 id="24">2.4 [禁用用户账号](#0)</h3>
> 禁用账号

###### 接口访问地址
> **domain/ucenter/api/accounts/inactive**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |ture    |int    |账号ID                          |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       |
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135301   |用户ID无效
|135302   |已禁用

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/inactive";
$params = {"account_id":"21"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "error_code": "170010",
    "msg": "******",
    "data": array(),
}
```

---------

### <h3 id="25">2.5 [销毁用户账号](#0)</h3>
> 账号销毁后将无法再次激活使用

###### 接口访问地址
> **domain/ucenter/api/accounts/cancel**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |ture    |int    |账号ID                          |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       |  
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135401   |用户ID无效
|135402   |已销毁

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/cancel";
$params = {"account_id":"21"};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
```
{
    "code": 130011,
    "msg": "该账号已销毁!",
    "data": []
}
```

---------

### <h3 id="26">2.6 [重置密码](#0)</h3>
> 重置密码

###### 接口访问地址
> **domain/ucenter/api/accounts/resetpwd**

###### HTTP请求方式
> POST

###### 入参类型
> JSON

###### 返回值类型
> JSON

###### 请求参数
> |参数|必选|类型|说明|
|:-----  |:-------|:-----|-----                               |
|account_type    |true    |int    |账号类型 (1:C端用户, 2:车商 3:4S店, 4:员工)                         |
|account_id   |true    |int    |账号ID                          |
|pwd_new   |true    |string    |新密码                          |
|manager_account_id   |true    |int    |操作人账号ID                          |
|manager_ip   |true    |string    |操作人IP                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|135501   |用户ID无效
|135502   |新密码不能为空
|135503   |新密码格式错误

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/resetpwd";
$params = {"account_id":"1001","pwd_new":"111111","manager_account_id":"","manager_ip":""};
$isPost = 1;
$requestObj = new Request($appKey, $secretKey);
$res = $requestObj->juhecurl($apiUrl, $params, $isPost);
```

###### 接口返回值示例
``` javascript
{
    "code": 130022,
    "msg": "新密码与原始密码重复！",
    "data": []
}
```

---------

### <h3 id="31">3.1 [Ucenter错误码](#0)</h3>
###### 错误码
> |错误码|说明                              |
|:----- |:-----------------------------   |
|130001   |操作人用户ID无效
|130002   |未检测到客户端IP
|130003   |入参验证失败
|130004   |提交处理失败
|130005   |账号未激活
|130006   |账号已禁用
|130007   |账号已销毁
|130008   |账号活动日志写入失败