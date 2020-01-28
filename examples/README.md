# uploadprogress Example

To run this example, you will need:

* [Apache httpd][] with [mod_php][] (other web servers and [PHP-FPM][] are not
  yet supported)
* PHP 5.4+ with the [fileinfo][] extension

The easiest way to run this example is by using [Docker][] with the provided
`docker-compose.yml` file (which includes all the requirements), though Docker
is not required.

## Using docker-compose

To run the Docker image, open a terminal window, change to this examples
directory (i.e. `cd /path/to/examples`), and enter the following command. It may
take a few minutes the first time you enter this, since it will build the image
for you and then run it.

```
docker-compose up
```

After it starts, open a web browser and go to <http://localhost:8080> to run the
example. Follow the instructions on the page, and read the code in this
directory for a better understanding of what's going on.

To stop `docker-compose`, press `Ctrl`-`C` in your terminal window, and then
enter `docker-compose rm` to remove the container that was created.


[docker]: https://www.docker.com
[apache httpd]: https://httpd.apache.org
[mod_php]: https://www.php.net/manual/en/install.unix.apache2.php
[php-fpm]: https://www.php.net/fpm
[fileinfo]: https://www.php.net/fileinfo
