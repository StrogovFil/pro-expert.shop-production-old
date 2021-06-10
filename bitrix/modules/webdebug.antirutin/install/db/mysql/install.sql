CREATE TABLE IF NOT EXISTS `b_wd_antirutin_profiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `SORT` int(11) DEFAULT '100',
  `DESCRIPTION` text,
  `IBLOCK_ID` int(11) NOT NULL,
  `SECTIONS_ID` longtext,
  `WITH_SUBSECTIONS` char(1) DEFAULT NULL,
  `FILTER` longtext,
  `ACTION` varchar(255) NOT NULL,
  `PARAMS` longtext,
  `SEND_EMAIL` char(1) NOT NULL DEFAULT 'Y',
  `DATE_CREATED` datetime DEFAULT NULL,
  `DATE_SUCCESS` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
);

/* NEW */

CREATE TABLE IF NOT EXISTS `wd_antirutin_profile` (
	`ID` int(11) NOT NULL AUTO_INCREMENT,
	`BLOCKED` char(1) NOT NULL DEFAULT 'N',
	`ACTIVE` char(1) NOT NULL DEFAULT 'Y',
	`NAME` varchar(255) NOT NULL,
	`CODE` varchar(255),
	`DESCRIPTION` text,
	`SORT` int(11) DEFAULT '100',
	`ENTITY_TYPE` varchar(255) NOT NULL,
	`IBLOCK_ID` int(11) NOT NULL,
	`SELECT_SECTIONS` char(1) NOT NULL DEFAULT 'N',
	`MAX_DEPTH` int(11) DEFAULT '3',
	`SECTIONS_ID` longtext,
	`INCLUDE_SUBSECTIONS` char(1) NOT NULL DEFAULT 'N',
	`FILTER` longtext,
	`SETTINGS` longtext,
	`EMAIL` text,
	`LOCKED` char(1) NOT NULL DEFAULT 'N',
	`DATE_CREATE` datetime DEFAULT NULL,
	`DATE_MODIFIED` datetime DEFAULT NULL,
  `DATE_START` datetime DEFAULT NULL,
  `DATE_FINISH` datetime DEFAULT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `wd_antirutin_profile_action` (
	`ID` int(11) NOT NULL AUTO_INCREMENT,
	`PROFILE_ID` int(11) NOT NULL,
	`HASH` varchar(32) NOT NULL,
	`SORT` int(11) DEFAULT '100',
	`PLUGIN` varchar(255) NOT NULL,
	`TITLE` varchar(255),
	`PARAMS` longtext,
	`COLLAPSED` char(1) NOT NULL DEFAULT 'N',
	`DATE_CREATE` datetime DEFAULT NULL,
	`DATE_MODIFIED` datetime DEFAULT NULL,
	PRIMARY KEY (`ID`)
);
