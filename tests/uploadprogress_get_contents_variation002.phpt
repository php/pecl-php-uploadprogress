--TEST--
uploadprogress_get_contents - File contents not found

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_contents/upload_contents_%s');

$info = uploadprogress_get_contents('file-identifier-not-found', 'fieldName');
var_dump($info);

--EXPECTF--
bool(false)
