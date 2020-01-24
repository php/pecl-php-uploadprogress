--TEST--
uploadprogress_get_info - File info not found

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', dirname(__FILE__) . '/mocks/get_info/upt_%s.txt');

$info = uploadprogress_get_info('file-identifier-not-found');
var_dump($info);

--EXPECTF--
NULL
