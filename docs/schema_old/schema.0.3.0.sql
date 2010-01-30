# Beehive Forum Database Creation
# version 0.2-dev
# http://beehiveforum.sourceforge.net/
#
# Schema generated using phpMyAdmin
# (http://phpmyadmin.sourceforge.net)
# Generation Time: Jan 19, 2003 at 11:28 PM
# --------------------------------------------------------

#
# Table structure for table `BANNED_IP`
#

CREATE TABLE BANNED_IP (
  IP char(15) NOT NULL default ''
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `DEDUPE`
#

CREATE TABLE DEDUPE (
  UID mediumint(8) unsigned NOT NULL default '0',
  DDKEY char(32) default NULL,
  PRIMARY KEY  (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `FOLDER`
#

CREATE TABLE FOLDER (
  FID mediumint(8) unsigned NOT NULL auto_increment,
  TITLE varchar(32) default NULL,
  ACCESS_LEVEL tinyint(4) default '0',
  PRIMARY KEY  (FID)
) TYPE=MyISAM;

#
# Dumping data for table `folder`
#

INSERT INTO FOLDER (FID, TITLE, ACCESS_LEVEL) VALUES (1, 'General', 0);
# --------------------------------------------------------

#
# Table structure for table `LINKS`
#

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

# --------------------------------------------------------

#
# Table structure for table `LINKS_COMMENT`
#

CREATE TABLE LINKS_COMMENT (
  CID smallint(5) unsigned NOT NULL auto_increment,
  LID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  COMMENT text NOT NULL,
  PRIMARY KEY  (CID),
  KEY LID (LID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `LINKS_FOLDERS`
#

CREATE TABLE LINKS_FOLDERS (
  FID smallint(5) unsigned NOT NULL auto_increment,
  PARENT_FID smallint(5) unsigned default '1',
  NAME varchar(32) NOT NULL default '',
  VISIBLE char(1) NOT NULL default '',
  PRIMARY KEY  (FID)
) TYPE=MyISAM;

#
# Dumping data for table `LINKS_FOLDERS`
#

INSERT INTO LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) VALUES (1, NULL, 'Top Level', 'Y');
# --------------------------------------------------------

#
# Table structure for table `LINKS_VOTE`
#

CREATE TABLE LINKS_VOTE (
  LID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  RATING smallint(5) unsigned NOT NULL default '0',
  TSTAMP datetime NOT NULL default '0000-00-00 00:00:00',
  KEY LID (LID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POLL`
#

CREATE TABLE POLL (
  TID mediumint(8) unsigned NOT NULL default '0',
  CLOSES datetime default NULL,
  CHANGEVOTE tinyint(1) NOT NULL default '1',
  POLLTYPE tinyint(1) NOT NULL default '0',
  SHOWRESULTS tinyint(1) NOT NULL default '1',
  KEY TID (TID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POLL_VOTES`
#

CREATE TABLE POLL_VOTES (
  TID mediumint(8) unsigned NOT NULL default '0',
  OPTION_ID mediumint(8) unsigned NOT NULL auto_increment,
  OPTION_NAME char(255) NOT NULL default '',
  VOTES mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (TID,OPTION_ID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POST`
#

CREATE TABLE POST (
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL auto_increment,
  REPLY_TO_PID mediumint(8) unsigned default NULL,
  FROM_UID mediumint(8) unsigned default NULL,
  TO_UID mediumint(8) unsigned default NULL,
  VIEWED datetime default NULL,
  CREATED datetime default NULL,
  STATUS tinyint(4) default '0',
  PRIMARY KEY  (TID,PID),
  KEY TO_UID (TO_UID)
) TYPE=MyISAM;

#
# Dumping data for table `POST`
#

INSERT INTO POST (TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS) VALUES (1, 1, 0, 1, 0, NULL, '2003-01-19 23:28:05', 0);
# --------------------------------------------------------

#
# Table structure for table `POST_ATTACHMENT_FILES`
#

CREATE TABLE POST_ATTACHMENT_FILES (
  ID mediumint(8) unsigned NOT NULL auto_increment,
  AID varchar(32) NOT NULL default '',
  UID mediumint(8) unsigned NOT NULL default '0',
  FILENAME varchar(255) NOT NULL default '',
  MIMETYPE varchar(255) NOT NULL default '',
  HASH varchar(32) NOT NULL default '',
  DOWNLOADS mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY AID (AID),
  KEY HASH (HASH)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POST_ATTACHMENT_IDS`
#

CREATE TABLE POST_ATTACHMENT_IDS (
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL default '0',
  AID char(32) NOT NULL default '',
  KEY AID (AID),
  KEY ix_pattid_1 (TID,PID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POST_CONTENT`
#

CREATE TABLE POST_CONTENT (
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL default '0',
  CONTENT text,
  PRIMARY KEY  (TID,PID),
  FULLTEXT KEY CONTENT (CONTENT)
) TYPE=MyISAM;

#
# Dumping data for table `POST_CONTENT`
#

INSERT INTO POST_CONTENT (TID, PID, CONTENT) VALUES (1, 1, 'Welcome to your new Beehive Forum');
# --------------------------------------------------------

#
# Table structure for table `PROFILE_ITEM`
#

CREATE TABLE PROFILE_ITEM (
  PIID mediumint(8) unsigned NOT NULL auto_increment,
  PSID mediumint(8) unsigned default NULL,
  NAME varchar(64) default NULL,
  PRIMARY KEY  (PIID)
) TYPE=MyISAM;

#
# Dumping data for table `PROFILE_ITEM`
#

INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (1, 1, 'Location');
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (2, 1, 'Age');
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (3, 1, 'Gender');
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (4, 1, 'Quote');
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (5, 1, 'Occupation');
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME) VALUES (6, 1, 'Birthday (DD/MM)');
# --------------------------------------------------------

#
# Table structure for table `PROFILE_SECTION`
#

CREATE TABLE PROFILE_SECTION (
  PSID mediumint(8) unsigned NOT NULL auto_increment,
  NAME varchar(64) default NULL,
  PRIMARY KEY  (PSID)
) TYPE=MyISAM;

#
# Dumping data for table `PROFILE_SECTION`
#

INSERT INTO PROFILE_SECTION (PSID, NAME) VALUES (1, 'Personal');
# --------------------------------------------------------

#
# Table structure for table `THREAD`
#

CREATE TABLE THREAD (
  TID mediumint(8) unsigned NOT NULL auto_increment,
  FID mediumint(8) unsigned default NULL,
  BY_UID mediumint(8) unsigned default NULL,
  TITLE varchar(64) default NULL,
  LENGTH mediumint(8) unsigned default NULL,
  POLL_FLAG char(1) default NULL,
  MODIFIED datetime default NULL,
  CLOSED datetime default NULL,
  PRIMARY KEY  (TID),
  KEY ix_thread_fid (FID),
  KEY BY_UID (BY_UID)
) TYPE=MyISAM;

#
# Dumping data for table `THREAD`
#

INSERT INTO THREAD (TID, FID, BY_UID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED) VALUES (1, 1, 1, 'Welcome', 1, 'N', '2003-01-19 23:28:06', NULL);
# --------------------------------------------------------

#
# Table structure for table `USER`
#

CREATE TABLE USER (
  UID mediumint(8) unsigned NOT NULL auto_increment,
  LOGON varchar(32) default NULL,
  PASSWD varchar(32) default NULL,
  NICKNAME varchar(32) default NULL,
  EMAIL varchar(80) default NULL,
  STATUS int(16) default NULL,
  LAST_LOGON timestamp(14) NOT NULL,
  LOGON_FROM varchar(15) default NULL,
  PRIMARY KEY  (UID)
) TYPE=MyISAM;

#
# Dumping data for table `user`
#

INSERT INTO USER (UID, LOGON, PASSWD, NICKNAME, EMAIL, STATUS, LAST_LOGON, LOGON_FROM) VALUES (1, 'ADMIN', 'b60eb83bf533eecf1bde65940925a981', 'Administrator', 'your@email.com', 56, 20030119232806, NULL);
INSERT INTO USER (UID, LOGON, PASSWD, NICKNAME, EMAIL, STATUS, LAST_LOGON, LOGON_FROM) VALUES (2, 'GUEST', '084e0343a0486ff05530df6c705c8bb4', 'Guest', 'guest@email.com', 0, 20030119232806, NULL);
# --------------------------------------------------------

#
# Table structure for table `USER_FOLDER`
#

CREATE TABLE USER_FOLDER (
  UID mediumint(8) unsigned default NULL,
  FID mediumint(8) unsigned default NULL,
  INTEREST tinyint(4) default '0',
  ALLOWED tinyint(4) default '0',
  KEY UID (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PEER`
#

CREATE TABLE USER_PEER (
  UID mediumint(8) unsigned default NULL,
  PEER_UID mediumint(8) unsigned default NULL,
  RELATIONSHIP tinyint(4) default NULL,
  KEY UID (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_POLL_VOTES`
#

CREATE TABLE USER_POLL_VOTES (
  ID mediumint(8) unsigned NOT NULL auto_increment,
  TID mediumint(8) unsigned NOT NULL default '0',
  PTUID varchar(32) NOT NULL default '',
  OPTION_ID mediumint(8) unsigned NOT NULL default '0',
  TSTAMP timestamp(14) NOT NULL,
  PRIMARY KEY  (ID,TID,PTUID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PREFS`
#

CREATE TABLE USER_PREFS (
  UID mediumint(8) unsigned default NULL,
  FIRSTNAME varchar(32) default NULL,
  LASTNAME varchar(32) default NULL,
  HOMEPAGE_URL varchar(255) default NULL,
  PIC_URL varchar(255) default NULL,
  EMAIL_NOTIFY char(1) default NULL,
  TIMEZONE tinyint(4) default NULL,
  DL_SAVING char(1) default NULL,
  MARK_AS_OF_INT char(1) default NULL,
  POSTS_PER_PAGE tinyint(3) unsigned default NULL,
  FONT_SIZE tinyint(3) unsigned default NULL,
  STYLE varchar(255) default NULL,
  VIEW_SIGS char(1) default NULL,
  START_PAGE tinyint(3) unsigned default NULL,
  KEY STYLE (STYLE),
  KEY UID (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PROFILE`
#

CREATE TABLE USER_PROFILE (
  UID mediumint(8) unsigned default NULL,
  PIID mediumint(8) unsigned default NULL,
  ENTRY varchar(255) default NULL
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_SIG`
#

CREATE TABLE USER_SIG (
  UID mediumint(8) unsigned default NULL,
  CONTENT text,
  HTML char(1) default NULL,
  KEY ix_user_sig (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_THREAD`
#

CREATE TABLE USER_THREAD (
  UID mediumint(8) unsigned default NULL,
  TID mediumint(8) unsigned default NULL,
  LAST_READ mediumint(8) unsigned default NULL,
  LAST_READ_AT datetime default NULL,
  INTEREST tinyint(4) default NULL,
  UNIQUE KEY ix_user_thread_1 (UID,TID)
) TYPE=MyISAM;

