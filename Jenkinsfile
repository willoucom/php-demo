node() {
  stage "Checkout"
    checkout scm
    def workspace = pwd()
  stage "Prepare Docker"
    sh 'docker pull willoucom/php-multitest'
  stage "Composer"
    sh 'docker run --rm -v ${DOCKERVOLUME}:/var/jenkins_home -w ${workspace} willoucom/php-multitest composer --working-dir=src update'
}