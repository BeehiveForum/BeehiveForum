<?php

// header.inc.php:
// Functions for manipulating the HTTP header
// These must be called BEFORE anything is output to the page - including blank lines outside PHP
// tags in include files, etc.

function header_no_cache()
{
    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT");               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
    header("Cache-Control: no-store, no-cache, must-revalidate");   // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

function header_redirect($uri)
{
    header("Location: $uri");
    exit;
}

?>
