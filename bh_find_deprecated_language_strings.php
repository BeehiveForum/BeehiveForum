<?php

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

function get_files($path, &$files_array)
{
    if (!is_array($files_array)) return false;

    if ($dir = opendir($path)) {

        while (($file = readdir($dir)) !== false) {

            if ($file != "." && $file != "..") {

                if (!is_dir("$path/$file")) {

                    $path_parts = pathinfo("$path/$file");

                    if (isset($path_parts['extension']) && $path_parts['extension'] == 'php') {

                        $files_array[] = "$path/$file";
                    }
                }
            }
        }

        closedir($dir);
        return true;
    }
}

set_time_limit(0);

$lang = load_language_file("en.inc.php");

$files_array = array();
$deprecated_array = array();

if (get_files("E:/beehiveforum/forum", $files_array)) {

    if (get_files("E:/beehiveforum/forum/include", $files_array)) {

        foreach($lang as $lang_key => $lang_value) {

            reset($files_array);

            $lang_used = false;

            foreach($files_array as $filename) {

                $file_contents = file_get_contents($filename);
                if (strstr($file_contents, "\$lang['$lang_key']")) $lang_used = true;
            }

            if (!$lang_used) {

                if (is_array($lang[$lang_key])) {

                    foreach ($lang[$lang_key] as $lang_sub_key => $lang_sub_value) {

                        echo "\$lang['$lang_key']['$lang_sub_key'] = \"$lang_sub_value\";\n";
                    }

                }else {

                    echo "\$lang['$lang_key'] = \"$lang_value\";\n";
                }
            }
        }
    }
}

?>