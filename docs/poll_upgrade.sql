# Beehive Forum Database Creation
# Version 0.2 to 0.3 Poll Upgrade Script
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Jan 14, 2003 at 10:56 PM
# --------------------------------------------------------#

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
