node() {
  stage "Checkout"
    checkout scm
  stage "Prepare"
    def phptest = docker.image('willoucom/php-multitest')
    phptest.pull() // make sure we have the latest available from Docker Hub
  stage "Composer"
    phptest.inside {
        sh 'composer --working-dir=phptest/src update'
    }
}