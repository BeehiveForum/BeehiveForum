<?php
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
    $login = $HTTP_POST_VARS['logon'];
} else {
    $login = "";
    $valid = false;
}

if(isset($HTTP_POST_VARS['pw'])){
    $password = $HTTP_POST_VARS['pw'];
} else {
    $password = "";
    $valid = false;
}

if(isset($HTTP_POST_VARS['cpw'])){
    $cpassword = $HTTP_POST_VARS['cpw'];
} else {
    $cpassword = "";
    $valid = false;
}

if(isset($HTTP_POST_VARS['nickname'])){
    $nickname = $HTTP_POST_VARS['nickname'];
} else {
    $nickname = "";
    $valid = false;
}

if(isset($HTTP_POST_VARS['email'])){
    $email = $HTTP_POST_VARS['email'];
} else {
    $email = "";
    $valid = false;
}

if($logon==""){
    $error_html = "<h2>A logon name is required</h2>";
    $valid = false;
} else if($password==""){
    $error_html = "<h2>A password is required</h2>";
    $valid = false;
} else if($cpassword==""){
    $error_html = "<h2>A confirmation password is required</h2>";
    $valid = false;
} else if($nickname==""){
    $error_html = "<h2>A nickname is required</h2>";
    $valid = false;
} else if($email==""){
    $error_html = "<h2>An email address is required</h2>";
    $valid = false;
}

if($valid){
    if(user_exists($logon)){
        $error_html = "<h2>Sorry, a user with that name already exists</h2>";
        $valid = false;
    }
}

if($valid){
    if(!($password == $cpassword)){
        $error_html = "<h2>Passwords do not match</h2>";
        $valid = false;
    }
}

if($valid){
    $new_uid = user_create($login,$password,$nickname,$email);
    if($new_uid > -1){
        $sess_uid = $new_uid;
    } else {
        $error_html = "<h2>Error creating user record</h2>";
        $valid = false;
    }
}

html_draw_top();

if($valid){
    echo "<p>Huzzah! Your user record has been created successfully!</p>";
    echo "<p><a href=\"messages.php\">Go to messages.</a></p>";
} else {
    echo "<h1>User Registration</h1>";
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
    echo "</tr><tr><td align=\"right\">Confirm</td>";
    echo "<td><input type=\"text\" name=\"cpw\" value=\"" . $cpassword . "\"></td>";
    echo "</tr><tr><td align=\"right\">Nickname</td>";
    echo "<td><input type=\"text\" name=\"nickname\" value=\"" . $nickname . "\"></td>";
    echo "</tr><tr><td align=\"right\">Email</td>";
    echo "<td><input type=\"text\" name=\"email\" value=\"" . $email . "\"></td>";
    echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
    echo "<input name=\"submit\" type=\"submit\" value=\"Submit\">";
}

html_draw_bottom();
?>

