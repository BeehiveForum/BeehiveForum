Beehive Forum Readme

Version 0.4.1 / 17th March 2004

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
  1.4    Upgrading 0.4 to 0.4.1
    1.4.1    Make a back up of your database
    1.4.2    Update the database
    1.4.3    Update the config file
  1.5    Upgrading from 0.3 to 0.4
  1.6    Upgrading from 0.2 to 0.3
  1.7    Upgrading from 0.1 / 0.1.1 to 0.2
  1.8    Upgrading from 0.1 or 0.2 to 0.4

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
  - PHP 4.x (tested on 4.0.6, 4.1.x, 4.2.x, 4.3.0, 4.3.3 and 4.3.4) and
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
Beehive working incorrectly or not at all.

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
$db_username = "user";          // your MySQL username
$db_password = "password";      // your MySQL password
$db_database = "beehivedbs";    // the name of your MySQL database

You need to change those values in quotes to the correct details for your MySQL
setup. You should be able to get the information from your hosting provider if
you're not running your own server.

Save your changes.

IMPORTANT: As of BeehiveForum 0.4.1 the additional settings in config.inc.php have
           been moved to a database table. If you are upgrading to 0.4.1 any
           settings you have in your config.inc.php file will be ignored and you
           will need to log into your forum and visit the Admin section to restore
           them to their old values.

1.2.4 Upload
============

Once you have configured that file, you can upload the forum onto your web space.
We recommend that you simply upload the "forum" folder directly, either into the
root of your web space or into another folder of your choosing.


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
admin section of the forum. Unfortunately this tool does not allow you to specify
different multiple colours to use, rather it rather cunningly chooses some for you
that are mathematically determined to be suitable based on your first choice. Watch
this space for a fully fledged style edited.


1.3.1 Stylesheet
================

If you know how to do CSS, you can edit the style.css file in the
forum/styles/[stylename] folder to change colours, fonts and things like that.
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


1.4 Upgrading from 0.4 to 0.4.1
===============================

If you are already using 0.4 of Beehive Forum, you will need to update your
database.

1.4.1 Make a back up of your database
======================================

You MUST make a back up of your database before you perform the upgrade. We 
can't stress how important this is. If you don't perform a backup and something
goes wrong don't make us say we told you so.

The easiest way to perform a back up is by telnetting into your server and making
a physical copy of the mysql/beehiveforum folder. You'll know when you've found
the right one when you come across loads of .MYI and .MYD files with the same
names as the BeehiveForum tables.

If you can do this then great, if not you might want to ask your hosting provider
if they can do it for you, at least temporarily why you do the upgrade. Then if
anything does go wrong you can ask them to restore the data.

If your ISP are less than cooperative about doing this then your next best chance
of performing a backup is by using phpMyAdmin and making use of it's Export
facility to save a copy of the database to your HD using your web browser. 
Be warned that doing it this way will result in a easily rather large file being
created on your HD so make sure you have adequate disc space in order to do this.
It will also be harder to restore the backup this way.


1.4.2 Update the database
=========================

Simply run the /docs/update-04-to-041.sql script against the database using phpMyAdmin or
MySQL directly.


1.4.3 Update the config file
============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.4 download
and set the relevant variables again.

IMPORTANT: As of BeehiveForum 0.4.1 the additional settings in config.inc.php have
           been moved to a database table. If you are upgrading to 0.4.1 any
           settings you have in your config.inc.php file will be ignored and you
           will need to log into your forum and visit the Admin section to restore
           them to their old values.

1.5 Upgrading from 0.2 to 0.3
=============================

Follow the same procedure as detailed above, but you must run /docs/upgrade-02-to-03.sql
beforehand.


1.6 Upgrading from 0.1 / 0.1.1 to 0.2
=====================================

Follow the same procedure as detailed above, but you must run /docs/upgrade-01-to-02.sql
beforehand


1.7 Upgrading from 0.1 or 0.2 to 0.4.1
======================================

No direct route exists for 0.1 or 0.2 to be upgraded to 0.4.1. To upgrade either of these
versions to 0.4.1 you will need to run the relevant schema files in order. 

For example if you are using Beehive 0.1 you will need to run:

upgrade-01-to-02.sql followed by..
upgrade-02-to-03.sql followed by..
upgrade-03-to-04.sql and finally..
upgrade-04-to-041.sql.

This will bring the database up to date. Likewise to upgrade from 0.3 you will
need to run:

upgrade-03-to-04.sql followed by..
upgrade-04-to-041.sql.


2 Known Issues
==============

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
is a test bed for the software where you can ask for help or check on the
progress of the next version. There is a bugs folder there too, but it's very
informal - it's best to use it to let us know that you've posted a bug in the SF
system.


3.3 BeehiveForums in foreign languages
======================================

As of 0.4 BeehiveForums supports multiple languages, but because we're all very
busy doing other things the number of languages that ship with Beehive are few
and far between.


3.3.1 Translating BeehiveForums into my native language
=======================================================

Unfortunately the BeehiveForum coding team consists primarily of born and bread
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
