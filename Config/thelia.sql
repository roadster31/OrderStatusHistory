
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- order_status_change
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_status_change`;

CREATE TABLE `order_status_change`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `order_status_id` INTEGER NOT NULL,
    `change_date` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_order_status_change_order_id` (`order_id`),
    INDEX `FI_order_status_change_order_status_id` (`order_status_id`),
    CONSTRAINT `fk_order_status_change_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_status_change_order_status_id`
        FOREIGN KEY (`order_status_id`)
        REFERENCES `order_status` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
