# Beehive Forum Release Notes

## What's new in 1.4.7 (Released 4th June 2015)

- Changes from 1.4.6

    - Fixed unable to upload attachments by making
      attachments exempt from CSRF checking.

    - Fixed unable to edit posts due to missing CSRF
      token.

## What's new in 1.4.6 (Released 29th May 2015)

- Changes from 1.4.5

    - Fixed several XSS security vulnerabilities
      in code across multiple pages.
      
    - Added CSRF checking for form posting.
    
    - Added support for installing Beehive using
      Softaculous.
      
    - Added PM notification counter to Mobile mode.
    
    - Make correct use of canonical meta tags to 
      help search engines correctly link pages
      together in search results.

## What's new in 1.4.5 (Released 28th February 2015)

- Changes from 1.4.4

    - Fixed a security vulnerability in the user
      profile fields: AVATAR_URL, PIC_URL and
      HOMEPAGE_URL.

## What's new in 1.4.4 (Released 4th August 2014)

- Changes from 1.4.3

    - Fixed an error during installation creating
      the VISITOR_LOG table
    - Fixed not being able to edit vertical polls.
    - Fixed broken images appearing for emoticons
      when editing a post.

## What's new in 1.4.3 (Released 12th July 2014)

- Changes from 1.4.2

    - Fixed threads older than cut-off showing as
      unread
    - New Mobile mode theme with better Beehive
      branding
    - CSS Sprites now used for images.
    - HTML emails for post notifications.
    - Added column sorting and grouping to Admin
      Visitor Log page.
    - Fixed issues with newer versions of Sphinxsearch.
    - Correctly localise numbers with digit grouping.
    - Fix upgrade issues when coming from very old
      versions.

    For more detail please see changelog.

## What's new in 1.4.2 (Released 26th March 2014)

- Changes from 1.4.1

    - Fixed not being able to register new user
      accounts when forum in restricted mode.
    - Fixed Attachments disappearing from posts
      when you edit them.
    - Allow thread authors to view their threads
      which are still pending approval.
    - Upgrade to CKEditor 4 to fix problems with
      Internet Explorer 11.

    For more detail please see changelog.

## What's new in 1.4.1 (Released 27th December 2013)

- Changes from 1.4.0

    - Fixed broken post preview
    - Fixed incorrectly formatted new user admin
      notification emails.

## What's new in 1.4.0 (Released 23rd December 2013)

- Changes from 1.3.0

    - Require PHP 5.3.0 minimum.
    - Use native PHP $_SESSION super-global
    - Youtube and AllMedia plugins for CKEditor
    - Added FineUploaderBasic for much improved
      attachment uploading.
    - Use native PHP zip handling support for PM
      export.
    - Added ability to add new user's to a group.
    - Added search to Mobile mode.
    - Fixed double-slashes in email links causing
      404 errors on some web-server configurations.
    - Fixed language pack not initialising on IIS.

    For more detail please see changelog.

## What's new in 1.3.0 (Released 18th November 2012)

- Changes from 1.2.0

    - Removed non-wysiwyg HTML toolbar and TinyMCE and
      replaced with CKEditor.
    - Fixed many XSS flaws.
    - Fixed Admin Stats display not working correctly.
    - Fixed StopForumSpam not working correctly with
      IPv4 addresses encoded as IPv6.
    - Changed to GNU gettext for translations.
    - Changed Sphinxsearch integration. Please see
      docs in sphinx directory for more information.

    For more detail please see changelog.


## What's new in 1.2.0 (Released 16th April 2012)

- Changes from 1.1.0

    - We got the beehiveforum.net domain back. Hooray!
    - Added IPv6 support.
    - Fixed merging and splitting threads created empty
      target threads and left the source threads
      locked.
    - Some PHP 5.4.0 fixes.
    - Experimental StopForumSpam integration.
    - Fixed editing posts would strip some HTML in
      signature even if HTML was enabled.
    - Word Filter wasn't being applied to HTML meta
      keywords, description and title.
    - We've switched to GIT for version control.
      Find us at github.com/beehiveforum

## What's new in 1.1.0 (Released 5th February 2012)

- Changes from 1.0.1

    - New domain name: www.beehiveforum.co.uk.
      Please update your links!
    - Fixed various XSS injection attacks.
    - New Poll creation and editing pages with
      support for multiple questions per poll.
    - New Mobile mode with visual theme designed
      to compliment the full desktop Beehive Forum
      experience.
    - New Flash and Youtube tags to facilitate the
      easy embedding of these content types.
    - New inline spoiler tag.
    - Imagemagick support for attachment thumbnails
    - Experimental Sphinx Search support. Please see
      sphinx\\_setup.txt for instructions.

## What's new in 1.0.1 (Released 14th February 2011)

- Changes from 1.0

    - RSS Feeds weren't updating due to hard-coded
      date in SQL query.
    - Window resize event firing for guests and
      causing error in IE7.
    - Emoticons not added by clicking on them in
      pm\\_edit.php and pm\\_write.php
    - Duplicate messages displaying if post author
      had more than 1 active session.
    - Profile and Avatar attachments would count up
      views due to missing profile\\_picture or
      avatar\_picture URL parameter.
    - Cast perm value to a double to stop max integer
      size corrupting permissions.
    - Apple Touch Icon not displaying on Android
      devices because they require absolute path to
      the image.
    - Permission USER\_PERM\_THREAD\_MOVE was being
      overridden by user permissions.
    - folder\_draw\_dropdown wasn't allowing the
      current folder

## What's new in 1.0 (Released 9th January 2011)

- Notes

    - Beehive Forum 1.0 changes how forum styles
      and start page are stored. Styles are now
      stored only in the main styles directory and
      start pages are saved to the database.

      The Beehive Forum installer will NOT move the
      forum styles for you, it will however attempt
      to import the forum start pages. After you have
      upgraded please copy any styles you wish to keep
      to the main styles directory.

- Changes from 0.9.1

    - Beehive Forum now uses JQuery as it's Javascript
      library, which allows for greater compatibility and
      extra features.
    - New icons. Beehive Forum now ships with the famfamfam
      silkicon set.
    - New logon page allows the browser to save user
      credentials and helps cut down on the number of
      cookies that Beehive Forum uses.
    - IE9 Beta Jumplist support (Windows 7 only). You can
      now pin your Beehive Forum to your Windows Superbar
      and make use of quick shortcuts to various sections
      including Messages, PM Inbox and Admin Tools.
    - Lots and lots of bugs fixed!
    - For comprehensive list of changes please see the change log.

## What's new in 0.9.1 (Released 15th July 2009)

- Notes

    - Beehive Forum 0.9.1 is intended to fix bugs found since
      the release of Beehive Forum 0.9. There are no new
      features in this version.

- Changes from 0.9

    - Fixed: Admin Forums not setting forum name if the forum
             already had a name saved.
    - Fixed: Debugging output of SQL query left in pm.inc.php
             is visible on IIS servers.
    - Fixed: Error during install if no FILE permission on MySQL
             account.
    - Fixed: Forum doesn't work if GeSHi is not installed.
    - For comprehensive list of changes please see the change log.


## What's new in 0.9 (Released 5th July 2009)

- Notes

    - Beehive Forum 0.9 introduces news client-side HTML
      caching of the page output for the most frequently
      visited pages on your forum including thread list,
      message pane and the start pages. If you encounter
      problems with stale content showing on the pages
      you can disable this option by modifying the
      $http\_cache\_enabled setting and changing it to false.
    - Beehive Forum 0.9 requires PHP 5.1.0 and PCRE 6.6
      compiled with --enable-utf8 --enable-unicode-properties.

- Changes from 0.8.4

    - Added: UTF-8 support improved. Should be fully compatible
             with other PHP applications now.
    - Added: Google Analytics code support added to Beehive.
    - Added: Support for Google Adsense adverts with various
             settings and options to change how they appear.
    - Added: Option to specify the forum rating as a meta tag
             so you can set your forum to be general, 14+,
             mature or restricted.
    - Added: Bans can now be set to expire on a set date.
    - Fixed: Deleting a user was physically deleting a user's
             posts from the database instead of NULL-ing the
             content resulting in errors when accesing affected
             threads.
    - For comprehensive list of changes please see the change log.

## What's new in 0.8.4 (Released 07th August 2008)

- Beehive Forum 0.8.4 is primarily intended to fix bugs
  found since the release of Beehive Forum 0.8.3.

  New features for this release include Admin Forum Stats
  Display, Improved Admin User Alias pages, Start Page CSS
  style sheet uploader, Folder Subscriptions, Thread List
  Sorting Options,  TinyMCE 3.1.0 support and Post Approval
  Queue Improvements.

- For comprehensive list of changes please see the change log.

## What's new in 0.8.3 (Released 16th June 2008)

- Beehive Forum 0.8.3 is primarily intended to fix bugs
  found since the release of Beehive Forum 0.8.2. New
  features for this release include Quick Reply, User
  Group display in profile pop-up and reduced memory
  foot print for user session data.

- For comprehensive list of changes please see the change log.

## What's new in 0.8.2 (Released 19th January 2008)

- Beehive Forum 0.8.2 fixes several bugs found since the
  release of Beehive Forum 0.8.1. Upgrading to
  Beehive Forum 0.8.2 is possible from 0.6.x, 0.7.x
  and 0.8.x and should be performed using the installer
  as normal.

- For detailed changes please see the change log

## What's new in 0.8 (Released 4th November 2007)

- Important Notes

    - Beehive Forum 0.8 fixes a security vulnerability that
      could allow for user logon and password MD5 hash disclosure.
      It is recommend all users immediately obtain the newest
      version of Beehive Forum to protect against this threat.

- Changes from 0.7.1

    - For detailed change log please read changelog.txt


## What's new in 0.7.1 (Released 13th October 2006)

- Notes

    - 0.7.1 replaces the original 0.7 release of 1st October.
      The database schema for 0.7.1 is identical to 0.7. To
      upgrade from 0.7 to 0.7.1 simply extract the archive
      over your existing installation and delete the installer
      files. Upgrades from 0.6.x to 0.7.1 will still require
      running the installer as normal.
    - BeehiveForum 0.7 introduces a new thread unread cut-off
      that helps to increase performance by storing unread
      thread data for a limited time rather than in previous
      builds where it was stored indefinitely. You can set up
      the thread unread cut-off in the Global Forum Settings
      portion of your Beehive Forum installation but pruning
      of the USER\_THREAD tables must be performed by hand.

- Changes from 0.7

    - Fixed: Broken links to confirm email script in edit.php,
             delete.php, create\_poll.php and admin\_post\_approve.php
    - Fixed: Incorrect error message displayed when accessing
             pages using user account with un-confirmed email
             address.
    - Fixed: Error message "Failed to create forum" appearing
             when attemping to create additional forums.
    - Fixed: "Unknown column 'DEFAULT\_FORUM' in 'field list'"
             error when performing new installation.
    - Fixed: "Unknown error [8] Undefined variable: table\_index"
             error message when performing upgrade from 0.6.x.
    - Fixed: Errors in English UK and English US language files.
    - Fixed: Search was sometimes showing no thread titles in
             results.
    - Fixed: Extra query in thread\_delete which was cleaning the
             USER\_THREAD table twice.
    - Fixed: Fixed special characters not being encoded
             correctly in RSS feed.
    - Added: More intuitive controls for moving folders, forum
             links and profile sections and items.

## What's new in 0.7 (Released 1st October 2006)

- Notes

    - BeehiveForum 0.7 introduces a new thread unread cut-off
      that helps to increase performance by storing unread
      thread data for a limited time rather than in previous
      builds where it was stored indefinitely. You can set up
      the thread unread cut-off in the Global Forum Settings
      portion of your Beehive Forum installation but pruning
      of the USER\_THREAD tables must be performed by hand.

