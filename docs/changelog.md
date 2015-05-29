# Beehive Forum Change Log (Generated: Fri, 29 May 2015 17:50:30)

## Date: Sun, 24 May 2015

- Fixed: XSS injections with PM folder names and recipient names.

## Date: Sat, 23 May 2015

- Fixed: Posts and poll forms not including csrf field
- Fixed: Function html\_display\_msg not having csrf field on post
         forms.
- Added: CSRF checks to all HTTP POST forms.

## Date: Mon, 18 May 2015

- Fixed: XSS issues in user search and folder rename functionality

## Date: Wed, 06 May 2015

- Fixed: Undefined index 0 in perms.inc.php on line 854.
- Changed: Use fetch\_row() instead of fetch\_array(MYSQLI\_NUM) on
           MySQLi result.

## Date: Wed, 15 Apr 2015

- Added: Show notification icon for number of unread PMs on mobile
         menu.

## Date: Sun, 05 Apr 2015

- Changed: Allow start page, forums rules and forum closed, restricted
           and password protected messages to have script tags.
- Fixed: Overflow not working correctly.

## Date: Fri, 03 Apr 2015

- Changed: Updated documentation and added details about Softaculous.
- Changed: Removed widths from HTML of edit\_profile.php and increase
           width of privacy select box.
- Fixed: Some minor JavaScript issues.

## Date: Sun, 29 Mar 2015

- Fixed: Re-added MobileOptimized and viewport meta values.
- Changed: Use POSTS\_PER\_PAGE settings in mobile mode.
- Changed: Calculate next and prev rel links using POSTS\_PER\_PAGE.
- Fixed: CKEditor plugin wasn't correctly referencing
         top.window.beehive.
- Fixed: Quote and Code plugin wouldn't correctly remove tag in
         Chrome.

## Date: Wed, 25 Mar 2015

- Fixed: Make correct use of canonical, next, prev, first and last
         link tags.
- Changed: Use first post in thread keywords in page, not the first
           post on the current page.

## Date: Mon, 16 Mar 2015

- Added: Use OnBeforeUnload event in My Controls to track when
         preferences have been changed but not saved.
- Fixed: User Details All Forums checkboxes were inverted and always
         coming back ticked.

## Date: Sat, 14 Mar 2015

- Fixed: Menu disappearing if post content causing horizontal
         scrolling.
- Changed: Add index to speed up thread list count query.
- Changed: Exclude empty and deleted threads from thread count.
- Fixed: PM Folder counts were incorrect.
- Changed: Decrease font-size of PM new count and increase PM bar
           text.
- Fixed: Search inputs were too wide since switch to CSS sprites.
- Fixed: Undefined variable $user\_profile

## Date: Fri, 06 Mar 2015

- Changed: Updated styles for Mobile register page.
- Changed: Remove working directory functionality from text-captcha -
           we now use the system temp path.
- Changed: Removed bootstrap files from allowed file lists.
- Changed: Added register form to Mobile mode.

## Date: Thu, 05 Mar 2015

- Changed: Pass webtag to top.php to allow customisation on a
           per-forum basis.

