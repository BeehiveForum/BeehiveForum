<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Beehive Version
define('BEEHIVE_VERSION', "1.5.2");

// Version supported for upgrades
define('BEEHIVE_VERSION_UPGRADE', "1.3.1");

// Beehive DOB (unixtimestamp)
define('BEEHIVE_DOB', 1018220400);

// Minimum requirements.
define('BEEHIVE_PHP_MIN_VERSION', '5.4.0');
define('BEEHIVE_MYSQL_MIN_VERSION', '5.1.41');

// Require PHP extensions
define('BEEHIVE_PHP_REQUIRED_EXT', 'curl,date,fileinfo,gd,gettext,intl,json,mbstring,mysqli,pcre,xml');

// Constants for date / time.
define('YEAR_IN_SECONDS', 31536000);
define('WEEK_IN_SECONDS', 604800);
define('DAY_IN_SECONDS', 86400);
define('HOUR_IN_SECONDS', 3600);
define('MINUTE_IN_SECONDS', 60);

// Constants for unread cut off.
define('THIRTY_DAYS_IN_SECONDS', 2592000);
define('SIXTY_DAYS_IN_SECONDS', 5184000);
define('NINETY_DAYS_IN_SECONDS', 7776000);
define('HUNDRED_EIGHTY_DAYS_IN_SECONDS', 15552000);

// Other constants for unread cut off.
define('UNREAD_MESSAGES_DISABLED', -1);

// Thread list constants
define('ALL_DISCUSSIONS', 0);
define('UNREAD_DISCUSSIONS', 1);
define('UNREAD_DISCUSSIONS_TO_ME', 2);
define('TODAYS_DISCUSSIONS', 3);
define('UNREAD_TODAY', 4);
define('TWO_DAYS_BACK', 5);
define('SEVEN_DAYS_BACK', 6);
define('HIGH_INTEREST', 7);
define('UNREAD_HIGH_INTEREST', 8);
define('RECENTLY_SEEN', 9);
define('IGNORED_THREADS', 10);
define('BY_IGNORED_USERS', 11);
define('SUBSCRIBED_TO', 12);
define('STARTED_BY_FRIEND', 13);
define('UNREAD_STARTED_BY_FRIEND', 14);
define('STARTED_BY_ME', 15);
define('POLL_THREADS', 16);
define('STICKY_THREADS', 17);
define('MOST_UNREAD_POSTS', 18);
define('SEARCH_RESULTS', 19);
define('DELETED_THREADS', 20);

// Thread Mark as Read Constants
define('THREAD_MARK_READ_ALL', 0);
define('THREAD_MARK_READ_FIFTY', 1);
define('THREAD_MARK_READ_VISIBLE', 2);
define('THREAD_MARK_READ_FOLDER', 3);

// Constants for user permissions
define('USER_PERM_BANNED', 1);
define('USER_PERM_WORMED', 2);
define('USER_PERM_POST_READ', 4);
define('USER_PERM_POST_CREATE', 8);
define('USER_PERM_THREAD_CREATE', 16);
define('USER_PERM_POST_EDIT', 32);
define('USER_PERM_POST_DELETE', 64);
define('USER_PERM_POST_ATTACHMENTS', 128);
define('USER_PERM_FOLDER_MODERATE', 256);
define('USER_PERM_ADMIN_TOOLS', 512);
define('USER_PERM_FORUM_TOOLS', 1024);
define('USER_PERM_HTML_POSTING', 2048);
define('USER_PERM_SIGNATURE', 4096);
define('USER_PERM_GUEST_ACCESS', 8192);
define('USER_PERM_POST_APPROVAL', 16384);
define('USER_PERM_LINKS_MODERATE', 32768);
define('USER_PERM_EMAIL_CONFIRM', 65536);
define('USER_PERM_CAN_IGNORE_ADMIN', 131072);
define('USER_PERM_PILLORIED', 262144);
define('USER_PERM_THREAD_MOVE', 524288);

// MySQL error codes
define('MYSQL_ACCESS_DENIED', 1045);
define('MYSQL_PERMISSION_DENIED', 1142);
define('MYSQL_ERROR_NO_SUCH_TABLE', 1146);
define('MYSQL_ERROR_WRONG_COLUMN_NAME', 1166);
define('MYSQL_CONNECT_ERROR', 9999);

