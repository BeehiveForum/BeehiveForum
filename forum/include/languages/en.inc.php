<?php

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

/* $Id: en.inc.php,v 1.21 2003-07-29 16:26:44 hodcroftcj Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "UTF-8";
$lang['_textdir'] = "ltr";  // ltr or rtl; left to right or vice versa


// Common words --------------------------------------------------------

$lang['add'] = "Add";
$lang['remove'] = "Remove";
$lang['go'] = "Go";
$lang['folder'] = "Folder";
$lang['folders'] = "Folders";
$lang['thread'] = "thread";
$lang['threads'] = "threads";
$lang['message'] = "Message";
$lang['from'] = "From";
$lang['to'] = "To";
$lang['all_caps'] = "ALL";
$lang['of'] = "of";
$lang['reply'] = "Reply";
$lang['delete'] = "Delete";
$lang['del'] = "Del";
$lang['edit'] = "Edit";
$lang['privileges'] = "Privileges";
$lang['ignore'] = "Ignore";
$lang['normal'] = "Normal";
$lang['interested'] = "Interested";
$lang['subscribe'] = "Subscribe";
$lang['apply'] = "Apply";
$lang['submit'] = "Submit";
$lang['save'] = "Save";
$lang['cancel'] = "Cancel";
$lang['continue'] = "Continue";
$lang['queen'] = "Queen";
$lang['soldier'] = "Soldier";
$lang['worker'] = "Worker";
$lang['worm'] = "Worm";
$lang['wasp'] = "Wasp";
$lang['splat'] = "Splat";
$lang['attachment'] = "Attachment";
$lang['attachments'] = "Attachments";
$lang['filename'] = "Filename";
$lang['dimensions'] = "Dimensions";
$lang['downloaded'] = "Downloaded";
$lang['size'] = "Size";
$lang['time'] = "time";
$lang['times'] = "times";
$lang['viewmessage'] = "View Message";
$lang['messageunavailable'] = "Message Unavailable";
$lang['logon'] = "Logon";
$lang['status'] = "Status";
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
$lang['wasnotfound'] = "was not found";
$lang['back'] = "Back";
$lang['subject'] = "Subject";
$lang['close'] = "Close";
$lang['name'] = "Name";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "View";
$lang['passwd'] = "Password";
$lang['ignored'] = "Ignored";
$lang['guest'] = "Guest";
$lang['next'] = "Next";
$lang['others'] = "Others";
$lang['nickname'] = "Nickname";
$lang['emailaddress'] = "Email address";
$lang['confirm'] = "Confirm";
$lang['email'] = "Email";
$lang['new'] = "new";
$lang['poll'] = "Poll";
$lang['friend'] = "Friend";
$lang['error'] = "Error";
$lang['reset'] = "Reset";
$lang['guesterror'] = "Sorry, you need to be logged in to use this feature. <a href=\"logout.php?final_uri=". get_request_uri(). "\" target=\"_top\">Login Now</a>.";
$lang['on'] = "on";
$lang['unread'] = "unread";
$lang['all'] = "All";
$lang['me_caps'] = "ME";
$lang['by'] = "by";
$lang['permissions'] = "Permissions";
$lang['position'] = "Position";
$lang['or'] = "or";
$lang['hours'] = "Hours";
$lang['type'] = "Type";
$lang['print'] = "Print";

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "Access Denied";
$lang['accessdeniedexp'] = "You do not have permission to use this section.";
$lang['managefolders'] = "Manage Folders";
$lang['managefolder'] = "Manage Folder";
$lang['id'] = "ID";
$lang['foldername'] = "Folder Name";
$lang['accesslevel'] = "Access Level";
$lang['move'] = "Move";
$lang['closed'] = "Closed";
$lang['open'] = "Open";
$lang['restricted'] = "Restricted";
$lang['newfolder'] = "New Folder";
$lang['forumadmin'] = "Forum Admin";
$lang['adminexp_1'] = "Use the menu on the left to manage things in your forum.";
$lang['adminexp_2'] = "<b>Users</b> allows you to set user permissions, including appointing Editors and gagging people.";
$lang['adminexp_3'] = "Use <b>Folders</b> to add new folders or change the names of existing ones.";
$lang['adminexp_4'] = "<b>Profiles</b> lets you change the items appearing in user profiles.";
$lang['adminexp_5'] = "Choose <b>Start Page</b> to edit the forum start page.";
$lang['adminexp_6'] = "Using <b>Forum Style</b> allows you to create new colour schemes for the forum.";
$lang['adminexp_7'] = "The words in the <b>Word Filter</b> can be edited.";
$lang['adminexp_8'] = "Look at the <b>Admin Log</b> to see what actions forum moderators have taken recently.";
$lang['createforumstyle'] = "Create a Forum Style";
$lang['newstyle'] = "New style";
$lang['successfullycreated'] = "successfully created.";
$lang['stylesdirnotwritable'] = "The styles directory is not writeable. Please CHMOD the styles directory and retry.";
$lang['stylealreadyexists'] = "A style with that filename already exists.";
$lang['stylenofilename'] = "You did not enter a filename to save the style with.";
$lang['stylenotauthorised'] = "You are not authorised to create forum styles.";
$lang['styleexp'] = "Use this page to help create a randomly generated style for your forum.";
$lang['stylecontrols'] = "Controls";
$lang['stylecolourexp'] = "Click on a colour to make a new stylesheet based on that colour. Current base colour is first in list.";
$lang['standardstyle'] = "Standard Style";
$lang['rotelementstyle'] = "Rotated Element Style";
$lang['randstyle'] = "Random Style";
$lang['enterhexcolour'] = "or enter a hex colour to base a new stylesheet on";
$lang['savestyle'] = "Save this style";
$lang['styledesc'] = "Style Desc.";
$lang['fileallowedchars'] = "(lowercase letters (a-z), numbers (0-9) and underscores (_) only)";
$lang['stylepreview'] = "Style Preview";
$lang['welcome'] = "Welcome";
$lang['messagepreview'] = "Message Preview";
$lang['h1tag'] = "H1 Tag";
$lang['subhead'] = "Subhead";
$lang['users'] = "Users";
$lang['profiles'] = "Profiles";
$lang['startpage'] = "Start Page";
$lang['forumstyle'] = "Forum Style";
$lang['wordfilter'] = "Word Filter";
$lang['viewlog'] = "View Log";
$lang['invalidop'] = "Invalid Operation";
$lang['noprofilesectionspecified'] = "No Profile section specified.";
$lang['newitem'] = "New Item";
$lang['manageprofileitems'] = "Manage Profile Items";
$lang['section'] = "Section";
$lang['itemname'] = "Item Name";
$lang['moveto'] = "Move To";
$lang['deleteitem'] = "Delete Item";
$lang['deletesection'] = "Delete Section";
$lang['new_caps'] = "NEW";
$lang['newsection'] = "New Section";
$lang['manageprofilesections'] = "Manage Profile Sections";
$lang['sectionname'] = "Section Name";
$lang['items'] = "Items";
$lang['startpageupdated'] = "Start Page updated";
$lang['viewupdatedstartpage'] = "View updated Start Page";
$lang['editstartpage'] = "Edit Start Page";
$lang['editstartpageexp'] = "Use this page to edit the Start Page on your forum.";
$lang['nouserspecified'] = "No user specified for editing.";
$lang['manageuser'] = "Manage User";
$lang['manageusers'] = "Manage Users";
$lang['userstatus'] = "User Status";
$lang['warning_caps'] = "WARNING";
$lang['userdeleteallpostswarning'] = "Are you sure you want to delete all of the selected user's posts? Once the posts are deleted they cannot be retrieved and will be lost forever.";
$lang['postssuccessfullydeleted'] = "Posts were successfully deleted.";
$lang['folderaccess'] = "Folder Access";
$lang['norestrictedfolders'] = "No restricted folders";
$lang['possiblealiases'] = "Possible Aliases";
$lang['nomatches'] = "No matches";
$lang['cannotipbansoldiers'] = "You cannot IP ban other Soldiers. Lower their Status first.";
$lang['banthisipaddress'] = "Ban this IP address";
$lang['noipaddress'] = "There is no IP address for this account. The user cannot be banned by IP address.";
$lang['deleteposts'] = "Delete Posts";
$lang['deleteallusersposts'] = "Delete all of this user's posts";
$lang['noattachmentsforuser'] = "No attachments for this user";
$lang['soldierdesc'] = "<b>Soldiers</b> can access all moderation tools, but cannot create or remove other Soldiers.";
$lang['workerdesc'] = "<b>Workers</b> can edit or delete any post.";
$lang['wormdesc'] = "<b>Worms</b> can read messages and post as normal, but their messages will appear deleted to all other users.";
$lang['waspdesc'] = "<b>Wasps</b> can read messages, but cannot reply or post new messages.";
$lang['splatdesc'] = "<b>Splats</b> cannot access the forum. Use this to ban persistent idiots.";
$lang['aliasdesc'] = "<b>Possible Aliases</b> is a list of other users who's last recorded IP address match this user.";
$lang['manageusersexp_1'] = "This list shows a selection of users who have logged on to your forum, sorted by";
$lang['manageusersexp_2'] = "To alter a user's permissions click their name.";
$lang['manageusersexp_3'] = "To see the last few users to logon, sort the list by LAST_LOGON.";
$lang['lastlogon'] = "Last Logon";
$lang['logonfrom'] = "Logon From";
$lang['nouseraccounts'] = "No user accounts in database.";
$lang['searchforusernotinlist'] = "Search for a user not in list";
$lang['adminaccesslog'] = "Admin Access Log";
$lang['adminlogexp'] = "This list shows the last actions sanctioned by users with Admin privileges.";
$lang['showingactions'] = "Showing actions";
$lang['inclusive'] = "inclusive";
$lang['datetime'] = "Date/Time";
$lang['unknownuser'] = "Unknown user";
$lang['unknownfolder'] = "Unknown folder";
$lang['changeduserstatus'] = "Changed User Status for User";
$lang['changedfolderaccess'] = "Changed User Folder Access Privs for User";
$lang['deletedallusersposts'] = "Deleted All Posts for User";
$lang['banneduser'] = "Banned User";
$lang['unbanneduser'] = "Unbanned User";
$lang['ipaddress'] = "IP address";
$lang['deleteduser'] = "Deleted User";
$lang['changedtitleaccessfolder'] = "Changed Folder Options for folder";
$lang['movedthreads'] = "Moved threads to folder";
$lang['creatednewfolder'] = "Created new folder";
$lang['changedprofilesectiontitle'] = "Changed Profile section title for section";
$lang['addednewprofilesection'] = "Added New Profile section";
$lang['deletedprofilesection'] = "Deleted Profile Section";
$lang['changedprofileitemtitle'] = "Changed Profile Item title for item";
$lang['addednewprofileitem'] = "Added New Profile Item";
$lang['deletedprofileitem'] = "Deleted Profile Item";
$lang['editedstartpage'] = "Edited Start Page";
$lang['savednewstyle'] = "Saved New Style";
$lang['movedthread'] = "Moved Thread";
$lang['closedthread'] = "Closed Thread";
$lang['openedthread'] = "Opened Thread";
$lang['renamedthread'] = "Renamed Thread";
$lang['deletedpost'] = "Deleted Post";
$lang['editedpost'] = "Edited Post";
$lang['editedwordfilter'] = "Edited Word Filter";
$lang['adminlogempty'] = "Admin Log is empty";
$lang['recententries'] = "Recent Entries";
$lang['clearlog'] = "Clear Log";
$lang['wordfilterupdated'] = "Word Filter updated";
$lang['editwordfilter'] = "Edit Word Filter";
$lang['wordfilterexp_1'] = "Use this page to edit the Word Filter for your forum. Place each word to be filtered on a new line.";
$lang['wordfilterexp_2'] = "Perl-compatible regular expressions can also be used to match words if you know how.";
$lang['allow'] = "Allow";
$lang['normalthreadsonly'] = "Normal threads only";
$lang['pollthreadsonly'] = "Poll threads only";
$lang['both'] = "Both thread types";
$lang['existingpermissions'] = "Existing Permissions";
$lang['folderisnotrestricted'] = "Folder is not restricted. Set it's Access Level to Restricted before adding/removing users";
$lang['nousers'] = "No users";
$lang['addnewuser'] = "Add New User";
$lang['adduser'] = "Add User";
$lang['searchforuser'] = "Search For User";
$lang['browsernegotiation'] = "Browser negotiated";
$lang['largetextfield'] = "Large Text Field";
$lang['mediumtextfield'] = "Medium Text Field";
$lang['smalltextfield'] = "Small Text Field";
$lang['multilinetextfield'] = "Multiline Text Field";
$lang['radiobuttons'] = "Radio Buttons";
$lang['dropdown'] = "Drop Down";
$lang['threadcount'] = "Thread Count";
$lang['fieldtypeexample1'] = "For Radio Buttons and Drop Down Fields you need to seperate the fieldname and the values with a colon and each value should be seperated by semi-colons.";
$lang['fieldtypeexample2'] = "Example: To create a basic Gender radio buttons, with two selections for Male and Female, you would enter: <b>Gender:Male;Female</b> in the Item Name field.";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AID not specified.";
$lang['upload'] = "Upload";
$lang['waitdotdot'] = "wait..";
$lang['attachmentnospace'] = "Sorry, you do not have enough free attachment space. Please free some space and try again.";
$lang['successfullyuploaded'] = "Successfully Uploaded";
$lang['uploadfailed'] = "Upload Failed";
$lang['errorfilesizeis0'] = "Error: Filesize must be greater than 0 bytes";
$lang['complete'] = "Complete";
$lang['uploadattachment'] = "Upload a file for attachment to the message";
$lang['enterfilenametoupload'] = "Enter filename to upload";
$lang['nowpress'] = "Now press";
$lang['ifdoneattachingfiles'] = "If you are done attaching file(s), press";
$lang['attachmentsforthismessage'] = "Attachments for this message";
$lang['otherattachmentsincludingpm'] = "Other Attachments (including PM Messages)";
$lang['totalsize'] = "Total Size";
$lang['freespace'] = "Free Space";
$lang['attachmentproblem'] = "There was a problem downloading this attachment. Please try again later.";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Password changed";
$lang['passedchangedexp'] = "Your password has been changed.";
$lang['gotologin'] = "Go to Login screen";
$lang['updatefailed'] = "Update failed";
$lang['passwdsdonotmatch'] = "Passwords do not match.";
$lang['allfieldsrequired'] = "All fields are required.";
$lang['invalidaccess'] = "Invalid Access";
$lang['requiredinformationnotfound'] = "ERROR: required information not found";
$lang['forgotpasswd'] = "Forgot password";
$lang['enternewpasswdforuser'] = "Enter a new password for user";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "No message specified for deletion";
$lang['postdelsuccessfully'] = "Post deleted successfully";
$lang['errordelpost'] = "Error deleting post";
$lang['delthismessage'] = "Delete this message";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "No message specified for editing";
$lang['edited_caps'] = "EDITED";
$lang['editappliedtomessage'] = "Edit Applied to Message";
$lang['editappliedtopoll'] = "Edit Applied to Poll";
$lang['errorupdatingpost'] = "Error updating post";
$lang['editmessage'] = "Edit message";
$lang['edittext'] = "Edit text";
$lang['editHTML'] = "Edit HTML";
$lang['editpollwarning'] = "<b>Note</b>: Editing any aspect of a poll will void all the current votes and allow people to vote again.";
$lang['changewhenpollcloses'] = "Change when the poll closes?";
$lang['nochange'] = "No change";
$lang['emailresult'] = "Email result";
$lang['msgsent'] = "Message sent";
$lang['msgfail'] = "Mail system failure. Message not sent.";
$lang['nopermissiontoedit'] = "You are not permitted to edit this message.";
$lang['pollediterror'] = "You cannot edit polls";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "No user specified for emailing.";
$lang['entersubjectformessage'] = "Enter a subject for the message";
$lang['entercontentformessage'] = "Enter some content for the message";
$lang['msgsentfrombeehiveforumby'] = "This message was sent from a Beehive Forum by";
$lang['subject'] = "Subject";
$lang['send'] = "Send";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "An error has occured. Please wait a few minutes and then click the Retry button below.";
$lang['retry'] = "Retry";
$lang['multipleerroronpost'] = "This error has occured more than once while attempting to post/preview your message. For your convienience we have included your message text and if applicable the thread and message number you were replying to below. You may wish to save a copy of the text elsewhere until the forum is available again.";
$lang['replymsgnumber'] = "Reply Message Number";
$lang['errormsgfordevs'] = "Error Message for server admins and developers";


// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "You requested this e-mail from";
$lang['forgotpwemail_2'] = "because you have forgotten your password.";
$lang['forgotpwemail_3'] = "Click the link below (or copy and paste it into your browser) to reset your password";
$lang['passwdresetrequest'] = "Your password reset request";
$lang['passwdresetemailsent'] = "Password reset e-mail sent";
$lang['passwdresetexp_1'] = "You should receive an e-mail containing";
$lang['passwdresetexp_2'] = "a link to reset your password shortly.";
$lang['validusernamerequired'] = "A valid username is required";
$lang['forgotpasswd'] = "Forgot password";
$lang['forgotpasswdexp_1'] = "Enter your logon name below and an e-mail";
$lang['forgotpasswdexp_2'] = "will be sent to the registered address for";
$lang['forgotpasswdexp_3'] = "that account containing a link allowing you";
$lang['forgotpasswdexp_4'] = "to change your password.";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "Oops, your browser says it doesn't support frames";
$lang['uselightversion'] = "You need to use the light HTML version of the forum <a href=\"llogon.php\">here</a>.";

// Links database (links*.php) -----------------------------------------

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
$lang['listviewcannotaddfolders'] = "Cannot add folders in this view. Showing maximum 30 entries.";
$lang['rating'] = "Rating";
$lang['commentsslashvote'] = "Comments / Vote";
$lang['nolinksinfolder'] = "No links in this folder.";
$lang['addlinkhere'] = "Add link here";
$lang['notvalidURI'] = "That is not a valid URI!";
$lang['mustspecifyname'] = "You must specify a name!";
$lang['mustspecifyvalidfolder'] = "You must specify a valid folder!";
$lang['mustspecifyfolder'] = "You must specify a folder!";
$lang['addlink'] = "Add a link";
$lang['addinglinkin'] = "Adding link in";
$lang['addressurluri'] = "Address (URL/URI)";
$lang['addnewfolder'] = "Add a new folder";
$lang['addnewfolderunder'] = "Adding new folder under";
$lang['mustchooserating'] = "You must choose a rating!";
$lang['commentadded'] = "Your comment was added.";
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
$lang['commentby'] = "Comment by";
$lang['nocommentsposted'] = "No comments have yet been posted.";
$lang['addacommentabout'] = "Add a comment about";
$lang['modtools'] = "Moderation Tools";
$lang['editname'] = "Edit name";
$lang['editaddress'] = "Edit address";
$lang['editdescription'] = "Edit description";
$lang['moveto'] = "Move to";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "User ID";
$lang['alreadyloggedin'] = "already logged in";
$lang['loggedinsuccessfully'] = "You logged in successfully.";
$lang['usernameorpasswdnotvalid'] = "The username or password you supplied is not valid.";
$lang['usernameandpasswdrequired'] = "A username and password is required";
$lang['welcometolight'] = "Welcome to Diet Beehive!";
$lang['pleasereenterpasswd'] = "Please reenter your password and try again.";
$lang['rememberpasswds'] = "Remember passwords";
$lang['enterasa'] = "Enter as a";
$lang['donthaveanaccount'] = "Don't have an account?";
$lang['problemsloggingon'] = "Problems logging on?";
$lang['deletecookies'] = "Delete Cookies";
$lang['forgottenpasswd'] = "Forgotten your password?";
$lang['usingaPDA'] = "Using a PDA?";
$lang['lightHTMLversion'] = "Light HTML version";
$lang['youhaveloggedout'] = "You have logged out.";
$lang['currentlyloggedinas'] = "You are currently logged in as";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['selectfolder'] = "Select folder";
$lang['messagecontainsHTML'] = "Message Contains HTML";
$lang['notincludingsignature'] = "(not including signature)";
$lang['mustenterpostcontent'] = "You must enter some content for the post!";
$lang['messagepreview'] = "Message Preview";
$lang['invalidusername'] = "Invalid username!";
$lang['mustenterthreadtitle'] = "You must enter a title for the thread!";
$lang['pleaseselectfolder'] = "Please select a folder!";
$lang['errorcreatingpost'] = "Error creating post! Please try again in a few minutes.";
$lang['createnewthread'] = "Create new thread";
$lang['postreply'] = "Post Reply";
$lang['threadtitle'] = "Thread title";
$lang['messagehasbeendeleted'] = "Message has been deleted.";
$lang['converttoHTML'] = "Convert to HTML";
$lang['pleaseentermembername'] = "Please enter a membername:";
$lang['cannotpostthisthreadtypeinfolder'] = "You cannot post this thread type in that folder!";
$lang['cannotpostthisthreadtype'] = "You cannot post this thread type as there are no available folders that allow it.";
$lang['threadisclosedforposting'] = "This thread is closed, you cannot post in it!";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "in reply to";
$lang['showmessages'] = "Show messages";
$lang['ratemyinterest'] = "Rate my interest";
$lang['adjtextsize'] = "Adjust text size";
$lang['smaller'] = "Smaller";
$lang['larger'] = "Larger";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Support";
$lang['threadcouldnotbefound'] = "The requested thread could not be found or access was denied.";
$lang['mustselectpolloption'] = "You must select an option to vote for!";
$lang['keepreading'] = "Keep reading";
$lang['backtothreadlist'] = "Back to thread list";
$lang['postdoesnotexist'] = "That post does not exist in this thread!";
$lang['clicktochangevote'] = "Click to change vote";
$lang['youvotedforoption'] = "You voted for option";
$lang['clicktovote'] = "Click to vote";
$lang['youhavenotvoted'] = "You have not voted";
$lang['viewresults'] = "View Results";
$lang['msgtruncated'] = "Message Truncated";
$lang['viewfullmsg'] = "View full message";
$lang['ignoredmsg'] = "Ignored message";
$lang['wormeduser'] = "Wormed user";
$lang['ignoredsig'] = "Ignored signature";
$lang['wasdeleted'] = "was deleted";
$lang['stopignoringthisuser'] = "Stop ignoring this user";
$lang['renamethread'] = "Rename thread";
$lang['movethread'] = "Move thread";
$lang['editthepoll'] = "Edit the poll";
$lang['torenamethisthread'] = "to rename this thread";
$lang['reopenforposting'] = "Reopen for posting";
$lang['closeforposting'] = "Close for posting";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "Start";
$lang['messages'] = "Messages";
$lang['pminbox'] = "PM Inbox";
$lang['pmsentitems'] = "Sent Items";
$lang['pmoutbox'] = "Outbox";
$lang['pmsaveditems'] = "Saved Items";
$lang['links'] = "Links";
$lang['preferences'] = "Preferences";
$lang['profile'] = "Profile";
$lang['admin'] = "Admin";
$lang['login'] = "Login";
$lang['logout'] = "Logout";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "Private Messages";
$lang['sendnewpm'] = "Send New PM";
$lang['savemessage'] = "Save Message";
$lang['sentby'] = "Sent By";
$lang['timesent'] = "Time Sent";
$lang['nomessages'] = "No Messages";
$lang['errorcreatingpm'] = "Error creating PM! Please try again in a few minutes";
$lang['writepm'] = "Write Message";
$lang['editpm'] = "Edit Message";
$lang['cannoteditpm'] = "Cannot edit this PM. It has already been viewed by the recipient or the message does not exist or it is inaccessible by you";
$lang['cannotviewpm'] = "Cannot view PM. Message does not exist or it is inaccessible by you";
$lang['nomessagespecifiedforreply'] = "No message specified for reply to";

// Preferences (prefs.php) ---------------------------------------------
$lang['newpasswd'] = "New Password";
$lang['confirmpasswd'] = "Confirm Password";
$lang['passwdsdonotmatch'] = "Passwords do not match!";
$lang['nicknamerequired'] = "Nickname is required!";
$lang['emailaddressrequired'] = "Email address is required!";
$lang['jan'] = "January";
$lang['feb'] = "February";
$lang['mar'] = "March";
$lang['apr'] = "April";
$lang['may'] = "May";
$lang['jun'] = "June";
$lang['jul'] = "July";
$lang['aug'] = "August";
$lang['sep'] = "September";
$lang['oct'] = "October";
$lang['nov'] = "November";
$lang['dec'] = "December";
$lang['userpreferences'] = "User Preferences";
$lang['preferencesupdated'] = "Preferences were successfully updated.";
$lang['leaveblanktoretaincurrentpasswd'] = "Leave blank to retain current password";
$lang['firstname'] = "First name";
$lang['lastname'] = "Last name";
$lang['dateofbirth'] = "Date of Birth";
$lang['homepageURL'] = "Homepage URL";
$lang['pictureURL'] = "Picture URL";
$lang['forumoptions'] = "Forum Options";
$lang['notifybyemail'] = "Notify by email of posts to me";
$lang['notifyofnewpm'] = "Notify by popup of new PM messages to me";
$lang['notifyofnewpmemail'] = "Notify by email of new PM messages to me";
$lang['daylightsaving'] = "Adjust for daylight saving";
$lang['autohighinterest'] = "Automatically mark threads I post in as High Interest";
$lang['globallyignoresigs'] = "Globally ignore user signatures";
$lang['timezonefromGMT'] = "Timezone";
$lang['postsperpage'] = "Posts per page";
$lang['fontsize'] = "Font size";
$lang['forumstyle'] = "Forum style";
$lang['startpage'] = "Start page";
$lang['containsHTML'] = "Contains HTML";
$lang['preferredlang'] = "Preferred language";
$lang['ageanddob'] = "Age and date of birth";
$lang['neitheragenordob'] = "Do not show to others";
$lang['showonlyage'] = "Show only age to others";
$lang['showageanddob'] = "Show to others";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "You must enter a poll question";
$lang['pleaseselectfolder'] = "Please select a folder";
$lang['mustspecifyvalues1and2'] = "You must specify values for answers 1 and 2";
$lang['abletochangevote'] = "You will be able to change your vote.";
$lang['abletovotemultiple'] = "You will be able to vote multiple times.";
$lang['notabletochangevote'] = "You will not be able to change your vote.";
$lang['pollvotesrandom'] = "Note: Poll votes are randomly generated for preview only.";
$lang['pollquestion'] = "Poll Question";
$lang['possibleanswers'] = "Possible Answers";
$lang['enterpollquestionexp'] = "Enter the answers for your poll question.. If your poll is a \"yes/no\" question, simply enter \"Yes\" for Answer 1 and \"No\" for Answer 2.";
$lang['numberanswers'] = "No. Answers";
$lang['answerscontainHTML'] = "Answers Contain HTML (not including signature)";
$lang['votechanging'] = "Vote Changing";
$lang['votechangingexp'] = "Can a person change his or her vote?";
$lang['allowmultiplevotes'] = "Allow Multiple Votes";
$lang['pollresults'] = "Poll Results";
$lang['pollresultsexp'] = "How would you like to display the results of your poll?";
$lang['horizgraph'] = "Horizontal Bar graph";
$lang['vertgraph'] = "Vertical Bar graph";
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
$lang['nobodyvoted'] = "Nobody voted.";
$lang['nobodyhasvoted'] = "Nobody has voted.";
$lang['1personvoted'] = "1 person voted.";
$lang['1personhasvoted'] = "1 person has voted.";
$lang['peoplevoted'] = "people voted.";
$lang['peoplehavevoted'] = "people have voted.";
$lang['pollhasended'] = "Poll has ended";
$lang['yourvotewas'] = "Your vote was";
$lang['youvotedforoption'] = "You voted for option";
$lang['thisisapoll'] = "This is a poll. Click to view results.";
$lang['editpoll'] = "Edit Poll";
$lang['results'] = "Results";
$lang['changevote'] = "Change vote";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Edit Profile";
$lang['profileupdated'] = "Profile updated.";
$lang['profilesnotsetup'] = "The forum owner has not set up Profiles.";
$lang['nouserspecified'] = "No user specified";
$lang['ignoreduser'] = "Ignored user";
$lang['lastvisit'] = "Last Visit";
$lang['sendemail'] = "Send email";
$lang['sendpm'] = "Send PM";
$lang['removefromfriends'] = "Remove from friends";
$lang['addtofriends'] = "Add to friends";
$lang['stopignoringuser'] = "Stop ignoring user";
$lang['ignorethisuser'] = "Ignore this user";
$lang['age'] = "Age";
$lang['aged'] = "aged";
$lang['birthday'] = "Birthday";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "Username must not contain HTML tags";
$lang['usernameinvalidchars'] = "Username can only contain a-z, 0-9, _ - characters";
$lang['usernametooshort'] = "Username must be a minimum of 2 characters long";
$lang['usernametoolong'] = "Username must be a maximum of 15 characters long";
$lang['usernamerequired'] = "A logon name is required";
$lang['passwdmustnotcontainHTML'] = "Password must not contain HTML tags";
$lang['passwdtooshort'] = "Password must be a minimum of 6 characters long";
$lang['passwdrequired'] = "A password is required";
$lang['confirmationpasswdrequired'] = "A confirmation password is required";
$lang['nicknamemustnotcontainHTML'] = "Nickname must not contain HTML tags";
$lang['nicknamerequired'] = "A nickname is required";
$lang['emailmustnotcontainHTML'] = "Email must not contain HTML tags";
$lang['emailrequired'] = "An email address is required";
$lang['passwdsdonotmatch'] = "Passwords do not match";
$lang['usernamesameaspasswd'] = "Username and password must be different";
$lang['usernameexists'] = "Sorry, a user with that name already exists";
$lang['userrecordcreated'] = "Huzzah! Your user record has been created successfully!";
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
$lang['itemsmarkedwithaasterixarerequired'] = "Items marked with a * are required";
$lang['confirmpassword'] = "Confirm Password";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Member";
$lang['searchforusernotinlist'] = "Search for a user not in list";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "User Relationship";
$lang['relationship'] = "Relationship";
$lang['friend_exp'] = "User's posts marked with a &quot;Friend&quot; icon.";
$lang['normal_exp'] = "User's posts appear as normal.";
$lang['ignore_exp'] = "User's posts are hidden.";
$lang['display'] = "Display";
$lang['displaysig_exp'] = "User's signature is displayed on their posts.";
$lang['hidesig_exp'] = "User's signature is hidden on their posts.";
$lang['globallyignored'] = "Globally ignored";
$lang['globallyignoredsig_exp'] = "No signatures are displayed.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "Search Results";
$lang['usernamenotfound'] = "The username you specified in the to or from field was not found.";
$lang['notexttosearchfor_1'] = "You did not specify any words to search for or the words were under";
$lang['notexttosearchfor_2'] = "characters long";
$lang['found'] = "Found";
$lang['matches'] = "matches";
$lang['prevpage'] = "Previous page";
$lang['findmore'] = "Find more";
$lang['searchmessages'] = "Search Messages";
$lang['searchdiscussions'] = "Search discussions";
$lang['containingallwords'] = "Containing all of the words";
$lang['containinganywords'] = "Containing any of the words";
$lang['containingexactphrase'] = "Containing the exact phrase";
$lang['find'] = "Find";
$lang['wordsshorterthan_1'] = "Words shorter than";
$lang['wordsshorterthan_2'] = "characters will not be included";
$lang['additionalcriteria'] = "Additional Criteria";
$lang['folderbrackets_s'] = "Folder(s)";
$lang['postedfrom'] = "Posted from";
$lang['postedto'] = "Posted to";
$lang['today'] = "Today";
$lang['yesterday'] = "Yesterday";
$lang['daybeforeyesterday'] = "Day before yesterday";
$lang['weekago'] = "week ago";
$lang['weeksago'] = "weeks ago";
$lang['monthago'] = "month ago";
$lang['monthsago'] = "months ago";
$lang['yearago'] = "year ago";
$lang['beginningoftime'] = "Beginning of time";
$lang['now'] = "Now";
$lang['relevance'] = "Relevance";
$lang['newestfirst'] = "Newest first";
$lang['oldestfirst'] = "Oldest first";
$lang['onlyshowmessagestoorfromme'] = "Only show messages to or from me";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Recent threads";
$lang['startreading'] = "Start Reading";
$lang['threadoptions'] = "Thread Options";
$lang['showmorevisitors'] = "Show More Visitors";
$lang['forthcomingbirthdays'] = "Forthcoming Birthdays";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "New Discussion";
$lang['createpoll'] = "Create Poll";
$lang['search'] = "Search";
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
$lang['ivesubscribedto'] = "I've subscribed to";
$lang['startedbyfriend'] = "Started by friend";
$lang['unreadstartedbyfriend'] = "Unread std by friend";
$lang['goexcmark'] = "Go!";
$lang['folderinterest'] = "Folder Interest";
$lang['postnew'] = "Post New";
$lang['currentthread'] = "Current Thread";
$lang['highinterest'] = "High Interest";
$lang['markasread'] = "Mark as Read";
$lang['next50discussions'] = "Next 50 discussions";
$lang['visiblediscussions'] = "Visible discussions";
$lang['navigate'] = "Navigate";
$lang['couldnotretrievefolderinformation'] = "There are no folders available.";
$lang['nomessagesinthiscategory'] = "No messages in this category. Please select another, or";
$lang['clickhere'] = "click here";
$lang['forallthreads'] = "for all threads";
$lang['prev50threads'] = "Previous 50 threads";
$lang['next50threads'] = "Next 50 threads";
$lang['startedby'] = "Started by";
$lang['unreadthread'] = "Unread Thread";
$lang['readthread'] = "Read Thread";
$lang['unreadmessages'] = "Unread Messages";
$lang['subscribed'] = "Subscribed";
$lang['ignorethisfolder'] = "Ignore This Folder";
$lang['stopignoringthisfolder'] = "Stop Ignoring This Folder";

?>
