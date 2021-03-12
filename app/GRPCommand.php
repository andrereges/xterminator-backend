<?php

namespace App;

class GRPCommand extends Command
{
    private $grp3Path = '/var/www/html/grp3/';
    private $grp2Path = '/var/www/html/grp2/';
    private $grp3GitCredentials = 'https://andre:C4v31r4_!_@git.lliege.com.br/POCS/grp3.git';
    private $grp2GitCredentials = 'https://andre:C4v31r4_!_@git.lliege.com.br/POCS/grp.git';

    /**
     * Executa o git pull e roda as migrações no projeto GRP3
     */
    public function deployGRP3()
    {
        $currentBranch = array_values($this->execute("docker exec -ti php-fpm5.6 bash -c 'git --git-dir=$this->grp3Path.git rev-parse --abbrev-ref HEAD'"))[0];
        $command = "docker exec -ti php-fpm5.6 bash -c 'git --git-dir=$this->grp3Path.git pull $this->grp3GitCredentials $currentBranch && php $this->grp3Path/bin/console doc:mi:mi --no-interaction'";

        return $this->execute($command);
    }

    /**
     * Executa o git pull no projeto GRP2
     */
    public function deployGRP2()
    {
        $currentBranch = array_values($this->execute("docker exec -ti php-fpm5.6 bash -c 'git --git-dir=$this->grp2Path.git rev-parse --abbrev-ref HEAD'"))[0];
        $command = "docker exec -ti php-fpm5.6 bash -c 'git --git-dir=$this->grp2Path.git pull $this->grp2GitCredentials $currentBranch'";

        return $this->execute($command);
    }

    /**
     * Roda os comando doctrine criar migração doctrine:migrations:generate
     * Sem interatividade com o terminal --no-interaction
     */
    public function migrationCreate()
    {
        $command = "docker exec -ti php-fpm5.6 bash -c 'php $this->grp3Path/bin/console doc:mi:ge'";
        $input = array_values($this->execute($command))[0];

        preg_match('~DoctrineMigrations/(.*?).php~', $input, $output);
        $this->execute("chmod -R 777 /var/www/html/grp3/app/DoctrineMigrations/$output[1].php");

        return $output[1].'.php';
    }

    /**
     * Roda o comando doctrine rodar as migrações doctrine:migrations:migrate
     * Sem interatividade com o terminal --no-interaction
     */
    public function migrationRun()
    {
        $command = "docker exec -ti php-fpm5.6 bash -c 'php $this->grp3Path/bin/console doc:mi:mi --no-interaction'";
        return $this->execute($command);
    }
}
