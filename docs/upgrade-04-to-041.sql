# Beehive Forum Database Creation
# version 0.3 to 0.4 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Nov 09, 2003 at 03:58 PM
#
# $Id: upgrade-04-to-041.sql,v 1.2 2004-02-27 22:00:13 decoyduck Exp $
#
# --------------------------------------------------------#

ALTER TABLE THREAD ADD ADMIN_LOCK DATETIME;
UPDATE THREAD SET ADMIN_LOCK = 0 WHERE 1;

ALTER TABLE PM ADD NOTIFIED TINYINT UNSIGNED DEFAULT '0' NOT NULL;
UPDATE PM SET NOTIFIED = 1 WHERE TYPE > 1;

ALTER TABLE POLL_VOTES DROP VOTES;
ALTER TABLE USER_PREFS ADD IMAGES_TO_LINKS CHAR(1);
