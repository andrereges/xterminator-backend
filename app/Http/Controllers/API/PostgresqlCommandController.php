<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostgresqlCommandController extends Controller
{
    public function list()
    {
        try {
            $logs = (new \App\PostgresqlCommand())->getLogs();

            return response()->json($logs, 200);
        } catch (\Exception $e) {
            return response()->json("Shit! Error when listing log files.", 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $nameFile = $request->get('nameFile');
            $selectors = $request->get('selectors');
            $save = $request->get('save');
            $return = (new \App\PostgresqlCommand())->create($nameFile, $selectors, $save);

            $return = $save ? "Great! The log file \"$return\" was created." : $return;
            return response()->json($return, 200);
        } catch (\Exception $e) {
            $message = $save ? "Shit! Error creating log file." : "Shit! Error getting logs.";
            return response()->json($message, 500);
        }
    }

    public function view(Request $request)
    {
        try {
            $filename = $request->get('filename');

            return Storage::download("/postgresql/$filename.html", $filename);
        } catch (\Exception $e) {
            return response()->json("Shit! Error downloading file.", 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            $filename = $request->get('filename');
            Storage::delete("/postgresql/$filename.html");

            return response()->json("Great! File log removed.", 200);
        } catch (\Exception $e) {
            return response()->json("Shit! Error remove file log.", 500);
        }
    }

    public function clear()
    {
        try {
            (new \App\PostgresqlCommand())->clear();

            return response()->json("Great! Clean logs.", 200);
        } catch (\Exception $e) {
            return response()->json("Shit! Error when clearing the logs.", 500);
        }
    }
}
