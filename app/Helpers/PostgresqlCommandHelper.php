<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class PostgresqlCommandHelper
{
    /**
     * Compara a primeira palavra da string com o prefixo enviado
     */
    public static function stringStartsWith($string, $prefix)
    {
        return strpos(strtoupper($string), strtoupper($prefix)) === 0;
    }

    /**
     * Substitui os ($1, $2, ...) da query pelos valores dos parametros caso tenha
     */
    public static function joinQueryParameters($query, $parameter)
    {
        if (str_contains($query, '$')) {
            $params = explode(', ', $parameter);

            foreach(array_reverse($params) as $param) {
                $values[] = explode(' = ', $param);

                foreach($values as $value) {
                    if (!str_contains($value[0], '$')) break;
                    $query = str_replace(' '.trim($value[0]), ' '.trim($value[1]), $query);
                    $query = str_replace('('.trim($value[0]), '('.trim($value[1]), $query);
                }
            }
        }

        return $query;
    }

    /**
     * Exporta arquivo de log para arquivo .html
     */
    public static function exportLog($filename, $selectorsWithQueries, $save) {
        try {
            $content = self::layoutHTML($selectorsWithQueries);
            $filename = self::makeFilename($filename);

            if ($save):
                return self::saveInStorage($filename, $content, 'html');
            endif;

            return $content;
        } catch (\Exception $e) {
            throw new \Exception("Shit! Log export failed.", 500);
        }
    }

    public static function layoutHTML($selectorsWithQueries)
    {
        $content = '';
        foreach ($selectorsWithQueries as $key => $selectorQueries) {
            $content .= sprintf(
                '<h3 style="font-color: red">%s (%s)</h3>',
                strtoupper($key),
                count($selectorsWithQueries)
            );

            foreach ($selectorQueries as $query) {
                $content .= sprintf('<hr><p>%s;</p><hr>', $query);
            }
        }

        return $content;
    }

    public static function saveInStorage($filename, $content, $extension)
    {
        $filename = sprintf('/postgresql/%s.%s', $filename, $extension);
        Storage::disk('local')->put($filename, $content);

        return $filename;
    }

    /**
     * Cria um nome do arquivo respeitando os caracteres permitidos para nome de arquivo
     */
    public static function makeFilename($filename)
    {
        return $filename ? preg_replace("([^\w\s\d\-_~,;\[\]\(\)])", "", $filename) : 'Log'.date('YmdHis');
    }
}
