<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Cabang</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 1150px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 26px;
            margin: 0;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 7px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-size: 14px;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .edit {
            background: #f59e0b;
            color: white;
        }

        .delete {
            background: #ef4444;
            color: white;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0000000a;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        th {
            background: #f8fafc;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .toko {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .bengkel {
            background: #fee2e2;
            color: #b91c1c;
        }

        .row-actions {
            display: flex;
            gap: 6px;
        }

        .alert {
            padding: 12px;
            background: #dcfce7;
            margin-bottom: 16px;
            border-radius: 6px;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Data Cabang</h1>
            <div class="actions">
                <a href="/peta" class="btn secondary">Lihat Peta</a>
                <a href="{{ route('branches.create') }}" class="btn primary">+ Tambah Cabang</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Cabang</th>
                            <th>Jenis</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                            <tr>
                                <td>{{ $branches->firstItem() + $loop->index }}</td>
                                <td>{{ $branch->nama }}</td>
                                <td>
                                    <span class="badge {{ $branch->jenis }}">
                                        {{ ucfirst($branch->jenis) }}
                                    </span>
                                </td>
                                <td>{{ $branch->alamat }}</td>
                                <td>{{ $branch->telepon ?? '-' }}</td>
                                <td>{{ $branch->latitude }}</td>
                                <td>{{ $branch->longitude }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('branches.edit', $branch) }}" class="btn edit">Edit</a>

                                        <form method="POST" action="{{ route('branches.destroy', $branch) }}"
                                            onsubmit="return confirm('Hapus cabang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center">
                                    Belum ada data cabang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</body>

</html>
