--TEST--
uploadprogress_get_info - When filename template is empty

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.file.filename_template=

--FILE--
<?php
$info = uploadprogress_get_info('fileId');
var_dump(ini_get('uploadprogress.file.filename_template'));
var_dump($info);

--EXPECTF--
string(0) ""
NULL
