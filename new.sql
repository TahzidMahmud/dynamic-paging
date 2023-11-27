ALTER TABLE `categories` ADD `image` INT(11) NULL AFTER `big_banner`;
INSERT INTO `pages` (`id`, `type`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `keywords`, `meta_image`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'sister-concern', 'Key Management', 'key-management', NULL, 'Key Management', NULL, 'Shop', NULL, '2021-04-13 09:44:16', '2021-11-18 22:02:33', NULL)
ALTER TABLE `products` ADD `technical_sheet` VARCHAR(200) NULL AFTER `thumbnail_img`, ADD `safety_sheet` VARCHAR(200) NULL AFTER `technical_sheet`;
ALTER TABLE `products` ADD `shipping_in` DOUBLE(10,2) NULL DEFAULT '0.00' AFTER `todays_deal`, ADD `shipping_out` DOUBLE(10,2) NULL DEFAULT '0.00' AFTER `shipping_in`;
ALTER TABLE `products` ADD `specification_n_approval` LONGTEXT NULL AFTER `description`;
ALTER TABLE `products` ADD `performance` LONGTEXT NULL AFTER `description`, ADD `application` LONGTEXT NULL AFTER `performance`;
