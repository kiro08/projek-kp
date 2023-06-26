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
                        <div class="col-md-4">
                            <input type="text" class="form-control bg-light border-2 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append"> 
                            </div>
                        </div>
                        <div class="col-md-8 text-md-right">
                        <button class="btn btn-primary mr-2">Import Excel</button>
                        <button class="btn btn-primary mr-2">Export Excel</button>
                        <button class="btn btn-primary">Edit</button>
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
        </div>
    </div>
</div>
@endsection