- Changes from 0.6.3

    - Fixed: My Forums showing lots of unread messages because
             it wasn't using the cut-off code.
    - Fixed: Light mode logon form wasn't redirecting correctly
             if you had a msg= or folder= url query.
    - Fixed: Extra unneeded ban check in admin.php
    - Fixed: Homepage URL and Pic URL were not optional and you
             couldn't delete the data in them if you wanted to.
    - Fixed: Homepage URL never showing up on user profile
             popup.
    - Fixed: USER\_PERM\_BANNED wasn't always working correctly.
             Moved check into main files and out of bh\_session\_init().
    - Fixed: Installer and upgrade scripts now attempt to
             recreate all the indexes that Beehive has ever had.
    - Fixed: Erranous word filter tags on email notifications
             caused by format\_user\_name using add\_wordfilter\_tags
             rather than straight apply\_wordfilter.
    - Fixed: Added missing log entries for deleting RSS Feeds
             and updating Bans to admin\_viewlog.php
    - Fixed: Potential conflict with RSS feed updates containing
             the same full story URL.
    - Fixed: Text stuck to border on admin\_folders.php and
             admin\_folder\_add.php
    - Fixed: sprintf() error in admin\_rss\_feeds.php
    - Fixed: install\_remove\_table\_keys() wasn't working correctly.
             It would bail out when it encountered a primary
             key and not remove any keys after that in the list
    - Fixed: upgrade-06x-to-07.php now works on all 0.6.x
             builds including release candidates without complaining
             about conflicts.
    - Fixed: Broken links to ban and unban IP and HTTP referer
             from other pages.
    - Fixed: Errors in installer when upgrading from 0.5 or
             doing a new fresh install.
    - Fixed: Error regarding valid characters in installer help
             popup (says you can use hyphens when you can't)
    - Fixed: Error handler not always able to get the MySQL
             version number so now we don't try to display what we
             can't get.
    - Fixed: Error in installer when target database doesn't
             exist.
    - Fixed: Always getting logged in as a guest even when you
             had saved logon.
    - Fixed: Reloading the frameset with the logon form visible
             will show it in it's first state.
    - Fixed: Unread threads showing with read icon on
             start\_left.php
    - Fixed: Parse errors in edit.php, delete.php and
             lmessages.php.
    - Fixed: Movied english language strings in admin\_banned.php
             into en.inc.php
    - Fixed: Ban check wasn't being applied to guests
    - Fixed: Ban check wasn't being performed if the session
             didn't contain some of the data to check.
    - Fixed: Exploit with $uid possible resulting in lots of
             failed queries and possibility for code injection.
    - Fixed: Admin Log was showing 'Unknown' for some recent log
             entry additions.
    - Fixed: Stats display wasn't using You and You (Invisible)
             language strings (from previous rollback maybe?)
    - Fixed: Layout issues in thread\_options.php when viewing a
             poll.
    - Fixed: admin\_forum\_access.php change password button went
             to default / current instead of selected forum.
    - Fixed: admin\_forum\_access.php loaded without a FID in url
             query resulted in a blank page with no error.
    - Fixed: admin\_forum\_set\_passwd.php loaded details for
             default / current forum (from webtag) if no ?fid= in url
             query or where fid was invalid.
    - Fixed: incorrect password could be used to enter a
             password protected forum!
    - Fixed: admin\_forums.php layout issue caused confusion if
             forum webtag or description were exceptionally long.
    - Fixed: user became locked out of forum if using a saved
             forum password and password was changed by owner.
    - Fixed: missing call to html\_draw\_top() in
             admin\_forum\_access.php
    - Fixed: Wrong description for forum settings.
    - Fixed: admin\_startpage.php wasn't showing all the correct
             extensions for upload.
    - Fixed: Attachments not working in PM correctly.
    - Fixed: Attachments field being too wide for IE and causing
             wrapping of text next to it.
    - Fixed: Function threads\_any\_unread was finding messages in
             folders the user didn't have access to.
    - Fixed: Clicking the "eye" in messages to mark a thread as
             unread wasn't working, Had been broken with previous
             update to message\_update\_read / message\_set\_read
             functions
    - Fixed: Removed if (IE) checks from post.js and made better
             checks against available JS functions.
    - Fixed: Made addOverflow function in post.js set the
             overflowX and overflowY separately for IE so as to not
             add a vertical scrollbar.
    - Fixed: Possible to edit someone elses signature without
             being an Admin by saving the form locally and editing.
    - Fixed: bh\_check\_styles.php works correctly to find classes
             with child tag definitions (e.g. spoiler a:hover)
    - Fixed: admin\_user\_groups display looked messed up when no
             groups created.
    - Fixed: Reply To All link no longer appears if the user
             doesn't have permission to reply.
    - Fixed: bug that allowed users to edit a reply to link to
             allow them to post in a folder they don't have access to.
    - Fixed: Sorting on "Referrer" column wasn't possible in
             admin\_users.php
    - Fixed: Incorrect datatype error when clicking a folder
             name
    - Fixed: Errors when viewing PM folders.
    - Fixed: Word Filter stripslashes issue and filter order
             kept switching around on save.
    - Fixed: Attachments add upload field link no longer clears
             the field if you've already selected a file.
    - Fixed: Attachments add upload field link only appears if
             the browser supports document.getElementById.
    - Fixed: forum\_create() wasn't creating all the tables
             required for a 0.7 forum
    - Fixed: Installer and upgrade scripts were not working
             correctly.
    - Fixed: Installer wasn't loading the 0.7 upgrade scripts
             correctly.
    - Fixed: Poll Question was broken.
    - Fixed: Polls weren't fetching the correct approval or
             edited data from the database.
    - Fixed: Inconsistency in display.php, ldisplay.php,
             messages.php with not showing h1&gt; header and wrong error
             message.
    - Fixed: Editing a post and clicking the hide / show
             signature box resulted in the text being urlencoded
             incorrectly.
    - Fixed: Undefined variable $uid in edit.php
    - Fixed: Answer count drop down not working.
    - Fixed: Messages still not marking as read. Restored old
             code from CVS.
    - Fixed: Layout changed for edit\_profile.php so all the text
             fields line up.
    - Fixed: Squiffy layout on edit\_profile.php
    - Fixed: Nicknames were showing as blank on edit\_relations.php
             on first visit (with existing pre 0.7 relationships)
    - Fixed: Better clean up of global data when deleting forum.
    - Fixed: Undefined variables $mids\_array in pm.inc.php when
             folders were empty.
    - Fixed: Missing argument 4 in user\_rel.php.
    - Fixed: Problem with edit\_signature stripping out URL where
             the href is exactly the same as the text to be linked
             (i.e. a URL)
    - Fixed: Removed SQL debugging code from admin.inc.php
             (displays in admin\_users.php)
    - Fixed: Added back the error trapping for invalid regular
             expressions on word filter.
    - Fixed: Same issues in edit\_wordfilter.php as Admin word
             filter (stripslashes, filter order)
    - Fixed: Link in install.php could cause 404 because it sent
             you to ../index.php
    - Fixed: Prevent logon.php and other page reloads from being
             logged as the referer.
    - Fixed: Recent Messages broken by previous guest user
             performance boosts.
    - Fixed: Error when parsing invalid url with parse\_url()
    - Fixed: Upgrade script was completely broken (got stuck in
             a loop indefinitely)
    - Fixed: Undefined variable $uid in myforums.inc.php caused
             by the user session not being initialized in lforums.php
    - Fixed: Guest users weren't being assigned their perm array
             so couldn't browse any of the messages.
    - Fixed: Stray guest session left behind when user finally
             logged in.
    - Fixed: Added thread title to page title.
    - Fixed: Messages not always marking as read under some
             MySQL versions
    - Fixed: Error in bh\_session\_get\_folders\_by\_perm() not
             checking default folder perms correctly.
    - Fixed: Missing webatg when logging out meant you wouldn't
             log back into the same forum if you logged out and
             straight back in.
    - Fixed: Adding up the wrong data for USER\_TIME\_TOTAL (duh
             brain moment)
    - Fixed: Bug in MySQL 4 prior to 4.1.16 results in error
             about ambiguous column names so we now perform a test to
             check the MySQL version before performing the newer and
             quicker queries otherwise we fall back to the old
             much-much slower code.
    - Fixed: Sort column in Admin -&gt; Users was ambiguous
    - Fixed: Undefined variable $db\_ip\_is\_banned in
             banned.inc.php
    - Fixed: Function forum\_create() bought up to date with
             indexes.
    - Fixed: Function forum\_delete() wasn't removing the new
             THREAD\_STATS table.
    - Fixed: Undefined variable $spid when marking a thread as
             unread.
    - Fixed: Session was tracking user accorss forum changes
             correctly.
    - Fixed: Automatic high interest was not working due to
             changes in query in previous update.
    - Fixed: Missing missing THREAD\_STATS table for conflicting
             removal on upgrade.
    - Fixed: Patch to thumbnails in PM export was incorrectly
             using ?thumb=1
    - Fixed: USER\_TRACK table turned into a per-forum table to
             fix post count and post and search frequency
             restrictions across multiple forums.
    - Fixed: Possible for user's to discover nicknames assigned
             to them by another user by means of a PM with a quoted
             reply.
    - Fixed: Stray wordfilter tags on pm\_write.php when replying
             to PM with auto quote enabled.
    - Fixed: Stary space on end of search results.
    - Fixed: Emoticons not working in IE7 Beta2. Same fix as
             used for Safari / KHTML based browsers (added &nbsp;)
    - Fixed: User was logged in when updating RSS feed forcing
             user to appear as logged in when they hadn't visited a BH
             forum using  the current browser session.
    - Fixed:: Undefined variable $result\_count in searh.inc.php
    - Fixed: Missing argument 4 for user\_rel\_update() when
             unignoring a user using the link in the message display.
    - Fixed: Not being able to log on when you don't have
             credentials saved and not being able to logon as a
             different user to those credentials you have saved.
             Hopefully this won't break the fix I put in place for Jon
             at tehforum.
    - Fixed: Undefined variable in messages\_set\_read() when
             marking thread unread.
    - Fixed: Missing argument 4 in messages\_set\_read() when
             marking thread unread.
    - Fixed: Double encoded HTML entities in RSS feed.
    - Fixed: RSS feed not working correctly in Internet
             Explorer.
    - Fixed: Threads RSS feed was broken if viewing as a guest.
    - Fixed: User Profile layout was squiffy.
    - Fixed: html\_get\_forum\_uri() was stripping the path from
             the URL returned.
    - Fixed: Layout issue with empty &lt;ul&gt;&lt;/ul&gt; tags and stray
             &lt;/ul&gt;
    - Fixed: Poll being affected by word filter which could
             break the display of the page. Word filter is applied to
             the polls option names instead.
    - Fixed: bh\_check\_dependencies.php changed output to use
             BH\_INCLUDE\_PATH
    - Fixed: Image attachments which are alpha blended PNG
             images should now create alpha blended thumbnails (GD &gt;=
             2.0)
    - Fixed: Undefined variable $interest when posting with high
             interest option set.
    - Fixed: Removed debugging code from ban\_check() function
             and added check for BEEHIVE\_INSTALL\_NOWARN
    - Fixed: Error trapping for text captcha for missing glyphs
             in selected font.
    - Fixed: PM XML export was broken.
    - Fixed: Hyphenated words matched correctly by dictionary.
    - Fixed: Parse error in errorhandler (the irony is too much)
    - Fixed: Extra check for $nickname to see if it's an empty
             string in user\_rel.inc.php
    - Fixed: Guests were able to see folders and posts they
             didn't have access to.
    - Fixed: Couldn't log in as a guest if you had a saved user
             logon.
    - Fixed: Attachments had a funny layout issue in personal
             messages.
    - Fixed: Yet more bh\_update\_user\_time fixes that account for
             the user not logging out correctly.
    - Fixed: Dictionary wasn't importing correctly when MySQL
             FILE permission error encountered.
    - Fixed: forum\_delete() function wasn't removing all
             references to old forum (missed USER\_TRACK and
             THREAD\_TRACK tables and data in global tables.
    - Fixed: Permissions were being applied incorrectly to new
             forums when created.
    - Fixed: USER\_TIME column changed to DATETIME type to allow
             storing session lengths greater than 6 months.
    - Fixed: bh\_cvs\_log\_parse.php was timing out if the CVS
             server was slow at responding.
    - Fixed: Undefined variable $result\_fetch in
             session.inc.php.
    - Fixed: PM notification popup not firing due to frameset
             calling html\_draw\_top and not using a body tag.
    - Fixed: Potential exploit in install\_check\_tables.
    - Fixed: Problem with looping index.php when using light
             mode.
    - Fixed: issue with user\_passhash check failing and user not
             being able to login despite BH saving the MD5 hash of
             their password.
    - Fixed: 2 or more attachments in message and PM display had
             an extra line break between them.
    - Fixed: IP Address comparision was returning empty strings
             and therefore returning non-matches.
    - Fixed: Word filter messing up ignored signatures.
    - Fixed: Prevent hi-jinks by using &lt;filter&gt; tag to prevent
             word filtering.
    - Fixed: db\_affected\_rows using wrong variable to check for
             success.
    - Fixed: Messages not always marking as read under some
             MySQL versions STILL
    - Fixed: Unread to me marker not working correctly.
    - Fixed: Undefined index MOVED\_TID and MOVED\_PID when
             viewing a poll in messages.inc.php caused by error in
             poll.inc.php.
    - Fixed: Unknown table name THREAD\_TRACKED in thread.inc.php
    - Fixed: Viewing an old thread marked un-read all the posts
             on subsequent pages.
    - Fixed: unread messages on forums.php showing as a negative
             number
    - Fixed: Changed permissions check to strict comparision to
             prevent potential problems.
    - Fixed: SQL error when editing a PM in Outbox.
    - Fixed: SQL error when calculating user's post count could
             occur.
    - Fixed: Prevent user from being prompted about a PM more
             than once. Still affected by page reloads.
    - Fixed: Undefined variable $mid in pm.inc.php
    - Fixed: Poll question not being affected by word filter.
    - Fixed: Peer Nickname not working on threads\_get\_recent()
             or on polls.
    - Fixed: Undefined variable in session.inc.php
    - Fixed: Undefined index ['FID'] in poll.inc.php
    - Fixed: Call to old perm\_is\_moderator in poll.inc.php
    - Fixed: bh\_user\_time\_update() wasn't working properly after
             the first update. It would subsequently set the time as 0
             after successfully working it out the first time.
    - Fixed: USER\_TIME\_TOTAL still wasn't working properly if
             the USER\_TIME\_TOTAL column was null.
    - Fixed: User time total was adding the session time up
             incorrectly and increasing the value artifically.
    - Fixed: Last Visit on My Forums showing Never Visited if
             you had browse anonymously switched on.
    - Fixed: Anonymous users USER\_TIME setting was being set
             incorrectly.
    - Fixed: USER\_TRACK data for USER\_TIME wasn't being added if
             the user didn't already have some data available in the
             table.
    - Fixed: USER\_TIME not updating when value was NULL.
    - Fixed: Guests and some users were receiving an error when
             entering the forum due to having no permissions.
    - Fixed: Undefined variable $user\_sess in session.inc.php
             when entering the forum as a guest.
    - Fixed: Function thread\_get() wasn't correctly setting the
             LAST\_READ for a thread outside the cut-off which meant
             that the whole thread appeared unread.
    - Fixed: Guests weren't able to browse folders in the thread
             list.
    - Fixed: Threads not modified since the cut-off were
             sometimes showing as unread in All Discussions.
    - Fixed: Thread with no LAST\_READ data now automatically
             mark as read posts older than the cut-off so you don't
             end up re-reading old posts.
    - Fixed: If statement error in threads\_process\_list()
    - Fixed: Thread list mode drop down wasn't returning the
             right thread types.
    - Fixed: Removed debugging code from user\_get\_aliases()
    - Fixed: Missing utf8.inc.php from CVS.
    - Fixed: You and You (Invisible) was hard coded into
             messages.inc.php. Added to translation files/
    - Fixed: Parse error in en-us.inc.php
    - Fixed: bh\_x-hacker\_translate.php wasn't always translating
             all the strings in the english file.
    - Fixed: bh\_check\_languages will now find strings which
             haven't been translated (identical to en.inc.php)
    - Fixed: Stray comma in new-install.php causes error when
             creating POST table.
    - Fixed: Errors installer and upgrader when upgrading
             multiple forums.
    - Fixed: Missing remove conflict for SEARCH\_ENGINE\_BOTS
             table.
    - Fixed: Unknown table type error caused by not resetting
             the $sql variable in upgrade scripts.
    - Fixed: Updated install / upgrade scripts with schema for
             new BANNED table.
    - Fixed: Wrong table format for USER\_POLL\_VOTES when
             upgrading from 0.5
    - Fixed: Adding indexes to wrong tables.
    - Fixed: Missing query to add SID column to VISITOR\_LOG
             table when upgrading to 0.6
    - Fixed: addOverFlow(): Calculation was off for clientWidth.
    - Fixed: addOverFlow():Table cells are now set to 98% in
             pixels (was 100%)
    - Fixed: addOverFlow(): Added redoOverFlow function to
             reflow page when window is resized.
    - Fixed: Type error for .width decleration in post.js in
             FireFox Javascript console fixed.
    - Fixed: Better check for attachEvent / addEventListener so
             they are only called if the browser supports them.
    - Fixed: Overflow text works for both Gecko browsers and IE
             browsers now. Not tested on Opera. Opera sucks.
    - Added: Tehforum style (variation of BH default) so it's
                 easier to maintain and it's somewhere safe to keep it.
    - Added: Missing image for edit\_relations.php
    - Added: bh\_ms\_word\_spelling\_check.php that can spell check
             the English language translation
    - Added: .cvsignore files to prevent adding of Attachments
             and Text Captcha folders and other files.
    - Added: UTF-8 encoded output via mb\_string functions if
             applicable.
    - Added: Check button on admin\_banned.php when adding a ban.
    - Added: Column sorting and pages to admin\_banned.php (10
             items per page).
    - Added: Ban controls for HTTP referer.
    - Added: Ban data changes for HTTP referer to admin log.
    - Added: Options to manage the unread messages cutoff in
             admin\_default\_forum\_settings.php
    - Added: Option to hide Guests from Visitor Log both at
             Global and per-forum level.
    - Added: Textcaptcha class has new destroy\_image function to
             clean up image after use.
    - Added: Register.php removes Textcaptcha image after use.
    - Added: New bh\_find\_deprecated\_consts\_and\_langs.php that
             replaced bh\_find\_deprecated\_language\_strings.php. Now
             finds constants and lang strings.
    - Added: Option to reset all user permissions for the
             selected folder to match those of the current folder.
    - Added: Grace period for editing posts where the EDITED BY
             text doesn't appear.
    - Added: User's can now alter the nicknames of other user's
             they've added to the relationships list. (WIP, probably
             missed loads)
    - Added: HTTP Referer code for session initialisation and
             user registration.
    - Added: Option for Admin to edit a user's profile.
    - Added: Option to artificially change the user's post count
             and reset it back to normal.
    - Added: Mouseover spoiler highlight to lite mode. Not in
             full mode at the moment. Will change this to user
             configurable option.
    - Added: Check for Windows CE powered Smartphones that shows
             the spoiler so it's readable in Pocket IE.
    - Added: Functionality to restrict CSS attributes by units
             (width, height, etc)
    - Added: 0.6.x to 0.7 upgrade updates thread viewcount
             with the number of registered users who have read each
             thread.
    - Added: Option added to config.inc.php allows you to
             specify target frame in replace of \_top for embedding
             Beehive in frameset.
    - Added: Functionality to restrict the USER\_THREAD table. No
             inteface to change the options yet.
    - Added: By popular request a way to preview the voting form
             when creating a poll.
    - Added: By popular request a proper thread delete function
             that actually removes all trace of a thread. Already
             deleted threads remain as they were.
    - Added: Ability to move a thread to a "Deleted Threads"
             list and recover it back.
    - Added: Tooltip text to reset button so people know what it
             actually does. Duh.
    - Added: Nickname editing to user\_rel.php (hand icon on
             posts)
    - Added: Export options for each file type added for PM
             Exporting.
    - Added: Backend code to forum\_options.php and user.inc.php
             to handle the saving of PM exporting options
    - Added: PM Export Options interface. Doesn't work yet.
    - Added: Optional argument to bh\_update\_visitor\_log() so you
             can specify the forum.
    - Added: Function install\_remove\_table\_keys() allows
             installer to remove keys from tables.
    - Added: Javascript code to resize images larger than the
             message pane width and add overflow to posts.
    - Added: USER\_TRACK.USER\_TIME tracks the length of the
             user's session. Rather inaccurate at the moment.
    - Added: Export option to pm.php which creates a zip file of
             html files (1 for each message) and includes your
             attachments and your user style. No emoticons because it
             wouldn't make sense to include all the files! Coming soon
             some options in My Controls to specify what gets
             exported.
    - Added: Thread type drop down list added to top of
             search.php for display when no results found.
    - Added: Tooltip for start\_left.php and thread\_list.php now
             include the VIEWCOUNT for the thread.
    - Added: bh\_session\_check() function now allows a second
             optional parameter that overrides the cookie MD5 hash.
    - Added: bh\_session\_init() now returns the MD5 hash
             generated / retrieved upon success.
    - Added: MySQL error code for missing / invalid column name
             added to prevent error handler from showing some SQL
             errors.
    - Added: Search engine bots now show in the visitor log with
             clickable links to their home pages.
    - Added: New attachment test code added to start\_left.php
             and threads\_get\_most\_recent() function.
    - Added: Registered display in user profile. About time we
             had that somewhere.
    - Added: Output for user time tracking to profile popup.
    - Added: Filename to end of get\_attachment.php links to try
             and spoof browsers who ignore the filename= header.
    - Added: Logging to the DB functions. ooh and eak at the
             number of queries at messages.php runs!!
    - Added: Error message when mysql/mysqli extension couldn't
             be loaded.
    - Added: Function to iterate through the session perms and
             return all matches against a perm for a specific forum.
    - Added: Code to prevent browsers caching style sheets
             (appends ?[modifiedtime] to end of URL)
    - Added: Backend code for post view counter. No idea where
             to display it at the moment. Bottom left of each post?
    - Added: Function to automatically prune the unread thread
             data based on the settings picked in Default Forum
             settings.
    - Added: bh\_update\_user\_time() function which handles the
             USER\_TIME updates.
    - Added: USER\_TIME update it performed once for each user
             every time their session needs renewing.
    - Added: FULLTEXT index added to SEARCH\_ENGINE\_BOTS to speed
             up matching.
    - Added: Query to attempt conversion of SESSIONS table to
             HEAP if available.
    - Added: Upgrade scripts now calculate and insert the thread
             view counts. It's only 1 thread view per registered user
             and doesn't count guests or multiple views but it's a
             start at least :)
    - Changed: Tehforum address changed to co.uk as the .net
               domain has expired and is being held to ransom.
               Bastards.
    - Changed: Probability of forum clean up functions changed
               to 1 in 50 by default.
    - Changed: Removed GRANT permission from requirements for
               MySQL
    - Changed: Made forum\_create() add an index to VIEWED on
               POST table.
    - Changed: Installer and upgrade script add index to
               VIEWED on POST table.
    - Changed: Updated readme.txt. Removed references to CLI
               installer and changed some other things.
    - Changed: Forum clean up functions now return FALSE if
               they didn't run.
    - Changed: Readme.txt updated for requirements (now PHP
               4.2.0)
    - Changed: clean\_styles was being too conservative at
               preventing margins and such like.
    - Changed: Got rid of the index creating loops in the
               installers because they're too slow.
    - Changed: Removed a lot of indexes that were causing slow
               downs just to conflicts (?) with primary keys.
    - Changed: Moved the current user perm checks into the
               session array so that there are fewer hits on the
               database.
    - Changed: Error message and success messages on
               admin\_banned and admin\_rss\_feeds now appear for more
               events.
    - Changed: Admin Ban controls changed to work like the new
               Admin RSS controls
    - Changed: Language-ised admin\_banned.php completely.
    - Changed: New admin\_banned.php with more intuitive (well,
               mostly) layout.
    - Changed: Updated x-hacker language file.
    - Changed: Logon and logout forms tidied up a bit.
    - Changed: Wording in admin\_default\_forum\_settings for
               textcaptcha waning includes full path now.
    - Changed: Seperated bh\_session\_init() into two functions
               with the second new one handling the guest session
               creation.
    - Changed: New RSS Feed Admin panel with easier to
               understand form and options.
    - Changed: RSS Feed Prefix is now optional and if used
               doesn't include square brackets around it.
    - Changed: Layout of admin\_folder\_edit.php so it looks a
               bit better now.
    - Changed: Search stop words popup changed to 3 column
               layout to better fit on screen.
    - Changed: Moved all hyperlinks out of the language files
               and into the main scripts.
    - Changed: install\_check\_tables now allows you to specify
               an array of tables to check.
    - Changed: Clicking reset nickname button in
               edit\_relations saves that relationship but not others.
    - Changed: admin\_forums,php width added to main table to
               prevent it looking bunched up.
    - Changed: Shrunk logon form slightly to make it look less
               gash.
    - Changed: Word filter is now done in output buffering
               rather than load list and call mutiple times everytime
               apply\_wordfilter is called.
    - Changed: Removed function
               messages\_get\_most\_recent\_unread function and updated
               messages\_get\_most\_recent function to find both read and
               unread messages.
    - Changed: admin\_post\_approve.php, delete.php and edit.php
               to use newer  messages\_get\_most\_recent function if the
               thread that was being modified no longer exists.
    - Changed: Function thread\_get() now checks to see which
               folders the user can view.
    - Changed: All calls to thread\_get placed within if
               statements to check the return value for above change.
    - Changed: Removed useless calls to thread\_get\_title,
               thread\_get\_folder, etc which were being duplicated by
               calls to thread\_get.
    - Changed: Removed join with THREAD table for
               message\_display. Instead we use the data we alread
               fetched from thread\_get.
    - Changed: My Controls pages layouts changed to move text
               away from the table border.
    - Changed: USER\_TIME\_LAST now USER\_TIME\_BEST and stores
               the user's longest session rather than last session.
    - Changed: URL truncating in admin\_users.php now uses
               parse\_url if possible to shorten URL to scheme and host
               only.
    - Changed: Attachments layout changed.
    - Changed: Poll groups are now seperated by a &lt;hr&gt; again.
    - Changed: New create\_poll.php that is more in fitting
               with post.php and other scripts.
    - Changed: Removed db.log debugging from DB functions.
    - Changed: Removed extra call to
               messages\_get\_most\_recent() and changed
               messages\_get\_most\_recent\_unread() to also look for read
               messages as well.
    - Changed: Removed joins on USER table for approved and
               edited logon. We now fetch that data seperatly if we
               need to.
    - Changed: user\_get\_prefs() changed query from COUNT to
               basic SELECT ... LIMIT 0, 1 style query.
    - Changed: Added Preview Voting Form button to
               edit\_poll.php
    - Changed: new edit\_poll.php that looks like
               create\_poll.php. No change in functionality otherwise.
    - Changed: Updated fr-ca language.
    - Changed: The individual light mode scripts now check to
               see if you have a saved logon cookie and redirect you
               if you're not logged in.
    - Changed: Replaced UTC time zones with GMT + country
               names
    - Changed: Updated Installer to add the relevant new PM
               exporting columns to USER\_PREFS (global) table.
    - Changed: Removed redudant final\_uri code from light mode
               as it doesn't do anything at the moment. Will work
               out a better way to handle it some time, but for now
               the frame set and the &lt;noframes&gt; tags and the whole
               redirecting causes too many headaches.
    - Changed: Removed lforums.php from robots.txt so that
               Google and co can index multiple forums under a single
               BH install.
    - Changed: Less Resource Intensive way of updating
               THREAD\_STATS table UNREAD\_PID, UNREAD\_CREATED columns.
    - Changed: Lack of LAST\_READ data is now calculated as
               threads are viewed and as the USER\_THREAD data is
               pruned rather than working it out on the fly with a
               join against the POST table.
    - Changed: Updated en-us and x-hacker language files.
    - Changed: Moved the invalid username / password prompt in
               logon.php to be within the frameset (uses a cookie to
               check if the logon was a failure)
    - Changed: Gave the Light mode the same functionality as
               the full thread list with the ability to mark a single
               folder as read.
    - Changed: Fixed spelling error "Where moved to" in
               en.inc.php
    - Changed: New CSS class for thread\_tracking\_notice rather
               than reusing text\_captcha\_error
    - Changed: Deleted threads can now be browsed by
               Moderators. Edit Thread Options link at bottom of page
               links to thread\_options.php to allow undelete.
    - Changed: Installer updated to reflect changes to
               USER\_PREFS table and USER\_TRACK table.
    - Changed: Removed Reply To links from PM Inbox export.
    - Changed: UTF-8 encoded files.
    - Changed: Removed redundant check from thread\_list.php
               which is now handled by thread\_get()
    - Changed: Funky queries for mark as read which literally
               take 2 to 3 seconds on default MySQl installation with
               no tuning! Not sure if these will work with MySQL 3.x.
               They should do because the manual mentions the method
               is available. Anyone want to test?
    - Changed: Reduced number of queries required to find
               threads with attachments for display of paperclip in
               thread list.
    - Changed: X-Hacker language doesn't show matching strings
               anymore like en-us.
    - Changed: Removed useless joins against GROUP\_USER and
               GROUP\_PERM tables from query in user\_logon function.
    - Changed: Probability of forum clean up functions running
               has been increased by default from 1 in 50 to 1 in 20
    - Changed: Only one forum clean up function is run per
               page load per user if they run at all. Prevents them
               running all at once and causing long page loads.
    - Changed: Removed POST table reindexes from upgrade and
               installer after running tests on Teh Forum.
    - Changed: All the wasteful SELECT COUNT queries have been
               changed to basic queries that fetch 1 row (LIMIT 0, 1)
               and 1 column (primary key)
    - Changed: PM export HTML now uses verbose date format to
               include day month and year.
    - Changed: Mucho faster emoticon class. Shaved over 400ms
               off the execution time (woo!)
    - Changed: new-install.php small change to prevent
               unneccesary processing after removal of conflicts.
    - Changed: bh\_session\_get\_perms\_by\_folder() is more
               efficient.
    - Changed: Moved test for USER\_PERM\_GUEST\_ACCESS into
               folder.inc.php.
    - Changed: folder\_get\_all() and folder\_get\_all\_by\_forum()
               now use the session data rather than requery the
               database.
    - Changed: Converted all BIT\_OR SQL calls for selecting or
               retrieving folders to the new bh\_session\_check\_perm()
               function.
    - Changed: Moved VIEWED column from THREAD table into a
               seperate THREAD\_STATS table.
    - Changed: USER\_TRACK table now records both the user's
               longest single session and their total session time.
    - Changed: Javascript threaded 'hack' to make the PM
               notification appear without disrupting the page
               loading.
    - Changed: Pluralisation of 'You have %d new PM" so we
               correctly get "You have 1 new PM" and "You have 2 new
               PMs"
    - Changed: Post count now is Thread count. Makes more
               sense. Duh.
    - Changed: bh\_session\_end() now uses current time rather
               than the session time.
    - Changed: Option to reset user permissions doesn't affect
               the user's moderation permission anymore.
    - Changed: USER\_POLL\_VOTES table structure changed to work
               on the primary key to make queries faster.
    - Changed: Probability code for update\_stats(),
               thread\_auto\_prune\_unread\_data(),
               bh\_remove\_stale\_sessions() and
               pm\_system\_prune\_folders()
               now used mt\_rand() rather than time() which means the
               functions are less likely to fire when two users load a
               page within milliseconds of each other.
    - Changed: PM Pruning, Stats Updating and Session Expiring
               code now all use the same probability before processing
               rather than every 15 minutes.
    - Changed: Thread pruning now uses a slightly higher
               probability as it wasn't ever firing on Teh Forum.
    - Changed: bh\_user\_update\_time() function to use less
               queries.
    - Changed: POST\_ATTACHMENT\_FILES table format changed
    - Changed: Switched join on thread and pm has\_attachment
               functions to make better use of the primary keys on
               PM\_ATTACHMENT\_IDS and POST\_ATTACHMENT\_IDS.
    - Changed: Removed join on THREAD table from poll display.
    - Changed: Removed KEYWORDS column from SEARCH\_RESULTS
               table and moved data to LAST\_SEARCH\_KEYWORDS in
               USER\_TRACK.
    - Changed: Call me nuts if you want but I've changed
               referrer back to referer. Spelt wrongly but correctly
               according to HTTP specification.
    - Changed: Limited bh\_delete\_expired\_sessions to 10 at a
               time to prevent the user who gets lumbered with the
               delete from waiting for the page to load.
    - Changed: User session length tracking now works for
               users who have browse anonymously switched on.
    - Changed: Removed WHERE from query that updates
               UNREAD\_PID and UNREAD\_CREATED columns so they always
               get updated!
    - Changed: Prevented guests from spoofing the thread list
               to get it to load thread types they can't view.
    - Changed: Added checks for guests and use shorter less
               complex queries with no relationships, interest or
               unread data.
    - Changed: Unread thread views limited to a maximum cut
               off period allows USER\_THREAD table to be pruned.
    - Changed: Updated English and German languages.
    - Changed: Updated en-us and x-hacker language files.
               fr-ca and de to come soon.
    - Changed: bh\_check\_languages now orders the problems it
               finds so it groups together missing strings,
               untranslated, unneeded, etc.
    - Changed: More comprehensive bh\_check\_languages.php
               script which can selectively turn on or off checking
               for untranslated strings.
    - Changed: bh\_ms\_word\_spelling\_check.php now writes the
               changes to en-new.inc.php rather than requiring you to
               do the changes manually.
    - Changed: Updated fr-ca translation.
    - Changed: Format of table key arrays changed so we can
               create named indexes so we don't create duplicate
               indexes on tables.
    - Removed: UTF-8 Page encoding. No idea how to fix the RSS
               output. Might just give in and flag it as a known
               issue.
    - Removed: Guest Auto logon optionas it doesn't work with
               the new session code where everybody is a guest even if
               they have a saved logon.
    - Removed: Unused logon error URL query when invalid
               username and password.
    - Removed: Useless call to thread\_can\_view which was
               pretty much duplicating the query in thread\_get.
    - Removed: thread\_can\_view function removed from
               thread.inc.php.
    - Removed: Undone the changes in the previous commit to
               the PM and thread have\_attachments functions.
    - Removed: CGI installer because it didn't work and was
               never maintained and was unsupported. Sorry peeps.

