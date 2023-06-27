@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <head>
                <h1>Data Tabel {{ $tableName }}</h1>
                <br>
            </head>
            
            <section>
                <div class="container mt-4">
                    <div class="row">
                    <div class="input-group col md-4">
                        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="search-btn">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="search-btn">Search</button>
                        </div>
                    </div>
                        <div class="col-md-8 text-md-right">
                        <button class="btn btn-success mr-2">
                            <i class="fas fa-file-excel"></i>
                            Export Excel</button>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal">
                        Edit
                        </button>
                        
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
                            <tr>
                                @foreach($tableData[0] as $column => $value)
                                    <th>{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <!--Table head-->

                        <!--Table body-->
                        <tbody>
                             @foreach ($tableData as $row)
                                <tr>
                                    @foreach($row as $column => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <!--Table body-->
                    </table><br>
                    <!--Table-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{-- Tombol Previous --}}
                            @if ($tableData->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&lt;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $tableData->previousPageUrl() }}" aria-label="Previous">&lt;</a>
                                </li>
                            @endif

                            {{-- Angka halaman --}}
                            @for ($i = max(1, $tableData->currentPage() - 2); $i <= min($tableData->lastPage(), $tableData->currentPage() + 2); $i++)
                                <li class="page-item {{ ($i === $tableData->currentPage()) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $tableData->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

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

                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>

                        </div>
                    </div>
                </div>
            </section>
                            <!-- End Modal -->
        </div>
    </div>
</div>
@endsection