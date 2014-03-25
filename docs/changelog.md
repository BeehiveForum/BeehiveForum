# Beehive Forum Change Log (Generated: Tue, 25 Mar 2014 19:20:32)

## Date: Tue, 25 Mar 2014

- Changed: Update includes.

## Date: Mon, 24 Mar 2014

- Changed: Perform attachment\_dir check before upgrading database.
- Changed: Trim the attachment\_dir and remove trailing slash.
- Changed: Remove USER\_AGENT column from SESSIONS table.
- Changed: Use constants for installer version numbers.

## Date: Sun, 23 Mar 2014

- Changed: Only update MODIFIED column of THREAD table if it is newer
           than the unread cutoff.

## Date: Sat, 22 Mar 2014

- Added: Vote count to mobile mode.
- Added: Vote count added to each post.

## Date: Fri, 21 Mar 2014

- Changed: Remove filter on attachments\_get and implement
           attachments\_get\_all.
- Fixed: Attachments disappearing from posts when you edit them.
- Changed: Use SUM on SQL to calculate used attachment space.
- Changed: Perform more strict check on attachments directory.
- Changed: Default to 'attachments' as attachments directory.

## Date: Mon, 17 Mar 2014

- Fixed: Only add/drop indexes if required.
- Fixed: Upgrade not working correctly.

## Date: Sun, 16 Mar 2014

- Added: Indicate thread starter with an icon next to their name if
         starting from post #2 onwards.
- Added: AJAX Chat online user count displayed next to Chat link in
         nav.php.
- Changed: Removed start left, go directly to thread list with start
           page showing.
- Changed: Added today's birthdays to the user stats at the bottom of
           the page.

## Date: Sat, 15 Mar 2014

- Changed: Remove logon.js which clears the password field when
           changing username.

## Date: Mon, 10 Mar 2014

- Changed: Allow thread authors to view their threads which are still
           pending approval.
- Fixed: 404 error when deleting links from approval queue.

## Date: Wed, 05 Mar 2014

- Changed: Removed double box layout of user groups on User page.
- Changed: Hide groups box if no user groups defined.
- Fixed: Empty id attribute in error / warning messages.
- Fixed: Missing APPROVED column in $\_SESSION. Fixes broken user
         approval.

## Date: Mon, 03 Mar 2014

- Changed: Prevent caching of page output if presented with forum
           restricted / password / closed message.

## Date: Sat, 01 Mar 2014

- Changed: Remove filtering of own domain from HTTP referrer.

## Date: Thu, 27 Feb 2014

- Added: Yandex added as a search-engine bot.

## Date: Mon, 24 Feb 2014

- Changed: Thread list shows only date if thread older than today.

## Date: Fri, 14 Feb 2014

- Fixed: CKEditor display issues in Chrome and IE.
- Changed: Added semi-colon to end of all rules in CSS selectors.
- Changed: Always add semi-colon to last rule of CSS selector.
- Fixed: Javascript errors on Windows Mobile.
- Changed: Updated dialog.css for CKEditor 4.
- Fixed: Resizing Youtube plugin dialog now centers the video.
- Changed: Updated colours on themes for CKEditor 4

## Date: Thu, 13 Feb 2014

- Changed: Upgrade to CKEditor 4
- Changed: Always add fb-root div, prevents error when it doesn't
           exist.

## Date: Mon, 10 Feb 2014

- Fixed: SQL Error in session::write
- Fixed: RSS Feed reader not working since multi-user reply
         implemented
- Changed: Restore REFERER column in SESSION table.
- Added: RSS icon next to mods list icon on thread list.

## Date: Sun, 09 Feb 2014

- Fixed: Cannot login nor logout with recent session changes.
- Changed: Reduce the complexity of session initialisation.
- Changed: Update visitor log when restoring a session from user
           token.
- Changed: Removed session::get\_value, set\_value and update\_value
           methods.
- Fixed: Missed a change in helper script that makes includes.
- Changed: Optimised imports.
- Changed: General code clean-up and refactoring.
- Fixed: &quot;preg\_replace(): The /e modifier is deprecated, use
         preg\_replace\_callback&quot; error in attachments.inc.php
- Changed: Helper script now formats include line the same as
           PhpStorm.

## Date: Sat, 08 Feb 2014

- Changed: Added Facebook vanity URL and Twitter link.

## Date: Wed, 05 Feb 2014

- Fixed: Cancel button on pm\_write.php not obeying return\_msg
- Fixed: Sending wrong pid to ajax.php for More menu.

## Date: Mon, 03 Feb 2014

- Changed: Allow access to user profile pages if account has not yet
           been approved.
- Changed: Updated file lists in server.inc.php.
- Fixed: Allow Guest access to register.php.

## Date: Sun, 02 Feb 2014

- Fixed: Cannot register when forum is put into restricted access
         mode.
- Changed: Remove REFERER and USER\_AGENT from SESSION table.
- Fixed: Error when deleting a forum due to wrong column name in
         DELETE query.
- Changed: Updated en\_GB language pack
- Changed: Added columns for Wiki Quick Links and Tags to installer.
- Added: Option to disable post tags.
- Changed: Split WikiWiki user options into two separate options as
           they are in forum settings.
- Fixed: Set sql\_mode to empty string for MySQL 5.6 compatibility.

## Date: Sat, 01 Feb 2014

- Added: Ability to add tags to posts like Twitter.
- Changed: Only show &quot;Successfully created post&quot; message if
           the post is not visible on the current page.

## Date: Sun, 26 Jan 2014

- Fixed: Display of a.button wasn't working correctly on some devices
- Changed: Removed &lt;h1&gt; from top of lpost.php and lsearch.php.
- Fixed: Guests not being recorded in visitor log.

## Date: Sat, 25 Jan 2014

- Fixed: Including alternate stylesheet twice if name matched filename
         of PHP script.
- Added: Separate admin.css files for each style.
- Fixed: Broken Unread to me query in Forums when searching.
- Changed: Allow batch processing to continue to next if
           approve/delete fails.
- Changed: Display post / link to approve on same page as the list of
           posts / links.
- Changed: Added batch post and link approval.

## Date: Sat, 18 Jan 2014

- Changed: Use a separate admin.css for admin area scripts.

## Date: Fri, 17 Jan 2014

- Fixed: Unquoted complete in ternary causing JavaScript error in
         onComplete callback of fineuploader.

## Date: Wed, 15 Jan 2014

- Fixed: Error displaying User History.
- Changed: User History and Aliases to not use a double nested box

## Date: Wed, 08 Jan 2014

- Fixed: Cancel button not working in lpm\_write.php
- Fixed: Quote links were not adding the quote\_list argument to the
         reply links.

## Date: Sun, 05 Jan 2014

- Changed: Drop and recreate SEARCH\_RESULTS tables when upgrading
           from 1.3.x. Fixes missing FID column error on some
           installs.

