--TEST--
uploadprogress_get_info - Template without replacement assumes directory

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', dirname(__FILE__) . '/mocks/get_info');

$info = uploadprogress_get_info('variation001');
var_export($info);

--EXPECTF--
array (
  'upload_id' => 'file003',
  'fieldname' => 'uploadFile',
  'filename' => '/path/to/tmp/filename.txt',
  'time_start' => '1579893044',
  'time_last' => '30',
  'speed_average' => '300',
  'speed_last' => '300',
  'bytes_uploaded' => '1592342',
  'bytes_total' => '3000000',
  'files_uploaded' => '1',
  'est_sec' => '45',
)
