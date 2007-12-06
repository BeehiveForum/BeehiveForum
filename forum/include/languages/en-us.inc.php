<?php

/*======================================================================
Copyright Project Beehive Forum 2002-2007

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

/* $Id: en-us.inc.php,v 1.34 2007-12-02 11:45:18 decoyduck Exp $ */

// American English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-us";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "January";
$lang['month'][2]  = "February";
$lang['month'][3]  = "March";
$lang['month'][4]  = "April";
$lang['month'][5]  = "May";
$lang['month'][6]  = "June";
$lang['month'][7]  = "July";
$lang['month'][8]  = "August";
$lang['month'][9]  = "September";
$lang['month'][10] = "October";
$lang['month'][11] = "November";
$lang['month'][12] = "December";

$lang['month_short'][1]  = "Jan";
$lang['month_short'][2]  = "Feb";
$lang['month_short'][3]  = "Mar";
$lang['month_short'][4]  = "Apr";
$lang['month_short'][5]  = "May";
$lang['month_short'][6]  = "Jun";
$lang['month_short'][7]  = "Jul";
$lang['month_short'][8]  = "Aug";
$lang['month_short'][9]  = "Sep";
$lang['month_short'][10] = "Oct";
$lang['month_short'][11] = "Nov";
$lang['month_short'][12] = "Dec";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by Beehive Forum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by Beehive Forum.

