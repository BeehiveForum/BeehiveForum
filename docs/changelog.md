# Beehive Forum Change Log (Generated: Sun, 11 Aug 2013 19:21:46)

## Date: Sun, 11 Aug 2013

- Changed: Use mysqli\_connect for Sphinxsearch, as it doesn't seem to
           work with mysqlnd.

## Date: Fri, 09 Aug 2013

- Changed: Enabled SSL support in SwiftMailer with an option in Global
           Forum Settings.
- Fixed: Global Forum Settings inaccessible if Sphinx functionality
         enabled without Sphinxsearch running.

## Date: Mon, 05 Aug 2013

- Changed: Always attempt to get the MySQL version in Error Handler.
- Changed: Go back to XHTML doctype.

## Date: Sun, 04 Aug 2013

- Changed: Error handler now uses var\_export instead of print\_r to
           aid quick copy-paste of super-globals for debugging.
- Changed: JavaScript tidy up.
- Changed: Code optimisation.
- Changed: Optimised CSS.
- Fixed: Uncaught exception in exception handler when querying for
         MySQL version.

## Date: Thu, 01 Aug 2013

- Fixed: Arguments to functions changes.

## Date: Wed, 31 Jul 2013

- Changed: Regex for Youtube CKEditor plugin changed to match extra
           query params in URL (version 2)
- Changed: Regex for Youtube CKEditor plugin changed to match extra
           query params in URL.
- Fixed: Edit using void result from message\_display.
- Changed: Increase minimum PHP version to 5.3.0 as 5.2.x is long
           discontinued and no longer supported by the PHP group.

## Date: Mon, 29 Jul 2013

- Fixed: Polls not displaying due to changes to MOVED\_TID and
         MOVED\_PID.

## Date: Sun, 28 Jul 2013

- Changed: Code clean-up using PhpStorm's code inspection.
- Fixed: Error in SQL when creating POST\_RATING table during upgrade.

## Date: Sat, 20 Jul 2013

- Changed: Use \_\_DIR\_\_ constant to prefix the BH\_INCLUDE\_PATH
           constant.

## Date: Fri, 19 Jul 2013

- Changed: Drop and recreate SESSIONS table on upgrade to add unique
           key to SID column.

## Date: Sat, 13 Jul 2013

- Fixed: Upgrade not creating new POSITION column in FORUM\_LINKS
         table.
- Fixed: Upgrade process wasn't correctly updating DEFAULT\_THREAD
         with approved / approved\_by state.
- Changed: Use a NOT IN clause to find non-contributing users for
           forum stats.

## Date: Sat, 06 Jul 2013

- Fixed: Undefined variable $fid in
         admin\_send\_link\_approval\_notification() in admin.inc.php.
- Fixed: Cannot change mysqli's constructor to protected. This might
         fix Beehive running on older PHP5 versions?
- Fixed: Undefined variable $result and $table\_prefix in
         forum\_search() in forum.inc.php.
- Fixed: Invalid arguments to array\_map in
         install\_check\_table\_conflicts() in install.inc.php.
- Fixed: Undefined variable $uid in post\_create() in post.inc.php.
- Fixed: Missing 3rd argument to socket\_create() in
         rss\_feed.inc.php.
- Fixed: Undefined variable $message in display.php.

## Date: Wed, 12 Jun 2013

- Fixed: Call to undefined function perm\_is\_group()

## Date: Tue, 11 Jun 2013

- Changed: Added styling to message ignored notification on Mobile
           mode.
- Fixed: Don't fetch message content if the sender has been ignored.
- Changed: Optimise the order in which the deleted/moved/approval and
           message manipulation is performed.
- Changed: Output of message moved has changed to match
           deleted/approval.
- Changed: Mobile mode message display now reacts the same was the
           full-fat mode does.
- Changed: Use is\_preview flag to determine what parts of a message
           to show. Fixes broken preview.

## Date: Mon, 10 Jun 2013

- Changed: Reduce size of approved messages notification on posts.
- Changed: Don't automatically show unapproved messages to moderators,
           it's confusing and means messages get missed.
- Changed: Updated dependencies.
- Changed: Upgraded SwiftMailer (although, not exactly many changes!)
- Fixed: Mobile mode displaying posts that should be ignored.
- Fixed: User query in Admin &gt; Users was forcing MySQL to use a
         temporary table.
- Changed: APPROVED, RELATIONSHIP AND EDITED are now null by default.

## Date: Sun, 09 Jun 2013

