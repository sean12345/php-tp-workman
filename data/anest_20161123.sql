-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.2.116    Database: ant_nest
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ant_auction_sub_log`
--

DROP TABLE IF EXISTS `ant_auction_sub_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ant_auction_sub_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'AN蚁巢appkey',
  `account_id` varchar(30) NOT NULL DEFAULT '' COMMENT '拍单审核人ID',
  `order_id` varchar(30) NOT NULL DEFAULT '' COMMENT '拍单ID',
  `task_content` varchar(200) NOT NULL DEFAULT '' COMMENT '任务内容',
  `distribute_status` tinyint(1) DEFAULT '1' COMMENT '拍单订阅分发结果 (1:成功, 0:失败)',
  `remark` text COMMENT '备注',
  `request_time` datetime NOT NULL COMMENT '请求时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=utf8 COMMENT='拍单订阅分发日志信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_auction_subpush_log`
--

DROP TABLE IF EXISTS `ant_auction_subpush_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=733 DEFAULT CHARSET=utf8 COMMENT='拍单订阅推送信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_jpush_send_log`
--

DROP TABLE IF EXISTS `ant_jpush_send_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='Jpush消息推送日志信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_msg_gateway`
--

DROP TABLE IF EXISTS `ant_msg_gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ant_msg_gateway` (
  `gateway_id` int(11) NOT NULL AUTO_INCREMENT,
  `gateway_name` varchar(60) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '短信网关状态(0:异常, 1:正常)',
  `is_current` tinyint(1) DEFAULT '1' COMMENT '是否当前正在使用(0:未使用, 1:正在使用)',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`gateway_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='SMS短信网关管理表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_msg_send_log`
--

DROP TABLE IF EXISTS `ant_msg_send_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=548 DEFAULT CHARSET=utf8 COMMENT='SMS短信发送日志信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_session`
--

DROP TABLE IF EXISTS `ant_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ant_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ant_task_service`
--

DROP TABLE IF EXISTS `ant_task_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ant_task_service` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) DEFAULT NULL COMMENT '任务分组ID',
  `pid` int(10) DEFAULT NULL COMMENT '进程号',
  `user_id` int(10) DEFAULT NULL COMMENT '创建人ID',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '任务标题',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '验车处理结果(0:待处理, 1:处理中, 2:暂停中, 3:处理成功 4:处理失败)',
  `processed` int(10) DEFAULT '0' COMMENT '已完成任务量(%)',
  `task_url` varchar(200) NOT NULL DEFAULT '' COMMENT '任务启动地址',
  `desc` text COMMENT '任务描述',
  `remark` text COMMENT '备注',
  `starttime` datetime NOT NULL COMMENT '任务结束时间',
  `endtime` datetime NOT NULL COMMENT '任务结束时间',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`task_id`),
  UNIQUE KEY `group_id_UNIQUE` (`group_id`),
  UNIQUE KEY `pid_UNIQUE` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务服务信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `au_come_from`
--

DROP TABLE IF EXISTS `au_come_from`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `au_come_from` (
  `from_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '渠道来源id自增',
  `pid` int(11) NOT NULL DEFAULT '-2' COMMENT '-2为父类车源',
  `from_name` varchar(300) NOT NULL COMMENT '来源名称',
  `sort` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`from_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='车源code 因原已使用  -1=》 自己      1  -》 58同城    0=》 车168   所以选用默认父类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crawler_yxp_auction`
--

DROP TABLE IF EXISTS `crawler_yxp_auction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crawler_yxp_auction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍单ID',
  `publish_type` smallint(4) DEFAULT '0' COMMENT '拍卖类型',
  `hprice` decimal(9,2) DEFAULT '0.00' COMMENT '最高价',
  `total_price` decimal(9,2) DEFAULT '0.00' COMMENT '总价',
  `trade_price` decimal(9,2) DEFAULT '0.00' COMMENT '成交价',
  `buyer_agent_fee` decimal(9,2) DEFAULT '0.00' COMMENT '代办费',
  `buyer_trade_fee` decimal(9,2) DEFAULT '0.00' COMMENT '交易服务费',
  `resp_code` smallint(4) DEFAULT '0' COMMENT '拍单拍卖状态(-3:车辆流拍, -7:竞价结束之后处理中, -12:等待竞价, -15:车辆成交)',
  `is_start_auction` smallint(4) DEFAULT '0' COMMENT '是否正在加价(1:正在加价)',
  `Is_over_reser` smallint(4) DEFAULT '0' COMMENT '是否超过保留价',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publish_id` (`publish_id`),
  KEY `resp_code` (`resp_code`),
  KEY `total_price` (`total_price`)
) ENGINE=InnoDB AUTO_INCREMENT=33805 DEFAULT CHARSET=utf8 COMMENT='优信拍拍单数据信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crawler_yxp_brand`
--

