/*
  +----------------------------------------------------------------------+
  | PHP Version 4                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2003 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.02 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available at through the world-wide-web at                           |
  | http://www.php.net/license/2_02.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Christian Stocker (chregu@bitflux.ch)                        |
  |  Derived from: Doru Petrescu (pdoru-php-upm@kappa.ro)                |
  |                http://pdoru.from.ro/upload-progress-meter/           |
  +----------------------------------------------------------------------+

  $Id$ 
*/
/* $ Id: $ */ 

#include "php_uploadprogress.h"
#include "rfc1867.h"


#if HAVE_UPLOADPROGRESS

/* {{{ uploadprogress_functions[] */
function_entry uploadprogress_functions[] = {
    PHP_FE(uploadprogress_get_info, NULL)
	PHP_FE(uploadprogress_get_contents, NULL)
    { NULL, NULL, NULL }
};
/* }}} */

PHP_INI_BEGIN()
PHP_INI_ENTRY("uploadprogress.file.filename_template",   "/tmp/upt_%s.txt", PHP_INI_ALL, NULL)
PHP_INI_ENTRY("uploadprogress.file.data_filename_template", "/tmp/upt_data_%s", PHP_INI_ALL, NULL)
PHP_INI_END()



/* {{{ uploadprogress_module_entry
*/
zend_module_entry uploadprogress_module_entry = {
    STANDARD_MODULE_HEADER,
    "uploadprogress",
    uploadprogress_functions,
    PHP_MINIT(uploadprogress),     /* Replace with NULL if there is nothing to do at php startup   */ 
    PHP_MSHUTDOWN(uploadprogress), /* Replace with NULL if there is nothing to do at php shutdown  */
    PHP_RINIT(uploadprogress),         /* Replace with NULL if there is nothing to do at request start */
    PHP_RSHUTDOWN(uploadprogress),   /* Replace with NULL if there is nothing to do at request end   */
    PHP_MINFO(uploadprogress),
    "0.0.1", 
    STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_UPLOADPROGRESS
ZEND_GET_MODULE(uploadprogress)
#endif


PHPAPI extern int (*php_rfc1867_callback)(unsigned int , void *, void ** TSRMLS_DC);

static int uploadprogress_php_rfc1867_file(unsigned int event, void  *event_data, void **data TSRMLS_DC)
{
    zval handler;
    char *callable = NULL;
    uploadprogress_data * progress;
    int read_bytes;
    
    progress =  *data;
    if (event == MULTIPART_EVENT_START) {
        multipart_event_start  *e_data;
        e_data = (multipart_event_start*) event_data;
        progress  = emalloc( sizeof(uploadprogress_data) );
		progress->upload_id = NULL;
		progress->fieldname = NULL;
		progress->data_filename = NULL;
        progress->bytes_total    = e_data->content_length;
        progress->identifier = NULL;
        progress->identifier_tmp = NULL;
        progress->time_start = time(NULL);
        *data = progress;
    } else if (event == MULTIPART_EVENT_FORMDATA) {
        
        multipart_event_formdata *e_data;
        e_data = (multipart_event_formdata*) event_data;
        read_bytes = e_data->post_bytes_processed;
        if (e_data->newlength) { 
            *e_data->newlength = e_data->length;
        }
        
        if (strcmp(e_data->name, "UPLOAD_IDENTIFIER") == 0)  {
            
            char * template = INI_STR("uploadprogress.file.filename_template");
            if (strcmp(template, "") == 0)  {
                return 0;
            }

			char * upload_id;
			upload_id = emalloc(strlen(*e_data->value));
			strcpy(upload_id, *e_data->value);

			progress->upload_id = upload_id;
			progress->time_last  = time(NULL);
            progress->speed_average  = 0;
            progress->speed_last     = 0;
            progress->bytes_uploaded = read_bytes;
            progress->files_uploaded = 0;
            progress->est_sec        = 0;
            progress->identifier = uploadprogress_mk_filename(upload_id, template);
            progress->identifier_tmp = emalloc(strlen( progress->identifier) + 4); 
            sprintf( progress->identifier_tmp, "%s.wr", progress->identifier );
        }
    }
    
    if (progress->identifier) {
        time_t crtime = time(NULL);
        int d,dt,ds;
                
        if (event == MULTIPART_EVENT_FILE_START) {
            multipart_event_file_start *e_data;
            
            e_data = (multipart_event_file_start*) event_data;
            read_bytes = e_data->post_bytes_processed;

            progress->fieldname = e_data->name;
			progress->filename = *e_data->filename;
			
			char * data_template = INI_STR("uploadprogress.file.data_filename_template");
			if (strcmp(data_template, "") == 0) {
				return 0;
			}

			char * data_identifier;
			data_identifier = emalloc(strlen(progress->upload_id) + strlen(progress->fieldname) + 2);
			sprintf(data_identifier, "%s-%s", progress->upload_id, progress->fieldname);

			progress->data_filename = uploadprogress_mk_filename(data_identifier, data_template);
            
        } else if (event == MULTIPART_EVENT_FILE_DATA) {
            multipart_event_file_data *e_data;
            
            e_data = (multipart_event_file_data*) event_data;
            read_bytes = e_data->post_bytes_processed;


			php_stream *stream;
			int options = ENFORCE_SAFE_MODE;

			stream = php_stream_open_wrapper(progress->data_filename, "ab", options, NULL);
			if (stream) {
				php_stream_write(stream, e_data->data, e_data->length);
			}
			php_stream_close(stream);

        } else if (event == MULTIPART_EVENT_FILE_END) {
            multipart_event_file_end *e_data;
            
            e_data = (multipart_event_file_end*) event_data;
            
            read_bytes = e_data->post_bytes_processed;
            progress->files_uploaded++;

			VCWD_UNLINK(progress->data_filename);
			efree(progress->data_filename);

        } else if ( event == MULTIPART_EVENT_END ) {
            VCWD_UNLINK( progress->identifier );
            efree( progress->identifier );
            efree( progress->identifier_tmp );
            efree( progress );

            return 0;
            
        }
        
        if (progress->time_last > crtime) { /* just in case we encounter a fracture in time */
            progress->time_last = crtime;
        }
        
        dt = crtime - progress->time_last;
        ds = crtime - progress->time_start;
        d = read_bytes - progress->bytes_uploaded;
        
            
        if (dt) {
            progress->speed_last = d/dt;
            
            progress->time_last = crtime;
            progress->bytes_uploaded = read_bytes;
            
            progress->speed_average = ds ? read_bytes / ds : 0;
            progress->est_sec = progress->speed_average ? (progress->bytes_total - read_bytes) / progress->speed_average : -1;
        }
        if (dt ||  event >= MULTIPART_EVENT_FILE_END) {
            
            
            FILE *F;
            F = VCWD_FOPEN(progress->identifier_tmp, "wb");
            if (F) {
                fprintf(F, "upload_id=%s\nfieldname=%s\nfilename=%s\ntime_start=%d\ntime_last=%d\nspeed_average=%d\nspeed_last=%d\nbytes_uploaded=%d\nbytes_total=%d\nfiles_uploaded=%d\nest_sec=%d\n",
                progress->upload_id, progress->fieldname, progress->filename,
				progress->time_start, progress->time_last, 
                progress->speed_average, progress->speed_last, 
                progress->bytes_uploaded, progress->bytes_total, 
                progress->files_uploaded, 
                progress->est_sec );
                fclose(F);
                VCWD_RENAME(progress->identifier_tmp,progress->identifier);
            }
        }
        
        
    }
    if (event == MULTIPART_EVENT_END ) {
        if (progress->identifier) {
            efree( progress->identifier );
        }
        if (progress->identifier_tmp) {
            efree( progress->identifier_tmp );
        }
		if (progress->data_filename) {
			efree(progress->data_filename);
		}
        efree( progress );

    }
}


/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(uploadprogress)
{
    REGISTER_INI_ENTRIES();
    php_rfc1867_callback = uploadprogress_php_rfc1867_file;
    
    /* add your stuff here */
    
    return SUCCESS;
}
/* }}} */


/* {{{ PHP_MSHUTDOWN_FUNCTION */
PHP_MSHUTDOWN_FUNCTION(uploadprogress)
{
    
    UNREGISTER_INI_ENTRIES();
    php_rfc1867_callback = NULL;
    
    /* add your stuff here */
    
    
    return SUCCESS;
}
/* }}} */



/* {{{ PHP_RINIT_FUNCTION */
PHP_RINIT_FUNCTION(uploadprogress)
{
    /* add your stuff here */
    
    
    return SUCCESS;
}
/* }}} */


/* {{{ PHP_RSHUTDOWN_FUNCTION */
PHP_RSHUTDOWN_FUNCTION(uploadprogress)
{
    /* add your stuff here */
    
    return SUCCESS;
}
/* }}} */


/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(uploadprogress)
{
    char                       buffer[ 512 ] ;
    php_info_print_table_start() ;
    
    php_info_print_table_header( 2, "uploadprogress support", "enabled" ) ;
    snprintf( buffer, 512, "0.3.1-dev");
    
    php_info_print_table_row( 2, "Version", buffer ) ;
    
    php_info_print_box_end();
    /* add your stuff here */
    
}


/* }}} */




/* {{{ proto bool uploadprogress_register(callback callback)
*/

PHP_FUNCTION(uploadprogress_get_info)
{
    char * id;
    int id_lg;
    char method;
    
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &id, &id_lg) == FAILURE) {
        return;
    }
    
    uploadprogress_file_php_get_info( id, return_value );
    return;
    
}

