<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GRPCommandController extends Controller
{
    public function executeDeploy(Request $request)
    {
        try {
            $project = strtoupper($request->get('project'));
            if ($project === 'GRP3'):
                (new \App\GRPCommand())->deployGRP3();
            elseif ($project === 'GRP2'):
                (new \App\GRPCommand())->deployGRP2();
            else:
                return response()->json("Shit! Project not found.", 500);
            endif;

            return response()->json("Great! Deploy $project successfully executed.", 200);
        } catch (\Exception $e) {
            return response()->json("Shit! Deploy $project failed.", 500);
        }
    }

    public function executeMigration(Request $request)
    {
        try {
            $command = $request->get('command');
            $migrations = $request->get('migrations');

            if ($command === "CREATE"):
                $return = (new \App\GRPCommand())->migrationCreate();

                return response()->json("Great! $return created.", 200);
            elseif ($command === "RUN"):
                (new \App\GRPCommand())->migrationRun();

                return response()->json("Great! Migrated migrations.", 200);
            elseif ($command === "ROLLBACK"):
                (new \App\GRPCommand())->migrationRollback($migrations);

                return response()->json("Great! Migrated migrations.", 200);
            else:
                return response()->json("Shit! Command not found.", 500);
            endif;
        } catch (\Exception $e) {
            return response()->json("Shit! Command $command migration failed.", 500);
        }
    }
}