$lang['date_periods']['year']   = "%s year";
$lang['date_periods']['month']  = "%s month";
$lang['date_periods']['week']   = "%s week";
$lang['date_periods']['day']    = "%s day";
$lang['date_periods']['hour']   = "%s hour";
$lang['date_periods']['minute'] = "%s minute";
$lang['date_periods']['second'] = "%s second";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s years";
$lang['date_periods_plural']['month']  = "%s months";
$lang['date_periods_plural']['week']   = "%s weeks";
$lang['date_periods_plural']['day']    = "%s days";
$lang['date_periods_plural']['hour']   = "%s hours";
$lang['date_periods_plural']['minute'] = "%s minutes";
$lang['date_periods_plural']['second'] = "%s seconds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%smin";  // 6min
$lang['date_periods_short']['second'] = "%ssec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "Percent";
$lang['average'] = "Average";
$lang['approve'] = "Approve";
$lang['banned'] = "Banned";
$lang['locked'] = "Locked";
$lang['add'] = "Add";
$lang['advanced'] = "Advanced";
$lang['active'] = "Active";
$lang['style'] = "Style";
$lang['go'] = "Go";
$lang['folder'] = "Folder";
$lang['ignoredfolder'] = "Ignored Folder";
$lang['folders'] = "Folders";
$lang['thread'] = "thread";
$lang['threads'] = "threads";
$lang['threadlist'] = "Thread List";
$lang['message'] = "Message";
$lang['messagenumber'] = "Message Number";
$lang['from'] = "From";
$lang['to'] = "To";
$lang['all_caps'] = "ALL";
$lang['of'] = "of";
$lang['reply'] = "Reply";
$lang['forward'] = "Forward";
$lang['replyall'] = "Reply to All";
$lang['pm_reply'] = "Reply as PM";
$lang['delete'] = "Delete";
$lang['deleted'] = "Deleted";
$lang['edit'] = "Edit";
$lang['privileges'] = "Privileges";
$lang['ignore'] = "Ignore";
$lang['normal'] = "Normal";
$lang['interested'] = "Interested";
$lang['subscribe'] = "Subscribe";
$lang['apply'] = "Apply";
$lang['download'] = "Download";
$lang['save'] = "Save";
$lang['update'] = "Update";
$lang['cancel'] = "Cancel";
$lang['continue'] = "Continue";
$lang['attachment'] = "Attachment";
$lang['attachments'] = "Attachments";
$lang['imageattachments'] = "Image Attachments";
$lang['filename'] = "Filename";
$lang['dimensions'] = "Dimensions";
$lang['downloadedxtimes'] = "Downloaded: %d times";
$lang['downloadedonetime'] = "Downloaded: 1 time";
$lang['size'] = "Size";
$lang['viewmessage'] = "View Message";
$lang['deletethumbnails'] = "Delete Thumbnails";
$lang['logon'] = "Logon";
$lang['more'] = "More";
$lang['recentvisitors'] = "Recent Visitors";
$lang['username'] = "Username";
$lang['clear'] = "Clear";
$lang['action'] = "Action";
$lang['unknown'] = "Unknown";
$lang['none'] = "none";
$lang['preview'] = "Preview";
$lang['post'] = "Post";
$lang['posts'] = "Posts";
$lang['change'] = "Change";
$lang['yes'] = "Yes";
$lang['no'] = "No";
$lang['signature'] = "Signature";
$lang['signaturepreview'] = "Signature Preview";
$lang['signatureupdated'] = "Signature Updated";
$lang['signatureupdatedforallforums'] = "Signature Updated For All Forums";
$lang['back'] = "Back";
$lang['subject'] = "Subject";
$lang['close'] = "Close";
$lang['name'] = "Name";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "View";
$lang['enterpasswd'] = "Enter Password";
$lang['passwd'] = "Password";
$lang['ignored'] = "Ignored";
$lang['guest'] = "Guest";
$lang['next'] = "Next";
$lang['prev'] = "Previous";
$lang['others'] = "Others";
$lang['nickname'] = "Nickname";
$lang['emailaddress'] = "Email address";
$lang['confirm'] = "Confirm";
$lang['email'] = "Email";
$lang['poll'] = "Poll";
$lang['friend'] = "Friend";
$lang['success'] = "Success";
$lang['error'] = "Error";
$lang['warning'] = "Warning";
$lang['guesterror'] = "Sorry, you need to be logged in to use this feature.";
$lang['loginnow'] = "Login now";
$lang['unread'] = "unread";
$lang['all'] = "All";
$lang['allcaps'] = "ALL";
$lang['permissions'] = "Permissions";
$lang['type'] = "Type";
$lang['print'] = "Print";
$lang['sticky'] = "Sticky";
$lang['polls'] = "Polls";
$lang['user'] = "User";
$lang['enabled'] = "Enabled";
$lang['disabled'] = "Disabled";
$lang['options'] = "Options";
$lang['emoticons'] = "Emoticons";
$lang['webtag'] = "Webtag";
$lang['makedefault'] = "Make Default";
$lang['unsetdefault'] = "Unset Default";
$lang['rename'] = "Rename";
$lang['pages'] = "Pages";
$lang['used'] = "Used";
$lang['days'] = "days";
$lang['usage'] = "Usage";
$lang['show'] = "Show";
$lang['hint'] = "Hint";
$lang['new'] = "New";
$lang['referer'] = "Referer";
$lang['thefollowingerrorswereencountered'] = "The following errors were encountered:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "Admin Tools";
$lang['forummanagement'] = "Forum Management";
$lang['accessdeniedexp'] = "You do not have permission to use this section.";
$lang['managefolders'] = "Manage Folders";
$lang['manageforums'] = "Manage Forums";
$lang['manageforumpermissions'] = "Manage Forum Permissions";
$lang['foldername'] = "Folder Name";
$lang['move'] = "Move";
$lang['closed'] = "Closed";
$lang['open'] = "Open";
$lang['restricted'] = "Restricted";
$lang['forumiscurrentlyclosed'] = "%s is currently closed";
$lang['youdonothaveaccesstoforum'] = "You do not have access to %s";
$lang['toapplyforaccessplease'] = "To apply for access please contact the forum owner.";
$lang['adminforumclosedtip'] = "If you want to change some settings on your forum click the Admin link in the navigation bar above.";
$lang['newfolder'] = "New Folder";
$lang['nofoldersfound'] = "No existing folders found. To add a folder click the 'Add New' button below.";
$lang['forumadmin'] = "Forum Admin";
$lang['adminexp_1'] = "Use the menu on the left to manage things in your forum.";
$lang['adminexp_2'] = "<b>Users</b> allows you to set individual user permissions, including appointing moderators and gagging people.";
$lang['adminexp_3'] = "<b>User Groups</b> allows you to create User Groups to assign permissions to as many or as few users quickly and easily.";
$lang['adminexp_4'] = "<b>Ban Controls</b> allows the banning and un-banning of IP Addresses, HTTP Referers, Usernames, Email addresses and Nicknames.";
$lang['adminexp_5'] = "<b>Folders</b> allows the creation, modification and deletion of folders.";
$lang['adminexp_6'] = "<b>RSS Feeds</b> allows you to manage RSS feeds for propagation into your forum.";
$lang['adminexp_7'] = "<b>Profiles</b> lets you customise the items that appear in the user profiles.";
$lang['adminexp_8'] = "<b>Forum Settings</b> allows you to customise your forum's name, appearance and many other things.";
$lang['adminexp_9'] = "<b>Start Page</b> lets you customise your forum's start page.";
$lang['adminexp_10'] = "<b>Forum style</b> allows you to generate random styles for your forum members to use.";
$lang['adminexp_11'] = "<b>Word filter</b> allows you to filter words you don't want to be used on your forum.";
$lang['adminexp_12'] = "<b>Posting stats</b> generates a report listing the top 10 posters in a defined period.";
$lang['adminexp_13'] = "<b>Forum links</b> lets you manage the links dropdown in the navigation bar.";
$lang['adminexp_14'] = "<b>View log</b> lists recent actions by the forum moderators.";
$lang['adminexp_15'] = "<b>Manage Forums</b> lets you create and delete and close or reopen forums.";
$lang['adminexp_16'] = "<b>Global Forum Settings</b> allows you to modify settings which affect all forums.";
$lang['adminexp_17'] = "<b>Post Approval Queue</b> allows you to view any posts awaiting approval by a moderator.";
$lang['adminexp_18'] = "<b>Visitor Log</b> allows you to view an extended list of visitors including their HTTP referers.";
$lang['createforumstyle'] = "Create a Forum Style";
$lang['newstylesuccessfullycreated'] = "New style successfully created.";
$lang['stylealreadyexists'] = "A style with that filename already exists.";
$lang['stylenofilename'] = "You did not enter a filename to save the style with.";
$lang['stylenodatasubmitted'] = "Could not read forum style data.";
$lang['styleexp'] = "Use this page to help create a randomly generated style for your forum.";
$lang['stylecontrols'] = "Controls";
$lang['stylecolourexp'] = "Click on a color to make a new style sheet based on that color. Current base color is first in list.";
$lang['standardstyle'] = "Standard Style";
$lang['rotelementstyle'] = "Rotated Element Style";
$lang['randstyle'] = "Random Style";
$lang['thiscolour'] = "This Color";
$lang['enterhexcolour'] = "or enter a hex color to base a new style sheet on";
$lang['savestyle'] = "Save this style";
$lang['styledesc'] = "Style Description";
$lang['stylefilenamemayonlycontain'] = "Style filename may only contain lowercase letters (a-z), numbers (0-9) and underscore.";
$lang['stylepreview'] = "Style Preview";
$lang['welcome'] = "Welcome";
$lang['messagepreview'] = "Message Preview";
$lang['users'] = "Users";
$lang['usergroups'] = "User Groups";
$lang['mustentergroupname'] = "You must enter a group name";
$lang['profiles'] = "Profiles";
$lang['manageforums'] = "Manage Forums";
$lang['forumsettings'] = "Forum Settings";
$lang['globalforumsettings'] = "Global Forum Settings";
$lang['settingsaffectallforumswarning'] = "<b>Note:</b> These settings affect all forums. Where the setting is duplicated on the individual Forum's settings page that will take precedence over the settings you change here.";
$lang['startpage'] = "Start Page";
$lang['startpageerror'] = "Your start page could not be saved locally to the server because permission was denied.</p><p>To change your start page please click the download button below which will prompt you to save the file to your hard drive. You can then upload this file to your server into the following folder, if necessary creating the folder structure in the process.</p><p><b>%s</b></p><p>Please note that some browsers may change the name of the file upon download.  When uploading the file please make sure that it is named start_main.php otherwise your start page will appear unchanged.";
$lang['failedtoopenmasterstylesheet'] = "Your forum style could not be saved because the master style sheet could not be loaded. To save your style the master style sheet (make_style.css) must be located in the styles directory of your Beehive Forum installation.";
$lang['makestyleerror'] = "Your forum style could not be saved locally to the server because permission was denied. To save your forum style please click the download button below which will prompt you to save the file to your hard drive. You can then upload this file to your server into %s folder, if necessary creating the folder structure in the process. You should note that some browsers may change the name of the file upon download. When uploading the file please make sure that it is named style.css otherwise the forum style will be unusable.";
$lang['forumstyle'] = "Forum Style";
$lang['wordfilter'] = "Word Filter";
$lang['forumlinks'] = "Forum Links";
$lang['viewlog'] = "View Log";
$lang['noprofilesectionspecified'] = "No Profile section specified.";
$lang['itemname'] = "Item Name";
$lang['moveto'] = "Move To";
$lang['manageprofilesections'] = "Manage Profile Sections";
$lang['sectionname'] = "Section Name";
$lang['items'] = "Items";
$lang['mustspecifyaprofilesectionid'] = "Must specify a profile section ID";
$lang['mustsepecifyaprofilesectionname'] = "Must specify a profile section name";
$lang['noprofilesectionsfound'] = "No existing profile sections found. To add a profile section click the 'Add New' button below.";
$lang['addnewprofilesection'] = "Add new profile section";
$lang['successfullyaddedprofilesection'] = "Successfully added profile section";
$lang['successfullyeditedprofilesection'] = "Successfully edited profile section";
$lang['addnewprofilesection'] = "Add new profile section";
$lang['mustsepecifyaprofilesectionname'] = "Must specify a profile section name";
$lang['successfullyremovedselectedprofilesections'] = "Successfully removed selected profile sections";
$lang['failedtoremoveprofilesections'] = "Failed to remove profile sections";
$lang['viewitems'] = "View items";
$lang['successfullyaddednewprofileitem'] = "Successfully added new profile item";
$lang['successfullyeditedprofileitem'] = "Successfully edited profile item";
$lang['successfullyremovedselectedprofileitems'] = "Successfully removed selected profile items";
$lang['failedtoremoveprofileitems'] = "Failed to remove profile items";
$lang['noexistingprofileitemsfound'] = "There are no existing profile items in this section. To add an item click the 'Add New' button below.";
$lang['edititem'] = "Edit item";
$lang['invalidprofilesectionid'] = "Invalid profile section ID or section not found";
$lang['invalidprofileitemid'] = "Invalid profile item ID or item not found";
$lang['addnewitem'] = "Add new item";
$lang['youmustenteraprofileitemname'] = "You must enter a profile item name";
$lang['invalidprofileitemtype'] = "Invalid profile item type selected";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "You must enter some options for selected profile item type";
$lang['youmustentermorethanoneoptionforitem'] = "You must enter more than one option for selected profile item type";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "Profile item hyperlinks support HTTP URLs only";
$lang['profileitemhyperlinkformatinvalid'] = "Profile item hyperlink format invalid";
$lang['youmustincludeprofileentryinhyperlinks'] = "You must include <i>%s</i> in the URL of clickable hyperlinks";
$lang['failedtocreatenewprofileitem'] = "Failed to create new profile item";
$lang['failedtoupdateprofileitem'] = "Failed to update profile item";
$lang['startpageupdated'] = "Start Page updated. %s";
$lang['viewupdatedstartpage'] = "View updated Start Page";
$lang['editstartpage'] = "Edit Start Page";
$lang['nouserspecified'] = "No user specified.";
$lang['manageuser'] = "Manage User";
$lang['manageusers'] = "Manage Users";
$lang['userstatusforforum'] = "User Status for %s";
$lang['userdetails'] = "User Details";
$lang['warning_caps'] = "WARNING";
$lang['userdeleteallpostswarning'] = "Are you sure you want to delete all of the selected user's posts? Once the posts are deleted they cannot be retrieved and will be lost forever.";
$lang['postssuccessfullydeleted'] = "Posts were successfully deleted.";
$lang['folderaccess'] = "Folder Access";
$lang['possiblealiases'] = "Possible Aliases";
$lang['userhistory'] = "User History";
$lang['nohistory'] = "No History Records Saved";
$lang['userhistorychanges'] = "Changes";
$lang['clearuserhistory'] = "Clear User History";
$lang['changedlogonfromto'] = "Changed Logon from %s to %s";
$lang['changednicknamefromto'] = "Changed Nickname from %s to %s";
$lang['changedemailfromto'] = "Changed Email from %s to %s";
$lang['successfullycleareduserhistory'] = "Successfully cleared user history";
$lang['failedtoclearuserhistory'] = "Failed to clear user history";
$lang['successfullychangedpassword'] = "Successfully Changed Password";
$lang['failedtochangepasswd'] = "Failed To Change Password";
$lang['viewuserhistory'] = "View User History";
$lang['viewuseraliases'] = "View User Aliases";
$lang['searchreturnednoresults'] = "Search Returned No Results";
$lang['deleteposts'] = "Delete Posts";
$lang['deleteuser'] = "Delete User";
$lang['alsodeleteusercontent'] = "Also delete all of the content created by this user";
$lang['userdeletewarning'] = "Are you sure you want to delete the selected user account? Once the account has been deleted it cannot be retrieved and will be lost forever.";
$lang['usersuccessfullydeleted'] = "User Successfully Deleted";
$lang['failedtodeleteuser'] = "Failed To Delete User";
$lang['forgottenpassworddesc'] = "If this user has forgotten their password you can reset it for them here.";
$lang['manageusersexp'] = "This list shows a selection of users who have logged on to your forum, sorted by %s. To alter a user's permissions click their name.";
$lang['userfilter'] = "User filter";
$lang['onlineusers'] = "Online users";
$lang['offlineusers'] = "Offline users";
$lang['usersawaitingapproval'] = "Users awaiting approval";
$lang['bannedusers'] = "Banned users";
$lang['lastlogon'] = "Last Logon";
$lang['sessionreferer'] = "Session Referer";
$lang['signupreferer'] = "Sign-up Referer:";
$lang['nouseraccountsmatchingfilter'] = "No user accounts matching filter";
$lang['searchforusernotinlist'] = "Search for a user not in list";
$lang['adminaccesslog'] = "Admin Access Log";
$lang['adminlogexp'] = "This list shows the last actions sanctioned by users with Admin privileges.";
$lang['datetime'] = "Date/Time";
$lang['unknownuser'] = "Unknown user";
$lang['unknownuseraccount'] = "Unknown user account";
$lang['unknownfolder'] = "Unknown folder";
$lang['ip'] = "IP";
$lang['lastipaddress'] = "Last IP Address";
$lang['logged'] = "Logged";
$lang['notlogged'] = "Not Logged";
$lang['addwordfilter'] = "Add word filter";
$lang['addnewwordfilter'] = "Add New Word Filter";
$lang['wordfilterupdated'] = "Word Filter updated";
$lang['filtername'] = "Filter Name";
$lang['filtertype'] = "Filter Type";
$lang['filterenabled'] = "Filter Enabled";
$lang['editwordfilter'] = "Edit Word Filter";
$lang['nowordfilterentriesfound'] = "No existing word filter entries found. To add a filter click the 'Add New' button below.";
$lang['mustspecifyfiltername'] = "You must specify a filter name";
$lang['mustspecifymatchedtext'] = "You must specify matched text";
$lang['mustspecifyfilteroption'] = "You must specify a filter option";
$lang['mustspecifyfilterid'] = "You must specify a filter ID";
$lang['invalidfilterid'] = "Invalid Filter ID";
$lang['failedtoupdatewordfilter'] = "Failed to update word filter. Check that the filter still exists.";
$lang['allow'] = "Allow";
$lang['block'] = "Block";
$lang['normalthreadsonly'] = "Normal threads only";
$lang['pollthreadsonly'] = "Poll threads only";
$lang['both'] = "Both thread types";
$lang['existingpermissions'] = "Existing Permissions";
$lang['nousershavebeengrantedpermission'] = "No existing users permissions found. To grant permission to users search for them below.";
$lang['successfullyaddedpermissionsforselectedusers'] = "Successfully added permissions for selected users";
$lang['successfullyremovedpermissionsfromselectedusers'] = "Successfully removed permissions from selected users";
$lang['failedtoaddpermissionsforuser'] = "Failed to add permissions for user '%s'";
$lang['failedtoremovepermissionsfromuser'] = "Failed to remove permissions from user '%s'";
$lang['searchforuser'] = "Search For User";
$lang['browsernegotiation'] = "Browser negotiated";
$lang['largetextfield'] = "Large Text Field";
$lang['mediumtextfield'] = "Medium Text Field";
$lang['smalltextfield'] = "Small Text Field";
$lang['multilinetextfield'] = "Multi-line Text Field";
$lang['radiobuttons'] = "Radio Buttons";
$lang['dropdownlist'] = "Drop Down List";
$lang['clickablehyperlink'] = "Clickable Hyperlink";
$lang['threadcount'] = "Thread Count";
$lang['clicktoeditfolder'] = "Click To Edit Folder";
$lang['fieldtypeexample1'] = "To create Radio Buttons or a Drop Down List you need to enter each individual value on a separate line in the Options field.";
$lang['fieldtypeexample2'] = "To create clickable links enter the URL in the Options field and use <i>%1\$s</i> where the entry from the user's profile should appear. Examples: <p>MySpace: <i>http://www.myspace.com/%1\$s</i><br />Xbox LIVE: <i>http://profile.mygamercard.net/%1\$s</i>";
$lang['editedwordfilter'] = "Edited Word Filter";
$lang['editedforumsettings'] = "Edited Forum Settings";
$lang['successfullyendedusersessionsforselectedusers'] = "Successfully ended sessions for selected users";
$lang['failedtoendsessionforuser'] = "Failed to end session for user %s";
$lang['successfullyapprovedselectedusers'] = "Successfully approved selected users";
$lang['matchedtext'] = "Matched Text";
$lang['replacementtext'] = "Replacement Text";
$lang['preg'] = "PREG";
$lang['wholeword'] = "Whole Word";
$lang['word_filter_help_1'] = "<b>All</b> matches against the whole text so filtering mom to mum will also change moment to mument.";
$lang['word_filter_help_2'] = "<b>Whole Word</b> matches against whole words only so filtering mom to mum will NOT change moment to mument.";
$lang['word_filter_help_3'] = "<b>PREG</b> allows you to use Perl Regular Expressions to match text.";
$lang['nameanddesc'] = "Name and Description";
$lang['movethreads'] = "Move Threads";
$lang['movethreadstofolder'] = "Move threads to folder";
$lang['failedtomovethreads'] = "Failed to move threads to specified folder";
$lang['resetuserpermissions'] = "Reset user permissions";
$lang['failedtoresetuserpermissions'] = "Failed to reset user permissions";
$lang['allowfoldertocontain'] = "Allow folder to contain";
$lang['addnewfolder'] = "Add New Folder";
$lang['mustenterfoldername'] = "You must enter a folder name";
$lang['nofolderidspecified'] = "No Folder ID specified";
$lang['invalidfolderid'] = "Invalid Folder ID. Check that a folder with this ID exists!";
$lang['successfullyaddednewfolder'] = "Successfully added new folder";
$lang['successfullyremovedselectedfolders'] = "Successfully removed selected folders";
$lang['successfullyeditedfolder'] = "Successfully edited folder";
$lang['failedtocreatenewfolder'] = "Failed to create new folder";
$lang['failedtodeletefolder'] = "Failed to delete folder.";
$lang['failedtoupdatefolder'] = "Failed to update folder";
$lang['cannotdeletefolderwiththreads'] = "Cannot delete folders that still contain threads.";
$lang['forumisnotrestricted'] = "Forum is not restricted";
$lang['groups'] = "Groups";
$lang['nousergroups'] = "No User Groups have been set up. To add a group click the 'Add New' button below.";
$lang['suppliedgidisnotausergroup'] = "Supplied GID is not a user group";
$lang['manageusergroups'] = "Manage User Groups";
$lang['groupstatus'] = "Group Status";
$lang['addusergroup'] = "Add User Group";
$lang['addemptygroup'] = "Add Empty Group";
$lang['adduserstogroup'] = "Add Users To Group";
$lang['addremoveusers'] = "Add/Remove Users";
$lang['nousersingroup'] = "There are no users in this group. Add users to this group by searching for them below.";
$lang['groupaddedaddnewuser'] = "Successfully added group. Add users to this group by searching for them below.";
$lang['nousersingroupaddusers'] = "There are no users in this group. To add users click the 'Add/Remove Users' button below.";
$lang['useringroups'] = "This user is a member of the following groups";
$lang['usernotinanygroups'] = "This user is not in any user groups";
$lang['usergroupwarning'] = "Note: This user may be inheriting additional permissions from any user groups listed below.";
$lang['successfullyaddedgroup'] = "Successfully added group";
$lang['successfullyeditedgroup'] = "Successfully edited group";
$lang['successfullydeletedselectedgroups'] = "Successfully deleted selected groups";
$lang['failedtodeletegroupname'] = "Failed to delete group %s";
$lang['usercanaccessforumtools'] = "User can access forum tools and can create, delete and edit forums";
$lang['usercanmodallfoldersonallforums'] = "User can moderate <b>all folders</b> on <b>all forums</b>";
$lang['usercanmodlinkssectiononallforums'] = "User can moderate links section on <b>all forums</b>";
$lang['emailconfirmationrequired'] = "Email confirmation required";
$lang['userisbannedfromallforums'] = "User is banned from <b>all forums</b>";
$lang['cancelemailconfirmation'] = "Cancel email confirmation and allow user to start posting";
$lang['resendconfirmationemail'] = "Resend confirmation email to user";
$lang['donothing'] = "Do nothing";
$lang['usercanaccessadmintools'] = "User has access to forum admin tools";
$lang['usercanaccessadmintoolsonallforums'] = "User has access to admin tools <b>on all forums</b>";
$lang['usercanmoderateallfolders'] = "User can moderate all folders";
$lang['usercanmoderatelinkssection'] = "User can moderate Links section";
$lang['userisbanned'] = "User is banned";
$lang['useriswormed'] = "User is wormed";
$lang['userispilloried'] = "User is pilloried";
$lang['usercanignoreadmin'] = "User can ignore administrators";
$lang['groupcanaccessadmintools'] = "Group can access admin tools";
$lang['groupcanmoderateallfolders'] = "Group can moderate all folders";
$lang['groupcanmoderatelinkssection'] = "Group can moderate Links sections";
$lang['groupisbanned'] = "Group is banned";
$lang['groupiswormed'] = "Group is wormed";
$lang['readposts'] = "Read Posts";
$lang['replytothreads'] = "Reply to threads";
$lang['createnewthreads'] = "Create new threads";
$lang['editposts'] = "Edit posts";
$lang['deleteposts'] = "Delete posts";
$lang['postssuccessfullydeleted'] = "Posts Successfully Deleted";
$lang['failedtodeleteusersposts'] = "Failed To Delete User's Posts";
$lang['uploadattachments'] = "Upload attachments";
$lang['moderatefolder'] = "Moderate folder";
$lang['postinhtml'] = "Post in HTML";
$lang['postasignature'] = "Post a signature";
$lang['editforumlinks'] = "Edit Forum Links";
$lang['linksaddedhereappearindropdown'] = "Links added here appear in a drop down in the top right of the frame set.";
$lang['linksaddedhereappearindropdownaddnew'] = "Links added here appear in a drop down in the top right of the frame set. To add a link click the 'Add New' button below.";
$lang['failedtoremoveforumlink'] = "Failed to remove forum link '%s'";
$lang['failedtoaddnewforumlink'] = "Failed to add new forum link '%s'";
$lang['failedtoupdateforumlink'] = "Failed to update forum link '%s'";
$lang['notoplevellinktitlespecified'] = "No top level link title specified";
$lang['youmustenteralinktitle'] = "You must enter a link title";
$lang['alllinkurismuststartwithaschema'] = "All link URIs must start with a schema (i.e. http://, ftp://, irc://)";
$lang['editlink'] = "Edit Link";
$lang['addnewforumlink'] = "Add New Forum Link";
$lang['forumlinktitle'] = "Forum Link Title";
$lang['forumlinklocation'] = "Forum Link Location";
$lang['successfullyaddednewforumlink'] = "Successfully added new forum link";
$lang['successfullyeditedforumlink'] = "Successfully edited forum link";
$lang['invalidlinkidorlinknotfound'] = "Invalid link id or link not found";
$lang['successfullyremovedselectedforumlinks'] = "Successfully removed selected links";
$lang['toplinkcaption'] = "Top link caption";
$lang['allowguestaccess'] = "Allow Guest Access";
$lang['searchenginespidering'] = "Search Engine Spidering";
$lang['allowsearchenginespidering'] = "Allow Search Engine Spidering";
$lang['newuserregistrations'] = "New User Registrations";
$lang['preventduplicateemailaddresses'] = "Prevent duplicate email addresses";
$lang['allownewuserregistrations'] = "Allow new user registrations";
$lang['requireemailconfirmation'] = "Require email confirmation";
$lang['usetextcaptcha'] = "Use text-captcha";
$lang['textcaptchadir'] = "Text-captcha directory";
$lang['textcaptchakey'] = "Text-captcha key";
$lang['textcaptchafonterror'] = "Text-captcha has been disabled automatically because there are no true type fonts available for it to use. Please upload some true type fonts to <b>%s</b> on your server.";
$lang['textcaptchadirerror'] = "Text-captcha has been disabled because the text_captcha directory and it's sub-directories are not writable by the web server / PHP process.";
$lang['textcaptchagderror'] = "Text-captcha has been disabled because your server's PHP setup does not provide support for GD Image manipulation and / or TTF font support. Both are required for text-captcha support.";
$lang['textcaptchadirblank'] = "Text-captcha directory is blank!";
$lang['newuserpreferences'] = "New User Preferences";
$lang['sendemailnotificationonreply'] = "Email notification on reply to user";
$lang['sendemailnotificationonpm'] = "Email notification on PM to user";
$lang['showpopuponnewpm'] = "Show popup when receiving new PM";
$lang['setautomatichighinterestonpost'] = "Set automatic high interest on post";
$lang['postingstats'] = "Posting Stats";
$lang['postingstatsforperiod'] = "Posting Stats For Period %s to %s";
$lang['nopostdatarecordedforthisperiod'] = "No post data recorded for this period.";
$lang['totalposts'] = "Total posts";
$lang['totalpostsforthisperiod'] = "Total posts for this period";
$lang['mustchooseastartday'] = "Must choose a start day";
$lang['mustchooseastartmonth'] = "Must choose a start month";
$lang['mustchooseastartyear'] = "Must choose a start year";
$lang['mustchooseaendday'] = "Must choose a end day";
$lang['mustchooseaendmonth'] = "Must choose a end month";
$lang['mustchooseaendyear'] = "Must choose a end year";
$lang['startperiodisaheadofendperiod'] = "Start period is ahead of end period";
$lang['bancontrols'] = "Ban Controls";
$lang['addban'] = "Add Ban";
$lang['checkban'] = "Check Ban";
$lang['editban'] = "Edit Ban";
$lang['bantype'] = "Ban Type";
$lang['bandata'] = "Ban Data";
$lang['bancomment'] = "Comment";
$lang['ipban'] = "IP ban";
$lang['logonban'] = "Logon ban";
$lang['nicknameban'] = "Nickname ban";
$lang['emailban'] = "Email ban";
$lang['refererban'] = "Referer ban";
$lang['invalidbanid'] = "Invalid Ban ID";
$lang['affectsessionwarnadd'] = "This ban may affect the following active user sessions";
$lang['noaffectsessionwarn'] = "This ban affects no active sessions";
$lang['mustspecifybantype'] = "You must specify a ban type";
$lang['mustspecifybandata'] = "You must specify some ban data";
$lang['successfullyremovedselectedbans'] = "Successfully removed selected bans";
$lang['failedtoaddnewban'] = "Failed to add new ban";
$lang['failedtoremovebans'] = "Failed to remove some or all of the selected bans";
$lang['duplicatebandataentered'] = "Duplicate ban data entered. Please check your wildcards to see if they already match the data entered";
$lang['successfullyaddedban'] = "Successfully added ban";
$lang['successfullyupdatedban'] = "Successfully updated ban";
$lang['noexistingbandata'] = "There is no existing ban data. To add a ban click the 'Add New' button below.";
$lang['youcanusethepercentwildcard'] = "You can use the percent (%) wildcard symbol in any of your ban lists to obtain partial matches, i.e. '192.168.0.%' would ban all IP Addresses in the range 192.168.0.1 through 192.168.0.254";
$lang['cannotusewildcardonown'] = "You cannot add % as a wildcard match on it's own!";
$lang['requirepostapproval'] = "Require Post Approval";
$lang['adminforumtoolsusercounterror'] = "There must be at least 1 user with admin tools and forum tools access on all forums!";
$lang['postcount'] = "Post Count";
$lang['resetpostcount'] = "Reset Post Count";
$lang['failedtoresetuserpostcount'] = "Failed To Reset Post Count";
$lang['failedtochangeuserpostcount'] = "Failed To Change User Post Count";
$lang['postapprovalqueue'] = "Post Approval Queue";
$lang['nopostsawaitingapproval'] = "No posts are awaiting approval";
$lang['approveselected'] = "Approve selected";
$lang['failedtoapproveuser'] = "Failed to approve user %s";
$lang['kickselected'] = "Kick selected";
$lang['visitorlog'] = "Visitor Log";
$lang['clearvisitorlog'] = "Clear Visitor Log";
$lang['novisitorslogged'] = "No Visitors Logged";
$lang['addselectedusers'] = "Add Selected Users";
$lang['removeselectedusers'] = "Remove Selected Users";
$lang['addnew'] = "Add New";
$lang['deleteselected'] = "Delete Selected";
$lang['forumrulesmessage'] = "<p><b>Forum Rules</b></p><p>\nRegistration to %1\$s is free! We do insist that you abide by the rules and policies detailed below. If you agree to the terms, please check the 'I agree' checkbox and press the 'Register' button below. If you would like to cancel the registration, click %2\$s to return to the forums index.</p><p>\nAlthough the administrators and moderators of %1\$s will attempt to keep all objectionable messages off this forum, it is impossible for us to review all messages. All messages express the views of the author, and neither the owners of %1\$s, nor Project Beehive Forum and it's affiliates will be held responsible for the content of any message.</p><p>\nBy agreeing to these rules, you warrant that you will not post any messages that are obscene, vulgar, sexually-orientated, hateful, threatening, or otherwise violative of any laws.</p><p>The owners of %1\$s reserve the right to remove, edit, move or close any thread for any reason.</p>";
$lang['cancellinktext'] = "here";
$lang['failedtoupdateforumsettings'] = "Failed to update forum settings. Please try again later.";
$lang['moreadminoptions'] = "More Admin Options";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "Changed user status for '%s'";
$lang['changedpasswordforuser'] = "Changed password for '%s'";
$lang['changedforumaccess'] = "Changed forum access permissions for '%s'";
$lang['deletedallusersposts'] = "Deleted all posts for '%s'";

