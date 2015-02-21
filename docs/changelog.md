# Beehive Forum Change Log (Generated: Sat, 21 Feb 2015 18:24:25)

## Date: Sat, 21 Feb 2015

- Changed: Use filter\_var to validate URL inputs.

## Date: Sun, 01 Feb 2015

- Fixed: Call beehive.init\_editor after initialising CKEditor.
- Changed: Use shared JavaScript beehive object across all frames by
           referencing top.window.beehive.
- Fixed: Remove menu.png from styles that still referenced it.

## Date: Sun, 25 Jan 2015

- Fixed: Don't detect MSIE 12 developer preview as Webkit.

## Date: Thu, 22 Jan 2015

- Fixed: Image resize not maintaining ratio of images.

## Date: Sat, 10 Jan 2015

- Fixed: Prevent users from voting on their own posts.
- Fixed: Image resize banner icon wasn't displayed correctly.
- Fixed: Post vote returned mobile HTML which displayed differently.

## Date: Fri, 02 Jan 2015

- Changed: Bump PHP minimum version to 5.4 (5.3 is deprecated)
- Fixed: Error Handler wasn't displaying images due to missing
         images.css.

## Date: Mon, 15 Dec 2014

- Added: Allow auto-loading of messages to be switched off in user
         preferences.
- Fixed: Webtag being removed from $\_GET vars in get\_request\_uri
         function.

## Date: Wed, 10 Dec 2014

- Fixed: Checkboxes on Group and User permissions included each other,
         making it impossible to deselect some permissions.

## Date: Wed, 26 Nov 2014

- Fixed: Double encoded &amp;amp; in frameset HTML and mobile
         nav\_links.

## Date: Tue, 18 Nov 2014

- Fixed: Opensearch wasn't working due to encoding issues HTML meta
         tag and XML output.

## Date: Sat, 15 Nov 2014

- Fixed: Deleting a forum failed due to error while cleaning up
         permissions.
- Added: Allow logging in using email address.
- Fixed: Don't hide the navigation if guest account is disabled.

## Date: Sun, 28 Sep 2014

- Changed: Reimplement per-script CSS by having a class of the
           filename on the body tag.
- Fixed: Escape all HTML attributes.

## Date: Wed, 20 Aug 2014

- Changed: Updated translations.

