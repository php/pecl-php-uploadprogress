# uploadprogress

A PHP extension to track progress of a file upload, including details on the
speed of the upload, estimated time remaining, and access to the contents of the
file as it is being uploaded.

## Requirements

The uploadprogress extension works on PHP 5, PHP 7, and PHP 8. It requires the
use of the [Apache HTTP Server][] with [mod_php][]. Other web servers and
[PHP-FPM][] are not yet supported.

## Example

Check out the [examples][] directory for a working example that you can run on
your local machine.

## Installation

Install uploadprogress with `pecl`:

```
pecl install uploadprogress
```

If it is not automatically added to your `php.ini` file by the `pecl` command,
you will need to update `php.ini` by adding the following line:

``` ini
extension=uploadprogress
```

## Documentation

In forms for which you wish to track a file upload using uploadprogress, you
must include a field named `UPLOAD_IDENTIFIER`.

The value of the `UPLOAD_IDENTIFIER` field may be any string. We recommend a
random, unique string per upload. This extension will use this value to keep
track of the upload, and you may query the extension using this identifier to
check the progress of the upload.

For example, you might choose to define the `UPLOAD_IDENTIFIER` field as such:

``` html
<input type="hidden" name="UPLOAD_IDENTIFIER" value="<?php echo bin2hex(random_bytes(16)); ?>">
```

The uploadprogress extension provides two functions: `uploadprogress_get_info()`
and `uploadprogress_get_contents()`.

While a file is uploading, you may call these functions from a different script
to check on the progress of the uploading file, providing the same identifier
used as the `UPLOAD_IDENTIFIER`.

For example, you might make an HTTP `GET` request to
`/check-progress.php?identifier=some_identifier&fieldName=the_file_upload_form_field_name`.
The contents of `check-progress.php` might contain code like this:

``` php
$identifier = filter_input(INPUT_GET, 'identifier', FILTER_SANITIZE_STRING);
$fieldName = filter_input(INPUT_GET, 'fieldName', FILTER_SANITIZE_STRING);

$info = uploadprogress_get_info($identifier);
$contents = uploadprogress_get_contents($identifier, $fieldName);
```

### php.ini Settings

* `uploadprogress.file.filename_template`:

  Set the path and pattern to which the *info* file should be written. This is
  where we will store the data about the uploaded file, while it is being
  uploaded. You may set it to a directory, or you may optionally use a filename
  pattern. It defaults to `sys_get_temp_dir() . '/upt_%s.txt'`. The `%s` is
  replaced with the value of `UPLOAD_IDENTIFIER`.

* `uploadprogress.file.contents_template`:

  Set the path and pattern to which the *contents* of the uploaded file should
  be written. This allows us to read the contents of the file, while it is still
  being uploaded. You may set it to a directory, or you may optionally use a
  filename pattern. It defaults to `sys_get_temp_dir() . '/upload_contents_%s'`.
  The `%s` is replaced with the value of `UPLOAD_IDENTIFIER` combined with the
  name of the file upload form field.

* `uploadprogress.get_contents`:

  Set to "On" to enable the ability to read a file's contents while it is still
  uploading. Defaults to "Off."

**NOTE:** The paths for these INI settings must be *absolute* paths. Relative
paths will not work.

#### Example php.ini

``` ini
extension=uploadprogress
uploadprogress.get_contents=On
uploadprogress.file.filename_template=/tmp/upt_%s.txt
uploadprogress.file.contents_template=/tmp/upload_contents_%s
```

### uploadprogress_get_info

``` php
uploadprogress_get_info ( string $identifier ) : array
```

The `$identifier` is the value of the form field named `UPLOAD_IDENTIFIER`.

This returns an associative array with the following keys:

* `upload_id` - The value of `UPLOAD_IDENTIFIER`.
* `fieldname` - The name of the file upload form field for this file upload.
* `filename` - The original name of the file being uploaded.
* `time_start` - The Unix timestamp at which the upload began.
* `time_last` - The Unix timestamp at which this information was last updated.
* `speed_average` - The average upload speed, in bytes.
* `speed_last` - The last speed calculation, in bytes.
* `bytes_uploaded` - The number of bytes uploaded so far.
* `bytes_total` - The total number of bytes to be upload.
* `files_uploaded` - The total number of files uploaded so far.
* `est_sec` - The estimated number of seconds remaining until the upload is
  complete.

### uploadprogress_get_contents

``` php
uploadprogress_get_contents ( string $identifier , string $fieldName [, int $maxLength ] ) : string
```

The `$identifier` is the value of the form field named `UPLOAD_IDENTIFIER`.

The `$fieldName` is the value of the file upload form field name.

The `$maxLength` is an optional number of bytes to read, if you wish to read
only the first `$maxLength` bytes of the uploading file. Otherwise, all bytes
currently uploaded will be read.

This returns a string of all the bytes currently uploaded for the uploading file.

## Contributing

Your contributions and bug reports are highly appreciated. To contribute, fork
and create a pull request. To report a bug use the [PHP Bug Tracking
System](https://bugs.php.net/report.php?package=uploadprogress).

### Building on *nix systems

To compile this extension, execute the following steps:

1. $ ./phpize
2. $ ./configure [--enable-uploadprogress]
3. $ make
4. $ make test
5. $ [sudo] make install

### Building on Windows

The extension provides the VisualStudio V6 project file

    uploadprogress.dsp

To compile the extension you open this file using VisualStudio, select the
apropriate configuration for your installation (either "Release_TS" or
"Debug_TS") and create `php_uploadprogress.dll`.

After successfull compilation you have to copy the newly created
`php_uploadprogress.dll` to the PHP extension directory (default:
`C:\PHP\extensions`).

### Testing

You can now load the extension using a php.ini directive

``` ini
extension=uploadprogress
```

The extension should now be available, you can test this using the
`extension_loaded()` function:

``` php
if (extension_loaded('uploadprogress')) {
    echo "uploadprogress loaded :)";
} else  {
    echo "something is wrong :(";
}
```

The extension will also add its own block to the output of `phpinfo();`.


[Apache HTTP Server]: https://httpd.apache.org
[mod_php]: https://www.php.net/manual/en/install.unix.apache2.php
[php-fpm]: https://www.php.net/fpm
[examples]: ./examples