- Changed: Removed hide\_ip\_address argument to post\_create.
- Fixed: Errors in SQL caused by previously commited column default
         changes.
- Changed: Register form now allows CKEditor for signature.
- Changed: More default column type changes.

## Date: Sat, 08 Jun 2013

- Changed: Reimplement remove user\_logon and user\_token cookie if
           session::restore fails.
- Changed: Removed all default values from columns where they are 0 or
           an empty string.
- Changed: Remove FID column from SEARCH\_RESULTS as it's not being
           used any more.
- Changed: Added index to POST\_RATING.RATING column.
- Changed: Removed all the old columns we don't need from the
           installer.
- Fixed: Installer not adding CREATED column to POST\_RATING table for
         upgrades.
- Fixed: SQL error with CREATED column on POST\_RATING.

## Date: Thu, 06 Jun 2013

- Fixed: Guest user (UID 0) would be added to the default user group.

## Date: Wed, 05 Jun 2013

- Changed: Always allow access to support files - ajax.php, json.php,
           etc.
- Changed: Always allow access to PMs and admin area if forum is set
           to restricted.
- Changed: Remove user\_logon and user\_token cookie if
           session::restore fails.
- Changed: Use HTTP\_COOKIE in $\_SERVER to unset cookies if
           available.

## Date: Sun, 02 Jun 2013

- Fixed: forum\_delete\_tables wasn't working correctly due to
         permissions check.
- Changed: Installer is now exception happy and throws them if
           anything goes wrong during installation / upgrade.
- Changed: Added CREATED column to POST\_RATING table.

## Date: Sat, 01 Jun 2013

- Fixed: Search was not allowed if you hadn't searched before.
- Fixed: Thread title not being highlighted with search keywords.

## Date: Fri, 31 May 2013

- Fixed: SQL errors in installer preventing installer from completing
         correctly.

## Date: Wed, 29 May 2013

- Changed: Removed require\_post\_approval setting and always just use
           the folder permission.
- Changed: Allow posts to be edited and deleted while pending
           approval.

## Date: Sat, 25 May 2013

- Changed: Disallow fullscreen mode in embed tag. Allow hSpace and
           vSpace.

## Date: Fri, 24 May 2013

- Added: CKEditor allMedias plugin (backported to work with CKEditor
         3.x)
- Changed: Allow embed tag in HTMLPurifier to support allMedias
           plugin.
- Changed: Switch attr calls to prop to make the JavaScript work
           correctly. Fixes the select all checkboxes.
- Changed: Reduce complexity of PM search query by only joining on
           PM\_TYPE to ensure user owns the PM.

## Date: Wed, 22 May 2013

- Fixed: Undefined index POST\_RATING and USER\_POST\_RATING when
         displaying a poll in Mobile mode.
- Changed: Remove max length restriction on passwords.
- Changed: Move post rating calculation into separate queries for
           better reuse.

## Date: Tue, 21 May 2013

- Fixed: Query for Visitor log user rating didn't function correctly.
- Fixed: form\_dropdown\_objgroup\_array wasn't returning the rendered
         HTML.
- Added: Visitor log allows adding user score and post votes.

## Date: Mon, 20 May 2013

- Fixed: More undefined variables in create\_poll.php.
- Fixed: Post menu not displaying due to AJAX error.
- Changed: Added folder FID to message\_get result.
- Changed: Simplified vote form and menu functions

## Date: Sun, 19 May 2013

- Added: Mobile mode post voting styles.
- Added: Mobile mode post voting with popup for easier tapping.
- Fixed: Undefined variable $content

## Date: Sat, 18 May 2013

- Changed: Add ajax handling of post voting.
- Fixed: Unable to reply to a specific post and change the recipient
         to all.

## Date: Thu, 16 May 2013

- Changed: Reduced the contrast the vote icons off state.
- Changed: More optimisation of the Sphinx configuration.
- Changed: New higher contrast vote icons courtesy of Andrew
- Changed: Make sure Sphinx only updates posts which were indexed in
           the last run.

## Date: Wed, 15 May 2013

- Fixed: Hardcoded DEFAULT webtag in a few queries added during
         permissions changes.
- Fixed: Installer not creating new tables added recently.
- Changed: Moved INDEXED column into POST table for query speed and
           have it be nulled when editing a post.

## Date: Mon, 13 May 2013

- Fixed: Broken SQL not sending new user approval / notification to
         admins.
- Added: Profile now includes total votes cast and current total user
         score.

## Date: Sun, 12 May 2013

