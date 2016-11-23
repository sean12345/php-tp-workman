
create database ant_nest default charset utf8 collate utf8_general_ci;

/*任务服务信息表*/
DROP TABLE IF EXISTS `ant_session`;
CREATE TABLE `ant_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务服务信息表';

/*任务服务信息表*/
DROP TABLE IF EXISTS `ant_task_service`;
CREATE TABLE `ant_task_service` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) DEFAULT NULL COMMENT '任务分组ID',
  `pid` int(10) DEFAULT NULL COMMENT '进程号',
  `user_id` int(10) DEFAULT NULL COMMENT '创建人ID',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '任务标题',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '验车处理结果(0:待处理, 1:处理中, 2:暂停中, 3:处理成功 4:处理失败)',
  `processed` int(10) DEFAULT NULL DEFAULT 0 COMMENT '已完成任务量(%)',
  `task_url` varchar(200) NOT NULL DEFAULT '' COMMENT '任务启动地址',
  `desc` text COMMENT '任务描述',
  `remark` text COMMENT '备注',
  `starttime` datetime NOT NULL COMMENT '任务开始时间',
  `endtime` datetime NOT NULL COMMENT '任务结束时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`task_id`),
  UNIQUE INDEX `group_id_UNIQUE` (`group_id` ASC),
  UNIQUE INDEX `pid_UNIQUE` (`pid` ASC)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='任务服务信息表';


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

/*SMS短信发送日志信息表*/
DROP TABLE IF EXISTS `ant_msg_send_log`;
CREATE TABLE `ant_msg_send_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '电话',
  `gateway` varchar(60) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `msg_type` smallint(4) DEFAULT NULL COMMENT '短信类型编号',
  `msg_var` varchar(200) NOT NULL DEFAULT '' COMMENT '短信模板参数',
  `response_code` tinyint(1) DEFAULT NULL COMMENT '短信发送结果(0:成功, 1:失败)',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='SMS短信发送日志信息表';


/*优信拍数据抓取信息表*/
DROP TABLE IF EXISTS `ant_msg_send_log`;
CREATE TABLE `ant_msg_send_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '电话',
  `gateway` varchar(60) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `msg_type` smallint(4) DEFAULT NULL COMMENT '短信类型编号',
  `msg_var` varchar(200) NOT NULL DEFAULT '' COMMENT '短信模板参数',
  `response_code` tinyint(1) DEFAULT NULL COMMENT '短信发送结果(0:成功, 1:失败)',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='SMS短信发送日志信息表';





