node() {
  stage "Checkout"
    checkout scm
    def workspace = pwd()
  stage "Composer"
    sh 'docker run --rm -v jenkins2docker_data:/var/jenkins_home -w ${workspace} willoucom/php-multitest composer --working-dir=src update'
}