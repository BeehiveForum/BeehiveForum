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

function format_time($time)
{
	if (date("j", $time) == date("j") && date("n", $time) == date("n") && date("Y", $time) == date("Y")) {
		$fmt = date("H:i", $time);
	} else {
		$fmt = date("j M", $time);
	}
    return $fmt;
}

function timestamp_to_date($timestamp)
{
    $year=substr($timestamp,0,4);
    $month=substr($timestamp,4,2);
    $day=substr($timestamp,6,2);
    $hour=substr($timestamp,8,2);
    $minute=substr($timestamp,10,2);
    $second=substr($timestamp,12,2);
    $newdate=mktime($hour,$minute,$second,$month,$day,$year);
    return ($newdate);
}  
?>