## What's new in 0.6.3 (Released 12th February 2006)

- Notes

    - BeehiveForum 0.6.3 fixed a few issues highlighted within
      the release of 0.6.2. For more detailed
      features of 0.6.2 please see the 0.6 release notes.

- Changes from 0.6.2

    - Fixed: html\_draw\_top() and html\_draw\_bottom() are now used for
             the frames pages (admin.php, discussion.php, index.php,
             start.php and user.php) so we correctly add the forum
             description and RSS feed links rather than the generic
             Beehive ones.
    - Fixed: Second attempt at fixing the error when updating your
             user prefs. Not even sure that the first patch didn't fix
             it to be honest.
    - Fixed: Added some code to disable register\_globals to prevent an
             exploit involving passing values in the URL
    - Fixed: Links pages weren't filtering the input correctly and
             were allowing HTML to be posted.
    - Fixed: potential exploit made available though page url var in
             admin.php
    - Fixed: Prevented the use of a hyphen in the forum webtag
             because it breaks things.
    - Fixed: Not being able to access restricted forum when access is
             applied correctly to user account.
    - Fixed: Clicking Change password / permissions button took you to the
             permissions page for the wrong forum.
    - Fixed: Removed align="middle" from images on all pages because they
             look out of place in the newer Gecko engine builds (FireFox 1.5)
    - Fixed: Thread list "there are no messages in this mode" text eas
             stuck to the bottom of the drop down in newer Gecko engine builds
             (FireFox 1.5)
    - Fixed: Missing html\_draw\_top() calls in edit\_signature.php when
             there is an error and also changed basetarget to \_blank so that when
             previewing signature any links open in new window/tab without the
             HTML needing a target attribute.
    - Fixed: Added tests for perm\_forumtools\_access() on post data so
             people can't send post data to change the user's nickname / password
             when they don't have access to it.
    - Fixed: forum settings array is constructed using only two queries
             now instead of 2 for current forum and another for global settings.
    - Fixed: Bug in admin\_user.php could allow user to loose access to
             Admin section on individual forums. Global perms were not affected
             by this bug.
    - Fixed: form\_quick\_button() wasn't looking at the right variable when
             you send it an array of var names and values
    - Fixed: Inconsistency in dictionary caused "(no suggestions)" to show
             when the dictionary had finished checking all words.
    - Fixed: Insert error when processing user post count when viewing a
             new user's (no posts) profile.
    - Fixed: Dictionary now works much better. It correctly matches words
             like couldn't, wouldn't and words in single quotes, it skips URLs,
             email address and HTML and doesn't corrupt unicode characters what
             so ever. It also correctly informs the user if there was no match in
             the dictionary instead of skiping over the word.
    - Fixed: Unicode characters were being corrupted by Javascript when
             sending the text back after using the dictionary.
    - Fixed: Emoticons and signature boxes couldn't be reshown once hidden
             on post, edit and pm\_write pages but reloading them made them show
             again.
    - Fixed: edit\_attachments.php was showing "Other attachments" in My
             Controls when it shouldn't.
    - Fixed: Removed debug code from forums.php
    - Fixed: Query being executed twice in when fetching forum list for
             'My Forums' and potentially undefined variable causing error.
    - Fixed: user\_stats.php no longer fetches the user prefs because it is
             told what to do by messages.php
    - Fixed: Undefined variable $install\_cgi\_mode when using the web
             interface to install.
    - Fixed: Attachment view count was incremented each time a thumbnail
             of an image was seen.
    - Fixed: load\_language\_file not working sometimes because of
             include\_once being used rather than include
    - Fixed: 404 page not found error when you click Continue upon
             finishing the install because you've just deleted install.php.
    - Fixed: Table structure for LINKS\_FOLDER had been mangled and was no
             longer allowing NULL on PARENT\_FID
    - Fixed: new-install.php no longer creates the old SEARCH\_KEYWORDS,
             SEARCH\_POSTS and SEARCH\_MATCH tables.
    - Fixed: wordwrap plan didn't work because it seems to trim lines it
             wraps on some OSes and not others?
    - Added: html\_draw\_top() now accepts a body\_tag argument which stops
             the function from drawing the body tag, as used in the frames pages.
    - Added: Favourites checkbox and button to Guest MyForums with an
             error about needing to login.
    - Added: Probability test to see if we should clean the stale user
             sessions. Defaults to 10% probability.
    - Added: Error out when ever the user's search query is affected by
             the MySQL full-text stop words
    - Added: User stats differentiates between you (shown in bold), other
             users and your friends (shown in italic) and includes tooltips which
             tell you that you are Invisible or not.
    - Added: By request search now tells you which words were invalid in
             your search query.
    - Added: Relevance to searches. BH doesn't do anything with it, but I
             might sneak something in before 0.6.2
    - Added: Drop down added to search results to allow quick switching of
             order and removed it from the actual search query.
    - Added: Post count caching to USER\_TRACK table to reduce the load
             caused by someone opening a user profile.
    - Changed: user\_font.php no longer loads the user's prefs as that
               part is handled by messages.php.
    - Changed: Made 06x upgrade script drop the SEARCH\_RESULTS table
               before attempting to create it.
    - Changed: Slight change to word wrapping in thread list and start
               page.
    - Changed: All pages now use our DTD. Can't get the W3 validator to
               see it though, but FireFox reports it is in Standards Compliance
               mode. Hmm.
    - Changed: bh\_check\_languages.php can now help to find strings which
               haven't been translated.
    - Changed: Removed call to threads\_any\_unread() in discussion.php,
               admin\_post\_approve.php, delete.php and edit.php
    - Changed: Only users who are perm\_forumtools\_access() can change
               another user's nickname and password.
    - Changed: bh\_session\_remove\_stale() is now only called when the
               user's session is about to expire.
    - Changed: Removed and / or based drop down from search and allow
               users to compose their own boolean searches.
    - Changed: Kick button is now available to global admins rather than
               just forum tools users
    - Changed: Dictionary is now case insensitive and with new primary
               key much quicker.
    - Changed: Removed count() query from thread\_has\_attachments and
               simply made it fetch the AID of the attachment
    - Changed: Removed count() query from thread\_any\_unread and made it
               fetch the TID.PID of the thread instead.
    - Changed: Encoding on some files changed to UTF-8 PC line endings
    - Changed: emoticon\_get\_sets() to have an optional function argument
               that hides the none and text emoticons
    - Changed: Attachments now sort alphabetically. Previously updating
               the attachment to say how many times it has viewed bumped it to
               the top of the list causing confusion when people pointed towards
               "attachment #1" rather than naming them by filename.
    - Changed: More tweaks to search which makes things a heck of a lot
               quicker!
    - Changed: Finding an old post to index is more friendly to the
               server hopefully.
    - Changed: Removed use of function \_in\_array() as defined in
               format.inc.php because it takes too long to process anything.
    - Changed: Updated language files.
    - Changed: Guests no longer help to index posts to help reduce load
               on server.
    - Changed: thread\_list.php and start\_left.php now wordwrap thread
               titles so they don't cause a horizontal scrollbar in the frame.
    - Changed: upgrade-06RC-to-06.php replaced with a generic script
               which will upgrade all 0.6 releases thus far to 0.6.2.
    - Changed: upgrade-05-to-06.php replaced with upgrade-05-to-062.php.
    - Changed: start\_form != start\_from.
    - Changed: robots.txt. 1st stage of Google Friendly Beehive.
    - Changed: Search now checks to see if it is running MySQL 4 and if
               so allows a choice between AND and OR based searches
    - Changed: Guests can no longer perform searches
    - Changed: Different way to check for results from user search which
               should be less server intensive.
    - Changed: Few more changes to the start\_main.php example script.
    - Changed: Removed gmmktime() and changed back to mktime() so we use
               the server timezone.
    - Changed: Removed all the search indexing code because it was a bad
               experiment that didn't work out. Going to concentrate of
               optimising BH to use MySQL FULLTEXT searches instead.
    - Changed: \_htmlentities now leaves single-quotes alone so they
               won't get mangled in the database.
    - Changed: search\_index.php now says which post it has just indexed.
    - Removed: search\_min\_word\_length setting as BH now uses the MySQL
               defaults (for MySQL &lt; 4.0 the values are fixed at 4 and 84)
    - Removed: Text at bottom of search dialog is no longer relevant
               because BH now errors out instead.

