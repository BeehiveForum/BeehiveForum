<?php

function format_user_name($u_logon,$u_nickname)
{
    if($u_nickname != ""){
        $fmt = $u_nickname . " (" . $u_logon . ")";
    } else {
        $fmt = $u_logon;
    }
    
    return $fmt;
}

function format_url2link($html)
{
    $fhtml = preg_replace("/\b((http(s?):\/\/)|(www\.))([\w\.]+)([\/\w+\.]+)\b/i",
        "<a href=\"http$3://$4$5$6\" target=\"_blank\">$2$4$5$6</a>", $html);
    return $fhtml;
}

?>
