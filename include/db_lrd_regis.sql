-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- โฮสต์: localhost
-- เวลาในการสร้าง: 25 ม.ค. 2011  น.
-- รุ่นของเซิร์ฟเวอร์: 5.0.51
-- รุ่นของ PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- ฐานข้อมูล: `db_lrd_regis`
-- 

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `province`
-- 

CREATE TABLE `province` (
  `id_province` int(11) NOT NULL auto_increment,
  `id_residence` int(11) NOT NULL,
  `name_province` varchar(255) NOT NULL,
  `drop_name` varchar(30) NOT NULL,
  `num_orders` int(11) NOT NULL,
  `id_personnel` int(11) NOT NULL,
  PRIMARY KEY  (`id_province`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

-- 
-- dump ตาราง `province`
-- 

INSERT INTO `province` VALUES (1, 18, 'กระบี่', 'กบ', 1, 1);
INSERT INTO `province` VALUES (2, 14, 'กาญจนบุรี', 'กจ', 2, 1);
INSERT INTO `province` VALUES (3, 16, 'กาฬสินธุ์ ', 'กส', 1, 1);
INSERT INTO `province` VALUES (4, 8, 'กำแพงเพชร ', 'กพ', 2, 1);
INSERT INTO `province` VALUES (5, 6, 'ขอนแก่น', 'ขก', 1, 1);
INSERT INTO `province` VALUES (6, 3, 'จันทบุรี', 'จบ', 2, 1);
INSERT INTO `province` VALUES (7, 13, 'ฉะเชิงเทรา', 'ฉช', 1, 1);
INSERT INTO `province` VALUES (8, 3, 'ชลบุรี', 'ชบ', 1, 1);
INSERT INTO `province` VALUES (9, 2, 'ชัยนาท ', 'ชน', 4, 1);
INSERT INTO `province` VALUES (10, 5, 'ชัยภูมิ', 'ชย', 4, 1);
INSERT INTO `province` VALUES (11, 11, 'ชุมพร', 'ชพ', 3, 1);
INSERT INTO `province` VALUES (12, 17, 'เชียงราย', 'ชร', 1, 1);
INSERT INTO `province` VALUES (13, 10, 'เชียงใหม่', 'ชม', 1, 1);
INSERT INTO `province` VALUES (14, 18, 'ตรัง', 'ตง', 4, 1);
INSERT INTO `province` VALUES (15, 3, 'ตราด', 'ตร', 4, 1);
INSERT INTO `province` VALUES (16, 8, 'ตาก', 'ตก', 5, 1);
INSERT INTO `province` VALUES (17, 13, 'นครนายก', 'นย', 3, 1);
INSERT INTO `province` VALUES (18, 14, 'นครปฐม', 'นฐ', 3, 1);
INSERT INTO `province` VALUES (19, 16, 'นครพนม', 'นพ', 2, 1);
INSERT INTO `province` VALUES (20, 5, 'นครราชสีมา', 'นม', 1, 1);
INSERT INTO `province` VALUES (21, 11, 'นครศรีธรรมราช', 'นศ', 2, 1);
INSERT INTO `province` VALUES (22, 8, 'นครสวรรค์', 'นว', 1, 1);
INSERT INTO `province` VALUES (23, 1, 'นนทบุรี', 'นบ', 2, 1);
INSERT INTO `province` VALUES (24, 12, 'นราธิวาส', 'นธ', 5, 1);
INSERT INTO `province` VALUES (25, 17, 'น่าน', 'นน', 2, 1);
INSERT INTO `province` VALUES (26, 5, 'บุรีรัมย์', 'บร', 3, 1);
INSERT INTO `province` VALUES (27, 1, 'ปทุมธานี', 'ปท', 1, 1);
INSERT INTO `province` VALUES (28, 4, 'ประจวบคีรีขันธ์', 'ปข', 2, 1);
INSERT INTO `province` VALUES (30, 12, 'ปัตตานี', 'ปน', 3, 1);
INSERT INTO `province` VALUES (32, 1, 'พระนครศรีอยุธยา', 'อย', 3, 1);
INSERT INTO `province` VALUES (31, 17, 'พะเยา', 'พย', 3, 1);
INSERT INTO `province` VALUES (33, 18, 'พังงา', 'พง', 2, 1);
INSERT INTO `province` VALUES (34, 18, 'พัทลุง', 'พท', 5, 1);
INSERT INTO `province` VALUES (35, 8, 'พิจิตร', 'พจ', 4, 1);
INSERT INTO `province` VALUES (36, 9, 'พิษณุโลก', 'พล', 2, 1);
INSERT INTO `province` VALUES (37, 4, 'เพชรบุรี', 'พบ', 1, 1);
INSERT INTO `province` VALUES (38, 9, 'เพชรบูรณ์', 'พช', 4, 1);
INSERT INTO `province` VALUES (39, 10, 'แพร่', 'พร', 5, 1);
INSERT INTO `province` VALUES (40, 18, 'ภูเก็ต', 'ภก', 3, 1);
INSERT INTO `province` VALUES (41, 6, 'มหาสารคาม', 'มค', 3, 1);
INSERT INTO `province` VALUES (42, 16, 'มุกดาหาร', 'มห', 3, 1);
INSERT INTO `province` VALUES (43, 10, 'แม่ฮ่องสอน', 'มส', 4, 1);
INSERT INTO `province` VALUES (44, 7, 'ยโสธร', 'ยส', 4, 1);
INSERT INTO `province` VALUES (45, 12, 'ยะลา', 'ยล', 4, 1);
INSERT INTO `province` VALUES (46, 6, 'ร้อยเอ็ด', 'รอ', 2, 1);
INSERT INTO `province` VALUES (47, 11, 'ระนอง', 'รน', 4, 1);
INSERT INTO `province` VALUES (48, 3, 'ระยอง', 'รย', 3, 1);
INSERT INTO `province` VALUES (49, 4, 'ราชบุรี', 'รบ', 5, 1);
INSERT INTO `province` VALUES (50, 2, 'ลพบุรี', 'ลบ', 2, 1);
INSERT INTO `province` VALUES (51, 10, 'ลำปาง', 'ลป', 3, 1);
INSERT INTO `province` VALUES (52, 10, 'ลำพูน', 'ลพ', 2, 1);
INSERT INTO `province` VALUES (53, 6, 'เลย', 'ลย', 4, 1);
INSERT INTO `province` VALUES (54, 7, 'ศรีสะเกษ', 'ศก', 2, 1);
INSERT INTO `province` VALUES (55, 16, 'สกลนคร', 'สน', 4, 1);
INSERT INTO `province` VALUES (56, 12, 'สงขลา', 'สข', 1, 1);
INSERT INTO `province` VALUES (57, 12, 'สตูล', 'สต', 2, 1);
INSERT INTO `province` VALUES (58, 1, 'สมุทรปราการ', 'สป', 5, 1);
INSERT INTO `province` VALUES (59, 4, 'สมุทรสงคราม', 'สส', 4, 1);
INSERT INTO `province` VALUES (60, 4, 'สมุทรสาคร', 'สค', 3, 1);
INSERT INTO `province` VALUES (61, 13, 'สระแก้ว', 'สก', 4, 1);
INSERT INTO `province` VALUES (62, 2, 'สระบุรี', 'สบ', 1, 1);
INSERT INTO `province` VALUES (63, 2, 'สิงห์บุรี', 'สห', 3, 1);
INSERT INTO `province` VALUES (64, 9, 'สุโขทัย', 'สท', 3, 1);
INSERT INTO `province` VALUES (65, 14, 'สุพรรณบุรี', 'สพ', 1, 1);
INSERT INTO `province` VALUES (66, 11, 'สุราษฎร์ธานี', 'สฏ', 1, 1);
INSERT INTO `province` VALUES (67, 5, 'สุรินทร์', 'สร', 2, 1);
INSERT INTO `province` VALUES (68, 15, 'หนองคาย', 'นค', 2, 1);
INSERT INTO `province` VALUES (69, 15, 'หนองบัวลำภู', 'นภ', 3, 1);
INSERT INTO `province` VALUES (70, 1, 'อ่างทอง', 'อท', 4, 1);
INSERT INTO `province` VALUES (71, 7, 'อำนาจเจริญ', 'อจ', 3, 1);
INSERT INTO `province` VALUES (72, 15, 'อุดรธานี', 'อด', 1, 1);
INSERT INTO `province` VALUES (73, 9, 'อุตรดิตถ์', 'อต', 1, 1);
INSERT INTO `province` VALUES (74, 8, 'อุทัยธานี', 'อน', 3, 1);
INSERT INTO `province` VALUES (75, 7, 'อุบลราชธานี', 'อบ', 1, 1);
INSERT INTO `province` VALUES (29, 13, 'ปราจีนบุรี', 'ปจ', 2, 1);

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `register_road`
-- 

CREATE TABLE `register_road` (
  `id_regis` bigint(30) NOT NULL auto_increment,
  `id_mun` int(11) NOT NULL,
  `na_road` varchar(30) NOT NULL,
  `id_road` varchar(30) NOT NULL,
  `name_per` varchar(255) NOT NULL,
  `name_road` varchar(255) NOT NULL,
  `distance_road` varchar(120) NOT NULL,
  `tumbol_road` varchar(255) NOT NULL,
  `district_road` varchar(255) NOT NULL,
  `province_road` varchar(255) NOT NULL,
  `start_road` varchar(255) NOT NULL,
  `trariff_start_road_n` varchar(120) NOT NULL,
  `trariff_start_road_e` varchar(120) NOT NULL,
  `end_road` varchar(255) NOT NULL,
  `trariff_end_road_n` varchar(120) NOT NULL,
  `trariff_end_road_e` varchar(120) NOT NULL,
  `type_ditch_road` int(1) NOT NULL,
  `ditch_road` varchar(120) NOT NULL,
  `type_road` int(1) NOT NULL,
  `year_road` varchar(12) NOT NULL,
  `divide_road` varchar(30) NOT NULL,
  `id_regis_detail` int(11) NOT NULL,
  `cre_date` date NOT NULL,
  `cre_time` time NOT NULL,
  `update_date` datetime NOT NULL,
  `id_personnel` int(11) NOT NULL,
  PRIMARY KEY  (`id_regis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- dump ตาราง `register_road`
-- 


-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `register_road_detail`
-- 

CREATE TABLE `register_road_detail` (
  `id_regis_detail` bigint(30) NOT NULL auto_increment,
  `id_regis` bigint(30) NOT NULL,
  `kate_regis` varchar(30) NOT NULL,
  `jarat_road` int(11) NOT NULL,
  `period_regis` int(11) NOT NULL,
  `distance_regis` varchar(250) NOT NULL,
  `type_ja` int(1) NOT NULL,
  `width_ja` varchar(30) NOT NULL,
  `type_sh` int(1) NOT NULL,
  `width_sh` varchar(30) NOT NULL,
  `type_fo` int(1) NOT NULL,
  `width_fo` varchar(30) NOT NULL,
  `type_road_detail` int(1) NOT NULL,
  `layer_road_detail` int(11) NOT NULL,
  `note` text,
  `cre_date` date NOT NULL,
  `cre_time` time NOT NULL,
  `update_date` datetime NOT NULL,
  `id_personnel` int(11) NOT NULL,
  PRIMARY KEY  (`id_regis_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- dump ตาราง `register_road_detail`
-- 

