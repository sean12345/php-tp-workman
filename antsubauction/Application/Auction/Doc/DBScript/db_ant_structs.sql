/*拍单订阅分发日志信息表*/
DROP TABLE IF EXISTS `ant_auction_sub_log`;
CREATE TABLE `ant_auction_sub_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'AN蚁巢appkey',
  `account_id` varchar(30) NOT NULL DEFAULT '' COMMENT '拍单审核人ID',
  `order_id` varchar(30) NOT NULL DEFAULT '' COMMENT '拍单ID',
  `task_content` varchar(200) NOT NULL DEFAULT '' COMMENT '任务内容',
  `distribute_status` tinyint(1) DEFAULT 1 COMMENT '拍单订阅分发结果 (1:成功, 0:失败)',
  `remark` text COMMENT '备注',
  `request_time` datetime NOT NULL COMMENT '请求时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='拍单订阅分发日志信息表';

/*拍单订阅推送日志信息表*/
DROP TABLE IF EXISTS `ant_auction_subpush_log`;
CREATE TABLE `ant_auction_subpush_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_key` varchar(60) NOT NULL DEFAULT '' COMMENT 'jpush appkey',
  `app_secret` varchar(60) NOT NULL DEFAULT '' COMMENT 'jpush secret',
  `order_id` char(11) NOT NULL DEFAULT '' COMMENT '拍单ID',
  `notice_info` varchar(200) NOT NULL DEFAULT '' COMMENT '通知消息内容',
  `jpush_id` varchar(200) NOT NULL DEFAULT '' COMMENT 'jpush_id',
  `response_code` char(10) DEFAULT '' COMMENT '推送结果(200:成功)',
  `remark` text COMMENT '备注',
  `request_time` datetime NOT NULL COMMENT '请求时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='拍单订阅推送日志信息表';


/*Jpush消息推送日志信息表*/
DROP TABLE IF EXISTS `ant_jpush_send_log`;
CREATE TABLE `ant_jpush_send_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_key` varchar(60) NOT NULL DEFAULT '' COMMENT 'jpush appkey',
  `app_secret` varchar(60) NOT NULL DEFAULT '' COMMENT 'jpush secret',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '接收人手机号',
  `notice_info` varchar(200) NOT NULL DEFAULT '' COMMENT '通知消息内容',
  `jpush_id` varchar(200) NOT NULL DEFAULT '' COMMENT 'jpush_id',
  `response_code` char(10) DEFAULT '' COMMENT '推送结果(200:成功)',
  `remark` text COMMENT '备注',
  `request_time` datetime NOT NULL COMMENT '请求时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Jpush消息推送日志信息表';