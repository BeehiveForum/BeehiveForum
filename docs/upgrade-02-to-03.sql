# Beehive Forum Database Creation
# Version 0.2 to 0.3 Upgrade Script
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Jan 14, 2003 at 10:56 PM
#
# $Id$
#
# --------------------------------------------------------#

CREATE TABLE BANNED_IP (
  IP char(15) NOT NULL default ''
) TYPE=MyISAM;

DROP TABLE IF EXISTS LINKS;
CREATE TABLE LINKS (
  LID smallint(5) unsigned NOT NULL auto_increment,
  FID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  URI varchar(255) NOT NULL default '',
  TITLE varchar(64) NOT NULL default '',
  DESCRIPTION text NOT NULL,
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  VISIBLE char(1) NOT NULL default 'N',
  CLICKS mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (LID),
  KEY FID (FID)
) TYPE=MyISAM;

DROP TABLE IF EXISTS LINKS_COMMENT;
CREATE TABLE LINKS_COMMENT (
  CID smallint(5) unsigned NOT NULL auto_increment,
  LID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  COMMENT text NOT NULL,
  PRIMARY KEY  (CID),
  KEY LID (LID)
) TYPE=MyISAM;

DROP TABLE IF EXISTS LINKS_FOLDERS;
CREATE TABLE LINKS_FOLDERS (
  FID smallint(5) unsigned NOT NULL auto_increment,
  PARENT_FID smallint(5) unsigned default '1',
  NAME varchar(32) NOT NULL default '',
  VISIBLE char(1) NOT NULL default '',
  PRIMARY KEY  (fid)
) TYPE=MyISAM;

INSERT INTO LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) VALUES (1, NULL, 'Top Level', 'Y');

DROP TABLE IF EXISTS LINKS_VOTE;
CREATE TABLE LINKS_VOTE (
  LID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  RATING smallint(5) unsigned NOT NULL default '0',
  TSTAMP datetime NOT NULL default '0000-00-00 00:00:00',
  KEY LID (LID)
) TYPE=MyISAM;

CREATE TABLE POLL_02_BACKUP (
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
  KEY TID (`TID`)
) TYPE=MyISAM;

INSERT INTO POLL_02_BACKUP SELECT * FROM POLL;

CREATE TABLE POLL_VOTES_02_BACKUP (
  TID mediumint(8) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  VOTE mediumint(8) unsigned NOT NULL default '0',
  TSTAMP timestamp(14) NOT NULL
) TYPE=MyISAM;

INSERT INTO POLL_VOTES_02_BACKUP SELECT * FROM POLL_VOTES;

CREATE TABLE USER_POLL_VOTES (
  ID mediumint(8) unsigned NOT NULL auto_increment,
  TID mediumint(8) unsigned NOT NULL default '0',
  PTUID varchar(32) NOT NULL default '',
  OPTION_ID mediumint(8) unsigned NOT NULL default '0',
  TSTAMP timestamp(14) NOT NULL,
  PRIMARY KEY (ID, TID, PTUID)
) TYPE=MyISAM;

INSERT INTO USER_POLL_VOTES (TID, PTUID, OPTION_ID, TSTAMP) SELECT TID, MD5(CONCAT(TID, '.', UID)), VOTE + 1, TSTAMP FROM POLL_VOTES;
DROP TABLE POLL_VOTES;

CREATE TABLE POLL_VOTES (
  TID mediumint(8) unsigned NOT NULL default '0',
  OPTION_ID mediumint(8) unsigned NOT NULL auto_increment,
  OPTION_NAME char(255) NOT NULL default '',
  VOTES mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (TID, OPTION_ID)
) TYPE=MyISAM;

INSERT INTO POLL_VOTES (TID, OPTION_NAME, VOTES) SELECT TID, O1, O1_VOTES FROM POLL;
INSERT INTO POLL_VOTES (TID, OPTION_NAME, VOTES) SELECT TID, O2, O2_VOTES FROM POLL;
INSERT INTO POLL_VOTES (TID, OPTION_NAME, VOTES) SELECT TID, O3, O3_VOTES FROM POLL;
INSERT INTO POLL_VOTES (TID, OPTION_NAME, VOTES) SELECT TID, O4, O4_VOTES FROM POLL;
INSERT INTO POLL_VOTES (TID, OPTION_NAME, VOTES) SELECT TID, O5, O5_VOTES FROM POLL;

ALTER TABLE POLL DROP O1;
ALTER TABLE POLL DROP O2;
ALTER TABLE POLL DROP O3;
ALTER TABLE POLL DROP O4;
ALTER TABLE POLL DROP O5;

ALTER TABLE POLL DROP O1_VOTES;
ALTER TABLE POLL DROP O2_VOTES;
ALTER TABLE POLL DROP O3_VOTES;
ALTER TABLE POLL DROP O4_VOTES;
ALTER TABLE POLL DROP O5_VOTES;

ALTER TABLE USER ADD LOGON_FROM CHAR(15);
ALTER TABLE USER_PREFS ADD VIEW_SIGS CHAR(1);
ALTER TABLE USER_PREFS ADD START_PAGE TINYINT(3) UNSIGNED;
