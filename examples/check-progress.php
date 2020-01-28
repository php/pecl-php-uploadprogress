<?php

/*
  +----------------------------------------------------------------------+
  | Uploadprogress extension                                             |
  +----------------------------------------------------------------------+
  | Copyright (c) The PHP Group                                          |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Ben Ramsey (ramsey@php.net)                                  |
  +----------------------------------------------------------------------+
*/

// If the client did not include an identifier in their request, then we cannot
// look up information about the upload, so we return a "not found" error. This
// is only for the sake of example and does not imply this is how your
// application should behave.
$identifier = filter_input(INPUT_GET, 'identifier', FILTER_SANITIZE_STRING);
$fieldName = filter_input(INPUT_GET, 'fieldName', FILTER_SANITIZE_STRING);

if ($identifier === null || $fieldName === null) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

// Retrieve information about the file and the contents received so far.
// 4KB should be enough to read the MIME type of the file.
$info = uploadprogress_get_info($identifier);
$contents = uploadprogress_get_contents($identifier, $fieldName, 4096);

// Get the MIME type of the bytes uploaded, using the Fileinfo extension.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$detectedMimeType = $finfo->buffer($contents);

$info = array_merge($info, [
    'detectedMimeType' => $detectedMimeType,
]);

// In our example, we respond with the uploadprogress information, as well as
// the detected MIME type from the initial bytes uploaded (if we can detect it).
header('HTTP/1.1 200 OK');
header('Content-Type: application/json');

echo json_encode($info);
