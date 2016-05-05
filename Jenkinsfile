#!groovy

node() {
  stage "Preparation"
    deleteDir()
    checkout scm
    sh 'docker pull willoucom/php-multitest'
    sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest composer --working-dir=src update'

  stage "PHP Tests"
    parallel php_md: {
      // Php mess detector
      try {
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpmd src html cleancode --reportfile ci/logs/phpmd.html'
      } catch (e) {
        echo "mess detector errors found"
      }
    }, php_cs: {
      // Php code sniffer
      try {
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcs --report=checkstyle --report-file=ci/logs/phpcs.xml --standard=PSR2 --extensions=php --ignore=autoload.php src'
      } catch (e) {
        echo "code sniffer errors found"
      }
    }, php_cpd: {
      // Php copy/paste detector
      try{
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest phpcpd --log-pmd ci/logs/phpcpd.xml src'
      } catch (e) {
        echo "copy/paste errors found"
      }
    }, atoum: {
      try{
        sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${PWD} willoucom/php-multitest php /mageekguy.atoum.phar -c ci/atoum.conf.php -d tests/units'
      } catch (e) {
        echo "unit test errors found"
      }
    }
    failFast: false

  stage "Reporting"
    try{
      step([$class: 'JUnitResultArchiver', testResults: '**/ci/logs/atoum.xunit.xml'])
      step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: '**/ci/logs/phpcs.xml'])
      step([$class: 'CloverPublisher', cloverReportDir: 'ci/logs/', cloverReportFileName: 'atoum.clover.xml'])
      publishHTML(target: [allowMissing: true, keepAll: true, reportDir: 'ci/logs/', reportFiles: 'phpmd.html', reportName: 'Php mess detector'])
      publishHTML(target: [allowMissing: true, keepAll: true, reportDir: 'ci/html/coverage', reportFiles: 'index.html', reportName: 'Code Coverage'])
    } catch (e) {
      echo "errors found"
    }
    
  stage "Archiving"
    step([$class: 'ArtifactArchiver', artifacts: '**/*', fingerprint: true])
}
