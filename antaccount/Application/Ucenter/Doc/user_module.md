## clcw用户中心设计
### 用户基础信息层设计
-----

1.目前用户类型: 车主、车商、员工、web站，用户类型可纵向扩展

2.用户基础信息层包含功能
```
> 用户注册

> 用户登录

> 用户找回密码

> 用户修改密码

> 用户设置头像

> 用户注销

```

3.数据存储结构

```
/*用户账号信息表*/
DROP TABLE IF EXISTS `uc_account`;
CREATE TABLE `uc_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名称',
  `pwd` varchar(80) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `account_type` tinyint(1) DEFAULT NULL COMMENT '用户类型(1:web站, 2:车商 3:4S店, 4:员工)',
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `status` tinyint(1) DEFAULT NULL COMMENT '账号状态(0:未激活, 1:已激活, 2:已禁用)',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name_mobile` (`account_name`,`mobile`),
  UNIQUE KEY `account_type_mobile` (`account_type`,`mobile`) 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号信息表';

/*用户账号操作日志表*/
DROP TABLE IF EXISTS `uc_account_log`;
CREATE TABLE `uc_account_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `status` tinyint(1) DEFAULT NULL COMMENT '账号状态(0:未激活, 1:已激活, 2:已禁用)',
  `remark` text COMMENT '操作内容',
  `op_account_id` char(60) NOT NULL DEFAULT '' COMMENT '操作人账号ID',
  `ip` char(30) NOT NULL DEFAULT '' COMMENT '操作人登录IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号操作日志表';

```
