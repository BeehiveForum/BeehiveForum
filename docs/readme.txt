Beehive Forum Readme

http://www.beehiveforum.net/

Version 0.5 / 10th December 2004

A list of changes since previous Beehive versions can be found in release.txt.

0. Contents
===========

1.    Installation
  1.1    Requirements
  1.2    Instructions
    1.2.1    Archive Extraction
    1.2.2    Database setup
    1.2.3    Upload
    1.2.4    Installing the forum
    1.2.5    First use
    1.2.6    Adminning
    1.2.7    What to do if it doesn't work
    1.2.8    Add your forum to our list
  1.3    Customising Beehive
    1.3.1    Stylesheet
    1.3.2    Images
    1.3.3    The top frame
    1.3.4    Emoticons
    1.3.5    GeSHi
    1.3.6    TinyMCE
  1.4    Upgrading 0.4 to 0.5
    1.4.1    Make a back up of your database
    1.4.2    Back up your files
    1.4.3    Upload new forum files
    1.4.4    Run the upgrade script
  1.5    Upgrading 0.3 to 0.4.
    1.5.1    Update the database
    1.5.2    Update the config file
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

  - PHP 4.1.0 or above (tested on 4.1.x, 4.2.x, 4.3.x and 5.0.0) and
  - MySQL 3.5 or above (must support compound AUTO_INCREMENT).

As a minimum Beehive requires: SELECT, CREATE, CREATE TEMPORARY TABLES,
GRANT, INSERT, ALTER, UPDATE, INDEX, DELETE and DROP privilleges
on the database / tables it creates.

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
|  |  |
|  |  |- geshi
|  |  |  |- contrib
|  |  |  |  |- cssgen.php
|  |  |  |  |- example.php
|  |  |  |
|  |  |  |- docs
|  |  |  |  |- BUGS
|  |  |  |  |- ...
|  |  |  |
|  |  |  |- geshi
|  |  |  |  |- actionscript.php
|  |  |  |  |- ...
|  |  |  |
|  |  |  |- geshi.php
|  |  | 
|  |  |  |- emoticons
|  |  |  |  |- boughton
|  |  |  |  |  |- images
|  |  |  |  |  |  |- angry.png
|  |  |  |  |  |  |- ...
|  |  |  |  |  |
|  |  |  |  |  |- definitions.php
|  |  |  |  |  |- desc.txt
|  |  |  |  |  |- style.css
|  |  |  |  |
|  |  |  |  |- default
|  |  |  |  |  |- images
|  |  |  |  |  |  |- alien.png
|  |  |  |  |  |  |- ...
|  |  |  |  |  |
|  |  |  |  |  |- definitions.php
|  |  |  |  |  |- desc.txt
|  |  |  |  |  |- style.css
|  |  |  |  |
|  |  |  |  |- none
|  |  |  |  |  |- desc.txt
|  |  |  |  |  |- style.css
|  |  |  |  |
|  |  |  |  |- text
|  |  |  |  |  |- desc.txt
|  |  |  |  |
|  |  |  |  |- README
|  |  |
|  |  |- forums
|  |  |  |- default
|  |  |  |  |- styles
|  |  |  |  |  |- put_per_forum_custom_styles_in_here
|  |  |  |  |
|  |  |  |  |- start_main.php
|  |  |  |  |- ...
|  |  |  
|  |  |- images
|  |  |  |- admin_locked.png
|  |  |  |- admintool.png
|  |  |  |- ...
|  |  |
|  |  |- include
|  |  |  |- admin.inc.php
|  |  |  |- attachments.inc.php
|  |  |  |- ...
|  |  |
|  |  |- install
|  |  |  |- config.inc.php
|  |  |  |- new-install.php
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
|  |  |
|  |  |- tiny_mce
|  |  |  |- langs
|  |  |  |  |- ar.js
|  |  |  |  |- ...
|  |  |  |
|  |  |  |- plugins
|  |  |  |  |- beehive
|  |  |  |  |- searchreplace
|  |  |  |  |- table
|  |  |  |  |- readme.txt
|  |  |  |
|  |  |  |- themes
|  |  |  |  |- advanced
|  |  |  |
|  |  |  |- blank.htm
|  |  |  |- ...