$lang['createdusergroup'] = "Created User Group '%s'";
$lang['deletedusergroup'] = "Deleted User Group '%s'";
$lang['updatedusergroup'] = "Updated User Group '%s'";
$lang['addedusertogroup'] = "Added user '%s' to group '%s'";
$lang['removeduserfromgroup'] = "Remove user '%s' from group '%s'";

$lang['addedipaddresstobanlist'] = "Added IP '%s' to ban list";
$lang['removedipaddressfrombanlist'] = "Removed IP '%s' from ban list";

$lang['addedlogontobanlist'] = "Added logon '%s' to ban list";
$lang['removedlogonfrombanlist'] = "Removed logon '%s' from ban list";

$lang['addednicknametobanlist'] = "Added nickname '%s' to ban list";
$lang['removednicknamefrombanlist'] = "Removed nickname '%s' from ban list";

$lang['addedemailtobanlist'] = "Added email address '%s' to ban list";
$lang['removedemailfrombanlist'] = "Removed email address '%s' from ban list";

$lang['addedreferertobanlist'] = "Added referer '%s' to ban list";
$lang['removedrefererfrombanlist'] = "Removed referer '%s' from ban list";

$lang['editedfolder'] = "Edited Folder '%s'";
$lang['movedallthreadsfromto'] = "Moved all threads from '%s' to '%s'";
$lang['creatednewfolder'] = "Created new folder '%s'";
$lang['deletedfolder'] = "Deleted folder '%s'";

$lang['changedprofilesectiontitle'] = "Changed Profile section title from '%s' to '%s'";
$lang['addednewprofilesection'] = "Added New Profile section '%s'";
$lang['deletedprofilesection'] = "Deleted Profile Section '%s'";

$lang['addednewprofileitem'] = "Added New Profile Item '%s' to section '%s'";
$lang['changedprofileitem'] = "Changed Profile Item '%s'";
$lang['deletedprofileitem'] = "Deleted Profile Item '%s'";

$lang['editedstartpage'] = "Edited Start Page";
$lang['savednewstyle'] = "Saved New Style '%s'";

$lang['movedthread'] = "Moved Thread '%s' from '%s' to '%s'";
$lang['closedthread'] = "Closed Thread '%s'";
$lang['openedthread'] = "Opened Thread '%s'";
$lang['renamedthread'] = "Renamed Thread '%s' to '%s'";

$lang['deletedthread'] = "Deleted Thread '%s'";
$lang['undeletedthread'] = "Undeleted Thread '%s'";

$lang['lockedthreadtitlefolder'] = "Locked thread options on '%s'";
$lang['unlockedthreadtitlefolder'] = "Unlocked thread options on '%s'";

$lang['deletedpostsfrominthread'] = "Deleted posts from '%s' in thread '%s'";
$lang['deletedattachmentfrompost'] = "Deleted attachment '%s' from post '%s'";

$lang['editedforumlinks'] = "Edited Forum Links";
$lang['editedforumlink'] = "Edited Forum Link: '%s'";

$lang['addedforumlink'] = "Added Forum Link: '%s'";
$lang['deletedforumlink'] = "Deleted Forum Link: '%s'";
$lang['changedtoplinkcaption'] = "Changed top link caption from '%s' to '%s'";

$lang['deletedpost'] = "Deleted Post '%s'";
$lang['editedpost'] = "Edited Post '%s'";

$lang['madethreadsticky'] = "Made thread '%s' sticky";
$lang['madethreadnonsticky'] = "Made thread '%s' non-sticky";

$lang['endedsessionforuser'] = "Ended session for user '%s'";

$lang['approvedpost'] = "Approved post '%s'";

$lang['editedwordfilter'] = "Edited Word Filter";

$lang['addedrssfeed'] = "Added RSS Feed '%s'";
$lang['editedrssfeed'] = "Edited RSS Feed '%s'";
$lang['deletedrssfeed'] = "Deleted RSS Feed '%s'";

$lang['updatedban'] = "Updated ban '%s'. Changed type from '%s' to '%s', Changed data from '%s' to '%s'.";

$lang['splitthreadatpostintonewthread'] = "Split thread '%s' at post %s  into new thread '%s'";
$lang['mergedthreadintonewthread'] = "Merged threads '%s' and '%s' into new thread '%s'";

$lang['approveduser'] = "Approved user '%s'";

$lang['forumautoupdatestats'] = "Forum Auto Update: Stats Updated";
$lang['forumautoprunepm'] = "Forum Auto Update: PM Folders Pruned";
$lang['forumautoprunesessions'] = "Forum Auto Update: Sessions Pruned";
$lang['forumautocleanthreadunread'] = "Forum Auto Update: Thread Unread Data Cleaned";
$lang['forumautocleancaptcha'] = "Forum Auto Update: Text-Captcha Images Cleaned";

$lang['adminlogempty'] = "Admin Log is empty";

$lang['youmustspecifyanactiontypetoremove'] = "You must specify an action type to remove";

$lang['removeentriesrelatingtoaction'] = "Remove Entries Relating to Action";
$lang['removeentriesolderthandays'] = "Remove Entries Older Than (Days)";

$lang['successfullyprunedadminlog'] = "Successfully Pruned Admin Log";
$lang['failedtopruneadminlog'] = "Failed To Prune Admin Log";

