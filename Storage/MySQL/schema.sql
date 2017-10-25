
DROP TABLE IF EXISTS `bono_module_team`;
CREATE TABLE `bono_module_team` (

    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `photo` varchar(255) NOT NULL,
    `published` varchar(1) NOT NULL,
    `order` INT NOT NULL COMMENT "Sort order"

) DEFAULT CHARSET = UTF8;

DROP TABLE IF EXISTS `bono_module_team_translations`;
CREATE TABLE `bono_module_team_translations` (
	
	`id` INT NOT NULL,
	`lang_id` INT NOT NULL,
	`name` varchar(255) NOT NULL COMMENT "Member's name",
	`description` LONGTEXT NOT NULL COMMENT "Member description or biography"
	
) DEFAULT CHARSET = UTF8;
