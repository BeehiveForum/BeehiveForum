# Beehive Forum Database Creation
# version 0.4 to 0.4.1 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Mar 16, 2004 at 00:17
#
# $Id: upgrade-04-to-041.sql,v 1.14 2004-03-17 18:23:43 tribalonline Exp $
#
# --------------------------------------------------------#

ALTER TABLE BANNED_IP ADD PRIMARY KEY (IP);

ALTER TABLE LINKS_VOTE ADD PRIMARY KEY (LID, UID);
ALTER TABLE LINKS_VOTE DROP INDEX LID;

ALTER TABLE POST_ATTACHMENT_IDS ADD PRIMARY KEY (TID, PID);
ALTER TABLE POST_ATTACHMENT_IDS DROP INDEX IX_PATTID_1;

ALTER TABLE STATS ADD ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE USER_FOLDER ADD PRIMARY KEY (UID, FID); 
ALTER TABLE USER_FOLDER DROP INDEX UID;

ALTER TABLE USER_PEER ADD PRIMARY KEY (UID, PEER_UID);
ALTER TABLE USER_PEER DROP INDEX UID; 

ALTER TABLE USER_PREFS ADD PRIMARY KEY (UID, UID);
ALTER TABLE USER_PREFS DROP INDEX UID;
ALTER TABLE USER_PREFS DROP INDEX STYLE;

ALTER TABLE USER_PROFILE ADD PRIMARY KEY (UID, PIID);

ALTER TABLE USER_SIG ADD PRIMARY KEY (UID);
ALTER TABLE USER_SIG DROP INDEX IX_USER_SIG; 

ALTER TABLE USER_THREAD ADD PRIMARY KEY (UID, TID);
ALTER TABLE USER_THREAD DROP INDEX IX_USER_THREAD_1;

ALTER TABLE THREAD ADD ADMIN_LOCK DATETIME DEFAULT NULL;

ALTER TABLE PM ADD NOTIFIED TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL;
UPDATE PM SET NOTIFIED = 1 WHERE TYPE > 1;

ALTER TABLE POLL_VOTES DROP VOTES;
ALTER TABLE USER_PREFS ADD IMAGES_TO_LINKS CHAR(1);

ALTER TABLE USER_PREFS ADD USE_WORD_FILTER CHAR(1);
ALTER TABLE USER_PREFS ADD USE_ADMIN_FILTER CHAR(1);

ALTER TABLE FILTER_LIST ADD UID MEDIUMINT(8) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE FILTER_LIST CHANGE FILTER MATCH_TEXT VARCHAR(255) NOT NULL;
ALTER TABLE FILTER_LIST ADD REPLACE_TEXT VARCHAR(255) NOT NULL;
ALTER TABLE FILTER_LIST ADD PREG_EXPR TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL;

ALTER TABLE SESSIONS ADD FID MEDIUMINT(8) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE SESSIONS ADD INDEX (FID);
ALTER TABLE SESSIONS ADD INDEX (UID);

CREATE TABLE FORUMS (
  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  WEBTAG VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (FID)
) TYPE=MyISAM;

INSERT INTO FORUMS (WEBTAG) VALUES('');

CREATE TABLE FORUM_SETTINGS (
  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  FID MEDIUMINT(8) UNSIGNED NOT NULL,  
  SNAME VARCHAR(255) NOT NULL,
  SVALUE VARCHAR(255) NOT NULL,
  INDEX (SID, FID)
) TYPE=MyISAM;

INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_name', 'A Beehive Forum');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_email', 'admin@abeehiveforum.net');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_style', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_emoticons', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_language', 'en');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_friendly_errors', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'cookie_domain', '');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_stats', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_links', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'auto_logon', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_pms', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'pm_allow_attachments', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'maximum_post_length', '6226');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_post_editing', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'post_edit_time', '0');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_polls', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'search_min_word_length', '3');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_enabled', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_dir', 'attachments');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_show_deleted', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_allow_embed', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_use_old_method', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'guest_account_active', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'session_cutoff', '86400');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'active_session_cutoff', '900');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'gzip_compress_output', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'gzip_compress_level', '1');

CREATE TABLE START_MAIN (
  FID MEDIUMINT(8) UNSIGNED NOT NULL,
  HTML TEXT NOT NULL,
  PRIMARY KEY (FID)
) TYPE=MyISAM;

INSERT INTO START_MAIN (FID, HTML) VALUES (1, '<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">\n<html>\n<head>\n<title>Project Beehive</title>\n<style type="text/css">\n<!--\n\n.bodytext    { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               font-style: normal; line-height: 13px; font-weight: normal; color: #666666;\n               background-color: #EAEFF4 }\n\n.title       { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px;\n               font-style: normal; font-weight: bold; color: #ffffff; background-color: #A6BED7 }\n\na            { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               line-height: 13px; font-weight: normal; color: #333399;\n               text-decoration: underline }\n\n-->\n</style>\n</head>\n\n<body class="bodytext">\n<table width="100%" border="0" cellspacing="0" cellpadding="8">\n  <tr>\n    <td class="title">Welcome to your new Beehive Forum!</td>\n  </tr>\n  <tr>\n    <td class="bodytext"><a href="http://sourceforge.net/projects/beehiveforum/" target="_blank">Home</a> | <a href="http://beehiveforum.net/faq">FAQ</a> | <a href="http://sourceforge.net/docman/?group_id=50772" target="_blank">Docs</a> | <a href="http://sourceforge.net/project/showfiles.php?group_id=50772" target="_blank"> Download</a> | <a href="../forums.php">Live Forums</a></td>\n  </tr>\n  <tr>\n    <td height="1" class="title"></td>\n  </tr>\n  <tr>\n    <td valign="top" class="bodytext">\n      <p>You can modify this start page from the admin interface.</p>\n    </td>\n  </tr>\n  <tr>\n    <td height="1" class="title"> </td>\n  </tr>\n</table>\n</body>\n</html>');

CREATE TABLE VISITOR_LOG (
  UID MEDIUMINT(8) UNSIGNED NOT NULL,
  FID MEDIUMINT(8) UNSIGNED NOT NULL,
  LAST_LOGON DATETIME NOT NULL,
  PRIMARY KEY (UID, FID)
) TYPE=MyISAM;

CREATE TABLE USER_STATUS (
  UID MEDIUMINT(8) UNSIGNED NOT NULL,
  FID MEDIUMINT(8) UNSIGNED NOT NULL,
  STATUS INT(16) NOT NULL,
  PRIMARY KEY (UID, FID)
) TYPE=MyISAM;

INSERT INTO USER_STATUS (UID, FID, STATUS) SELECT UID, 1, STATUS FROM USER;

ALTER TABLE USER DROP LAST_LOGON;
ALTER TABLE USER DROP LOGON_FROM;
ALTER TABLE USER DROP STATUS;

ALTER TABLE `user_prefs` ADD `EMOTICONS` VARCHAR( 255 ) ;
