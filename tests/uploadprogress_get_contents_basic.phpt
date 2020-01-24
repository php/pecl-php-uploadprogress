--TEST--
uploadprogress_get_contents - Returns contents of uploading file

--SKIPIF--
<?php
if (!extension_loaded('uploadprogress')) exit('skip extension not loaded');

--INI--
uploadprogress.get_contents = On

--FILE--
<?php
ini_set('uploadprogress.file.contents_template', dirname(__FILE__) . '/mocks/get_contents/upload_contents_%s');

$contents = uploadprogress_get_contents('basic', 'formFieldId');
echo $contents;

--EXPECTF--
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse placerat
risus ac augue lacinia, sed aliquam sapien ullamcorper. Nulla ipsum diam,
condimentum nec vulputate sodales, convallis vel neque. Morbi at rutrum arcu,
sit amet ullamcorper velit. In erat risus, blandit sit amet imperdiet eget,
auctor a turpis. Nulla vel augue elit. Pellentesque vestibulum dui nisl, a
auctor leo accumsan in. Etiam eget varius metus. Donec eu pulvinar metus, ac
vulputate erat. Integer viverra augue quis mauris vestibulum, vel rutrum ante
dapibus. Donec venenatis viverra mollis. Pellentesque id magna sit amet leo
lobortis faucibus. Nam eu tellus vel nibh lobortis tincidunt.
