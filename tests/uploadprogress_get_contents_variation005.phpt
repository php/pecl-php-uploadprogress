--TEST--
uploadprogress_get_contents - Template without replacement assumes directory

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_contents/%s');

$contents = uploadprogress_get_contents('variation005', 'fieldName');
echo $contents;

--EXPECTF--
Lorem ipsum dolor sit amet, consectetur adipiscing elit.