// MySQL date, time and datetime formatting constants for PHP's date function
define('MYSQL_DATE', 'Y-m-d');
define('MYSQL_TIME', 'H:i:s');
define('MYSQL_DATETIME', 'Y-m-d H:i:s');
define('MYSQL_DATE_HOUR_MIN', 'Y-m-d H:i:00');
define('MYSQL_DATETIME_MIDNIGHT', 'Y-m-d 00:00:00');

// Constants for relationship system
define('USER_NORMAL', 0);
define('USER_FRIEND', 1);
define('USER_IGNORED', 2);
define('USER_IGNORED_SIG', 4);
define('USER_IGNORED_COMPLETELY', 8);
define('USER_BLOCK_PM', 16);

// Profile Privacy Constants
define('PROFILE_ITEM_PUBLIC', 0);
define('PROFILE_ITEM_FRIENDS', 1);
define('PROFILE_ITEM_PRIVATE', 2);

// Constants for DOB Display
define('USER_DOB_DISPLAY_NONE', 0);
define('USER_DOB_DISPLAY_AGE', 1);
define('USER_DOB_DISPLAY_DATE', 2);
define('USER_DOB_DISPLAY_BOTH', 3);

// Constants for user anonymity
define('USER_ANON_DISABLED', 0);
define('USER_ANON_ENABLED', 1);
define('USER_ANON_FRIENDS_ONLY', 2);

// Constants for Search Dialog Errors
define('SEARCH_NO_ERROR', 0);
define('SEARCH_USER_NOT_FOUND', 1);
define('SEARCH_NO_MATCHES', 2);
define('SEARCH_FREQUENCY_TOO_GREAT', 3);
define('SEARCH_SPHINX_UNAVAILABLE', 4);

// Constants for Search date range
define('SEARCH_DATE_RANGE_ARRAY', 0);
define('SEARCH_DATE_RANGE_SQL', 1);

// Constants for style creation
define('STYLE_MODE_NONE', 0);
define('STYLE_MODE_RANDOM', 1);

// Constants for style creation errors
define('STYLE_NO_ERROR', 0);
define('STYLE_ALREADY_EXISTS', 1);
define('STYLE_WRITE_ERROR', 2);

// Constants for post page preferences
define('POST_EMOTICONS_DISPLAY', 1);
define('POST_SIGNATURE_DISPLAY', 2);
define('POLL_ADVANCED_DISPLAY', 4);
define('POLL_ADDITIONAL_MESSAGE_DISPLAY', 8);
define('POLL_EDIT_SOFT_DISPLAY', 16);
define('POST_ATTACHMENT_DISPLAY', 32);

// Constants for recipient type
define('POST_RADIO_FRIENDS', 0);
define('POST_RADIO_OTHERS', 1);

// Thread Interest Constants
define('THREAD_IGNORED', -1);
define('THREAD_NOINTEREST', 0);
define('THREAD_INTERESTED', 1);
define('THREAD_SUBSCRIBED', 2);

// Folder Interest Constants
define('FOLDER_IGNORED', -1);
define('FOLDER_NOINTEREST', 0);
define('FOLDER_SUBSCRIBED', 1);

// Thread Admin Constants
define('THREAD_ADMIN_LOCK_DISABLED', 0);
define('THREAD_ADMIN_LOCK_ENABLED', 1);

// Forum Interest Constants
define('FORUM_IGNORED', -1);
define('FORUM_NOINTEREST', 0);
define('FORUM_FAVOURITE', 1);

// Forum Age Ratings
define('FORUM_RATING_GENERAL', 0);
define('FORUM_RATING_FOURTEEN', 1);
define('FORUM_RATING_MATURE', 2);
define('FORUM_RATING_RESTRICTED', 3);

// Forum Access Level Constants
define('FORUM_DISABLED', -2);
define('FORUM_CLOSED', -1);
define('FORUM_UNRESTRICTED', 0);
define('FORUM_RESTRICTED', 1);
define('FORUM_PASSWD_PROTECTED', 2);

// Forum Default Constants
define('FORUM_DEFAULT', 1);

// Forum User access constants
define('FORUM_USER_DISALLOWED', 0);
define('FORUM_USER_ALLOWED', 1);

