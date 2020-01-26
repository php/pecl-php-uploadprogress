--TEST--
uploadprogress_get_contents - Warns when too few arguments

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');
if (PHP_MAJOR_VERSION >= 8) exit('skip test not valid on PHP 8');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
$contents = uploadprogress_get_contents('fileIdentifier');
var_dump($contents);

--EXPECTF--
Warning: uploadprogress_get_contents() expects at least 2 parameters, 1 given in %s/uploadprogress_get_contents_error002.php on line %d
NULL
