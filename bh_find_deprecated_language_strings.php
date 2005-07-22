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

$files_array = array();
$deprecated_array = array();
$unused_langs = array();

$lang = load_language_file("en.inc.php");

foreach($lang as $lang_key => $lang_value) {
    $unused_langs[$lang_key] = $lang_value;
}

if (get_files("./forum", $files_array)) {

    if (get_files("./forum/include", $files_array)) {

        echo "Please wait, checking files...\n\n";

        foreach($files_array as $filename) {

            if ($file_contents = file_get_contents($filename)) {

                echo "CHECKING: $filename\n";

                reset($lang);

                foreach($lang as $lang_key => $lang_value) {

                    if (stristr($file_contents, "\$lang['$lang_key']")) {
                        unset($unused_langs[$lang_key]);
                    }
                }

            }else {

                echo "FAILED TO LOAD: $filename\n";
            }
        }

        if (sizeof($unused_langs) > 0) {

            echo "\nUnused language strings:\n\n";

            foreach($unused_langs as $lang_key => $lang_value) {

                echo "\$lang['$lang_key'] = \"$lang_value\";\n";
            }

        }else {

            echo "\nNo unused language strings detected!\n";
        }
    }
}

?>