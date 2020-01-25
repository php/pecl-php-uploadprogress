# uploadprogress

## Building on *nix systems

To compile your new extension, you will have to execute the following steps:

1. $ ./phpize
2. $ ./configure [--enable-uploadprogress]
3. $ make
4. $ make test
5. $ [sudo] make install

## Building on Windows

The extension provides the VisualStudio V6 project file

    uploadprogress.dsp

To compile the extension you open this file using VisualStudio, select the
apropriate configuration for your installation (either "Release_TS" or
"Debug_TS") and create `php_uploadprogress.dll`.

After successfull compilation you have to copy the newly created
`php_uploadprogress.dll` to the PHP extension directory (default:
`C:\PHP\extensions`).

## Testing

You can now load the extension using a php.ini directive

    extension=uploadprogress

The extension should now be available, you can test this using the
`extension_loaded()` function:

```php
if (extension_loaded('uploadprogress')) {
    echo "uploadprogress loaded :)";
} else  {
    echo "something is wrong :(";
}
```

The extension will also add its own block to the output of `phpinfo()`;
