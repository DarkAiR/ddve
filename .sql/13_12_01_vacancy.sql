CREATE TABLE `u17424_ddve`.`jos_vacancy` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `required` TEXT NOT NULL,
  `responsibility` TEXT NOT NULL,
  `conditions` TEXT NOT NULL,
  `info` TEXT NOT NULL,
  `skills` TEXT NOT NULL,
  `phone` VARCHAR(128) NOT NULL,
  `address` VARCHAR(128) NOT NULL,
  `ordering` INT NOT NULL,
  PRIMARY KEY (`id`));

INSERT INTO `jos_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES ('Vacancy', 'option=com_vacancy', '0', '0', 'option=com_vacancy', 'Manage Vacancy', 'com_vacancy', '0', 'js/ThemeOffice/component.png', '0', '', '1');
