CREATE TABLE `_jugendliga` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `kurz` varchar(5) DEFAULT NULL,
  `land` varchar(25) DEFAULT NULL,
  `picture` varchar(128) DEFAULT NULL,
  `p_steh` tinyint(3) NOT NULL,
  `p_sitz` tinyint(3) NOT NULL,
  `p_haupt_steh` tinyint(3) NOT NULL,
  `p_haupt_sitz` tinyint(3) NOT NULL,
  `p_vip` tinyint(3) NOT NULL,
  `preis_steh` smallint(5) NOT NULL,
  `preis_sitz` smallint(5) NOT NULL,
  `preis_vip` smallint(5) NOT NULL,
  `admin_id` smallint(5) NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `_jugendsaison` (
  `id` int(10) NOT NULL AUTO_INCREMENT ,
  `name` varchar(20) DEFAULT NULL,
  `liga_id` smallint(5) NOT NULL,
  `platz_1_id` int(10) NOT NULL,
  `platz_2_id` int(10) NOT NULL,
  `platz_3_id` int(10) NOT NULL,
  `platz_4_id` int(10) NOT NULL,
  `platz_5_id` int(10) NOT NULL,
  `beendet` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


ALTER TABLE `_verein` ADD `jugend_liga_id` SMALLINT(5) NULL DEFAULT NULL AFTER `liga_id`;

ALTER TABLE `_verein` ADD `ju_sa_tore` INT(6) NOT NULL AFTER `sa_punkte`, ADD `ju_sa_gegentore` INT(6) NOT NULL AFTER `ju_sa_tore`, ADD `ju_sa_spiele` SMALLINT(5) NOT NULL AFTER `ju_sa_gegentore`, ADD `ju_sa_siege` SMALLINT(5) NOT NULL AFTER `ju_sa_spiele`, ADD `ju_sa_niederlagen` SMALLINT(5) NOT NULL AFTER `ju_sa_siege`, ADD `ju_sa_unentschieden` SMALLINT(5) NOT NULL AFTER `ju_sa_niederlagen`, ADD `ju_sa_punkte` INT(6) NOT NULL AFTER `ju_sa_unentschieden`;

ALTER TABLE `_youthmatch` ADD `spieltyp` ENUM('Ligaspiel','Pokalspiel','Freundschaft') NOT NULL DEFAULT 'Freundschaft' AFTER `id`, ADD `liga_id` SMALLINT(5) NOT NULL AFTER `spieltyp`, ADD `saison_id` INT(10) NULL DEFAULT NULL AFTER `liga_id`, ADD `spieltag` TINYINT(3) NULL DEFAULT NULL AFTER `saison_id`;