// Poll closting constants
define('POLL_CLOSE_ONE_DAY', 0);
define('POLL_CLOSE_THREE_DAYS', 1);
define('POLL_CLOSE_SEVEN_DAYS', 2);
define('POLL_CLOSE_THIRTY_DAYS', 3);
define('POLL_CLOSE_NEVER', 4);
define('POLL_CLOSE_NO_CHANGE', 5);

// Poll voting types
define('POLL_VOTE_ANON', 0);
define('POLL_VOTE_PUBLIC', 1);

// Poll constants for vote changing
define('POLL_VOTE_CANNOT_CHANGE', 0);
define('POLL_VOTE_CAN_CHANGE', 1);
define('POLL_VOTE_MULTI', 2);

// Poll View constants
define('POLL_VIEW_TYPE_OPTION', 0);
define('POLL_VIEW_TYPE_USER', 1);

// Poll type constants
define('POLL_HORIZONTAL_GRAPH', 0);
define('POLL_VERTICAL_GRAPH', 1);
define('POLL_TABLE_GRAPH', 2);

// Poll option types
define('POLL_OPTIONS_RADIOS', 0);
define('POLL_OPTIONS_DROPDOWN', 1);

// Poll Guest options
define('POLL_GUEST_ALLOWED', 1);
define('POLL_GUEST_DENIED', 0);

// Poll results showing
define('POLL_SHOW_RESULTS', 1);
define('POLL_HIDE_RESULTS', 0);

// Attachment thumbnail sizes
define('ATTACHMENT_THUMB_SMALL', 1);
define('ATTACHMENT_THUMB_MEDIUM', 2);
define('ATTACHMENT_THUMB_LARGE', 3);

// Attachment thumbnail methods.
define('ATTACHMENT_THUMBNAIL_PHPGD', 0);
define('ATTACHMENT_THUMBNAIL_IMAGEMAGICK', 1);

// PM Constants
define('PM_OUTBOX', 1);
define('PM_UNREAD', 2);
define('PM_READ', 4);
define('PM_SENT', 8);
define('PM_SAVED_IN', 16);
define('PM_SAVED_OUT', 32);
define('PM_SAVED_DRAFT', 64);

// PM Folders
define('PM_FOLDER_NONE', 0);
define('PM_FOLDER_INBOX', 1);
define('PM_FOLDER_SENT', 2);
define('PM_FOLDER_OUTBOX', 3);
define('PM_FOLDER_SAVED', 4);
define('PM_FOLDER_DRAFTS', 5);
define('PM_SEARCH_RESULTS', 6);

// PM Item types
define('PM_OUTBOX_ITEMS', 1);
define('PM_INBOX_ITEMS', 6);
define('PM_SENT_ITEMS', 8);
define('PM_SAVED_ITEMS', 48);
define('PM_DRAFT_ITEMS', 64);
define('PM_ALL_ITEMS', 127);

// Allowed thread types in folders
define('FOLDER_ALLOW_NORMAL_THREAD', 1);
define('FOLDER_ALLOW_POLL_THREAD', 2);
define('FOLDER_ALLOW_ALL_THREAD', 3);

// Profile Item Types
define('PROFILE_ITEM_LARGE_TEXT', 0);
define('PROFILE_ITEM_MEDIUM_TEXT', 1);
define('PROFILE_ITEM_SMALL_TEXT', 2);
define('PROFILE_ITEM_MULTI_TEXT', 3);
define('PROFILE_ITEM_RADIO', 4);
define('PROFILE_ITEM_DROPDOWN', 5);
define('PROFILE_ITEM_HYPERLINK', 6);

