--TEST--
uploadprogress_get_info - Warns when too few arguments

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');
if (PHP_MAJOR_VERSION < 8) exit('skip test only valid on PHP 8+');

--FILE--
<?php
$info = uploadprogress_get_info();
var_dump($info);

--EXPECTF--
Fatal error: Uncaught ArgumentCountError: uploadprogress_get_info() expects exactly 1 parameter, 0 given in %s/uploadprogress_get_info_error004.php:%d
Stack trace:
#0 %s/uploadprogress_get_info_error004.php(%d): uploadprogress_get_info()
#1 {main}
  thrown in %s/uploadprogress_get_info_error004.php on line %d
