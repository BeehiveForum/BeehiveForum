Beehive Forum Readme

Version 0.4 / 10th December 2003

A list of changes since previous Beehive versions can be found in release.txt.

0. Contents
===========

1.    Installation
  1.1    Requirements
  1.2    Instructions
    1.2.1    Archive Extraction
    1.2.2    Database setup
    1.2.3    Configuring the forum
    1.2.4    Upload
    1.2.5    First use
    1.2.6    Adminning
    1.2.7    What to do if it doesn't work
    1.2.8    Add your forum to our list
  1.3    Customising Beehive
    1.3.1    Stylesheet
    1.3.2    Images
    1.3.3    The top frame
  1.4    Upgrading from 0.3 to 0.4
    1.4.1    Update the database
    1.4.2    Update the config file
  1.5    Upgrading from 0.2 to 0.3
  1.6    Upgrading from 0.1 / 0.1.1 to 0.2
  1.7    Upgrading from 0.1 or 0.2 to 0.4

2.    Known Issues

3.    Support
  3.1    Requests / Bug reporting
  3.2    General questions and help
  3.3    BeehiveForums in foreign languages
    3.3.1    Translating BeehiveForums into my native language
    3.3.2    Current Available Languages   

4.    Credits


1. Installation
===============

1.1 Requirements
================
You need web hosting which provides:
  - PHP 4.x (tested on 4.0.6, 4.1.x, 4.2.x, 4.3.0 and 4.3.3) and
  - MySQL 3.5 or above (must support compound AUTO_INCREMENT).


1.2 Instructions
================

1.2.1 Archive Extraction
========================

How you extract the contents of the Beehiveforum distribution archive is very
important. At all times please ensure that you retain the directory structure
of the archive. If everything has been extracted correctly you should be
presented with a directory that looks a bit like this:

|- forum
|  |- docs
|  |  |- schema.sql
|  |  |- upgrade-01-to-02.sql
|  |  |- ...
|  |
|  |- forum
|  |  |- attachments
|  |  |- images
|  |  |  |- admintool.png
|  |  |  |- align_center_button.png
|  |  |  |- ...
|  |  |
|  |  |- include
|  |  |  |- admin.inc.php
|  |  |  |- attachments.inc.php
|  |  |  |- ...
|  |  |
|  |  |- js
|  |  |  |- edit.js
|  |  |  |- htmltools.js
|  |  |  |- ...
|  |  |
|  |  |- styles
|  |  |  |- default
|  |  |  |  |- images
|  |  |  |  |  |- admintool.png
|  |  |  |  |  |- attach.png
|  |  |  |  |- style.css
|  |  |  |  |- top.html


As you can see the main distribution contains a docs and forum folder. The main
forum folder, which actually contains Beehive, itself contains several more
folders with relevant files in them. If they are not extracted in the right place
subsequently uploading them to your server in this incorrect order will result in
Beehive not working correctly.

1.2.2 Database setup
====================

