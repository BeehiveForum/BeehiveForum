<?php 
if(isset($sess_uid)){
    unset($sess_uid);
}

session_start();

session_register("sess_uid");
require_once("./include/html.inc.php");
require_once("./include/user.inc.php");

if(isset($sess_uid)){
    html_draw_top();
    echo "User ID " . $sess_uid . " already logged in.";
    html_draw_bottom();
    exit;
}

$valid = true;

if(isset($HTTP_POST_VARS['logon'])){
    $logon = $HTTP_POST_VARS['logon'];
} else {
    $logon = "";
    $valid = false;
}

if(isset($HTTP_POST_VARS['pw'])){
    $password = $HTTP_POST_VARS['pw'];
} else {
    $password = "";
    $valid = false;
}

if($logon==""){
    $error_html = "<h2>A logon name is required</h2>";
    $valid = false;
} else if($password==""){
    $error_html = "<h2>A password is required</h2>";
    $valid = false;
}

if($valid){
    $luid = user_logon($logon,$pw);
    if($luid>-1){
        $sess_uid = $luid;
    } else {
        $error_html = "<h2>Invalid login</h2>";
        $valid = false;
    }
}

html_draw_top();

if($valid){
    echo "<p>w00t! You've logged on.</p>";
    echo "<p><a href=\"messages.php\">Go to messages.</a></p>";
} else {
    echo "<h1>User Logon</h1>";
    if(isset($error_html)){
        echo $error_html;
    }
    echo "<div align=\"center\">";
    echo "<form name=\"register\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">";
    echo "<table>";
    echo "<tr><td align=\"right\">Login Name</td>";
    echo "<td><input type=\"text\" name=\"logon\" value=\"" . $logon . "\"></td>";
    echo "</tr><tr><td align=\"right\">Password</td>";
    echo "<td><input type=\"text\" name=\"pw\" value=\"" . $password . "\"></td>";
    echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
    echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
}

html_draw_bottom();
?>