## What's new in 0.6.2 (Released 30th Nov 2005)

- Notes

    - BeehiveForum 0.6.2 fixes a few issues highlighted within
      the release of 0.6 and 0.6.1. For more detailed
      features of 0.6.2 please see the 0.6 release notes.

- Changes from 0.6.1

    - Fixed: Query being executed twice in when fetching forum list for 'My Forums' and
             potentially undefined variable causing error.
    - Fixed: Undefined variable $minimum\_post\_frequency in check\_search\_frequency()
    - Fixed: admin\_forum\_links.php reset button weren't being translated.
    - Fixed: admin\_make\_style.php "this colour" and "new" weren't being translated.
    - Fixed: Undefined index AID in create\_poll.php, lpost.php and pm\_write.php
    - Fixed: $page\_var not being used correctly in page\_links() function
    - Fixed: page\_links() now correctly checks for a URL query before deciding if it
             needs to use &amp; or ? to add the $page\_var
    - Fixed: Keep reading button wasn't working correctly in polls due to missing
             &lt;/form&gt; tag.
    - Fixed: Page layout issues in Opera. Crazy stinking browser still center aligns
             text in a table that has been position within a div??
    - Fixed: load\_language\_file not working sometimes because of include\_once being used
             rather than include
    - Fixed: UTF-8 encoding in dictionary fixed.
    - Fixed: Dictionary now skips works that fail the metaphone conversion.
    - Fixed: Search limiting by username now works again.
    - Fixed: Regular expression incorrectly matching 9-\_ rather than 0-9.
    - Fixed: URL incorrect for Canadian-Politics.com. Sorry Jo! :)
    - Fixed: Forum shown was always the default forum even if the webtag was valid.
    - Fixed: My Forums page was sometimes missing the message count / not showing 0
             messages.
    - Fixed: Missing SEARCH\_RESULTS table when performing a new installation of
             BeehiveForum 0.6 or upgrading from a 0.5 installation.
    - Fixed: Missing FORUM column in SEARCH\_RESULTS table when upgrading from 0.6RC1 /
             RC2 to 0.6 final.
    - Fixed: Forum level admins were able to remove the global privilleges of another
             user without having global forum privilleges themselves.
    - Fixed: Upgrading from 0.5 to 0.6 sometimes results in an error with primary keys
             on SEARCH\_POST table.
    - Fixed: Buffer error occured when using MSIE browser and being forced to download
             the config.inc.php when installing Beehive.
    - Fixed: admin\_banned.php wasn't allowing wildcard in ban list entries
    - Fixed: Removed align="middle" from images on all pages because they look out of
             place in the newer Gecko engine builds (FireFox 1.5)
    - Fixed: Thread list "there are no messages in this mode" text eas stuck to the
             bottom of the drop down in newer Gecko engine builds (FireFox 1.5)
    - Fixed: Missing html\_draw\_top() calls in edit\_signature.php when there is an error
             and also changed basetarget to \_blank so that when previewing signature any
             links open in new window/tab without the HTML needing a target attribute.
    - Fixed: thread\_any\_unread not fetching the recent modified unread thread.
    - Fixed: Missing / undefined language strings in various files.
    - Fixed: Added tests for perm\_forumtools\_access() on post data so people can't send
             post data to change the user's nickname / password when they don't have
             access to it.
    - Fixed: Double escaped $forum\_name when adding a new forum.
    - Fixed: forum settings array is constructed using only two queries now instead of 2
             for current forum and another for global settings.
    - Fixed: undefined variable $old\_t\_sticky / $old\_t\_closed and related variables.
    - Fixed: Bug in admin\_user.php could allow user to loose access to Admin section on
             individual forums. Global perms were not affected by this bug.
    - Fixed: form\_quick\_button() wasn't looking at the right variable when you send it
             an array of var names and values
    - Fixed: Thread list drop down was sticking to the top most folder.
    - Fixed: Group by thread wasn't working and order by was back to front.
    - Fixed: Sorting by columns on admin\_viewlog.php wasn't working as expected.
    - Fixed: Inconsistency in dictionary caused "(no suggestions)" to show when the
             dictionary had finished checking all words.
    - Fixed: Insert error when processing user post count when viewing a new user's (no
             posts) profile.
    - Fixed: Dictionary now works much better. It correctly matches words like couldn't,
             wouldn't and words in single quotes, it skips URLs, email address and HTML
             and doesn't corrupt unicode characters what so ever. It also correctly
             informs the user if there was no match in the dictionary instead of skiping
             over the word.
    - Fixed: Unicode characters were being corrupted by Javascript when sending the text
             back after using the dictionary.
    - Fixed: Emoticons and signature boxes couldn't be reshown once hidden on post, edit
             and pm\_write pages but reloading them made them show again.
    - Fixed: Errors in display\_emoticons.php when trying to view invalid emoticon sets.
    - Fixed: edit\_attachments.php was showing "Other attachments" in My Controls when it
             shouldn't.
    - Fixed: error in checkdate when not entering birthdate.
    - Fixed: layout issue in forums.php
    - Fixed: undefined index NUM\_MESSAGES when searching for a forum.
    - Fixed: Problem when trying to upgrade 0.6RC forum to 0.6 final.
    - Fixed: Missing \_htmlentities and \_stripslashes in form\_hidden\_array()
    - Fixed: Table structure for LINKS\_FOLDER had been mangled and was no longer
             allowing NULL on PARENT\_FID
    - Fixed: Debugging code in session.inc.php
    - Fixed: new-install.php no longer creates the old SEARCH\_KEYWORDS, SEARCH\_POSTS and
             SEARCH\_MATCH tables.
    - Fixed: Array to string conversion in attachments.inc.php
    - Fixed: Searching for keywords and limiting by user wasn't working as expected.
    - Fixed: &#037; (single-quote) etc chars not displaying correctly in RSS Feed.
    - Fixed: Search results not actually sorting by the method picked by the user
    - Fixed: Missing space in attachment tooltip
    - Fixed: Search indexing was only ever indexing the first forum created.
    - Fixed: search\_index\_old\_post() was tripping up over threads which were lost but
             still had records in the database.
    - Fixed: wordwrap plan didn't work because it seems to trim lines it wraps on some
             OSes and not others?
    - Fixed: Default values in beehive-frameset.dtd needed to be in quotes.
    - Fixed: Some bugs in the example start\_main.php
    - Fixed: Dictionary now correctly skips over web addresses and email addresses.
    - Fixed: Missing dependencies on post.inc.php and geshi.inc.php fixed.
    - Fixed: Old style include('./include/file.inc.php') in search.inc.php replaced with
             BH\_INCLUDE\_PATH.
    - Fixed: Unknown column TID when deleting a message.
    - Fixed: attachments owned by a moderator / admin were being logged in the admin log
             when deleted. Changed so that only attachments not owned by the moderator /
             admin are logged when deleted.
    - Fixed: Bug in attachments when thumbnail could not be read (i.e. corrupted file,
             permissions error, locked file, etc).
    - Fixed: Stream lined the number fo queries that $dictionary-&gt;word\_get\_suggestions()
             makes by checking that the word we're checking is well formed first.
    - Fixed: Dictionary would take forever to find and replace all word matches and time
             out.
    - Fixed: Dictionary now correctly identifies html tags and doesn't check them.
    - Fixed: Extra single-quote characters in english.dic
    - Fixed: Dictionary now correctly splits words in single-quotes but doesn't split
             words like wouldn't, couldn't aren't, can't, etc.
    - Fixed: Error when editing a post that has not been indexed yet.
    - Fixed: Error when folder has no ALLOWED\_TYPE set.
    - Fixed: Upgrading from 0.5 to 0.6 and doing a new install of 0.6 should create 99%
             identical tables now.
    - Fixed: Text emoticons wasn't being listed in emoticon drop down on
             forum\_options.php or admin\_forum\_settings.php
    - Fixed: Your couldn't select "None" as the default emoticon type in
             admin\_forum\_settings.php
    - Fixed: Some errors with PHP 5.0 with user\_update\_prefs.
    - Fixed: top.html and stylesheet not being selected correctly when no default forum
             / no webtag
    - Fixed: bug in emoticons caused them not to work correctly for some users and
             guests.
    - Fixed: duplicate users in visitor log / recent visitors in drop down on post page.
    - Fixed: Geshi has some bugs which we need to work around. Stole the old trick that
             we used to use for Beautifier.
    - Fixed: Can't post when ALLOWED\_TYPES in FOLDER table is null.
    - Fixed: bh\_session\_check() was being called twice by the thread list once by itself
             and again by the RSS feed checker
    - Fixed: Added an @ on line 153 of forum.inc.php to suppress warning when no default
             forum and no ?webtag in querystring. This might be a dirty way to fix it,
             but i can't see why it'd break anything?
    - Fixed: Uploading a 0 byte startpage causes the admin script to always fail there
             after.
    - Fixed: Searching using AND based search was returning no results!
    - Fixed: Double frequency time being applied to post restriction.
    - Fixed: Problem with MySQL server being in different timezone to Apache resulted in
             post and search frequency never allowing a user to post/search or
             post/search more frequently than they should.
    - Fixed: POST\_COUNT column was being updated twice when a user posted for the very
             first time.
    - Fixed: check\_post\_frequency() and search\_check\_frequency() were both breaking if
             the server time changed to be behind the user's last post. Both functions
             now check to see if the frequency is set to 0 (disabled) before checking.
    - Fixed: search.inc.php couple of bugs in new frequency test code - line 621
             incorrect var name $minimum\_post\_frequency, assumed it should be
             $search\_min\_frequency, changed. Similarly, line 630, $last\_search\_check,
             assumed it should be $last\_search\_stamp, changed.
    - Fixed: Removed debugging code (oops!) and fixed missing semi-colon from query
             resulting in error.
    - Fixed: Relevance wasn't being calculated correctly due to missing IN BOOLEAN MODE
             in SELECT.
    - Fixed: thread list was showing unread threads when there were none because
             threads\_any\_unread() wasn't accounting for ignored completely users.
    - Fixed: Incorrect arguments foreach on line 565
    - Fixed: parse error in en.inc.php
    - Fixed: Search tables inconsistencies across different upgrade paths.
    - Fixed: Added line to create post\_count in user\_track table, as in new-install.php.
    - Added: Favourites checkbox and button to Guest MyForums with an error about
             needing to login.
    - Added: img { vertical-align: middle } to all CSS files.
    - Added: English US translation
    - Added: Script to find lang vars not defined in the default en.inc.php
    - Added: readme.txt updated with details about MySQL privs
    - Added: Probability test to see if we should clean the stale user sessions.
             Defaults to 10% probability.
    - Added: Error out when ever the user's search query is affected by the MySQL
             full-text stop words
    - Added: Link to allow the user to view the MySQL stop word list.
    - Added: User stats differentiates between you (shown in bold), other users and your
             friends (shown in italic) and includes tooltips which tell you that you are
             Invisible or not.
    - Added: Missing include to server.inc.php in db.inc.php
    - Added: Link to stop words list on search form.
    - Added: "Search Results" selection to thread list drop down.
    - Added: Relevance to searches. BH doesn't do anything with it, but I might sneak
             something in before 0.6.2
    - Added: Drop down added to search results to allow quick switching of order and
             removed it from the actual search query.
    - Added: english.dic didn't have I'm in it and lots of people had added it on Teh...
    - Added: Further explanation to search\_index.php about being able to use webtag on
             the CLI
    - Added: Return-path header to email functions. Seems to do nothng for tehforum but
             it has no negative effect either.
    - Added: Made Beehive check the arv array for a webtag so you can now call BH's
             scripts from the CLI (webtag must be 1st arg!)
    - Added: Post count caching to USER\_TRACK table to reduce the load caused by someone
             opening a user profile.
    - Added: Missing xhtml-lat1.ent, xhtml-special.ent, xhtml-symbol.ent to CVS. Don't
             really know if I should be including this or if I can reference them in the
             HTML. Anyone know?
    - Added: You can now make BH dump a query log for each file by creating a PHP
             writable directory called db\_logs in the forum folder.
    - Added: The and They to dictionary.
    - Added: Function to fetch the full text min and max word lengths from the MySQL
             server itself.
    - Added: Functions in preperation from thread splitting functionality for 0.7
             release.
    - Added: POST\_COUNT column to installer and upgrade script. CVS should work again
             now!
    - Added: missing semi-colon on end of height attribute in .pmhead class.
    - Removed: Text at bottom of search dialog is no longer relevant because BH now errors
               out instead.
    - Removed: Unused argument from format\_date() function in format.inc.php
    - Removed: RSS error handler
    - Removed: Debugging code from dictionary.
    - Removed: search\_min\_word\_length setting as BH now uses the MySQL defaults (for MySQL
               &lt; 4.0 the values are fixed at 4 and 84)
    - Removed: Unneeded install\_* classes from the provided stylesheets.
    - Removed: Copy of put\_per\_forum\_custom\_styles\_in\_here