To set up the database, use something like phpMyAdmin (get it from
https://sourceforge.net/projects/phpmyadmin/), or direct MySQL if you
have the "skillz", to run the /docs/schema.sql file from the download.

(Beehive would prefer its very own database, but if you can't provide that, it
should work in an existing one.)

If you're feeling saucy, you can edit the insert statements to alter the thread
title and content of the default first post, but if you don't know SQL, it's
probably best to leave well alone.


1.2.3 Configuring the forum
===========================

OK, now you need to make some simple changes to one of the files. Don't
worry, it's easy.

Look in the forum/include folder, and open the file called "config.inc.php".

In here are some variables you need to set so that Beehive Forum can find your
database:

$db_server   = "localhost";     // the address of your MySQL server
$db_username = "user";  // your MySQL username
$db_password = "password";      // your MySQL password
$db_database = "beehivedbs";    // the name of your MySQL database

You need to change those values in quotes to the correct details for your MySQL
setup. You should be able to get the information from your hosting provider if
you're not running your own server.

Next section:

$forum_name  = "A Beehive Forum"; // the name of your forum
$forum_email = "webmaster@yourdomain.com"; // admin email
$default_style = "default"; // the default forum style directory name

Change $forum_name to whatever you want displayed in the browser title bar for
your forum. This value is also used when sending e-mails notifying people of
posts.

Change $forum_email to a reasonable email address which your notification will
be "from". You may want to make this "noreply@yourdomain.com", just in case some
of your users take it upon themselves to reply to it.

That's all you need to do to get the forum running - however, you can read on for
more information on other things you can change.

Change $default_style to the name of the style you want as the default for your
forum. See section 1.3, Customising Beehive, for more info.

As of 0.4 Beehive supports I18N language selection based on the client browser
HTTP_ACCEPT_LANGUAGE header. The $default_language setting is the language file
that Beehive should fall back to if the language specified by the client is not
available. It should be set to the filename (sans the .inc.php part of the
filename - i.e. en for en.inc.php).

When $show_friendly_errors is set to true Beehive will implement it's own error
handler which will be used to show friendly error messages rather than PHP's own
error messages. Unfortunately this setting can cause problems with certain
server configurations / PHP versions, so if you encounter any problems (blank
pages for example) it is recommended that you try and disable this option.

The $cookie_domain setting is designed for use in a multiple subdomain environ-
ment, where the forum installation is accessible from multiple addresses. For
example, if your forum is accessible from both http://forum.mydomain.com/ and
http://www.mydomain.com/forum, you could set the $cookie_domain setting as
".mydomain.com" and this would then allow people to visit either address with
out having to login more than once per session.

With 0.4, Beehive Forum includes some basic stats such as a current active user
list and highest post count. If you do not want your users to be able to make
use of such a setting (they can configure it themselves to be hidden if they wish)
you can set this variable to false.

$show_links makes the links section available. If you don't want to make use of
the links page you can set this variable to false.

Beehive 0.4 includes the ability to have Guests logged in automatically as per
Delphi.com. By default this is enabled, but if you don't want this functionality you
can set the $auto_logon variable to false and users will be forced to the login
page. This setting relies on the $guest_account_enabled variable which is detailed
below.

Personal Messages are now possible in Beehive. If you do not want your users to be
able to send PMs, you can set the $show_pms to false. In addition to this you can
also set the $pm_allow_attachment variable to false if you do not want your users
to be able to add attachments to their PMs. The $pm_allow_attachment is dependant
on the $attachments_enabled variable which is detailed below.

$maximum_post_length: this limits the amount of a post that will be displayed in
the message list, not the maximum possible size of posts. That's unlimited.

$allow_post_editing: choose whether to allow users to edit their own posts if
they've made a mistake by setting it to true, or change to false to disallow post
editing by users (moderators can always edit posts).

$post_edit_time: you can restrict the time that posts are editable by users for
after they are created - set it to a number of hours, or to 0 to allow posts to be
edited at any time.

$allow_polls: When set to false this prevents users from being able to create any
new polls. Current polls will be unaffected by this setting so users' will still
be able to vote.

$search_min_word_length: This allows you to specify a minimum word length that can
be searched for using the Beehive search page. Setting this higher can decrease
the load on your server caused by people searching and also increases the overall
accuracy.

$attachments_enabled: turns the attatchments feature on (true) or off (false).
If you have limited web space or bandwidth, you may want to turn off this feature.

$attachment_dir: If you choose to enable attachments, you will also need to set a
folder for the files to be kept in. The default, "attachments", would use a folder
called "attachments" in the installation folder. If you wish, you can specify a
root-relative path to keep them somewhere else (e.g. "/www/myattachmentdir").

$guest_account_enabled: enable (true) or disable (false) the guest account, to choose
whether or not to allow casual browsers to read the forum.

$session_cutoff: This is the length of time in seconds before an idle user is
deemed 'stale' and the user's session is automatically ended. By default this
is set to 24 hours (86400 seconds). If a user remains active then their session
will not expire.

$active_sess_cutoff: This is the length of time in seconds before an idle user
is removed from the active users stats display. Once this time laps the user's
name will be removed from the display. This setting does not affect the validity
of their session and they will not be logged out. Once they become active again
they will automatically reappear on the stats display.

$gzip_compress_output: this nifty feature compresses the HTML output that is sent to
the browser, which saves your bandwidth, at a cost of a slight increase in server CPU
usage. Set to true for on or false for off.

$gzip_compress_level: this setting specifies the level of the gzip compression to use,
with 1 being the lowest and least CPU intensive and 9 the highest. Only integer values
may be expressed in this setting, so a value of 1.4 would be meaningless. Unless you
know what you are doing it is not recommended that you change this value.

Save your changes.


1.2.4 Upload
============

Once you have configured that file, you can upload the forum onto your webspace.
We recommend that you simply upload the "forum" folder directly, either into the
root of your webspace or into another folder of your choosing.


1.2.5 First use
===============

When it's uploaded, open it in your browser, using the address like:

http://www.mysite.com/forum/

but pointing to wherever you've put it. If all has gone well, you should be
faced with a logon screen.

The setup created the administrator login for you, which is as follows:

Logon:    ADMIN
Password: honey

That gives you access to everything, so you can create folders, set user
permissions and so forth. The first thing you should do after logging in is
change that password to something only you know, to stop someone else staging a
coup, and stuff.


1.2.6 Adminning
===============

Now you're ready to create some folders, so click the admin link near the top of
the page, then choose folders from the menu on the left, and set them up.

The other links on the left let you set up profile sections and items, where
your members can provide information about themselves if they like, and do stuff
to users, like ban them, gag them or promote them. It's all explained in there.


1.2.7 What to do if it doesn't work
===================================

Don't panic. Pop over to http://beehiveforum.net/forum and ask us
for help, but remember, we don't get paid for this, so be nice.

It's helpful if you can tell us your setup when you've got a problem, such as
the type of server (e.g. Linux/Apache, Windows/Apache or Windows/IIS, etc) and
the version of PHP and MySQL that you're using. If Beehive threw up an error
message, paste that in as well.


1.2.8 Add your forum to our list (optional)
===========================================

If you like, you can add your shiny new forum to our list of live copies by
going to http://beehiveforum.net/forums.php

It could be a bit of publicity for your site, and it helps us to be able to say
"Look, all these people are using it!", but if you don't want to, you don't have
to.


1.3 Customising Beehive
=======================

Beehive Forum has user-selectable styles. Basically these are like themes
(or skins for WinAmp users) for your forum. There are several supplied styles,
and it's easy to create your own.

You can edit the existing styles, but we recommend that you create your own styles.

To create a new style, just create a new folder in the styles folder, with the name
of the new style. For example, to add a style called "fish", you need a folder called
"fish" in the "styles" folder.

Then copy in the contents of one of the existing folders to base your new style on
(the "default" folder is probably a good start) - style.css, top.html and the images
folder with contents.

Additionally you can also create random styles by using the forum styles tool in the
admin section of the forum. Unfortunatly this tool does not allow you to specify
different multiple colours to use, rather it rather cunningly chooses some for you
that are mathematically determined to be suitable based on your first choice. Watch
this space for a fully fledged style edited.


1.3.1 Stylesheet
================

If you know how to do CSS, you can edit the style.css file in the
forum/styles/[stylename] folder to change colors, fonts and things like that.
We recommend taking a backup first, though, in case you make a mess of it.


1.3.2 Images
============

Feel free to edit the images in the forum/styles/[stylename]/images folder too,
as long as the sizes remain the same. Again, you might want to take backups.


1.3.3 The top frame
===================

The very top frame is yours to do with as you wish. In each style's folder you will
find a file called "top.html", which you can edit any way you like, put what you
want in there, little Flash movies with solar/lunar cycles or big headache
inducing adverts for stuff, it's entirely up to you.
Just keep it 60 pixels high or under.


1.4 Upgrading from 0.3 to 0.4
=============================

If you are already using 0.3 of Beehive Forum, you will need to update your
database, and add some new variables to the config.inc.php file.


1.4.1 Update the database
=========================

Simply run the /docs/update-03-to-04.sql script against the database using phpMyAdmin or
MySQL directly.


1.4.2 Update the config file
============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.4 download
and set the relevant variables again.

However, you can also add the new variables to your existing config.inc.php if you wish.
See section 1.2.2 "Configuring the forum" for details.

1.5 Upgrading from 0.2 to 0.3
=============================

Follow the same procedure as detailed above, but you must run /docs/upgrade-02-to-03.sql
beforehand.


1.6 Upgrading from 0.1 / 0.1.1 to 0.2
=====================================

Follow the same procedure as detailed above, but you must run /docs/upgrade-01-to-02.sql
beforehand


1.7 Upgrading from 0.1 or 0.2 to 0.4
====================================

No direct route exists for 0.1 or 0.2 to be upgraded to 0.4. To upgrade either of these
versions to 0.4 you will need to run the relevant schema files in order. For example
if you are using Beehive 0.1 you will need to run /docs/upgrade-01-to-02.sql, followed
by /docs/upgrade-02-to-03.sql, followed by /docs/upgrade-03-to-04.sql. This will bring
the database up to date. Likewise to upgrade from 0.2 you will need to run both 
/docs/upgrade-02-to-03.sql then /docs/upgrade-03-to-04.sql.


2 Known Issues
==============

- The PM notification pop-up always displays in English UK.

- Folders created under 0.3 or below which contained quotes will now
  display incorrectly in 0.4. You can fix this by visiting the admin
  folders option and fixing the folder names. This was due to a bug
  in previous versions which has now been fixed.


3 Support
=========


3.1 Requests / Bug reporting
============================

All this can be done through the Project page provided by SourceForge.
Simply browse to http://sourceforge.net/projects/beehiveforum and submit
requests or bug reports there.


3.2 General questions and help
==============================

You can also try dropping in to http://beehiveforum.net/forum, which
is a testbed for the software where you can ask for help or check on the
progress of the next version. There is a bugs folder there too, but it's very
informal - it's best to use it to let us know that you've posted a bug in the SF
system.


3.3 BeehiveForums in foreign langauges
======================================

As of 0.4 BeehiveForums supports multiple languages, but because we're all very
busy doing other things the number of languages that ship with Beehive are few
and far between.


3.3.1 Translating BeehiveForums into my native language
=======================================================

Unfortunatly the BeehiveForum coding team consists primarily of born and bread
English men who have enough trouble speaking our own tongue as it is. Because
of this, we're on the look out for people to start translating Beehive for us.
If you feel you have the necessary skills to do this (no babelfish / direct
from dictionary translations please) feel free to drop us a note. With any
luck your language file may end up being distributed with future versions of
BeehiveForums and you may even get to see your name in print, or at the very
least bundled here amongst the other credits.


3.3.2 Current Available Languages
=================================

Current available languages are as follows:

English (UK)
French (note: incomplete - includes some English phrases still)
X-Hacker
Gangsta


4 Credits
=========

4.1 Coding
==========

Matt Beale / Andy Black / Chris Hodcroft / Mark Rendle / Mike Franklin / Ben Sekulowicz / Andrew Holgate


4.2 Design/CSS
==============

Mike Franklin / Simon Roberts / Kevin Yip


4.3 Graphics
============

Nigel Moore / Kevin Yip / Andrew Holgate / Mike Quigley


4.4 Translations
================

French   - Mark Krywonos
Gangsta  - Jay Graham.
X-Hacker - Matt Beale.


4.5 Contributions
=================

Mike Quigley / Frnht451 / Peter Kelly / "Michael" from www.hermitscave.org / Peter Boughton / Lots of other people


4.6 Directors
=============

Matt Beale
Mark Rendle - taking time out


4.7 Special Thanks
==================

- The Teh Forumers for testing, moral support, saying nice things and just generally
  being teh cool.
  
- Mike Quigley for Teh Backup Forum, Breaking lots of things and pimping Beehive without fail.

- SourceForge (http://sourceforge.net) for providing top-notch facilities to us
  (and to thousands of other projects) at absolutely no cost.


4.7.1 Matt would like to thank:
===============================

- Mike Franklin, Pete Kelly, Jon Cooper and Yvonne for just being who you are.


FIN
