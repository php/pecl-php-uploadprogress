--TEST--
uploadprogress_get_info - Trims whitespace around keys and values

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', dirname(__FILE__) . '/mocks/get_info/upt_%s.txt');

$info = uploadprogress_get_info('variation004');
var_export($info);

--EXPECTF--
array (
  'upload_id' => 'file005',
  'fieldname' => 'uploadFile',
  'filename' => 'a value with spaces in it',
  'time_start' => '1579893044',
  'time_last' => '30',
  'speed_average' => '300',
  'speed_last' => '300',
  'bytes_uploaded' => '1592342',
  'bytes_total' => '3000000',
  'files_uploaded' => '1',
  'est_sec' => '45',
)
