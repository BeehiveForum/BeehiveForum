<?php

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

// This is a list of directories that bh_cvs_log_parse.php should
// ignore when generating the changelog. Add paths here to prevent
// them from being indexed.

$exclude_dirs = array('./forum/tiny_mce',
                      './forum/tiny_mce/plugins',
                      './forum/tiny_mce/plugins/searchreplace',
                      './forum/tiny_mce/plugins/searchreplace/images',
                      './forum/tiny_mce/plugins/searchreplace/langs',
                      './forum/tiny_mce/plugins/table',
                      './forum/tiny_mce/plugins/table/images',
                      './forum/tiny_mce/plugins/table/langs',
                      './forum/tiny_mce/themes',
                      './forum/tiny_mce/themes/advanced',
                      './forum/tiny_mce/themes/advanced/docs',
                      './forum/tiny_mce/themes/advanced/docs/cs',
                      './forum/tiny_mce/themes/advanced/docs/cs/images',
                      './forum/tiny_mce/themes/advanced/docs/de',
                      './forum/tiny_mce/themes/advanced/docs/de/images',
                      './forum/tiny_mce/themes/advanced/docs/en',
                      './forum/tiny_mce/themes/advanced/docs/en/images',
                      './forum/tiny_mce/themes/advanced/docs/es',
                      './forum/tiny_mce/themes/advanced/docs/es/images',
                      './forum/tiny_mce/themes/advanced/docs/fi',
                      './forum/tiny_mce/themes/advanced/docs/fi/images',
                      './forum/tiny_mce/themes/advanced/docs/fr',
                      './forum/tiny_mce/themes/advanced/docs/fr/images',
                      './forum/tiny_mce/themes/advanced/docs/fr_ca',
                      './forum/tiny_mce/themes/advanced/docs/fr_ca/images',
                      './forum/tiny_mce/themes/advanced/docs/hu',
                      './forum/tiny_mce/themes/advanced/docs/hu/images',
                      './forum/tiny_mce/themes/advanced/docs/images',
                      './forum/tiny_mce/themes/advanced/docs/it',
                      './forum/tiny_mce/themes/advanced/docs/it/images',
                      './forum/tiny_mce/themes/advanced/docs/nl',
                      './forum/tiny_mce/themes/advanced/docs/nl/images',
                      './forum/tiny_mce/themes/advanced/docs/pl',
                      './forum/tiny_mce/themes/advanced/docs/pl/images',
                      './forum/tiny_mce/themes/advanced/docs/sv',
                      './forum/tiny_mce/themes/advanced/docs/sv/images',
                      './forum/tiny_mce/themes/advanced/docs/zh_cn',
                      './forum/tiny_mce/themes/advanced/docs/zh_cn/images',
                      './forum/tiny_mce/themes/advanced/images',
                      './forum/tiny_mce/themes/advanced/langs',
                      './forum/geshi',
                      './forum/geshi/contrib',
                      './forum/geshi/docs',
                      './forum/geshi/geshi');

?>