/*优信拍拍单数据信息表*/
#DROP TABLE IF EXISTS `crawler_yxp_auction`;
CREATE TABLE `crawler_yxp_auction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_id` int(11) NOT NULL DEFAULT 0 COMMENT '拍单ID',
  `publish_type` smallint(4) DEFAULT 0 COMMENT '拍卖类型',
  `hprice` decimal(9,2) DEFAULT 0 COMMENT '最高价',
  `total_price` decimal(9,2) DEFAULT 0 COMMENT '总价',
  `trade_price` decimal(9,2) DEFAULT 0 COMMENT '成交价',
  `buyer_agent_fee` decimal(9,2) DEFAULT 0 COMMENT '代办费',
  `buyer_trade_fee` decimal(9,2) DEFAULT 0 COMMENT '交易服务费',
  `resp_code` smallint(4) DEFAULT 0 COMMENT '拍单拍卖状态(-3:车辆流拍, -7:竞价结束之后处理中, -12:等待竞价, -15:车辆成交)',
  `is_start_auction` smallint(4) DEFAULT 0 COMMENT '是否正在加价(1:正在加价)',
  `Is_over_reser` smallint(4) DEFAULT 0 COMMENT '是否超过保留价',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  index resp_code (`resp_code`),
  index total_price (`total_price`),
  UNIQUE KEY `publish_id` (`publish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优信拍拍单数据信息表';



#alter table crawler_yxp_auction add index resp_code ( `resp_code` );
#alter table crawler_yxp_auction add index total_price ( `total_price` );
#alter table crawler_yxp_auction add index resp_code ( `resp_code` );
#alter table crawler_yxp_auction add index resp_code ( `resp_code` );
#alter table `crawler_yxp_auction` Add column `updatetime` datetime not null AFTER `createtime`;

/*优信拍拍单车辆信息表*/
#DROP TABLE IF EXISTS `crawler_yxp_car`;
CREATE TABLE `crawler_yxp_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_id` int(11) NOT NULL DEFAULT 0 COMMENT '拍单ID',
  `carsource_id` int(11) NOT NULL DEFAULT 0 COMMENT '拍单ID',
  `car_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆名称',
  `car_original_color` varchar(120) NOT NULL DEFAULT '' COMMENT '车辆颜色',
  `car_type_id` int(11) NOT NULL DEFAULT 0 COMMENT '车辆类型ID',
  `car_type_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆类型名称',
  `car_usetype` varchar(120) NOT NULL DEFAULT '' COMMENT '车辆应用类型',
  `conditions_remark` varchar(600) NOT NULL DEFAULT '' COMMENT '问题备注',
  `coolingcheck_remark` varchar(600) NOT NULL DEFAULT '' COMMENT '冷却系统检测',
  `effluent_yellow` varchar(600) NOT NULL DEFAULT '' COMMENT '排放标准',
  `is_firsthand` varchar(60) NOT NULL DEFAULT '' COMMENT '是否一手车',
  `master_brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '主品牌ID',
  `master_brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '主品牌名称',
  `mileage` int(11) NOT NULL DEFAULT 0 COMMENT '公里数',
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
  `brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '品牌ID',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `car_city` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆所在城市',
  `car_city_id` int(11) NOT NULL DEFAULT 0 COMMENT '城市ID',
  `car_configinfo` varchar(600) NOT NULL DEFAULT '' COMMENT '短信网关名称',
  `remark` text COMMENT '备注',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  index publish_id (`publish_id`),
  index master_brand_id (`master_brand_id`),
  index brand_id (`brand_id`),
  index car_city_id (`car_city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优信拍拍单车辆信息表';

#alter table `crawler_yxp_car` Add column `updatetime` datetime not null AFTER `createtime`;
-- alter table `crawler_yxp_car` Add column `car_city_id` int(11) NOT NULL DEFAULT 0 COMMENT '城市ID' AFTER `car_city`;
#alter table crawler_yxp_car add index master_brand_id ( `master_brand_id` );
#alter table crawler_yxp_car add index car_city_id ( `car_city_id` );


/*优信拍车辆地址信息表*/
DROP TABLE IF EXISTS `crawler_yxp_city`;
CREATE TABLE `crawler_yxp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL DEFAULT 0 COMMENT '城市ID',
  `city_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车辆所在城市',
  `remark` text NOT NULL DEFAULT '' COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  index city_id (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优信拍车辆地址信息表';


insert into crawler_yxp_city(city_id, city_name, createtime) values
(201, '北京', sysdate()),
(2401, '上海', sysdate()),
(2501, '成都', sysdate()),
(5, '广州', sysdate()),
(2601, '天津', sysdate()),
(3001, '杭州', sysdate()),
(1201, '武汉', sysdate()),
(502, '深圳', sysdate()),
(518, '佛山', sysdate()),
(1717, '铁岭', sysdate()),
(1502, '苏州', sysdate()),
(2301, '西安', sysdate()),
(-1, '其它', sysdate());

/*优信拍主品牌信息表*/
DROP TABLE IF EXISTS `crawler_yxp_master_brand`;
CREATE TABLE `crawler_yxp_master_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '主品牌ID',
  `master_brand_letter` char(10) NOT NULL DEFAULT '' COMMENT '主品牌名称首字母',
  `master_brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '主品牌名称',
  `remark` text NOT NULL DEFAULT '' COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `master_brand_id` (`master_brand_id`),
  index city_id (`master_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优信拍主品牌信息表';


/*优信拍车系信息表*/
DROP TABLE IF EXISTS `crawler_yxp_brand`;
CREATE TABLE `crawler_yxp_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '车系ID',
  `master_brand_id` int(11) NOT NULL DEFAULT 0 COMMENT '主品牌ID',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '车系名称',
  `remark` text NOT NULL DEFAULT '' COMMENT '备注',
  `createtime` datetime NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updatetime` datetime NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_id` (`brand_id`),
  index city_id (`master_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优信拍车系信息表';