- Fixed: Post rating was broken on polls.
- Added: Post voting with positive and negative voting.
- Changed: Allow repeated upgrade attempts by making upgrade.php check
           for tables it has already modified.
- Fixed: Broken SQL query preventing user profile popup from fetching
         list of groups a user is in.

## Date: Fri, 10 May 2013

- Changed: Move user permissions into their own table and keep only
           groups and group permissions in the existing tables.

## Date: Thu, 02 May 2013

- Fixed: Emails containing final\_uri, including email confirmation,
         had a proceeding slash that caused the link to not work.
- Fixed: Calls to html\_draw\_error had the wrong arguments in some
         cases.

## Date: Mon, 29 Apr 2013

- Fixed: Uncomment contentsCSS in CKEditor setup that was setting
         wrong default font and disabling emoticons.

## Date: Sat, 27 Apr 2013

- Changed: Added textareas to zoom disable on mobile mode.
- Fixed: CKEditor Youtube plugin not setting height and width when
         using URL.

## Date: Thu, 25 Apr 2013

- Fixed: Font resize ajax event not reloading CSS file.
- Added: jQuery.mobile.zoom added from jQuery.mobile project to
         prevent zoom on input field focus.
- Changed: Upgrade jQuery and plugins to latest available versions.
- Changed: Google Closure Compiled all the 3rd part JavaScript files.

## Date: Sun, 21 Apr 2013

- Changed: Youtube CKEditor plugin now allows embed code or URL.
- Changed: Upgrade Swiftmailer to 4.3.1
- Changed: Upgrade HTMLPurifier to 4.5.0
- Changed: Upgrade CKEditor to 3.6.6.1.
- Changed: Added &quot;Me Only&quot; privacy level to profile items.
- Changed: Layout of Edit Profile changed to better fit long profile
           item texts.

## Date: Sat, 20 Apr 2013

- Fixed: Mobile mode thread list discussion type select box didn't
         auto-submit form when accessed from index.php.

## Date: Sun, 14 Apr 2013

- Fixed: Wrong data being passed to admin\_add\_log\_entry()
- Fixed: Undefined variable $t\_content when editing a post.

## Date: Sat, 13 Apr 2013

- Fixed: Broken HTML could cause message\_apply\_formatting to get
         stuck in an infinite loop.
- Fixed: Maximum post length should be checked against the combined
         length of content and signature.
- Fixed: Arguments to form functions were using false or 0 when they
         should be using null if they have no argument.
- Fixed: Signatures not showing for guests and showing when they
         shouldn't for registered users.

## Date: Wed, 10 Apr 2013

- Fixed: Mobile mode PM folder select box didn't automatically submit
         form.
- Fixed: Mobile mode search didn't work correctly for searching for
         posts by user.
- Fixed: Thread list mode select showing &quot;Search Results&quot; if
         you click on Messages in nav.php after performing a search.
- Changed: Moved JavaScript that controls thread list mode change into
           js/thread\_list.js.

## Date: Tue, 09 Apr 2013

- Fixed: PM search results were being counted towards used PM space.
- Fixed: Menu not working on Mobile mode since adding placeholder.
- Changed: Added Search to Mobile mode menu.
- Added: Mobile mode search page.

## Date: Mon, 08 Apr 2013

- Added: Form input fields now have placeholder support via native
         attribute and jQuery plugin for older browsers.
- Changed: Tidy up the Mobile mode post page a little.

## Date: Sat, 06 Apr 2013

- Fixed: Thread list icon wasn't changing correctly since
         #24342c87ccb04e1e9f59a0cb0275a332788f3e2c

## Date: Fri, 05 Apr 2013

- Fixed: Sphinx search was checking variable that didn't exist.
- Added: Ability to specify default user group for new users, applied
         the first time they visit a forum.
- Changed: New greyed out icons for set\_default\_forum.png.
- Changed: Allow no default forum to exist. Redirects users to My
           Forums page and shows link in navigation bar.

## Date: Sun, 31 Mar 2013

- Changed: Insert a space before each emoticon as well as after.

## Date: Sat, 30 Mar 2013

- Fixed: Guests could access forums despite access being restricted in
         forum settings.
- Fixed: Upgrade method wasn't creating new USER\_TRACK table format.
- Fixed: Undefined variable $error\_html under some circumstances when
         performing an upgrade.
- Changed: Bump master branch version number to 1.4.0.
- Changed: Make bh\_check\_style.php reformat and save the default css
           files.

