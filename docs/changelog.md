# Beehive Forum Change Log (Generated: Sun, 29 Jul 2012 16:48:57)

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

## Date: Mon, 16 Apr 2012

- Changed: Updated release date for 1.2.0

