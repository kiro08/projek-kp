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
        $tableData = DB::table($tableName)->paginate(100);
    
        // Mendapatkan daftar kolom dari tabel yang dipilih
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
    
        return view('pages.backend.view', compact('tableName', 'tableData', 'database', 'columns'));
    }
    
    public function update(Request $request, $tableName)
    {
        $columnName = $request->input('columnSelect');
        $searchKeyword = $request->input('changeInput');
        $newValue = $request->input('newValueInput');

        // Mengganti nilai pada kolom yang dipilih yang mengandung kata-kata tertentu
        DB::table($tableName)
            ->where($columnName, 'LIKE', "%{$searchKeyword}%")
            ->update([$columnName => DB::raw("REPLACE($columnName, '{$searchKeyword}', '{$newValue}')")]);

        return redirect()->back()->with('success', 'Kolom berhasil diubah dan nilai diupdate.');
    }
    public function search(Request $request, $tableName)
    {
        $database = env('DB_DATABASE', 'bri');
        $keyword = $request->input('keyword');
        $searchColumn = $request->input('searchColumn');

        // Mendapatkan data dari tabel yang dipilih berdasarkan kolom pencarian
        $tableData = DB::table($tableName)
            ->where($searchColumn, 'LIKE', "%{$keyword}%")
            ->paginate(100);

        return view('pages.backend.view', compact('tableName', 'tableData', 'database'));
    }


}
