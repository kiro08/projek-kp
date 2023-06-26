<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use DataTables;


class AdminController extends Controller
{
    public function Dashboard()
    {
        $database = env('DB_DATABASE', 'bri');
        $tables = DB::select("SHOW TABLES FROM `$database`");

        $hiddenTables = ['failed_jobs', 'migrations','personal_access_tokens','password_reset_tokens','users']; // Tabel-tabel yang ingin disembunyikan

        // Filter tabel-tabel yang ingin ditampilkan
        $filteredTables = array_filter($tables, function ($table) use ($hiddenTables, $database) {
            $tableName = $table->{'Tables_in_' . $database};
            return !in_array($tableName, $hiddenTables);
        });

        return view('pages.backend.dashboard', compact('filteredTables', 'database'));
    }

    public function index()
    {
        return view('pages.backend.index');
    }

    public function view($tableName)
    {
        $database = env('DB_DATABASE', 'bri');

        // Mendapatkan data dari tabel yang dipilih
        $tableData = DB::table($tableName)->paginate(100);;

        return view('pages.backend.view', compact('tableName', 'tableData', 'database'));
    }
}
