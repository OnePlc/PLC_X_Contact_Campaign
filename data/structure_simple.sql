ALTER TABLE `contact_campaign` ADD `type_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `contact_idfs`,
ADD `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `type_idfs`;

