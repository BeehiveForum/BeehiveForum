# Beehive Forum Database Creation
# Version 0.3 to 0.4-dev Upgrade Script
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Jul 15, 2003 at 19:35 PM
# --------------------------------------------------------#

ALTER TABLE USER_PREFS ADD DOB date default '0000-00-00' NULL AFTER LASTNAME;
ALTER TABLE USER_PREFS ADD LANGUAGE varchar(32) default NULL AFTER START_PAGE;
ALTER TABLE USER_PREFS ADD PM_NOTIFY char(1) default NULL AFTER LANGUAGE;
ALTER TABLE USER_PREFS ADD PM_NOTIFY_EMAIL char(1) default NULL AFTER PM_NOTIFY;
ALTER TABLE USER_PREFS ADD DOB_DISPLAY tinyint(3) unsigned default NULL AFTER PM_NOTIFY_EMAIL;

ALTER TABLE FOLDER ADD DESCRIPTION varchar(255) default NULL;

CREATE TABLE ADMIN_LOG (
  LOG_ID mediumint(8) unsigned NOT NULL auto_increment,
  LOG_TIME datetime default NULL,
  ADMIN_UID mediumint(8) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  FID mediumint(8) unsigned NOT NULL default '0',
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL default '0',
  PSID mediumint(8) unsigned NOT NULL default '0',
  PIID mediumint(8) unsigned NOT NULL default '0',
  ACTION mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (LOG_ID)
) TYPE=MyISAM;

CREATE TABLE FILTER_LIST (
  ID mediumint(8) unsigned NOT NULL auto_increment,
  FILTER text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

CREATE TABLE PM (
  MID mediumint(8) unsigned NOT NULL auto_increment,
  FROM_UID mediumint(8) unsigned NOT NULL default '0',
  TO_UID mediumint(8) unsigned NOT NULL default '0',
  SUBJECT varchar(64) NOT NULL default '',
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  VIEWED datetime default NULL,
  DELETED tinyint(4) NOT NULL default '0',
  NOTIFIED tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (MID),
  KEY TO_UID (TO_UID)
) TYPE=MyISAM;

CREATE TABLE PM_CONTENT (
  MID mediumint(8) unsigned NOT NULL default '0',
  CONTENT text,
  PRIMARY KEY  (MID),
  FULLTEXT KEY CONTENT (CONTENT)
) TYPE=MyISAM;
