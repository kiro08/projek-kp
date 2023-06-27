@extends('layout.admin')

@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
        <div class="container mt-5">
        <h2>Unggah File Excel</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="excel_files[]" class="form-control-file" multiple>
                @error('excel_files')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="table_name" class="form-label">Nama Tabel</label>
                <input type="text" class="form-control" id="table_name" name="table_name" required>
            </div>
            <div class="mb-3">
                <label for="reference_column" class="form-label">Kolom Acuan</label>
                <input type="text" class="form-control" id="reference_column" name="reference_column" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>
    <br>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div> 
@endsection
