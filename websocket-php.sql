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

 Date: 24/12/2024 15:17:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `room` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mssg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sender` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_sender`(`sender` ASC) USING BTREE,
  INDEX `fk_room`(`room` ASC) USING BTREE,
  CONSTRAINT `FK_sender` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 140 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES (112, 'phu222_phu333', 'zo', 'phu222', 'phu333', 'Y', '2024-12-24 09:21:41');
INSERT INTO `messages` VALUES (113, 'phu222_phu333', 'whasup men', 'phu222', 'phu333', 'Y', '2024-12-24 09:21:49');
INSERT INTO `messages` VALUES (114, 'phu111_phu333', 'z', 'phu111', 'phu333', 'Y', '2024-12-24 09:22:49');
INSERT INTO `messages` VALUES (115, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:23:01');
INSERT INTO `messages` VALUES (116, 'phu111_phu333', 'zo', 'phu111', 'phu333', 'Y', '2024-12-24 09:23:45');
INSERT INTO `messages` VALUES (117, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:23:51');
INSERT INTO `messages` VALUES (118, 'phu111_phu222', 'zo', 'phu222', 'phu111', 'Y', '2024-12-24 09:24:32');
INSERT INTO `messages` VALUES (119, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-24 09:24:41');
INSERT INTO `messages` VALUES (120, 'phu111_phu222', 'go', 'phu222', 'phu111', 'Y', '2024-12-24 09:24:56');
INSERT INTO `messages` VALUES (121, 'phu111_phu333', 'men', 'phu111', 'phu333', 'Y', '2024-12-24 09:25:04');
INSERT INTO `messages` VALUES (122, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:25:11');
INSERT INTO `messages` VALUES (123, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:26:10');
INSERT INTO `messages` VALUES (124, 'phu111_phu333', 'yo', 'phu111', 'phu333', 'Y', '2024-12-24 09:26:18');
INSERT INTO `messages` VALUES (125, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:26:22');
INSERT INTO `messages` VALUES (126, 'phu111_phu333', 'men', 'phu111', 'phu333', 'Y', '2024-12-24 09:32:53');
INSERT INTO `messages` VALUES (127, 'phu111_phu333', 'zo', 'phu333', 'phu111', 'Y', '2024-12-24 09:40:17');
INSERT INTO `messages` VALUES (128, 'phu111_phu333', 'men', 'phu111', 'phu333', 'Y', '2024-12-24 09:40:22');
INSERT INTO `messages` VALUES (129, 'phu222_phu333', 'zo', 'phu333', 'phu222', 'Y', '2024-12-24 09:40:37');
INSERT INTO `messages` VALUES (130, 'phu222_phu333', 'zo', 'phu333', 'phu222', 'Y', '2024-12-24 09:40:54');
INSERT INTO `messages` VALUES (131, 'phu222_phu333', 'zo', 'phu333', 'phu222', 'N', '2024-12-24 09:43:22');
INSERT INTO `messages` VALUES (132, 'phu111_phu333', 'zo', 'phu333', 'phu111', 'Y', '2024-12-24 09:43:33');
INSERT INTO `messages` VALUES (133, 'phu111_phu222', 'o', 'phu111', 'phu222', 'Y', '2024-12-24 09:43:44');
INSERT INTO `messages` VALUES (134, 'phu111_phu333', 'men', 'phu111', 'phu333', 'Y', '2024-12-24 09:43:57');
INSERT INTO `messages` VALUES (135, 'phu111_phu333', 'men', 'phu111', 'phu333', 'Y', '2024-12-24 09:44:10');
INSERT INTO `messages` VALUES (136, 'phu111_phu333', 'men', 'phu333', 'phu111', 'Y', '2024-12-24 09:44:21');
INSERT INTO `messages` VALUES (137, 'phu111_phu222', 'men', 'phu222', 'phu111', 'Y', '2024-12-24 09:44:30');
INSERT INTO `messages` VALUES (138, 'phu111_phu222', 'cec', 'phu222', 'phu111', 'Y', '2024-12-24 11:14:24');
INSERT INTO `messages` VALUES (139, 'phu111_phu444', 'zo', 'phu444', 'phu111', 'Y', '2024-12-24 14:52:59');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_open` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stt` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'A',
  `chat_with` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_user_open`(`user_open` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES (24, 'phu333', 'phu111_phu333', 'X', 'phu111', '2024-12-24 10:33:17');
INSERT INTO `rooms` VALUES (25, 'phu222', 'phu111_phu222', 'X', 'phu111', '2024-12-24 11:14:27');
INSERT INTO `rooms` VALUES (26, 'phu111', 'phu111_phu444', 'X', 'phu444', '2024-12-24 14:53:41');
INSERT INTO `rooms` VALUES (27, 'phu444', 'phu111_phu444', 'X', 'phu111', '2024-12-24 14:53:01');

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
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_connection
-- ----------------------------
INSERT INTO `user_connection` VALUES (40, 'phu111', 0, 0);
INSERT INTO `user_connection` VALUES (41, 'phu222', 0, 0);
INSERT INTO `user_connection` VALUES (42, 'phu333', 0, 0);
INSERT INTO `user_connection` VALUES (44, 'phu444', 0, 0);
INSERT INTO `user_connection` VALUES (46, 'phu555', 1, 103);

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
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (37, 'phu111', '$2y$10$trUJ3svarTRRvXgiRo.wxeXFAtEcUXO9npUoayOEnYNCFZ5Nd7aRa', 'Phu Thai');
INSERT INTO `users` VALUES (38, 'phu222', '$2y$10$vTfPJaIl5h2Hb3tmbKgI4O3Hr6CFkamx8TYLsNiqIMcbzkQSgrWzO', 'Ma Vy');
INSERT INTO `users` VALUES (39, 'phu333', '$2y$10$wd4QZAg4vbvBmOUkzvZk1.oqBcZlJwoKp14nvHbINZZKLBVKKMRqi', 'Zatan Ibrahimovic');
INSERT INTO `users` VALUES (41, 'phu444', '$2y$10$cjb0xTO2EMNfZaIMFX6l5eAUW2SOG9xlfKV7DcrOdhGXfmrXYnMmq', 'Tristance Pulisic');
INSERT INTO `users` VALUES (44, 'phu555', '$2y$10$efLfy6bQ3tq6W/mIcte7tu/.Et.2SMMv0RTJMbmbQ4YSdcwhYQjka', 'Bắp Bắp');

SET FOREIGN_KEY_CHECKS = 1;
