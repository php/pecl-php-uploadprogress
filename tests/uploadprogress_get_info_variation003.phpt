--TEST--
uploadprogress_get_info - When info file cannot be read

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', dirname(__FILE__) . '/mocks/get_info/upt_%s.txt');

$testFile = dirname(__FILE__) . '/mocks/get_info/upt_variation003.txt';
$permissions = fileperms($testFile);

// Set the permissions on the file to test to writable only. This should ensure
// that this script cannot read from the file, for proper testing.
chmod($testFile, 0200);

$info = uploadprogress_get_info('variation003');
var_export($info);

// Set the file back to its original permissions. This makes sure that we
// don't get any weird VCS issues with files showing up as changed when they
// haven't really changed.
chmod($testFile, $permissions & 0777);

--EXPECTF--
NULL
