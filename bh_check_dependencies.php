<?php

  $include_files_dir   = "forum/include";
  $include_files_array = array();
  
  $source_files_dir_array = array("forum", "forum/include");
  $source_files_array     = array();
  
  if (is_dir($include_files_dir)) {
  
      if ($dir = opendir($include_files_dir)) {
      
          while (($file = readdir($dir)) !== false) {
              
              $pathinfo = pathinfo("$include_files_dir/$file");
              
              if ($pathinfo['extension'] == 'php') {
              
                  $file_contents = file_get_contents("$include_files_dir/$file");
                  
                  if (preg_match_all("/function ([a-z1-9-_]+)[ ]?\(/i", $file_contents, $function_matches)) {
                  
                      for ($i = 0; $i < sizeof($function_matches[1]); $i++) {
                          
                          $include_files_array[$function_matches[1][$i]] = $file;
                      }
                  }
              }
          }
      }
  }
  
  foreach($source_files_dir_array as $source_files_dir) {
  
      if (is_dir($source_files_dir)) {

          if ($dir = opendir($source_files_dir)) {
        
              while (($file = readdir($dir)) !== false) {
              
                  $pathinfo = pathinfo("$source_files_dir/$file");
              
                  if ($pathinfo['extension'] == 'php') {
              
                      $file_contents = file_get_contents("$source_files_dir/$file");
                  
                      if (preg_match_all("/([a-z1-9-_]+)[ ]?\(/i", $file_contents, $function_matches)) {
                  
                          for ($i = 0; $i < sizeof($function_matches[1]); $i++) {
                        
                              $source_files_array[$file][] = $function_matches[1][$i];
                          }
                      }
                  }
              }
          }
      }
  }
  
  foreach($source_files_array as $source_filename => $source_file) {
      
      $file_include_array = array();
      
      echo " === $source_filename ===\n\n";  
  
      foreach($source_file as $function_name) {
          
          if (isset($include_files_array[$function_name])) {
          
              if (!in_array($include_files_array[$function_name], $file_include_array)) {
                  $file_include_array[] = $include_files_array[$function_name];
              }
          }
      }
      
      sort($file_include_array);
      
      foreach ($file_include_array as $include_file) {
          echo "include_once(\"./include/$include_file\");\n";
      }

      echo "\n\n";
  }

?> 