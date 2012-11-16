# Beehive Forum Change Log (Generated: Fri, 16 Nov 2012 20:10:13)

## Date: Thu, 15 Nov 2012

- Fixed: High Interest not working with Quick Reply.

## Date: Sat, 10 Nov 2012

- Changed: Don't hide menu when clicking button again. Fixes issues
           with mobile browsers that send two clicks due to touch
           screen issues.

## Date: Fri, 09 Nov 2012

- Fixed: Text selection for Code, Quote and Spoiler tags was showing
         [object MSSelection] or [Object Selection] in Internet
         Explorer.

## Date: Thu, 08 Nov 2012

- Changed: Added empty paragraphs after quote. Would prefer br but
           ckeditor insists on continusing to use p tags everywhere.
- Changed: Made spoilers readable in editor and added styling for
           anchor tags.

## Date: Sat, 03 Nov 2012

- Fixed: Editor breaking if you click Quick Reply after having already
         clicked Quick Reply on another post.

## Date: Fri, 02 Nov 2012

- Fixed: Some Javascript got disabled while trying and failing to make
         it work with IE7.
- Changed: Disable CKEditor context menu.

## Date: Wed, 31 Oct 2012

- Changed: Increased width of Create Poll and Edit Poll to match Post
           and Edit.
- Changed: Put Create and Edit Poll pages radio butons on separate
           lines for easier use.

## Date: Tue, 30 Oct 2012

- Added: Readme for root of repository with links to the other docs.

## Date: Fri, 26 Oct 2012

- Changed: Removed dictionary functionality. Please use browser
           specific add-ons / plugins.

## Date: Thu, 25 Oct 2012

- Changed: Removed hidden t\_sig field in lpost.php. No need to submit
           it if it's can't be edited.

## Date: Wed, 24 Oct 2012

- Changed: Added margin to div.sig. Needed now we don't use paragraphs
           in CKEditor.

## Date: Tue, 23 Oct 2012

- Fixed: Sorting of CSS selectors wasn't working in
         bh\_check\_styles.php.
- Changed: Removed margins from paragraph tags for CKEditor enter
           press functionality.

## Date: Sun, 21 Oct 2012

- Fixed: Missing space in favicon tag in Mobile pages.
- Fixed: Cancel button height in Mobile Post / Edit wasn't the same as
         the other buttons.
- Changed: Updated styles so they all match the default.

## Date: Fri, 19 Oct 2012

- Fixed: Ctrl + Enter on Quick Reply wasn't working with CKEditor.
- Changed: Don't use CKEditor jQuery adaptor as it's not as flexible
           as straight up CKEDITOR.replace().
- Changed: Don't cache the cached response from StopForumSpam.

## Date: Wed, 17 Oct 2012

- Fixed: Quick Reply Open, Cancel and Reopen would break CKEditor
         because we weren't destroying the old instance.

## Date: Tue, 16 Oct 2012

- Fixed: Beehive CKEditor plugin not working correctly in IE8.
- Fixed: Youtube Preview not working due to incorrect child reference.

## Date: Mon, 15 Oct 2012

- Fixed: Cancel buttons not working on lpost.php and ledit.php.
- Fixed: bh\_check\_styles.php wasn't sorting the modified CSS file to
         match the defaults.
- Changed: Added CSS selector to a.button to mobile.css.

## Date: Sun, 14 Oct 2012

