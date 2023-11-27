INSERT INTO `settings` (`type`, `value`)  VALUES ('customer_login_with', 'email_phone');
INSERT INTO `settings` (`type`, `value`)  VALUES ('customer_otp_with', 'email');
INSERT INTO `settings` (`type`, `value`)  VALUES ('customer_otp_with', 'email');

ALTER TABLE `users` ADD `phone_verified_at` TIMESTAMP NULL DEFAULT NULL AFTER `email_verified_at`;