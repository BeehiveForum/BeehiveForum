# Beehive Forum Change Log (Generated: Fri, 06 Jun 2014 19:27:00)

## Date: Fri, 06 Jun 2014

- Fixed: Thread list showing threads older than cut-off as unread.

## Date: Thu, 05 Jun 2014

- Fixed: Posts not being marked as read if the thread updated time is
         perfectly equal to unread cut-off.
- Changed: Use CSS Transforms and DXFilter for scaling the vote form
           with CSS sprites #2
- Fixed: Thread modified date not updating when replying to a thread
         outside of the unread cut-off.
- Fixed: Post vote buttons not appearing on AJAX loaded posts.
- Changed: Use CSS Transforms and DXFilter for scaling the vote form
           with CSS sprites.

## Date: Wed, 04 Jun 2014

- Fixed: Broken HTML.

## Date: Mon, 02 Jun 2014

- Added: First draft HTML emails.
- Fixed: State icon not changing when clicking to view thread.

## Date: Sun, 01 Jun 2014

- Fixed: Whitespace creeping in in places and causing bizarre errors.
- Fixed: Whitespace creeping in in places and causing bizarre errors.
- Added: Column sorting and grouping added to Admin Visitor Log.
- Fixed: Broken pagination due to bad match in strstr
- Fixed: Image position on question boxes wasn't aligned correctly.
- Fixed: Loading image has incorrect class name.

## Date: Sat, 31 May 2014

- Fixed: Use array\_unshift not array\_merge.
- Fixed: Use array\_unshift not array\_merge.

## Date: Fri, 23 May 2014

- Fixed: Only count positive and negative votes, not no-votes.
- Fixed: Don't show Mobile Reply to All link if thread is closed.
- Fixed: Post &quot;More&quot; link didn't work if you clicked the
         image not the text.
- Fixed: Broken HTML on index.php mobile mode.
- Fixed: Script bh\_check\_styles.php would trip over colon in value.
- Fixed: Back / Cancel button on new discussion went back to
         lmessages.php not lthread\_list.php.
- Changed: Added New Discussion / New PM links in Mobile header.
- Changed: Use CSS sprites for all decoration images.
- Changed: Remove unused images.
- Changed: Update top.php with new transparent beehive\_logo.png and
           top.css
- Changed: Don't support IE6 any more.
- Changed: Use CSS sprites for all decoration images.

## Date: Thu, 22 May 2014

- Fixed: Upgrading to 1.4.2 drop and recreates POST\_SEARCH\_ID but
         doesn't refill it.

## Date: Wed, 21 May 2014

- Fixed: Newer versions of Sphinx Search require explicit use of
         WEIGHT() macro to get weight of results.

## Date: Tue, 20 May 2014

- Fixed: Display of numbers is now localised correctly.
- Changed: Link text to visitor log change to make it more obvious.
- Changed: Reduce HTML output of stats, use row span to reduce empty
           table cell usage.

## Date: Mon, 19 May 2014

- Changed: Removed separator line on navigation menu.
- Fixed: New bh\_check\_style.php didn't remove selectors removed from
         default style
- Changed: Tidy up some code.
- Changed: Update changelog.md
- Changed: Updated stylesheets.
- Changed: Updated bh\_check\_styles.php to support parsing media
           rules.

## Date: Sun, 18 May 2014

- Changed: Updated stylesheets.
- Changed: Updated ignored folders.
- Changed: Updated includes

## Date: Sat, 17 May 2014

- Changed: Remove black border from profile image and allow smaller
           than 95x95px
- Fixed: Cannot access forgot\_pw.php when not logged in.
- Fixed: Completely empty database shows a empty error message.

## Date: Thu, 15 May 2014

- Fixed: Make sure VOTED column exists on LINKS\_VOTE table. It seems
         to have gone missing somewhere before 1.4.2

## Date: Wed, 14 May 2014

- Changed: Display mobile icon in place of the back button when not
           available.
- Fixed: Cannot dismiss the menu by tapping on the same icon again.

## Date: Tue, 13 May 2014

- Fixed: Navigation background menu.png
- Fixed: CSS syntax errors in mobile.css
- Changed: Sync images with default style.
- Changed: Sync images with default style.
- Changed: Sync images with default style.
- Fixed: resize\_width isn't a valid html\_draw\_top argument any
         more.
- Changed: New icons for mobile mode.
- Changed: Use underscores in all image filenames.

## Date: Tue, 22 Apr 2014

- Changed: Mobile mode changes. Move footer links into header bar.
- Changed: Refactor html\_draw\_top to accept an array of arguments
           keyed by property name.
- Fixed: Spelling mistake in exception handler.
- Fixed: Showing some pages in admin / user menu that aren't
         accessible without a webtag.
- Fixed: Couldn't access PM / user areas without a webtag.

## Date: Mon, 21 Apr 2014

- Changed: Move back link on mobile mode into header.

## Date: Thu, 17 Apr 2014

- Changed: Update styles
- Fixed: Array to string conversion in get\_request\_uri when $\_GET
         contains a multi-dimensional array.
- Changed: Error Handler no longer escapes the output of var\_export
           so they variables can be copied and pasted.

## Date: Wed, 16 Apr 2014

- Fixed: Unlimited attachment space prevented uploading any
         attachments.
- Fixed: Add missing curl extension to list of required PHP
         extensions.

## Date: Tue, 15 Apr 2014

- Changed: Run pngcrush on images.

## Date: Sat, 12 Apr 2014

- Changed: Combined format\_date and format\_time into a single
           function with an argument to display only date.