$lang['prune_log'] = "Prune Log";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "No existing forums found. To create a new forum click the 'Add New' button below.";
$lang['webtaginvalidchars'] = "Webtag can only contain uppercase A-Z, 0-9 and underscore characters";
$lang['databasenameinvalidchars'] = "Database name can only contain a-z, A-Z, 0-9 and underscore characters";
$lang['invalidforumidorforumnotfound'] = "Invalid forum FID or forum not found";
$lang['successfullyupdatedforum'] = "Successfully updated forum";
$lang['failedtoupdateforum'] = "Failed to update forum: '%s'";
$lang['successfullycreatednewforum'] = "Successfully created new forum";
$lang['selectedwebtagisalreadyinuse'] = "The selected webtag is already in use. Please choose another.";
$lang['selecteddatabasecontainsconflictingtables'] = "The selected database contains conflicting tables. Conflicting table names are:";
$lang['forumdeleteconfirmation'] = "Are you sure you want to delete all of the selected forums?";
$lang['forumdeletewarning'] = "Please note that you cannot recover deleted forums. Once deleted a forum and all of it's associated data is permanently removed from the database. If you do not wish to delete the selected forums please click cancel.";
$lang['successfullyremovedselectedforums'] = "Successfully deleted selected forums";
$lang['failedtodeleteforum'] = "Failed to deleted forum: '%s'";
$lang['addforum'] = "Add Forum";
$lang['editforum'] = "Edit Forum";
$lang['visitforum'] = "Visit Forum: %s";
$lang['accesslevel'] = "Access level";
$lang['forumleader'] = "Forum Leader";
$lang['usedatabase'] = "Use Database";
$lang['unknownmessagecount'] = "Unknown";
$lang['forumwebtag'] = "Forum Webtag";
$lang['defaultforum'] = "Default Forum";
$lang['forumdatabasewarning'] = "Please ensure you select the correct database when creating a new forum. Once created a new forum cannot be moved between available databases.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "Global user permissions";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "You must supply a forum webtag";
$lang['mustsupplyforumname'] = "You must supply a forum name";
$lang['mustsupplyforumemail'] = "You must supply a forum email address";
$lang['mustchoosedefaultstyle'] = "You must choose a default forum style";
$lang['mustchoosedefaultemoticons'] = "You must choose default forum emoticons";
$lang['mustsupplyforumaccesslevel'] = "You must supply a forum access level";
$lang['mustsupplyforumdatabasename'] = "You must supply a forum database name";
$lang['unknownemoticonsname'] = "Unknown emoticons name";
$lang['mustchoosedefaultlang'] = "You must choose a default forum language";
$lang['activesessiongreaterthansession'] = "Active session timeout cannot be greater than session timeout";
$lang['attachmentdirnotwritable'] = "Attachment directory and system temporary directory / php.ini 'upload_tmp_dir' must be writable by the web server / PHP process!";
$lang['attachmentdirblank'] = "You must supply a directory to save attachments in";
$lang['mainsettings'] = "Main Settings";
$lang['forumname'] = "Forum Name";
$lang['forumemail'] = "Forum Email";
$lang['forumnoreplyemail'] = "No-Reply Email";
$lang['forumdesc'] = "Forum Description";
$lang['forumkeywords'] = "Forum Keywords";
$lang['defaultstyle'] = "Default Style";
$lang['defaultemoticons'] = "Default Emoticons";
$lang['defaultlanguage'] = "Default Language";
$lang['forumaccesssettings'] = "Forum Access Settings";
$lang['forumaccessstatus'] = "Forum Access Status";
$lang['changepermissions'] = "Change Permissions";
$lang['changepassword'] = "Change Password";
$lang['passwordprotected'] = "Password Protected";
$lang['passwordprotectwarning'] = "You have not set a forum password. If you do not set a password the password protection functionality will be automatically disabled!";
$lang['postoptions'] = "Post Options";
$lang['allowpostoptions'] = "Allow Post Editing";
$lang['postedittimeout'] = "Post Edit Timeout";
$lang['posteditgraceperiod'] = "Post Edit Grace Period";
$lang['wikiintegration'] = "WikiWiki Integration";
$lang['enablewikiintegration'] = "Enable WikiWiki Integration";
$lang['enablewikiquicklinks'] = "Enable WikiWiki Quick Links";
$lang['wikiintegrationuri'] = "WikiWiki Location";
$lang['maximumpostlength'] = "Maximum Post Length";
$lang['postfrequency'] = "Post Frequency";
$lang['enablelinkssection'] = "Enable Links section";
$lang['allowcreationofpolls'] = "Allow creation of polls";
$lang['allowguestvotesinpolls'] = "Allow Guests to vote in polls";
$lang['unreadmessagescutoff'] = "Unread messages cut-off";
$lang['unreadcutoffseconds'] = "seconds";
$lang['disableunreadmessages'] = "Disable unread messages";
$lang['nocutoffdefault'] = "No cut-off (default)";
$lang['1month'] = "1 month";
$lang['6months'] = "6 months";
$lang['1year'] = "1 year";
$lang['customsetbelow'] = "Custom value (set below)";
$lang['searchoptions'] = "Search Options";
$lang['searchfrequency'] = "Search Frequency";
$lang['sessions'] = "Sessions";
$lang['sessioncutoffseconds'] = "Session cut off (seconds)";
$lang['activesessioncutoffseconds'] = "Active session cut off (seconds)";
$lang['stats'] = "Stats";
$lang['hide_stats'] = "Hide Stats";
$lang['show_stats'] = "Show Stats";
$lang['enablestatsdisplay'] = "Enable Stats Display";
$lang['personalmessages'] = "Personal Messages";
$lang['enablepersonalmessages'] = "Enable Personal Messages";
$lang['pmusermessages'] = "PM messages per user";
$lang['allowpmstohaveattachments'] = "Allow Personal Messages to have attachments";
$lang['autopruneuserspmfoldersevery'] = "Auto prune user's PM folders every";
$lang['userandguestoptions'] = "User and Guest Options";
$lang['enableguestaccount'] = "Enable Guest Account";
$lang['listguestsinvisitorlog'] = "List Guests in Visitor Log";
$lang['allowguestaccess'] = "Allow Guest Access";
$lang['userandguestaccesssettings'] = "User and guest access settings";
$lang['allowuserstochangeusername'] = "Allow users to change username";
$lang['requireuserapproval'] = "Require user approval by admin";
$lang['requireforumrulesagreement'] = "Require user to agree to forum rules";
$lang['enableattachments'] = "Enable Attachments";
$lang['attachmentdir'] = "Attachment Dir";
$lang['userattachmentspace'] = "Attachment space per user";
$lang['allowembeddingofattachments'] = "Allow embedding of attachments";
$lang['usealtattachmentmethod'] = "Use Alternative attachment method";
$lang['allowgueststoaccessattachments'] = "Allow Guests to access attachments";
$lang['forumsettingsupdated'] = "Forum settings successfully updated";
$lang['forumstatusmessages'] = "Forum Status Messages";
$lang['forumclosedmessage'] = "Forum Closed Message";
$lang['forumrestrictedmessage'] = "Forum Restricted Message";
$lang['forumpasswordprotectedmessage'] = "Forum Password Protected Message";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>Post Edit Timeout</b> is the time in minutes after posting that a user can edit their post. If set to 0 there is no limit.";
$lang['forum_settings_help_11'] = "<b>Maximum Post Length</b> is the maximum number of characters that will be displayed in a post. If a post is longer than the number of characters defined here it will be cut short and a link added to the bottom to allow users to read the whole post on a separate page.";
$lang['forum_settings_help_12'] = "If you don't want your users to be able to create polls you can disable the above option.";
$lang['forum_settings_help_13'] = "The Links section of Beehive provides a place for your users to maintain a list of sites they frequently visit that other users may find useful. Links can be divided into categories by folder and allow for comments and ratings to be given. In order to moderate the links section a user must be ranted Global Moderator status.";
$lang['forum_settings_help_15'] = "<b>Session cut off</b> is the maximum time before a user's session is deemed dead and they are logged out. By default this is 24 hours (86400 seconds).";
$lang['forum_settings_help_16'] = "<b>Active session cut off</b> is the maximum time before a user's session is deemed inactive at which point they enter an idle state. In this state the user remains logged in, but they are removed from the active users list in the stats display. Once they become active again they will be re-added to the list. By default this setting is set to 15 minutes (900 seconds).";
$lang['forum_settings_help_17'] = "Enabling this option allows Beehive to include a stats display at the bottom of the messages pane similar to the one used by many forum software titles. Once enabled the display of the stats page can be toggled individually by each user. If they don't want to see it they can hide it from view.";
$lang['forum_settings_help_18'] = "Personal Messages are invaluable as a way of taking more private matters out of view of the other members. However if you don't want your users to be able to send each other personal messages you can disable this option.";
$lang['forum_settings_help_19'] = "Personal Messages can also contain attachments which can be useful for exchanging files between users.";
$lang['forum_settings_help_20'] = "<b>Note:</b> The space allocation for PM attachments is taken from each users' main attachment allocation and is not in addition to.";
$lang['forum_settings_help_21'] = "<b>Enable Guest Account</b> allows visitors to browse your forum and read posts without registering a user account. A user account is still required if they wish to post or change user preferences.";
$lang['forum_settings_help_22'] = "<b>List Guests in Visitor Log</b> allows you to specify whether or not unregistered users are listed on the Visitor Log along side registered users.";
$lang['forum_settings_help_23'] = "Beehive allows attachments to be uploaded to messages when posted. If you have limited web space you may which to disable attachments by clearing the box above.";
$lang['forum_settings_help_24'] = "<b>Attachment Dir</b> is the location Beehive should store it's attachments in. This directory must exist on your web space and must be writable by the web server / PHP process otherwise uploads will fail.";
$lang['forum_settings_help_25'] = "<b>Attachment Space Per User</b> is the maximum amount of disk space a user has for attachments. Once this space is used up the user cannot upload any more attachments. By default this is 1MB of space.";
$lang['forum_settings_help_26'] = "<b>Allow embedding of attachments in messages / signatures</b> allows users to embed attachments in posts. Enabling this option while useful can increase your bandwidth usage drastically under certain configurations of PHP. If you have limited bandwidth it is recommended that you disable this option.";
$lang['forum_settings_help_27'] = "<b>Use Alternative attachment method</b> Forces Beehive to use an alternative retrieval method for attachments. If you receive 404 error messages when trying to download attachments from messages try enabling this option.";
$lang['forum_settings_help_28'] = "This setting allows your forum to be spidered by search engines like Google, AltaVista and Yahoo. If you switch this option off your forum will not be included in these search engines results.";
$lang['forum_settings_help_29'] = "<b>Allow new user registrations</b> allows or disallows the creation of new user accounts. Setting the option to no completely disables the registration form.";
$lang['forum_settings_help_30'] = "<b>Enable WikiWiki Integration</b> provides WikiWord support in your Forum posts. A WikiWord is made up of two or more concatenated words with uppercase letters (often referred to as CamelCase). If you write a word this way it will automatically be changed into a hyperlink pointing to your chosen WikiWiki.";
$lang['forum_settings_help_31'] = "<b>Enable WikiWiki Quick Links</b> enables the use of msg:1.1 and User:Logon style extended WikiLinks which create hyperlinks to the specified message / user profile of the specified user.";
$lang['forum_settings_help_32'] = "<b>WikiWiki Location</b> is used to specify the URI of your WikiWiki. When entering the URI use <i>%1\$s</i> to indicate where in the URI the WikiWord should appear, i.e.: <i>http://en.wikipedia.org/wiki/%1\$s</i> would link your WikiWords to %s";
$lang['forum_settings_help_33'] = "<b>Forum Access Status</b> controls how users may access your forum.";
$lang['forum_settings_help_34'] = "<b>Open</b> will allow all users and guests access to your forum without restriction.";
$lang['forum_settings_help_35'] = "<b>Closed</b> prevents access for all users, with the exception of the admin who may still access the admin panel.";
$lang['forum_settings_help_36'] = "<b>Restricted</b> allows to set a list of users who are allowed access to your forum.";
$lang['forum_settings_help_37'] = "<b>Password Protected</b> allows you to set a password to give out to users so they can access your forum.";
$lang['forum_settings_help_38'] = "When setting Restricted or Password Protected mode you will need to save your changes before you can change the user access privileges or password.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"from killing the server.";
$lang['forum_settings_help_40'] = "<b>Post Frequency</b> is the minimum time a user must wait before they can post again. This setting also affects the creation of polls. Set to 0 to disable the restriction.";
$lang['forum_settings_help_41'] = "The above options change the default values for the user registration form. Where applicable other settings will use the forum's own default settings.";
$lang['forum_settings_help_42'] = "<b>Prevent use of duplicate email addresses</b> forces Beehive to check the user accounts against the email address the user is registering with and prompts them to use another if it is already in use.";
$lang['forum_settings_help_43'] = "<b>Require email confirmation</b> when enabled will send an email to each new user with a link that can be used to confirm their email address. Until they confirm their email address they will not be able to post unless their user permissions are changed manually by an admin.";
$lang['forum_settings_help_44'] = "<b>Use text-captcha</b> presents the new user with a mangled image which they must copy a number from into a text field on the registration form. Use this option to prevent automated sign-up via scripts.";
$lang['forum_settings_help_45'] = "<b>Text-captcha directory</b> specifies the location that Beehive will store it's text-captcha images and fonts in. This directory must be writable by the web server / PHP process and must be accessible via HTTP. After you have enabled text-captcha you must upload some true type fonts into the fonts sub-directory of your main text-captcha directory otherwise Beehive will skip the text-captcha during user registration.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"the code.";
$lang['forum_settings_help_47'] = "<b>Post Edit Grace Period</b> allows you to define a period in minutes where users may edit posts without the 'EDITED BY' text appearing on their posts. If set to 0 the 'EDITED BY' text will always appear.";
$lang['forum_settings_help_48'] = "<b>Unread messages cut-off</b> specifies how long unread messages are retained. You may choose from various preset values or enter your own cut-off period in seconds. Threads modified earlier than the defined cut-off period will automatically appear as read.";
$lang['forum_settings_help_49'] = "Choosing <b>Disable unread messages</b> will completely remove unread messages support and remove the relevant options from the discussion type drop down on the thread list.";
$lang['forum_settings_help_50'] = "<b>Require user approval by admin</b> allows you to restrict access by new users until they have been approved by a moderator or admin. Without approval a user cannot access any area of the Beehive Forum installation including individual forums, PM inbox and My Forums sections.";
$lang['forum_settings_help_51'] = "Use <b>Closed Message</b>, <b>Restricted Message</b> and <b>Password Protected Message</b> to customise the message displayed when users access your forum in the various states.";
$lang['forum_settings_help_52'] = "You can use HTML in your messages. Hyperlinks and email addresses will also be automatically converted to links. To use the default Beehive Forum messages clear the fields.";
$lang['forum_settings_help_53'] = "<b>Allow users to change username</b> permits already registered users to change their username. When enabled you can track the changes a user makes to their username via the admin user tools.";
$lang['forum_settings_help_54'] = "Use <b>Forum Rules</b> to enter an Acceptable Use Policy that each user must agree to before registering on your forum.";
$lang['forum_settings_help_55'] = "You can use HTML in your forum rules. Hyperlinks and email addresses will also be automatically converted to links. To use the default Beehive Forum AUP clear the field.";
$lang['forum_settings_help_56'] = "Use <b>No-Reply Email</b> to specify an email address that does not exist or will not be monitored for replies. This email address will be used in the headers for all emails sent from your forum including but not limited to Post and PM notifications, user emails and password reminders.";
$lang['forum_settings_help_57'] = "It is recommended that you use an email address that does not exist to help cut down on spam that may be directed at your main forum email address";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AID not specified.";
$lang['upload'] = "Upload";
$lang['uploadnewattachment'] = "Upload New Attachment";
$lang['waitdotdot'] = "wait..";
$lang['successfullyuploaded'] = "Successfully Uploaded: %s";
$lang['failedtoupload'] = "Failed to upload: %s";
$lang['complete'] = "Complete";
$lang['uploadattachment'] = "Upload a file for attachment to the message";
$lang['enterfilenamestoupload'] = "Enter filename(s) to upload";
$lang['attachmentsforthismessage'] = "Attachments for this message";
$lang['otherattachmentsincludingpm'] = "Other Attachments (including PM Messages and other forums)";
$lang['totalsize'] = "Total Size";
$lang['freespace'] = "Free Space";
$lang['attachmentproblem'] = "There was a problem downloading this attachment. Please try again later.";
$lang['attachmentshavebeendisabled'] = "Attachments have been disabled by the forum owner.";
$lang['canonlyuploadmaximum'] = "You can only upload a maximum of 10 files at a time";
$lang['deleteattachments'] = "Delete attachments";
$lang['deleteattachmentsconfirm'] = "Are you sure you want to delete the selected attachments?";
$lang['deletethumbnailsconfirm'] = "Are you sure you want to delete the selected attachments thumbnails?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Password changed";
$lang['passedchangedexp'] = "Your password has been changed.";
$lang['updatefailed'] = "Update failed";
$lang['passwdsdonotmatch'] = "Passwords do not match.";
$lang['newandoldpasswdarethesame'] = "New and old passwords are the same.";
$lang['requiredinformationnotfound'] = "Required information not found";
$lang['forgotpasswd'] = "Forgot password";
$lang['resetpassword'] = "Reset Password";
$lang['resetpasswordto'] = "Reset password to";
$lang['invaliduseraccount'] = "Invalid user account specified. Check email for correct link";
$lang['invaliduserkeyprovided'] = "Invalid user key provided. Check email for correct link";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "No message specified for deletion";
$lang['deletemessage'] = "Delete Message";
$lang['postdelsuccessfully'] = "Post deleted successfully";
$lang['errordelpost'] = "Error deleting post";
$lang['cannotdeletepostsinthisfolder'] = "You cannot delete posts in this folder";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "No message specified for editing";
$lang['cannoteditpollsinlightmode'] = "Cannot edit polls in Light mode";
$lang['editedbyuser'] = "EDITED: %s by %s";
$lang['editappliedtomessage'] = "Edit Applied to Message";
$lang['errorupdatingpost'] = "Error updating post";
$lang['editmessage'] = "Edit message %s";
$lang['editpollwarning'] = "<b>Note</b>: Editing certain aspects of a poll will void all the current votes and allow people to vote again.";
$lang['hardedit'] = "Hard edit options (votes will be reset):";
$lang['softedit'] = "Soft edit options (votes will be retained):";
$lang['changewhenpollcloses'] = "Change when the poll closes?";
$lang['nochange'] = "No change";
$lang['emailresult'] = "Email result";
$lang['msgsent'] = "Message sent";
$lang['msgsentsuccessfully'] = "Message sent successfully.";
$lang['mailsystemfailure'] = "Mail system failure. Message not sent.";
$lang['nopermissiontoedit'] = "You are not permitted to edit this message.";
$lang['cannoteditpostsinthisfolder'] = "You cannot edit posts in this folder";
$lang['messagewasnotfound'] = "Message %s was not found";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "Send Email to %s";
$lang['nouserspecifiedforemail'] = "No user specified for emailing.";
$lang['entersubjectformessage'] = "Enter a subject for the message";
$lang['entercontentformessage'] = "Enter some content for the message";
$lang['msgsentfromby'] = "This message was sent from %s by %s";
$lang['subject'] = "Subject";
$lang['send'] = "Send";
$lang['userhasoptedoutofemail'] = "%s has opted out of email contact";
$lang['userhasinvalidemailaddress'] = "%s has an invalid email address";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "Message Notification from %s";
$lang['msgnotificationemail'] = "Hello %s,\n\n%s posted a message to you on %s.\n\nThe subject is: %s.\n\nTo read that message and others in the same discussion, go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: If you do not wish to receive email notifications of forum messages posted to you, go to: %s click on My Controls then Email and Privacy, unselect the Email Notification checkbox and press Submit.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "Subscription Notification from %s";
$lang['subnotification'] = "Hello %s,\n\n%s posted a message in a thread you have subscribed to on %s.\n\nThe subject is: %s.\n\nTo read that message and others in the same discussion, go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: If you do not wish to receive email notifications of new messages in this thread, go to: %s and adjust your Interest level at the bottom of the page.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "PM Notification from %s";
$lang['pmnotification'] = "Hello %s,\n\n%s posted a PM to you on %s.\n\nThe subject is: %s.\n\nTo read the message go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: If you do not wish to receive email notifications of new PM messages posted to you, go to: %s click My Controls then Email and Privacy, unselect the PM Notification checkbox and press Submit.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "Password change notification from %s";
$lang['pwchangeemail'] = "Hello %s,\n\nThis a notification email to inform you that your password on %s has been changed.\n\nIt has been changed to: %s and was changed by: %s.\n\nIf you have received this email in error or were not expecting a change to your password please contact the forum owner or a moderator on %s immediately to correct it.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "Email confirmation required for %s";
$lang['confirmemail'] = "Hello %s,\n\nYou recently created a new user account on %s.\nBefore you can start posting we need to confirm your email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\n\n%s\n\nOnce confirmation is complete you may login and start posting immediately.\n\nIf you did not create a user account on %s please accept our apologies and forward this email to %s so that the source of it may be investigated.";
$lang['confirmchangedemail'] = "Hello %s,\n\nYou recently changed your email on %s.\nBefore you can start posting again we need to confirm your new email address. Don't worry this is quite easy. All you need to do is click the link below (or copy and paste it into your browser):\n\n%s\n\nOnce confirmation is complete you may continue to use the forum as normal.\n\nIf you were not expecting this email from %s please accept our apologies and forward this email to %s so that the source of it may be investigated.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "Hello %s,\n\nYou requested this e-mail from %s because you have forgotten your password.\n\nClick the link below (or copy and paste it into your browser) to reset your password:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "Your password reset request from %s";
$lang['passwdresetemailsent'] = "Password reset e-mail sent";
$lang['passwdresetexp'] = "You should shortly receive an e-mail containing instructions for resetting your password.";
$lang['validusernamerequired'] = "A valid username is required";
$lang['forgottenpasswd'] = "Forgot password";
$lang['couldnotsendpasswordreminder'] = "Could not send password reminder. Please contact the forum owner.";
$lang['request'] = "Request";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "Email confirmation";
$lang['emailconfirmationcomplete'] = "Thank you for confirming your email address. You may now login and start posting immediately.";
$lang['emailconfirmationfailed'] = "Email confirmation has failed, please try again later. If you encounter this error multiple times please contact the forum owner or a moderator for assistance.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "Top Level";
$lang['maynotaccessthissection'] = "You may not access this section.";
$lang['toplevel'] = "Top Level";
$lang['links'] = "Links";
$lang['viewmode'] = "View Mode";
$lang['hierarchical'] = "Hierarchical";
$lang['list'] = "List";
$lang['folderhidden'] = "This folder is hidden";
$lang['hide'] = "hide";
$lang['unhide'] = "unhide";
$lang['nosubfolders'] = "No subfolders in this category";
$lang['1subfolder'] = "1 subfolder in this category";
$lang['subfoldersinthiscategory'] = "subfolders in this category";
$lang['linksdelexp'] = "Entries in a deleted folder will be moved to the parent folder. Only folders which do not contain subfolders may be deleted.";
$lang['listview'] = "List View";
$lang['listviewcannotaddfolders'] = "Cannot add folders in this view. Showing 20 entries at a time.";
$lang['rating'] = "Rating";
$lang['nolinksinfolder'] = "No links in this folder.";
$lang['addlinkhere'] = "Add link here";
$lang['notvalidURI'] = "That is not a valid URI!";
$lang['mustspecifyname'] = "You must specify a name!";
$lang['mustspecifyvalidfolder'] = "You must specify a valid folder!";
$lang['mustspecifyfolder'] = "You must specify a folder!";
$lang['successfullyaddedlinkname'] = "Successfully added link '%s'";
$lang['failedtoaddlink'] = "Failed to add link";
$lang['failedtoaddfolder'] = "Failed to add folder";
$lang['addlink'] = "Add a link";
$lang['addinglinkin'] = "Adding link in";
$lang['addressurluri'] = "Address";
$lang['addnewfolder'] = "Add a new folder";
$lang['addnewfolderunder'] = "Adding new folder under";
$lang['editfolder'] = "Edit Folder";
$lang['editingfolder'] = "Editing folder";
$lang['mustchooserating'] = "You must choose a rating!";
$lang['commentadded'] = "Your comment was added.";
$lang['commentdeleted'] = "Comment was deleted.";
$lang['commentcouldnotbedeleted'] = "Comment could not be deleted.";
$lang['musttypecomment'] = "You must type a comment!";
$lang['mustprovidelinkID'] = "You must provide a link ID!";
$lang['invalidlinkID'] = "Invalid link ID!";
$lang['address'] = "Address";
$lang['submittedby'] = "Submitted by";
$lang['clicks'] = "Clicks";
$lang['rating'] = "Rating";
$lang['vote'] = "Vote";
$lang['votes'] = "Votes";
$lang['notratedyet'] = "Not rated by anyone yet";
$lang['rate'] = "Rate";
$lang['bad'] = "Bad";
$lang['good'] = "Good";
$lang['voteexcmark'] = "Vote!";
$lang['clearvote'] = "Clear Vote";
$lang['commentby'] = "Comment by %s";
$lang['addacommentabout'] = "Add a comment about";
$lang['modtools'] = "Moderation Tools";
$lang['editname'] = "Edit name";
$lang['editaddress'] = "Edit address";
$lang['editdescription'] = "Edit description";
$lang['moveto'] = "Move to";
$lang['linkdetails'] = "Link Details";
$lang['addcomment'] = "Add Comment";
$lang['voterecorded'] = "Your vote has been recorded";
$lang['votecleared'] = "Your vote has been cleared";
$lang['linknametoolong'] = "Link name too long. Maximum is %s characters";
$lang['linkurltoolong'] = "Link URL too long. Maximum is %s characters";
$lang['linkfoldernametoolong'] = "Folder name too long. Maximum length is %s characters";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "You logged in successfully.";
$lang['presscontinuetoresend'] = "Press Continue to resend form data or cancel to reload page.";
$lang['usernameorpasswdnotvalid'] = "The username or password you supplied is not valid.";
$lang['rememberpasswds'] = "Remember passwords";
$lang['rememberpassword'] = "Remember password";
$lang['enterasa'] = "Enter as a %s";
$lang['donthaveanaccount'] = "Don't have an account? %s";
$lang['registernow'] = "Register now.";
$lang['problemsloggingon'] = "Problems logging on?";
$lang['deletecookies'] = "Delete Cookies";
$lang['cookiessuccessfullydeleted'] = "Cookies successfully deleted";
$lang['forgottenpasswd'] = "Forgotten your password?";
$lang['usingaPDA'] = "Using a PDA?";
$lang['lightHTMLversion'] = "Light HTML version";
$lang['youhaveloggedout'] = "You have logged out.";
$lang['currentlyloggedinas'] = "You are currently logged in as %s";
$lang['logonbutton'] = "Logon";
$lang['otherbutton'] = "Other";
$lang['yoursessionhasexpired'] = "Your session has expired. You will need to login again to continue.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "My Forums";
$lang['allavailableforums'] = "All Available Forums";
$lang['favouriteforums'] = "Favorite Forums";
$lang['ignoredforums'] = "Ignored Forums";
$lang['ignoreforum'] = "Ignore forum";
$lang['unignoreforum'] = "Unignore forum";
$lang['lastvisited'] = "Last Visited";
$lang['forumunreadmessages'] = "%s Unread Messages";
$lang['forummessages'] = "%s Messages";
$lang['forumunreadtome'] = "%s Unread &quot;To: Me&quot;";
$lang['forumnounreadmessages'] = "No Unread Messages";
$lang['removefromfavourites'] = "Remove From Favorites";
$lang['addtofavourites'] = "Add To Favorites";
$lang['availableforums'] = "Available Forums";
$lang['noforumsofselectedtype'] = "There are no forums of the selected type available. Please select a different type.";
$lang['successfullyaddedforumtofavourites'] = "Successfully added forum to Favorites.";
$lang['successfullyremovedforumfromfavourites'] = "Successfully removed forum from Favorites.";
$lang['successfullyignoredforum'] = "Successfully ignored forum.";
$lang['successfullyunignoredforum'] = "Successfully unignored forum.";
$lang['failedtoupdateforuminterestlevel'] = "Failed to update forum interest level";
$lang['noforumsavailablelogin'] = "There are no forums available. Please login to view your forums.";
$lang['passwdprotectedforum'] = "Password Protected Forum";
$lang['passwdprotectedwarning'] = "This forum is password protected. To gain access enter the password below.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Post message";
$lang['selectfolder'] = "Select folder";
$lang['mustenterpostcontent'] = "You must enter some content for the post!";
$lang['messagepreview'] = "Message Preview";
$lang['invalidusername'] = "Invalid username!";
$lang['mustenterthreadtitle'] = "You must enter a title for the thread!";
$lang['pleaseselectfolder'] = "Please select a folder!";
$lang['errorcreatingpost'] = "Error creating post! Please try again in a few minutes.";
$lang['createnewthread'] = "Create new thread";
$lang['postreply'] = "Post Reply";
$lang['threadtitle'] = "Thread title";
$lang['messagehasbeendeleted'] = "Message not found. Check that it hasn't been deleted.";
$lang['messagenotfoundinselectedfolder'] = "Message not found in selected folder. Check that it hasn't been moved or deleted.";
$lang['cannotpostthisthreadtypeinfolder'] = "You cannot post this thread type in that folder!";
$lang['cannotpostthisthreadtype'] = "You cannot post this thread type as there are no available folders that allow it.";
$lang['cannotcreatenewthreads'] = "You cannot create new threads.";
$lang['threadisclosedforposting'] = "This thread is closed, you cannot post in it!";
$lang['moderatorthreadclosed'] = "Warning: this thread is closed for posting to normal users.";
$lang['usersinthread'] = "Users in thread";
$lang['correctedcode'] = "Corrected code";
$lang['submittedcode'] = "Submitted code";
$lang['htmlinmessage'] = "HTML in message";
$lang['disableemoticonsinmessage'] = "Disable emoticons in message";
$lang['automaticallyparseurls'] = "Automatically parse URLs";
$lang['automaticallycheckspelling'] = "Automatically check spelling";
$lang['setthreadtohighinterest'] = "Set thread to high interest";
$lang['enabledwithautolinebreaks'] = "Enabled with auto-line-breaks";
$lang['fixhtmlexplanation'] = "This forum uses HTML filtering. Your submitted HTML has been modified by the filters in some way.\\n\\nTo view your original code, select the \\'Submitted code\\' radio button.\\nTo view the modified code, select the \\'Corrected code\\' radio button.";
$lang['messageoptions'] = "Message options";
$lang['notallowedembedattachmentpost'] = "You are not allowed to embed attachments in your posts.";
$lang['notallowedembedattachmentsignature'] = "You are not allowed to embed attachments in your signature.";
$lang['reducemessagelength'] = "Message length must be under 65,535 characters (currently: %s)";
$lang['reducesiglength'] = "Signature length must be under 65,535 characters (currently: %s)";
$lang['cannotcreatethreadinfolder'] = "You cannot create new threads in this folder";
$lang['cannotcreatepostinfolder'] = "You cannot reply to posts in this folder";
$lang['cannotattachfilesinfolder'] = "You cannot post attachments in this folder. Remove attachments to continue.";
$lang['postfrequencytoogreat'] = "You can only post once every %s seconds. Please try again later.";
$lang['emailconfirmationrequiredbeforepost'] = "Email confirmation is required before you can post. If you have not received a confirmation email please click the button below and a new one will be sent to you. If your email address needs changing please do so before requesting a new confirmation email. You may change your email address by click My Controls above and then User Details";
$lang['emailconfirmationfailedtosend'] = "Confirmation email failed to send. Please contact the forum owner to rectify this.";
$lang['emailconfirmationsent'] = "Confirmation email has been resent.";
$lang['resendconfirmation'] = "Resend Confirmation";
$lang['userapprovalrequiredbeforeaccess'] = "Your user account needs to be approved by a forum admin before you can access the requested forum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "In reply to";
$lang['showmessages'] = "Show messages";
$lang['ratemyinterest'] = "Rate my interest";
$lang['adjtextsize'] = "Adjust text size";
$lang['smaller'] = "Smaller";
$lang['larger'] = "Larger";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Support";
$lang['donateexcmark'] = "Donate!";
$lang['fontsizechanged'] = "Font Size Changed. %s";
$lang['framesmustbereloaded'] = "Frames must be reloaded manually to see changes.";
$lang['threadcouldnotbefound'] = "The requested thread could not be found or access was denied.";
$lang['mustselectpolloption'] = "You must select an option to vote for!";
$lang['mustvoteforallgroups'] = "You must vote in every group.";
$lang['keepreading'] = "Keep reading";
$lang['backtothreadlist'] = "Back to thread list";
$lang['postdoesnotexist'] = "That post does not exist in this thread!";
$lang['clicktochangevote'] = "Click to change vote";
$lang['youvotedforoption'] = "You voted for option";
$lang['youvotedforoptions'] = "You voted for options";
$lang['clicktovote'] = "Click to vote";
$lang['youhavenotvoted'] = "You have not voted";
$lang['viewresults'] = "View Results";
$lang['msgtruncated'] = "Message Truncated";
$lang['viewfullmsg'] = "View full message";
$lang['ignoredmsg'] = "Ignored message";
$lang['wormeduser'] = "Wormed user";
$lang['ignoredsig'] = "Ignored signature";
$lang['messagewasdeleted'] = "Message %s.%s was deleted";
$lang['stopignoringthisuser'] = "Stop ignoring this user";
$lang['renamethread'] = "Rename thread";
$lang['movethread'] = "Move thread";
$lang['torenamethisthreadyoumusteditthepoll'] = "To rename this thread you must edit the poll.";
$lang['closeforposting'] = "Close for posting";
$lang['until'] = "Until 00:00 UTC";
$lang['approvalrequired'] = "Approval Required";
$lang['messageawaitingapprovalbymoderator'] = "Message %s.%s is awaiting approval by a moderator";
$lang['postapprovedsuccessfully'] = "Post approved successfully";
$lang['postapprovalfailed'] = "Post approval failed.";
$lang['postdoesnotrequireapproval'] = "Post does not require approval";
$lang['approvepost'] = "Approve post for display";
$lang['approvedbyuser'] = "APPROVED: %s by %s";
$lang['makesticky'] = "Make sticky";
$lang['messagecountdisplay'] = "%s of %s";
$lang['linktothread'] = "Permanent link to this thread";
$lang['linktopost'] = "Link to post";
$lang['linktothispost'] = "Link to this post";
$lang['imageresized'] = "This image has been resized (original size %1\$sx%2\$s). To view the full-size image click here.";
$lang['messagedeletedbyuser'] = "Message %s.%s deleted %s by %s";
$lang['messagedeleted'] = "Message %s.%s was deleted";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "Cannot display folder moderators";
$lang['moderatorlist'] = "Moderator list:";
$lang['modsforfolder'] = "Moderators for folder";
$lang['nomodsfound'] = "No moderators found";
$lang['forumleaders'] = "Forum leaders:";
$lang['foldermods'] = "Folder moderators:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "Start";
$lang['messages'] = "Messages";
$lang['pminbox'] = "Inbox";
$lang['startwiththreadlist'] = "Start page with thread list";
$lang['pmsentitems'] = "Sent Items";
$lang['pmoutbox'] = "Outbox";
$lang['pmsaveditems'] = "Saved Items";
$lang['pmdrafts'] = "Drafts";
$lang['links'] = "Links";
$lang['admin'] = "Admin";
$lang['login'] = "Login";
$lang['logout'] = "Logout";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "Private Messages";
$lang['recipienttiptext'] = "Separate recipients by semi-colon or comma";
$lang['maximumtenrecipientspermessage'] = "There is a limit of 10 recipients per message. Please amend your recipient list.";
$lang['mustspecifyrecipient'] = "You must specify at least one recipient.";
$lang['usernotfound'] = "User %s not found";
$lang['sendnewpm'] = "Send New PM";
$lang['savemessage'] = "Save Message";
$lang['timesent'] = "Time Sent";
$lang['errorcreatingpm'] = "Error creating PM! Please try again in a few minutes";
$lang['writepm'] = "Write Message";
$lang['editpm'] = "Edit Message";
$lang['cannoteditpm'] = "Cannot edit this PM. It has already been viewed by the recipient or the message does not exist or it is inaccessible by you";
$lang['cannotviewpm'] = "Cannot view PM. Message does not exist or it is inaccessible by you";
$lang['pmmessagenumber'] = "Message %s";

