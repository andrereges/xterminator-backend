<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DockerCommandController extends Controller
{
    public function index()
    {
        try {
            $containers = (new \App\DockerCommand())->getAllContainers();
            return response()->json($containers, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $containers = (new \App\DockerCommand())->findByNameOrID($id);
            return response()->json($containers, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function execute(Request $request)
    {
        $containerID = $request->get('containerID');
        $action = $request->get('action');

        try {
            (new \App\DockerCommand())->action($containerID, $action);
            return response()->json('Great! Command docker executed.', 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
