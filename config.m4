PHP_ARG_ENABLE([uploadprogress],
  [whether to enable uploadprogress functions],
  [AS_HELP_STRING([--enable-uploadprogress],
    [Enable uploadprogress support [default=yes]])])

if test "$PHP_UPLOADPROGRESS" != "no"; then
  PHP_SUBST(UPLOADPROGRESS_SHARED_LIBADD)
  AC_DEFINE(HAVE_UPLOADPROGRESS, 1, [Whether the uploadprogress extension is enabled])
  PHP_NEW_EXTENSION(uploadprogress, uploadprogress.c , $ext_shared)
fi
