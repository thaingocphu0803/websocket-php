/*
 Navicat Premium Data Transfer

 Source Server         : mysql_db
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : websocket-php

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 18/12/2024 16:56:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for user_connection
-- ----------------------------
DROP TABLE IF EXISTS `user_connection`;
CREATE TABLE `user_connection`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_online` tinyint(1) NOT NULL,
  `connection_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username` ASC) USING BTREE,
  CONSTRAINT `user_connection_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_connection
-- ----------------------------
INSERT INTO `user_connection` VALUES (40, 'phu111', 1, 121);
INSERT INTO `user_connection` VALUES (41, 'phu222', 0, 163);
INSERT INTO `user_connection` VALUES (42, 'phu333', 1, 823);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pssw` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  UNIQUE INDEX `unique_username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (37, 'phu111', '$2y$10$trUJ3svarTRRvXgiRo.wxeXFAtEcUXO9npUoayOEnYNCFZ5Nd7aRa', 'Phu Thai');
INSERT INTO `users` VALUES (38, 'phu222', '$2y$10$vTfPJaIl5h2Hb3tmbKgI4O3Hr6CFkamx8TYLsNiqIMcbzkQSgrWzO', 'Ma Vy');
INSERT INTO `users` VALUES (39, 'phu333', '$2y$10$wd4QZAg4vbvBmOUkzvZk1.oqBcZlJwoKp14nvHbINZZKLBVKKMRqi', 'Zatan Ibrahimovic');

SET FOREIGN_KEY_CHECKS = 1;
