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
:: $Id: check_files.cmd,v 1.2 2004-02-22 15:33:16 decoyduck Exp $
:: 
:: Checks each of the files includes with Beehive by parsing the file
:: using the CLI version of php.exe. 
::
:: Requirements:
::   - MS Windows NT/2000/XP.
::   - CLI php.exe in your PATH.

@echo off
echo Checking Files for errors. Please wait...
for %%a in (*.php) do php.exe -l %%a >> error_log.txt
for %%a in (forum\*.php) do php.exe -l %%a >> error_log.txt
for %%a in (forum\include\*.php) do php.exe -l %%a >> error_log.txt
for %%a in (forum\include\languages\*.php) do php.exe -l %%a >> error_log.txt
start error_log.txt