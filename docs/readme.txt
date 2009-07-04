Beehive Forum Readme

http://www.beehiveforum.net/

Version 0.9 / 4th July 2009

A list of changes since previous Beehive Forum versions can be found
in release.txt.

0. Contents
===========

1.    Installation
  1.1    Requirements
  1.1.1  Requirements Notes
  1.2    Instructions
    1.2.1    Archive Extraction
    1.2.2    Database setup
    1.2.3    MySQL permissions
    1.2.4    Upload
    1.2.5    Installing the forum
    1.2.6    Installing from CLI
    1.2.7    Creating your config.inc.php
    1.2.8    First use
    1.2.9    Adminning
    1.2.10    What to do if it doesn't work
    1.2.11   Add your forum to our list
  1.3    Customising your Beehive Forum
    1.3.1    Style sheet
    1.3.2    Images
    1.3.3    The top frame
    1.3.4    Emoticons
    1.3.5    GeSHi
    1.3.6    TinyMCE
  1.4    Upgrading from previous versions of Beehive Forum
    1.4.1    Upgrading your Beehive Forum installation
      1.4.1.1    Make a back up of your database
      1.4.1.2    Back up your files
      1.4.1.3    Upload new forum files
      1.4.1.4    Run the upgrade script
    1.4.2    Skipping a version during upgrade
    1.4.3    Upgrading 0.5PR1 to 0.5.
    1.4.4    Upgrading 0.3 to 0.4.
      1.4.4.1    Update the database
      1.4.4.2    Update the config file
    1.4.5   Upgrading from 0.2 to 0.3
    1.4.6   Upgrading from 0.1 / 0.1.1 to 0.2
    1.4.7   Upgrading from 0.1 or 0.2 to 0.4
  1.5    Beehive Forum Error Reporter
    1.5.1   Enabling Error Reporter after upgrading

2.    Known Issues

3.    Support
  3.1    Requests / Bug reporting
  3.2    General questions and help
  3.3    Beehive Forums in foreign languages
    3.3.1    Translating Beehive Forums into my native language
    3.3.2    Completed Translations
    3.3.3    Incomplete / Partial Translations

4.    Credits


1. Installation
===============

1.1 Requirements
================

You need web hosting which provides:

  - PHP 5.1.0 or above
  - MySQL 4.1.16 or above
  - PCRE 6.6 compiled with --enable-utf8 --enable-unicode-properties

1.1.1 Requirements Notes
========================

- Beehive Forum requires PHP 5.0 as a minimum, but we recommend installing
  the latest PHP 5.2.x release where possible.
  
- PCRE runtime compiled with --enable-utf8 --enable-unicode-properties is
  requried. PCRE support is OS dependent, please check with your host 
  for PCRE requirements.

- MySQL 4.1.16 or newer is required by Beehive Forum. As with PHP we recommend
  installing the latest release of MySQL 5 if possible.

- As a minimum Beehive Forum requires the following privileges on the
  MySQL database and tables it runs from:

  SELECT, CREATE, CREATE TEMPORARY TABLES, 
  INSERT, ALTER, UPDATE, INDEX, DELETE and DROP.

  You may optionally grant the FILE permission to speed up the creation
  of the dictionary during installation but Beehive Forum. Once installation
  has completed you may restore the default permissions without suffering
  any reduced functionality.

1.2 Instructions
================

1.2.1 Archive Extraction
========================

How you extract the contents of the Beehive Forum distribution archive is very
important. At all times please ensure that you retain the directory structure
of the archive. If everything has been extracted correctly you should be
presented with a directory that looks a bit like this:

|- docs
|  |- schema.sql
|  |- upgrade-01-to-02.sql
|  |- ...
|
|- forum
|  |- attachments
|  |  |- ...
|  |
|  |- emoticons
|  |  |- default
|  |  |  |- images
|  |  |  |  |- alien.png
|  |  |  |  |- ...
|  |  |  |
|  |  |  |- definitions.php
|  |  |  |- desc.txt
|  |  |  |- style.css
|  |  |
|  |  |- none
|  |  |  |- desc.txt
|  |  |  |- style.css
|  |  |
|  |  |- text
|  |  |  |- desc.txt
|  |  |
|  |  |- README
|  |
|  |- forums
|  |  
|  |- images
|  |  |- admin_locked.png
|  |  |- admintool.png
|  |  |- ...
|  |
|  |- include
|  |  |- admin.inc.php
|  |  |- attachments.inc.php
|  |  |- ...
|  |
|  |- install
|  |  |- config.inc.php
|  |  |- new-install.php
|  |  |- ...
|  |
|  |- js
|  |  |- edit.js
|  |  |- htmltools.js
|  |  |- ...
|  |
|  |- styles
|  |  |- default
|  |  |  |- images
|  |  |  |  |- admintool.png
|  |  |  |  |- attach.png
|  |  |  |  |- ...
|  |  |  |
|  |  |  |- style.css
|  |  |  |- top.html
|  |
|  |- tiny_mce
|  |  |- plugins
|  |  |  |- beehive
|  |  |  |  |- images
|  |  |  |  |  |- code.gif
|  |  |  |  |  |- noemots.gif
|  |  |  |  |  |- ...
|  |  |  |  |-langs
|  |  |  |  |  |- en.js


