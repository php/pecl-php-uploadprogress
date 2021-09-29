/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 5f78bc7f8b12cfd54c838e6e6e85b9f28b67b386 */

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_uploadprogress_get_info, 0, 1, IS_ARRAY, 1)
	ZEND_ARG_TYPE_INFO(0, identifier, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_uploadprogress_get_contents, 0, 2, IS_STRING, 1)
	ZEND_ARG_TYPE_INFO(0, identifier, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, fieldname, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, maxlen, IS_LONG, 0, "-1")
ZEND_END_ARG_INFO()


ZEND_FUNCTION(uploadprogress_get_info);
ZEND_FUNCTION(uploadprogress_get_contents);


static const zend_function_entry ext_functions[] = {
	ZEND_FE(uploadprogress_get_info, arginfo_uploadprogress_get_info)
	ZEND_FE(uploadprogress_get_contents, arginfo_uploadprogress_get_contents)
	ZEND_FE_END
};
