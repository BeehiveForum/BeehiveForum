/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

function openWindow(url, name, width, height) {
	window.open(url, name, 'width=' + width + ', height=' + height + ', toolbars=no, scrollbars=1');
}

function confirmFolderIgnore() {
        return window.confirm('Are you sure you want to ignore this folder?');
}

function confirmFolderUnignore() {
        return window.confirm('Are you sure you want to stop ignoring this folder?');
}