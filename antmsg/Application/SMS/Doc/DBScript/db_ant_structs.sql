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
  `request_time` datetime NOT NULL COMMENT '请求时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='SMS短信发送日志信息表';

/*SMS短信网关管理表*/
DROP TABLE IF EXISTS `ant_msg_gateway`;
CREATE TABLE `ant_msg_gateway` (
  `gateway_id` int(11) NOT NULL AUTO_INCREMENT,
  `gateway_name` varchar(60) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `status` tinyint(1) DEFAULT 1 COMMENT '短信网关状态(0:无效, 1:有效)',
  `is_current` tinyint(1) DEFAULT 1 COMMENT '是否当前正在使用(0:未使用, 1:正在使用)',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='SMS短信网关管理表';

insert into ant_msg_gateway(gateway_name,`status`,is_current,createtime) values('YUNPIAN',1,1,'2016-09-18 14:15:00');
insert into ant_msg_gateway(gateway_name,`status`,is_current,createtime) values('CHINAMSG',1,0,'2016-09-18 14:15:00');

