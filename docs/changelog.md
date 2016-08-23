# Beehive Forum Change Log (Generated: Tue, 23 Aug 2016 20:25:51)

## Date: Mon, 08 Aug 2016

- Fixed: Remove width and height from images.css main .image selector.
- Fixed: application-name and msapplication-tooltip attributes had
         wordfilter tags in output.
- Fixed: Various XSS vulnerabilities fixed.

## Date: Wed, 22 Jun 2016

- Fixed: Prevent toolbar button hover making the page bounce.

## Date: Thu, 10 Mar 2016

- Fixed: CKEditor not loading content.css due to wrong path.
- Changed: Tidy-up some code.

## Date: Tue, 08 Mar 2016

- Fixed: Avoid collision with PHP's own Error class.
- Changed: Tidy-up some code.

## Date: Thu, 03 Mar 2016

- Changed: Update .gitignore.

## Date: Wed, 24 Feb 2016

- Changed: Remove forum\_path property and related code.
- Changed: Removed Beehive dependency from CKEditor plugins and add
- Changed: Load json.php via AJAX in general.js and pass result as
           argument
- Changed: Add localization support to CKEditor plugins and remove
           dependency on Beehive.
- Changed: Load json.php from general.js and pass result through in
           beehive.init event.
- Changed: Move 3rd Party JavaScript into lib subdirectory.
- Changed: Replaced old jquery.sprintf with sprintf-js
- Changed: Tidy JavaScript with JSHint.
- Changed: Remove call usage and add argument for element.
- Changed: Hide vote icons on own posts.
- Changed: Rename forum\_links.js

## Date: Sun, 31 Jan 2016

- Fixed: Current Thread icon wasn't being applied correctly.

## Date: Thu, 17 Dec 2015

- Fixed: Including wrong bootstrap in ledit.php (caused error in PHP7)

## Date: Fri, 16 Oct 2015

- Fixed: Undefined index UID when performing SFS check

## Date: Wed, 26 Aug 2015

- Changed: Added constant to disable CSRF checking. Fixes AJAXChat
           integration.

## Date: Sat, 08 Aug 2015

- Fixed: Unable to login if no existing session due to failure to call
         session\_start in session::init.
- Fixed: Lots of code had calls to functions with too many arguments.
- Fixed: Tabular polls not working.

## Date: Fri, 07 Aug 2015

- Changed: Generate CSRF token when login occurs / session is restored
           and don't regenerate it unless invalid

## Date: Tue, 14 Jul 2015

- Changed: Add CSS classes to elements of the message pane to allow
           styling separately.

## Date: Sat, 13 Jun 2015

- Fixed: Function forum\_delete not removing TAG and POST\_TAG tables.
- Fixed: Google Chrome squashing the content into narrow column.

## Date: Sun, 07 Jun 2015

- Changed: Quick Reply closing when clicking outside it causing
           premature close. Use cancel button instead.

