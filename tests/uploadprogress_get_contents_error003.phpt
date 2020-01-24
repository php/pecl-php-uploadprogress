--TEST--
uploadprogress_get_contents - Warns when maxlength is less than zero

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
$contents = uploadprogress_get_contents('fileIdentifier', 'formFieldName', -1);
var_dump($contents);

--EXPECTF--
Warning: uploadprogress_get_contents(): length must be greater than or equal to zero in %s/uploadprogress_get_contents_error003.php on line %d
bool(false)