## Date: Thu, 21 Mar 2013

- Fixed: Post count ordering was performing string not numeric
         comparison.

## Date: Wed, 20 Mar 2013

- Fixed: Content overflow wasn't working for pm\_display.

## Date: Sat, 16 Mar 2013

- Changed: Updated English British translation.
- Fixed: Typo in Admin Forum Settings.
- Changed: Replaced \r\n with \n in gettext calls as required for
           correct internationalisation.
- Fixed: Email confirmation link 2nd part is not an md5 sum any more.

## Date: Fri, 08 Mar 2013

- Fixed: Bitwise bit disable in
         perm\_user\_cancel\_email\_confirmation and
         perm\_folder\_reset\_user\_permissions was incorrect.
- Fixed: Some bitwise comparisions didn't make sense or were hard to
         read.

## Date: Wed, 06 Mar 2013

- Changed: Add version string to CSS, JavaScript and Images added to
           page using the methods in html.inc.php.

## Date: Sun, 03 Mar 2013

- Fixed: Incorrect use of fetch\_row and using assoc array keys.
- Fixed: Broken User Profile popup search redirect handling.

## Date: Sat, 02 Mar 2013

- Fixed: Register link not visible on logon page.
- Fixed: Logout redirect wasn't correctly passing the webtag to
         index.php.
- Changed: Allow user to be added to and removed from groups form
           admin user page.

## Date: Fri, 01 Mar 2013

- Changed: Remove GeSHi as we don't use it any more. To be replaced
           with client-side implementation.

## Date: Thu, 28 Feb 2013

- Changed: Allow searches to be limitd to  n searches every y minutes,
           instead of just every n minutes.

## Date: Wed, 27 Feb 2013

- Fixed: Undefined index POST\_PAGE in forum\_options.php when saving
         preferences.

## Date: Tue, 26 Feb 2013

- Changed: Turn USER\_TRACK table into a key value store to allow
           easier expansion.
- Changed: Removed User total tme and user best time calculations as
           they don't work.
- Fixed: Checking wrong User Preference for PM email notification.
- Fixed: Age and User's local time calculation were using static
         dates, not the current date / time.

## Date: Sun, 24 Feb 2013

- Fixed: Search results display blank page if mb\_substr-ing the
         content resulted in broken HTML.
- Changed: Increased preview of search result to 70 characters and
           removed signature.
- Changed: Changed layout of installer, moved help into the HTML so
           that JavaScript isn't required to view it. Embed CSS inline
           in the HTML output.
- Changed: Supress errors caused by suPHP and ini\_set.

## Date: Wed, 20 Feb 2013

- Fixed: It was possible to read other user's PMs while they remained
         undeleted by all parties.
- Fixed: Mobile Mode PM display was broken due to undefined variables.
- Fixed: PMs weren't being marked as read in Mobile Mode.

## Date: Sun, 17 Feb 2013

- Fixed: Light mode thread split notification was missing call to
         sprintf.

## Date: Thu, 14 Feb 2013

- Changed: Require both Etag and Last-Modified header to be the same
           before sending 304 not modified header.
- Changed: Added Etag checking to cache routines and removed all the
           duplicate code.

## Date: Tue, 12 Feb 2013

- Changed: Updated Sphinx configuration with proper stale index
           checking, kill-list and word stemming via libstemmer.

## Date: Sun, 10 Feb 2013

- Fixed: Sphinx query for fetching posts wasn't returning a unique id.
         Removed to\_uid as it's not used.
- Changed: Old School MSN Type R Emoticon pack updated to work with
           Beehive 1.3.x.
- Fixed: Mistake in search\_popup.php checking wrong field in GET
         request.

## Date: Sat, 09 Feb 2013

- Fixed: Session garbage collection was deleting sessions linked to
         non-expired login tokens.

## Date: Tue, 05 Feb 2013

- Fixed: Search Popup didn't work with allow\_multi set to true.
- Changed: List of allowed mime-type to a textarea and new-line
           separated for easier editing.
- Changed: Allow inputs now use comma and not semi-colon separators.

## Date: Mon, 04 Feb 2013

- Fixed: Deleting a user didn't complete successfully due to broken
         query when deleting PMs.

## Date: Sun, 03 Feb 2013

- Fixed: RSS feeds not working due to call to depreciated function.
- Changed: Remove unused message\_get\_recipients and add
           message\_get\_author.
- Fixed: Quick Reply was broken since most recent changes to post
         page.

## Date: Sat, 02 Feb 2013

