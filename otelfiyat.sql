/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : otelfiyat

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 05/03/2024 22:50:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for concepts
-- ----------------------------
DROP TABLE IF EXISTS `concepts`;
CREATE TABLE `concepts`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `room_id` int NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `open_for_sale` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of concepts
-- ----------------------------
INSERT INTO `concepts` VALUES (1, 1, 1, 500.10, 'Sadece Oda', 1);
INSERT INTO `concepts` VALUES (2, 1, 1, 600.50, 'Oda Kahvaltı', 0);
INSERT INTO `concepts` VALUES (3, 1, 1, 700.00, 'Yarım Pansiyon', 1);
INSERT INTO `concepts` VALUES (4, 1, 1, 800.00, 'Tam Pansiyon', 1);
INSERT INTO `concepts` VALUES (5, 1, 2, 700.00, 'Oda Kahvaltı', 1);
INSERT INTO `concepts` VALUES (6, 1, 2, 800.00, 'Tam Pansiyon', 1);
INSERT INTO `concepts` VALUES (7, 2, 4, 100.00, 'Sadece Oda', 1);
INSERT INTO `concepts` VALUES (8, 2, 5, 200.00, 'Tam Pansiyon', 1);
INSERT INTO `concepts` VALUES (9, 2, 6, 5000.00, 'Herşey Dahil', 1);
INSERT INTO `concepts` VALUES (10, 3, 7, 1500.00, 'Tam Pansiyon Plus', 1);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `since` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, 'Hakan Üşenmez', '2000-01-28');
INSERT INTO `customers` VALUES (2, 'Kaptan Devopuz', '2000-06-15');
INSERT INTO `customers` VALUES (3, 'Hikmet Daşcı', '2000-08-11');

-- ----------------------------
-- Table structure for hotels
-- ----------------------------
DROP TABLE IF EXISTS `hotels`;
CREATE TABLE `hotels`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hotels
-- ----------------------------
INSERT INTO `hotels` VALUES (1, 'May Thermal Resort Spa', 1);
INSERT INTO `hotels` VALUES (2, 'Susesi Luxury Resort', 2);
INSERT INTO `hotels` VALUES (3, 'Swissotel Büyük Efes İzmir', 3);

-- ----------------------------
-- Table structure for reservations
-- ----------------------------
DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `hotel_id` int NULL DEFAULT NULL,
  `room_id` int NULL DEFAULT NULL,
  `concept_id` int NULL DEFAULT NULL,
  `total_nights` int NULL DEFAULT NULL,
  `price_per_night` decimal(10, 2) NULL DEFAULT NULL,
  `total_price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reservations
-- ----------------------------
INSERT INTO `reservations` VALUES (23, 1, 1, 1, 1, 5, 500.10, 2500.50);

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES (1, 1, 'Deluxe Oda');
INSERT INTO `rooms` VALUES (2, 1, 'Superior Oda');
INSERT INTO `rooms` VALUES (3, 1, 'Family Oda');
INSERT INTO `rooms` VALUES (4, 2, 'Deluxe Oda Kara Manzara');
INSERT INTO `rooms` VALUES (5, 2, 'Deluxe Oda Deniz Manzara');
INSERT INTO `rooms` VALUES (6, 2, 'Klasik Oda Şehir Manzaralı');
INSERT INTO `rooms` VALUES (7, 3, 'Şehir Manzaralı Oda');

SET FOREIGN_KEY_CHECKS = 1;
