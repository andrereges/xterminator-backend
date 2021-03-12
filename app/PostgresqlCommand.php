<?php

namespace App;

use App\Helpers\PostgresqlCommandHelper;
use Illuminate\Support\Facades\Storage;

class PostgresqlCommand extends Command
{
    private $logFile = '/opt/dockers/LLIEGE-GRP/postgres/backup/postgresql.log';

    /**
     * Cria arquivo com os logs de cada seletor exemplo select, insert, update, delete e etc
     * O arquivo tem os seletores com as queries agrupadas
     * Salva o arquivo opcional
     */
    public function create($nameFile, $selectors, $save)
    {
        $this->execute("docker exec -ti postgres bash -c 'cp /var/lib/postgresql/data/log/postgresql.log /backup/postgresql.log'");
        // $this->execute("sshpass -p lliege@123 scp -P 22 root@192.168.1.15:/var/dockers/LLIEGE-GRP/postgres/data/log/postgresql.log $this->logFile");
        $this->setPermissionFileOrDirectory($this->logFile);

        $logFile = fopen($this->logFile, "r");

        $queries = [];
        $hasParameter = false;
        $keySelector = '';
        while (!feof($logFile)) {
            $line = fgets($logFile);
            $line = preg_replace('/\s+/', ' ', $line);

            if (str_contains($line, 'parameters:') && $hasParameter) {
                $parameter = trim(substr($line, strpos($line, "parameters:") + 12));
                $lastKey = array_key_last($queries[$keySelector]);
                $lastQuery = end($queries[$keySelector]);

                $queries[$keySelector][$lastKey] = PostgresqlCommandHelper::joinQueryParameters($lastQuery, $parameter);
                $keySelector = '';
            }

            if (str_contains($line, 'execute <unnamed>: ')) {
                $query = trim(substr($line, strpos($line, "execute <unnamed>: ") + 19));

                foreach ($selectors as $selector) {
                    if (PostgresqlCommandHelper::stringStartsWith($query, $selector)) {
                        $keySelector = $selector;

                        if (str_contains($query, '$')) {
                            $queries[$selector][] = $query;
                            $hasParameter = true;
                        } else {
                            $hasParameter = false;
                        }
                    }
                }
            } else {
                $hasParameter = false;
            }
        }

        fclose($logFile);

        return PostgresqlCommandHelper::exportLog($nameFile, $queries, $save);
    }

    /**
     * Pega todos os arquivos salvos no storage pasta postgresql/
     * Envia o nome e url para download do arquivo
     */
    public function getLogs()
    {
        $files = array_map(function($file) {
            $filename = str_replace(['postgresql/', '.html'], '', $file);

            return [
                'name' => $filename,
                'url' => asset(Storage::url("postgresql/log/$filename.html"))
            ];
        }, Storage::disk('local')->allFiles('postgresql'));

        asort($files);

        return $files;
    }

    /**
     * Limpa os logs no arquivo postgresql.log dentro do docker
     */
    public function clear()
    {
        $command = "docker exec -ti postgres bash -c 'echo \"\" > /var/lib/postgresql/data/log/postgresql.log'";
        return $this->execute($command);
    }
}
