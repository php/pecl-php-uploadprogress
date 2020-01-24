--TEST--
uploadprogress_get_contents - Warns when function is disabled

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = Off

--FILE--
<?php
$contents = uploadprogress_get_contents('fileIdentifier', 'formFieldName');
var_dump($contents);

--EXPECTF--
Warning: uploadprogress_get_contents(): this function is disabled; set uploadprogress.get_contents = On to enable it in %s/uploadprogress_get_contents_error001.php on line %d
bool(false)
