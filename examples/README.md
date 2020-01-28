# uploadprogress Example

The easiest way to run this example is by using [Docker][], though Docker is not
required. [Apache httpd][] and [mod_php][] are required, and these are provided
in the included Docker image.

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
