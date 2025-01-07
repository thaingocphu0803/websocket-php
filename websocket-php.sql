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

 Date: 07/01/2025 16:29:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for friend_request
-- ----------------------------
DROP TABLE IF EXISTS `friend_request`;
CREATE TABLE `friend_request`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stt` enum('pending','accepted','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_friend_sender`(`sender` ASC) USING BTREE,
  INDEX `fk_friend_receiver`(`receiver` ASC) USING BTREE,
  CONSTRAINT `fk_friend_receiver` FOREIGN KEY (`receiver`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_friend_sender` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of friend_request
-- ----------------------------
INSERT INTO `friend_request` VALUES (1, 'phu111', 'phu222', 'rejected', '2025-01-07 16:23:15');
INSERT INTO `friend_request` VALUES (2, 'phu111', 'phu333', 'pending', '2025-01-07 16:25:09');
INSERT INTO `friend_request` VALUES (3, 'phu111', 'phu444', 'rejected', '2025-01-07 16:25:10');

-- ----------------------------
-- Table structure for friends
-- ----------------------------
DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends`  (
  `int` int NOT NULL AUTO_INCREMENT,
  `user1` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user2` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stt` enum('A','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'A',
  PRIMARY KEY (`int`) USING BTREE,
  INDEX `fk_friend_user2`(`user2` ASC) USING BTREE,
  UNIQUE INDEX `unique_relationship`(`user1` ASC, `user2` ASC) USING BTREE,
  CONSTRAINT `fk_friend_user1` FOREIGN KEY (`user1`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_friend_user2` FOREIGN KEY (`user2`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of friends
-- ----------------------------
INSERT INTO `friends` VALUES (3, 'phu222', 'phu111', 'A');

-- ----------------------------
-- Table structure for images_message
-- ----------------------------
DROP TABLE IF EXISTS `images_message`;
CREATE TABLE `images_message`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `img_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_messsage_id`(`message_id` ASC) USING BTREE,
  CONSTRAINT `fk_messsage_id` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of images_message
-- ----------------------------
INSERT INTO `images_message` VALUES (43, 178, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwMTQ0OS9waHUxMTFfcGh1MjIyL3Zhd2pycG42bWtuOWd5Z2hjdGJsLnBuZw==');
INSERT INTO `images_message` VALUES (44, 178, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwMTQ1NC9waHUxMTFfcGh1MjIyL3J5anVycDR5NmRuam9sM3psYjRuLnBuZw==');
INSERT INTO `images_message` VALUES (45, 179, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwMTc0MC9waHUxMTFfcGh1MjIyL3ZyeDI1YjJicW02NmI1anhlbzBsLnBuZw==');
INSERT INTO `images_message` VALUES (46, 179, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwMTc0NC9waHUxMTFfcGh1MjIyL2Z5c3NudnlzdW44d2p6OGcxd21mLnBuZw==');
INSERT INTO `images_message` VALUES (47, 180, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwMzUzNS9waHUxMTFfcGh1MjIyL3RwMHpnZHp3bWxiNmk5eXVjcDR3LnBuZw==');
INSERT INTO `images_message` VALUES (48, 181, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNDkxNy9waHUxMTFfcGh1MjIyL2E0c2liZjFzc2ZjZnhycmN6djFnLnBuZw==');
INSERT INTO `images_message` VALUES (49, 183, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTMzNi9waHUxMTFfcGh1MjIyL3huY25waTh3enRodmVtNXk4aGpkLnBuZw==');
INSERT INTO `images_message` VALUES (50, 183, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM0MC9waHUxMTFfcGh1MjIyL2JndGdlMHplYWRjbzdzaXE4eGxvLnBuZw==');
INSERT INTO `images_message` VALUES (51, 183, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM0NC9waHUxMTFfcGh1MjIyL2kzdmd2dWNkNzh5dWF2ZGhnamVqLnBuZw==');
INSERT INTO `images_message` VALUES (52, 184, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM2MC9waHUxMTFfcGh1MjIyL2ZyYXF3cGVhMmNoNjduZmR3N2RrLnBuZw==');
INSERT INTO `images_message` VALUES (53, 185, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM3My9waHUxMTFfcGh1MjIyL294NnVnY2JhcHB2aGppandzdXcxLnBuZw==');
INSERT INTO `images_message` VALUES (54, 186, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM4NS9waHUxMTFfcGh1MjIyL21uY2o5a3Bla2o2cnA2bWpvYzVwLnBuZw==');
INSERT INTO `images_message` VALUES (55, 186, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM4OS9waHUxMTFfcGh1MjIyL3J2ZmpuNnAzd2NvOWp1c3JqcXNvLnBuZw==');
INSERT INTO `images_message` VALUES (56, 186, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTM5My9waHUxMTFfcGh1MjIyL3E1anRwaWc2bHBuNHE3NXhlaTBnLnBuZw==');
INSERT INTO `images_message` VALUES (57, 191, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTc3Mi9waHUyMjJfcGh1MzMzL2ZwcG1tc3hsMWVycGd1ZWptdHZlLnBuZw==');
INSERT INTO `images_message` VALUES (58, 191, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTc3Ni9waHUyMjJfcGh1MzMzL3gxZGRtbnZlaWMxenBnd3l5bHV2LnBuZw==');
INSERT INTO `images_message` VALUES (59, 194, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTkwNy9waHUyMjJfcGh1MzMzL2pzeHhhdXk3bDl2dmNpY2t1Y2JzLnBuZw==');
INSERT INTO `images_message` VALUES (60, 195, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTIwNTkxNi9waHUyMjJfcGh1MzMzL2RzbXpjYmtrb2hmam85aGxmYnF4LnBuZw==');
INSERT INTO `images_message` VALUES (61, 243, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI2NDUwNy9waHUxMTFfcGh1MjIyL2FmYXRrcjZnd2M5bnR0eHB0aXI2LnBuZw==');
INSERT INTO `images_message` VALUES (62, 243, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI2NDUxMi9waHUxMTFfcGh1MjIyL2I1ZmdsaHR4a3lpeWo0enh3YTdmLnBuZw==');
INSERT INTO `images_message` VALUES (63, 245, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI2NDcyMy9waHUxMTFfcGh1MjIyL2FzaTJvYmRmcnhocXJudHVnc2NhLnBuZw==');
INSERT INTO `images_message` VALUES (64, 245, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI2NDcyOC9waHUxMTFfcGh1MjIyL2hxaGZxZHYzMHk3aDB1Y2l5bmZ2LnBuZw==');
INSERT INTO `images_message` VALUES (65, 270, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI4MDIxMS9waHUxMTFfcGh1MjIyL2Y4aWgzcXUyZXRiaGQ2cGE0emN5LnBuZw==');
INSERT INTO `images_message` VALUES (66, 270, 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTI4MDIxNS9waHUxMTFfcGh1MjIyL2NlZXpjbGNkenB0ZmNiZjF5am13LnBuZw==');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `room` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mssg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sender` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_sender`(`sender` ASC) USING BTREE,
  INDEX `fk_room`(`room` ASC) USING BTREE,
  CONSTRAINT `FK_sender` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 274 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `messages` VALUES (176, 'phu111_phu222', 'beautifull', 'phu222', 'phu111', 'Y', '2024-12-26 15:18:31');
INSERT INTO `messages` VALUES (178, 'phu111_phu222', '', 'phu222', 'phu111', 'Y', '2024-12-26 15:24:15');
INSERT INTO `messages` VALUES (179, 'phu111_phu222', '', 'phu222', 'phu111', 'Y', '2024-12-26 15:29:05');
INSERT INTO `messages` VALUES (180, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-26 15:58:56');
INSERT INTO `messages` VALUES (181, 'phu111_phu222', 'hello', 'phu222', 'phu111', 'Y', '2024-12-26 16:21:58');
INSERT INTO `messages` VALUES (182, 'phu111_phu222', 'hello', 'phu111', 'phu222', 'Y', '2024-12-26 16:28:40');
INSERT INTO `messages` VALUES (183, 'phu111_phu222', '', 'phu111', 'phu222', 'Y', '2024-12-26 16:29:05');
INSERT INTO `messages` VALUES (184, 'phu111_phu222', 'hello', 'phu222', 'phu111', 'Y', '2024-12-26 16:29:21');
INSERT INTO `messages` VALUES (185, 'phu111_phu222', 'hello', 'phu222', 'phu111', 'Y', '2024-12-26 16:29:34');
INSERT INTO `messages` VALUES (186, 'phu111_phu222', 'hello', 'phu111', 'phu222', 'Y', '2024-12-26 16:29:54');
INSERT INTO `messages` VALUES (187, 'phu222_phu333', 'yo', 'phu333', 'phu222', 'Y', '2024-12-26 16:30:42');
INSERT INTO `messages` VALUES (188, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:31:54');
INSERT INTO `messages` VALUES (189, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:32:19');
INSERT INTO `messages` VALUES (190, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:35:55');
INSERT INTO `messages` VALUES (191, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:36:17');
INSERT INTO `messages` VALUES (192, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:37:53');
INSERT INTO `messages` VALUES (193, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:38:14');
INSERT INTO `messages` VALUES (194, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:38:28');
INSERT INTO `messages` VALUES (195, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:38:37');
INSERT INTO `messages` VALUES (196, 'phu222_phu333', 'hello', 'phu222', 'phu333', 'Y', '2024-12-26 16:39:12');
INSERT INTO `messages` VALUES (197, 'phu222_phu333', 'hello', 'phu222', 'phu333', 'Y', '2024-12-26 16:40:56');
INSERT INTO `messages` VALUES (198, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:41:23');
INSERT INTO `messages` VALUES (199, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:41:54');
INSERT INTO `messages` VALUES (200, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:43:39');
INSERT INTO `messages` VALUES (201, 'phu222_phu333', 'yo', 'phu222', 'phu333', 'Y', '2024-12-26 16:43:45');
INSERT INTO `messages` VALUES (202, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:43:52');
INSERT INTO `messages` VALUES (203, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:44:12');
INSERT INTO `messages` VALUES (204, 'phu222_phu333', 'helo', 'phu222', 'phu333', 'Y', '2024-12-26 16:46:14');
INSERT INTO `messages` VALUES (205, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:46:35');
INSERT INTO `messages` VALUES (206, 'phu222_phu333', 'hello', 'phu222', 'phu333', 'Y', '2024-12-26 16:47:05');
INSERT INTO `messages` VALUES (207, 'phu222_phu333', '', 'phu222', 'phu333', 'Y', '2024-12-26 16:47:12');
INSERT INTO `messages` VALUES (208, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:11:16');
INSERT INTO `messages` VALUES (209, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:12:02');
INSERT INTO `messages` VALUES (210, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:12:20');
INSERT INTO `messages` VALUES (211, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:12:36');
INSERT INTO `messages` VALUES (212, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:13:04');
INSERT INTO `messages` VALUES (213, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:13:22');
INSERT INTO `messages` VALUES (214, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:13:36');
INSERT INTO `messages` VALUES (215, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:13:50');
INSERT INTO `messages` VALUES (216, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:14:00');
INSERT INTO `messages` VALUES (217, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:14:17');
INSERT INTO `messages` VALUES (218, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:14:23');
INSERT INTO `messages` VALUES (219, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:15:24');
INSERT INTO `messages` VALUES (220, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:15:32');
INSERT INTO `messages` VALUES (221, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:15:46');
INSERT INTO `messages` VALUES (222, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:16:13');
INSERT INTO `messages` VALUES (223, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:18:07');
INSERT INTO `messages` VALUES (224, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:18:12');
INSERT INTO `messages` VALUES (225, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:25:03');
INSERT INTO `messages` VALUES (226, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:25:15');
INSERT INTO `messages` VALUES (227, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:25:23');
INSERT INTO `messages` VALUES (228, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:25:35');
INSERT INTO `messages` VALUES (229, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:25:47');
INSERT INTO `messages` VALUES (230, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:35:38');
INSERT INTO `messages` VALUES (231, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:36:26');
INSERT INTO `messages` VALUES (232, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:36:33');
INSERT INTO `messages` VALUES (233, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:36:47');
INSERT INTO `messages` VALUES (234, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:45:07');
INSERT INTO `messages` VALUES (235, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:45:34');
INSERT INTO `messages` VALUES (236, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:45:47');
INSERT INTO `messages` VALUES (237, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:45:59');
INSERT INTO `messages` VALUES (238, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:46:10');
INSERT INTO `messages` VALUES (239, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:46:24');
INSERT INTO `messages` VALUES (240, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:50:30');
INSERT INTO `messages` VALUES (241, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:50:39');
INSERT INTO `messages` VALUES (242, 'phu111_phu222', 'YO', 'phu222', 'phu111', 'Y', '2024-12-27 08:54:45');
INSERT INTO `messages` VALUES (243, 'phu111_phu222', 's', 'phu111', 'phu222', 'Y', '2024-12-27 08:55:13');
INSERT INTO `messages` VALUES (244, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 08:56:49');
INSERT INTO `messages` VALUES (245, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 08:58:49');
INSERT INTO `messages` VALUES (246, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 09:20:50');
INSERT INTO `messages` VALUES (247, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:21:09');
INSERT INTO `messages` VALUES (248, 'phu111_phu222', 'YO', 'phu111', 'phu222', 'Y', '2024-12-27 09:24:30');
INSERT INTO `messages` VALUES (249, 'phu111_phu222', 'YO', 'phu111', 'phu222', 'Y', '2024-12-27 09:24:38');
INSERT INTO `messages` VALUES (250, 'phu111_phu222', 'YO', 'phu111', 'phu222', 'Y', '2024-12-27 09:24:43');
INSERT INTO `messages` VALUES (251, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:39:55');
INSERT INTO `messages` VALUES (252, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:40:04');
INSERT INTO `messages` VALUES (253, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:40:14');
INSERT INTO `messages` VALUES (254, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:41:37');
INSERT INTO `messages` VALUES (255, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:41:51');
INSERT INTO `messages` VALUES (256, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 09:43:10');
INSERT INTO `messages` VALUES (257, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 09:45:33');
INSERT INTO `messages` VALUES (258, 'phu111_phu222', 'you', 'phu111', 'phu222', 'Y', '2024-12-27 09:47:35');
INSERT INTO `messages` VALUES (259, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 10:23:07');
INSERT INTO `messages` VALUES (260, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 10:23:14');
INSERT INTO `messages` VALUES (261, 'phu111_phu222', 'YO', 'phu222', 'phu111', 'Y', '2024-12-27 11:39:02');
INSERT INTO `messages` VALUES (262, 'phu111_phu222', 'YO', 'phu111', 'phu222', 'Y', '2024-12-27 11:39:09');
INSERT INTO `messages` VALUES (263, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 11:48:34');
INSERT INTO `messages` VALUES (264, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 11:49:22');
INSERT INTO `messages` VALUES (265, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 11:50:04');
INSERT INTO `messages` VALUES (266, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 11:50:32');
INSERT INTO `messages` VALUES (267, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 11:50:43');
INSERT INTO `messages` VALUES (268, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2024-12-27 11:52:28');
INSERT INTO `messages` VALUES (269, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2024-12-27 11:52:35');
INSERT INTO `messages` VALUES (270, 'phu111_phu222', '', 'phu111', 'phu222', 'Y', '2024-12-27 13:16:57');
INSERT INTO `messages` VALUES (271, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2025-01-02 09:08:51');
INSERT INTO `messages` VALUES (272, 'phu111_phu222', 'yo', 'phu111', 'phu222', 'Y', '2025-01-02 09:10:32');
INSERT INTO `messages` VALUES (273, 'phu111_phu222', 'yo', 'phu222', 'phu111', 'Y', '2025-01-02 09:14:20');

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
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES (24, 'phu333', 'phu222_phu333', 'A', 'phu222', '2025-01-03 11:27:23');
INSERT INTO `rooms` VALUES (25, 'phu222', 'phu111_phu222', 'X', 'phu111', '2025-01-03 11:25:54');
INSERT INTO `rooms` VALUES (26, 'phu111', 'phu111_phu222', 'X', 'phu222', '2025-01-07 11:02:47');
INSERT INTO `rooms` VALUES (27, 'phu444', 'phu111_phu444', 'X', 'phu111', '2024-12-24 14:53:01');
INSERT INTO `rooms` VALUES (28, 'phu555', 'phu111_phu555', 'A', 'phu111', '2024-12-25 08:18:46');

-- ----------------------------
-- Table structure for user_avatar
-- ----------------------------
DROP TABLE IF EXISTS `user_avatar`;
CREATE TABLE `user_avatar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_avatar
-- ----------------------------
INSERT INTO `user_avatar` VALUES (1, 'phu222', 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTg3NzY2OS9hdmF0YXIvcGh1MjIyL2MyaGN6bm9tdmY1bXhrc2lscmtqLmpwZw==');
INSERT INTO `user_avatar` VALUES (2, 'phu333', 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNTg3ODQzNy9hdmF0YXIvcGh1MzMzL2RxaXhhYmd3OWtvZjdhbHV4dmRkLndlYnA=');
INSERT INTO `user_avatar` VALUES (3, 'phu111', 'aHR0cHM6Ly9yZXMuY2xvdWRpbmFyeS5jb20vY29ybi1jaGF0L2ltYWdlL3VwbG9hZC92MTczNjEzMzM1Ny9hdmF0YXIvcGh1MTExL2FtZHJlMnd6aHhxc2J6dW9ndGNnLmpwZw==');

-- ----------------------------
-- Table structure for user_connection
-- ----------------------------
DROP TABLE IF EXISTS `user_connection`;
CREATE TABLE `user_connection`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_online` tinyint(1) NOT NULL,
  `connection_id` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username` ASC) USING BTREE,
  CONSTRAINT `user_connection_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_connection
-- ----------------------------
INSERT INTO `user_connection` VALUES (40, 'phu111', 0, 0, '2025-01-02 09:16:36');
INSERT INTO `user_connection` VALUES (41, 'phu222', 1, 99, '2025-01-02 09:14:07');
INSERT INTO `user_connection` VALUES (42, 'phu333', 0, 0, '2024-12-26 16:34:52');
INSERT INTO `user_connection` VALUES (44, 'phu444', 0, 0, NULL);
INSERT INTO `user_connection` VALUES (46, 'phu555', 0, 0, NULL);

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
INSERT INTO `users` VALUES (37, 'phu111', '$2y$10$RuRJir2pxX8EK.TynKos2uE6HwpYjIfJno0t/0UsZvcF90sJVpHMi', 'Phu Thai');
INSERT INTO `users` VALUES (38, 'phu222', '$2y$10$q9N2IagSMfXgYy7PwS4O3.OLzZk76z5tHX9pZeigUQ.NnzLZnULvm', 'Mã Vy');
INSERT INTO `users` VALUES (39, 'phu333', '$2y$10$wd4QZAg4vbvBmOUkzvZk1.oqBcZlJwoKp14nvHbINZZKLBVKKMRqi', 'Zatan Ibrahimovic');
INSERT INTO `users` VALUES (41, 'phu444', '$2y$10$cjb0xTO2EMNfZaIMFX6l5eAUW2SOG9xlfKV7DcrOdhGXfmrXYnMmq', 'Tristance Pulisic');
INSERT INTO `users` VALUES (44, 'phu555', '$2y$10$efLfy6bQ3tq6W/mIcte7tu/.Et.2SMMv0RTJMbmbQ4YSdcwhYQjka', 'Bắp Bắp');

SET FOREIGN_KEY_CHECKS = 1;
