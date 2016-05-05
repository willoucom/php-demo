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
        try {
          sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpmd src html cleancode --reportfile ci/logs/phpmd.html'
        } catch (e) {
          echo "errors found"
        }
      }, php_cs: {
        // Php code sniffer
        try {
          sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcs --report=checkstyle --report-file=ci/logs/phpcs.xml --standard=PSR2 --extensions=php --ignore=autoload.php src'
        } catch (e) {
          echo "errors found"
        }
      }, php_cpd: {
        // Php copy/paste detector
        try{
          sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcpd --log-pmd ci/logs/phpcpd.xml src'
        } catch (e) {
          echo "errors found"
        }
      },
      failFast: false

    stage "Atoum"
      try{
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest php /mageekguy.atoum.phar -c ci/atoum.conf.php -d tests/units'
      } catch (e) {
        echo "errors found"
      }
    stage "Reporting"
      try{
        step([$class: 'JUnitResultArchiver', testResults: '**/ci/logs/atoum.xunit.xml'])
        step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: '**/ci/logs/phpcs.xml'])
        step([$class: 'CloverPublisher', cloverReportDir: 'ci/logs/', cloverReportFileName: 'atoum.clover.xml'])
        publishHTML(target: [allowMissing: true, keepAll: true, reportDir: 'ci/logs/', reportFiles: 'phpmd.html', reportName: 'Php mess detector'])
      } catch (e) {
        echo "errors found"
      }
    stage "Archiving"
      step([$class: 'ArtifactArchiver', artifacts: '**/*', fingerprint: true])

}
