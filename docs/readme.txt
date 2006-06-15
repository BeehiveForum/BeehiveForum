Beehive Forum Readme

http://www.beehiveforum.net/

Version 0.6.3 / TBA

A list of changes since previous BeehiveForum versions can be found
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
  1.3    Customising your BeehiveForum
    1.3.1    Style sheet
    1.3.2    Images
    1.3.3    The top frame
    1.3.4    Emoticons
    1.3.5    GeSHi
    1.3.6    TinyMCE
  1.4    Upgrading from previous versions of BeehiveForum
    1.4.1    Upgrading your Beehiveforum installation
      1.4.1.1    Make a back up of your database
      1.4.1.2    Back up your files
      1.4.1.3    Upload new forum files
      1.4.1.4    Run the upgrade script
    1.4.2    Upgrading 0.5PR1 to 0.5.
    1.4.3    Upgrading 0.3 to 0.4.
      1.4.3.1    Update the database
      1.4.3.2    Update the config file
    1.4.4   Upgrading from 0.2 to 0.3
    1.4.5   Upgrading from 0.1 / 0.1.1 to 0.2
    1.4.6   Upgrading from 0.1 or 0.2 to 0.4

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

  - PHP 4.2.0 or above
  - MySQL 3.5 or above (must support compound AUTO_INCREMENT).

1.1.1 Requirements Notes
========================

- The BeehiveForum team can't stress enough how much of an improvement
  MySQL 4.1 is compared to older versions. You may continue to use an
  older version of MySQL (so long as they support compound AUTO_INCREMENT)
  but performance will improve greatly through the use of MySQL 4.1.

- As a minimum BeehiveForum requires the following privileges on the
  database and tables it runs from:

  SELECT, CREATE, CREATE TEMPORARY TABLES, 
  GRANT, INSERT, ALTER, UPDATE,
  INDEX, DELETE and DROP.

- You may optionally grant the FILE permission to speed up the creation
  of the dictionary during installation but BeehiveForum doesn't require
  it to remain enabled.

1.2 Instructions
================

1.2.1 Archive Extraction
========================

How you extract the contents of the BeehiveForum distribution archive is very
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
forum folder, which actually contains BeehiveForum, itself contains several more
folders with relevant files in them. If they are not extracted in the right place
subsequently uploading them to your server in this incorrect order will result in
your BeehiveForum working incorrectly or not at all.


1.2.2 Database setup
====================

