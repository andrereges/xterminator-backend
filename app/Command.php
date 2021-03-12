<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    private $sudoPassword = 'yes';
    protected $table = 'applications';
    protected $fillable = ['name', 'status'];

    public function execute(String $command)
    {
        exec($command, $output, $error);

        if ($error) {
            throw new \Exception("Shit! Command executed with failure.", 500);
        }

        return $output;
    }

    public function executeInContainer(String $containerId, String $command)
    {
        return $this->execute("docker exec -ti $containerId bash -c '$command'");
    }

    public function setPermissionFileOrDirectory($fileOrDirectory)
    {
        $this->execute("echo $this->sudoPassword | sudo -S -k chmod -R 777 $fileOrDirectory");
        return true;
    }
}
