<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
// End Required includes

// Don't cache this page
cache_disable();

// Retrieve the final_uri request
if (isset($_GET['final_uri']) && strlen(trim($_GET['final_uri'])) > 0) {

    $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

    if (preg_match("/^$available_files_preg/u", trim($_GET['final_uri'])) > 0) {
        $final_uri = href_cleanup_query_keys($_GET['final_uri']);
    }

} else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;msg=". $_GET['msg'];

} else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $final_uri = "discussion.php?webtag=$webtag&amp;folder=". $_GET['folder'];

} else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

    $final_uri = "pm.php?webtag=$webtag&amp;mid=". $_GET['pmid'];
}

// Delete the user's cookie as requested and send them back to the login form.
if (isset($_GET['deletecookie']) && ($_GET['deletecookie'] == 'yes')) {

    html_remove_all_cookies();

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);
        header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", gettext("Cookies successfully deleted"));

    } else {

        header_redirect("index.php?webtag=$webtag", gettext("Cookies successfully deleted"));
    }

} else if (isset($_POST['logon']) || isset($_POST['guest_logon'])) {

    if (logon_perform(true)) {

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", gettext("You logged in successfully."));

        } else {

            header_redirect("index.php?webtag=$webtag", gettext("You logged in successfully."));
        }

    } else {

        if (isset($final_uri)) {

            $final_uri = rawurlencode(sprintf("logon.php?webtag=$webtag&logon_failed=true&final_uri=%s", rawurlencode($final_uri)));
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", gettext("The username or password you supplied is not valid."));

        } else {

            $final_uri = rawurlencode("logon.php?webtag=$webtag&logon_failed=true");
            header_redirect("index.php?webtag=$webtag&final_uri=$final_uri", gettext("The username or password you supplied is not valid."));
        }
    }

} else if (isset($_POST['other_logon'])) {

    if (isset($final_uri)) {

        $final_uri = rawurlencode($final_uri);
        header_redirect("index.php?webtag=$webtag&other_logon=true&final_uri=$final_uri");

    } else {

        header_redirect("index.php?webtag=$webtag&other_logon=true");
    }
}

html_draw_top("js/logon.js");

echo "<div align=\"center\">\n";

logon_draw_form(LOGON_FORM_DEFAULT);

echo "</div>\n";

html_draw_bottom();

?>