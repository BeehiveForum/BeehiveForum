<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Use this script in a CRON job or other schedule to index
// your forum's posts automatically. How often you want the
// script to be executed is entirely up to you, but we recommend
// no more than once every 5 minutes. Whatever value you choose
// remember that this script will only index *1* post each time
// it is run so if you have a lot of posts it could be some time
// before your entire database is indexed.

// You can optionally add the webtag of the forum you wish to index
// as a command line argument to the script if you run multiple
// forums on your Beehive Forum installation. If you don't specify
// a webtag or you specify an invalid webtag the script will index
// your default forum only. If you do not have a default forum no
// posts will be indexed.

// Example command line:

// php /home/account_name/public_html/forum/search_index.php WEBTAG

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

include_once(BH_INCLUDE_PATH. "search.inc.php");

echo "Search Indexing is no longer required by Beehive Forum 0.6.2 and higher";

?>