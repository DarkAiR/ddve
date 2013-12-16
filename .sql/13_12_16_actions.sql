CREATE TABLE `u17424_ddve`.`jos_actions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `text` TEXT NOT NULL,
  `smalltext` TEXT NOT NULL,
  `rollday` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `ordering` INT NOT NULL,
  `published` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

INSERT INTO `jos_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES ('Actions', 'option=com_actions', '0', '0', 'option=com_actions', 'Actions', 'com_actions', '0', 'js/ThemeOffice/component.png', '0', '', '1');