$lang['youhavexnewpm'] = "You have %d new messages. Would you like to go to your Inbox now?";
$lang['youhave1newpm'] = "You have 1 new message. Would you like to go to your Inbox now?";
$lang['youhave1newpmand1waiting'] = "You have 1 new message.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";
$lang['youhave1pmwaiting'] = "You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmand1waiting'] = "You have %d new messages.\n\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmandxwaiting'] = "You have %d new messages.\n\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";
$lang['youhave1newpmandxwaiting'] = "You have 1 new message.\n\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";
$lang['youhavexpmwaiting'] = "You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\n\nWould you like to go to your Inbox now?";

$lang['youdonothaveenoughfreespace'] = "You do not have enough free space to send this message.";
$lang['userhasoptedoutofpm'] = "%s has opted out of receiving personal messages";
$lang['pmfolderpruningisenabled'] = "PM Folder pruning is enabled!";
$lang['pmpruneexplanation'] = "This forum uses PM folder pruning. The messages you have stored in your Inbox and Sent Items\\nfolders are subject to automatic deletion. Any messages you wish to keep should be moved to\\nyour \\'Saved Items\\' folder so that they are not deleted.";
$lang['yourpmfoldersare'] = "Your PM folders are %s full";
$lang['currentmessage'] = "Current Message";
$lang['unreadmessage'] = "Unread Message";
$lang['readmessage'] = "Read Message";
$lang['pmshavebeendisabled'] = "Personal Messages have been disabled by the forum owner.";
$lang['adduserstofriendslist'] = "Add users to your friends list to have them appear in a drop down on the PM Write Message Page.";