## What's new in 0.6.1 (Released 22nd Aug 2005)

- Notes

    - BeehiveForum 0.6.1 fixes a few issues highlighted within
      the final release of 0.6. There are no functional changes
      to the software at this time. For more detailed features
      of 0.6.1 please see the 0.6 release notes.

- Changes from 0.6

    - Fixed: Forum level admins were able to remove the global
             privilleges of another user without having global
             forum privilleges themselves.
    - Fixed: Upgrading from 0.5 to 0.6 sometimes results in an
             error with primary keys on SEARCH\_POST table.
    - Fixed: Buffer error occured when using MSIE browser and
             being forced to download the config.inc.php when
             installing Beehive.
    - Fixed: Forum shown was always the default forum even if the
             webtag was valid.
    - Fixed: My Forums page would not display the message count on
             the forum if the forum had no messages or the user
             had not previously visited the forum.
    - Fixed: Missing SEARCH\_RESULTS table when performing a new
             installation of BeehiveForum 0.6 or upgrading from
             a 0.5 installation.
    - Fixed: Missing FORUM column in SEARCH\_RESULTS table when
             upgrading from 0.6RC1 / RC2 to 0.6 final.

## What's new in 0.6 ("Honey Lingers", released 18th Aug 2005)

- Notes

    - BeehiveForum 0.6 introduces a new search indexing procedure
      which will unfortunately skew the search results of your forum
      while it catches up and performs the indexing. If you have a
      lot of posts this will take a long time to complete. To help
      reduce the time required in the indexing your old posts,
      included is search\_index.php which is suitable for running
      from a cron or schedule job. Posts created after upgrading
      to 0.6 will be indexed as they are created.

    - New Admin logging options require 0.6 to clear your current
      Admin Log before upgrading. This is at the expense of
      improved logging. If you want to keep your old logs please
      view and save the HTML output or export the ADMIN\_LOG table
      for each forum.

