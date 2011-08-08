<?php

/*
  +----------------------------------------------------------------------+
  | Uploadprogress extension                                             |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006-2008 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Christian Stocker (chregu@php.net)                           |
  +----------------------------------------------------------------------+
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="HTML Tidy for Linux/x86 (vers 1 September 2005), see www.w3.org" />
<script type="text/javascript">
<?php
if (count($_FILES) > 0) {
  echo  "parent.UP.stop(true);";
} else {
  echo "parent.UP.stop(false);";
}
?>
</script>

<title></title>
</head>

<body>
  File uploaded:
  <pre>
<?php
var_dump($_FILES);
?>

</pre>
</body>
</html>
