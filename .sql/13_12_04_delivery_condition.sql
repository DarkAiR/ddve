CREATE TABLE `u17424_ddve`.`jos_delivery_condition` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `summ` VARCHAR(128) NOT NULL,
  `ordering` INT NOT NULL,
  `published` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

INSERT INTO `jos_components` (
  `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`
)
VALUES (
  'DeliveryCondition', 'option=com_deliverycondition', '0', '0', 'option=com_deliverycondition', 'Manage Delivery Condition', 'com_deliverycondition', '0', 'js/ThemeOffice/component.png', '0', '', '1'
);
