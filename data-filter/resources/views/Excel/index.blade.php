<!DOCTYPE html>
<html>
<head>
    <title>Data Manajemen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/dash.css">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="\asset\img\logo.png" width="100" alt="Logo" />
      </a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img src="\asset\img\profil.png" width="40" alt="Profile" />
              admin
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- end navbar -->
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
