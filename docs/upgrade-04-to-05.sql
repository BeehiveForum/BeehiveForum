# Beehive Forum Database Creation
# version 0.4 to 0.5 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Mar 16, 2004 at 00:17
#
# $Id: upgrade-04-to-05.sql,v 1.9 2004-05-04 17:10:15 decoyduck Exp $
#
# --------------------------------------------------------#

CREATE TABLE USER_FORUM (
  UID MEDIUMINT(8) UNSIGNED NOT NULL,
  FID MEDIUMINT(8) UNSIGNED NOT NULL,
  INTEREST TINYINT(4) DEFAULT '0',
  ALLOWED TINYINT(4) DEFAULT '0',
  PRIMARY KEY (UID, FID)
) TYPE = MYISAM;

DELETE FROM USER WHERE LOGON = 'GUEST' AND (PASSWD = MD5('GUEST') OR PASSWD = MD5('guest'));