- Changed: bh\_check\_styles now ignore rules containing colour codes
           (#[0-9A-F]|rgba?) as well as rules containing the world
           color.
- Changed: bh\_git\_log\_parse.php now uses UNIX line endings for
           everything.

## Date: Sat, 13 Oct 2012

- Fixed: Width of Signature box was too small when collapsed.
- Fixed: Changing Signature Ignore option trashed other post page
         preferences.
- Fixed: Post user was not being correctly populated when clicking on
         Reply link in messages.php.
- Changed: user\_update\_prefs logic changed so global prefs are set
           only if entry set in global setting array.
- Changed: Allow div and pre tag to have class attribute.
- Changed: Disabled emoticons using CSS instead of with PHP code in
           message\_apply\_formatting.

## Date: Fri, 12 Oct 2012

- Fixed: Missing CSS for autocomplete.
- Fixed: Emoticons in CKEditor were not being created correctly after
         preview.
- Changed: Removed auto links, disable emoticons and check spelling
           post prefs.
- Changed: Made Post, Edit, PM Write and PM Edit pages wider.
- Changed: Removed recent user dropdown and thread users. Replaced
           with single autocomplete.

## Date: Thu, 11 Oct 2012

- Fixed: html\_get\_cookie and forum\_get\_setting 2nd argument should
         be null for it to be ignored.
- Changed: Always add emoticon class name to emoticon HTML.
- Changed: Use spans for emoticons in CKEditor, not fakeElements.

## Date: Sun, 07 Oct 2012

- Changed: Show emoticons as user's selected pack in CKEditor.
- Fixed: Set default font and font-size in CKEditor.

## Date: Sat, 06 Oct 2012

- Fixed: Switching off spoiler didn't remove the outer span.
- Fixed: minHeight on link dialog isn't required now we've removed
         some elements.
- Changed: Context menu wasn't styled in Beehive skin for CKEditor.
- Changed: Added editor.css which contains styles for Beehive Code,
           Quote and Spoiler elements.

## Date: Tue, 02 Oct 2012

- Changed: Removed all remaining references to htmltools.
- Changed: Removed emoticons 'More' link.
- Changed: Emoticons preview box now uses CKEDITOR.currentInstance
           (seems to be buggy though!)
- Fixed: Broken emots\_disable checkbox would automatically tick on
         preview / post.
- Fixed: Don't check LOGON, EMAIL or NICKNAME for bans if user is a
         Guest.

## Date: Sun, 30 Sep 2012

- Fixed: Only use youtube plugin for iframes with src matching
         youtube.com/embed
- Changed: Validation on youtube plugin dialog box input now checks we
           have an iframe with the src set correctly.
- Changed: Add thumbnail to fakeElement created by youtube plugin.

## Date: Sat, 29 Sep 2012

- Added: Work in progress Youtube Embed Plugin for ckeditor. Creates a
         fake element, but gets mangled on preview due to iframe being
         returned.

## Date: Sun, 23 Sep 2012

- Changed: Auto focus the editor on page load for edit.php,
           pm\_edit.php and pm\_write.php.

## Date: Sat, 22 Sep 2012

- Fixed: Installer not creating APPROVED and APPROVED\_BY in LINKS and
         MD5 in SESSIONS table.
- Fixed: Incorrect column name - LINKS\_VOTE column TSTAMP should be
         VOTED.
- Changed: Added method set\_config to db class to allow overriding
           the values in config.inc.php.
- Changed: Installer now uses db::set\_config.

## Date: Wed, 05 Sep 2012

- Fixed: TinyMCE .js files not being included if a CDN is enabled.

## Date: Sun, 02 Sep 2012

- Changed: Don't catch fatal errors at all. Turn them off and don't
           output anything. Fixed SFS timeout preventing forum from
           loading.
- Changed: Error Handler is back to using Exception and new Error
           class as a replacement for broken ErrorException.
- Changed: Add timeout to SFS integration to speed up initial
           connection.

## Date: Sat, 01 Sep 2012

- Fixed: Transparency issue with GD image resizing.
- Changed: Attachment thumbnails are now resized to shortest size and
           cropped into the final dimensions requested.
- Changed: Require GD 2.0 support in image\_resize\_gd.

## Date: Thu, 30 Aug 2012

- Fixed: Registering was trying to create a second session. It should
         be calling session::refresh with the new UID instead.

## Date: Wed, 29 Aug 2012

- Fixed: Call to undefined method get\_referer() in register.php.
         Should be get\_http\_referer().
- Changed: Don't parse stack trace around in function arguments, only
           get it when we need to use it.

## Date: Tue, 28 Aug 2012

- Fixed: Trying to use db-&gt;escape without getting instance of db.

## Date: Mon, 27 Aug 2012

- Fixed: Forum maintenance functions weren't being run due to recent
         bootstrap changes.
- Fixed: Adsense ads were always showing wide adverts on Mobile Mode.
         Switched to always show smaller ads.
- Changed: Mobile Mode Menu changed to place drop down menu outside of
           header. Makes it work correctly on Blackberry devices.
- Changed: Removed deprecated settings from config.inc.php.

## Date: Tue, 21 Aug 2012

- Changed: Unset sess\_uid cookie if if working with a guest session /
           logging out.

## Date: Mon, 20 Aug 2012

- Fixed: Wrong column name in gc method.

## Date: Sun, 19 Aug 2012

- Changed: Add some logging to session class to see if we can work out
           why sessions keep expiring prematurely.

## Date: Sat, 18 Aug 2012

- Changed: SESSIONS table is now INNODB and has a maximum ID length of
           40 chars to allow for SHA-1 session IDs.

## Date: Wed, 15 Aug 2012

- Fixed: Stats AJAX request not sending correct cache headers.

## Date: Tue, 14 Aug 2012

- Fixed: Search not redirect to the correct page after it has
         completed.
- Changed: Exception handler is now in easy to manage chunks that can
           be called independently to the main function.

## Date: Mon, 13 Aug 2012

- Changed: Added call to register\_shutdown\_function to see if it
           helps with premature session expiry

## Date: Sun, 12 Aug 2012

- Changed: Allow Javascript files to be loaded via CDN URI.

## Date: Sat, 11 Aug 2012

- Fixed: Broken session::logged\_in() check wqas preventing messages
         from being marked as read.
- Fixed: Removed duplicated session::logged\_in() check in
         font\_size.php.
- Fixed: lboot.php was not up to date when compared to boot.php.
- Fixed: Remove debug code from session.inc.php. Always send cookie
         with every response if logged in.

## Date: Fri, 10 Aug 2012

- Fixed: All calls to db\_fetch\_array passing into list now uses
         DB\_RESULT\_NUM.
- Fixed: All html\_draw\_top calls now use sprintf and gettext
         correctly to set the window / page title.
- Changed: More pages in admin area now use wider layouts and display
           more data for ease of use.
- Changed: Sessions no longer use base64\_encode/decode as it seems
           sometimes the data gets corrupted.

## Date: Mon, 06 Aug 2012

- Fixed: forum\_check\_access now has a white-list that it allows to
         proceed.
- Changed: All arrays are now cleanly formatted for easy reading.
- Changed: Autocomplete now includes logon in brackets.
- Changed: Removed stripslashes\_array and implement
           disable\_magic\_quotes function.
- Changed: bhsearchinput no longer uses a container div in the HTML.
           This is now added by Javascript.

## Date: Sun, 05 Aug 2012

- Changed: Introduced boot.php and lboot.php for bootstrapping the
           individual files into a common state.
- Changed: Massive code overhaul, formatting, etc. Probably lots of
           broken things, but they'll get fixed eventually.
- Changed: Removed all phpdocumentor comment blocks. Will re-do them
           properly at a later date.
- Changed: Switched to jQueryUI autocomplete.

## Date: Wed, 01 Aug 2012

- Fixed: User E-mail message footer missing line breaks.

## Date: Sun, 29 Jul 2012

- Changed: License changed from GNU GPL v2 to v3 to bring us inline
           with some of the libraries we distribute with Beehive.
- Changed: All our documentation is now in markdown for easy export to
           HTML and other formats.
- Changed: bh\_git\_log\_parse.php now generates markdown
           changelog.md.

## Date: Sat, 28 Jul 2012

- Fixed: Updated bh\_check\_php\_version.php to work with latest
         Bartlett/PHP/CompatInfo.php.
- Fixed: Lots of broken sprintf statements due to change to GNU
         gettext.
- Changed: Updated dependencies in all scripts.
- Changed: Updated stylesheets to be consistent with default style.
- Changed: Upgraded bundled version fo SwiftMailer.

## Date: Fri, 27 Jul 2012

- Fixed: TinyMCE seems to remove empty paragraph tags, switched to
         using &lt;br /&gt; instead.
- Fixed: Allow style attribute on span tag. TinyMCE seems to have
         disabled / broken the inline\_styles option they have.
- Changed: Compress white-space when quoting a post in a reply.

## Date: Thu, 26 Jul 2012

- Fixed: Incorrect uses of format strings in strftime

## Date: Tue, 24 Jul 2012

- Fixed: Incorrect table name VISITOR\_LOG\_NEW and missing
         USER\_AGENT column in SESSION table in new installs.

## Date: Mon, 23 Jul 2012

- Fixed: html\_draw\_top was not clearing additional arguments if they
         were already set.
- Fixed: inline\_css argument to html\_draw\_top was not matching the
         CSS after the argument correctly.
- Changed: Applied same modifications to html\_draw\_top to
           light\_html\_draw\_top.

## Date: Sun, 22 Jul 2012

- Changed: Updated Beehive TinyMCE plugin to work with 3.5.5 minimum.
- Changed: Updated readme.txt to indicate minimum TinyMCE version
           required.
- Fixed: Height and width on Youtube and Flash plugins.

## Date: Sat, 21 Jul 2012

- Fixed: Display of languages in Forum Options included the full path
         to the locale file.

## Date: Thu, 19 Jul 2012

- Fixed: Empty Visitor log prevented page from loading due to infinite
         loop occuring.

## Date: Wed, 18 Jul 2012

- Changed: Added some branding to the top banner on Mobile mode and
           move menu items into a drop down structure.

## Date: Tue, 17 Jul 2012

- Fixed: Broken HTML in start\_left.php
- Fixed: Broken upgrade script not escaping table names correctly.

## Date: Sat, 14 Jul 2012

- Fixed: Broken page titles caused by title argument not being passed
         correctly.
- Changed: Forum user preferences are now nullable so that they can
           correctly inherit from global user preferences.

## Date: Tue, 10 Jul 2012

- Changed: Only add entry to ADMIN\_LOG if SFS response is not cached.

## Date: Mon, 09 Jul 2012

- Fixed: Language strings in JSON response were missing keys.
- Fixed: SQL\_CALC\_FOUND\_ROWS missing from visitor\_log.inc.php.
- Fixed: Image Resize code being called too early, changed to use
         event delegation on img load event.
- Fixed: jQuery.attr('clientWidth') is no longer valid, changed to
         prop('clientWidth')

## Date: Sat, 07 Jul 2012

- Fixed: Calls to gettext as an argument to forum\_submit\_image was
         creating broken HTML in forums.php, user\_rel.php and
         visitor\_log.php.
- Changed: Revert back to old visitor\_log\_get\_recent() function for
           displaying the recent visitors in start\_left.php
- Changed: New schema for VISITOR\_LOG table that makes use of
           MYISAM's relaxed NULL unique constraint to make querying it
           easier.

## Date: Tue, 03 Jul 2012

- Fixed: Date dropdown functions were trying to translate the text
         &quot;Array&quot;.
- Changed: Added lang\_get\_month\_names function for use in date
           dropdown functions.

## Date: Fri, 22 Jun 2012

- Fixed: Broken links when searching for posts by a user.

## Date: Thu, 21 Jun 2012

- Fixed: Hard-coded DEFAULT webtag in poll.inc.php
- Fixed: Missing comma in SQL statement in stats.inc.php
- Changed: Revert back to word filter appying to whole message instead
           of non-HTML parts.

## Date: Wed, 20 Jun 2012

- Fixed: Not escaping filter name in display of filters.

## Date: Thu, 14 Jun 2012

- Changed: All coookies are now marked as HTTP only.

## Date: Sun, 10 Jun 2012

- Changed: Function admin\_add\_log\_entry now accepts only array as
           it's second argument.

## Date: Sat, 09 Jun 2012

- Changed: Allow session\_check\_banned to check global ban state of
           user.

## Date: Fri, 08 Jun 2012

- Fixed: Prevent HTML in word filter from breaking HTML in messages.

## Date: Thu, 07 Jun 2012

- Fixed: Reimplement nested tag checking in add\_paragraphs and fix
         infinite loop when HTML with code tags.

## Date: Tue, 05 Jun 2012

- Fixed: Link details shows stale data after submitting edit form.
- Fixed: Links page was sending page URL query var that we don't use.

## Date: Mon, 04 Jun 2012

- Changed: Remove $init\_guest\_session argument of session\_check.
           Now always intitialise Guest session. Fixes problems with
           Light mode embedded in index.php.
- Changed: Always show RSS feed links for available folders.

## Date: Sun, 03 Jun 2012

- Added: Link Approval Email Notification for Link Moderators.

## Date: Fri, 01 Jun 2012

- Changed: Session Restore will now look for a session to reuse before
           creating a new one.
- Changed: Prune sessions more frequently upon each user's session
           cutoff being triggered.
- Changed: Removed remove\_stale\_sessions call from forum maintenance
           calls.

## Date: Tue, 29 May 2012

- Fixed: Undefined index when editing a post with complicated mix of
         HTML and auto-paragraphs.

## Date: Mon, 28 May 2012

- Fixed: Checking wrong POST data for PM\_EXPORT\_TYPE user
         preference.

## Date: Sat, 26 May 2012

- Changed: Prevent some XSS vulnerabilities in the cookies we use.

## Date: Thu, 24 May 2012

- Fixed: Social links were cropped badly. Moved code into common
         function in messages.inc.php.

## Date: Wed, 23 May 2012

- Changed: Don't escape frameset attribute values. Make calling code
           escape them.
- Changed: Function href\_cleanup\_query\_keys now always uses &amp;
           separator. Use built-in PHP code to build query string.
- Changed: Removed redudant URL query checks in index.php.

## Date: Tue, 22 May 2012

- Fixed: XSS / HTML inection flaws involving final\_uri URL query
         parameter and frameset tags.
- Fixed: Removed call to text\_captcha-&gt;delete\_image().
- Fixed: Session not correctly restoring if user\_token cookie was
         set.
- Changed: Removed session\_expired functionality as it's not needed
           any more.
- Changed: Added ban\_check call to register.php so we don't create
           banned user accounts.
- Changed: sfs\_check\_banned to take an array of data.

## Date: Sun, 20 May 2012

- Fixed: Meta Keywords and Meta Description were being passed through
         word filter twice if no msg URL query param.
- Fixed: Multiple calls to session\_check() initialised multiple
         sessions if the user used Remember Me functionality.
- Changed: Function get\_request\_uri() now returns relative URL.
- Changed: Added optional argument html\_guest\_error to specify which
           page to redirect back to after logon instead of guessing
           it.
- Changed: HTML head now uses relative URLs. Fixes 3rd Party
           integration.
- Changed: Removed $use\_full\_path argument from
           html\_get\_forum\_file\_path method.
- Added: Record user\_agent in SESSION and VISITOR\_LOG tables.

## Date: Sat, 19 May 2012

- Fixed: SFS Ban Admin Log entries were showing Unknown User for
         Guests.

## Date: Thu, 17 May 2012

- Fixed: Incorrectly using Javascript redirect if web-server didn't
         add SERVER\_SOFTWARE in $\_SERVER.
- Changed: Text-captcha now writes images to system temp directory.
- Changed: Added AJAX Chat global forum setting (no UI yet) which
           shows a 'Chat' link in nav.php.

## Date: Tue, 15 May 2012

- Changed: Always allow Google AdSense Crawler.

## Date: Mon, 14 May 2012

- Changed: Allow final\_uri to be a full path.
- Changed: All final\_uri parameters now check against
           get\_available\_files() list as a minimum.

## Date: Sun, 13 May 2012

- Added: Option to place text-captcha directory outside of the forum
         directory.
- Changed: Text-captcha image is now sent as base64 encoded data which
           allows the text-captcha directory to be placed outside the
           web root.
- Changed: TinyMCE youtube plugin source files were different in the
           minified target file and the original source file.
- Fixed: Huge mess of .gitignore files moved into one file. Correctly
         excluded TinyMCE files except our own plugins.

## Date: Sat, 12 May 2012

- Changed: Updated installer / upgrader to use new VISITOR\_LOG table
           schema.

## Date: Thu, 10 May 2012

- Changed: Adsense options now have more flexability about where you
           can place adverts.

## Date: Mon, 07 May 2012

- Changed: Added tehforum style to .gitignore

## Date: Sun, 06 May 2012

- Fixed: Highlighting search results wasn't working due to changes in
         how the keywords are matched.
- Changed: Beehive now uses delta+main indexing in Sphinx. Beehive
           will look for indexes named [WEBTAG] and [WEBTAG]\_DELTA.

## Date: Sat, 05 May 2012

- Fixed: SFS cache was not repopulating cache after it had expired,
         causing 100% misses all the time.
- Changed: Sphinx examples changed to reference Ubuntu 12.04 LTS
           sphinxsearch package.
- Changed: Sphinx integration now uses forum's WEBTAG as the index and
           source names.
- Changed: Installer now drops and recreates SFS\_CACHE table every
           time it is run.

## Date: Thu, 26 Apr 2012

- Added: Admin Log Record Grouping to help reduce SFS log pollution.
- Fixed: Admin log prune didn't remember column sorting and direction.
- Changed: Removed forum\_uri setting as it's causing too many
           problems for people.

## Date: Thu, 19 Apr 2012

- Fixed: StopForumSpam hit was causing error and not logging ban to
         admin log.
- Changed: Added display of StopForumSpam admin log entries.

## Date: Wed, 18 Apr 2012

- Fixed: Missing sfs global forum settings added to
         global\_forum\_settings array.
- Changed: Added option to disable StopForumSpam integration.