PHP_FUNCTION(uploadprogress_get_contents)
{
	char *id, *fieldname;
	int id_len, fieldname_len;
	long maxlen = PHP_STREAM_COPY_ALL;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss|l", 
							  &id, &id_len, &fieldname, &fieldname_len, &maxlen) == FAILURE) {
		return;
	}

	if (ZEND_NUM_ARGS() == 3 && maxlen < 0) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "length must be greater than or equal to zero");
		RETURN_FALSE;
	}

	uploadprogress_file_php_get_contents(id, fieldname, maxlen, return_value);
	return;
}

static char * uploadprogress_mk_filename(char * identifier, char * template)
{
    char * x;
    char * filename;
    
    filename = emalloc( strlen(template) + strlen(identifier) + 3 );
    
    x = strstr( template, "%s" );
    if (x==NULL) {
        sprintf( filename, "%s/%s", template, identifier );
    }else{
        strcpy( filename, template );
        strcpy( filename + (x - template), identifier );
        strcat( filename, x+2 );
    }
    return filename;
}

static void uploadprogress_file_php_get_info(char * id, zval * return_value)
{
    char s[1024];
    char * filename;
    char * template;
    FILE *F;
    TSRMLS_FETCH();
    
    template = INI_STR("uploadprogress.file.filename_template");
    
    
    if (strcmp(template, "") == 0)  {
        return;
    } else {
        filename = uploadprogress_mk_filename( id, template );
        if (!filename) return;
        
        F = VCWD_FOPEN(filename, "rb");
        
        if (F) {
            array_init(return_value);
            
            while ( fgets(s, 1000, F) ) {
                char *k, *v, *e;
                e = strchr(s,'=');
                if (!e) continue;
                
                *e = 0; /* break the line into 2 parts */
                v = e+1;
                k = s;
                
                /* trim spaces in front and after the name/value */
                while (*k && *k <= 32) v++;
                while (*v && *v <= 32) v++;
                for (e=k; *e; e++) if (*e <= 32) { *e = 0; break; }
                for (e=v; *e; e++) if (*e <= 32) { *e = 0; break; }
                
                add_assoc_string( return_value, k, v, 1 );
            }
            fclose(F);
        }
        
        if (filename) efree(filename);
        return;
    }
}