As you can see the main distribution contains a docs and forum folder. The main
forum folder, which actually contains the Beehive Forum files, itself contains
several more folders with relevant files in them. If they are not extracted
in the right place subsequently uploading them to your server in this incorrect
order will result in your Beehive Forum working incorrectly or not at all.


1.2.2 Database setup
====================

To set up the database, use something like phpMyAdmin (get it from
https://sourceforge.net/projects/phpmyadmin/), or direct MySQL if you have the
"skillz", to create a database for your forum to live in. Take note of the
database name, as you will need it when you run the install script.

Beehive Forum would prefer its very own database, but if you can't provide that
it should work in an existing one.

1.2.3 MySQL permissions
=======================

To ensure full functionality as a minimum Beehive Forum requires the following
privileges granted on the user account it will use for interacting with your
MySQL database:

SELECT, CREATE, CREATE TEMPORARY TABLES, INSERT, ALTER,
UPDATE, INDEX, DELETE and DROP.

Additionally you can grant the FILE privilege globally for the user account to
aid in the creation of the dictionary. To do this will also require GRANT
permission on the database you are to install Beehive to. Without the FILE
privilege the installer for Beehive Forum will still function but it will
take a lot longer to complete.

1.2.4 Upload
============

You should now upload the forum onto your web space. We recommend that you simply
upload the "forum" folder directly, either into the root of your web space or 
into another folder of your choosing.


1.2.5 Installing the forum
==========================

Once everything's uploaded, you will need to run the forum's install script. This
is located in the /install subdirectory of your forum. To access it, you will need
to load the file in your browser from the web space you just uploaded to, e.g.:

http://www.mysite.com/forum/install.php

This will then walk you through the creation of your new forum. Note that you will
need your MySQL database's host address, username and password for this stage, as
well as the name of the database from step 1.2.2.  You should be able to get the 
information from your hosting provider if you're not running your own server.

1.2.6 Installing from CLI
=========================

Support for the CLI installer has been discontinued. Please use the web based
installer to set up your Beehive Forum.

1.2.7 Creating your config.inc.php
==================================

Please use the web based installer to set up your Beehive Forum. Creation of
your config.inc.php is handled automatically when installation is performed
this way.

1.2.8 First use
===============

If all went well, you should now have a working forum! After deleting the /install
subdirectory (as is described by the install script) you can then log in to your
newly created administrator account, using the details you specified at install.
This account gives you access to everything, so you can create folders, set user
permissions and so forth.


1.2.9 Adminning
===============

Now you're ready to create some folders, so click the admin link near the top of
the page, then choose folders from the menu on the left, and set them up.

You may also wish to change the access permissions of your forum. In the admin 
section you will find options for restricting access to your Beehive Forum. The
two main options are restricted, where each user account needs to be given
permission to access the forum and password protected, where your forum uses
a common password that can be given to users to allow them access.

The other links on the left let you set up profile sections and items, where
your members can provide information about themselves if they like, and do stuff
to users, like ban them, gag them or promote them. You can also edit the forum
'start' page, change the forum style, add forum word filters and so forth. It's 
all explained in there.


1.2.10 What to do if it doesn't work
====================================

Don't panic. Pop over to http://www.tehforum.co.uk/forum/ and ask us
for help, but remember, we don't get paid for this, so be nice.

It's helpful if you can tell us your setup when you've got a problem, such as
the type of server (e.g. Linux/Apache, Windows/Apache or Windows/IIS, etc) and
the version of PHP and MySQL that you're using. If your Beehive Forum threw up
an error message, paste that in as well.


1.2.11 Add your forum to our list (optional)
============================================

If you like, you can add your shiny new forum to our list of live copies by
going to http://beehiveforum.net/forums.php

It could be a bit of publicity for your site, and it helps us to be able to say
"Look, all these people are using it!", but if you don't want to, you don't have
to.


1.3 Customising your Beehive Forum
=================================

Beehive Forum has user-selectable styles. Basically these are like themes
(or skins for WinAmp users) for your forum. There are several supplied styles,
and it's easy to create your own.

You can edit the existing styles, but we recommend that you create your own.

To create a new style simply create a new folder in the styles folder, with the name
of the new style. For example, to add a style called "fish", you need a folder called
"fish" in the "styles" folder.

Then copy in the contents of one of the existing folders to base your new style on
(the "default" folder is probably a good start) - style.css, top.html and the images
folder with contents.

You can also create random styles by using the forum styles tool in the admin section
of the forum. Unfortunately this tool does not allow you to specify different multiple
colours to use, rather it rather cunningly chooses some for you that are mathematically
determined to be suitable based on your first choice.

Notes:

Due to the new multi-forum capabilities of Beehive Forum 0.5+, there are now two 
locations where style sheets/images etc. are held. For styles which you wish to be
globally available to all forums on your server, add/change the styles in the /styles
subdirectory. For forum-specific styles, you will need to add/change the styles in
the /forums/FORUM_WEBTAG/styles directory, where 'FORUM_WEBTAG' is the webtag of your
forum that you chose on forum-creation. See /forums/default as an example.

Styles created using the admin styles creator will be saved as forum-specific
styles. If you wish for a style you create through it to be global, you will need to
manually copy the style into the global /styles directory through your FTP program.

The files start_main.php, style.css and top.html can also be present in the 
/forums/FORUM_WEBTAG directory, which allows for per-forum start pages, default forum 
styles, and top frames.


1.3.1 Style sheet
=================

If you know how to do CSS, you can edit the style.css file in the
/styles/[stylename] folder to change colours, fonts and things like that.
We recommend taking a backup first, though, in case you make a mess of it.

As of BeehiveForum 0.8 you can also create per-file style sheets that allow you
to give different pages different designs. This would for example allow you to
give the thread list a background image but leave the other pages using the
same design.

To do this all you would need to do is create a .css file with the same name
as the PHP script you want it to affect, sans it's extension. i.e. for the thread
list you would create a style sheet named thread_list.css and place it in the
same folder as the main style.css. Beehive will automatically find and use this
style sheet in preference to the main style.css.

There is one caveat though of course (isn't there always?). When Beehive
encounters the per-file style sheet it will leave out the main style.css so any
classes you want displayed in all your forum styles must be defined in each
of your per-page .css files.

1.3.2 Images
============

Feel free to edit the images in the /styles/[stylename]/images folder too,
as long as the dimensions remain the same. Again, you might want to take backups.


1.3.3 The top frame
===================

The very top frame is yours to do with as you wish. In each style's folder you will
find a file called "top.html", which you can edit any way you like, put what you
want in there, little Flash movies with solar/lunar cycles or big headache
inducing adverts for stuff, it's entirely up to you.
Just keep it 60 pixels high or under.


1.3.4 Emoticons
===============

Beehive Forum uses CSS-styled emoticons. This allows the end-user to have great control,
being able to choose from options such as completely invisible, text-only, and the
range of graphic sets which can be installed. 

To create an emoticon pack first add a subdirectory (named whatever you like - for 
example's sake I'll choose 'mypack') in the /emoticons directory. In this directory 
create a file definitions.php. This file contains the textual pattern definitions 
of the emoticons. For example, to add a ':-)' emoticon, one would add the following 
line:

$emoticon[':-)'] = "smile";

Once you have finished adding your pattern definitions you need to create a file 
desc.txt (which contains one line describing your pack, e.g. "My Pack") and a
style.css file. To add your ':-)' emoticon you will need CSS code similar to this:

.e_smile {
        padding-left: 15px; // the width of the emoticon image
        height: 13px;       // the height of the image
        font-size: 13px;    // the height of the image again, for Mozilla
        background-image: url("./images/smile.gif");  // the image itself
        background-repeat: no-repeat;
}
.e_smile span {
        display: none;
}

Notice the class name 'e_smile' - this is the word you associated with the ':-)'
pattern in definitions.php ("smile") prefixed by 'e_'. Be careful not to use the 
same associated word for different emoticons (it's fine to use the same word for, 
for example, both ':)' and ':-)', however). Also note that every .e_NAME class must 
also have the .e_NAME span { ... } class.


1.3.5 GeSHi
===========

Beehive Forum uses several 'custom' HTML tags, including the <code> tag. This tag now 
accepts a 'language' attribute which will highlight your code, thanks to the open-source
software GeSHi 1.0.6 or later from http://qbnz.com/highlighter/.

To include GeSHi syntax highlighting with your Beehive Forum install simply download 
the latest version of GeSHi and upload it to a subdirectory 'geshi' in your main forum
folder. For example if your forum was at www.site.com/forum/ you would upload GeSHi to
www.site.com/forum/geshi/.

To change any GeSHi settings edit the file include/geshi.inc.php.

Note: GeSHi is not created by the Beehive Forum developers.

1.3.6 TinyMCE
=============

Beehive Forum has a simple HTML toolbar built in, but also allows the use of the 
open-source WYSIWYG TinyMCE version 3.1.0 or later by Moxiecode Systems. You can
downloaded TinyMCE from http://tinymce.moxiecode.com/

To install TinyMCE in to your Beehive Forum simply copy everything from the 
tinymce/jscripts/tiny_mce directory into a subdirectory named 'tiny_mce' in your
main forum folder.

There is a Beehive Forum plugin for TinyMCE which should have already been in your
forum's tiny_mce directory, under the subdirectory plugins/beehive. If this is not
the case copy the directory tiny_mce/plugins/beehive from a fresh download of
Beehive Forum to your forum.

Note: TinyMCE is not created by the Beehive Forum developers.

1.4 Upgrading from previous versions of Beehive Forum
====================================================

If you're reading this you're looking for instructions on upgrading your
Beehive Forum to the latest and greatest available version. Below you will find
instructions pertaining to each individual release. Please read them fully
before starting the upgrade process.

As with all software installations or upgrades it is highly recommended that
you perform a backup of your existing web space and database before upgrading
your Beehive Forum. Failure to do so could result in lost data. You have been
warned. Don't make us say we told you so.


1.4.1 Upgrading your Beehive Forum installation
==============================================

Beehive Forum's install script should be used to perform any upgrade from 0.4
or newer. Previously .sql scripts were provided but due to the nature of the
software these are no longer viable.


1.4.1.1 Make a back up of your database
=======================================

You REALLY SHOULD make a back up of your database before you perform the upgrade.
We can't stress how important this is. If you don't perform a backup and something
goes wrong you'll be up shit creek without a paddle and if things were to get even
worse you may find that you loose your boat as well.

The easiest way to perform a back up is by using telnet to connect into your server
and making a physical copy of the MySQL/Beehive Forum folder. You'll know when you've
found the right one when you come across loads of .MYI and .MYD files with the same
names as the Beehive Forum tables.

If you can do this then great, if not you might want to ask your hosting provider
if they can do it for you, at least temporarily while you do the upgrade. Then if
anything does go wrong you can ask them to restore the data.

If your hosting provider is less than cooperative about doing this then your next
best chance of performing a backup is by using phpMyAdmin and making use of it's
Export facility to save a copy of the database to your PC using your web browser. 
Be warned that doing it this way will result in a easily rather large file being
created on your HDD so make sure you have adequate disc space in order to do
this. It will also be harder to restore the backup this way.


1.4.1.2 Back up your files
==========================

The easiest way to back up your Beehive Forum files is to take a copy of the forum
directory and it's contents. Restoring this back up incase of upgrade failure is
then simply a case of uploading the files and overwriting the changes.


1.4.1.3 Upload new forum files
==============================

This step is similar to 1.2.3, though you may wish to upload to a temporary
directory (e.g. if your forum is currently installed in a subdirectory 'forum',
you may wish to upload the new files to a subdirectory 'forumtemp' so that 
you can make any neccesary changes before replacing the old files with the
newer ones.


1.4.1.4 Run the upgrade script
==============================

Once you've backed up your database/files and uploaded the new files, you will
need to run the upgrade script, located at install.php in your forum
directory:

http://www.mysite.com/forumtemp/install.php

Make sure you select the correct 'Upgrade' proceedure from the installation
method drop-down list, and then follow the instructions.


1.4.2 Skipping a version during upgrade
=======================================

Skipping versions during upgrade is unsupported by the Beehive Forum development
team. To upgrade from 0.5 to 0.7 (for example) you should first download and
upgrade to 0.6 and then upgrade separatly to 0.7. We appreciate that this is
long winded and highly inconvienient but it is the only reliable method of
upgrading and you should really only have to do it once.


1.4.3 Upgrading from 0.5PR1 to 0.5
==================================

0.5PR1 is no longer supported by the development team. If you are still running
this version of Beehive Forum please upgrade to 0.5 or a later release.


1.4.4 Upgrading from 0.3 to 0.4
===============================

If you are already using 0.3 of Beehive Forum, you will need to update your
database. You should first backup by following the steps in 1.4.1.


1.4.4.1 Update the database
===========================

Simply run the /docs/update-03-to-04.sql script against the database using phpMyAdmin
or MySQL directly.


1.4,4,2 Update the config file
==============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.4 download
and set the relevant variables again.


1.4.5 Upgrading from 0.2 to 0.3
===============================

Follow the procedures as detailed in steps 1.4.4 but when upgrading the database
as in step 1.4.4.1 use the /docs/update-02-to-03.sql script instead of update-03-to-04.sql.


1.4.6 Upgrading from 0.1 / 0.1.1 to 0.2
=======================================

Follow the procedure as detailed in steps 1.4.4 but when upgrading the database
as in step 1.4.4.1 use the /docs/update-01-to-02.sql script instead of update-03-to-04.sql.


1.4.7 Upgrading from 0.1 or 0.2 to 0.4 and newer
================================================

No direct route exists for 0.1 or 0.2 to be upgraded to versions of Beehive newer than 0.3.
To upgrade either of these versions to the latest release you will first need to run the
relevant .sql script files in order and then proceed to use the built in installer script.

For example if you are using Beehive Forum 0.1 you will need to run:

upgrade-01-to-02.sql followed by..
upgrade-02-to-03.sql followed by..
upgrade-03-to-04.sql.

This will bring the database up to 0.4 compatibility, and from there you can use the 
upgrade script built into the newer releases of Beehive to bring you bang up to date.


1.5 Beehive Forum Error Reporter
================================

Beehive Forum includes a comprehensive error reporter which can be used to help
diagnose faults and find bugs in the software. This error reporter is indispensable
in helping to develop the project and should be used at all times when reporting
problems you have with the software.

In older releases the error reporter was enabled by default and set to output error
messages to all users but with the release of Beehive Forum 0.8 it was decided the
error reporter should at least be partially silenced and the error reports instead
sent to the system error log (Apache error_log or similar). This was primarily done
to reduce the security risk associated with potentially sensitive data being
released to end users.

Because not everyone has access to their server's error log (shared hosting, etc.) 
we have also implement error reporting by email. With this option you can continue to
receive detailed error messages from your Beehive Forum installation with none of the 
associated risks. It also means you can continue to report bugs back to the development
team and get help diagnosing faults.

Due to the nature of the Beehive Forum the error reporter can only be enabled automatically 
if you're performing a new installation. To do this you simply tick the relevant box under
Advanced Options in the installer. The changes will be automatically made to your 
config.inc.php for you and you are then good to go.

To enable the error reporter for upgrades please follow the instructions below.


1.5.1 Enabling Error Reporter after upgrading
=============================================

This process applies to Beehive Forum 0.8 and newer only. Please note that older versions
of the software already have the error reporter enabled by default.

To enable error reporting after upgrading you will need to manually edit the config.inc.php
file generated during the installation process of your Beehive Forum. You will find this file
within the include folder on your web space. Please do not use the config.inc.php file from
the distribution archive. This is a template file used by the installer and will not work
without further changes.

To begin, download the config.inc.php using FTP and save it somewhere on your PC. As good place
as any is your desktop. Once you have it downloaded make a copy of the file just in case 
something goes wrong and then open it using a text editor. Windows users are recommended to
use Notepad. Please do not use Microsoft Wordpad or Microsoft Word, or any other word processor
for that matter, unless you know what you're doing, as these may cause problems with the format
of the file. *nux users, we're sure you'll do just fine with vi or vim or even gedit.

To actually enable the error handler you need to change two variables. The first variable to be
changed is named $error_report_verbose and should be changed from false to true. Second is the
$error_report_email_addr_to variable. This is where you should enter your email address. Once
changed the variables should look a bit like this:


    $error_report_verbose = true;
    $error_report_email_addr_to = 'youremail@address.com';


Once you've made the changes save the file. If given the choice save the file as UTF-8 encoded
with PC / Windows line endings. This will make the file more portable and easier to edit later.

Finally upload the modified config.inc.php making sure to replace the existing copy and check
that your Beehive Forum continues to function. If it does, sit back and wait to see if you
receive any error reports. If you don't it's quite possible you're not actually getting any
errors which is a good thing, but if you suspect you should be check that the email address
is correct.

If you can't get the error reporting to function or if you break your Beehive Forum you can
simply restore the copy of config.inc.php you made earlier or try again. If you continue to
have problems please seek assistance at Teh Forum, a link for which you find below in the
Support section.


2 Known Issues
==============

Please see release.txt for issues pertaining to each individual release.


3 Support
=========


3.1 Requests / Bug reporting
============================

All this can be done through the Project page provided by SourceForge.
Simply browse to http://sourceforge.net/projects/Beehive Forum and submit
requests or bug reports there.

Alternatively you can visit http://www.tehforum.co.uk/forum/ where you'll
find most of the developers of Beehive Forum hanging out. Feel free to post
any questions or queries you have and we'll do our best to answer them.


3.2 General questions and help
==============================

As above, you can try dropping in to http://www.tehforum.co.uk/forum/, 
where you can ask for help or check on the progress of the next version and
see and test previews of the new features. If you need help don't think twice
about posting, although please keep Beehive-related enquires to the 'Beehive 
Development' folder.

We've also added a wiki to help us document Beehive. Check it out here:

http://www.beehiveforum.net/wiki/

Want to contribute to the Wiki? To do so you will need to register a user
account on the test forum. Once you have your account you can login using
the same logon and password and start contributing.


3.3 Beehive Forums in foreign languages
======================================

Since the release of Beehive Forum 0.4 multiple languages have been supported,
but because we're all very busy doing other things the number of languages
that actually ship with Beehive Forum are few and far between. We hope to rectify
this over time, but in order to do so we require volunteers. If you would
like to help translate Beehive Forum into your native tongue please see below.


3.3.1 Translating Beehive Forums into my native language
=======================================================

Unfortunately the Beehive Forum coding team consists primarily of born and bred
English men who have enough trouble speaking our own tongue as it is. Because
of this, we're on the look out for people to start translating Beehive Forum for
us. If you feel you have the necessary skills to do this (no babelfish / direct
from dictionary translations please) feel free to drop us a note. With any
luck your language file may end up being distributed with future versions of
Beehive Forums and you may even get to see your name in print, or at the very
least bundled here amongst the other credits.


3.3.2 Completed Translations
============================

Current complete translations are as follows:

English British
French Canadian
German
X-Hacker

3.3.3 Incomplete / Partial Translations
=======================================

Current incomplete translations also available include:

English (US)

These translations can be obtained from the Beehive Forum Project CVS Repository.
For instructions on accessing the CVS Reporistory please see:

http://sourceforge.net/cvs/?group_id=50772


4 Credits
=========


4.1 Coding
==========

Matt Beale, Andy Black, Chris Hodcroft, Mark Rendle, Rowan Hill, 
Andrew Holgate, Peter Kelly, Mike Franklin, Ben Sekulowicz

4.2 Website
===========

Peter Boughton, Rowan Hill, Matt Beale, Mike Franklin and all you
lovely Wiki contributors.


4.3 Design/CSS
==============

Kevin Yip, Mike Franklin, Simon Roberts, Matt Beale.


4.4 Graphics
============

Nigel Moore, Kevin Yip, Andrew Holgate, Mike Quigley, Matt Beale,
Andy Black.


4.5 Translations
================

French Canadian - Joanne McNair.
German          - Armin Damm.
X-Hacker        - Matt Beale.


4.6 Official Beehive Forum Pimp
==============================

Mike Quigley


4.7 Bug finders extraordinaire
==============================

Ken Kauffman, Speakez.


4.6 Other Contributions
=======================

Frnht451, Michael @ Hermitscave


4.7 Project Lead
================

Matt Beale


4.7 Special Thanks
==================

- The Teh Forumers for testing, moral support, saying nice things and just generally
  being teh cool.
  
- Michael from Hermitscave for taking the time to find all those nasty exploits.
  
- JimL for beating Mike in our being obsessed with Beehive Forum competition.

- SourceForge (http://sourceforge.net) for providing top-notch facilities to us
  (and to thousands of other projects) at absolutely no cost.


4.7.1 Matt would like to thank:
===============================

- Mike Franklin, Pete Kelly, Jon Cooper and Yvonne for just being who you are.


FIN