// Admin log actions
define('ALL_LOG_ENTIES', 0);
define('CHANGE_USER_STATUS', 1);
define('CHANGE_FORUM_ACCESS', 2);
define('DELETE_ALL_USER_POSTS', 3);
define('EDIT_THREAD_OPTIONS', 7);
define('MOVED_THREADS', 8);
define('CREATE_FOLDER', 9);
define('DELETE_FOLDER', 10);
define('CHANGE_PROFILE_SECT', 11);
define('ADDED_PROFILE_SECT', 12);
define('DELETE_PROFILE_SECT', 13);
define('CHANGE_PROFILE_ITEM', 14);
define('ADDED_PROFILE_ITEM', 15);
define('DELETE_PROFILE_ITEM', 16);
define('EDITED_START_PAGE', 17);
define('CREATED_NEW_STYLE', 18);
define('MOVED_THREAD', 19);
define('CLOSED_THREAD', 20);
define('OPENED_THREAD', 21);
define('RENAME_THREAD', 22);
define('DELETE_POST', 23);
define('EDIT_POST', 24);
define('EDIT_WORD_FILTER', 25);
define('CREATE_THREAD_STICKY', 26);
define('REMOVE_THREAD_STICKY', 27);
define('END_USER_SESSION', 28);
define('EDIT_FORUM_SETTINGS', 30);
define('LOCKED_THREAD', 31);
define('UNLOCKED_THREAD', 32);
define('DELETE_USER_THREAD_POSTS', 33);
define('DELETE_THREAD', 34);
define('ATTACHMENTS_DELETE', 35);
define('EDIT_FORUM_LINKS', 36);
define('APPROVED_POST', 37);
define('CREATE_USER_GROUP', 38);
define('DELETE_USER_GROUP', 39);
define('ADD_USER_TO_GROUP', 40);
define('REMOVE_USER_FROM_GROUP', 41);
define('CHANGE_USER_PASSWD', 42);
define('UPDATE_USER_GROUP', 43);
define('ADD_BANNED_IP', 44);
define('REMOVE_BANNED_IP', 45);
define('ADD_BANNED_LOGON', 46);
define('REMOVE_BANNED_LOGON', 47);
define('ADD_BANNED_NICKNAME', 48);
define('REMOVE_BANNED_NICKNAME', 49);
define('ADD_BANNED_EMAIL', 50);
define('REMOVE_BANNED_EMAIL', 51);
define('ADDED_RSS_FEED', 52);
define('EDITED_RSS_FEED', 53);
define('UNDELETE_THREAD', 54);
define('ADD_BANNED_REFERER', 55);
define('REMOVE_BANNED_REFERER', 56);
define('DELETED_RSS_FEED', 57);
define('UPDATED_BAN', 58);
define('THREAD_SPLIT', 59);
define('THREAD_MERGE', 60);
define('ADD_FORUM_LINKS', 62);
define('DELETE_FORUM_LINKS', 63);
define('EDIT_TOP_LINK_CAPTION', 64);
define('DELETE_USER', 66);
define('DELETE_USER_DATA', 67);
define('BAN_HIT_TYPE_IP', 70);
define('BAN_HIT_TYPE_LOGON', 71);
define('BAN_HIT_TYPE_NICK', 72);
define('BAN_HIT_TYPE_EMAIL', 73);
define('BAN_HIT_TYPE_REF', 74);
define('USER_PERMS_CHANGED', 75);
define('USER_FOLDER_PERMS_CHANGED', 76);
define('BAN_HIT_TYPE_SFS', 77);
define('APPROVED_LINK', 78);
define('DELETE_LINK', 79);
define('EDIT_LINK', 80);

// Admin log grouping
define('ADMIN_LOG_GROUP_NONE', 0);
define('ADMIN_LOG_GROUP_YEAR', 1);
define('ADMIN_LOG_GROUP_MONTH', 2);
define('ADMIN_LOG_GROUP_DAY', 3);
define('ADMIN_LOG_GROUP_HOUR', 4);
define('ADMIN_LOG_GROUP_MINUTE', 5);
define('ADMIN_LOG_GROUP_SECOND', 6);

// Admin visitor log grouping
define('ADMIN_VISITOR_LOG_GROUP_NONE', 0);
define('ADMIN_VISITOR_LOG_GROUP_IP', 1);
define('ADMIN_VISITOR_LOG_GROUP_REFERER', 2);
define('ADMIN_VISITOR_LOG_GROUP_USER_AGENT', 3);

// Link viewmode constants
define('LINKS_VIEW_HIERARCHICAL', 0);
define('LINKS_VIEW_LIST', 1);

define('LINKS_ADD_LINK', 0);
define('LINKS_ADD_FOLDER', 1);

// Error codes for Text Captcha
define('TEXT_CAPTCHA_NO_FONTS', 1);
define('TEXT_CAPTCHA_KEY_ERROR', 2);
define('TEXT_CAPTCHA_GD_ERROR', 4);
define('TEXT_CAPTCHA_FONT_ERROR', 5);

// PM Export constants
define('PM_EXPORT_HTML', 0);
define('PM_EXPORT_XML', 1);
define('PM_EXPORT_SINGLE', 0);
define('PM_EXPORT_MANY', 1);

