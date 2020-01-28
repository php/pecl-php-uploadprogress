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

// NOTE: This code is only executed after the entire file has finished uploading
// to the server. Once the last byte reaches the server, this script begins
// execution.

// If the request is not a POST, tell the client the method is not allowed. This
// is not required to use the uploadprogress extension. It is only here for the
// sake of example.
if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

// If there are no files in the request, tell the client it made a bad request.
// Again, this is not required to use uploadprogress. It is used as an example.
if (count($_FILES) === 0) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

// There is no reason to process the file upload in this example, so we simply
// return with a 200 status code to tell the client we received the file. This
// is not a recommendation for how your application should respond. It is
// only for the sake of example.
header('HTTP/1.1 200 OK');
header('Content-Type: application/json');

echo json_encode(['status' => 'ok']);
