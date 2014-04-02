
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- basis_key
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_key`;

CREATE TABLE `basis_key`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_key` VARCHAR(255),
    `product_id` INTEGER NOT NULL,
    `order_id` INTEGER,
    `host_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `basis_key_FI_1` (`product_id`),
    INDEX `basis_key_FI_2` (`order_id`),
    INDEX `basis_key_FI_3` (`host_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- basis_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_product`;

CREATE TABLE `basis_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- basis_customer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_customer`;

CREATE TABLE `basis_customer`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `email` VARCHAR(255),
    `country` VARCHAR(80),
    `organization` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- basis_order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_order`;

CREATE TABLE `basis_order`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `agent` VARCHAR(255),
    `trans_id` VARCHAR(255),
    `state` TINYINT,
    `customer_id` INTEGER NOT NULL,
    `gross` DECIMAL NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `basis_order_FI_1` (`customer_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- basis_order_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_order_item`;

CREATE TABLE `basis_order_item`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `quantity` INTEGER NOT NULL,
    `price` DECIMAL NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `basis_order_item_FI_1` (`order_id`),
    INDEX `basis_order_item_FI_2` (`product_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- basis_host
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `basis_host`;

CREATE TABLE `basis_host`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fingerprint` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- fos_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user`;

CREATE TABLE `fos_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255),
    `username_canonical` VARCHAR(255),
    `email` VARCHAR(255),
    `email_canonical` VARCHAR(255),
    `enabled` TINYINT(1) DEFAULT 0,
    `salt` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_login` DATETIME,
    `locked` TINYINT(1) DEFAULT 0,
    `expired` TINYINT(1) DEFAULT 0,
    `expires_at` DATETIME,
    `confirmation_token` VARCHAR(255),
    `password_requested_at` DATETIME,
    `credentials_expired` TINYINT(1) DEFAULT 0,
    `credentials_expire_at` DATETIME,
    `roles` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fos_user_U_1` (`username_canonical`),
    UNIQUE INDEX `fos_user_U_2` (`email_canonical`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- fos_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_group`;

CREATE TABLE `fos_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `roles` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- fos_user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user_group`;

CREATE TABLE `fos_user_group`
(
    `fos_user_id` INTEGER NOT NULL,
    `fos_group_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`fos_user_id`,`fos_group_id`),
    INDEX `fos_user_group_FI_2` (`fos_group_id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