// Thread Merge and Split constants
define('THREAD_MERGE_START', 0);
define('THREAD_MERGE_END', 1);
define('THREAD_MERGE_BY_CREATED', 2);

define('THREAD_SPLIT_REPLIES', 0);
define('THREAD_SPLIT_FOLLOWING', 1);

// Thread Merge and Split error constants
define('THREAD_TYPE_SPLIT', 1);
define('THREAD_TYPE_MERGE', 0);

define('THREAD_MERGE_FORUM_ERROR', 1);
define('THREAD_MERGE_FOLDER_ERROR', 2);
define('THREAD_MERGE_THREAD_ERROR', 3);
define('THREAD_MERGE_POLL_ERROR', 4);
define('THREAD_MERGE_PERMS_ERROR', 5);
define('THREAD_MERGE_CREATE_ERROR', 6);
define('THREAD_MERGE_QUERY_ERROR', 7);

define('THREAD_SPLIT_INVALID_ARGS', 1);
define('THREAD_SPLIT_FORUM_ERROR', 2);
define('THREAD_SPLIT_THREAD_ERROR', 3);
define('THREAD_SPLIT_POST_ERROR', 4);
define('THREAD_SPLIT_CREATE_ERROR', 5);
define('THREAD_SPLIT_QUERY_ERROR', 6);

// Thread Delete constants
define('THREAD_DELETE_PERMENANT', 0);
define('THREAD_DELETE_NON_PERMENANT', 1);

// Thread Closed constants
define('THREAD_OPEN', 0);
define('THREAD_CLOSED', 1);

// Ban type constants
define('BAN_TYPE_NONE', 0);
define('BAN_TYPE_IP', 1);
define('BAN_TYPE_LOGON', 2);
define('BAN_TYPE_NICK', 3);
define('BAN_TYPE_EMAIL', 4);
define('BAN_TYPE_REF', 5);
define('BAN_TYPE_SFS', 6);

// Search Popup types
define('SEARCH_LOGON', 1);
define('SEARCH_THREAD', 2);

// Search From Periods
define('SEARCH_FROM_TODAY', 1);
define('SEARCH_FROM_YESTERDAY', 2);
define('SEARCH_FROM_DAYBEFORE', 3);
define('SEARCH_FROM_ONE_WEEK_AGO', 4);
define('SEARCH_FROM_TWO_WEEKS_AGO', 5);
define('SEARCH_FROM_THREE_WEEKS_AGO', 6);
define('SEARCH_FROM_ONE_MONTH_AGO', 7);
define('SEARCH_FROM_TWO_MONTHS_AGO', 8);
define('SEARCH_FROM_THREE_MONTHS_AGO', 9);
define('SEARCH_FROM_SIX_MONTHS_AGO', 10);
define('SEARCH_FROM_ONE_YEAR_AGO', 11);
define('SEARCH_FROM_BEGINNING_OF_TIME', 12);

// Search To Periods
define('SEARCH_TO_NOW', 1);
define('SEARCH_TO_TODAY', 2);
define('SEARCH_TO_YESTERDAY', 3);
define('SEARCH_TO_DAYBEFORE', 4);
define('SEARCH_TO_ONE_WEEK_AGO', 5);
define('SEARCH_TO_TWO_WEEKS_AGO', 6);
define('SEARCH_TO_THREE_WEEKS_AGO', 7);
define('SEARCH_TO_ONE_MONTH_AGO', 8);
define('SEARCH_TO_TWO_MONTHS_AGO', 9);
define('SEARCH_TO_THREE_MONTHS_AGO', 10);
define('SEARCH_TO_SIX_MONTHS_AGO', 11);
define('SEARCH_TO_ONE_YEAR_AGO', 12);

// Search User include types
define('SEARCH_FILTER_USER_THREADS', 1);
define('SEARCH_FILTER_USER_POSTS', 2);

// Search Thread Grouping
define('SEARCH_GROUP_NONE', 0);
define('SEARCH_GROUP_THREADS', 1);

// Search Sorting
define('SEARCH_SORT_CREATED', 0);
define('SEARCH_SORT_NUM_REPLIES', 1);
define('SEARCH_SORT_FOLDER_NAME', 2);
define('SEARCH_SORT_AUTHOR_NAME', 3);
define('SEARCH_SORT_RELEVANCE', 4);