$lang['messagesaved'] = "Message Saved";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "Message was successfully saved to 'Drafts' folder";
$lang['couldnotsavemessage'] = "Could not save message. Make sure you have enough available free space.";
$lang['pmtooltipxmessages'] = "%s messages";
$lang['pmtooltip1message'] = "1 message";

$lang['allowusertosendpm'] = "Allow user to send personal messages to me";
$lang['blockuserfromsendingpm'] = "Block user from sending personal messages to me";
$lang['yourfoldernamefolderisempty'] = "Your %s folder is empty";
$lang['successfullydeletedselectedmessages'] = "Successfully deleted selected messages";
$lang['successfullyarchivedselectedmessages'] = "Successfully archived selected messages";
$lang['failedtodeleteselectedmessages'] = "Failed to delete selected messages";
$lang['failedtoarchiveselectedmessages'] = "Failed to archive selected messages";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "My Controls";
$lang['myforums'] = "My Forums";
$lang['menu'] = "Menu";
$lang['userexp_1'] = "Use the menu on the left to manage your settings.";
$lang['userexp_2'] = "<b>User Details</b> allows you to change your name, email address and password.";
$lang['userexp_3'] = "<b>User Profile</b> allows you to edit your user profile.";
$lang['userexp_4'] = "<b>Change Password</b> allows you to change your password";
$lang['userexp_5'] = "<b>Email &amp; Privacy</b> lets you change how you can be contacted on and off the forum.";
$lang['userexp_6'] = "<b>Forum Options</b> lets you change how the forum looks and works.";
$lang['userexp_7'] = "<b>Attachments</b> allows you to edit/delete your attachments.";
$lang['userexp_8'] = "<b>Signature</b> lets you edit your signature.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_9'] = "<b>Word Filter</b> lets you edit your personal word filter.";
$lang['userexp_10'] = "<b>Thread Subscriptions</b> allows you to manage your thread subscriptions.";
$lang['userdetails'] = "User Details";
$lang['userprofile'] = "User Profile";
$lang['emailandprivacy'] = "Email &amp; Privacy";
$lang['editsignature'] = "Edit Signature";
$lang['norelationshipssetup'] = "You have no user relationships set up. Add a new user by searching below.";
$lang['editwordfilter'] = "Edit Word Filter";
$lang['userinformation'] = "User Information";
$lang['changepassword'] = "Change Password";
$lang['currentpasswd'] = "Current Password";
$lang['newpasswd'] = "New Password";
$lang['confirmpasswd'] = "Confirm Password";
$lang['passwdsdonotmatch'] = "Passwords do not match!";
$lang['nicknamerequired'] = "Nickname is required!";
$lang['emailaddressrequired'] = "Email address is required!";
$lang['logonnotpermitted'] = "Logon not permitted. Choose another!";
$lang['nicknamenotpermitted'] = "Nickname not permitted. Choose another!";
$lang['emailaddressnotpermitted'] = "Email Address not permitted. Choose another!";
$lang['emailaddressalreadyinuse'] = "Email Address already in use. Choose another!";
$lang['relationshipsupdated'] = "Relationships Updated!";
$lang['relationshipupdatefailed'] = "Relationship updated failed!";
$lang['preferencesupdated'] = "Preferences were successfully updated.";
$lang['userdetails'] = "User Details";
$lang['memberno'] = "Member No.";
$lang['firstname'] = "First name";
$lang['lastname'] = "Last name";
$lang['dateofbirth'] = "Date of Birth";
$lang['homepageURL'] = "Homepage URL";
$lang['profilepicturedimensions'] = "Profile Picture (Max 95x95px)";
$lang['avatarpicturedimensions'] = "Avatar Picture (Max 15x15px)";
$lang['invalidattachmentid'] = "Invalid Attachment. Check that is hasn't been deleted.";
$lang['unsupportedimagetype'] = "Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.";
$lang['selectattachment'] = "Select Attachment";
$lang['pictureURL'] = "Picture URL";
$lang['avatarURL'] = "Avatar URL";
$lang['profilepictureconflict'] = "To use an attachment for your profile picture the Picture URL field must be blank.";
$lang['avatarpictureconflict'] = "To use an attachment for your avatar picture the Avatar URL field must be blank.";
$lang['attachmenttoolargeforprofilepicture'] = "Selected attachment is too large for profile picture. Maximum dimensions are %s";
$lang['attachmenttoolargeforavatarpicture'] = "Selected attachment is too large for avatar picture. Maximum dimensions are %s";
$lang['failedtoupdateuserdetails'] = "Some or all of your user account details could not be updated. Please try again later.";
$lang['failedtoupdateuserpreferences'] = "Some or all of your user preferences could not be updated. Please try again later.";
$lang['emailaddresschanged'] = "Email address has been changed";
$lang['newconfirmationemailsuccess'] = "Your email address has been changed and a new confirmation email has been sent. Please check and read the email for further instructions.";
$lang['newconfirmationemailfailure'] = "You have changed your email address, but we were unable to send a confirmation request. Please contact the forum owner for assistance.";
$lang['forumoptions'] = "Forum Options";
$lang['notifybyemail'] = "Notify by email of posts to me";
$lang['notifyofnewpm'] = "Notify by popup of new PM messages to me";
$lang['notifyofnewpmemail'] = "Notify by email of new PM messages to me";
$lang['daylightsaving'] = "Adjust for daylight saving";
$lang['autohighinterest'] = "Automatically mark threads I post in as High Interest";
$lang['convertimagestolinks'] = "Automatically convert embedded images in posts into links";
$lang['thumbnailsforimageattachments'] = "thumbnails for image attachments";
$lang['smallsized'] = "Small Sized";
$lang['mediumsized'] = "Medium Sized";
$lang['largesized'] = "Large Sized";
$lang['globallyignoresigs'] = "Globally ignore user signatures";
$lang['allowpersonalmessages'] = "Allow other users to send me personal messages";
$lang['allowemails'] = "Allow other users to send me emails via my profile";
$lang['timezonefromGMT'] = "Time zone";
$lang['postsperpage'] = "Posts per page";
$lang['fontsize'] = "Font size";
$lang['forumstyle'] = "Forum style";
$lang['forumemoticons'] = "Forum emoticons";
$lang['startpage'] = "Start page";
$lang['signaturecontainshtmlcode'] = "Signature contains HTML code";
$lang['savesignatureforuseonallforums'] = "Save signature for use on all forums";
$lang['preferredlang'] = "Preferred language";
$lang['donotshowmyageordobtoothers'] = "Do not show my age or date of birth to others";
$lang['showonlymyagetoothers'] = "Show only my age to others";
$lang['showmyageanddobtoothers'] = "Show both my age and date of birth to others";
$lang['showonlymydayandmonthofbirthytoothers'] = "Show only my day and month of birth to others";
$lang['listmeontheactiveusersdisplay'] = "List me on the active users display";
$lang['browseanonymously'] = "Browse forum anonymously";
$lang['allowfriendstoseemeasonline'] = "Browse anonymously, but allow friends to see me as online";
$lang['revealspoileronmouseover'] = "Reveal spoilers on mouse over";
$lang['showspoilersinlightmode'] = "Always show spoilers in light mode (uses lighter font color)";
$lang['resizeimagesandreflowpage'] = "Resize images and reflow page to prevent horizontal scrolling.";
$lang['showforumstats'] = "Show forum stats at bottom of message pane";
$lang['usewordfilter'] = "Enable word filter.";
$lang['forceadminwordfilter'] = "Force use of admin word filter on all users (inc. guests)";
$lang['timezone'] = "Time Zone";
$lang['language'] = "Language";
$lang['emailsettings'] = "Email and contact settings";
$lang['forumanonymity'] = "Forum anonymity settings";
$lang['birthdayanddateofbirth'] = "Birthday and date of birth display";
$lang['includeadminfilter'] = "Include admin word filter in my list.";
$lang['setforallforums'] = "Set for all forums?";
$lang['containsinvalidchars'] = "%s contains invalid characters!";
$lang['homepageurlmustincludeschema'] = "Homepage URL must include http:// schema.";
$lang['pictureurlmustincludeschema'] = "Picture URL must include http:// schema.";
$lang['avatarurlmustincludeschema'] = "Avatar URL must include http:// schema.";
$lang['postpage'] = "Post Page";
$lang['nohtmltoolbar'] = "No HTML toolbar";
$lang['displaysimpletoolbar'] = "Display simple HTML toolbar";
$lang['displaytinymcetoolbar'] = "Display WYSIWYG HTML toolbar";
$lang['displayemoticonspanel'] = "Display emoticons panel";
$lang['displaysignature'] = "Display signature";
$lang['disableemoticonsinpostsbydefault'] = "Disable emoticons in messages by default";
$lang['automaticallyparseurlsbydefault'] = "Automatically parse URLs in messages by default";
$lang['postinplaintextbydefault'] = "Post in plain text by default";
$lang['postinhtmlwithautolinebreaksbydefault'] = "Post in HTML with auto-line-breaks by default";
$lang['postinhtmlbydefault'] = "Post in HTML by default";
$lang['privatemessageoptions'] = "Private Message Options";
$lang['privatemessageexportoptions'] = "Private Message Export Options";
$lang['savepminsentitems'] = "Save a copy of each PM I send in my Sent Items folder";
$lang['includepminreply'] = "Include message body when replying to PM";
$lang['autoprunemypmfoldersevery'] = "Auto prune my PM folders every:";
$lang['friendsonly'] = "Friends only?";
$lang['globalstyles'] = "Global Styles";
$lang['forumstyles'] = "Forum Styles";
$lang['youmustenteryourcurrentpasswd'] = "You must enter your current password";
$lang['youmustenteranewpasswd'] = "You must enter a new password";
$lang['youmustconfirmyournewpasswd'] = "You must confirm your new password";
$lang['profileentriesmustnotincludehtml'] = "Profile Entries must not include HTML";
$lang['failedtoupdateuserprofile'] = "Failed to update user profile";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "You must provide some answer groups";
$lang['mustprovidepolltype'] = "You must provide a poll type";
$lang['mustprovidepollresultsdisplaytype'] = "You must provide results display type";
$lang['mustprovidepollvotetype'] = "You must provide a poll vote type";
$lang['mustprovidepollguestvotetype'] = "You must specify if guests should be allowed to vote";
$lang['mustprovidepolloptiontype'] = "You must provide a poll option type";
$lang['mustprovidepollchangevotetype'] = "You must provide a poll change vote type";
$lang['pollquestioncontainsinvalidhtml'] = "One or more of your Poll Questions contains invalid HTML.";
$lang['pleaseselectfolder'] = "Please select a folder";
$lang['mustspecifyvalues1and2'] = "You must specify values for answers 1 and 2";
$lang['tablepollmusthave2groups'] = "Tabular format polls must have precisely two voting groups";
$lang['nomultivotetabulars'] = "Tabular format polls cannot be multi-vote";
$lang['nomultivotepublic'] = "Public ballots cannot be multi-vote";
$lang['abletochangevote'] = "You will be able to change your vote.";
$lang['abletovotemultiple'] = "You will be able to vote multiple times.";
$lang['notabletochangevote'] = "You will not be able to change your vote.";
$lang['pollvotesrandom'] = "Note: Poll votes are randomly generated for preview only.";
$lang['pollquestion'] = "Poll Question";
$lang['possibleanswers'] = "Possible Answers";
$lang['enterpollquestionexp'] = "Enter the answers for your poll question.. If your poll is a &quot;yes/no&quot; question, simply enter &quot;Yes&quot; for Answer 1 and &quot;No&quot; for Answer 2.";
$lang['numberanswers'] = "No. Answers";
$lang['answerscontainHTML'] = "Answers Contain HTML (not including signature)";
$lang['optionsdisplay'] = "Answers display type";
$lang['optionsdisplayexp'] = "How should the answers be presented?";
$lang['dropdown'] = "As drop-down list(s)";
$lang['radios'] = "As a series of radio buttons";
$lang['votechanging'] = "Vote Changing";
$lang['votechangingexp'] = "Can a person change his or her vote?";
$lang['guestvoting'] = "Guest Voting";
$lang['guestvotingexp'] = "Can guests vote in this poll?";
$lang['allowmultiplevotes'] = "Allow Multiple Votes";
$lang['pollresults'] = "Poll Results";
$lang['pollresultsexp'] = "How would you like to display the results of your poll?";
$lang['pollvotetype'] = "Poll Voting Type";
$lang['pollvotesexp'] = "How should the poll be conducted?";
$lang['pollvoteanon'] = "Anonymously";
$lang['pollvotepub'] = "Public ballot";
$lang['horizgraph'] = "Horizontal graph";
$lang['vertgraph'] = "Vertical graph";
$lang['tablegraph'] = "Tabular format";
$lang['polltypewarning'] = "<b>Warning</b>: This is a public ballot. Your name will be visible next to the option you vote for.";
$lang['expiration'] = "Expiration";
$lang['showresultswhileopen'] = "Do you want to show results while the poll is open?";
$lang['whenlikepollclose'] = "When would you like your poll to automatically close?";
$lang['oneday'] = "One day";
$lang['threedays'] = "Three days";
$lang['sevendays'] = "Seven days";
$lang['thirtydays'] = "Thirty days";
$lang['never'] = "Never";
$lang['polladditionalmessage'] = "Additional Message (Optional)";
$lang['polladditionalmessageexp'] = "Do you want to include an additional post after the poll?";
$lang['mustspecifypolltoview'] = "You must specify a poll to view.";
$lang['pollconfirmclose'] = "Are you sure you want to close the following Poll?";
$lang['endpoll'] = "End Poll";
$lang['nobodyvotedclosedpoll'] = "Nobody voted";
$lang['votedisplayopenpoll'] = "%s and %s have voted.";
$lang['votedisplayclosedpoll'] = "%s and %s voted.";
$lang['nousersvoted'] = "No users";
$lang['oneuservoted'] = "1 user";
$lang['xusersvoted'] = "%s users";
$lang['noguestsvoted'] = "no guests";
$lang['oneguestvoted'] = "1 guest";
$lang['xguestsvoted'] = "%s guests";
$lang['pollhasended'] = "Poll has ended";
$lang['youvotedforpolloptionsondate'] = "You voted for %s on %s";
$lang['thisisapoll'] = "This is a poll. Click to view results.";
$lang['editpoll'] = "Edit Poll";
$lang['results'] = "Results";
$lang['resultdetails'] = "Result Details";
$lang['changevote'] = "Change vote";
$lang['pollshavebeendisabled'] = "Polls have been disabled by the forum owner.";
$lang['answertext'] = "Answer Text";
$lang['answergroup'] = "Answer Group";
$lang['previewvotingform'] = "Preview Voting Form";
$lang['viewbypolloption'] = "View by poll option";
$lang['viewbyuser'] = "View by user";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Edit Profile";
$lang['profileupdated'] = "Profile updated.";
$lang['profilesnotsetup'] = "The forum owner has not set up Profiles.";
$lang['ignoreduser'] = "Ignored user";
$lang['lastvisit'] = "Last Visit";
$lang['userslocaltime'] = "User's Local Time";
$lang['userstatus'] = "Status";
$lang['useractive'] = "Online";
$lang['userinactive'] = "Inactive / Offline";
$lang['totaltimeinforum'] = "Total time";
$lang['longesttimeinforum'] = "Longest session";
$lang['sendemail'] = "Send email";
$lang['sendpm'] = "Send PM";
$lang['visithomepage'] = "Visit Homepage";
$lang['age'] = "Age";
$lang['aged'] = "aged";
$lang['birthday'] = "Birthday";
$lang['registered'] = "Registered";
$lang['findpostsmadebyuser'] = "Find Posts made by %s";
$lang['findpostsmadebyme'] = "Find Posts made by me";
$lang['profilenotavailable'] = "Profile Not Available.";
$lang['userprofileempty'] = "This user has not filled in their profile or it is set to private.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "Sorry, new user registrations are not allowed right now. Please check back later.";
$lang['usernameinvalidchars'] = "Username can only contain a-z, 0-9, _ - characters";
$lang['usernametooshort'] = "Username must be a minimum of 2 characters long";
$lang['usernametoolong'] = "Username must be a maximum of 15 characters long";
$lang['usernamerequired'] = "A logon name is required";
$lang['passwdmustnotcontainHTML'] = "Password must not contain HTML tags";
$lang['passwordinvalidchars'] = "Password can only contain a-z, 0-9, _ - characters";
$lang['passwdtooshort'] = "Password must be a minimum of 6 characters long";
$lang['passwdrequired'] = "A password is required";
$lang['confirmationpasswdrequired'] = "A confirmation password is required";
$lang['nicknamerequired'] = "A nickname is required";
$lang['emailrequired'] = "An email address is required";
$lang['passwdsdonotmatch'] = "Passwords do not match";
$lang['usernamesameaspasswd'] = "Username and password must be different";
$lang['usernameexists'] = "Sorry, a user with that name already exists";
$lang['successfullycreateduseraccount'] = "Successfully created user account";
$lang['useraccountcreatedconfirmfailed'] = "Your user account has been created but the required confirmation email was not sent. Please contact the forum owner to rectify this. In this meantime please click the continue button to login in.";
$lang['useraccountcreatedconfirmsuccess'] = "Your user account has been created but before you can start posting you must confirm your email address. Please check your email for a link that will allow you to confirm your address.";
$lang['useraccountcreated'] = "Your user account has been created successfully! Click the continue button below to login";
$lang['errorcreatinguserrecord'] = "Error creating user record";
$lang['userregistration'] = "User Registration";
$lang['registrationinformationrequired'] = "Registration Information (Required)";
$lang['profileinformationoptional'] = "Profile Information (Optional)";
$lang['preferencesoptional'] = "Preferences (Optional)";
$lang['register'] = "Register";
$lang['rememberpasswd'] = "Remember password";
$lang['birthdayrequired'] = "Your date of birth is required or is invalid";
$lang['alwaysnotifymeofrepliestome'] = "Notify on reply to me";
$lang['notifyonnewprivatemessage'] = "Notify on new Private Message";
$lang['popuponnewprivatemessage'] = "Pop up on new Private Message";
$lang['automatichighinterestonpost'] = "Automatic high interest on post";
$lang['confirmpassword'] = "Confirm Password";
$lang['invalidemailaddressformat'] = "Invalid email address format";
$lang['moreoptionsavailable'] = "More Profile and Preference options are available once you register";
$lang['textcaptchaconfirmation'] = "Confirmation";
$lang['textcaptchaexplain'] = "To the right is a text-captcha image. Please type the code you can see in the image into the input field below it.";
$lang['textcaptchaimgtip'] = "This is a captcha-picture. It is used to prevent automatic registration";
$lang['textcaptchamissingkey'] = "A confirmation code is required.";
$lang['textcaptchaverificationfailed'] = "Text-captcha verification code was incorrect. Please re-enter it.";
$lang['forumrules'] = "Forum Rules";
$lang['forumrulesnotification'] = "In order to proceed, you must agree with the following rules";
$lang['forumrulescheckbox'] = "I have read, and agree to abide by the forum rules.";
$lang['youmustagreetotheforumrules'] = "You must agree to the forum rules before you can continue.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Member";
$lang['searchforusernotinlist'] = "Search for a user not in list";
$lang['yoursearchdidnotreturnanymatches'] = "Your search did not return any matches. Try simplifying your search parameters and try again.";
$lang['hiderowswithemptyornullvalues'] = "Hide rows with empty or null values in selected columns";
$lang['showregisteredusersonly'] = "Show Registered Users only (hide Guests)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "Relationships";
$lang['userrelationship'] = "User Relationship";
$lang['userrelationships'] = "User Relationships";
$lang['failedtoremoveselectedrelationships'] = "Failed to remove selected relationship";
$lang['friends'] = "Friends";
$lang['ignoredcompletely'] = "Ignored Completely";
$lang['relationship'] = "Relationship";
$lang['restorenickname'] = "Restore User's Nickname";
$lang['friend_exp'] = "User's posts marked with a &quot;Friend&quot; icon.";
$lang['normal_exp'] = "User's posts appear as normal.";
$lang['ignore_exp'] = "User's posts are hidden.";
$lang['ignore_completely_exp'] = "Threads and posts to or from user will appear deleted.";
$lang['display'] = "Display";
$lang['displaysig_exp'] = "User's signature is displayed on their posts.";
$lang['hidesig_exp'] = "User's signature is hidden on their posts.";
$lang['cannotignoremod'] = "You cannot ignore this user, as they are a moderator.";
$lang['previewsignature'] = "Preview Signature";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "Search Results";
$lang['usernamenotfound'] = "The username you specified in the to or from field was not found.";
$lang['notexttosearchfor'] = "One or all of your search keywords were invalid. Search keywords must be no shorter than %d characters, no longer than %d characters and must not appear in the %s";
$lang['keywordscontainingerrors'] = "Keywords Containing Errors: %s";
$lang['mysqlstopwordlist'] = "MySQL stopword list";
$lang['foundzeromatches'] = "Found: 0 matches";
$lang['found'] = "Found";
$lang['matches'] = "matches";
$lang['prevpage'] = "Previous page";
$lang['findmore'] = "Find more";
$lang['searchmessages'] = "Search Messages";
$lang['searchdiscussions'] = "Search discussions";
$lang['find'] = "Find";
$lang['additionalcriteria'] = "Additional Criteria";
$lang['searchbyuser'] = "Search by user (optional)";
$lang['folderbrackets_s'] = "Folder(s)";
$lang['postedfrom'] = "Posted from";
$lang['postedto'] = "Posted to";
$lang['today'] = "Today";
$lang['yesterday'] = "Yesterday";
$lang['daybeforeyesterday'] = "Day before yesterday";
$lang['weekago'] = "%s week ago";
$lang['weeksago'] = "%s weeks ago";
$lang['monthago'] = "%s month ago";
$lang['monthsago'] = "%s months ago";
$lang['yearago'] = "%s year ago";
$lang['beginningoftime'] = "Beginning of time";
$lang['now'] = "Now";
$lang['lastpostdate'] = "Last post date";
$lang['numberofreplies'] = "Number of replies";
$lang['foldername'] = "Folder name";
$lang['authorname'] = "Author name";
$lang['decendingorder'] = "Newest first";
$lang['ascendingorder'] = "Oldest first";
$lang['keywords'] = "Keywords";
$lang['sortby'] = "Sort by";
$lang['sortdir'] = "Sort dir";
$lang['sortresults'] = "Sort Results";
$lang['groupbythread'] = "Group by thread";
$lang['postsfromuser'] = "Posts from user";
$lang['poststouser'] = "Posts to user";
$lang['poststoandfromuser'] = "Posts to and from user";
$lang['searchfrequencyerror'] = "You can only search once every %s seconds. Please try again later.";
$lang['searchsuccessfullycompleted'] = "Search successfully completed. %s";
$lang['clickheretoviewresults'] = "Click here to view results.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "Select";
$lang['searchforthread'] = "Search For Thread";
$lang['mustspecifytypeofsearch'] = "You must specify type of search to perform";
$lang['unkownsearchtypespecified'] = "Unknown search type specified";
$lang['mustentersomethingtosearchfor'] = "You must enter something to search for";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Recent threads";
$lang['startreading'] = "Start Reading";
$lang['threadoptions'] = "Thread Options";
$lang['editthreadoptions'] = "Edit Thread Options";
$lang['morevisitors'] = "More Visitors";
$lang['forthcomingbirthdays'] = "Forthcoming Birthdays";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "You can edit this page from the admin interface";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "New Discussion";
$lang['createpoll'] = "Create Poll";
$lang['search'] = "Search";
$lang['searchagain'] = "Search Again";
$lang['alldiscussions'] = "All Discussions";
$lang['unreaddiscussions'] = "Unread Discussions";
$lang['unreadtome'] = "Unread &quot;To: Me&quot;";
$lang['todaysdiscussions'] = "Today's Discussions";
$lang['2daysback'] = "2 Days Back";
$lang['7daysback'] = "7 Days Back";
$lang['highinterest'] = "High Interest";
$lang['unreadhighinterest'] = "Unread High Interest";
$lang['iverecentlyseen'] = "I've recently seen";
$lang['iveignored'] = "I've ignored";
$lang['byignoredusers'] = "By ignored users";
$lang['ivesubscribedto'] = "I've subscribed to";
$lang['startedbyfriend'] = "Started by friend";
$lang['unreadstartedbyfriend'] = "Unread std by friend";
$lang['startedbyme'] = "Started by me";
$lang['unreadtoday'] = "Unread today";
$lang['deletedthreads'] = "Deleted Threads";
$lang['goexcmark'] = "Go!";
$lang['folderinterest'] = "Folder Interest";
$lang['postnew'] = "Post New";
$lang['currentthread'] = "Current Thread";
$lang['highinterest'] = "High Interest";
$lang['markasread'] = "Mark as Read";
$lang['next50discussions'] = "Next 50 discussions";
$lang['visiblediscussions'] = "Visible discussions";
$lang['selectedfolder'] = "Selected folder";
$lang['navigate'] = "Navigate";
$lang['couldnotretrievefolderinformation'] = "There are no folders available.";
$lang['nomessagesinthiscategory'] = "No messages in this category. Please select another, or %s for all threads";
$lang['clickhere'] = "click here";
$lang['prev50threads'] = "Previous 50 threads";
$lang['next50threads'] = "Next 50 threads";
$lang['nextxthreads'] = "Next %s threads";
$lang['threadstartedbytooltip'] = "Thread #%s Started by %s. Viewed %s";
$lang['threadviewedonetime'] = "1 time";
$lang['threadviewedtimes'] = "%d times";
$lang['unreadthread'] = "Unread Thread";
$lang['readthread'] = "Read Thread";
$lang['unreadmessages'] = "Unread Messages";
$lang['subscribed'] = "Subscribed";
$lang['ignorethisfolder'] = "Ignore This Folder";
$lang['stopignoringthisfolder'] = "Stop Ignoring This Folder";
$lang['stickythreads'] = "Sticky Threads";
$lang['mostunreadposts'] = "Most unread posts";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d new";
$lang['onenewoflength'] = "%d new of %d";
$lang['manynewoflength'] = "%d new of %d";
$lang['ignorefolderconfirm'] = "Are you sure you want to ignore this folder?";
$lang['unignorefolderconfirm'] = "Are you sure you want to stop ignoring this folder?";
$lang['confirmmarkasread'] = "Are you sure you want to mark the selected threads as read?";
$lang['successfullymarkreadselectedthreads'] = "Successfully marked selected threads as read";
$lang['failedtomarkselectedthreadsasread'] = "Failed to mark selected threads as read";
$lang['gotofirstpostinthread'] = "Go to first post in thread";
$lang['gotolastpostinthread'] = "Go to last post in thread";
$lang['viewmessagesinthisfolderonly'] = "View messages in this folder only";
$lang['shownext50threads'] = "Show next 50 threads";
$lang['showprev50threads'] = "Show previous 50 threads";
$lang['createnewdiscussioninthisfolder'] = "Create new discussion in this folder";
$lang['nomessages'] = "No Messages";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Bold";
$lang['italic'] = "Italic";
$lang['underline'] = "Underline";
$lang['strikethrough'] = "Strikethrough";
$lang['superscript'] = "Superscript";
$lang['subscript'] = "Subscript";
$lang['leftalign'] = "Left-align";
$lang['center'] = "Center";
$lang['rightalign'] = "Right-align";
$lang['numberedlist'] = "Numbered list";
$lang['list'] = "List";
$lang['indenttext'] = "Indent text";
$lang['code'] = "Code";
$lang['quote'] = "Quote";
$lang['spoiler'] = "Spoiler";
$lang['horizontalrule'] = "Horizontal rule";
$lang['image'] = "Image";
$lang['hyperlink'] = "Hyperlink";
$lang['noemoticons'] = "Disable emoticons";
$lang['fontface'] = "Font Face";
$lang['size'] = "Size";
$lang['colour'] = "Color";
$lang['red'] = "Red";
$lang['orange'] = "Orange";
$lang['yellow'] = "Yellow";
$lang['green'] = "Green";
$lang['blue'] = "Blue";
$lang['indigo'] = "Indigo";
$lang['violet'] = "Violet";
$lang['white'] = "White";
$lang['black'] = "Black";
$lang['grey'] = "Grey";
$lang['pink'] = "Pink";
$lang['lightgreen'] = "Light green";
$lang['lightblue'] = "Light blue";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "Forum Stats";
$lang['usersactiveinthepasttimeperiod'] = "%s active in the past %s. %s";

