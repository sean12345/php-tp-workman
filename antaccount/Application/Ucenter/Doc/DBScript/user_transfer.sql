

=====数据迁移脚本==================================
#1.  车商数据迁移
insert into ant_nest.uc_dealer_account(account_id,account_name,pwd,nick_name,real_name,u_idcard,account_avatar,mobile,createtime,updatetime,las_login_time,status,sex) select distinct(u.uid),u.user_name,u.passwd,u.nick_name,u.real_name,u.u_idcard,u.avatar,u.pwd_mobile,u.reg_date,u.last_modify_time,u.las_login_time,u.`status`,u.sex from aums.au_dealer_user d left join aums.au_user u on d.uid=u.uid;

-- 注意执行顺序
update uc_dealer_account set `status`=2 where `status`=1;
update uc_dealer_account set `status`=3 where `status`=-1;
update uc_dealer_account set `status`=1 where `status`=0;

select count(*) from au_user u join au_dealer_user d on d.uid=u.uid;
select * from aums.au_user where sms_mobile <> pwd_mobile;


#2. 员工账号迁移
insert into ant_nest.uc_employee_account(account_id,account_name,pwd,nick_name,real_name,u_idcard,account_avatar,mobile,createtime,updatetime,las_login_time,status,sex,province_id,city_id,address)
  select u.emp_id,u.username,u.passwd,'',u.real_name,'',u.avatar,u.mobile,u.createtime,'','',u.`status`,u.sex,u.province_id,'',u.address from aums.au_employee u;

-- 注意执行顺序
update uc_employee_account set `status`=2 where `status`=1;
update uc_employee_account set `status`=3 where `status`=-1;
update uc_employee_account set `status`=1 where `status`=0;

insert into ant_nest.uc_employee_account(account_id,account_name,pwd,nick_name,real_name) values(100, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 'admin');


#2. clcw账号迁移
#1.  车商数据迁移
insert into ant_nest.uc_clcw_account(account_id,account_name,pwd,nick_name,real_name,u_idcard,account_avatar,mobile,createtime,updatetime,las_login_time,status,sex) select distinct(u.uid),u.user_name,u.passwd,u.nick_name,u.real_name,u.u_idcard,u.avatar,u.pwd_mobile,u.reg_date,u.last_modify_time,u.las_login_time,u.`status`,u.sex from aums.au_auth_group_access a left join aums.au_user u on a.uid=u.uid where a.group_id in (1,2);

-- 注意执行顺序
update uc_clcw_account set `status`=2 where `status`=1;
update uc_clcw_account set `status`=3 where `status`=-1;
update uc_clcw_account set `status`=1 where `status`=0;


===================================================

select * from ant_nest.uc_dealer_account;
select * from ant_nest.uc_dealer_account where `status` = -1;
update ant_nest.uc_dealer_account set `status` = 1;

  -- from aums.au_user u right join aums.au_dealer_user d on d.uid=u.uid;
select count(dealer_id) as counts, dealer_id, uid  form aums.au_dealer_user group by dealer_id order by counts desc;


select * from aums.au_dealer_user where dealer_id=62;
select * from aums.au_dealer_user where uid=10087;


uid,user_name,passwd,nick_name,real_name,avatar,pwd_mobile,reg_date,last_modify_time,las_login_time,`status`,sex

  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(30) NOT NULL COMMENT '登录名',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  `nick_name` varchar(30) NOT NULL COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `avatar` varchar(600) NOT NULL COMMENT '头像',
  `sms_mobile` varchar(20) NOT NULL COMMENT '短信手机号',
  `pwd_mobile` varchar(20) DEFAULT NULL COMMENT '密码手机号',
  `reg_date` datetime NOT NULL COMMENT '注册日期',
  `last_modify_time` datetime NOT NULL COMMENT '最后修改日期',
  `las_login_time` datetime NOT NULL COMMENT '最后登录日期',
  `status` smallint(3) NOT NULL COMMENT '状态(-1删除 0正常 1禁用)',
  `is_account_send` tinyint(1) DEFAULT '1' COMMENT '是否已发送登录账号',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',


  `u_idcard` varchar(20) DEFAULT NULL COMMENT '身份证',


