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
  | Author: Christian Stocker (chregu@liip.ch)                           |
  |  Derived from: Doru Petrescu (pdoru-php-upm@kappa.ro)                |
  |                http://pdoru.from.ro/upload-progress-meter/           |
  +----------------------------------------------------------------------+
*/

#ifndef PHP_UPLOADPROGRESS_H
#define PHP_UPLOADPROGRESS_H

#ifdef  __cplusplus
extern "C" {
#endif

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <php.h>

#ifdef HAVE_UPLOADPROGRESS

#include <php_ini.h>
#include <SAPI.h>
#include <ext/standard/info.h>
#include <ext/standard/php_string.h>

#ifdef  __cplusplus
} // extern "C"
#endif
#ifdef  __cplusplus
extern "C" {
#endif

extern zend_module_entry uploadprogress_module_entry;
#define phpext_uploadprogress_ptr &uploadprogress_module_entry

#define PHP_UPLOADPROGRESS_VERSION "1.1.3"

#ifdef PHP_WIN32
#define PHP_UPLOADPROGRESS_API __declspec(dllexport)
#else
#define PHP_UPLOADPROGRESS_API
#endif

typedef struct _uploadprogress_data {
    /* Full filename, or just the identifier, depending on method */
    char *identifier;

    /* Full filename, or just the identifier, depending on method */
    char *identifier_tmp;

    /* Raw string of the UPLOAD_IDENTIFIER */
    char *upload_id;

    /* Full filename of temporary data file */
    char *data_filename;

    /* Name of form field for current file being uploaded */
    char *fieldname;

    /* Filename of the uploaded file */
    char *filename;

    time_t time_start;
    time_t time_last;
    unsigned int speed_average;
    unsigned int speed_last;
    unsigned long bytes_uploaded;
    unsigned long bytes_total;
    unsigned int files_uploaded;
    int est_sec;
} uploadprogress_data;

static char *uploadprogress_mk_filename(char *identifier, char *template);

static void uploadprogress_file_php_get_info(char *, zval *);
static void uploadprogress_file_php_get_contents(char *, char *, long, zval *);

PHP_MINIT_FUNCTION(uploadprogress);
PHP_MSHUTDOWN_FUNCTION(uploadprogress);
PHP_RINIT_FUNCTION(uploadprogress);
PHP_RSHUTDOWN_FUNCTION(uploadprogress);
PHP_MINFO_FUNCTION(uploadprogress);

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_FUNCTION(uploadprogress_get_info);
PHP_FUNCTION(uploadprogress_get_contents);

#ifdef  __cplusplus
} // extern "C"
#endif

#endif /* PHP_HAVE_UPLOADPROGRESS */

#endif /* PHP_UPLOADPROGRESS_H */
