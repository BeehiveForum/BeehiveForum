# Beehive Forum Change Log (Generated: Mon, 19 May 2014 17:20:17)

## Date: Mon, 19 May 2014

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

## Date: Wed, 26 Mar 2014

- Changed: Updated documentation.
- Changed: Updated en\_GB locale.