$lang['numactiveguests'] = "<b>%s</b> guests";
$lang['oneactiveguest'] = "<b>1</b> guest";
$lang['numactivemembers'] = "<b>%s</b> members";
$lang['oneactivemember'] = "<b>1</b> member";
$lang['numactiveanonymousmembers'] = "<b>%s</b> anonymous members";
$lang['oneactiveanonymousmember'] = "<b>1</b> anonymous member";

$lang['numthreadscreated'] = "<b>%s</b> threads";
$lang['onethreadcreated'] = "<b>1</b> thread";
$lang['numpostscreated'] = "<b>%s</b> posts";
$lang['onepostcreated'] = "<b>1</b> post";

$lang['younormal'] = "You";
$lang['youinvisible'] = "You (Invisible)";
$lang['viewcompletelist'] = "View Complete List";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "Our members have made a total of %s and %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "Longest thread is <b>%s</b> with %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "There have been <b>%s</b> posts made in the last 60 minutes.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "There has been <b>1</b> post made in the last 60 minutes.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "Most posts ever made in a single 60 minute period is <b>%s</b> on %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "We have <b>%s</b> registered members and the newest member is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "We have %s registered members.";
$lang['wehaveoneregisteredmember'] = "We have one registered member.";
$lang['mostuserseveronlinewasnumondate'] = "Most users ever online was <b>%s</b> on %s.";
$lang['statsdisplaychanged'] = "Stats Display Changed";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "Updates saved successfully";
$lang['useroptions'] = "User Options";
$lang['markedasread'] = "Marked as read";
$lang['postsoutof'] = "posts out of";
$lang['interest'] = "Interest";
$lang['closedforposting'] = "Closed for posting";
$lang['locktitleandfolder'] = "Lock title and folder";
$lang['deletepostsinthreadbyuser'] = "Delete posts in thread by user";
$lang['deletethread'] = "Delete Thread";
$lang['permenantlydelete'] = "Permanently Delete";
$lang['movetodeleteditems'] = "Move to Deleted Threads";
$lang['undeletethread'] = "Undelete Thread";
$lang['threaddeletedpermenantly'] = "Thread deleted permanently. Cannot undelete.";
$lang['markasunread'] = "Mark as unread";
$lang['makethreadsticky'] = "Make Thread Sticky";
$lang['threareadstatusupdated'] = "Thread Read Status Updated Successfully";
$lang['interestupdated'] = "Thread Interest Status Updated Successfully";
$lang['failedtoupdatethreadreadstatus'] = "Failed to update thread read status";
$lang['failedtoupdatethreadinterest'] = "Failed to update thread interest";
$lang['failedtorenamethread'] = "Failed to rename thread";
$lang['failedtomovethread'] = "Failed to move thread to specified folder";
$lang['failedtoupdatethreadstickystatus'] = "Failed to update thread sticky status";
$lang['failedtoupdatethreadclosedstatus'] = "Failed to update thread closed status";
$lang['failedtoupdatethreadlockstatus'] = "Failed to update thread lock status";
$lang['failedtodeletepostsbyuser'] = "Failed to delete posts by selected user";
$lang['failedtodeletethread'] = "Failed to delete thread.";
$lang['failedtoundeletethread'] = "Failed to un-delete thread";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "Dictionary";
$lang['spellcheck'] = "Spell Check";
$lang['notindictionary'] = "Not in dictionary";
$lang['changeto'] = "Change to";
$lang['restartspellcheck'] = "Restart";
$lang['cancelchanges'] = "Cancel Changes";
$lang['initialisingdotdotdot'] = "Initialising...";
$lang['spellcheckcomplete'] = "Spell check is complete. To restart spell check click restart button below.";
$lang['spellcheck'] = "Spell check";
$lang['noformobj'] = "No form object specified for return text";
$lang['bodytext'] = "Body Text";
$lang['ignore'] = "Ignore";
$lang['ignoreall'] = "Ignore All";
$lang['change'] = "Change";
$lang['changeall'] = "Change All";
$lang['add'] = "Add";
$lang['suggest'] = "Suggest";
$lang['nosuggestions'] = "(no suggestions)";
$lang['cancel'] = "Cancel";
$lang['dictionarynotinstalled'] = "No dictionary has been installed. Please contact the forum owner to remedy this.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "Post reading allowed";
$lang['postcreationallowed'] = "Post creation allowed";
$lang['threadcreationallowed'] = "Thread creation allowed";
$lang['posteditingallowed'] = "Post editing allowed";
$lang['postdeletionallowed'] = "Post deletion allowed";
$lang['attachmentsallowed'] = "Attachments allowed";
$lang['htmlpostingallowed'] = "HTML posting allowed";
$lang['signatureallowed'] = "Signature allowed";
$lang['guestaccessallowed'] = "Guest access allowed";
$lang['postapprovalrequired'] = "Post approval required";