account_id,account_name,pwd,nick_name,real_name,account_avatar,email,mobile,createtime,updatetime,las_login_time,status,sex

  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `pwd` varchar(120) NOT NULL DEFAULT '' COMMENT '用户密码',
  `nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `account_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '个人头像',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  `las_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '账号状态(0:未激活, 1:已启用, 2:已禁用, 3:已销毁)',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',


+-------------------+-------------------------------------------------------------
















================================



CREATE TABLE `au_car_dealer` (
  `dealer_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '车商id',
  `depart_id` int(11) NOT NULL COMMENT '所属分公司ID',
  `category` int(3) NOT NULL COMMENT '账户类型1正式账号2体验账户',
  `bail_amount` double(10,2) NOT NULL COMMENT '保证金总数',
  `freeze_amount` double(10,2) NOT NULL COMMENT '冻结金额总数',
  `indemnity_amount` double(10,2) NOT NULL COMMENT '累计赔付金额',
  `org_code` varchar(20) NOT NULL COMMENT '车商公司编码',
  `fullname` varchar(100) NOT NULL COMMENT '车商公司全称',
  `shortname` varchar(20) NOT NULL COMMENT '车商公司简称',
  `type` smallint(3) NOT NULL COMMENT '车商公司类型',
  `contact_person` varchar(30) NOT NULL COMMENT '联系人',
  `contact_mobile` varchar(11) NOT NULL COMMENT '联系电话',
  `email` varchar(60) NOT NULL COMMENT '联系人邮箱',
  `province` int(10) NOT NULL COMMENT '省份',
  `city` int(10) NOT NULL COMMENT '城市',
  `area` int(10) NOT NULL COMMENT '所在城市',
  `address` varchar(200) NOT NULL COMMENT '详细地址',
  `postcode` varchar(6) NOT NULL COMMENT '邮编',
  `level` smallint(3) NOT NULL DEFAULT '0' COMMENT '车商等级0普通1金牌',
  `status` smallint(3) NOT NULL DEFAULT '1' COMMENT '车商状态',
  `mod_man_num` smallint(3) NOT NULL COMMENT '当月修改的提车人次数',
  `dealer_idcard` varchar(20) NOT NULL COMMENT '车商身份证',
  `start_au_remind` tinyint(1) NOT NULL COMMENT '开始拍卖是否提醒',
  `trading_remind` tinyint(1) NOT NULL COMMENT '交易提醒',
  `arbitrate_remind` tinyint(1) NOT NULL COMMENT '仲裁提醒',
  `money_change_remind` tinyint(1) NOT NULL COMMENT '保证金变动提醒',
  `sign_time` datetime NOT NULL COMMENT '签约时间',
  `is_experienced` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否体验过',
  `is_credit` tinyint(4) NOT NULL COMMENT '是否授信 0未授信  1授信',
  PRIMARY KEY (`dealer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COMMENT='车商表';

CREATE TABLE `au_dealer_user` (
  `dealer_user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联ID',
  `uid` int(10) NOT NULL COMMENT '用户id',
  `dealer_id` int(10) NOT NULL COMMENT '车商id',
  `status` smallint(3) NOT NULL COMMENT '状态',
  PRIMARY KEY (`dealer_user_id`),
  KEY `FK_Reference_53` (`uid`),
  KEY `FK_Reference_68` (`dealer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=utf8 COMMENT='车商用户关联表';


CREATE TABLE `au_car_owner` (
  `owner_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '车主编号',
  `oc_id` int(10) NOT NULL DEFAULT '0' COMMENT '线索表ID',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '网站用户ID',
  `service_id` int(10) NOT NULL DEFAULT '0' COMMENT '预约客服编号',
  `checker_id` int(10) NOT NULL DEFAULT '0' COMMENT '评估师员工编号',
  `deliver_id` int(10) NOT NULL COMMENT '交付顾问员工编号',
  `seller_name` varchar(30) NOT NULL COMMENT '车主姓名',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `car_model` varchar(100) NOT NULL COMMENT '车型',
  `brand_id` int(10) NOT NULL COMMENT '品牌',
  `series_id` int(10) NOT NULL COMMENT '车系',
  `model_id` int(10) NOT NULL COMMENT '车型',
  `business_status` smallint(3) NOT NULL DEFAULT '1' COMMENT '业务状态(1,待预约检测 2,预约检测跟踪中 3,预约检测失败 4,待检测 5,检测成功 6,检测失败， 7,待预约签约，8,预约签约跟踪中,9,预约签约失败,10,待签约分配 11，待签约,12,签约跟踪中 13,签约失败 14签约成功 15待过户 16过户中',
  `mileage` varchar(20) NOT NULL DEFAULT '0' COMMENT '里程',
  `first_reg_date` date NOT NULL DEFAULT '0000-00-00' COMMENT '初登日期（即上牌时间）',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '状态(-1禁用，0正常）',
  `comefrom` int(10) NOT NULL DEFAULT '-1' COMMENT ' 来源详见au_come_from表  备注：调整前  渠道来源(1，PC,2 M站)',
  `comefrom_url` varchar(255) DEFAULT NULL COMMENT '来源连接',
  `location_area` int(10) NOT NULL COMMENT '车辆所在地',
  `first_reg_city` int(10) NOT NULL DEFAULT '0' COMMENT '上牌地点',
  `service_method` smallint(3) NOT NULL DEFAULT '1' COMMENT '服务方式(1,未知 2,上门 3,到店)',
  `certificate_type` smallint(3) NOT NULL DEFAULT '0' COMMENT '证件类型',
  `certificate_number` varchar(100) NOT NULL DEFAULT '' COMMENT '有效证件号',
  `province` int(10) NOT NULL DEFAULT '0' COMMENT '省份',
  `city` int(10) NOT NULL DEFAULT '0' COMMENT '城市',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '地区',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
  `next_trace_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下次检测跟踪时间',
  `trace_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '跟踪类型(0普通，1改约，2驳回，3滞留)',
  `reserve_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '检测预约时间',
  `reserve_store` int(10) NOT NULL COMMENT '预约门店',
  `reserve_remark` text COMMENT '检测预约备注(检测预约成功备注，检测预约失败备注)',
  `reserve_area` int(10) NOT NULL DEFAULT '0' COMMENT '检测预约地区',
  `reserve_city` int(10) NOT NULL DEFAULT '0' COMMENT '检测预约市',
  `reserve_province` int(10) NOT NULL DEFAULT '0' COMMENT '检测预约省',
  `reserve_address` varchar(200) NOT NULL DEFAULT '' COMMENT '检测预约地址',
  `is_assigned` tinyint(1) NOT NULL COMMENT '是否被分配（0 未分配 1已分配）',
  `assgin_remark` text COMMENT '分配评估师检测备注',
  `checker_name` varchar(30) NOT NULL DEFAULT '' COMMENT '评估师姓名',
  `check_remark` text COMMENT '检测备注',
  `check_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '检测时间',
  `check_fail_date` datetime NOT NULL COMMENT '检测失败提交时间',
  `sign_next_trace_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签约下次跟踪时间',
  `sign_service_method` smallint(3) NOT NULL DEFAULT '0' COMMENT '签约服务方式(1,未知 2,上门 3,到店)',
  `sign_reserve_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签约预约时间',
  `sign_reserve_remark` text COMMENT '签约预约备注(签约预约成功备注，签约预约失败备注)',
  `sign_reserve_area` int(10) NOT NULL DEFAULT '0' COMMENT '签约预约地区',
  `sign_reserve_city` int(10) NOT NULL DEFAULT '0' COMMENT '签约预约市',
  `sign_reserve_province` int(10) NOT NULL DEFAULT '0' COMMENT '签约预约省',
  `sign_reserve_address` varchar(200) NOT NULL DEFAULT '' COMMENT '签约预约地址',
  `sign_reserve_store` int(11) NOT NULL DEFAULT '0' COMMENT '签约预约门店',
  `sign_assgin_remark` text COMMENT '分配交付顾问签约备注',
  `sign_deliver_name` varchar(30) NOT NULL DEFAULT '' COMMENT '交付顾问姓名',
  `sign_check_result` text COMMENT '签约结果',
  `sign_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签约时间',
  `audit_remark` text COMMENT '审核备注',
  `modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `posttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '提交时间',
  `is_account_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已发送登录账号',
  `isou_id` int(11) NOT NULL DEFAULT '0' COMMENT 'clcw网站的预约信息id',
  `rater_id` int(10) NOT NULL COMMENT '定价人ID',
  `is_self_upload` tinyint(1) NOT NULL COMMENT '是否为评估师自主上传的车源（1是 0否）',
  `remark_fail` text COMMENT '检测失败备注',
  `delay_status` smallint(3) DEFAULT '0' COMMENT '检测滞留状态(1未处理，2客服处理中，3客服处理完成待再约，4再分配处理中，5调度处理完成 6预约处理中',
  `check_fail_type` tinyint(1) DEFAULT '0' COMMENT '1改约2驳回3流失4退单5、调度改约',
  `reserve_reminder` varchar(255) DEFAULT NULL COMMENT '再预约提醒',
  PRIMARY KEY (`owner_id`),
  KEY `FK_Reference_70` (`service_id`),
  KEY `FK_Reference_77` (`checker_id`),
  KEY `idx_co_uid` (`uid`),
  KEY `index_isou_id` (`isou_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2357 DEFAULT CHARSET=utf8 COMMENT='车主表';

CREATE TABLE `au_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(30) NOT NULL COMMENT '登录名',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  `nick_name` varchar(30) NOT NULL COMMENT '昵称',
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `avatar` varchar(600) NOT NULL COMMENT '头像',
  `sms_mobile` varchar(20) NOT NULL COMMENT '短信手机号',
  `pwd_mobile` varchar(20) DEFAULT NULL COMMENT '密码手机号',
  `reg_date` datetime NOT NULL COMMENT '注册日期',
  `last_modify_time` datetime NOT NULL COMMENT '最后修改日期',
  `las_login_time` datetime NOT NULL COMMENT '最后登录日期',
  `status` smallint(3) NOT NULL COMMENT '状态(-1删除 0正常 1禁用)',
  `is_account_send` tinyint(1) DEFAULT '1' COMMENT '是否已发送登录账号',
  `sex` tinyint(4) DEFAULT '0' COMMENT '性别 1男 2女',
  `u_idcard` varchar(20) DEFAULT NULL COMMENT '身份证',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `index_pwd_mobile` (`pwd_mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=10659 DEFAULT CHARSET=utf8 COMMENT='网站用户表';

CREATE TABLE `au_employee` (
  `emp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工编号',
  `depart_id` int(10) NOT NULL COMMENT '部门编号',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `real_name` varchar(30) NOT NULL COMMENT '员工姓名',
  `sex` smallint(3) NOT NULL COMMENT '性别',
  `mobile` varchar(11) NOT NULL COMMENT '手机',
  `avatar` varchar(600) NOT NULL COMMENT '员工头像',
  `describe` text COMMENT '简介',
  `status` smallint(3) NOT NULL COMMENT '状态（-1删除 0启用，1禁用）',
  `province_id` int(10) NOT NULL COMMENT '省份',
  `store` smallint(3) NOT NULL COMMENT '店面',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `checker_level` smallint(3) NOT NULL DEFAULT '1' COMMENT '评估师等级(1普通车辆检测师 ,2高级车辆检测师)',
  `is_head` smallint(3) NOT NULL DEFAULT '0' COMMENT '是否负责人(0否1是)',
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_Reference_80` (`depart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=414 DEFAULT CHARSET=utf8 COMMENT='员工表';

CREATE TABLE `au_fours` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(32) NOT NULL COMMENT '4s店名称',
  `channel_id` int(11) NOT NULL COMMENT '渠道来源id',
  `b_id` int(11) NOT NULL COMMENT '集团id',
  `addr` varchar(255) NOT NULL COMMENT '4s店地址',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `modifytime` datetime NOT NULL COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:0为停用,1为开启',
  `phone` char(11) NOT NULL COMMENT '联系电话',
  `contact` varchar(32) NOT NULL COMMENT '联系人',
  `developer` varchar(32) NOT NULL COMMENT '4S店开发人',
  `city` int(10) NOT NULL COMMENT '所在城市',
  `bank_name` varchar(255) NOT NULL COMMENT '开户行',
  `card_no` varchar(30) NOT NULL COMMENT '银行卡号',
  `account_name` varchar(30) NOT NULL COMMENT '账户名',
  PRIMARY KEY (`fid`),
  KEY `channel_id` (`channel_id`),
  KEY `b_id` (`b_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='4s店表';

CREATE TABLE `au_fours_user` (
  `fu_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '用户id',
  `f_id` int(11) NOT NULL COMMENT '4s店id',
  `phone` char(11) NOT NULL COMMENT '电话',
  `real_name` varchar(32) NOT NULL COMMENT '姓名',
  `modifytime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`fu_id`),
  KEY `uf_id` (`u_id`,`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户对应4s店中间表';

CREATE TABLE `au_agent` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '经纪人id',
  `uid` int(11) NOT NULL COMMENT '用户UID',
  `superior_id` int(11) NOT NULL COMMENT '上级id',
  `develop_deal` double(10,4) NOT NULL COMMENT '发展经纪人金额',
  `direct_deal` double(10,4) NOT NULL COMMENT '直接交易金额',
  `indirect_deal` double(10,4) NOT NULL COMMENT '间接交易金额',
  `total_money` double(10,4) NOT NULL COMMENT '累积总额',
  `wallet` double(10,4) NOT NULL COMMENT '零钱',
  `invite_code` varchar(80) NOT NULL COMMENT '我的邀请码',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `invite_code` (`invite_code`),
  UNIQUE KEY `uid` (`uid`),
  KEY `superior_id` (`superior_id`)
) ENGINE=InnoDB AUTO_INCREMENT=609 DEFAULT CHARSET=utf8 COMMENT='经纪人表';

CREATE TABLE `au_bloc` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `b_name` varchar(32) NOT NULL COMMENT '集团名称',
  `addr` varchar(255) NOT NULL COMMENT '集团地址',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `modifytime` datetime NOT NULL COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:0为停用,1为开启',
  `phone` char(11) NOT NULL COMMENT '联系电话',
  `contact` varchar(32) NOT NULL COMMENT '联系人',
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='集团表';

CREATE TABLE `au_bloc_user` (
  `bu_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '用户id',
  `b_id` int(11) NOT NULL COMMENT '集团id',
  `phone` char(11) NOT NULL COMMENT '电话',
  `real_name` varchar(32) NOT NULL COMMENT '姓名',
  `modifytime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`bu_id`),
  KEY `ub_id` (`u_id`,`b_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户对应集团中间表';

