- Brand new features

    - Installation can now be completed via CLI over telnet / SSH.
    - RSS Feed propagation allows the replication of an RSS feed
      into threads on your forum. Useful for news headlines from
      other sites to promote discussion.
    - Added constant for the include files path so that developers
      can reuse the Beehive include files while placing their own
      scripts outside of the main forum folder.
    - Post Approval options allows moderators to optionally approve
      posts before they are displayed to other users.
    - Email address confirmation for new user registrations.
    - Text Captcha options for new user registrations to help
      prevent scripts and bots from creating user accounts.
    - TinyMCE WYSIWYG integration with BeehiveForum's compose
      pages.
    - French Canadian (fr-ca) language file. Thanks to Jo from
      Canadian Politics Forums <http://www.canadian-politics.com/>
    - Forums can be opened, closed, restricted or password protected
      without requiring access to the 'Manage Forums' section. A new
      option allows a user with access to the 'Manage Forums' section
      to disable a forum which will hide it from the My Forums list
      as per 0.5's behaviour.
    - WikiWiki integration allows Beehive to automatically hyperlink
      CamalCase words as used by most popular Wiki sites.
    - Wiki-esq quick links for linking to a specific post using
      msg:1.1 or to user's profile using user:Logon.
    - Attachments allow for the creation of thumbnails in posts for
      supported file types (*.png, *.jpg, *.gif). Requires GD library
      to be compiled in with PHP.
    - New option allows all other users to edit a PILLORIED users
      posts without having to be given moderator privileges.
    - Added user tracking and limitations to restrict how often users
      can post and perform searches.
    - New User Registrations can now be disabled.
    - Added option to prevent spidering of forums by adding the
      appropriate noindex,nofollow meta tags to the HTML generated
      by Beehive.
    - Added options to enable or disable the links and Personal
      Messages sections and correctly prevent access to the related
      pages.
    - Added option to specify the forum time zone and day light saving
      mode independently of the server clock and user time zone.
    - Added option to prevent users from ignoring admin.
    - Default New User registration settings including email notification
      PM notification, etc. can be defined in Global Forum Settings.
    - Added &lt;label for=""&gt; to checkboxes and radio buttons which allow
      for clickable text to toggle form elements.
    - Added post stats page to Admin tools which can be used to find
      the Top 20 posters during specified period.

- Enhanced old features

    - Greatly improved Unicode UTF-8 support which should make it
      possible to type in different alphabets in the same post.
    - Improved user permissions handling to be more consistent and
      less prone to problems. A lot of the niggles you've all
      encountered with 0.5's permissions should be fixed in 0.6.
    - Ban controls now allow banning of IP Addresses, Logons,
      Nicknames and email addresses, all by wildcard matching.
    - Better search indexing added which generates less load on
      MySQL
      server when a user performs a search.
    - Better Admin log with less possibility for display of Unknown
      User, Unknown Thread / Post, etc.
    - Added ability for Admin to change user's password.
    - Re-added User Alias list on User page, but removed IP banning
      option as this is now handled by the new Ban Controls section.
    - Dictionary now skips HTML tags and entities and is otherwise
      more precise in matching whole words.
    - Links and Link folders are now sorted alphabetically by
      default.
    - Replaced Beautifier with Geshi - Generic Syntax Highlighter.
    - Improved user permissions allow for separate Links section
      and Post moderators as well as better global Admin who
      can optionally moderate over all forums.
    - Improved emoticons support makes it easier to create and
      distribute emoticon packs that are easy to install.
    - Attachments now always open in a new window / tab.
    - New improved attachments popup with G-mail-a-like multiple
      file uploads.
    - Light mode now uses the Forum Name in the logon page to indicate
      the name of the forum you are visiting.
    - Images to links option will now convert embedded files including
      Shockwave and Flash files.
    - Added Logon and User UID to top of Edit Preferences page.
    - Removed all inline CSS and replaced it with class names which
      can be more easily modified in your style sheets.
    - Greatly improved the start page editor and style sheet editor
      with more useful error messages and help for write protected
      files and folders.
    - Added Deleted by text and time / date stamp on deleted messages.
    - Prevented users from blocking moderators and stopping them
      from sending them PMs.
    - Fixed sending an email to a user via their profile always
      said "Sent by X from a Beehive Forum"
    - Better session handling code allows users to logout correctly
      and appear logged out on the Recent Users display.
    - Better detection for when a user's session expires, giving them
      more control over logging back in with minimal fuss.
    - Fixed all user preference updates so they don't affect all
      forums. Changing things like post page settings, font size,
      toggling stats display now only affects the forum a user is
      currently visiting rather than all of them.
    - Re-added display of Guests to Recent Visitors list.