- Changed: Don't garbage collect session if there is a logon token
           that hasn't yet expired.
- Changed: Don't garbage collect session if there is a logon token
           that hasn't yet expired.
- Fixed: Query didn't return enough columns to sort result in
         search\_get\_first\_result\_msg. Improved query to obey user
         relation for ignored users.
- Fixed: Broken query when using Sphinxsearch.
- Changed: Restore functionality that checks Beehive is installed
           correctly.
- Changed: Updated Sphinx configuration for new POST\_RECIPIENT table.

## Date: Fri, 01 Feb 2013

- Changed: Tidy up following merge from 1.3.x branch.
- Changed: Remove check\_install and don't call it in boot.php.
- Changed: Refined installer to remove duplicate HTML output and
           specify required includes.
- Changed: Installer should now work for PHP 5.2.x.

## Date: Fri, 25 Jan 2013

- Changed: Improve the fatal error shutdown handler. Wrap Exception
           Handler in try catch to trap exceptions thrown in the
           handler itself.
- Changed: Normalised PM database structure to allow storing single
           message with multiple recipients without duplication of
           data.
- Changed: Email post to, thread and folder subscriptions
           notifications now use queries and not the other functions
           to get results.
- Changed: Allow multiple recipients in posts.
- Changed: Reset session.gc\_probability and session.gc\_divisor to
           their defaults if not set or 0.

## Date: Mon, 21 Jan 2013

- Fixed: More broken includes discovered by changes to
         bh\_check\_dependencies.php.
- Fixed: Autocomplete wasn't working correctly for multi-user input
         fields (Part 2).
- Changed: bh\_check\_dependencies.php can now scan for object class
           and static method usage.
- Fixed: Lots of broken includes discovered by changes to
         bh\_check\_dependencies.php.
- Fixed: Autocomplete wasn't working correctly for multi-user input
         fields.
- Added: Option to disable sending emails by use of the SwiftMailer
         NullTransport.
- Fixed: Attachments not working in IE8.

## Date: Sun, 06 Jan 2013

- Fixed: mysql\_big\_selects config option not working.
- Fixed: Couldn't select a folder to view in lthread\_list.php.
- Fixed: Missing include placeholders in Mobile mode scripts.
- Changed: Increased width of some pages. Target 1280x960.
- Fixed: Broken includes for HTMLPurifier.
- Fixed: User timezone selection not working due to missing keys in
         session.
- Changed: More improvements to bh\_check\_dependencies.php.
- Changed: Updated dependencies using new bh\_check\_dependencies.php.

## Date: Sat, 05 Jan 2013

- Changed: New and improved bh\_check\_dependencies.php which can
           automatically update the source files.
- Changed: Added placeholder for require lines to scripts.
- Changed: Updated bh\_check\_dependencies.php to ignore files loaded
           by boot.php.
- Changed: Updated dependencies,
- Changed: Removed redudant bh\_check\_function\_names.php and
           zip\_lib.inc.php.

## Date: Fri, 04 Jan 2013

- Fixed: user\_get\_pref\_names should always return an array.
- Changed: Add $\_COOKIE and $\_SESSION to error reporting output.

## Date: Tue, 01 Jan 2013

- Changed: Removed invalid webtag final\_uri check from index.php.
           This is handled in boot.php.
- Changed: Ensure webtag is validated before using it.

## Date: Mon, 31 Dec 2012

- Changed: Always send charset=UTF-8 for Content-type.
- Fixed: Locale not being initialised correctly in all scripts.
- Fixed: Chrome likes to send &amp;nbsp; between emoticons.
- Fixed: Complete implementation of fake-emoticons.
- Changed: Removed browser-hacks from editor.css.

## Date: Sun, 30 Dec 2012

- Changed: Use CKEditor createFakeElement to insert emoticons. Allows
           them to be more easily deleted in the editor.

## Date: Sat, 29 Dec 2012

- Added: New caching method that throttles requests per-user to the
         specified number of seconds.

## Date: Thu, 27 Dec 2012

- Fixed: Broken Light mode thread list.
- Changed: Removed redudant helper scripts that are no longer needed.
- Changed: Increase width of Admin area tables and forms to better
           suit hi-res displays. Target 1280x??? screen width. (part
           2)
- Fixed: Initialise word filter after starting the session so
         RAND\_HASH is correctly populated.
- Changed: Increase width of Admin area tables and forms to better
           suit hi-res displays. Target 1280x??? screen width.
- Changed: Added support for Apple retina display touch-icons at
           144x144px.
