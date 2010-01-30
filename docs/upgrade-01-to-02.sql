# Beehive Forum Database Creation
# version 0.1 to 0.2 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Aug 27, 2002 at 05:16 PM
#
# $Id: upgrade-01-to-02.sql,v 1.2 2003/11/09 17:53:41 decoyduck Exp $
#
# --------------------------------------------------------#

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

ALTER TABLE USER_PREFS ADD STYLE VARCHAR(255), ADD INDEX (STYLE);
ALTER TABLE POST CHANGE CREATED CREATED DATETIME DEFAULT NULL;
ALTER TABLE POST_ATTACHMENT_FILES ADD DOWNLOADS MEDIUMINT UNSIGNED NOT NULL;
