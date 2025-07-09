SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE `_anpassungen` (
  `id` int(10) NOT NULL,
  `spieler_id` int(10) NOT NULL,
  `position_main` enum('T','LV','IV','RV','LM','DM','ZM','OM','RM','LS','MS','RS') DEFAULT NULL,
  `position_second` enum('T','LV','IV','RV','LM','DM','ZM','OM','RM','LS','MS','RS') DEFAULT NULL,
  `marktwert_neu` int(10) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `admin_approval_pending` enum('1','0') NOT NULL DEFAULT '1',
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `toffer_spieler_id_fk` (`spieler_id`)
) DEFAULT CHARSET=utf8, ENGINE=InnoDB;
SET FOREIGN_KEY_CHECKS = 1;