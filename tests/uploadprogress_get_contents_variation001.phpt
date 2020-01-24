--TEST--
uploadprogress_get_contents - When contents template is empty

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On
uploadprogress.file.contents_template=

--FILE--
<?php
$contents = uploadprogress_get_contents('fileId', 'fieldName');
var_dump(ini_get('uploadprogress.file.contents_template'));
var_dump($contents);

--EXPECTF--
string(0) ""
NULL
