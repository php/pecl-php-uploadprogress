--TEST--
uploadprogress_get_info - When empty template and identifier

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', '');

$info = uploadprogress_get_info('');
var_export($info);

--EXPECTF--
NULL
