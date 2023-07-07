<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Arr;
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

    
    public function update(Request $request, $tableName)
    {
        // ...
        
        if ($request->has('edit')) {
            $columnName = $request->input('columnSelect');
            $searchKeyword = $request->input('changeInput');
            $newValue = $request->input('newValueInput');
            
            // Mengganti nilai pada kolom yang dipilih yang mengandung kata-kata tertentu (tanpa memperhatikan perbedaan huruf besar/kecil)
            DB::table($tableName)
                ->whereRaw("LOWER($columnName) LIKE LOWER(?)", ["%{$searchKeyword}%"])
                ->update([$columnName => DB::raw("REPLACE(LOWER($columnName), LOWER('{$searchKeyword}'), '{$newValue}')")]);
        
            return redirect()->back()->with('success', 'Kolom berhasil diubah dan nilai diperbarui.');
        }
        
        // ...
    }


    public function view($tableName, Request $request)
    {
        $database = env('DB_DATABASE', 'bri');

        // Periksa apakah tabel ada dalam database
        if (!Schema::hasTable($tableName)) {
            // Tampilkan pesan bahwa tabel tidak ada
            $errorMessage = "Tabel $tableName tidak ditemukan.";
            return redirect()->back()->with('error', $errorMessage);
        }

        // Dapatkan daftar kolom dari tabel
        $columns = Schema::getColumnListing($tableName);

        // Ambil data dari tabel berdasarkan keyword pencarian
        $query = DB::table($tableName);

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
            }
        }

        $tableData = $query->paginate(100);

        return view('pages.backend.view', compact('tableName', 'tableData', 'database', 'columns', 'keyword'));
    }

    public function search(Request $request, $tableName)
    {
        $database = env('DB_DATABASE', 'bri');
        $keyword = $request->input('keyword');
        $searchColumn = $request->input('searchColumn', []);

        // Periksa apakah tabel ada dalam database
        if (!Schema::hasTable($tableName)) {
            // Tampilkan pesan bahwa tabel tidak ada
            $errorMessage = "Tabel $tableName tidak ditemukan.";
            return redirect()->back()->with('error', $errorMessage);
        }

        // Dapatkan daftar kolom dari tabel
        $columns = Schema::getColumnListing($tableName);

        $tableData = DB::table($tableName);

        if (!empty($keyword) && !empty($searchColumn)) {
            // Cari data berdasarkan kolom pencarian jika keyword dan kolom pencarian tidak kosong
            $tableData->where(function ($query) use ($searchColumn, $keyword) {
                foreach (Arr::wrap($searchColumn) as $column) {
                    $query->orWhere($column, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $tableData = $tableData->paginate(100);

        $tableData->appends(['keyword' => $keyword, 'searchColumn' => $searchColumn]);

        $isEmpty = $tableData->isEmpty();

        return view('pages.backend.view', compact('tableName', 'tableData', 'database', 'columns'));
    }


    public function delete(Request $request, $tableName)
    {
        // Periksa apakah tabel ada dalam database
        if (!Schema::hasTable($tableName)) {
            $errorMessage = "Tabel $tableName tidak ditemukan.";
            return redirect()->back()->with('error', $errorMessage);
        }

        // Hapus tabel dari database
        Schema::dropIfExists($tableName);

        return redirect()->back()->with('success', 'Tabel berhasil dihapus.');
    }

}
