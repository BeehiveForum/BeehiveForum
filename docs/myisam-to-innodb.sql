# Beehive Forum Database Table Conversion Script
# version 0.4-dev
# http://beehiveforum.sourceforge.net/
#
# Schema generated using phpMyAdmin
# (http://phpmyadmin.sourceforge.net)
# Generation Time: May 05, 2003 at 10:26 PM
# --------------------------------------------------------
#
# This script converts the Beehive Forum database tables
# from MyISAM to INNODB tables, which will result in a
# slight performance increase as well as introduce data
# recovery. See http://www.innodb.org for more
# information.
#
# NOTE: INNODB is only available if your webserver is
#       running the MAX version of MySQL. If you are
#       unsure if MySQL-MAX is available on your server,
#       please ask your hosting provider.
#
#
# WARNING: Although the conversion from MyISAM to INNODB
#          is data safe, you should always perform a
#          backup of your database before running any
#          upgrade script.
#
# --------------------------------------------------------

ALTER TABLE ADMIN_LOG TYPE = INNODB;
ALTER TABLE BANNED_IP TYPE = INNODB;
ALTER TABLE DEDUPE TYPE = INNODB;
ALTER TABLE FILTER_LIST TYPE = INNODB;
ALTER TABLE FOLDER TYPE = INNODB;
ALTER TABLE LINKS TYPE = INNODB;
ALTER TABLE LINKS_COMMENT TYPE = INNODB;
ALTER TABLE LINKS_FOLDERS TYPE = INNODB;
ALTER TABLE LINKS_VOTE TYPE = INNODB;

ALTER TABLE POLL TYPE = INNODB;

CREATE TABLE POLL_VOTES_NEW (
  TID mediumint(8) unsigned NOT NULL default '0',
  OPTION_ID mediumint(8) unsigned NOT NULL auto_increment,
  OPTION_NAME char(255) NOT NULL default '',
  VOTES mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (OPTION_ID,TID)
) TYPE=INNODB;

INSERT INTO POLL_VOTES_NEW SELECT * FROM POLL_VOTES;
DROP TABLE POLL_VOTES;
ALTER TABLE POLL_VOTES_NEW RENAME POLL_VOTES;

ALTER TABLE POLL_VOTES TYPE = INNODB;

CREATE TABLE POST_NEW (
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL auto_increment,
  REPLY_TO_PID mediumint(8) unsigned default NULL,
  FROM_UID mediumint(8) unsigned default NULL,
  TO_UID mediumint(8) unsigned default NULL,
  VIEWED datetime default NULL,
  CREATED datetime default NULL,
  STATUS tinyint(4) default '0',
  PRIMARY KEY  (PID,TID),
  KEY TO_UID (TO_UID)
) TYPE=INNODB;

INSERT INTO POST_NEW SELECT * FROM POST;
DROP TABLE POST;
ALTER TABLE POST_NEW RENAME POST;

ALTER TABLE POST_ATTACHMENT_FILES TYPE = INNODB;
ALTER TABLE POST_ATTACHMENT_IDS TYPE = INNODB;

ALTER TABLE POST_CONTENT DROP INDEX CONTENT;
ALTER TABLE POST_CONTENT TYPE = INNODB;

ALTER TABLE PROFILE_ITEM TYPE = INNODB;
ALTER TABLE PROFILE_SECTION TYPE = INNODB;
ALTER TABLE THREAD TYPE = INNODB;
ALTER TABLE USER TYPE = INNODB;
ALTER TABLE USER_FOLDER TYPE = INNODB;
ALTER TABLE USER_PEER TYPE = INNODB;
ALTER TABLE USER_POLL_VOTES TYPE = INNODB;
ALTER TABLE USER_PREFS TYPE = INNODB;
ALTER TABLE USER_PROFILE TYPE = INNODB;
ALTER TABLE USER_SIG TYPE = INNODB;
ALTER TABLE USER_THREAD TYPE = INNODB;
