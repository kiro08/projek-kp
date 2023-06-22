<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Imports\ExcelExport;
use DataTables;

class ExcelController extends Controller
{
    public function index()
    {
        return view('excel.index');
    }

    public function store(Request $request)
    {
        $file = $request->file('excel_file');

        // Validasi file Excel
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        // Membaca file Excel
        $data = Excel::toCollection(new ExcelImport, $file);

        // Mengambil nama kolom dari file Excel
        $columnNames = $data[0]->first()->toArray();

        // Menentukan nama tabel berdasarkan inputan user
        $tableName = $request->input('table_name');

        // Membuat tabel baru berdasarkan nama tabel yang ditentukan
        Schema::create($tableName, function ($table) use ($columnNames) {
            foreach ($columnNames as $columnName) {
                $table->string($columnName)->nullable();
            }
        });

        // Insert data into the newly created table
        $rows = $data[0]->skip(1); // Skip the first row (column names)
        $insertData = [];
        foreach ($rows as $row) {
            $rowData = [];
            foreach ($columnNames as $index => $columnName) {
                // Pastikan data yang akan dimasukkan ke kolom sesuai dengan struktur tabel
                $rowData[$columnName] = $row[$index] ?? null;
            }
            $insertData[] = $rowData;
        }

        DB::table($tableName)->insert($insertData);

        return redirect()->back()->with('success', 'File Excel berhasil diunggah dan disimpan.');
    }

    public function listTables()
    {
        $tables = Excel::pluck('table_name');
        return view('excel.list_tables', compact('tables'));
    }

    public function showTable($tableName)
    {
        $data = \DB::table($tableName)->get();
        return view('excel.show_table', compact('data'));
    }

    // Metode lainnya seperti search, replace, dll. sesuaikan dengan kebutuhan Anda
}
