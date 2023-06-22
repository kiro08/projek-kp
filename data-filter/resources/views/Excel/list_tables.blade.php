<!DOCTYPE html>
<html>
<head>
    <title>List Tabel Excel</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>List Tabel Excel</h2>
        <table class="table table-bordered" id="tables-table">
            <thead>
                <tr>
                    <th>Nama Tabel</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tables-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("excel.tables") }}',
                columns: [
                    { data: 'table_name', name: 'table_name' }
                ]
            });
        });
    </script>
</body>
</html>
