<?php

namespace App;

class DockerCommand extends Command
{
    public function action($containerID, $action)
    {
        return $this->execute("docker container $action $containerID");
    }

    public function getAllContainers()
    {
        $command = "docker container ls --all --format '{{.ID}}~{{.Names}}'";
        $outputContainers = $this->execute($command);

        return $this->formattedContainers($outputContainers);
    }

    public function findByNameOrID($value)
    {
        $command = "docker container ls --all --format '{{.ID}}~{{.Names}}' | grep " . $value;
        return $this->execute($command);
    }

    public function getStatusByID($id)
    {
        $command = "docker container inspect -f '{{.State.Running}}' $id";
        return $this->execute($command);
    }

    public function formattedContainers($outputContainers)
    {
        $containers = [];
        foreach ($outputContainers as $container) {
            list($id, $name) = explode('~', $container);
            array_push($containers, [
                'id' => $id,
                'name' => $name,
                'status' => $this->getStatusByID($id)
            ]);
        };

        return $containers;
    }
}
