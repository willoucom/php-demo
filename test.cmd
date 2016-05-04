REM Update tools
docker pull willoucom/php-multitest

REM Composer
docker run --rm -ti -v %CD%:/phptest willoucom/php-multitest composer --working-dir=/phptest/src update

REM Php mess detector
docker run --rm -ti -v %CD%:/phptest willoucom/php-multitest phpmd /phptest/src xml cleancode --reportfile /phptest/ci/logs/phpmd.xml

REM Php code sniffer
docker run --rm -ti -v %CD%:/phptest willoucom/php-multitest phpcs --report=checkstyle --report-file=/phptest/ci/logs/phpcs.xml --standard=PSR2 --extensions=php --ignore=autoload.php /phptest/src /phptest/tests

REM Php copy/paste detector
docker run --rm -ti -v %CD%:/phptest willoucom/php-multitest phpcpd --log-pmd /phptest/ci/logs/phpcpd.xml /phptest/src

REM Atoum
docker run --rm -ti -v %CD%:/phptest willoucom/php-multitest php /mageekguy.atoum.phar -c /phptest/ci/atoum.conf.php -d /phptest/tests/units

