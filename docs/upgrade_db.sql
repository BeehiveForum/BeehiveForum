INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL, STATUS, LAST_LOGON) VALUES ('GUEST', MD5('guest'), 'Guest', 'guest@email.com', 0, NOW());

DROP TABLE IF EXISTS POLL;

CREATE TABLE POLL (
  TID mediumint(8) unsigned NOT NULL default '0',
  O1 varchar(255) default NULL,
  O1_VOTES mediumint(8) unsigned default '0',
  O2 varchar(255) default NULL,
  O2_VOTES mediumint(8) unsigned default '0',
  O3 varchar(255) default NULL,
  O3_VOTES mediumint(8) unsigned default '0',
  O4 varchar(255) default NULL,
  O4_VOTES mediumint(8) unsigned default '0',
  O5 varchar(255) default NULL,
  O5_VOTES mediumint(8) unsigned default '0',
  CLOSES datetime default NULL,
  CHANGEVOTE tinyint(1) NOT NULL default '1',
  POLLTYPE tinyint(1) NOT NULL default '0',
  SHOWRESULTS tinyint(1) NOT NULL default '1',
  KEY TID (TID)
) TYPE=MyISAM;

ALTER TABLE USER_PREFS
ADD STYLE varchar(255) default NULL,
ADD KEY STYLE (STYLE)

ALTER TABLE POST
MODIFY CREATED datetime NOT NULL