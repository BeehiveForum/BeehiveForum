# Beehive Forum Database Creation
# Version 0.2 to 0.3 Poll Upgrade Script
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Nov 21, 2002 at 11:04 PM
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
  TID mediumint(8) unsigned NOT NULL default '0',
  UID mediumint(8) unsigned NOT NULL default '0',
  OPTION_ID mediumint(8) unsigned NOT NULL default '0',
  TSTAMP timestamp(14) NOT NULL
) TYPE=MyISAM;

INSERT INTO USER_POLL_VOTES SELECT TID, UID, VOTE + 1, TSTAMP FROM POLL_VOTES;
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
