node() {
    stage "Checkout"
        checkout scm

    stage "Prepare Docker"
        sh 'docker pull willoucom/php-multitest'

    stage "Composer"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest composer --working-dir=src update'

    stage "Php mess detector"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpmd /phptest/src xml cleancode --reportfile /phptest/ci/logs/phpmd.xml

    stage "Php code sniffer"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcs --report=checkstyle --report-file=/phptest/ci/logs/phpcs.xml --standard=PSR2 --extensions=php --ignore=autoload.php /phptest/src /phptest/tests

    stage "Php copy/paste detector"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcpd --log-pmd /phptest/ci/logs/phpcpd.xml /phptest/src

    stage "Atoum"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest php /mageekguy.atoum.phar -c /phptest/ci/atoum.conf.php -d /phptest/tests/units

}