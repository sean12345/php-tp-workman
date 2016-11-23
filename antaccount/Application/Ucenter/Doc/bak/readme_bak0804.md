## <h3 id="0">Ant-Nest 蚁巢服务平台</h3>
### 用户中心
---------

###### 
> |账号服务模块接口文档|
|:-----  |
|[注册新用户账号](#1)|
|[激活用户账号](#2)|
|[禁用账号](#3)|
|[销毁用户账号](#4)|
|[用户登录](#5)|
|[用户退出](#6)|
|[找回密码](#7)|
|[修改密码](#8)|
|[修改账号资料](#9)|
|[获取账号信息](#10)|


>
官网 http://www.clcw.com.cn/MyCenter/my_car.html
员工用户 http://admin.clcw.com.cn/Fours/index
4S店用户 http://spm.clcw.com.cn/Emp/login
车商 http://www.lpaiche.com/



---------

### <h3 id="1">1. [注册新用户账号](#0)</h3>
> 注册新用户账号，提供用户名、用户类型、手机号、密码等信息，可对新注册账号激活、禁用或销毁

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
|account_name   |ture    |int    |账号名称                          |
|mobile   |ture    |string    |手机号码                          |
|account_type    |ture    |int    |账号类型 (1:web站, 2:车商 3:4S店, 4:员工)                         |
|account_avatar   |false    |string    |个人头像                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/add";
$params = {"account_name":"sean_21","account_type":"1","pwd":"123456","mobile":"15029911706","account_avatar":""};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="2">2. [激活用户账号](#0)</h3>
> 激活新注册用户账号或已禁用账号

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
|account_id   |ture    |int    |账号ID                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/active";
$params = {"account_id":"21"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="3">3. [禁用用户账号](#0)</h3>
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
|account_id   |ture    |int    |账号ID                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       |
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/inactive";
$params = {"account_id":"21"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="4">4. [销毁用户账号](#0)</h3>
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
|account_id   |ture    |int    |账号ID                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       |  
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/cancel";
$params = {"account_id":"21"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="5">5. [用户登录](#0)</h3>
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
|account_name   |ture    |string    |账号名称                          |
|pwd   |ture    |string    |账号密码                          |
|account_type   |ture    |int    |账号类型 (1:web站, 2:车商 3:4S店, 4:员工)                         |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/login";
$params = {"account_name":"sean","pwd":"123456"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="6">6. [用户退出](#0)</h3>
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
|account_id   |ture    |int    |账号ID                          |
|account_type   |ture    |int    |账号类型 (1:web站, 2:车商 3:4S店, 4:员工)                         |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/logout";
$params = {"account_id":"1001","account_type":"1"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="7">7. [找回密码](#0)</h3>
> 找回账号密码 (导向密码修改接口)

---------

### <h3 id="8">8. [修改账号密码](#0)</h3>
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
|account_id   |ture    |int    |账号ID                          |
|pwd_old   |ture    |string    |原始密码                          |
|pwd_new   |ture    |string    |新密码                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/changepwd";
$params = {"account_id":"1001","pwd_old":"111111","pwd_new":"666666"};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="9">9. [修改账号资料](#0)</h3>
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
|account_id   |ture    |int    |账号ID                          |
|account_avatar   |false    |string    |账号头像                          |
|mobile   |false    |string    |账号手机号                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码('000000':正确)       | 
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```php
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/changeinfo";
$params = {"account_id":"1001","account_avatar":"","mobile":""};
$isPost = 1;
Request::juhecurl($apiUrl, $params, $isPost);
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

### <h3 id="10">10. [获取账号信息](#0)</h3>
> 根据账号ID获取账号信息

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
|account_id   |ture    |int    |账号ID                          |

###### 返回字段
> |返回字段|字段类型|说明                              |
|:-----   |:------|:-----------------------------   |
|error_code  |string |错误码   '000000':正确 >0:错误        
|msg |string |错误描述                         |
|data |array |数据                         |

###### 接口访问DEMO
```
<?php
/*准备入参*/
$apiUrl = "http://domain/ucenter/accounts/info";
$params = {'account_id':'***'};
$params = json_encode($params);
$isPost = 0;
Request::juhecurl($apiUrl, $params, $isPost);
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