static void uploadprogress_file_php_get_contents(char *id, char *fieldname, long maxlen, zval *return_value)
{
	char *filename, *template, *contents, *data_identifier;
	php_stream *stream;
	int options = ENFORCE_SAFE_MODE;
	int len, newlen;
    TSRMLS_FETCH();

	template = INI_STR("uploadprogress.file.data_filename_template");

	if (strcmp(template, "") == 0) {
		return;
	} else {
		data_identifier = emalloc(strlen(id) + strlen(fieldname) + 2);
		sprintf(data_identifier, "%s-%s", id, fieldname);

		filename = uploadprogress_mk_filename(data_identifier, template);
		if (!filename) return;

		stream = php_stream_open_wrapper(filename, "rb", options, NULL);
		if (!stream) {
			RETURN_FALSE;
		}

		/* uses mmap if possible */
		if ((len = php_stream_copy_to_mem(stream, &contents, maxlen, 0)) > 0) {
			
			if (PG(magic_quotes_runtime)) {
				contents = php_addslashes(contents, len, &newlen, 1 TSRMLS_CC);
				len = newlen;
			}
			
			RETVAL_STRINGL(contents, len, 0);
		} else if (len == 0) {
			RETVAL_EMPTY_STRING();
		} else {
			RETVAL_FALSE;
		}

		php_stream_close(stream);
		if (data_identifier) efree(data_identifier);
		if (filename) efree(filename);

		return;
	}
}



#endif /* HAVE_UPLOADPROGRESS */


/*
* Local variables:
* tab-width: 4
* c-basic-offset: 4
* End:
* vim600: noet sw=4 ts=4 fdm=marker
* vim<600: noet sw=4 ts=4
*/
