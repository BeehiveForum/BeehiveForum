Beehive Forum ReadMe

Version 0.2 / 13th September 2002

0. Contents
===========

1.    Installation
  1.1    Requirements
  1.2    Instructions
    1.2.1    Database setup
    1.2.2    Configuring the forum
    1.2.3    Upload
    1.2.4    First use
    1.2.5    Adminning
    1.2.6    What to do if it doesn't work
  1.3    Customising Beehive
    1.3.1    Stylesheet
    1.3.2    Images
    1.3.3    The top frame
  1.4    Upgrading from 0.1
    1.4.1    Update the database
    1.4.2    Update the config file

2 Known Issues

3 Support
 3.1 Requests / Bug reporting
 3.2 General questions and help

4 Credits


1. Installation
===============

1.1 Requirements
================
You need web hosting which provides:
  - PHP 4.x (tested on 4.0.6, 4.1 and 4.2) and
  - MySQL 3.5 or above (must support compound AUTO_INCREMENT).


1.2 Instructions
================

1.2.1 Database setup
====================

To set up the database, use something like phpMyAdmin (get it from
https://sourceforge.net/projects/phpmyadmin/), or direct MySQL if you
have the skillz, to run the beehiveforum.sql file from the download.

(Beehive would prefer its very own database, but if you can't provide that, it
should work in an existing one.)

If you're feeling saucy, you can edit the insert statements to alter the thread
title and content of the default first post, but if you don't know SQL, it's
probably best to leave well alone.


1.2.2 Configuring the forum
===========================

OK, now you need to make some simple changes to one of the files. Don't
worry, it's easy.

Look in the forum/include folder, and open the file called "config.inc.php".

In here are some variables you need to set so that Beehive Forum can find your
database:

$db_server   = "localhost";	// the address of your MySQL server
$db_username = "user";	// your MySQL username
$db_password = "password";	// your MySQL password
$db_database = "beehivedbs";	// the name of your MySQL database

You need to change those values in quotes to the correct details for your MySQL
setup. You should be able to get the information from your hosting provider if
you're not running your own server.

Next section:

$forum_name  = "A Beehive Forum"; // the name of your forum
$forum_email = "webmaster@yourdomain.com"; // admin email

Change $forum_name to whatever you want displayed in the browser title bar for
your forum. This value is also used when sending e-mails notifying people of
posts.

Change $forum_email to a reasonable email address which your notification will
be "from". You may want to make this "noreply@yourdomain.com", just in case some
of your users take it upon themselves to reply to it.

Change $default_style to the name of the style you want as the default for your
forum. See section 1.3, Customising Beehive, for more info.

You can also change the $maximum_post_length variable if you like - it limits
the amount of a post that will be displayed in the message list, not the maximum
possible size of posts. That's unlimited.

Turn the attachments feature on or off by setting the $attachments_enabled to
true or false. If you have limited web space or bandwidth, you may want to turn
off this feature.

If you choose to enable attachments, you will also need to set a folder for the files
to be kept in. The default, "attachments", would use a folder called called "attachments"
in the installation folder. If you wish, you can specify a root-relative path to keep
them somewhere else (e.g. "/www/myattachmentdir").

Save your changes.


1.2.3 Upload
============

Once you have configured that file, you can upload the forum onto your webspace.
We recommend that you simply upload the "forum" folder directly, either into the
root of your webspace or into another folder of your choosing.


1.2.4 First use
===============

When it's uploaded, open it in your browser, using the address like:

http://www.mysite.com/forum/

but pointing to whereever you've put it. If all has gone well, you should be
faced with a logon screen.

The setup created the administrator login for you, which is as follows:

Logon:    ADMIN
Password: honey

That gives you access to everything, so you can create folders, set user
permissions and so forth. The first thing you should do after logging in is
change that password to something only you know, to stop someone else staging a
coup, and stuff.


1.2.5 Adminning
===============

Now you're ready to create some folders, so click the admin link near the top of
the page, then choose folders from the menu on the left, and set them up.

The other links on the left let you set up profile sections and items, where
your members can provide information about themselves if they like, and do stuff
to users, like ban them, gag them or promote them. It's all explained in there.


1.2.6 What to do if it doesn't work
===================================

Don't panic. Pop over to http://beehiveforum.net/forum and ask us
for help, but remember, we don't get paid for this, so be nice.

It's helpful if you can tell us your setup when you've got a problem, such as
the type of server (e.g. Linux/Apache or Windows/IIS) and the version of PHP and
MySQL that you're using. If Beehive threw up an error message, paste that in as
well.


1.2.7 Add your forum to our list (optional)
===========================================

If you like, you can add your shiny new forum to our list of live copies by
going to http://beehiveforum.net/forums.php

It could be a bit of publicity for your site, and it helps us to be able to say
"Look, all these people are using it!", but if you don't want to, you don't have
to.


1.3 Customising Beehive
=======================

New to version 0.2 of Beehive Forum are the user-selectable styles. Basically
these are like themes (or skins for WinAmp users) for your forum. There are 
several supplied styles, and it's easy to create your own. We will be creating 
a Style Exchange in the near future where people can submit styles they have
created, or download new ones for their own forums.

You can edit the existing styles, but we recommend that you create your own styles.

To create a new style, just create a new folder in the styles folder, with the name
of the new style. For example, to add a style called "fish", you need a folder called
"fish" in the "styles" folder.

Then copy in the contents of one of the existing folders to base your new style on
(the "default" folder is probably a good start) - style.css, top.html and the images
folder with contents.


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


1.4 Upgrading from 0.1
======================

If you are already using 0.1 of Beehive Forum, you will need to update your
database, and add some new variables to the config.inc.php file.


1.4.1 Update the database
=========================

Simply run the update_db.sql script against the database using phpMyAdmin or
command line MySQL.


1.4.2 Update the config file
============================

Probably the easiest way to do this is to edit the config.inc.php in the 0.2 download
and set the relevant variables again.

However, you can also add the new variables to your existing config.inc.php if you wish.
See section 1.2.2 "Configuring the forum" for details.


2 Known Issues
==============

- The Opera browser doesn't display everything right. As usual.
- Bound to be some other stuff.

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


4 Credits
=========

4.1 Coding
==========
Matt Beale / Andy Black / Chris Hodcroft / Mark Rendle / Ben Sekulowicz


4.2 Design/CSS
==============
Mike Franklin / Simon Roberts


4.3 Graphics
============
Nigel Moore / Kevin Yip / Andrew Holgate


4.4 Director
============
Mark Rendle
and Matt/Andy while I was moving house...


4.5 Thanks to
=============
- The NPCFFers for testing, moral support, saying nice things and just generally
  being teh cool.

- SourceForge (http://sourceforge.net) for providing top-notch facilities to us
  (and to thousands of other projects) at absolutely no cost.

FIN
