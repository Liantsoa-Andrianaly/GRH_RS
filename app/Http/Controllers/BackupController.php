<?php

namespace App\Http\Controllers;

use App\Models\Employee; 
use Illuminate\Http\Request;

use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Employee::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(6);

        return view('backups.index', compact('backups'));
    }
}