// Search Sort Direction
define('SEARCH_SORT_ASC', 0);
define('SEARCH_SORT_DESC', 1);

// My Forums view types
define('FORUMS_SHOW_SEARCH', -2);
define('FORUMS_SHOW_IGNORED', -1);
define('FORUMS_SHOW_ALL', 0);
define('FORUMS_SHOW_FAVS', 1);

// Word Filter
define('WORD_FILTER_TYPE_ALL', 0);
define('WORD_FILTER_TYPE_WHOLE_WORD', 1);
define('WORD_FILTER_TYPE_PREG', 2);

define('WORD_FILTER_DISABLED', 0);
define('WORD_FILTER_ENABLED', 1);

// Start Page
define('START_PAGE_NORMAL', 0);
define('START_PAGE_MESSAGES', 1);
define('START_PAGE_INBOX', 2);
define('START_PAGE_THREAD_LIST', 3);

// Admin User Filter
define('ADMIN_USER_FILTER_NONE', 0);
define('ADMIN_USER_FILTER_ONLINE', 1);
define('ADMIN_USER_FILTER_OFFLINE', 2);
define('ADMIN_USER_FILTER_BANNED', 3);
define('ADMIN_USER_FILTER_APPROVAL', 4);

// Admin User Options
define('ADMIN_USER_OPTION_END_SESSION', 0);
define('ADMIN_USER_OPTION_APPROVE', 1);

// Admin RSS Feed Settings Frequencies
define('RSS_FEED_UPDATE_NEVER', 0);
define('RSS_FEED_UPDATE_THIRTY_MINS', 30);
define('RSS_FEED_UPDATE_ONE_HOUR', 60);
define('RSS_FEED_UPDATE_SIX_HOURS', 360);
define('RSS_FEED_UPDATE_TWELVE_HOURS', 720);
define('RSS_FEED_UPDATE_ONCE_A_DAY', 1440);
define('RSS_FEED_UPDATE_ONCE_A_WEEK', 10080);

// Logon Form Constants
define('LOGON_FORM_DEFAULT', 0);
define('LOGON_FORM_HIDE_TICKBOX', 1);
define('LOGON_FORM_SESSION_EXPIRED', 2);
define('LOGON_FORM_HIDE_LINKS', 4);

// Admin User Alias View Constants
define('USER_ALIAS_IPADDRESS', 0);
define('USER_ALIAS_EMAIL', 1);
define('USER_ALIAS_PASSWD', 2);
define('USER_ALIAS_REFERER', 3);

// Google AdSense support
define('ADSENSE_DISPLAY_NONE', 0);
define('ADSENSE_DISPLAY_GUESTS', 1);
define('ADSENSE_DISPLAY_ALL_USERS', 2);

define('ADSENSE_DISPLAY_TOP_OF_ALL_PAGES', 0);
define('ADSENSE_DISPLAY_TOP_OF_MESSAGES', 1);
define('ADSENSE_DISPLAY_BOTTOM_OF_ALL_PAGES', 2);
define('ADSENSE_DISPLAY_BOTTOM_OF_MESSAGES', 3);
define('ADSENSE_DISPLAY_ONCE_AFTER_NTH_MSG', 4);
define('ADSENSE_DISPLAY_AFTER_EVERY_NTH_MSG', 5);
define('ADSENSE_DISPLAY_AFTER_RANDOM_MSG', 6);

// Mail Functions
define('MAIL_FUNCTION_PHP', 0);
define('MAIL_FUNCTION_SMTP', 1);
define('MAIL_FUNCTION_SENDMAIL', 2);
define('MAIL_FUNCTION_NONE', 3);

// Browser detection
define('BROWSER_UNKNOWN', 0);
define('BROWSER_LYNX', 1);
define('BROWSER_CHROME', 2);
define('BROWSER_SAFARI', 4);
define('BROWSER_GECKO', 8);
define('BROWSER_MSIE_WIN', 16);
define('BROWSER_MSIE_MAC', 32);
define('BROWSER_OPERA', 64);
define('BROWSER_NETSCAPE4', 128);
define('BROWSER_IPHONE', 256);
define('BROWSER_MSIE', 512);
define('BROWSER_MSIE7', 1024);
define('BROWSER_KONQUEROR', 2048);
define('BROWSER_WEBKIT', 4096);
define('BROWSER_AOL', 8192);
