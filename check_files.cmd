:: ======================================================================
:: Copyright Project BeehiveForum 2002
::
:: This file is part of BeehiveForum.
::
:: BeehiveForum is free software; you can redistribute it and/or modify
:: it under the terms of the GNU General Public License as published by
:: the Free Software Foundation; either version 2 of the License, or
:: (at your option) any later version.
:: 
:: BeehiveForum is distributed in the hope that it will be useful,
:: but WITHOUT ANY WARRANTY; without even the implied warranty of
:: MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
:: GNU General Public License for more details.
:: 
:: You should have received a copy of the GNU General Public License
:: along with Beehive; if not, write to the Free Software
:: Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
:: USA
:: ======================================================================
::
:: $Id: check_files.cmd,v 1.1 2004-02-22 15:24:39 decoyduck Exp $
:: 
:: Checks each of the files includes with Beehive by parsing the file
:: using the CLI version of php.exe. 
::
:: Requirements:
::   - MS Windows NT/2000/XP.
::   - CLI php.exe in your PATH.

@echo off
echo Checking Files for errors. Please wait...
php.exe -l bh_check_languages.php > error_log.txt
php.exe -l bh_x-hacker_translate.php >> error_log.txt
php.exe -l forum\admin.php >> error_log.txt
php.exe -l forum\admin_folders.php >> error_log.txt
php.exe -l forum\admin_folder_access.php >> error_log.txt
php.exe -l forum\admin_main.php >> error_log.txt
php.exe -l forum\admin_make_style.php >> error_log.txt
php.exe -l forum\admin_menu.php >> error_log.txt
php.exe -l forum\admin_prof_items.php >> error_log.txt
php.exe -l forum\admin_prof_sect.php >> error_log.txt
php.exe -l forum\admin_startpage.php >> error_log.txt
php.exe -l forum\admin_user.php >> error_log.txt
php.exe -l forum\admin_users.php >> error_log.txt
php.exe -l forum\admin_viewlog.php >> error_log.txt
php.exe -l forum\admin_wordfilter.php >> error_log.txt
php.exe -l forum\attachments.php >> error_log.txt
php.exe -l forum\change_pw.php >> error_log.txt
php.exe -l forum\create_poll.php >> error_log.txt
php.exe -l forum\delete.php >> error_log.txt
php.exe -l forum\discussion.php >> error_log.txt
php.exe -l forum\display.php >> error_log.txt
php.exe -l forum\edit.php >> error_log.txt
php.exe -l forum\edit_attachments.php >> error_log.txt
php.exe -l forum\edit_email.php >> error_log.txt
php.exe -l forum\edit_password.php >> error_log.txt
php.exe -l forum\edit_poll.php >> error_log.txt
php.exe -l forum\edit_prefs.php >> error_log.txt
php.exe -l forum\edit_profile.php >> error_log.txt
php.exe -l forum\edit_signature.php >> error_log.txt
php.exe -l forum\email.php >> error_log.txt
php.exe -l forum\fontsize.php >> error_log.txt
php.exe -l forum\forgot_pw.php >> error_log.txt
php.exe -l forum\forum_options.php >> error_log.txt
php.exe -l forum\getattachment.php >> error_log.txt
php.exe -l forum\index.php >> error_log.txt
php.exe -l forum\interest.php >> error_log.txt
php.exe -l forum\links.php >> error_log.txt
php.exe -l forum\links_add.php >> error_log.txt
php.exe -l forum\links_detail.php >> error_log.txt
php.exe -l forum\llogon.php >> error_log.txt
php.exe -l forum\lmessages.php >> error_log.txt
php.exe -l forum\logon.php >> error_log.txt
php.exe -l forum\logout.php >> error_log.txt
php.exe -l forum\lpost.php >> error_log.txt
php.exe -l forum\lthread_list.php >> error_log.txt
php.exe -l forum\messages.php >> error_log.txt
php.exe -l forum\nav.php >> error_log.txt
php.exe -l forum\pm.php >> error_log.txt
php.exe -l forum\pm_edit.php >> error_log.txt
php.exe -l forum\pm_write.php >> error_log.txt
php.exe -l forum\pollresults.php >> error_log.txt
php.exe -l forum\post.php >> error_log.txt
php.exe -l forum\register.php >> error_log.txt
php.exe -l forum\search.php >> error_log.txt
php.exe -l forum\set_relation.php >> error_log.txt
php.exe -l forum\start.php >> error_log.txt
php.exe -l forum\start_left.php >> error_log.txt
php.exe -l forum\start_main.php >> error_log.txt
php.exe -l forum\start_main_sf.php >> error_log.txt
php.exe -l forum\thread_admin.php >> error_log.txt
php.exe -l forum\thread_list.php >> error_log.txt
php.exe -l forum\user.php >> error_log.txt
php.exe -l forum\user_folder.php >> error_log.txt
php.exe -l forum\user_font.php >> error_log.txt
php.exe -l forum\user_logout.php >> error_log.txt
php.exe -l forum\user_main.php >> error_log.txt
php.exe -l forum\user_menu.php >> error_log.txt
php.exe -l forum\user_profile.php >> error_log.txt
php.exe -l forum\user_rel.php >> error_log.txt
php.exe -l forum\user_stats.php >> error_log.txt
php.exe -l forum\visitor_log.php >> error_log.txt
php.exe -l forum\include\admin.inc.php >> error_log.txt
php.exe -l forum\include\attachments.inc.php >> error_log.txt
php.exe -l forum\include\beehive.inc.php >> error_log.txt
php.exe -l forum\include\config.inc.php >> error_log.txt
php.exe -l forum\include\constants.inc.php >> error_log.txt
php.exe -l forum\include\db.inc.php >> error_log.txt
php.exe -l forum\include\edit.inc.php >> error_log.txt
php.exe -l forum\include\email.inc.php >> error_log.txt
php.exe -l forum\include\errorhandler.inc.php >> error_log.txt
php.exe -l forum\include\fixhtml.inc.php >> error_log.txt
php.exe -l forum\include\folder.inc.php >> error_log.txt
php.exe -l forum\include\form.inc.php >> error_log.txt
php.exe -l forum\include\format.inc.php >> error_log.txt
php.exe -l forum\include\forum.inc.php >> error_log.txt
php.exe -l forum\include\gzipenc.inc.php >> error_log.txt
php.exe -l forum\include\header.inc.php >> error_log.txt
php.exe -l forum\include\html.inc.php >> error_log.txt
php.exe -l forum\include\htmltools.inc.php >> error_log.txt
php.exe -l forum\include\ip.inc.php >> error_log.txt
php.exe -l forum\include\lang.inc.php >> error_log.txt
php.exe -l forum\include\light.inc.php >> error_log.txt
php.exe -l forum\include\links.inc.php >> error_log.txt
php.exe -l forum\include\make_style.inc.php >> error_log.txt
php.exe -l forum\include\messages.inc.php >> error_log.txt
php.exe -l forum\include\perm.inc.php >> error_log.txt
php.exe -l forum\include\pm.inc.php >> error_log.txt
php.exe -l forum\include\poll.inc.php >> error_log.txt
php.exe -l forum\include\post.inc.php >> error_log.txt
php.exe -l forum\include\profile.inc.php >> error_log.txt
php.exe -l forum\include\search.inc.php >> error_log.txt
php.exe -l forum\include\session.inc.php >> error_log.txt
php.exe -l forum\include\stats.inc.php >> error_log.txt
php.exe -l forum\include\thread.inc.php >> error_log.txt
php.exe -l forum\include\threads.inc.php >> error_log.txt
php.exe -l forum\include\user.inc.php >> error_log.txt
php.exe -l forum\include\user_profile.inc.php >> error_log.txt
php.exe -l forum\include\user_rel.inc.php >> error_log.txt
php.exe -l forum\include\languages\en.inc.php >> error_log.txt
php.exe -l forum\include\languages\fr.inc.php >> error_log.txt
php.exe -l forum\include\languages\gangsta.inc.php >> error_log.txt
php.exe -l forum\include\languages\x-hacker.inc.php >> error_log.txt
start error_log.txt