- General Bug fixes

    - Fixed call to undefined function user\_change\_pw() fixed. A
      patch is also available to fix separately this problem in 0.5
    - Fixed call to undefined function gzcompress() when GZIP
      compression was enabled on a PHP installation that was compiled
      without ZLIB.
    - Lots of IIS server fixes.
    - Lots and lots more!

- Known issues

    - Threads created from RSS Feeds are known to have problems
      with some characters displaying incorrectly where the
      character encoding of the feed is different to that of
      the output generated by the BeehiveForum software.
    - Incorrect HTML contained within RSS Feeds will be rendered
      correctly (shown as HTML entities) due to aggressive checking
      used by BeehiveForum to make sure broken HTML doesn't break
      the display of the messages.

- Changes from 0.6RC2

    - Added: 4th table to search (SEARCH\_RESULTS) which stores a
             users search results for quicker retrieval across
             result pages and to get around the problem with the
             search frequency.
    - Added: Upgrade script for 0.6RCx (will work for both RC1 and
             RC2) to upgrade to 0.6 Final when we release it.
    - Added: Option to mark as read a selected folder (*)
    - Fixed: undefined index 6 in attachments.inc.php when creating
             a thumb nail for unsupported image type.
    - Fixed: Outer Join error in search query when performing an OR
             based search.
    - Fixed: Error with undefined index msg in admin\_banned.php
             when not specifying the URI query correctly.
    - Fixed: Undefined variable $result\_threads in threads.inc.php
    - Fixed: install.php was not using it's own error message for
             database connection problems.
    - Fixed: blank page error when reading emoticon directories on
             some PHP versions caused by error suppressant being in
             wrong place.
    - Fixed: text\_captcha class reporting incorrect error message
             or no error when there was an error.
    - Fixed: old style include path links for file\_exists check on
             config.inc.php
    - Fixed: Links drop down still displaying if table was empty /
             there were no links.
    - Fixed: forums page showing 0 unread threads if you've never
             visited the forum in question
    - Fixed: Differentiated between Downloaded: 1 time and
             Downloaded: x times for foreign langs.
    - Fixed: months not displaying correctly as per bug #1227704
    - Fixed: edit\_prefs.php not accepting a hyphen in PIC\_URL and
             HOMEPAGE\_URL.
    - Fixed: Undefined variable $result in threads.inc.php.
    - Fixed: Undefined property $this-&gt;emoticons.
    - Fixed: Undefined index PRIVACY and redone how the form checks
             the checkboxes for privacy
    - Fixed: final\_uri error in forums.php that allowed the
             exclusion of an foreign web site.
    - Fixed: Prevented error handler from revealing path of files
             on server.
    - Fixed: Prevented direct access to include files. All redirect
             back to index.php now.
    - Fixed: webtag is now checked against a regular expression to
             prevent SQL injection / xss eploits
    - Fixed: Undefined constant BH\_INCLUDE\_PATH in search\_index.php
    - Fixed: Undefined index UID in user.inc.php
    - Fixed: english.dic was corrupted most of the way through. No
             idea how that happened, but it did. SF to blame maybe?
    - Fixed: User:Logon and Msg:1.1 WikiLinks were broken
    - Fixed: Added extra precaution against SQL injections in
             webtag functions.
    - Fixed: My Forum page getting folder list for current forum
             rather than the actual forum we're trying to get
             unread messages from.
    - Fixed: My Forum page always showing 0 unread messages when
             there were some.
    - Fixed: Password protected forum will now only prompt for
             password if the password has been entered and is the
             minimum length.
    - Fixed: Unknown error [8] ob\_flush(): failed to flush buffer.
             No buffer to flush (maybe)
    - Fixed: Light mode not saving password correctly.
    - Fixed: IP address in post not being a link if the user is
             both a moderator and has access to the Admin tools.
    - Changed: Path in bh\_find\_deprecated\_language\_strings.php
               changed so it works with a relative path so everyone
               else can use it.
    - Changed: Removed scripted file types from upload dialog on
               admin\_startpage.php. It will now only accept *.txt,
               *.htm and *.html
    - Changed: Added IP Address display with link to
               admin\_banned.php to admin\_user.php
    - Changed: Added check for unban\_ipaddress on URL query which
               automatically highlights the banned address in
               admin\_banned.php.
    - Changed: All preg\_match calls have been changed to check the
               number of matches rather than assume true / false
    - Changed: bh\_setcookie() now matches many schemas by using a
               regular expression.
    - Changed: Reworded the help text for $cookie\_domain and
               $gzip\_compress\_output in config.inc.php.
    - Changed: Updated language files and removed unneeded strings.
    - Changed: Optimised the visible discussions mark as read so
               the tidarray contains the TID and LENGTH so we don't
               have to query to fetch them.
    - Changed: edit\_prefs.php so it keeps the entered user data
               even if it contains an error so that the user can
               correct it without having to completely retype it.
    - Changed: Made admin\_user\_groups table wider
    - Changed: Added missing $Id lines from rss\_feed.inc.php,
               htmltools.inc.php and geshi.inc.php
    - Changed: Added forum ID to search query for future
               compatibility.
    - Changed: Removed $admin\_nickname and changed query that
               creates user account to use MySQL's UPPER() function
               instead.
    - Changed: SEARCH\_RESULTS table added to new-install.php
    - Changed: Language strings updated. Better grammar and
               spelling hopefully.
    - Changed: Mark as read function now fetch all the threads to
               mark as read first before passing them to
               message\_mark\_read.
    - Changed: Removed redirect on direct access from
               config.inc.php and constants.inc.php
    - Changed: Removed \_htmlentities\_decode calls from
               threads\_rss.php
    - Changed: Added functions to get a forum's WEBTAG and table
               prefix. Works the same as get\_table\_prefix but takes
               a forum id and queries the table rather than using
               the webtag URI query.
    - Changed: Users with forum tools permissions can access
               password protected forums without entering a
               password.

