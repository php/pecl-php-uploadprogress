--TEST--
uploadprogress_get_info - Filename containing spaces (bug #58318)

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--FILE--
<?php
ini_set('uploadprogress.file.filename_template', dirname(__FILE__) . '/mocks/get_info/upt_%s.txt');

$info = uploadprogress_get_info('bug58318');
echo $info['filename'];

--EXPECTF--
C:\Documents and Settings\franck\Bureau\taf\tevasia\1and1\video\Kumar.flv
