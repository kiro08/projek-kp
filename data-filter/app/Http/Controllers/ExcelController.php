<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
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
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheetNames = $spreadsheet->getSheetNames();

        // Iterasi melalui setiap sheet
        foreach ($sheetNames as $index => $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);

            // Mengambil nama kolom dari sheet
            $columnNames = [];
            $cellIterator = $sheet->getRowIterator(1)->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true); // Menghindari sel yang kosong
            foreach ($cellIterator as $cell) {
                $columnNames[] = $cell->getValue();
    }


        // Menentukan nama tabel berdasarkan inputan dari user dengan tambahan angka urutan
        $tableName = $request->input('table_name') . '_' . ($index + 1);


        // Membuat tabel baru berdasarkan nama tabel yang ditentukan
        Schema::create($tableName, function ($table) use ($columnNames) {
            foreach ($columnNames as $columnName) {
                $table->string($columnName)->nullable();
            }
        });

        // Insert data into the newly created table
        $rows = $sheet->toArray();
        $insertData = [];
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex === 0) {
                // Skip the first row (column names)
                continue;
            }

            $rowData = [];
            foreach ($columnNames as $columnIndex => $columnName) {
                // Pastikan data yang akan dimasukkan ke kolom sesuai dengan struktur tabel
                $rowData[$columnName] = $row[$columnIndex] ?? null;
            }
            $insertData[] = $rowData;
        }

        DB::table($tableName)->insert($insertData);
    }

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
