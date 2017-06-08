CREATE DATABASE mw DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

#用户表
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
  `lasttime` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
  `status` int(1)  NOT NULL ,
  `heart_sleep` int(11) NOT NULL,
  `heart_sit` int(11) NOT NULL,
  `heart_sport` int(11) NOT NULL,
  `channel_id` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- alter table users add channel_id varchar(100) NOT NULL DEFAULT '';


INSERT INTO `users` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','','17701317933','admin','',1,0,80,0,''),(2,'song','21232f297a57a5a743894a0e4a801fc3','','15562121068','宋','',1,0,0,0,''),(3,'song','21232f297a57a5a743894a0e4a801fc3','','15562153556','宋','',1,60,80,0,''),(4,'杨先生','e10adc3949ba59abbe56e057f20f883e','','13255668818','杨先生','',1,60,80,0,''),(5,'admin','21232f297a57a5a743894a0e4a801fc3','','15163176588','admin','',1,60,80,0,'43132321'),(6,'admin','21232f297a57a5a743894a0e4a801fc3','','13561874900','admin','',1,60,80,0,'52312131');



 CREATE TABLE `mw_heart_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_num` varchar(20) DEFAULT NULL COMMENT '终端手机号',
  `client_sn` varchar(100) DEFAULT NULL COMMENT '终端唯一标识码',
  `lat` double DEFAULT NULL COMMENT '经度',
  `lng` double DEFAULT NULL COMMENT '纬度',
  `steps` int(11) DEFAULT NULL COMMENT '步数',
  `hearts` int(11) DEFAULT NULL COMMENT '心率',
  `static_times` int(11) DEFAULT '1' COMMENT '统计时间',
  `created_at` int(10) DEFAULT NULL,
  `upload_at` int(10) DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1026 DEFAULT CHARSET=utf8;


#手机关联表
CREATE TABLE IF NOT EXISTS `bindphone` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `bindphone` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
INSERT INTO `bindphone` VALUES(1, '17701317933', '15163176588');
INSERT INTO `bindphone` VALUES(2, '17701317933', '13561874900');


#消息推送列表
CREATE TABLE IF NOT EXISTS `push` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `body` text,
  `created_at` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
  `device_type` tinyint(2) NOT NULL DEFAULT 1,
  `msg_id` varchar(100) NOT NULL DEFAULT '',
  `send_time` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


#设备表
CREATE TABLE IF NOT EXISTS `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  `channel_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






























