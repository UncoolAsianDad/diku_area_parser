/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : la

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-04-12 20:40:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mob`
-- ----------------------------
DROP TABLE IF EXISTS `mob`;
CREATE TABLE `mob` (
`vnum`  int(11) NOT NULL ,
`player_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`short_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`long_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`act`  set('is_npc','sentinel','scavenger','halt','fightscr','aggressive','stay_area','wimpy','pet','train','practice','gamble','join','undead','wind','learn','scramble','trackscr','tracking','angry','immortal','blacksmith','assist','backstab','inn_keeper','mountable') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`affected_by`  set('blind','invis','detect_evil','detect_invis','detect_magic','detect_hidden','hold','sanctuary','faerie_fire','infrared','curse','flaming','poison','protect','paralysis','sneak','hide','sleep','charm','flying','pass_door','waterwalk','summoned','mute','gills','berserk','stealth','hasteslash','d_protect','berserker') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`alignment`  int(11) NOT NULL ,
`level`  int(11) NOT NULL ,
`hitroll`  int(11) NOT NULL ,
`ac`  int(11) NOT NULL ,
`gold`  int(11) NOT NULL ,
`script`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `mob_in_room`
-- ----------------------------
DROP TABLE IF EXISTS `mob_in_room`;
CREATE TABLE `mob_in_room` (
`command`  char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`mob_vnum`  int(11) NOT NULL ,
`arg2`  int(11) NOT NULL ,
`room_vnum`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `obj_in_mob_equip`
-- ----------------------------
DROP TABLE IF EXISTS `obj_in_mob_equip`;
CREATE TABLE `obj_in_mob_equip` (
`command`  char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`obj_vnum`  int(11) NOT NULL ,
`mob_vnum`  int(11) NOT NULL ,
`location`  enum('finger_l','finger_r','neck_1','neck_2','body','head','legs','feet','hands','arms','wield_l','about','waist','wrist_l','wrist_r','wield','hold') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `obj_in_obj`
-- ----------------------------
DROP TABLE IF EXISTS `obj_in_obj`;
CREATE TABLE `obj_in_obj` (
`command`  char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`obj_vnum`  int(11) NOT NULL ,
`arg2`  int(11) NOT NULL ,
`container_vnum`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `obj_in_room`
-- ----------------------------
DROP TABLE IF EXISTS `obj_in_room`;
CREATE TABLE `obj_in_room` (
`command`  char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`obj_vnum`  int(11) NOT NULL ,
`arg2`  int(11) NOT NULL ,
`room_vnum`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object`
-- ----------------------------
DROP TABLE IF EXISTS `object`;
CREATE TABLE `object` (
`vnum`  int(11) NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`short_descr`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`item_type`  enum('light','scroll','wand','staff','weapon','arrows','wcontainer','treasure','armor','potoin','item_11','furniture','trash','item_14','container','item_16','drink_con','key','food','money','item_21','boat','corpse_npc','corpse_pc','fountain','pill') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`extra_flags`  set('glow','hum','dark','lock','evil','invis','magic','nodrop','bless','anti_good','anti_evil','anti_neutral','noremove','inventory','poisoned','trap') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`wear_flag`  set('take','finger','neck','body','head','legs','feet','hands','arms','shield','about','waist','wrist','wield','hold') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`v0`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v1`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v2`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`v3`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`weight`  int(11) NOT NULL ,
`cost`  int(11) NOT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object_affects`
-- ----------------------------
DROP TABLE IF EXISTS `object_affects`;
CREATE TABLE `object_affects` (
`obj_vnum`  int(11) NOT NULL ,
`flag`  enum('str','dex','int','wis','con','sex','class','level','age','height','weight','mana','hit','move','gold','exp','ac','hitroll','damroll','saving_para','saving_rod','saving_petri','saving_breath','saving_spell','round') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`modifier`  int(11) NOT NULL ,
FOREIGN KEY (`obj_vnum`) REFERENCES `object` (`vnum`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `object_ed`
-- ----------------------------
DROP TABLE IF EXISTS `object_ed`;
CREATE TABLE `object_ed` (
`obj_vnum`  int(11) NOT NULL ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
FOREIGN KEY (`obj_vnum`) REFERENCES `object` (`vnum`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `resets`
-- ----------------------------
DROP TABLE IF EXISTS `resets`;
CREATE TABLE `resets` (
`command`  char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`arg1`  int(11) NOT NULL ,
`arg2`  int(11) NOT NULL ,
`arg3`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `room`
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
`vnum`  int(11) NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`desc`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`flags`  int(11) NOT NULL ,
`sector_type`  enum('city','field','forest','hills','mountain','water_swim','water_noswim','underwater','air','desert') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`light`  int(11) NOT NULL ,
PRIMARY KEY (`vnum`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `room_exits`
-- ----------------------------
DROP TABLE IF EXISTS `room_exits`;
CREATE TABLE `room_exits` (
`room_vnum`  int(11) NOT NULL ,
`to_room`  int(11) NOT NULL ,
`direction`  int(11) NOT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lock_vnum`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- View structure for `v_mob_in_room`
-- ----------------------------
DROP VIEW IF EXISTS `v_mob_in_room`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mob_in_room` AS select `mob`.`player_name` AS `player_name`,`room`.`name` AS `name` from ((`mob_in_room` join `mob` on((`mob_in_room`.`mob_vnum` = `mob`.`vnum`))) join `room` on((`room`.`vnum` = `mob_in_room`.`room_vnum`)));

-- ----------------------------
-- View structure for `v_objects`
-- ----------------------------
DROP VIEW IF EXISTS `v_objects`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_objects` AS select `object`.`vnum` AS `vnum`,`object`.`name` AS `name`,`object`.`short_descr` AS `short_descr`,`object`.`description` AS `description`,`object`.`item_type` AS `item_type`,`object`.`extra_flags` AS `extra_flags`,`object`.`wear_flag` AS `wear_flag`,`object`.`v0` AS `v0`,`object`.`v1` AS `v1`,`object`.`v2` AS `v2`,`object`.`v3` AS `v3`,`object`.`weight` AS `weight`,`object`.`cost` AS `cost`,`object_affects`.`flag` AS `flag`,`object_affects`.`modifier` AS `modifier` from (`object` join `object_affects` on((`object_affects`.`obj_vnum` = `object`.`vnum`)));

-- ----------------------------
-- View structure for `view_obj_on_mob`
-- ----------------------------
DROP VIEW IF EXISTS `view_obj_on_mob`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_obj_on_mob` AS select `mob`.`player_name` AS `player_name`,`mob`.`level` AS `level`,`obj_in_mob_equip`.`location` AS `location`,`obj_in_mob_equip`.`mob_vnum` AS `mob_vnum`,`object`.`vnum` AS `vnum`,`object`.`name` AS `name`,`object`.`short_descr` AS `short_descr`,`object`.`description` AS `description`,`object`.`item_type` AS `item_type`,`object`.`extra_flags` AS `extra_flags`,`object`.`wear_flag` AS `wear_flag`,`object`.`v0` AS `v0`,`object`.`v1` AS `v1`,`object`.`v2` AS `v2`,`object`.`v3` AS `v3`,`object`.`weight` AS `weight`,`object`.`cost` AS `cost`,`object_affects`.`flag` AS `flag`,`object_affects`.`modifier` AS `modifier` from (((`obj_in_mob_equip` join `object` on((`obj_in_mob_equip`.`obj_vnum` = `object`.`vnum`))) join `mob` on((`mob`.`vnum` = `obj_in_mob_equip`.`mob_vnum`))) join `object_affects` on((`object_affects`.`obj_vnum` = `object`.`vnum`)));

-- ----------------------------
-- Indexes structure for table object_affects
-- ----------------------------
CREATE INDEX `obj_vnum` ON `object_affects`(`obj_vnum`) USING BTREE ;

-- ----------------------------
-- Indexes structure for table object_ed
-- ----------------------------
CREATE INDEX `obj_vnum` ON `object_ed`(`obj_vnum`) USING BTREE ;

-- ----------------------------
-- Indexes structure for table room_exits
-- ----------------------------
CREATE INDEX `room_vnum` ON `room_exits`(`room_vnum`) USING BTREE ;
