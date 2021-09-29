/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 2d041ae6d6a3d972168fe0cc71978048f694a39c */

ZEND_BEGIN_ARG_INFO_EX(arginfo_uploadprogress_get_info, 0, 0, 1)
	ZEND_ARG_INFO(0, identifier)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_uploadprogress_get_contents, 0, 0, 2)
	ZEND_ARG_INFO(0, identifier)
	ZEND_ARG_INFO(0, fieldname)
	ZEND_ARG_INFO(0, maxlen)
ZEND_END_ARG_INFO()


ZEND_FUNCTION(uploadprogress_get_info);
ZEND_FUNCTION(uploadprogress_get_contents);


static const zend_function_entry ext_functions[] = {
	ZEND_FE(uploadprogress_get_info, arginfo_uploadprogress_get_info)
	ZEND_FE(uploadprogress_get_contents, arginfo_uploadprogress_get_contents)
	ZEND_FE_END
};
