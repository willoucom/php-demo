#!groovy

node() {
    stage "Checkout"
        checkout scm

    stage "Prepare Docker"
        sh 'docker pull willoucom/php-multitest'

    stage "Composer"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest composer --working-dir=src update'

    stage "PHP QC"
      parallel php_md: {
        // Php mess detector
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpmd src xml cleancode --reportfile ci/logs/phpmd.xml | true'
      }, php_cs: {
        // Php code sniffer
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcs --report=checkstyle --report-file=ci/logs/phpcs.xml --standard=PSR2 --extensions=php --ignore=autoload.php src tests | true'
      }, php_cpd: {
        // Php copy/paste detector
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcpd --log-pmd ci/logs/phpcpd.xml src | true'
      },
      failFast: false

    stage "Atoum"
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest php /mageekguy.atoum.phar -c ci/atoum.conf.php -d tests/units | true'

    stage "Reporting"
      step([$class: 'AnalysisPublisher'])
}
