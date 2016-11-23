
/*用户账号信息表*/
DROP TABLE IF EXISTS `uc_account`;
CREATE TABLE `uc_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮箱',  
  `pwd` varchar(120) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `account_type` tinyint(1) DEFAULT NULL COMMENT '用户类型(1:C端用户, 2:车商 3:4S店, 4:员工)',
  `status` tinyint(1) DEFAULT 1 COMMENT '账号状态(0:未激活, 1:已启用, 2:已禁用, 3:已销毁)',
  `las_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name_mobile` (`account_name`,`mobile`),
  UNIQUE KEY `account_type_mobile` (`account_type`,`mobile`) 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号信息表';

/*用户账号资料信息表*/
DROP TABLE IF EXISTS `uc_account_profile`;
CREATE TABLE `uc_account_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT '用户ID',
  `nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',  
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',
  `province_id` int(10) NOT NULL COMMENT '省份',
  `city_id` int(10) NOT NULL COMMENT '城市',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号资料信息表';

/*用户账号活动日志表*/
DROP TABLE IF EXISTS `uc_account_action_log`;
CREATE TABLE `uc_account_action_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `action_source` int(10) DEFAULT 0 COMMENT '动作来源',
  `types` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:注册, 2:启用, 3:登录, 4:退出, 5:找回密码, 6:设置密码, 7:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `login_ip` char(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号活动日志表';

/*用户账号操作日志表*/
DROP TABLE IF EXISTS `uc_account_option_log`;
CREATE TABLE `uc_account_option_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `types` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:添加用户, 2:启用用户, 3:禁用用户, 4:销毁用户, 5:重置密码, 6:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `manager_account_id` char(60) NOT NULL DEFAULT '' COMMENT '操作人账号ID',
  `manager_ip` char(30) NOT NULL DEFAULT '' COMMENT '操作人IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户账号操作日志表';