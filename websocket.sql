/*
 Navicat Premium Data Transfer

 Source Server         : db
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : websocket

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 25/11/2024 08:08:36
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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_connection
-- ----------------------------
INSERT INTO `user_connection` VALUES (4, 'phu123', 1, 151);
INSERT INTO `user_connection` VALUES (5, 'phu111', 1, 91);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pssw` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'phu123', 'phu123');
INSERT INTO `users` VALUES (2, 'phu111', 'phu111');
INSERT INTO `users` VALUES (3, 'phu122', 'phu122');
INSERT INTO `users` VALUES (4, 'phu222', 'phu222');

SET FOREIGN_KEY_CHECKS = 1;
