<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

define('BH_INCLUDE_PATH', "./forum/include/");

require_once BH_INCLUDE_PATH. 'format.inc.php';

set_time_limit(0);

header('Content-Type: text/plain');

$source_files_array = array();

$include_files_required_array = array();

$include_files_functions_array = array(
    'db.inc.php' => array(
        '/db::[^\(]+\(/imu'
    ),
    'errorhandler.inc.php' => array(
        '/new Error\s*\(/imu'
    ),
    'geshi.inc.php' => array(
        '/new GeSHi\s*\(/imu',
    ),
    'html.inc.php' => array(
        '/new html_frameset\s*\(/imu',
        '/new html_frameset_rows\s*\(/imu',
        '/new html_frameset_cols\s*\(/imu',
        '/new html_frame\s*\(/imu',
    ),
    'lang.inc.php' => array(
        '/[\s|\.|,|\(]gettext\s*\(/imu'
    ),
    'post.inc.php' => array(
        '/new MessageTextParse\s*\(/imu',
    ),
    'rss_feed.inc.php' => array(
        '/new rss_feed_item\s*\(/imu',
    ),
    'session.inc.php' => array(
        '/session::[^\(]+\(/imu',
    ),
    'swift.inc.php' => array(
        '/Swift_TransportFactory::get\s*\(/imu',
        '/new Swift_SmtpTransportSingleton\s*\(/imu',
        '/new Swift_MailTransportSingleton\s*\(/imu',
        '/new Swift_SendmailTransportSingleton\s*\(/imu',
        '/new Swift_MessageBeehive\s*\(/imu',
    ),
    'text_captcha.inc.php' => array(
        '/new captcha\s*\(/imu'
    ),
);

$include_files_constants_array = array();

$ignore_files_array = array(
    'errorhandler.inc.php',
    'forum.inc.php',
    'server.inc.php',
    'cache.inc.php',
    'install.inc.php',
    'word_filter.inc.php',
    'banned.inc.php',
    'format.inc.php',
    'header.inc.php',
    'html.inc.php',
    'lang.inc.php',
);

$ignore_functions_array = array();

$ignore_constants_array = array(
    'BH_INCLUDE_PATH',
    'BEEHIVE_DEVELOPER_MODE',
    'BEEHIVEMODE_LIGHT'
);

$source_files_dir_array = array(
    'forum',
    'forum/include'
);

$ignore_functions_preg = implode('|', array_map('preg_quote_callback', $ignore_functions_array));

$ignore_constants_preg = implode('|', array_map('preg_quote_callback', $ignore_constants_array));

set_time_limit(0);

header('Content-Type: text/plain');

echo "Getting list of functions...\n";

foreach ($source_files_dir_array as $include_file_dir) {

    if (($dir = opendir($include_file_dir)) !== false) {

        while (($file = readdir($dir)) !== false) {

            $path_info_array = pathinfo("$include_file_dir/$file");

            if (!isset($path_info_array['extension']) || ($path_info_array['extension'] != 'php')) {
                continue;
            }

            $source_files_array[] = "$include_file_dir/$file";

            $source_file_contents = file_get_contents("$include_file_dir/$file");

            $function_matches = array();

            $constant_matches = array();

            if (preg_match_all('/^function\s+([^\(]+)\(/imu', $source_file_contents, $function_matches)) {

                if (sizeof($ignore_functions_array) > 0) {
                    $function_matches[1] = preg_grep("/$ignore_functions_preg/u", $function_matches[1], PREG_GREP_INVERT);
                }

                if (sizeof($function_matches[1]) > 0) {

                    if (!isset($include_files_functions_array[$file])) {
                        $include_files_functions_array[$file] = array();
                    }

                    foreach ($function_matches[1] as $function_match) {

                        $include_files_functions_array[$file][] = sprintf(
                            '/[\s|\.|,|\(]%s\s*\(/mu',
                            preg_quote($function_match)
                        );
                    }
                }
            }

            if (preg_match_all('/define\s*\(["|\']([A-Z0-9-_]+)["|\'],\s*[^\)]+\)/imu', $source_file_contents, $constant_matches)) {

                if (sizeof($ignore_constants_array) > 0) {
                    $constant_matches[1] = preg_grep("/$ignore_constants_preg/u", $constant_matches[1], PREG_GREP_INVERT);
                }

                if (sizeof($constant_matches[1]) > 0) {

                    if (!isset($include_files_constants_array[$file])) {
                        $include_files_constants_array[$file] = array();
                    }

                    foreach ($constant_matches[1] as $constant_match) {
                        $include_files_constants_array[$file][] = $constant_match;
                    }
                }
            }
        }
    }
}

ksort($include_files_functions_array);

sort($source_files_array);

echo "Checking files...\n\n";

foreach ($source_files_array as $source_file) {

    echo "Checking ", $source_file, "...\n";

    $source_file_contents = file_get_contents($source_file);

    foreach ($include_files_functions_array as $include_file => $function_names_array) {

        if ($include_file !== basename($source_file) && !in_array($include_file, $ignore_files_array)) {

            $include_file_line = "require_once BH_INCLUDE_PATH. '$include_file'";

            $include_file_line_preg = preg_quote($include_file_line, "/");

            if (preg_match("/$include_file_line_preg/imu", $source_file_contents) > 0) {
                continue;
            }

            foreach ($function_names_array as $function_name_preg) {

                if (preg_match_all($function_name_preg, $source_file_contents) > 0) {
                    $include_files_required_array[$source_file][$include_file] = $include_file_line;
                }
            }
        }
    }

    foreach ($include_files_constants_array as $include_file => $constant_names_array) {

        if ($include_file !== basename($source_file) && !in_array($include_file, $ignore_files_array)) {

            $include_file_line = "require_once BH_INCLUDE_PATH. '$include_file'";

            $include_file_line_preg = preg_quote($include_file_line, "/");

            if (preg_match("/$include_file_line_preg/mu", $source_file_contents) > 0) {
                continue;
            }

            $constant_names_preg = implode("|", array_map('preg_quote_callback', $constant_names_array));

            if (preg_match("/{$constant_names_preg}/u", $source_file_contents) > 0) {
                $include_files_required_array[$source_file][$include_file] = $include_file_line;
            }
        }
    }

    break;
}

echo "Found ", sizeof($include_files_required_array), " missing requires.\n\n";

ksort($include_files_required_array);

if (sizeof($include_files_required_array) > 0) {

    foreach ($include_files_required_array as $source_file => $required_include_files) {

        ksort($required_include_files);

        $required_includes_lines = sprintf(
            "// Required includes\n%s;\n// End Required includes\n\n",
            implode(";\n", $required_include_files)
        );

        $source_file_contents = file_get_contents($source_file);

        $source_file_contents = preg_replace("/\/\/ Required includes\n.*\/\/ End Required includes\n\n/mu", $required_includes_lines, $source_file_contents);

        file_put_contents($source_file, $source_file_contents, FILE_TEXT);
    }
}

?>