ALTER TABLE USER_PREFS ADD DOB date default '0000-00-00' NULL AFTER LASTNAME

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
