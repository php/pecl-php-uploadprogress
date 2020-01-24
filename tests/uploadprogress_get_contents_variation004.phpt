--TEST--
uploadprogress_get_contents - Returns empty string for empty file

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_contents/upload_contents_%s');

$contents = uploadprogress_get_contents('variation004', 'aFieldId');
var_dump($contents);

--EXPECTF--
string(0) ""
