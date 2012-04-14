<?php date_default_timezone_set('UTC'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Teh Forum</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<!-- We Like Bees -->
<body style="margin: 0px; background-color: rgb(36,55,74);">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <?php if ((date('md') >= '1201' && date('md') <= '1231') || (date('md') >= '0101' && date('md') <= '0131')) { ?>
        <td align="left" valign="middle"><a target="_blank" href="/"><img src="./images/beehive_logo_winter.png" border="0" alt="Beehive Forum Logo" /></a></td>
    <?php } else { ?>
        <td align="left" valign="middle"><a target="_blank" href="/"><img src="./images/beehive_logo.png" border="0" alt="Beehive Forum Logo" /></a></td>
    <?php } ?>
    <td align="right" valign="middle"><object type="application/x-shockwave-flash" data="./images/beehive_header.swf" width="400" height="60"><param name="movie" value="./images/beehive_header.swf" /></object></td>
  </tr>
</table>
</body>
</html>
