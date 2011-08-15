dnl
dnl $ Id: $
dnl

PHP_ARG_ENABLE(uploadprogress, whether to enable uploadprogress functions,
[  --enable-uploadprogress         Disable uploadprogress support])

if test "$PHP_UPLOADPROGRESS" != "no"; then


  PHP_SUBST(UPLOADPROGRESS_SHARED_LIBADD)
  AC_DEFINE(HAVE_UPLOADPROGRESS, 1, [ ])
  PHP_NEW_EXTENSION(uploadprogress, uploadprogress.c , $ext_shared)

fi

