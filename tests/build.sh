#!/bin/bash
dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
set -ex

cd "${dir}/../"
php_path=${PHP_BIN_PATH:-$(dirname "$(which php)")}

"${php_path}/phpize"
./configure --with-php-config="${php_path}/php-config"
make
make install

"${php_path}/php" run-tests.php \
    -q \
    -p "${php_path}/php" \
    -d extension=$(pwd)/modules/uploadprogress.so \
    -g "FAIL,XFAIL,BORK,WARN,LEAK,SKIP" \
    --show-diff \
    --offline \
    --set-timeout 120