/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

function getFormObj(obj_id) {

    var form_obj;

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    return form_obj;
}

function disable_button (button) {

    if (document.all || document.getElementById) {
        button.disabled = true;
    } else if (button) {
        button.onclick = null;
    }
    return true;
}

function confirm_install(button) {

    var install_type = getFormObj('install_method');
    var install_form = getFormObj('install_form');

    if (install_type.selectedIndex == 1) {
        confirm_text = 'Are you sure you want to perform a reinstall? Any existing BeehiveForum tables and their data will be permenantly lost!\n\n';
	confirm_text+= 'If you haven\'t performed a backup of your database and files now would be a good time to do it! Don\'t say we didn\'t warn you!';
    }else if (install_type.selectedIndex == 2) {
        confirm_text = 'Are you sure you want to perform a reconnect? Any customised values in your config.inc.php file will be lost!\n\n';
	confirm_text+= 'If you haven\'t performed a backup of your database and files now would be a good time to do it! Don\'t say we didn\'t warn you!';
    }else if (install_type.selectedIndex > 2) {
        confirm_text = 'Are you sure you want to perform an upgrade? If you have selected the wrong upgrade method your forum may become unusable!\n\n';
	confirm_text+= 'If you haven\'t performed a backup of your database and files now would be a good time to do it! Don\'t say we didn\'t warn you!';
    }

    if (install_type.selectedIndex > 0) {

        if (window.confirm(confirm_text)) {

            disable_button(button);
            install_form.submit();
            return true;
        }

        return false;
    }
}

function show_install_help(topic) {

    if (topic == 0) {

      topic_text = 'For new installations please select \'New Install\' from the drop down and enter a webtag.\n\n';
      topic_text+= 'Your webtag can be anything you want as long as it only contains the characters A-Z, 0-9, underscore and hyphen. If you enter any other characters an error will occur.\n\n';
      topic_text+= 'For reinstalls enter a webtag as above. Any existing BeehiveForum tables will be automatically removed and all data within them will be permenantly lost.\n\n';
      topic_text+= 'For reconnects the database setup is skipped and the installation simply rewrites your config.inc.php file. Use this if for example you\'re moving hosts. The webtag field is ignored.\n\n';
      topic_text+= 'For upgrades please select the correct upgrade process. The webtag field is ignored.';

    } else if (topic == 1) {

      topic_text = 'These are the MySQL database details required by to install and run your BeehiveForum.\n\n';
      topic_text+= 'Hostname: The address of the MySQL server. This may be an IP or a DNS for example 127.0.0.1 or localhost or mysql.myhosting.com\n\n';
      topic_text+= 'Database name: The name of the database you want your BeehiveForum to use. The database must already exist and you must have at least SELECT, INSERT, UPDATE, CREATE, ALTER, INDEX and DROP privilleges on the database for the installation and your BeehiveForum to work correctly.\n\n';
      topic_text+= 'Username: The username needed to connect to the MySQL server.\n';
      topic_text+= 'Password: The password needed to connect to the MySQL server.\n\n';
      topic_text+= 'If you do not know what these settings are please contact your hosting provider.';

    } else if (topic == 2) {

      topic_text = 'The credentials of the user you want to have initial Admin access. This information is only required for new installations. Upgrades will leave the existing user accounts intact.';

    } else if (topic == 3) {

      topic_text = 'These options are recommended for advanced users only. There use can have a detrimental effect on the functionality of your BeehiveForum AND other software you may have installed.\n\n';
      topic_text+= 'USE WITH EXTREME CAUTION!';
    }

    alert(topic_text);
    return true;
}
