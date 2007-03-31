<?php

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

function get_file_list(&$file_list, $path)
{
    if ($dir = opendir($path)) {

        while(($file = readdir($dir)) !== false) {

            if ($file != "." && $file != "..") {

                if (is_dir("$path/$file")) {

                    get_file_list($file_list, "$path/$file");

                }else {

                    if (preg_match("/\.php$/i", $file) > 0) {

                        if (!is_array($file_list)) $file_list = array();
                        $file_list[] = "$path/$file";
                    }
                }
            }
        }
    }
}

get_file_list($file_list, "forum");

foreach($file_list as $php_file) {

    $php_file_contents = file_get_contents($php_file);

    if (preg_match_all("/\\\$lang\['([a-z0-9_]+)'\]/i", $php_file_contents, $lang_matches) > 0) {

        $lang_matches = array_unique($lang_matches[1]);

        if ($lang = load_language_file('en.inc.php')) {

            foreach ($lang_matches as $lang_key) {

                if (!isset($lang[$lang_key])) {
                    echo "\$lang['$lang_key'] = \"\";\n";
                }
            }
        }
    }
}

?>