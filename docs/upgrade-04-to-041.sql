# Beehive Forum Database Creation
# version 0.3 to 0.4 Upgrade
# http://beehiveforum.sourceforge.net/
#
# Generation Time: Nov 09, 2003 at 03:58 PM
#
# $Id: upgrade-04-to-041.sql,v 1.1 2004-02-13 01:14:12 decoyduck Exp $
#
# --------------------------------------------------------#

ALTER TABLE THREAD ADD ADMIN_LOCK DATETIME;
UPDATE THREAD SET ADMIN_LOCK = 0 WHERE 1;

ALTER TABLE PM ADD NOTIFIED TINYINT UNSIGNED DEFAULT '0' NOT NULL;
UPDATE PM SET NOTIFIED = 1 WHERE TYPE > 1;