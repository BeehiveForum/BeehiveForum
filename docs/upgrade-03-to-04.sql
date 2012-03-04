# Beehive Forum Database Creation
# version 0.3 to 0.4 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Nov 09, 2003 at 03:58 PM
#
# --------------------------------------------------------#

ALTER TABLE USER_PREFS ADD DOB date default '0000-00-00' NULL AFTER LASTNAME;
ALTER TABLE USER_PREFS ADD LANGUAGE varchar(32) default NULL AFTER START_PAGE;
ALTER TABLE USER_PREFS ADD PM_NOTIFY char(1) default NULL AFTER LANGUAGE;
ALTER TABLE USER_PREFS ADD PM_NOTIFY_EMAIL char(1) default NULL AFTER PM_NOTIFY;
ALTER TABLE USER_PREFS ADD DOB_DISPLAY tinyint(3) unsigned default NULL AFTER PM_NOTIFY_EMAIL;
ALTER TABLE USER_PREFS ADD ANON_LOGON tinyint(3) unsigned default NULL AFTER DOB_DISPLAY;
ALTER TABLE USER_PREFS ADD SHOW_STATS tinyint(3) unsigned default NULL AFTER ANON_LOGON;
ALTER TABLE USER_PREFS CHANGE TIMEZONE TIMEZONE decimal(2,1) default NULL;

ALTER TABLE PROFILE_ITEM ADD TYPE tinyint(3) unsigned default 0 AFTER NAME;
ALTER TABLE PROFILE_ITEM ADD POSITION mediumint(3) unsigned default 0 AFTER TYPE;

ALTER TABLE PROFILE_SECTION ADD POSITION mediumint(3) unsigned default 0 AFTER NAME;

ALTER TABLE FOLDER ADD DESCRIPTION varchar(255) default NULL;
ALTER TABLE FOLDER ADD ALLOWED_TYPES tinyint(3) default NULL;
ALTER TABLE FOLDER ADD POSITION mediumint(3) unsigned default 0;

ALTER TABLE POLL ADD VOTETYPE TINYINT(1) UNSIGNED NOT NULL default '0';
ALTER TABLE POLL DROP PRIMARY KEY, ADD PRIMARY KEY (TID);
ALTER TABLE POLL DROP INDEX TID;

ALTER TABLE POLL_VOTES ADD GROUP_ID MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER OPTION_NAME;

ALTER TABLE POST ADD EDITED DATETIME;
ALTER TABLE POST ADD EDITED_BY MEDIUMINT UNSIGNED NOT NULL;
ALTER TABLE POST ADD IPADDRESS VARCHAR(15) NOT NULL;
ALTER TABLE POST ADD INDEX (IPADDRESS);

ALTER TABLE USER CHANGE LAST_LOGON LAST_LOGON DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

ALTER TABLE USER_POLL_VOTES ADD UID MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER TID;
ALTER TABLE USER_POLL_VOTES CHANGE TSTAMP TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

ALTER TABLE THREAD ADD STICKY varchar(1) default NULL;
UPDATE THREAD SET THREAD.STICKY = "N" WHERE 1;
ALTER TABLE THREAD ADD STICKY_UNTIL datetime default NULL;

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
  TYPE tinyint(3) unsigned NOT NULL default '0',
  TO_UID mediumint(8) unsigned NOT NULL default '0',
  FROM_UID mediumint(8) unsigned NOT NULL default '0',
  SUBJECT varchar(64) NOT NULL default '',
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (MID),
  KEY TO_UID (TO_UID)
) TYPE=MyISAM;

CREATE TABLE PM_ATTACHMENT_IDS (
  MID mediumint(8) unsigned NOT NULL default '0',
  AID char(32) NOT NULL default '',
  PRIMARY KEY  (MID),
  KEY AID (AID)
) TYPE=MyISAM;

CREATE TABLE PM_CONTENT (
  MID mediumint(8) unsigned NOT NULL default '0',
  CONTENT text,
  PRIMARY KEY  (MID),
  FULLTEXT KEY CONTENT (CONTENT)
) TYPE=MyISAM;

CREATE TABLE SESSIONS (
  SESSID mediumint(8) unsigned NOT NULL auto_increment,
  HASH varchar(32) NOT NULL default '',
  UID mediumint(8) unsigned NOT NULL default '0',
  IPADDRESS varchar(15) NOT NULL default '',
  TIME datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (SESSID),
  KEY HASH (HASH)
) TYPE=MyISAM;

CREATE TABLE STATS (
  MOST_USERS_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  MOST_USERS_COUNT mediumint(8) unsigned NOT NULL default '0',
  MOST_POSTS_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  MOST_POSTS_COUNT mediumint(8) unsigned NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO STATS (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) VALUES ('0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0');
