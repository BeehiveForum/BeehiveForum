# Beehive Forum Links Database upgrade
# This creates the required tables for the links database on a forum which does not already have one.
# --------------------------------------------------------

#
# Table structure for table `LINKS`
#

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
# --------------------------------------------------------

#
# Table structure for table `LINKS_COMMENT`
#

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
# --------------------------------------------------------

#
# Table structure for table `LINKS_FOLDERS`
#

DROP TABLE IF EXISTS LINKS_FOLDERS;
CREATE TABLE LINKS_FOLDERS (
  FID smallint(5) unsigned NOT NULL auto_increment,
  PARENT_FID smallint(5) unsigned default '1',
  NAME varchar(32) NOT NULL default '',
  VISIBLE char(1) NOT NULL default '',
  PRIMARY KEY  (fid)
) TYPE=MyISAM;

INSERT INTO LINKS_FOLDERS (FID, PARENT_FID, NAME, VISIBLE) VALUES (1, NULL, 'Top Level', 'Y');
# --------------------------------------------------------

#
# Table structure for table `LINKS_VOTE`
#

DROP TABLE IF EXISTS LINKS_VOTE;
CREATE TABLE LINKS_VOTE (
  LID smallint(5) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  RATING smallint(5) unsigned NOT NULL default '0',
  TSTAMP datetime NOT NULL default '0000-00-00 00:00:00',
  KEY LID (LID)
) TYPE=MyISAM;

