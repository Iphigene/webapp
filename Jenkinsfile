pipeline {
    agent any
    stages {
        stage('OWASP DependencyCheck') {
            steps {
                dependencyCheck additionalArguments: '--format HTML --format XML',
                odcInstallation: 'OWASP Dependency-Check Vulnerabilities'
            }
			post {
                success {
                    dependencyCheckPublisher pattern: 'dependency-check-report.xml'
                }
            }
        }
		
        stage('SonarQube Analysis') {
            agent any
            steps {
                script {
                    def scannerHome = tool 'SonarQube'
                    withSonarQubeEnv('SonarQube') {
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=Test -Dsonar.sources=."
                    }
                }
            }
            post {
                always {
                    recordIssues enabledForFailure: true, tool: sonarQube()
                }
            }
        }
    }
}
