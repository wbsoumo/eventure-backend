-- Eventure CMS MySQL Database Dump
-- Generated: 2026-11-12 22:08:25

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'superadmin',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES ('1', 'Eventure Admin', 'admin@myeventure.in', '$2y$12$y0OyNLwuxnYE8KniT1lQTOr.yghyKho2UwluEi0t9QUavwcmsQ2um', 'superadmin', '2026-11-13 03:37:39', '2026-11-13 03:37:39');

DROP TABLE IF EXISTS `enquiries`;
CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `event_type` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `target_date` varchar(100) DEFAULT NULL,
  `guests` varchar(50) DEFAULT NULL,
  `budget` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL DEFAULT 'general',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('1', 'general', 'Which cities and destinations do you work in?', 'We are headquartered in Salt Lake Sector V, Kolkata and work pan-India. Our destination wedding work is concentrated in Udaipur, Jaipur, Jodhpur, Goa, Kerala and Bengal\'s heritage rajbaris, and our corporate productions regularly take us across Kolkata, Mumbai, Delhi NCR, Bengaluru, and Hyderabad.', '1', '1');
INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('2', 'general', 'How far in advance should we book?', 'For a multi-day destination wedding we recommend six to twelve months, largely because the best heritage venues and artists are booked that far ahead. Corporate events typically need eight to sixteen weeks, though we have delivered large-format launches in less.', '2', '1');
INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('3', 'general', 'Do you take on full planning, or only execution?', 'Both. Most clients engage us end to end: concept, design, vendor curation, production and on-ground execution. We also take on production-only or on-ground-management-only mandates where an in-house team has already built the master plan.', '3', '1');
INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('4', 'general', 'What kind of budgets do you work with?', 'We work across a wide range and will tell you honestly at the first conversation whether your budget and your ambition are aligned. What we do not do is accept a brief we cannot deliver to our own luxury standard.', '4', '1');
INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('5', 'general', 'Will we work with your senior team directly?', 'Yes. Senior-level involvement is a deliberate part of how Eventure operates: the people who take your brief are the people on the ground directing the show on the day.', '5', '1');
INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `display_order`, `is_active`) VALUES ('6', 'general', 'Can you keep our event confidential?', 'Yes. A significant share of our work is for prominent families, business leaders, and listed brands. Discretion is standard practice — non-disclosure agreements are routine, and we never publish without written permission.', '6', '1');

