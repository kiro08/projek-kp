@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <head>
                <h1>Data Table : {{ $tableName }}</h1>
                <br>
            </head>
            
            <section>
                <div class="container mt-4">
                    <div class="row">
                    <div class="input-group col-md-4">
                    <!-- Form Pencarian -->
                        <form action="{{ route('search', ['tableName' => $tableName]) }}" method="GET">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword" placeholder="Search for..." aria-label="Search" aria-describedby="search-btn">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="searchColumn">
                                    @foreach ($columns as $column)
                                        <option value="{{ $column }}">{{ $column }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit" id="search-btn">Search</button>
                        </form>
                    </div>
                        <div class="col-md-8 text-md-right">
                        <form action="{{ route('export', ['tableName' => $tableName]) }}" method="GET">
                            <div class="form-row align-items-center justify-content-end">
                                <div class="col-3">
                                    <input type="text" name="keyword" class="form-control mb-2" placeholder="Keyword" value="{{ request('keyword') }}">
                                </div>
                                <div class="col-3">
                                    <select name="column" class="custom-select mb-2">
                                        <option value="">Choose column</option>
                                        @foreach ($columns as $column)
                                            <option value="{{ $column }}">{{ $column }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br>
                            <div class="form-row">
                                <div class="col d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" onclick="exportData()">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                    <button type="button" class="btn btn-warning ml-2" data-toggle="modal" data-target="#editModal">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
                
            </section> 
            
            <br>
            <section>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table table-striped">
                        <!--Table head-->
                        <thead>
                            @if (!$tableData->isEmpty() && isset($tableData[0]))
                                <tr>
                                    @foreach($tableData[0] as $column => $value)
                                        <th>
                                            {{ $column }}
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenu{{$column}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Filter
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu{{$column}}">
                                                    @php
                                                        $uniqueValues = $tableData->pluck($column)->unique();
                                                        $valueCounts = $tableData->countBy($column);
                                                    @endphp
                                                    <a class="dropdown-item" href="#" onclick="filterByColumn('{{ $column }}', '')">Semua ({{ $tableData->count() }})</a>
                                                    @foreach ($uniqueValues as $value)
                                                        <a class="dropdown-item" href="#" onclick="filterByColumn('{{ $column }}', '{{ $value }}')">{{ $value }} ({{ $valueCounts[$value] }})</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            @endif
                        </thead>
                        <!--Table head-->

                        <!--Table body-->
                        <tbody>
                            @if ($tableData->isEmpty())
                                <tr>
                                    <td colspan="{{ count($columns) }}">Tidak ada data yang sesuai dengan pencarian Anda.</td>
                                </tr>
                            @else
                                @foreach ($tableData as $row)
                                    <tr>
                                        @foreach($row as $column => $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <!--Table body-->
                    </table>
                    <br>
                    <!--Table-->
               <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Tombol Previous --}}
            @if ($tableData->currentPage() === 1)
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&lt;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $tableData->url($tableData->currentPage() - 1) }}" aria-label="Previous">&lt;</a>
                </li>
            @endif

            {{-- Tombol Next --}}
            @if ($tableData->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $tableData->nextPageUrl() }}" aria-label="Next">&gt;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        {{-- Tombol Previous --}}
        @if ($tableData->isEmpty() || $tableData->currentPage() === 1)
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&lt;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $tableData->previousPageUrl() }}" aria-label="Previous">&lt;</a>
            </li>
        @endif

        {{-- Tombol Next --}}
        @if ($tableData->isEmpty() || $tableData->count() < $tableData->perPage())
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&gt;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $tableData->nextPageUrl() }}" aria-label="Next">&gt;</a>
            </li>
        @endif
    </ul>
</nav>

                </div>
            </section>
            <section>
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Pilihan kolom -->
                                <form action="{{ route('update', $tableName) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- Pilihan kolom -->
                                    <div class="form-group">
                                        <label for="columnSelect">Pilih Kolom</label>
                                        <select class="form-control" id="columnSelect" name="columnSelect">
                                            @foreach ($columns as $column)
                                                <option value="{{ $column }}">{{ $column }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Form untuk kata-kata/kolom yang ingin diubah -->
                                    <div class="form-group">
                                        <label for="changeInput">Kata-kata/Kolom yang ingin diubah</label>
                                        <input type="text" class="form-control" id="changeInput" name="changeInput">
                                    </div>

                                    <!-- Form untuk mengisi kata-katanya ingin dirubah menjadi apa -->
                                    <div class="form-group">
                                        <label for="newValueInput">Kata-kata yang ingin dirubah menjadi</label>
                                        <input type="text" class="form-control" id="newValueInput" name="newValueInput">
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                                </form>
                        </div>
                    </div>
                </div>
                <script>
                    function exportData() {
                        // Redirect ke URL eksport dengan query parameter
                        window.location.href = "/export?tableName=" + encodeURIComponent("{{ $tableName }}");
                    }
                     var originalTableData = @json($tableData);
                    function filterByColumn(column, value) {
                            $('table tbody tr').show(); // Tampilkan semua baris tabel
                            if (value !== '') {
                                $('table tbody tr').each(function() {
                                    var cellValue = $(this).find('td:eq(' + $('table thead th').index($('table thead th:contains(' + column + ')')) + ')').text();
                                    if (cellValue !== value) {
                                        $(this).hide(); // Sembunyikan baris jika nilainya tidak sesuai
                                    }
                                });
                            }
                        }

                    function resetFilters() {
                        $('table tbody tr').show(); // Tampilkan semua baris tabel
                    }
                </script>

            </section>
                            <!-- End Modal -->
        </div>
    </div>
</div>
@endsection