// RSS feeds gubbins

$lang['rssfeed'] = "RSS Feed";
$lang['every30mins'] = "Every 30 minutes";
$lang['onceanhour'] = "Once an hour";
$lang['every6hours'] = "Every 6 hours";
$lang['every12hours'] = "Every 12 hours";
$lang['onceaday'] = "Once a day";
$lang['rssfeeds'] = "RSS Feeds";
$lang['feedname'] = "Feed Name";
$lang['feedfoldername'] = "Feed Folder Name";
$lang['feedlocation'] = "Feed Location";
$lang['threadtitleprefix'] = "Thread Title Prefix";
$lang['feednameandlocation'] = "Feed Name and Location";
$lang['feedsettings'] = "Feed Settings";
$lang['updatefrequency'] = "Update Frequency";
$lang['rssclicktoreadarticle'] = "Click here to read this article";
$lang['addnewfeed'] = "Add New Feed";
$lang['editfeed'] = "Edit Feed";
$lang['feeduseraccount'] = "Feed User Account";
$lang['noexistingfeeds'] = "No existing RSS Feeds found. To add a feed click the 'Add New' button below";
$lang['rssfeedhelp'] = "Here you can setup some RSS feeds for automatic propagation into your forum. The items from the RSS feeds you add will be created as threads which users can reply to as if they were normal posts. The RSS feed must be accessible via HTTP or it will not work.";
$lang['mustspecifyrssfeedname'] = "Must specify RSS Feed Name";
$lang['mustspecifyrssfeeduseraccount'] = "Must specify RSS Feed User Account";
$lang['mustspecifyrssfeedfolder'] = "Must specify RSS Feed Folder";
$lang['mustspecifyrssfeedurl'] = "Must specify RSS Feed URL";
$lang['mustspecifyrssfeedupdatefrequency'] = "Must specify RSS Feed Update Frequency";
$lang['unknownrssuseraccount'] = "Unknown RSS User Account";
$lang['rssfeedsupportshttpurlsonly'] = "RSS Feed supports HTTP URLs only. Secure feeds (https://) are not supported.";
$lang['rssfeedurlformatinvalid'] = "RSS Feed URL format is invalid. URL must include scheme (e.g. http://) and a hostname (e.g. www.hostname.com).";
$lang['rssfeeduserauthentication'] = "RSS Feed does not support HTTP user authentication";
$lang['successfullyremovedselectedfeeds'] = "Successfully removed selected feeds";
$lang['successfullyaddedfeed'] = "Successfully added new feed";
$lang['successfullyeditedfeed'] = "Successfully edited feed";
$lang['failedtoremovefeeds'] = "Failed to remove some or all of the selected feeds";
$lang['failedtoaddnewrssfeed'] = "Failed to add new RSS Feed";
$lang['failedtoupdaterssfeed'] = "Failed to update RSS Feed";
$lang['rssstreamworkingcorrectly'] = "RSS stream appears to be working correctly";
$lang['rssstreamnotworkingcorrectly'] = "RSS stream was empty or could not be found";
$lang['invalidfeedidorfeednotfound'] = "Invalid feed id or feed not found";

// PM Export Options

$lang['pmexportastype'] = "Export as type";
$lang['pmexporthtml'] = "HTML";
$lang['pmexportxml'] = "XML";
$lang['pmexportplaintext'] = "Plain Text";
$lang['pmexportmessagesas'] = "Export messages as";
$lang['pmexportonefileforallmessages'] = "One file for all messages";
$lang['pmexportonefilepermessage'] = "One file per message";
$lang['pmexportattachments'] = "Export attachments";
$lang['pmexportincludestyle'] = "Include forum style sheet";
$lang['pmexportwordfilter'] = "Apply word filter to messages";

// Thread merge / split options

$lang['threadhasbeensplit'] = "Thread has been split";
$lang['threadhasbeenmerged'] = "Thread has been merged";
$lang['mergesplitthread'] = "Merge / Split Thread";
$lang['mergewiththreadid'] = "Merge with thread ID:";
$lang['postsinthisthreadatstart'] = "Posts in this thread at start";
$lang['postsinthisthreadatend'] = "Posts in this thread at end";
$lang['reorderpostsintodateorder'] = "Re-order posts into date order";
$lang['splitthreadatpost'] = "Split thread at post:";
$lang['selectedpostsandrepliesonly'] = "Selected post and replies only";
$lang['selectedandallfollowingposts'] = "Selected and all following posts";

$lang['threadmovedhere'] = "here";

$lang['thisthreadhasmoved'] = "<b>Threads Merged:</b> This thread has moved %s";
$lang['thisthreadwasmergedfrom'] = "<b>Threads Merged:</b> This thread was merged from %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>Thread Split:</b> Some posts in this thread have been moved %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>Thread Split:</b> Some posts in this thread were moved from %s";

$lang['thisposthasbeenmoved'] = "<b>Thread Split:</b> This post has been moved %s";

$lang['invalidfunctionarguments'] = "Invalid function arguments";
$lang['couldnotretrieveforumdata'] = "Could not retrieve forum data";
$lang['cannotmergepolls'] = "One or more threads is a poll. You cannot merge polls";
$lang['couldnotretrievethreaddatamerge'] = "Could not retrieve thread data from one or more threads";
$lang['couldnotretrievethreaddatasplit'] = "Could not retrieve thread data from source thread";
$lang['couldnotretrievepostdatamerge'] = "Could not retrieve post data from one or more threads";
$lang['couldnotretrievepostdatasplit'] = "Could not retrieve post data from source thread";
$lang['failedtocreatenewthreadformerge'] = "Failed to create new thread for merge";
$lang['failedtocreatenewthreadforsplit'] = "Failed to create new thread for split";

// Thread subscriptions

$lang['threadsubscriptions'] = "Thread Subscriptions";
$lang['couldnotupdateinterestonthread'] = "Could not update interest on thread '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "Thread interests updated successfully";
$lang['nothreadsubscriptions'] = "You are not subscribed to any threads.";
$lang['resetselected'] = "Reset Selected";
$lang['allthreadtypes'] = "All Thread Types";
$lang['ignoredthreads'] = "Ignored Threads";
$lang['highinterestthreads'] = "High Interest Threads";
$lang['subscribedthreads'] = "Subscribed Threads";
$lang['currentinterest'] = "Current Interest";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "You can only add 3 columns. To add a new column close an existing one";
$lang['columnalreadyadded'] = "You have already added this column. If you want to remove it click its close button";

?>