- Changes from 0.6RC1

    - Fixed: error handler falling over itself if the $\_POST
             variables contains an array. Handled by a function in
             form.inc.php that can be used by other scripts if
             required.
    - Fixed: error in get\_request\_uri which trips over $\_GET
             variable containing an array. Handled by a seperate
             function to the one in form.inc.php as this one is
             required to construct a URL query from them.
    - Fixed: post content preview was being chopped incorrectly in
             search results
    - Fixed: search was not working as expected when a user
             searched for words by a user and the word was in the
             MySQL stop list.
    - Fixed: redid all the transparency on all the Default style
             images and made sure they were 15x15 pixels.
    - Fixed: Several changes to make Beehive more friendly to
             non-english translations.
    - Fixed: attachments being deleted prevents moderators from
             gaining access to the edit attachments page of a post
             for another user.
    - Fixed: Made all edit pages check for and create an AID record
             in the relevant ATTACHMENTS table in order to prevent
             replacing it and loosing link between posts and
             attachments.
    - Fixed: pm\_save\_attachment\_id() causing problems when a PM
             already has an attachment ID. It now checks the
             database first same as post\_save\_attachment\_id does.
    - Fixed: all final\_uri queries now check to make sure the
             string is longer than 0 chars.
    - Fixed: exploit in final\_uri that allowed people to load
             another website into the discussion frame of Beehive.
    - Fixed: grammar error in "You have 1 a new PM" language
             string.
    - Fixed: PM's always showing as having attachments. Added a new
             function to pm.inc.php called pm\_has\_attachments()
             which will actually check the POST\_ATTACHMENT\_FILES
             table for attachments same as the
             thread\_has\_attachments() does.
    - Fixed: user\_get\_aliases() no longer include empty IPAddress
             matches in the check.
    - Fixed: moved USER\_PREF modifications out of 0.5-to-0.6
             upgrader foreach loop into main part of installer so
             they are only performed once.
    - Fixed: undefined variable $db\_post\_save\_attachment\_id on line
             722 of pm.inc.php
    - Fixed: logon drop down not working on expired session page.
    - Fixed: missing [1 new from thread list.
    - Fixed: Guest error login link loosing URL query due to it not
             being encoded correctly.
    - Fixed: [x new of y] wrapping incorrectly by adding
             white-space: nowrap to CSS
    - Fixed: "Ararar" error message in thread\_options.php
    - Fixed: missing rawurlencode call in parse\_url function which
             broke the ?msg thing in email links.
    - Fixed: emoticon "none" setting not working.
    - Fixed: session failure page choking on $\_POST being a
             multi-dimensional array.
    - Fixed: threads\_any\_unread() not checking if the user had not
             seen the thread before at all.
    - Fixed: bug with undefined index PATH\_INFO in html.inc.php
    - Fixed: light mode always remembering password even when
             tickbox unticked.
    - Fixed: logging in from light mode and then visiting the full
             mode triggers showing the logon dialog even though
             you've never visted it before.
    - Fixed: static webtag in poll.inc.php and upgrade-05-to-06.php
    - Fixed: undefined variable $lang in poll.inc.php
    - Fixed: Removed erranous space from end of constants.inc.php
             that trips up if the output buffering is disabled.
    - Fixed: undefined variable $settings\_array in forum.inc.php
    - Fixed: undefined $db\_install in forum.inc.php
    - Fixed: removing a forum didn't remove the RSS\_FEEDS and
             RSS\_HISTORY tables for that forum
    - Fixed: header\_redirect problem when msie\_buffer\_fix() is
             called producing output before headers
    - Fixed: undefined variable $chunks\_array in format.inc.php
    - Fixed: undefined variable $chunks in format.inc.php
    - Changed: Simplified the calls to the email notification
               functions requiring a msg and splitting it into
               tid.pid when the function is called by joining
               the tid & pid!
    - Changed: RSS feed now duplicates the headline in the quote
               tag so if it gets truncated by Beehive's 64 char
               limit on thread titles we still get to see it all.
    - Changed: All '{$table\_data['FID']}' changed to $forum\_fid
               to make things neater and easier to understand.
    - Changed: Truncating of RSS thread title now works the same
               as the search results.
    - Changed: Reformatted user\_profile.php page so it should
               display better.
    - Changed: Added error checking to installer/upgrade scripts.
    - Changed: Made the Find button on the Advanced Search form
               auto-re-enable when the search results have
               successfully loaded.
    - Changed: logon.php and logout.php to not use the expired
               session page. Makes sense, no?
    - Changed: Removed &lt;bdo&gt; tags from thread\_list.php
    - Changed: Added CDATA tags to the &lt;title&gt; element of the RSS
               Feed which should help with FireFox not being able
               to use the output.
    - Changed: Added an exclude\_keys array list to
               form\_input\_hidden\_array so you can specify named
               keys to skip.
    - Changed: Added \_array\_chunk function which mimics
               PHP &gt; 4.2.0's own function.
    - Changed: search indexing to ignore keywords with numerals
               only (like: '000', '999', '911', '666' etc)
    - Changed: search indexing now chunks the keywords and
               performs multiple queries in chunks of 20 keywords
               in order to stop MySQL failing when the number of
               words to index in one query is greater than the
               highest extended query count.
    - Changed: Removed directory creation functionality from
               admin\_default\_forum\_settings.php and added a
               function that is called by the script and all
               the other attachment scripts to check and create
               the directory. The text captcha class already does
               this.
    - Changed: Removed all the width and height attributes from
               image tags to stop those images which are larger
               or smaller from being resized by the browser.
    - Changed: Added optional UID argument to all the perm\_*
               functions that require it.
    - Changed: Added optional argument to disable ip address
               logging as used by the RSS feed
    - Chamged: Added extra index to USER\_POLL\_VOTES (TID,
               OPTION\_ID) to improve poll performance
    - Changed: RSS Feed so it only fetches 10 feed items per update

## What's new in 0.5 ("What You Have Is Enough", released 10th Dec 2004)

- Notes

    - Beehive Forum 0.5 corrected a very large scale problem with
      stripslashes which means that content created with prior
      versions may be subject to erroneous display once you
      upgrade to 0.5.

- Brand new features

    - Multiple Forum support. Yes, finally you can run more than
      one forum on your web space using a single Beehive
      installation, under a 'My Forums' linking system.
    - Forums can be open/closed/restricted/passworded.
    - Install/upgrade script simplifies installation process.
    - Comprehensive user permissions - users can be given/denied access
      to post/read/moderate etc. in specific folders, as well as having
      HTML/sig privileges given/denied.
    - As well as per-folder moderators, a user can be assigned as a
      'Global moderator', who can moderate in all folders.
    - User groups can be created to help moderation of large forums.
    - New 'Forum Links' drop-down in the top frame allows for linking
      other Beehive forums and sites easily.
    - New 'My Controls' replaces the old preferences and profile
      sections, incorporating them into a single location.
    - Emoticons. Really fancy emoticons. With per-user options to
      display
      any of several graphical sets, or plain-text, or nothing at all.
    - Emoticon preview pane on post page for quick reference.
    - Users can now perform basic moderation duties on their own
      posts on the new 'Thread Options' page, including changing
      the thread title and moving the thread to different folders.
      Admins can prevent this functionality by 'edit locking' the
      thread to prevent it from being changed.
    - Users can access 'Thread Options' by clicking the icon to
      the left of every thread title in the thread list frame.
      From here a thread can be ignored without ever reading it.
    - Posts can now be marked as unread, for later reading.
    - New 'Reply as PM' link on every post will quickly create a new PM
      addressed to the post author, with the thread title as the subject.
    - Number of PMs per user can be restricted by the admin.
    - PM auto-pruning - messages not in the 'saved' folder can be
      automatically deleted after a certain time has passed.
    - Option to reply a PM with the in-reply-to PM's text quoted.
    - New user option to change all images embedded into a post by
      users (inc. signature images) into clickable links.
    - 'Reply to all' allows a user to reply to an entire thread instead of
      a specific post.
    - New tabular polls to compare votes from different poll groups.
    - Quick search.
    - Per-user word filter.
    - Beautifier (www.beautifier.org) integration with BH &lt;code&gt; tag.
    - &lt;spoiler&gt; tag to hide text which may otherwise spoil that movie
      you're planning on seeing tonight's killer plot twist. &lt;spoiler&gt;He
      was dead all along!!&lt;/spoiler&gt;
    - &lt;noemots&gt; tag to prevent anything within it from being converted to
      an emoticon.
    - New post page preferences which allow you to toggle the HTML
      toolbar, the emoticons preview pane and the signature text
      field. You can also choose an HTML mode by default; you can
      choose to enable/disable emoticons in your messages by
      default and so on.
    - English Language Dictionary available from the HTML Toolbar
      which can be configured to auto-check spelling each time you
      post.
    - Guest account no longer requires cookies, so that search engines can
      spider Beehive forums. A robots.txt file is also included to help
      search engines spider the right content.
    - A user can now set their default start page to be the thread list in
      the left frame, and the forum start page in the right frame.
    - New thread\_rss.php allows recent Beehive threads to be loaded into
      an RSS reader.
    - Previous/next post navigation arrows.
    - 'Unread Today' threadlist filter option.
    - Admin tools to delete all a user's posts in a thread, or throughout
      the whole forum.
    - Admin option to delete an entire thread.
    - 'Ignore Completely' option allows you to ignore all posts to/from a
      user as well as any threads they create.

- Enhanced old features

    - HTML toolbar is now present for post creation; post editing;
      poll creation; signature editing; PM creation; PM editing;
      start page editing. Can't get enough of that HTML toolbar.
    - Slicker HTML integration - &lt;quote&gt;/&lt;code&gt;/&lt;spoiler&gt; tags won't show
      their innards, for example.
    - Better editing page. No longer will you have to toggle between a
      plain-text/HTML version of your post - BH will automatically
      approximoguesstimate what settings you originally posted your
      message with.
    - Polls can now be 'soft-edited' - minor edits which won't reset the
      votes.
    - Poll options can either be displayed as radio buttons (as before) or
      as a drop-down list.
    - Improved word filter that allows you to find and replace
      rather than obscure the filtered words with asterix.
    - Word filter can now be disable without having to clear the
      filter list of the current entries. Useful if browsing from
      different places such as home and work.
    - Many pages have had their output tweaked so they fit in with
      the overall style of beehive.
    - Attachments now support the uploading of multiple files at
      the same time. Useful for dial-up users who want to attach
      multiple files without having to do each file in turn.
    - The forum owner can now choose to have deleted attachments
      still show (with the link removed) in posts.
    - Alternative attachment method which allows Beehive to make
      use of the old 0.3 and older attachment retrieval method for
      servers that can't handle the newer method.
    - The search page has been remade with a better design and
      better functionality.
    - 'Page [1] 2 3 ...' on various pages rewritten a bit posher.

- Fixes

    - Lots and lots!

- Known Issues

    - Content created prior to the installation of 0.5 will be
      incorrectly escaped (all ' and " characters will appear as
      \'and \" respectively). This is due to a major bug in
      versions prior to 0.5 which meant content inserted into
      the database was double-escaped.

## What's new in 0.4 ("In The Flesh", released 10th December 2003)

- Brand new features

    - Personal Messages allow users to keep more private matters
      out of view from the rest of the forum members.
    - I18N multiple language support is now included with Beehive which
      allows Beehive to be viewed in a variety of languages. See
      readme.txt for more information.
    - New word filter allows forum admins to censor words using Perl
      Compatible Regular Expressions.
    - A style creator is now included to help you generate a random
      coloured style sheet for your forum.
    - All admin activities are now logged to a table in the database.
      The log is viewable from the admin options.
    - Stats display shows some basic stats such as the active users, the
      maximum number of users ever active, number of total posts and
      threads made and other such delights.

- Enhanced old features

    - New Post and Edit pages including intelligent HTML toolbar which
      allows for quick and easy creation of HTML posts without having
      to worry about paragraphs and other such things.
    - New Register page includes some basic options that people can
      set when they sign up.
    - Preferences page now remembers a users chosen settings if an
      error occurred on submit.
    - Preferences page has been restyled to fit in with the profile
      page better.
    - Sticky threads can now be created by forum admins.
    - Search page allows the results to be grouped by thread.
    - A minimum word length can now be applied to the search dialog.
    - New navigatable list style view added to the links page.
    - Attachments can no longer be embedded in posts, making them more
      narrowband friendly, more secure and less bandwidth hungry.
    - New cookie domain setting allows Beehive to set it's cookies so
      that they will work across all sub-domains of a web site.
    - Users can now choose to display their age and/or birthday in both
      their profile pop-up and also on the Start page.
    - Folders can now have a restriction placed upon them which prevents
      users from posting polls / posts in them.
    - Folders can now be re-sorted after creation.
    - Profile items and sections can be re-sorted.
    - Configurable Profile options allow you to specify some basic options
      for the profile page including the type of input field.
    - Groupable poll options allow users to create polls with different
      groups of answers.
    - Public Ballot polls allow the creation of a poll which can be used
      to display the username of each user under the option name they
      voted for.

- Fixes

    - High Interest, Unread High Interest, most recent discussion
      and other things which were not working under MySQL 4.0.13
      and later are fixed.
    - Some fixes to make Beehive more palatable with Microsoft IIS.
    - Folders were showing a thread count of 0 on threads which did
      actually contain some posts.
    - User custom selected font size now applies to all on-screen
      fonts. Smaller fonts are automatically scaled to the main
      font size used.
    - Some layout changes make Beehive look better on non MSIE
      based web browsers.

- Known Issues

    - Folders created under 0.3 or below which contained quotes
      will now display incorrectly in 0.4. You can fix this by
      visiting the admin folders option and fixing the folder
      names. This was due to a bug in previous versions which has
      now been fixed.

## What's new in 0.3.1 ("Beemused", released 3rd September 2003)

- New features / Enhancements

    - There are no new features or enhancements in this release.
      This release is primarily intended to fix some problems that
      exist in MySQL 4.0.13 and higher. Don't worry 0.4 will be
      coming soon!

- Fixes

    - Users lost access to restricted folders if they ignored them
    - Queen could loose her 'Queen' Status and be demoted to a
      soldier if he/she changed her own permissions through the
      Admin Users interface.
    - It was not possible to delete Profile Items and when deleting
      a Profile Section the wrong one was deleted.
    - Threads would not be visible at all regardless of folder
      interest settings under MySQL 4.0.13 and later
    - Recent discussions list on Start Page would appear empty
      under MySQL 4.0.13.

## What's new in 0.3 ("A little Beehind", released 11th February 2003)

- Brand new features

    - All output is now optionally gzip encoded to save bandwidth.
    - The styles system has changed a bit - the majority of the
      stylesheet is now static, which saves even more bandwidth.
    - You can modify the start page directly from the admin
      interface.
    - As well as ignoring a user, you can make them your "Friend",
      and filter the thread list to only show discussions started
      by Friends if you want.
    - New poll system, with up to 20 options per poll.
    - There's a new frame-less light HTML "diet" version of the
      forum
    - now you can browse and post from a PDA and some mobile
      phones.
    - A links section that allows your users to create a database
      of useful links.
    - You can see a list of possible aliases for any user (people
      who have logged in from the same IP address before)
    - Banning a user by IP address is now possible.
    - Option to delete all of a user's posts in the admin
      interface.
    - You can now ignore entire folders.

- Enhanced old features

    - Guest access is now optional.
    - Other changes to polls, such as the ability to post an
      explanatory message at the same time as you post the poll.
    - Various new UI stuff - friend / attachment icons in the
      thread list, link back to the voting form in a poll thread.
    - Polls are now slightly more anonymous (at least, it's not
      trivial for someone with database access to see how you
      voted, but neither is it secure).
    - Users can choose to be directed straight to the forum
      (bypassing the start page) when logging in.
    - The time a user last logged on and the total number of posts
      they have made on the forum are displayed in their profile.
    - You can now ignore only someone's signature, or globally
      ignore all signatures if you want.
    - Mark as Read has more options (all discussions, visible
      discussions, next 50 discussions)

- Fixes

    - We've given the code a spring clean - hopefully there are now
      no PHP errors/warnings/notices at all.
    - Various fixes to make things work properly with
      Microsoft-IIS.
    - Some fixes to properly support PHP 4.3.x.
    - Some of the database stuff (mainly thread list queries) has
      been optimised for efficiency.
    - Database errors are now caught in a nice way.
    - Some session handling improvements

## What's new in 0.2 ("Let It Bee", released 12th September 2002)

- User Selectable Styles: Forum members can now select from a number of
  styles to change the appearance of the forum. Pretty much everything
  can be styled, by editing the CSS files and altering the images.
- Polls: Polls are now enabled. They let people vote, and stuff.
- Attachments: Forum owners can optionally enable the attachments
  feature, allowing members to upload files to the forum server.
  Space available per member can be limited.
- Forgot password: Muppets who forget their passwords can now get an
  e-mail to the address they entered, with a link where they can reset
  the password.
- Guest access: Casual browsers can access forums as guests, but can
  not post.
- Lots of little things: Little enhancements here and there that just
  generally make things nicer. Like friend icons in the message view,
  and multiple logins being saveable.
- Discontinued undocumented features: Most of the undocumented features
  from 0.1 have been removed, such as the undocumented feature where
  fix\_html would occasionally loop until PHP timed out, and the famous
  "time-travelling" undocumented feature where post's creation times
  were updated when they were read by the user they were addressed to.
- New undocumented features: It is possible that the addition of the
  new documented features has resulted in the accidental addition of
  new undocumented features. If you believe you have found an
  undocumented feature, please let us know in the test forum at
  <http://beehiveforum.co.uk/forum>
- \o/ Domain name \o/: We got the domain name registered, so you can
  now use <http://beehiveforum.co.uk> for all your Beehive URL needs.
  It's still hosted on SourceForge <http://sf.net>, lovely people that
  they are.

## What's new in 0.1.1 ("Jump This Way", released 28th June 2002)

- Some fixes, as a result of the fact that we'd never tested 0.1 on
  Microsoft IIS :)

## What's new in 0.1 ("Don't Call Me Baby", released 26th June 2002)

- General forum functionality
- User administration (gag, ban, promote to moderator)
- Moderation (edit/delete/remove posts)
- Private folders
- Search
- HTML posting with full rigourous vaildation (you can't break the
  page)
- Editing posts
- Ignoring users/threads
- Email post notification