DROP TABLE IF EXISTS `crawler_yxp_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crawler_yxp_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '车系ID',
  `master_brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '主品牌ID',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车系名称',
  `remark` text NOT NULL COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_id` (`brand_id`),
  KEY `city_id` (`master_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1859 DEFAULT CHARSET=utf8 COMMENT='优信拍车系信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crawler_yxp_car`
--

DROP TABLE IF EXISTS `crawler_yxp_car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crawler_yxp_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍单ID',
  `carsource_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍单ID',
  `car_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆名称',
  `car_original_color` varchar(120) NOT NULL DEFAULT '' COMMENT '车辆颜色',
  `car_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '车辆类型ID',
  `car_type_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆类型名称',
  `car_usetype` varchar(120) NOT NULL DEFAULT '' COMMENT '车辆应用类型',
  `conditions_remark` varchar(600) NOT NULL DEFAULT '' COMMENT '问题备注',
  `coolingcheck_remark` varchar(600) NOT NULL DEFAULT '' COMMENT '冷却系统检测',
  `effluent_yellow` varchar(600) NOT NULL DEFAULT '' COMMENT '排放标准',
  `is_firsthand` varchar(60) NOT NULL DEFAULT '' COMMENT '是否一手车',
  `master_brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '主品牌ID',
  `master_brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '主品牌名称',
  `mileage` int(11) NOT NULL DEFAULT '0' COMMENT '公里数',
  `newcar_warranty` varchar(600) NOT NULL DEFAULT '' COMMENT '新车担保',
  `carshiptax_expiredate` varchar(60) NOT NULL DEFAULT '' COMMENT '保险到期日',
  `paint_repair` varchar(60) NOT NULL DEFAULT '' COMMENT '表面修复',
  `present_status` varchar(60) NOT NULL DEFAULT '' COMMENT '表面状况',
  `is_watercar` varchar(60) NOT NULL DEFAULT '' COMMENT '是否过水车',
  `regist_date` varchar(60) NOT NULL DEFAULT '' COMMENT '注册时间',
  `license_number` varchar(60) NOT NULL DEFAULT '' COMMENT '牌照',
  `license_date` varchar(60) NOT NULL DEFAULT '' COMMENT '上牌时间',
  `summary` varchar(600) NOT NULL DEFAULT '' COMMENT '车辆描述',
  `condition_grade` varchar(120) NOT NULL DEFAULT '' COMMENT '车况评级',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `car_city` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆所在城市',
  `car_city_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `car_configinfo` varchar(600) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publish_id` (`publish_id`),
  KEY `master_brand_id` (`master_brand_id`),
  KEY `brand_id` (`brand_id`),
  KEY `car_city` (`car_city`),
  KEY `car_city_id` (`car_city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17271 DEFAULT CHARSET=utf8 COMMENT='优信拍拍单车辆信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crawler_yxp_city`
--

DROP TABLE IF EXISTS `crawler_yxp_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crawler_yxp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `city_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆所在城市',
  `remark` text NOT NULL COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='优信拍车辆地址信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crawler_yxp_master_brand`
--

