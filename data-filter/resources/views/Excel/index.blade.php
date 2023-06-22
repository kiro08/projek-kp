<!DOCTYPE html>
<html>
<head>
    <title>Unggah File Excel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
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
                <input type="file" name="excel_file" class="form-control-file">
                @error('excel_file')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="table_name" class="form-label">Nama Tabel</label>
                <input type="text" class="form-control" id="table_name" name="table_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>
    </div>
</body>
</html>