DROP TABLE IF EXISTS `gallery_photos`;
CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `aspect_ratio` varchar(50) NOT NULL DEFAULT 'landscape',
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('1', 'Pudhari Maha Summit 01', 'corporate', '/images/gallery/pudhari-maha-summit-01.webp', NULL, 'landscape', '1', '1', '2026-11-13 03:37:48');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('2', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-03.webp', NULL, 'landscape', '2', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('3', 'Phere setup, Eventure', 'weddings', '/images/gallery/thumb/phere-setup-05.webp', NULL, 'landscape', '3', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('4', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-01.webp', NULL, 'landscape', '4', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('5', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-03.webp', NULL, 'landscape', '5', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('6', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-01.webp', NULL, 'landscape', '6', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('7', 'Haldi stage, Eventure', 'weddings', '/images/gallery/thumb/haldi-stage-01.webp', NULL, 'landscape', '7', '1', '2026-11-13 03:37:49');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('8', 'Phere setup, Eventure', 'weddings', '/images/gallery/thumb/phere-setup-01.webp', NULL, 'landscape', '8', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('9', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-01.webp', NULL, 'landscape', '9', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('10', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-02.webp', NULL, 'landscape', '10', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('11', 'Phere setup, Eventure', 'weddings', '/images/gallery/thumb/phere-setup-02.webp', NULL, 'landscape', '11', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('12', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-02.webp', NULL, 'landscape', '12', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('13', 'Phere setup, Eventure', 'weddings', '/images/gallery/thumb/phere-setup-03.webp', NULL, 'landscape', '13', '1', '2026-11-13 03:37:50');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('14', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-03.webp', NULL, 'landscape', '14', '1', '2026-11-13 03:37:51');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('15', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-04.webp', NULL, 'landscape', '15', '1', '2026-11-13 03:37:51');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('16', 'Phere setup, Eventure', 'weddings', '/images/gallery/thumb/phere-setup-04.webp', NULL, 'landscape', '16', '1', '2026-11-13 03:37:51');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('17', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-04.webp', NULL, 'landscape', '17', '1', '2026-11-13 03:37:51');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('18', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-04.webp', NULL, 'landscape', '18', '1', '2026-11-13 03:37:51');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('19', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-05.webp', NULL, 'landscape', '19', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('20', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-05.webp', NULL, 'landscape', '20', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('21', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-05.webp', NULL, 'landscape', '21', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('22', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-06.webp', NULL, 'landscape', '22', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('23', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-06.webp', NULL, 'landscape', '23', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('24', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-06.webp', NULL, 'landscape', '24', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('25', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-07.webp', NULL, 'landscape', '25', '1', '2026-11-13 03:37:52');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('26', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-07.webp', NULL, 'landscape', '26', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('27', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-08.webp', NULL, 'landscape', '27', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('28', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-08.webp', NULL, 'landscape', '28', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('29', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-08.webp', NULL, 'landscape', '29', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('30', 'Carnival-theme sangeet, Eventure', 'sangeet', '/images/gallery/thumb/carnival-sangeet-09.webp', NULL, 'landscape', '30', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('31', 'Sangeet night, Eventure', 'sangeet', '/images/gallery/thumb/sangeet-night-09.webp', NULL, 'landscape', '31', '1', '2026-11-13 03:37:53');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('32', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-09.webp', NULL, 'landscape', '32', '1', '2026-11-13 03:37:54');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('33', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-10.webp', NULL, 'landscape', '33', '1', '2026-11-13 03:37:54');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('34', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-11.webp', NULL, 'landscape', '34', '1', '2026-11-13 03:37:54');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('35', 'Wedding décor, Eventure', 'weddings', '/images/gallery/thumb/wedding-decor-12.webp', NULL, 'landscape', '35', '1', '2026-11-13 03:37:54');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('36', 'NDTV, The Future Summit, Eventure', 'corporate', '/images/gallery/thumb/ndtv-future-summit-01.webp', NULL, 'landscape', '36', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('37', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-01.webp', NULL, 'landscape', '37', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('38', 'Zee 24 Taas, Diwali Pahat, Eventure', 'decor', '/images/gallery/thumb/zee24-diwali-01.webp', NULL, 'landscape', '38', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('39', 'Pudhari Maha Icon, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-icon-01.webp', NULL, 'landscape', '39', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('40', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-01.webp', NULL, 'landscape', '40', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('41', 'Zee 24 Taas, Krushi Samman, Eventure', 'decor', '/images/gallery/thumb/zee24-krushi-samman-03.webp', NULL, 'landscape', '41', '1', '2026-11-13 03:37:55');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('42', 'Zee PHH, Pride of Malwa, Eventure', 'corporate', '/images/gallery/thumb/zee-pride-of-malwa-03.webp', NULL, 'landscape', '42', '1', '2026-11-13 03:37:56');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('43', 'Zee MPCG, Indore, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-indore-01.webp', NULL, 'landscape', '43', '1', '2026-11-13 03:37:56');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('44', 'Pudhari News, Solapur, Eventure', 'decor', '/images/gallery/thumb/pudhari-solapur-01.webp', NULL, 'landscape', '44', '1', '2026-11-13 03:37:56');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('45', 'UltraTech, ICC Awards, Nagpur, Eventure', 'corporate', '/images/gallery/thumb/ultratech-icc-nagpur-01.webp', NULL, 'landscape', '45', '1', '2026-11-13 03:37:56');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('46', 'Zee MPCG, Bhopal, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-bhopal-01.webp', NULL, 'landscape', '46', '1', '2026-11-13 03:37:56');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('47', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-02.webp', NULL, 'landscape', '47', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('48', 'Zee PHH, Pride of Malwa, Eventure', 'corporate', '/images/gallery/thumb/zee-pride-of-malwa-01.webp', NULL, 'landscape', '48', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('49', 'Pudhari Maha Icon, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-icon-02.webp', NULL, 'landscape', '49', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('50', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-02.webp', NULL, 'landscape', '50', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('51', 'Pudhari News, Solapur, Eventure', 'decor', '/images/gallery/thumb/pudhari-solapur-02.webp', NULL, 'landscape', '51', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('52', 'UltraTech, ICC Awards, Nagpur, Eventure', 'corporate', '/images/gallery/thumb/ultratech-icc-nagpur-02.webp', NULL, 'landscape', '52', '1', '2026-11-13 03:37:57');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('53', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-02.webp', NULL, 'landscape', '53', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('54', 'Zee MPCG, Bhopal, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-bhopal-02.webp', NULL, 'landscape', '54', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('55', 'Zee MPCG, Indore, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-indore-02.webp', NULL, 'landscape', '55', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('56', 'Zee 24 Taas, Diwali Pahat, Eventure', 'decor', '/images/gallery/thumb/zee24-diwali-02.webp', NULL, 'landscape', '56', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('57', 'Zee 24 Taas, Krushi Samman, Eventure', 'decor', '/images/gallery/thumb/zee24-krushi-samman-02.webp', NULL, 'landscape', '57', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('58', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-03.webp', NULL, 'landscape', '58', '1', '2026-11-13 03:37:58');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('59', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-03.webp', NULL, 'landscape', '59', '1', '2026-11-13 03:37:59');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('60', 'Pudhari News, Solapur, Eventure', 'decor', '/images/gallery/thumb/pudhari-solapur-03.webp', NULL, 'landscape', '60', '1', '2026-11-13 03:37:59');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('61', 'UltraTech, ICC Awards, Nagpur, Eventure', 'corporate', '/images/gallery/thumb/ultratech-icc-nagpur-03.webp', NULL, 'landscape', '61', '1', '2026-11-13 03:37:59');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('62', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-03.webp', NULL, 'landscape', '62', '1', '2026-11-13 03:38:00');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('63', 'Zee MPCG, Bhopal, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-bhopal-03.webp', NULL, 'landscape', '63', '1', '2026-11-13 03:38:00');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('64', 'Zee MPCG, Indore, Eventure', 'decor', '/images/gallery/thumb/zee-mpcg-indore-03.webp', NULL, 'landscape', '64', '1', '2026-11-13 03:38:00');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('65', 'Zee 24 Taas, Diwali Pahat, Eventure', 'decor', '/images/gallery/thumb/zee24-diwali-03.webp', NULL, 'landscape', '65', '1', '2026-11-13 03:38:00');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('66', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-04.webp', NULL, 'landscape', '66', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('67', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-04.webp', NULL, 'landscape', '67', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('68', 'Pudhari News, Solapur, Eventure', 'decor', '/images/gallery/thumb/pudhari-solapur-04.webp', NULL, 'landscape', '68', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('69', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-04.webp', NULL, 'landscape', '69', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('70', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-05.webp', NULL, 'landscape', '70', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('71', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-05.webp', NULL, 'landscape', '71', '1', '2026-11-13 03:38:01');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('72', 'Pudhari News, Solapur, Eventure', 'decor', '/images/gallery/thumb/pudhari-solapur-05.webp', NULL, 'landscape', '72', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('73', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-05.webp', NULL, 'landscape', '73', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('74', 'Kotak Neo, Kona Kona Investor, Eventure', 'corporate', '/images/gallery/thumb/kotak-kona-investor-06.webp', NULL, 'landscape', '74', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('75', 'Zee PHH, Pride of Malwa, Eventure', 'corporate', '/images/gallery/thumb/zee-pride-of-malwa-04.webp', NULL, 'landscape', '75', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('76', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-06.webp', NULL, 'landscape', '76', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('77', 'UltraTech, Solapur, Eventure', 'decor', '/images/gallery/thumb/ultratech-solapur-06.webp', NULL, 'landscape', '77', '1', '2026-11-13 03:38:02');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('78', 'NDTV, The Future Summit, Eventure', 'corporate', '/images/gallery/thumb/ndtv-future-summit-07.webp', NULL, 'landscape', '78', '1', '2026-11-13 03:38:03');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('79', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-07.webp', NULL, 'landscape', '79', '1', '2026-11-13 03:38:03');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('80', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-08.webp', NULL, 'landscape', '80', '1', '2026-11-13 03:38:03');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('81', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-09.webp', NULL, 'landscape', '81', '1', '2026-11-13 03:38:03');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('82', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-10.webp', NULL, 'landscape', '82', '1', '2026-11-13 03:38:04');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('83', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-11.webp', NULL, 'landscape', '83', '1', '2026-11-13 03:38:04');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('84', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-12.webp', NULL, 'landscape', '84', '1', '2026-11-13 03:38:04');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('85', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-13.webp', NULL, 'landscape', '85', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('86', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-14.webp', NULL, 'landscape', '86', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('87', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-15.webp', NULL, 'landscape', '87', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('88', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-16.webp', NULL, 'landscape', '88', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('89', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-17.webp', NULL, 'landscape', '89', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('90', 'Pudhari Maha Summit, Trident, Eventure', 'corporate', '/images/gallery/thumb/pudhari-maha-summit-18.webp', NULL, 'landscape', '90', '1', '2026-11-13 03:38:05');
INSERT INTO `gallery_photos` (`id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio`, `display_order`, `is_active`, `created_at`) VALUES ('91', 'Photo 1571896349842 33C89424De2D?Auto=Format&Fit=Crop&Q=68&W=1900', 'decor', 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&q=68&w=1900', NULL, 'landscape', '91', '1', '2026-11-13 03:38:06');

DROP TABLE IF EXISTS `nav_items`;
CREATE TABLE `nav_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL,
  `num_prefix` varchar(10) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('1', 'Home', '/', '01', '1', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('2', 'Weddings', '/weddings', '02', '2', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('3', 'Corporate', '/corporate', '03', '3', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('4', 'Portfolio', '/portfolio', '04', '4', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('5', 'Gallery', '/gallery', '05', '5', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('6', 'About', '/about', '06', '6', '1');
INSERT INTO `nav_items` (`id`, `name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES ('7', 'Contact', '/contact', '07', '7', '1');

DROP TABLE IF EXISTS `page_sections`;
CREATE TABLE `page_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(50) NOT NULL,
  `section_key` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `content_json` longtext NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_section_idx` (`page_slug`,`section_key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `page_sections` (`id`, `page_slug`, `section_key`, `title`, `subtitle`, `content_json`, `display_order`, `updated_at`) VALUES ('1', 'home', 'stats', 'Key Metrics', NULL, '[{\"value\":\"Pan India \\/ Global\",\"label\":\"Reach\"},{\"value\":\"10+ Years\",\"label\":\"Experience\"},{\"value\":\"250+\",\"label\":\"Weddings Produced\"},{\"value\":\"150+\",\"label\":\"Corporate Summits\"}]', '0', '2026-11-13 03:37:44');
INSERT INTO `page_sections` (`id`, `page_slug`, `section_key`, `title`, `subtitle`, `content_json`, `display_order`, `updated_at`) VALUES ('2', 'home', 'capabilities', 'A full-service event house', NULL, '[{\"num\":\"01\",\"title\":\"Concept & Creative Design\",\"desc\":\"Themes, narrative arcs, stage and set design, 3D visualisation \\u2014 the idea before the invoice.\"},{\"num\":\"02\",\"title\":\"D\\u00e9cor & Floral Artistry\",\"desc\":\"Bespoke installations, floral architecture and lighting built by our own master production partners.\"},{\"num\":\"03\",\"title\":\"Venue & Vendor Curation\",\"desc\":\"Access to India\'s premier palaces, resorts, luxury hotels and convention centres, negotiated on your behalf.\"},{\"num\":\"04\",\"title\":\"Production & Technical\",\"desc\":\"Sound, light, LED, rigging, AV and show-calling to international broadcast standards.\"},{\"num\":\"05\",\"title\":\"Celebrity & Artist Management\",\"desc\":\"Headline performers, anchors, emcees and world-class entertainment curated and contracted end to end.\"},{\"num\":\"06\",\"title\":\"Guest & Hospitality Management\",\"desc\":\"Arrivals, VIP accommodation, chartered transfers, RSVP desks and dedicated 24\\/7 guest concierges.\"},{\"num\":\"07\",\"title\":\"Premium Catering Direction\",\"desc\":\"Curated culinary concepts with India\'s elite master chefs, artisanal live stations and royal service.\"},{\"num\":\"08\",\"title\":\"Cinematography & Content\",\"desc\":\"Cinematic 4K reels, live broadcast feeds, and editorial photography capturing every fleeting moment.\"}]', '0', '2026-11-13 03:37:44');
INSERT INTO `page_sections` (`id`, `page_slug`, `section_key`, `title`, `subtitle`, `content_json`, `display_order`, `updated_at`) VALUES ('3', 'about', 'differences', 'Why hosts come back', NULL, '[{\"title\":\"A pan-India network money can\\u2019t buy\",\"desc\":\"Deep, long-standing relationships with India\\u2019s premier venues, caterers, d\\u00e9cor houses, production partners and artists.\"},{\"title\":\"White-glove hospitality\",\"desc\":\"From arrival logistics and accommodation to in-event hospitality teams, every guest touchpoint is managed with five-star precision.\"},{\"title\":\"Senior-level involvement\",\"desc\":\"You work with our senior team directly, from the first brief to the final farewell. No hand-offs to junior coordinators.\"},{\"title\":\"Flawless execution, every time\",\"desc\":\"We plan for every contingency, rehearse every detail and coordinate in real time, so complex production appears effortless.\"},{\"title\":\"International standards, an Indian soul\",\"desc\":\"A design sensibility drawn from global luxury benchmarks, interpreted through a distinctly Indian understanding of celebration.\"},{\"title\":\"Discretion and trust\",\"desc\":\"Many of our clients are high-profile families and public brands. We protect their privacy as carefully as we protect the quality of their event.\"}]', '0', '2026-11-13 03:37:44');
INSERT INTO `page_sections` (`id`, `page_slug`, `section_key`, `title`, `subtitle`, `content_json`, `display_order`, `updated_at`) VALUES ('4', 'about', 'steps', 'A simple, proven journey', NULL, '[{\"num\":\"01\",\"title\":\"We Listen\",\"desc\":\"A single conversation to understand the vision, the scale, the budget and the feeling you want people to leave with.\"},{\"num\":\"02\",\"title\":\"We Design\",\"desc\":\"Concepts, themes, floor plans, production plans and timelines. You see the event before it exists.\"},{\"num\":\"03\",\"title\":\"We Execute\",\"desc\":\"Our senior team takes over the ground. Vendors, rehearsals, contingencies and real-time show calling.\"},{\"num\":\"04\",\"title\":\"We Obsess\",\"desc\":\"We stay until the last guest leaves. The details at the end matter as much as the grand reveal at the beginning.\"}]', '0', '2026-11-13 03:37:44');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `eyebrow` varchar(150) NOT NULL,
  `hero_title` text NOT NULL,
  `hero_subtitle` text NOT NULL,
  `hero_image` varchar(255) NOT NULL,
  `cta_eyebrow` varchar(150) DEFAULT NULL,
  `cta_title` text DEFAULT NULL,
  `cta_subtitle` text DEFAULT NULL,
  `cta_btn_text` varchar(100) DEFAULT NULL,
  `cta_btn_link` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('1', 'home', 'Home', 'Luxury Weddings · Corporate Events · Pan India / Global', 'Where vision\nbecomes an\nexperience.', 'For more than a decade, India’s most discerning families and brands have trusted Eventure with the occasions that truly matter — designed with ambition, executed without a single visible seam.', '/images/udaipur-lake-palace-couple.webp', 'Begin a Conversation', 'If you are planning something that truly matters, we would be honoured to bring it to life.', 'Tell us the date, the city, and the feeling you want people to leave with. We will take it from there.', 'Start an Enquiry', '/contact', '2026-11-13 03:37:42');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('2', 'weddings', 'Luxury Weddings', 'Destination & Bespoke Celebrations', 'Vows, rituals &\nevening revelry.', 'From heritage rajbaris in Bengal and lakeside palaces in Udaipur to barefoot coastal vows in Goa, we curate destination weddings that linger in memory for a lifetime.', '/images/wedding-ceremony-confetti.webp', 'Wedding Inquiries', 'Let’s plan your wedding of a lifetime.', 'Tell us your dream destination, dates, and vision. Our senior planners will guide you through every detail.', 'Enquire Now', '/contact', '2026-11-13 03:37:43');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('3', 'corporate', 'Corporate Events', 'Conferences, Launches & Summits', 'Flawless staging,\nbroadcast precision.', 'Large-format summits, high-stakes brand reveals, and investor meets engineered to broadcast standards with impeccable delegate hospitality.', '/images/summit-audience.webp', 'Corporate Mandates', 'Host an event that defines your brand’s year.', 'Engage our senior production leads for complete AV engineering, stagecraft, and delegate operations.', 'Brief Our Team', '/contact', '2026-11-13 03:37:43');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('4', 'portfolio', 'Signature Portfolio', 'Selected Works', 'A decade of\nextraordinary moments.', 'Browse our curated collection of palatial weddings, global brand conferences, and bespoke celebrations executed across India.', '/images/unsplash/photo-1508997449629-303059a039c0.jpg', 'Collaborate', 'Ready to create your next landmark event?', 'We limit our active mandates each season to guarantee senior-level involvement on ground.', 'Schedule a Consultation', '/contact', '2026-11-13 03:37:43');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('5', 'gallery', 'Visual Gallery', 'Eventure Archive', 'Through the lens of\nluxury & grandeur.', 'An unfiltered photographic archive of sets, moments, and stage productions captured across India.', '/images/gallery/pudhari-maha-summit-01.webp', 'Experience Eventure', 'Want to see more bespoke concepts?', 'Visit our studio in Salt Lake Sector V, Kolkata, or request our confidential lookbook.', 'Get in Touch', '/contact', '2026-11-13 03:37:43');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('6', 'about', 'About Eventure', 'About Eventure', 'Equal parts\nart and precision.', 'A luxury event house headquartered in Kolkata, creating extraordinary weddings, corporate showcases and bespoke celebrations across India.', '/images/unsplash/photo-1519167758481-83f550bb49b3.jpg', 'Kolkata Studio', 'If you are planning something that truly matters, we would be honoured to bring it to life.', 'Tell us the date, the city and the feeling you want people to leave with. We will take it from there.', 'Start an Enquiry', '/contact', '2026-11-13 03:37:43');
INSERT INTO `pages` (`id`, `slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`, `updated_at`) VALUES ('7', 'contact', 'Contact & Enquiries', 'Contact & Enquiries', 'Let’s begin with\na conversation.', 'Tell us the occasion, the date and the feeling you want people to leave with. Every enquiry is read by a senior member of our team and answered within one working day.', '/images/unsplash/photo-1744805624890-9931ebb50428.jpg', 'Direct Line', 'Prefer a phone call or WhatsApp?', 'Reach our Kolkata studio directly on +91 97483 28654.', 'WhatsApp Now', 'https://wa.me/919748328654', '2026-11-13 03:37:43');

DROP TABLE IF EXISTS `portfolio_events`;
CREATE TABLE `portfolio_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `client` varchar(150) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `location` varchar(150) NOT NULL,
  `scope` varchar(255) NOT NULL,
  `stats` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) NOT NULL,
  `gallery_images` longtext DEFAULT NULL,
  `summary` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Palace Wedding Spectacle', 'palace-wedding-spectacle', 'Wedding', 'Private Family', '2025', 'Udaipur & Kolkata', 'Creative Direction, Production, Guest Logistics & Hospitality', '3 Days · 450 Guests · Palace Takeover', '/images/wedding-ceremony-confetti.webp', NULL, 'A lakeside palace taken over for three days, mandap, sangeet, and a reception staged across two courtyards, with 450 guests flown in and hosted end to end.', 'From the private boat transfers across mirror-still waters to the starlit sangeet under cascading crystal chandeliers, every hour was choreographed to perfection.', '1', '1', '1', '2026-11-13 03:37:45', '2026-11-13 03:37:45');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'National Brand Summit', 'national-brand-summit', 'Corporate', 'Leading National Media Group', '2025', 'Kolkata & Mumbai', 'Broadcast Stage, AV Engineering, VIP Protocol', '2 Days · 1,200 Delegates · Live Broadcast', '/images/kotak-neo-kona-kona-investor.jpeg', NULL, 'A two-day flagship summit for a national media house, main stage production, four breakout tracks, live broadcast feed and full delegate management.', 'Seamless multi-track audio engineering, 65-foot curved LED backdrop, and real-time broadcast switching reaching 5M+ viewers.', '1', '2', '1', '2026-11-13 03:37:45', '2026-11-13 03:37:45');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Annual Awards Night', 'annual-awards-night', 'Corporate', 'Apex Industrial Council', '2024', 'Kolkata', 'Stage Design, Rigging, Show-Calling, Red Carpet', '1 Evening · 600 Leaders · Live Orchestration', '/images/zee24-krushi-samman-hall.webp', NULL, 'Black-tie gala for industry leaders with dynamic lighting choreography, custom trophies, and headline live performances.', 'A bespoke black-tie dinner featuring synchronized theatrical lighting, live symphonic performances, and high-impact award presentations.', '1', '3', '1', '2026-11-13 03:37:46', '2026-11-13 03:37:46');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Heritage Fort Celebrations', 'heritage-fort-celebrations', 'Wedding', 'Royal Families', '2024', 'Jaipur', 'Historical Preservation Compliance, Kinetic Stage, Hospitality', '3 Days · 350 Guests · Rampart Illumination', '/images/haldi-mandap-marigold.webp', NULL, 'Centuries-old ramparts transformed into an open-air amphitheatre with projection mapping and bespoke hospitality suites.', 'Architectural lighting mapping centuries of stone history, accompanied by heritage sufi singers and royal banquet curation.', '0', '4', '1', '2026-11-13 03:37:46', '2026-11-13 03:37:46');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Global Leadership Conclave', 'global-leadership-conclave', 'Corporate', 'Fortune 500 Enterprise', '2024', 'Kolkata', 'Plenary Stage, Breakout Suites, Multi-lingual Simultaneous Interpretation', '3 Days · 850 Global Delegates', '/images/summit-audience.webp', NULL, 'Plenary sessions, minister-level security clearances, international delegates, and simultaneous translation across four languages.', 'VVIP protocol, multi-tiered security protocols, and state-of-the-art interactive voting displays.', '0', '5', '1', '2026-11-13 03:37:46', '2026-11-13 03:37:46');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Coastal Sunset Phere', 'coastal-sunset-phere', 'Wedding', 'NRI Couple', '2024', 'Goa Coast', 'Tide-timed Mandap, Acoustic Tuning, Private Beach Takeover', '2 Days · 220 Guests · Beachfront Mandap', '/images/outdoor-mandap-phere-setup.jpg', NULL, 'Barefoot luxury mandap constructed on private shoreline, timed to the precise minute of sunset with sound engineering over ocean waves.', 'Intimate beachfront celebration featuring bespoke wooden architecture, sustainable botanical decor, and candlelit seaside dinners.', '0', '6', '1', '2026-11-13 03:37:46', '2026-11-13 03:37:46');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('7', 'Flagship Product Launch', 'flagship-product-launch', 'Corporate', 'Automotive Major', '2023', 'Kolkata', '360° Reveal Stage, Kinetic Screen Rig, Media Briefing', '1 Day · 400 Journalists · National Reveal', '/images/zee-mpcg-building-new-india.webp', NULL, 'Unveiling with a custom revolving stage, hydraulic reveals, laser synchronization, and real-time test drive hospitality.', 'High-voltage kinetic screen unveiling with synchronized laser architecture for a nationwide audience.', '0', '7', '1', '2026-11-13 03:37:47', '2026-11-13 03:37:47');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('8', 'Rajbari Aristocratic Nuptials', 'rajbari-aristocratic-nuptials', 'Wedding', 'Distinguished Kolkata Family', '2023', 'Heritage Bengal', 'Heritage Conservation, Shehnai Ensembles, Royal Banquet', '2 Days · 500 Guests · Colonial Courtyard', '/images/petal-shower-couple.webp', NULL, 'Traditional Bengali rituals elevated to royal proportions with heritage shehnai masters, terracotta styling, and five-star culinary art.', 'Recreating aristocratic Zamindari grandeur in a restored 200-year-old courtyard with thousands of floating brass lamps.', '0', '8', '1', '2026-11-13 03:37:47', '2026-11-13 03:37:47');
INSERT INTO `portfolio_events` (`id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `gallery_images`, `summary`, `description`, `featured`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES ('9', 'Media Summit & Awards Gala', 'media-summit-awards-gala', 'Corporate', 'Broadcast Network', '2023', 'Kolkata', 'Dual-stage Setup, Celebrity Management, Live OB Van Integration', '2 Days · 1,500 Attendees · Multi-channel Live', '/images/zee-pride-of-malwa-stage.webp', NULL, 'Two-day mega conclave featuring political dignitaries, entertainment icons, and televised award distributions.', 'Dual broadcast stages with live satellite OB van integration and complete backstage talent management.', '0', '9', '1', '2026-11-13 03:37:48', '2026-11-13 03:37:48');

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL DEFAULT 'Eventure',
  `legal_name` varchar(150) NOT NULL DEFAULT 'Eventure Experiences LLP',
  `tagline` varchar(255) NOT NULL DEFAULT 'Where vision becomes an experience.',
  `site_url` varchar(255) NOT NULL DEFAULT 'https://myeventure.in',
  `cdn_url` varchar(255) NOT NULL DEFAULT 'https://cdn.myeventure.in',
  `logo_url` varchar(255) NOT NULL DEFAULT '/logos/eventure-logo.svg',
  `phone` varchar(50) NOT NULL DEFAULT '+91 97483 28654',
  `phone_raw` varchar(50) NOT NULL DEFAULT '9748328654',
  `whatsapp` varchar(50) NOT NULL DEFAULT '9748328654',
  `email` varchar(150) NOT NULL DEFAULT 'info@myeventure.in',
  `address_street` varchar(255) NOT NULL DEFAULT 'Tower 2, Sector V, Salt Lake City',
  `address_locality` varchar(255) NOT NULL DEFAULT 'Bidhannagar',
  `address_city` varchar(100) NOT NULL DEFAULT 'Kolkata',
  `address_region` varchar(100) NOT NULL DEFAULT 'West Bengal',
  `address_postal_code` varchar(20) NOT NULL DEFAULT '700091',
  `opening_hours` varchar(150) NOT NULL DEFAULT 'Monday to Saturday, 10:00 AM – 7:00 PM',
  `instagram_url` varchar(255) NOT NULL DEFAULT 'https://www.instagram.com/myeventure/',
  `facebook_url` varchar(255) NOT NULL DEFAULT 'https://www.facebook.com/myeventure/',
  `linkedin_url` varchar(255) NOT NULL DEFAULT 'https://www.linkedin.com/company/eventure-experiences/',
  `youtube_url` varchar(255) NOT NULL DEFAULT 'https://www.youtube.com/',
  `footer_brand_text` text DEFAULT NULL,
  `footer_tagline` varchar(255) NOT NULL DEFAULT 'Luxury Weddings · Corporate Events · Bespoke Experiences',
  `footer_copyright` varchar(255) NOT NULL DEFAULT '© 2026 Eventure. All rights reserved.',
  `meta_title` varchar(255) NOT NULL DEFAULT 'Eventure — Luxury Wedding & Corporate Event Management | Kolkata, India',
  `meta_description` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `site_name`, `legal_name`, `tagline`, `site_url`, `cdn_url`, `logo_url`, `phone`, `phone_raw`, `whatsapp`, `email`, `address_street`, `address_locality`, `address_city`, `address_region`, `address_postal_code`, `opening_hours`, `instagram_url`, `facebook_url`, `linkedin_url`, `youtube_url`, `footer_brand_text`, `footer_tagline`, `footer_copyright`, `meta_title`, `meta_description`, `updated_at`) VALUES ('1', 'Eventure', 'Eventure Experiences LLP', 'Where vision becomes an experience.', 'https://myeventure.in', 'https://cdn.myeventure.in', '/logos/eventure-logo.svg', '+91 97483 28654', '9748328654', '9748328654', 'info@myeventure.in', 'Tower 2, Sector V, Salt Lake City', 'Bidhannagar', 'Kolkata', 'West Bengal', '700091', 'Monday to Saturday, 10:00 AM – 7:00 PM', 'https://www.instagram.com/myeventure/', 'https://www.facebook.com/myeventure/', 'https://www.linkedin.com/company/eventure-experiences/', 'https://www.youtube.com/', 'Where vision becomes an experience. Luxury weddings, corporate events and bespoke experiences, delivered with precision across India.', 'Luxury Weddings · Corporate Events · Bespoke Experiences', '© 2026 Eventure. All rights reserved.', 'Eventure — Luxury Wedding & Corporate Event Management | Kolkata, India', NULL, '2026-11-13 03:37:40');

SET FOREIGN_KEY_CHECKS=1;
