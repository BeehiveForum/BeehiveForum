# Beehive Forum Database Creation
# version 0.4-dev
# http://beehiveforum.sourceforge.net/
#
# Schema generated using phpMyAdmin
# (http://phpmyadmin.sourceforge.net)
# Generation Time: Mar 17, 2004 at 00:17
#
# $Id: schema.sql,v 1.61 2004-03-17 00:08:15 decoyduck Exp $
#
# --------------------------------------------------------

#
# Table structure for table `ADMIN_LOG`
#

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
# Table structure for table `FILTER_LIST`
#

CREATE TABLE FILTER_LIST (
  ID mediumint(8) unsigned NOT NULL auto_increment,
  MATCH_TEXT varchar(255) NOT NULL default '',
  UID mediumint(8) unsigned NOT NULL default '0',
  REPLACE_TEXT varchar(255) NOT NULL default '',
  PREG_EXPR tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `FOLDER`
#

CREATE TABLE FOLDER (
  FID mediumint(8) unsigned NOT NULL auto_increment,
  TITLE varchar(32) default NULL,
  ACCESS_LEVEL tinyint(4) default '0',
  DESCRIPTION varchar(255) default NULL,
  ALLOWED_TYPES tinyint(3) default NULL,
  POSITION mediumint(3) unsigned default '0',
  PRIMARY KEY  (FID)
) TYPE=MyISAM;

#
# Dumping data for table `FOLDER`
#

INSERT INTO FOLDER (FID, TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) VALUES (1, 'General', 0, NULL, NULL, 0);

# --------------------------------------------------------

#
# Table structure for table `FORUM_SETTINGS`
#

CREATE TABLE FORUM_SETTINGS (
  FID mediumint(8) unsigned NOT NULL default '0',
  SETTING_NAME varchar(255) NOT NULL default '',
  SETTING_VALUE varchar(255) NOT NULL default '',
  KEY FID (FID)
) TYPE=MyISAM;

#
# Dumping data for table `FORUM_SETTINGS`
#

INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'forum_name', 'A Beehive Forum');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'forum_email', 'admin@abeehiveforum.net');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'default_style', 'default');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'default_language', 'en');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'show_friendly_errors', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'cookie_domain', '');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'show_stats', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'show_links', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'auto_logon', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'show_pms', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'pm_allow_attachments', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'maximum_post_length', '6226');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'allow_post_editing', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'post_edit_time', '0');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'allow_polls', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'search_min_word_length', '3');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'attachments_enabled', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'attachments_dir', 'attachments');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'attachments_show_deleted', 'N');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'attachments_allow_embed', 'N');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'attachments_use_old_method', 'N');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'guest_account_active', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'session_cutoff', '86400');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'active_session_cutoff', '900');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'gzip_compress_output', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SETTING_NAME, SETTING_VALUE) VALUES (1, 'gzip_compress_level', '1');

# --------------------------------------------------------

#
# Table structure for table `FORUMS`
#

CREATE TABLE FORUMS (
  FID mediumint(8) unsigned NOT NULL auto_increment,
  WEBTAG varchar(255) default NULL,
  PRIMARY KEY  (FID)
) TYPE=MyISAM;

#
# Dumping data for table `FORUMS`
#

INSERT INTO FORUMS (FID, WEBTAG) VALUES (1, '');

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
# Table structure for table `PM`
#

