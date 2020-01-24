--TEST--
uploadprogress_get_contents - When contents file cannot be read

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_info/upload_contents_%s');

$testFile = dirname(__FILE__) . '/mocks/get_contents/upload_contents_variation006-field';
$permissions = fileperms($testFile);

// Set the permissions on the file to test to writable only. This should ensure
// that this script cannot read from the file, for proper testing.
chmod($testFile, 0200);

$contents = uploadprogress_get_contents('variation006', 'field');
var_dump($contents);

// Set the file back to its original permissions. This makes sure that we
// don't get any weird VCS issues with files showing up as changed when they
// haven't really changed.
chmod($testFile, $permissions & 0777);

--EXPECTF--
bool(false)
