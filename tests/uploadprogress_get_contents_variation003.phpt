--TEST--
uploadprogress_get_contents - Returns contents of file up to maxlen

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_contents/upload_contents_%s');

$contents = uploadprogress_get_contents('variation003', 'formFieldId', 57);
echo $contents;

--EXPECTF--
Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