As you can see the main distribution contains a docs and forum folder. The main
forum folder, which actually contains Beehive, itself contains several more
folders with relevant files in them. If they are not extracted in the right place
subsequently uploading them to your server in this incorrect order will result in
Beehive working incorrectly or not at all.


1.2.2 Database setup
====================

To set up the database, use something like phpMyAdmin (get it from
https://sourceforge.net/projects/phpmyadmin/), or direct MySQL if you have the
"skillz", to create a database for your forum to live in. Take note of the
database name, as you will need it when you run the install script.

(Beehive would prefer its very own database, but if you can't provide that, it
should work in an existing one.)


1.2.3 Upload
============

You should now upload the forum onto your web space. We recommend that you simply
upload the "forum" folder directly, either into the root of your web space or 
into another folder of your choosing.


1.2.4 Installing the forum
===========================

Once everything's uploaded, you will need to run the forum's install script. This
is located in the /install subdirectory of your forum. To access it, you will need
to load the file in your browser from the web space you just uploaded to, e.g.:

http://www.mysite.com/forum/install.php

This will then walk you through the creation of your new forum. Note that you will
need your MySQL database's host address, username and password for this stage, as
well as the name of the database from step 1.2.2.  You should be able to get the 
information from your hosting provider if you're not running your own server.


1.2.5 First use
===============

If all went well, you should now have a working forum! After deleting the /install
subdirectory (as is described by the install script) you can then log in to your
newly created administrator account, using the details you specified at install.
This account gives you access to everything, so you can create folders, set user
permissions and so forth.


1.2.6 Adminning
===============

Now you're ready to create some folders, so click the admin link near the top of
the page, then choose folders from the menu on the left, and set them up.

You may also wish to change the access permissions of your forum. In the admin 
section, under 'Manage Forums' you can set your forum access to 'Restricted' (so
that each user account need be given permission) or 'Passworded' (so that each
user needs to know a password you specify to gain entry).

The other links on the left let you set up profile sections and items, where
your members can provide information about themselves if they like, and do stuff
to users, like ban them, gag them or promote them. You can also edit the forum
'start' page, change the forum style, add forum word filters and so forth. It's 
all explained in there.


1.2.7 What to do if it doesn't work
===================================

Don't panic. Pop over to http://www.tehforum.net/forum/ and ask us
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
this space for a fully fledged style editor.

Note: Due to the new multi-forum capabilities of Beehive 0.5+, there are now two 
locations where stylesheets/images etc. are held. For styles which you wish to be
globally available to all forums on your server, add/change the styles in the /styles
subdirectory. For forum-specific styles, you will need to add/change the styles in
the /forums/FORUM_WEBTAG/styles directory, where 'FORUM_WEBTAG' is the webtag of your
forum that you chose on forum-creation. See /forums/default as an example.

Note: Styles created using the admin styles creator will be saved as forum-specific
styles. If you wish for a style you create through it to be global, you will need to
manually copy the style into the global /styles directory through your FTP program.

Note: start_main.php, style.css and top.html can also be present in the 
/forums/FORUM_WEBTAG directory, which allows for per-forum start pages, default forum 
styles, and top frames.


1.3.1 Stylesheet
================

If you know how to do CSS, you can edit the style.css file in the
/styles/[stylename] folder to change colours, fonts and things like that.
We recommend taking a backup first, though, in case you make a mess of it.


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

Beehive uses CSS-styled emoticons. This allows the end-user to have great control,
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

Beehive uses several 'custom' HTML tags, including the <code> tag. This tag now 
accepts a 'language' attribute (<code language="...">) which will highlight your 
code, thanks to the open-source software 'GeSHi' (http://qbnz.com/highlighter/). 
To include GeSHi syntax highlighting with your Beehive install simply download 
the latest version of GeSHi (tested with v1.0.6) and upload it to a subdirectory 
'geshi' in your main forum folder (if your forum was at www.site.com/forum/, 
upload to www.site.com/forum/geshi/).

Note: GeSHi is not created by the Beehive developers.


1.3.6 TinyMCE
=============

Beehive has a simple HTML toolbar built in, but also allows the use of the open-
source WYSIWYG TinyMCE toolbar (http://tinymce.moxiecode.com/) by Moxiecode Systems. 
To include TinyMCE in your Beehive install download the latest version (tested with 
v1.43). Within the compressed source there should be a directory:
  tinymce/jscripts/tiny_mce/
Simply copy everything from that tiny_mce directory into a subdirectory 'tiny_mce' in
your main forum folder (if your forum was at www.site.com/forum/, upload it to 
www.site.com/forum/tiny_mce/). 

There is a Beehive plugin for TinyMCE which should have already been in your forum's 
tiny_mce directory, under the subdirectory plugins/beehive. If this is not the case 
copy the directory tiny_mce/plugins/beehive from a fresh download of Beehive to your 
forum.

Note: TinyMCE is not created by the Beehive developers.


1.4 Upgrading from 0.4 to 0.5
=============================

0.5's install script will upgrade your 0.4 database, but it is HIGHLY recommended
that you perform a database and file backup before you attempt this.


1.4.1 Make a back up of your database
======================================

You REALLY SHOULD make a back up of your database before you perform the upgrade. We 
can't stress how important this is. If you don't perform a backup and something
goes wrong don't make us say we told you so.

The easiest way to perform a back up is by telnetting into your server and making
a physical copy of the mysql/beehiveforum folder. You'll know when you've found
the right one when you come across loads of .MYI and .MYD files with the same
names as the BeehiveForum tables.

If you can do this then great, if not you might want to ask your hosting provider
if they can do it for you, at least temporarily while you do the upgrade. Then if
anything does go wrong you can ask them to restore the data.

If your hosting provider is less than cooperative about doing this then your next
best chance of performing a backup is by using phpMyAdmin and making use of it's
Export facility to save a copy of the database to your HD using your web browser. 
Be warned that doing it this way will result in a easily rather large file being
created on your HD so make sure you have adequate disc space in order to do this.
It will also be harder to restore the backup this way.


1.4.2 Back up your files
========================

A list of files/directories you will potentially need to backup is as follows:

|- /attachments
|- /styles
|- start_main.php
|- top.html


1.4.3 Upload new forum files
============================

This step is similar to 1.2.3, though you may wish to upload to a temporary
directory (e.g. if your forum is currently installed in a subdirectory 'forum',
you may wish to upload the new files to a subdirectory 'forumtemp'. If uploading
to a seperate directory, remember to also upload the files you backed-up in 1.4.2.


1.4.4 Run the upgrade script
============================

Once you've backed up your database/files and uploaded the new files, you will
need to run the upgrade script, located at install.php in your forum
directory:

http://www.mysite.com/forumtemp/install.php

Make sure you select 'Upgrade' from the installation method drop-down list, and
then follow the instructions.

1.5 Upgrading from 0.5PR1 to 0.5
================================

If you are already running 0.5PR1 of Beehive Forum you can upgrade to 0.5 by
following the instructions outlined in section 1.4.1 to 1.4.3. Once you have
completed these steps run the upgrade script as instructed in step 1.4.4
but instead of choosing to upgrade from 0.4 choose to upgrade from 0.5PR1.

That should be all that is needed. If you have any problems with this please
post on Teh Forum (http://www.tehforum.net/forum/) and we'll try our best to
help you get sorted.


1.5 Upgrading from 0.3 to 0.4
=============================

If you are already using 0.3 of Beehive Forum, you will need to update your
database. You should first backup by following the steps in 1.4.1.


1.5.1 Update the database
=========================

Simply run the /docs/update-03-to-04.sql script against the database using phpMyAdmin or
MySQL directly.


1.5.2 Update the config file
============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.4 download
and set the relevant variables again.


1.6 Upgrading from 0.2 to 0.3
=============================

Follow the same procedure as detailed above, but you must run /docs/upgrade-02-to-03.sql
beforehand.


1.7 Upgrading from 0.1 / 0.1.1 to 0.2
=====================================

Follow the same procedure as detailed above, but you must run /docs/upgrade-01-to-02.sql
beforehand


1.8 Upgrading from 0.1 or 0.2 to 0.4
====================================

No direct route exists for 0.1 or 0.2 to be upgraded to 0.4. To upgrade either of these
versions to 0.4 you will need to run the relevant schema files in order. 

For example if you are using Beehive 0.1 you will need to run:

upgrade-01-to-02.sql followed by..
upgrade-02-to-03.sql followed by..
upgrade-03-to-04.sql.

This will bring the database up to 0.4, and from there you can use 0.5's upgrade script.


2 Known Issues
==============

- Folders created under 0.3 or below which contained quotes will now
  display incorrectly in 0.4. You can fix this by visiting the admin
  folders option and fixing the folder names. This was due to a bug
  in previous versions which has now been fixed.

- Content created prior to the installation of 0.5 will be incorrectly
  escaped (all ' and " characters will appear as \' and \" respectively).
  This is due to a major bug in versions prior to 0.5 which meant
  content inserted into the database was double-escaped.


3 Support
=========


3.1 Requests / Bug reporting
============================

All this can be done through the Project page provided by SourceForge.
Simply browse to http://sourceforge.net/projects/beehiveforum and submit
requests or bug reports there.

Alternatively you can visit http://www.tehforum.net/forum/ where you'll
find most of the developers of Beehive hanging out. Feel free to post
any questions or queries you have and we'll do our best to answer them.


3.2 General questions and help
==============================

As above, you can try dropping in to http://www.tehforum.net/forum/, 
where you can ask for help or check on the progress of the next version and
see and test previews of the new features. If you need help don't think twice
about posting, although please keep Beehive-related enquires to the 'Beehive 
Development' folder. It should be noted that we prefer using this system
over the SF bug reporting tool.

We've also added a wiki to help us document Beehive. Check it out here:

http://www.beehiveforum.net/wiki/


3.3 BeehiveForums in foreign languages
======================================

As of 0.4 BeehiveForums supports multiple languages, but because we're all very
busy doing other things the number of languages that ship with Beehive are few
and far between, i.e. English, English and nothing but English. There's also an
incomplete French translation, as well as the 'comedy' English X-Gangsta and
X-Hacker languages available from CVS should you wish to obtain them.


3.3.1 Translating BeehiveForums into my native language
=======================================================

Unfortunately the BeehiveForum coding team consists primarily of born and bred
English men who have enough trouble speaking our own tongue as it is. Because
of this, we're on the look out for people to start translating Beehive for us.
If you feel you have the necessary skills to do this (no babelfish / direct
from dictionary translations please) feel free to drop us a note. With any
luck your language file may end up being distributed with future versions of
Beehive Forums and you may even get to see your name in print, or at the very
least bundled here amongst the other credits.


3.3.2 Current Available Languages
=================================

Current available languages are as follows:

English (UK)
X-Hacker

Also avaulable, but incomplete (includes some/many English phrases still):

French
X-Gangsta


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

Mike Franklin, Simon Roberts, Kevin Yip


4.4 Graphics
============

Nigel Moore, Kevin Yip, Andrew Holgate, Mike Quigley


4.5 Translations
================

French   - Mark Krywonos
Gangsta  - Jay Graham.
X-Hacker - Matt Beale.


4.6 Other Contributions
=======================

Mike Quigley, Frnht451, Michael @ Hermitscave, Peter Boughton, Lots of other people


4.7 Project Lead
================

Matt Beale


4.7 Special Thanks
==================

- The Teh Forumers for testing, moral support, saying nice things and just generally
  being teh cool.
  
- Michael from Hermitscave for taking the time to find all those nasty exploits.
  
- Mike Quigley for Teh Backup Forum, Breaking lots of things and pimping Beehive without fail.

- JimL for beating Mike in our being obcessed with Beehive competition.

- SourceForge (http://sourceforge.net) for providing top-notch facilities to us
  (and to thousands of other projects) at absolutely no cost.


4.7.1 Matt would like to thank:
===============================

- Mike Franklin, Pete Kelly, Jon Cooper and Yvonne for just being who you are.


FIN
