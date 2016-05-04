node() {
  stage "Checkout"
    checkout scm
  stage "Composer"
    sh 'docker run --rm -v ${pwd}:/phptest willoucom/php-multitest composer --working-dir=/phptest/src update'
}