CREATE TABLE PM (
  MID mediumint(8) unsigned NOT NULL auto_increment,
  TYPE tinyint(3) unsigned NOT NULL default '0',
  TO_UID mediumint(8) unsigned NOT NULL default '0',
  FROM_UID mediumint(8) unsigned NOT NULL default '0',
  SUBJECT varchar(64) NOT NULL default '',
  CREATED datetime NOT NULL default '0000-00-00 00:00:00',
  NOTIFIED tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (MID),
  KEY TO_UID (TO_UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `PM_ATTACHMENT_IDS`
#

CREATE TABLE PM_ATTACHMENT_IDS (
  MID mediumint(8) unsigned NOT NULL default '0',
  AID char(32) NOT NULL default '',
  PRIMARY KEY  (MID),
  KEY AID (AID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `PM_CONTENT`
#

CREATE TABLE PM_CONTENT (
  MID mediumint(8) unsigned NOT NULL default '0',
  CONTENT text,
  PRIMARY KEY  (MID),
  FULLTEXT KEY CONTENT (CONTENT)
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
  VOTETYPE tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (TID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `POLL_VOTES`
#

CREATE TABLE POLL_VOTES (
  TID mediumint(8) unsigned NOT NULL default '0',
  OPTION_ID mediumint(8) unsigned NOT NULL auto_increment,
  OPTION_NAME char(255) NOT NULL default '',
  GROUP_ID mediumint(8) unsigned NOT NULL default '0',
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
  EDITED datetime default NULL,
  EDITED_BY mediumint(8) unsigned NOT NULL default '0',
  IPADDRESS varchar(15) NOT NULL default '',
  PRIMARY KEY  (TID,PID),
  KEY TO_UID (TO_UID),
  KEY IPADDRESS (IPADDRESS)
) TYPE=MyISAM;

#
# Dumping data for table `POST`
#

INSERT INTO POST (TID, PID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS) VALUES (1, 1, 0, 1, 0, NULL, NOW(), 0, NULL, 0, '');

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
  TYPE tinyint(3) unsigned default '0',
  POSITION mediumint(3) unsigned default '0',
  PRIMARY KEY  (PIID)
) TYPE=MyISAM;

#
# Dumping data for table `PROFILE_ITEM`
#

INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (1, 1, 'Location', 0, 0);
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (2, 1, 'Age', 0, 0);
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (3, 1, 'Gender', 0, 0);
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (4, 1, 'Quote', 0, 0);
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (5, 1, 'Occupation', 0, 0);
INSERT INTO PROFILE_ITEM (PIID, PSID, NAME, TYPE, POSITION) VALUES (6, 1, 'Birthday (DD/MM)', 0, 0);

# --------------------------------------------------------

#
# Table structure for table `PROFILE_SECTION`
#

CREATE TABLE PROFILE_SECTION (
  PSID mediumint(8) unsigned NOT NULL auto_increment,
  NAME varchar(64) default NULL,
  POSITION mediumint(3) unsigned default '0',
  PRIMARY KEY  (PSID)
) TYPE=MyISAM;

#
# Dumping data for table `PROFILE_SECTION`
#

INSERT INTO PROFILE_SECTION (PSID, NAME, POSITION) VALUES (1, 'Personal', 0);

# --------------------------------------------------------

#
# Table structure for table `SESSIONS`
#

CREATE TABLE SESSIONS (
  SESSID mediumint(8) unsigned NOT NULL auto_increment,
  HASH varchar(32) NOT NULL default '',
  UID mediumint(8) unsigned NOT NULL default '0',
  IPADDRESS varchar(15) NOT NULL default '',
  TIME datetime NOT NULL default '0000-00-00 00:00:00',
  FID mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (SESSID),
  KEY HASH (HASH),
  KEY FID (FID),
  KEY UID (UID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `START_MAIN`
#

CREATE TABLE START_MAIN (
  FID mediumint(8) unsigned NOT NULL default '0',
  HTML text NOT NULL,
  PRIMARY KEY  (FID)
) TYPE=MyISAM;

#
# Dumping data for table `START_MAIN`
#

INSERT INTO START_MAIN (FID, HTML) VALUES (1, '<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">\n<html>\n<head>\n<title>Project Beehive</title>\n<style type="text/css">\n<!--\n\n.bodytext    { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               font-style: normal; line-height: 13px; font-weight: normal; color: #666666;\n               background-color: #EAEFF4 }\n\n.title       { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px;\n               font-style: normal; font-weight: bold; color: #ffffff; background-color: #A6BED7 }\n\na            { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               line-height: 13px; font-weight: normal; color: #333399;\n               text-decoration: underline }\n\n-->\n</style>\n</head>\n\n<body class="bodytext">\n<table width="100%" border="0" cellspacing="0" cellpadding="8">\n  <tr>\n    <td class="title">Welcome to your new Beehive Forum!</td>\n  </tr>\n  <tr>\n    <td class="bodytext"><a href="http://sourceforge.net/projects/beehiveforum/" target="_blank">Home</a> | <a href="http://beehiveforum.net/faq">FAQ</a> | <a href="http://sourceforge.net/docman/?group_id=50772" target="_blank">Docs</a> | <a href="http://sourceforge.net/project/showfiles.php?group_id=50772" target="_blank"> Download</a> | <a href="../forums.php">Live Forums</a></td>\n  </tr>\n  <tr>\n    <td height="1" class="title"></td>\n  </tr>\n  <tr>\n    <td valign="top" class="bodytext">\n      <p>You can modify this start page from the admin interface.</p>\n    </td>\n  </tr>\n  <tr>\n    <td height="1" class="title"> </td>\n  </tr>\n</table>\n</body>\n</html>');

# --------------------------------------------------------

#
# Table structure for table `STATS`
#

CREATE TABLE STATS (
  MOST_USERS_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  MOST_USERS_COUNT mediumint(8) unsigned NOT NULL default '0',
  MOST_POSTS_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  MOST_POSTS_COUNT mediumint(8) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `STATS`
#

INSERT INTO STATS (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) VALUES ('0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

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
  STICKY char(1) default NULL,
  STICKY_UNTIL datetime default NULL,
  ADMIN_LOCK datetime default NULL,
  PRIMARY KEY  (TID),
  KEY ix_thread_fid (FID),
  KEY BY_UID (BY_UID)
) TYPE=MyISAM;

#
# Dumping data for table `THREAD`
#

INSERT INTO THREAD (TID, FID, BY_UID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) VALUES (1, 1, 1, 'Welcome', 1, 'N', NOW(), NULL, 'N', NULL, '0000-00-00 00:00:00');

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
  PRIMARY KEY  (UID)
) TYPE=MyISAM;

#
# Dumping data for table `USER`
#

INSERT INTO USER (UID, LOGON, PASSWD, NICKNAME, EMAIL) VALUES (1, 'ADMIN', 'b60eb83bf533eecf1bde65940925a981', 'Administrator', 'your@email.com');
INSERT INTO USER (UID, LOGON, PASSWD, NICKNAME, EMAIL) VALUES (2, 'GUEST', '084e0343a0486ff05530df6c705c8bb4', 'Guest', 'guest@email.com');

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
  UID mediumint(8) unsigned NOT NULL default '0',
  PTUID varchar(32) NOT NULL default '',
  OPTION_ID mediumint(8) unsigned NOT NULL default '0',
  TSTAMP datetime NOT NULL default '0000-00-00 00:00:00',
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
  DOB date default '0000-00-00',
  HOMEPAGE_URL varchar(255) default NULL,
  PIC_URL varchar(255) default NULL,
  EMAIL_NOTIFY char(1) default NULL,
  TIMEZONE decimal(2,1) default NULL,
  DL_SAVING char(1) default NULL,
  MARK_AS_OF_INT char(1) default NULL,
  POSTS_PER_PAGE tinyint(3) unsigned default NULL,
  FONT_SIZE tinyint(3) unsigned default NULL,
  STYLE varchar(255) default NULL,
  VIEW_SIGS char(1) default NULL,
  START_PAGE tinyint(3) unsigned default NULL,
  LANGUAGE varchar(32) default NULL,
  PM_NOTIFY char(1) default NULL,
  PM_NOTIFY_EMAIL char(1) default NULL,
  DOB_DISPLAY tinyint(3) unsigned default NULL,
  ANON_LOGON tinyint(3) unsigned default NULL,
  SHOW_STATS tinyint(3) unsigned default NULL,
  IMAGES_TO_LINKS char(1) default NULL,
  USE_WORD_FILTER char(1) default NULL,
  USE_ADMIN_FILTER char(1) default NULL,
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
# Table structure for table `USER_STATUS`
#

CREATE TABLE USER_STATUS (
  UID mediumint(8) unsigned NOT NULL default '0',
  FID mediumint(8) unsigned NOT NULL default '0',
  STATUS int(16) NOT NULL default '0',
  KEY UID (UID)
) TYPE=MyISAM;

#
# Dumping data for table `USER_STATUS`
#

INSERT INTO USER_STATUS (UID, FID, STATUS) VALUES (1, 1, 56);
INSERT INTO USER_STATUS (UID, FID, STATUS) VALUES (2, 1, 0);

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

# --------------------------------------------------------

#
# Table structure for table `VISITOR_LOG`
#

CREATE TABLE VISITOR_LOG (
  UID mediumint(8) unsigned NOT NULL default '0',
  FID mediumint(8) unsigned NOT NULL default '0',
  LAST_LOGON datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (UID)
) TYPE=MyISAM;