DROP TABLE IF EXISTS `crawler_yxp_master_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crawler_yxp_master_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '主品牌ID',
  `master_brand_letter` char(10) NOT NULL DEFAULT '' COMMENT '主品牌名称首字母',
  `master_brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '主品牌名称',
  `remark` text NOT NULL COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `master_brand_id` (`master_brand_id`),
  KEY `city_id` (`master_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8 COMMENT='优信拍主品牌信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_account_profile`
--

DROP TABLE IF EXISTS `uc_account_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户账号资料信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_clcw_account`
--

DROP TABLE IF EXISTS `uc_clcw_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_clcw_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `pwd` varchar(120) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(1) DEFAULT '1' COMMENT '账号状态(0:未激活, 1:已启用, 2:已禁用, 3:已销毁)',
  `nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `u_idcard` varchar(20) DEFAULT NULL COMMENT '身份证',
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',
  `province_id` int(10) NOT NULL COMMENT '省份',
  `city_id` int(10) NOT NULL COMMENT '城市',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `las_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `createtime` datetime NOT NULL COMMENT '注册时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name_mobile` (`account_name`,`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=10813 DEFAULT CHARSET=utf8 COMMENT='CLCW账号信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_clcw_account_action_log`
--

DROP TABLE IF EXISTS `uc_clcw_account_action_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_clcw_account_action_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `action_source` int(10) DEFAULT '0' COMMENT '动作来源',
  `action_type` tinyint(1) DEFAULT NULL COMMENT '活动类型(1:注册, 2:启用, 3:登录, 4:退出, 5:找回密码, 6:设置密码, 7:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `login_ip` char(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CLCW账号活动日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_clcw_account_option_log`
--

DROP TABLE IF EXISTS `uc_clcw_account_option_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_clcw_account_option_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `opt_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:添加用户, 2:启用用户, 3:禁用用户, 4:销毁用户, 5:重置密码, 6:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `manager_account_id` char(60) NOT NULL DEFAULT '' COMMENT '操作人账号ID',
  `manager_ip` char(30) NOT NULL DEFAULT '' COMMENT '操作人IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CLCW账号操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_dealer_account`
--

DROP TABLE IF EXISTS `uc_dealer_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_dealer_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `pwd` varchar(120) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(1) DEFAULT '1' COMMENT '账号状态(0:未激活, 1:已启用, 2:已禁用, 3:已销毁)',
  `nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `u_idcard` varchar(20) DEFAULT NULL COMMENT '身份证',
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',
  `province_id` int(10) NOT NULL COMMENT '省份',
  `city_id` int(10) NOT NULL COMMENT '城市',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `las_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `createtime` datetime NOT NULL COMMENT '注册时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name_mobile` (`account_name`,`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=10969 DEFAULT CHARSET=utf8 COMMENT='车商账号信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_dealer_account_action_log`
--

DROP TABLE IF EXISTS `uc_dealer_account_action_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_dealer_account_action_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `action_source` int(10) DEFAULT '0' COMMENT '动作来源',
  `action_type` tinyint(1) DEFAULT NULL COMMENT '活动类型(1:注册, 2:启用, 3:登录, 4:退出, 5:找回密码, 6:设置密码, 7:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `login_ip` char(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2862 DEFAULT CHARSET=utf8 COMMENT='车商账号活动日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_dealer_account_option_log`
--

DROP TABLE IF EXISTS `uc_dealer_account_option_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_dealer_account_option_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `opt_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:添加用户, 2:启用用户, 3:禁用用户, 4:销毁用户, 5:重置密码, 6:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `manager_account_id` char(60) NOT NULL DEFAULT '' COMMENT '操作人账号ID',
  `manager_ip` char(30) NOT NULL DEFAULT '' COMMENT '操作人IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=utf8 COMMENT='车商账号操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_employee_account`
--

DROP TABLE IF EXISTS `uc_employee_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_employee_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `pwd` varchar(120) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(1) DEFAULT '1' COMMENT '账号状态(0:未激活, 1:已启用, 2:已禁用, 3:已销毁)',
  `nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `u_idcard` varchar(20) DEFAULT NULL COMMENT '身份证',
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',
  `province_id` int(10) NOT NULL COMMENT '省份',
  `city_id` int(10) NOT NULL COMMENT '城市',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `las_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `createtime` datetime NOT NULL COMMENT '注册时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name_mobile` (`account_name`,`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=utf8 COMMENT='员工账号信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_employee_account_action_log`
--

DROP TABLE IF EXISTS `uc_employee_account_action_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_employee_account_action_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `action_source` int(10) DEFAULT '0' COMMENT '动作来源',
  `action_type` tinyint(1) DEFAULT NULL COMMENT '活动类型(1:注册, 2:启用, 3:登录, 4:退出, 5:找回密码, 6:设置密码, 7:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `login_ip` char(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='员工账号活动日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uc_employee_account_option_log`
--

DROP TABLE IF EXISTS `uc_employee_account_option_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_employee_account_option_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `appkey` varchar(60) NOT NULL DEFAULT '' COMMENT 'appkey应用授权编号',
  `dev_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:Android, 2:IOS, 3:Web Mobile, 4:Web PC)',
  `account_id` int(11) DEFAULT NULL COMMENT '账号ID',
  `opt_type` tinyint(1) DEFAULT NULL COMMENT '操作类型(1:添加用户, 2:启用用户, 3:禁用用户, 4:销毁用户, 5:重置密码, 6:修改账号资料)',
  `option` varchar(600) NOT NULL DEFAULT '' COMMENT '操作内容',
  `remark` varchar(600) NOT NULL DEFAULT '' COMMENT '备注',
  `manager_account_id` char(60) NOT NULL DEFAULT '' COMMENT '操作人账号ID',
  `manager_ip` char(30) NOT NULL DEFAULT '' COMMENT '操作人IP',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='员工账号操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-23 10:04:55