To set up the database, use something like phpMyAdmin (get it from
https://sourceforge.net/projects/phpmyadmin/), or direct MySQL if you have the
"skillz", to create a database for your forum to live in. Take note of the
database name, as you will need it when you run the install script.

BeehiveForum would prefer its very own database, but if you can't provide that
it should work in an existing one.

1.2.3 MySQL permissions
=======================

As a minimum BeehiveForum requires the following privileges granted on the user
account it will use for interacting with your database:

SELECT, CREATE, CREATE TEMPORARY TABLES, GRANT, INSERT, ALTER, UPDATE,
INDEX, DELETE and DROP.

Additionally you can grant the FILE privilege globally for the user account to
aid in the creation of the dictionary. Without the FILE privilege the installer
for BeehiveForum will still function but it will take a lot longer to do so.

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

If PHP CLI mode is available to you, you can also run the BeehiveForum installation
from a command line over SSH or a telnet connection. If you don't know what SSH or
telnet is then you'd do best sticking to using the web based installer.

First things first it is important to note that when running the BeehiveForum 
installer from CLI that no config.inc.php will be created. Rather you must create
your own and upload it to your server. For instructions on creating a config.inc.php
please see next section.

The full command needed for running the installation from CLI can vary depending on
the server configuration and PHP version. In newer versions of PHP the name of the 
PHP CLI executable has changed to be 'php-cli', but with older versions it is more
often simply named 'php'. When executing the commands below you should replace the
php-cli part with the correct name for your PHP CLI executable.

For new installs using the command line installer you should execute the following:

>php-cli new-install.php

When performing an upgrade of your BeehiveForum software you should supplement
new-install.php with the name of the upgrade script you require. For example if
you are upgrading from 0.5 to 0.6.2 you should execute:

>php-cli upgrade-05-to-062.php

You can go ahead and do that right now. Okay, unless you've already read ahead
you will probably have noticed that not a lot actually happened when you ran either
of the above commands, but with any luck you should have on your screen the command
line installer help text which will tell you what went wrong, which should look
something like this:

    BeehiveForum 0.6.2 CLI installer
    Copyright Project BeehiveForum 2002 - 2005
    Usage: php-cli new-install.php [OPTIONS]
      --help      Display this help and exit
      -h          MySQL hostname to connect to
      -u          Username to use when connecting to MySQL server
      -p          Password to use when connecting to MySQL server
      -D          Database to use\n
      -w          Webtag to use for forum
      -U          Admin user account to create [Default: ADMIN]
      -P          Password to use for Admin account [Default: honey]
      -E          Email address to use [Default: admin@abeehiveforum.net]
    Depending on the version of Beehive you're upgrading to you may not
    need to specify all of these options. Any that are unneeded by the script
    you are using will be ignored.

As you can no doubt tell by reading the help text above you need to specify some
command line options to get the installer or upgrader to work correctly. The most
important are those which conern the database connection and are required by the
script before it will actually work. It should be noted that when typing the
options there should be no white space between the option name and the value you
give it otherwise problems will occur, for example:

>php new-install.php -hlocalhost -uusername -ppassword -Ddatabase -wDEFAULT

In this example we are running the new-install script and asking it to connect to
the MySQL server located on localhost using the username 'username' and password 
'password' and that we wish to use the 'database' database and the webtag for the
forum we wish to create is called 'DEFAULT'.

The webtag option is only required for new installations. During upgrades you should 
ommit this option, but it will do no harm if you do not. In addition to the database
details you can optionally provide user credentials for the admin account. If you
choose not to provide these credentials then the installer will create a default
'Admin' account with the password set as honey.

Unless you received any other error messages your installation / upgrade via CLI
will now be running and once complete you will be back at the shell prompt. Once it
has completed successfully you should go to the next step.


1.2.7 Creating your config.inc.php
==================================

This step is only required if you chose to run the installer from the command line.
If you used the web based installation wizard your config.inc.php will have been
generated for you.

Look in the install folder of the BeehiveForum distribution and open the file 
called "config.inc.php". This is the template used by the BeehiveForum webbased
installer when it creates the config.inc.php for you. Unfortunately because the
command line installer is unable to generate this file for you, you must edit it
manually before using your BeehiveForum. As with the installer the most important
settings are those which deal with the connection to your MySQL database which
appear as follows:

$db_server   = "{db_server}";    // the address of your MySQL server
$db_username = "{db_username}";  // your MySQL username
$db_password = "{db_password}";  // your MySQL password
$db_database = "{db_database}";  // the name of your MySQL database

You will need to change the values in quotes to the correct details for your MySQL
setup. This will be the same information you used when running the command line
installer.

Once done you should save and upload the file as /forum/include/config.inc.php.

In addition to the database connection settings you will notice that the
config.inc.php contains some other settings which you can change. For information
on these please refer to the config.inc.php template file itself.

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
section you will find options for restricting access to your BeehiveForum. The
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

Don't panic. Pop over to http://www.tehforum.net/forum/ and ask us
for help, but remember, we don't get paid for this, so be nice.

It's helpful if you can tell us your setup when you've got a problem, such as
the type of server (e.g. Linux/Apache, Windows/Apache or Windows/IIS, etc) and
the version of PHP and MySQL that you're using. If your BeehiveForum threw up
an error message, paste that in as well.


1.2.11 Add your forum to our list (optional)
============================================

If you like, you can add your shiny new forum to our list of live copies by
going to http://beehiveforum.net/forums.php

It could be a bit of publicity for your site, and it helps us to be able to say
"Look, all these people are using it!", but if you don't want to, you don't have
to.


1.3 Customising your BeehiveForum
=================================

BeehiveForum has user-selectable styles. Basically these are like themes
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

Note: Due to the new multi-forum capabilities of BeehiveForum 0.5+, there are now two 
locations where style sheets/images etc. are held. For styles which you wish to be
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


1.3.1 Style sheet
=================

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

BeehiveForum uses CSS-styled emoticons. This allows the end-user to have great control,
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

BeehiveForum uses several 'custom' HTML tags, including the <code> tag. This tag now 
accepts a 'language' attribute (<code language="...">) which will highlight your 
code, thanks to the open-source software 'GeSHi' (http://qbnz.com/highlighter/). 
To include GeSHi syntax highlighting with your BeehiveForum install simply download 
the latest version of GeSHi (tested with v1.0.6) and upload it to a subdirectory 
'geshi' in your main forum folder (if your forum was at www.site.com/forum/, 
upload to www.site.com/forum/geshi/).

To change any GeSHi settings edit the file include/geshi.inc.php.

Note: GeSHi is not created by the BeehiveForum developers.


1.3.6 TinyMCE
=============

BeehiveForum has a simple HTML toolbar built in, but also allows the use of the open-
source WYSIWYG TinyMCE toolbar (http://tinymce.moxiecode.com/) by Moxiecode Systems. 
To include TinyMCE in your BeehiveForum install download the latest version (tested with 
v1.43). Within the compressed source there should be a directory:
  tinymce/jscripts/tiny_mce/
Simply copy everything from that tiny_mce directory into a subdirectory 'tiny_mce' in
your main forum folder (if your forum was at www.site.com/forum/, upload it to 
www.site.com/forum/tiny_mce/). 

There is a BeehiveForum plugin for TinyMCE which should have already been in your forum's 
tiny_mce directory, under the subdirectory plugins/beehive. If this is not the case 
copy the directory tiny_mce/plugins/beehive from a fresh download of BeehiveForum to your 
forum.

To change any TinyMCE settings edit the file include/htmltools.inc.php, looking for 
the function TinyMCE().

Note: TinyMCE is not created by the BeehiveForum developers.

1.4 Upgrading from previous versions of BeehiveForum
====================================================

If you're reading this you're looking for instructions on upgrading your
BeehiveForum to the latest and greatest available version. Below you will find
instructions pertaining to each individual release. Please read them fully
before starting the upgrade process.

As with all software installations or upgrades it is highly recommended that
you perform a backup of your existing web space and database before upgrading
your BeehiveForum. Failure to do so could result in lost data. You have been
warned. Don't make us say we told you if things go wrong and you haven't
backed up.


1.4.1 Upgrading your Beehiveforum installation
==============================================

BeehiveForum's install script should be used to perform any upgrade from 0.4
or higher. There are two ways you can use the upgrade scripts. From a web
browser or via the command line over telnet / SSH. Using a web browser is the
preferred method.


1.4.1.1 Make a back up of your database
=======================================

You REALLY SHOULD make a back up of your database before you perform the upgrade.
We can't stress how important this is. If you don't perform a backup and something
goes wrong you'll be up creek without a paddle and if things go even more
wrong you may find that you loose your boat as well.

The easiest way to perform a back up is by using telnet to connect into your server
and making a physical copy of the MySQL/BeehiveForum folder. You'll know when you've
found the right one when you come across loads of .MYI and .MYD files with the same
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


1.4.1.2 Back up your files
==========================

The easiest way to back up your BeehiveForum files is to take a copy of the forum
directory and it's contents. Restoring this back up incase of upgrade failure is
then simply a case of uploading the files again just as you would when performing
a new install.


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

Make sure you select the right 'Upgrade' proceedure from the installation
method drop-down list, and then follow the instructions.

1.4.2 Upgrading from 0.5PR1 to 0.5
==================================

0.5PR1 is no longer supported by the development team. If you are still running
this version of BeehiveForum please upgrade to the 0.5 or a later release.


1.4.3 Upgrading from 0.3 to 0.4
===============================

If you are already using 0.3 of BeehiveForum, you will need to update your
database. You should first backup by following the steps in 1.4.1.


1.4.3.1 Update the database
===========================

Simply run the /docs/update-03-to-04.sql script against the database using phpMyAdmin or
MySQL directly.


1.4,3,2 Update the config file
==============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.4 download
and set the relevant variables again.


1.4.4 Upgrading from 0.2 to 0.3
===============================

Follow the same procedure as detailed above, but you must run /docs/upgrade-02-to-03.sql
beforehand.


1.4.5 Upgrading from 0.1 / 0.1.1 to 0.2
=======================================

Follow the same procedure as detailed above, but you must run /docs/upgrade-01-to-02.sql
beforehand


1.4.6 Upgrading from 0.1 or 0.2 to 0.4
======================================

No direct route exists for 0.1 or 0.2 to be upgraded to 0.4. To upgrade either of these
versions to 0.4 you will need to run the relevant schema files in order. 

For example if you are using BeehiveForum 0.1 you will need to run:

upgrade-01-to-02.sql followed by..
upgrade-02-to-03.sql followed by..
upgrade-03-to-04.sql.

This will bring the database up to 0.4, and from there you can use 0.5's upgrade script.


2 Known Issues
==============

Please see release.txt for issues pertaining to each individual release.


3 Support
=========


3.1 Requests / Bug reporting
============================

All this can be done through the Project page provided by SourceForge.
Simply browse to http://sourceforge.net/projects/beehiveforum and submit
requests or bug reports there.

Alternatively you can visit http://www.tehforum.net/forum/ where you'll
find most of the developers of BeehiveForum hanging out. Feel free to post
any questions or queries you have and we'll do our best to answer them.


3.2 General questions and help
==============================

As above, you can try dropping in to http://www.tehforum.net/forum/, 
where you can ask for help or check on the progress of the next version and
see and test previews of the new features. If you need help don't think twice
about posting, although please keep Beehive-related enquires to the 'Beehive 
Development' folder.

We've also added a wiki to help us document Beehive. Check it out here:

http://www.beehiveforum.net/wiki/

Want to contribute to the Wiki? To do so you will need to register a user
account on the test forum. Once you have your account you can login using
the same logon and password and start contributing.


3.3 BeehiveForums in foreign languages
======================================

Since the release of BeehiveForum 0.4 multiple languages have been supported,
but because we're all very busy doing other things the number of languages
that actually ship with BeehiveForum are few and far between. We hope to rectify
this over time, but in order to do so we require volunteers. If you would
like to help translate BeehiveForum into your native tongue please see below.


3.3.1 Translating BeehiveForums into my native language
=======================================================

Unfortunately the BeehiveForum coding team consists primarily of born and bred
English men who have enough trouble speaking our own tongue as it is. Because
of this, we're on the look out for people to start translating BeehiveForum for
us. If you feel you have the necessary skills to do this (no babelfish / direct
from dictionary translations please) feel free to drop us a note. With any
luck your language file may end up being distributed with future versions of
BeehiveForums and you may even get to see your name in print, or at the very
least bundled here amongst the other credits.


3.3.2 Current Available Languages
=================================

Current complete available languages are as follows:

English (UK)
French Canadian
X-Hacker


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
X-Hacker        - Matt Beale.


4.6 Official BeehiveForum Pimp
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
  
- JimL for beating Mike in our being obsessed with BeehiveForum competition.

- SourceForge (http://sourceforge.net) for providing top-notch facilities to us
  (and to thousands of other projects) at absolutely no cost.


4.7.1 Matt would like to thank:
===============================

- Mike Franklin, Pete Kelly, Jon Cooper and Yvonne for just being who you are.


FIN
