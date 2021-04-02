/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : train

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 02/04/2021 16:34:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_extension_histories
-- ----------------------------
DROP TABLE IF EXISTS `admin_extension_histories`;
CREATE TABLE `admin_extension_histories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_extension_histories_name_index`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_extensions
-- ----------------------------
DROP TABLE IF EXISTS `admin_extensions`;
CREATE TABLE `admin_extensions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` tinyint(4) NOT NULL DEFAULT 0,
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_extensions_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 13, 'Index', 'feather icon-bar-chart-2', '/', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (2, 0, 14, 'Admin', 'feather icon-settings', '', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (3, 2, 15, 'Users', '', 'auth/users', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (4, 2, 16, 'Roles', '', 'auth/roles', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (5, 2, 17, 'Permission', '', 'auth/permissions', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (6, 2, 18, 'Menu', '', 'auth/menu', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (7, 2, 19, 'Extensions', '', 'auth/extensions', '', 1, '2021-04-02 02:59:55', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (8, 0, 8, 'App配置', NULL, NULL, '', 1, '2021-04-02 03:24:25', '2021-04-02 07:22:49');
INSERT INTO `admin_menu` VALUES (9, 8, 9, 'APP版本', NULL, 'version', '', 1, '2021-04-02 03:24:40', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (10, 8, 10, '展示位', NULL, 'exhibition', '', 1, '2021-04-02 03:56:44', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (11, 18, 3, '行业管理', NULL, 'industry', '', 1, '2021-04-02 05:31:46', '2021-04-02 07:22:08');
INSERT INTO `admin_menu` VALUES (12, 18, 4, '职业管理', NULL, 'occupation', '', 1, '2021-04-02 05:48:07', '2021-04-02 07:22:08');
INSERT INTO `admin_menu` VALUES (13, 8, 11, '更新计划', NULL, 'update-plan', '', 1, '2021-04-02 06:17:03', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (14, 19, 7, '反馈', NULL, 'feedback', '', 1, '2021-04-02 06:45:01', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (15, 8, 12, '协议', NULL, 'agreement', '', 1, '2021-04-02 06:51:19', '2021-04-02 07:22:38');
INSERT INTO `admin_menu` VALUES (16, 18, 2, '机构管理', NULL, 'mechanism', '', 1, '2021-04-02 07:07:22', '2021-04-02 07:22:08');
INSERT INTO `admin_menu` VALUES (17, 18, 5, '学习资料', NULL, 'learning-material', '', 1, '2021-04-02 07:20:29', '2021-04-02 07:22:08');
INSERT INTO `admin_menu` VALUES (18, 0, 1, '基本设置', NULL, NULL, '', 1, '2021-04-02 07:21:02', '2021-04-02 07:21:10');
INSERT INTO `admin_menu` VALUES (19, 0, 6, '用户设置', NULL, NULL, '', 1, '2021-04-02 07:22:17', '2021-04-02 07:22:38');

-- ----------------------------
-- Table structure for admin_permission_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission_menu`;
CREATE TABLE `admin_permission_menu`  (
  `permission_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_permission_menu_permission_id_menu_id_unique`(`permission_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'Auth management', 'auth-management', '', '', 1, 0, '2021-04-02 02:59:55', NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Users', 'users', '', '/auth/users*', 2, 1, '2021-04-02 02:59:55', NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Roles', 'roles', '', '/auth/roles*', 3, 1, '2021-04-02 02:59:55', NULL);
INSERT INTO `admin_permissions` VALUES (4, 'Permissions', 'permissions', '', '/auth/permissions*', 4, 1, '2021-04-02 02:59:55', NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Menu', 'menu', '', '/auth/menu*', 5, 1, '2021-04-02 02:59:55', NULL);
INSERT INTO `admin_permissions` VALUES (6, 'Extension', 'extension', '', '/auth/extensions*', 6, 1, '2021-04-02 02:59:55', NULL);

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_menu_role_id_menu_id_unique`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_permissions_role_id_permission_id_unique`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_users_role_id_user_id_unique`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, '2021-04-02 02:59:55', '2021-04-02 02:59:55');

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2021-04-02 02:59:55', '2021-04-02 02:59:55');

-- ----------------------------
-- Table structure for admin_settings
-- ----------------------------
DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings`  (
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`slug`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$O4pCBjCwXp/9T/FwT5jWfu.MyEGhUvwjU88xN.3OMAYEbFdN6D3eO', 'Administrator', NULL, NULL, '2021-04-02 02:59:55', '2021-04-02 02:59:55');

-- ----------------------------
-- Table structure for agreement
-- ----------------------------
DROP TABLE IF EXISTS `agreement`;
CREATE TABLE `agreement`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `position` int(11) NOT NULL DEFAULT 0 COMMENT '位置',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agreement
-- ----------------------------
INSERT INTO `agreement` VALUES (1, '测试', 1, '<p>23232</p>', 1, '2021-04-02 06:57:27', '2021-04-02 06:57:27');

-- ----------------------------
-- Table structure for exhibition
-- ----------------------------
DROP TABLE IF EXISTS `exhibition`;
CREATE TABLE `exhibition`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `type` int(11) NOT NULL COMMENT '类型',
  `href_way` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转方式',
  `material_id` int(11) NULL DEFAULT NULL COMMENT '站内素材',
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '链接',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of exhibition
-- ----------------------------
INSERT INTO `exhibition` VALUES (1, '测试banner', 1, '1', 1, 'http://baidu.com', 1, 0, '2021-04-02 05:25:48', '2021-04-02 07:51:00');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系方式',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of feedback
-- ----------------------------
INSERT INTO `feedback` VALUES (1, '201301445555', '测试', '测试描述', '15728006876', '2021-04-02 06:46:01', '2021-04-02 06:46:01');

-- ----------------------------
-- Table structure for industry
-- ----------------------------
DROP TABLE IF EXISTS `industry`;
CREATE TABLE `industry`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '行业名字',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `sort` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of industry
-- ----------------------------
INSERT INTO `industry` VALUES (1, '测试行业', 1, '0', '2021-04-02 05:48:24', '2021-04-02 05:49:02');

-- ----------------------------
-- Table structure for learning_materials
-- ----------------------------
DROP TABLE IF EXISTS `learning_materials`;
CREATE TABLE `learning_materials`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '描述',
  `industry_id` int(11) NOT NULL COMMENT '行业',
  `occupation_id` int(11) NOT NULL COMMENT '职业',
  `mechanism_id` int(11) NOT NULL COMMENT '机构',
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '视频',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of learning_materials
-- ----------------------------
INSERT INTO `learning_materials` VALUES (1, '规章制度', NULL, 1, 1, 1, 'files/图片1.png', 1, 0, '2021-04-02 07:35:01', '2021-04-02 07:35:01');

-- ----------------------------
-- Table structure for mechanism
-- ----------------------------
DROP TABLE IF EXISTS `mechanism`;
CREATE TABLE `mechanism`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `social_credit_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '社会信用代码',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `deposit_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_card_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '银行卡号',
  `legal_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '法人',
  `id_card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '证件号码',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'status',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mechanism
-- ----------------------------
INSERT INTO `mechanism` VALUES (1, 'Pete Hoo', '232323232', '浙江宁波', '23232', '32323', '3232', '32323232323', '15728006876', 1, '2021-04-02 07:09:06', '2021-04-02 07:09:06');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_09_07_090635_create_admin_settings_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_09_22_015815_create_admin_extensions_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_11_01_083237_update_admin_menu_table', 1);
INSERT INTO `migrations` VALUES (8, '2021_04_02_032130_create_version_table', 2);
INSERT INTO `migrations` VALUES (9, '2021_04_02_035523_create_exhibition_table', 3);
INSERT INTO `migrations` VALUES (10, '2021_04_02_053023_create_industry_table', 4);
INSERT INTO `migrations` VALUES (11, '2021_04_02_054518_create_occupation_table', 5);
INSERT INTO `migrations` VALUES (12, '2021_04_02_061613_create_update_plan_table', 6);
INSERT INTO `migrations` VALUES (13, '2021_04_02_064354_create_feedback_table', 7);
INSERT INTO `migrations` VALUES (14, '2021_04_02_065026_create_agreement_table', 8);
INSERT INTO `migrations` VALUES (15, '2021_04_02_070654_create_mechanism_table', 9);
INSERT INTO `migrations` VALUES (16, '2021_04_02_071934_create_learning_materials_table', 10);

-- ----------------------------
-- Table structure for occupation
-- ----------------------------
DROP TABLE IF EXISTS `occupation`;
CREATE TABLE `occupation`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `industry_id` int(11) NOT NULL COMMENT '行业',
  `choice_question_num` int(11) NOT NULL DEFAULT 0 COMMENT '选择题数量',
  `choice_question_score` int(11) NOT NULL DEFAULT 0 COMMENT '选择题分数',
  `judgment_question_num` int(11) NOT NULL DEFAULT 0 COMMENT '判断题数量',
  `judgment_question_score` int(11) NOT NULL DEFAULT 0 COMMENT '判断题分数',
  `exam_time` int(11) NOT NULL DEFAULT 0 COMMENT '考试时长（分钟）',
  `passing_grade` int(11) NOT NULL DEFAULT 60 COMMENT '及格分',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of occupation
-- ----------------------------
INSERT INTO `occupation` VALUES (1, '程序员', 1, 10, 5, 10, 5, 90, 60, '2021-04-02 05:57:07', '2021-04-02 05:57:07');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for update_plan
-- ----------------------------
DROP TABLE IF EXISTS `update_plan`;
CREATE TABLE `update_plan`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL DEFAULT 0 COMMENT 'app名称',
  `md5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '加密',
  `download_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '下载链接',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '描述',
  `after_version` int(11) NOT NULL COMMENT '更新后版本',
  `before_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '更新前版本',
  `status` tinyint(4) NULL DEFAULT 0 COMMENT '状态',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of update_plan
-- ----------------------------
INSERT INTO `update_plan` VALUES (1, 1, NULL, NULL, NULL, 1, '1', 1, '2021-04-02 06:38:53', '2021-04-02 06:38:53');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for version
-- ----------------------------
DROP TABLE IF EXISTS `version`;
CREATE TABLE `version`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` int(10) NOT NULL DEFAULT 0 COMMENT '名称',
  `os` tinyint(4) NOT NULL COMMENT '终端（1-android 2-ios）',
  `version_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态(0-关闭 1-开启)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of version
-- ----------------------------
INSERT INTO `version` VALUES (1, 1, 1, '1.0.0', 1, '2021-04-02 03:34:04', '2021-04-02 06:09:50');

SET FOREIGN_KEY_CHECKS = 1;
