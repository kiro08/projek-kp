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

    public function store(Request $request)
    {
        $files = $request->file('excel_files');
        $tableName = $request->input('table_name');
        $referenceColumn = $request->input('reference_column');

        // Validasi file Excel
        $validatedData = $request->validate([
            'excel_files' => 'required|array',
            'excel_files.*' => 'required|mimes:xls,xlsx',
            'table_name' => 'required',
            'reference_column' => 'required',
        ]);

        foreach ($files as $file) {
            // Membaca file Excel
            $spreadsheet = IOFactory::load($file);
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

                // Menentukan nama tabel berdasarkan sheet name dengan tambahan angka urutan
                $newTableName = $tableName . '_' . ($index + 1);

                // Periksa apakah tabel dengan nama yang sama sudah ada
                if (Schema::hasTable($newTableName)) {
                    // Tabel sudah ada, lakukan proses penggabungan atau beri nama tabel yang berbeda
                    // Misalnya, tambahkan angka unik atau lainnya untuk nama tabel baru
                    $newTableName = $tableName . '_' . uniqid();
                }

                // Membuat tabel baru berdasarkan nama tabel yang ditentukan
                Schema::create($newTableName, function ($table) use ($columnNames) {
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

                DB::table($newTableName)->insert($insertData);
            }
        }

        return redirect()->back()->with('success', 'File Excel berhasil diunggah dan disimpan.');
    }
}