- Changed: Store dimensions of images in POST\_ATTACHMENT\_FILES
           instead of using getimagesize to work it out every time.
- Changed: Add confirmation when deleting attachments.
- Changed: Updated installer to set WIDTH, HEIGHT and THUMBNAIL on
           POST\_ATTACHMENT\_FILES table.

## Date: Wed, 26 Dec 2012

- Fixed: Layout of attachments for wasn't quite right in some
         browsers.
- Changed: Allow html\_draw\_top to load CSS files and JS files not in
           /js.
- Changed: Don't load CKEditor and FineUploader on every page, only
           those pages we use them on.
- Changed: Re-enabled Youtube CKEditor plugin.
- Changed: Removed forum\_style cookie and allow STYLE preference to
           persist in session when user logs out instead.
- Changed: Even more code clean-up and bug fixing.
- Fixed: Undefined variable $start\_page in index.php.
- Fixed: PHP error in poll\_results.php.
- Changed: Some more code tidying.

## Date: Mon, 24 Dec 2012

- Fixed: Undefined variable max\_post\_attachment\_space.
- Changed: Fixed some minor issues including assignment in comparison
           statement.
- Changed: Don't use session::get/set\_value, use $\_SESSION
           super-global instead.
- Fixed: Undefined variable max\_post\_attachment\_space.
- Fixed: Undefined variable new\_thread.
- Changed: Fixed some minor issues including assignment in comparison
           statement.
- Changed: Don't use session::get/set\_value, use $\_SESSION
           super-global instead.
- Fixed: Undefined variable max\_post\_attachment\_space.
- Changed: Fixed some minor issues including assignment in comparison
           statement.
- Changed: Don't use session::get/set\_value, use $\_SESSION
           super-global instead.
- Changed: Fixed some minor issues including assignment in comparison
           statement.
- Changed: Don't use session::get/set\_value, use $\_SESSION
           super-global instead.
- Changed: Fixed some minor issues including assignment in comparison
           statement.

## Date: Sun, 23 Dec 2012

- Added: Forum Setting for overriding PHP's upload\_max\_size
         directive.
- Fixed: Error in User Details if the user doesn't have any
         attachments uploaded.

## Date: Sat, 22 Dec 2012

- Fixed: Creating new Post or PM would always attach all uploads if no
         checkboxes were ticked!
- Fixed: Quick Reply attaching all unattached files to every post.
- Fixed: Missing / broken CSS for Attachments form.
- Changed: Put attachment form buttons in a floated div to allow the
           summary to position better.
- Changed: Bump version number to 1.3.1.
- Changed: Embed warning.png in errorhandler.inc.php so we don't need
           html\_style\_image.
- Changed: Fix border misplacement on CKEditor mock-dropdowns.
- Changed: Simplify output from bh\_check\_php\_version.php and make
           it compatible with latest PHP-CompatInfo.

## Date: Fri, 21 Dec 2012

- Changed: Bump minimum version required for upgrade to 1.3.0.
- Changed: Updated Installer and Forum creation code to correctly
           handle new attachment tables.

## Date: Wed, 19 Dec 2012

- Fixed: User online/offline status not displaying correctly on Polls.

## Date: Tue, 18 Dec 2012

- Fixed: Inverted test when getting avatar image link for stats
         output.
- Fixed: Polls not animating in post.php when replying directly to
         poll.
- Changed: Upgraded jQuery, jQueryUI and fineUploader.
- Changed: Load Twitter, Facebook and G+ JavaScript libs using
           jQuery.getScript().
- Changed: Updated styles and images for fineUploader.

## Date: Mon, 17 Dec 2012

- Changed: Add attachments directory to .gitignore.
- Changed: More attachment improvements using FineUploader.js. Lots
           and lots of changes here.
- Changed: PM Export now uses built-in PHP zip support. Probably needs
           PHP 5.3.x.
- Changed: Use HTML5 doctype for non-frame pages.
- Changed: Don't use gettext short \_() function.
- Changed: Use JavaScript window.location.reload() instead of form
           post for retry button on error output.
- Changed: Removed unneeded constants and renumbered post page
           constants.
- Fixed: Guest votes not displaying in poll graphs.

## Date: Wed, 28 Nov 2012

- Fixed: Always trim trailing slash off directory name when appending
         filename. Fixes double slash in email notifications and HTML
         output.

## Date: Tue, 27 Nov 2012

- Changed: Implement FineUploaderBasic for handling attachment
           uploads.

