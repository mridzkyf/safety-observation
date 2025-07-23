<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Pengguna</title>

    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <style>
        body {
            background-color: #032E3D;
            color: #fff;
        }

        .content-wrapper {
            padding: 40px;
        }

        .table-container {
            background-color: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: white;
            color: #032E3D;
            font-weight: bold;
            text-align: center;
            border: 1px solid #ddd;
            padding: 12px;
        }

        .table td {
            color: #032E3D;
            background-color: #f9f9f9;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #0A2B33;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .btn-primary:hover {
            background-color: #145c73;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0098be;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .d-flex.gap-2>* {
            margin-right: 6px;
        }

        .d-flex.gap-2>*:last-child {
            margin-right: 0;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .heading-section {
            font-size: 24px;
            color: #032E3D;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
            width: 100%;
        }

        .filter-row input {
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            color: #032E3D;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .filter-row button {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 6px;
            background-color: #0A2B33;
            color: white;
            border: none;
            white-space: nowrap;
            align-self: stretch;
        }

        /* Pagination rapi */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 12px;
            color: #032E3D;
        }

        .pagination svg {
            width: 1em;
            height: 1em;
            vertical-align: middle;
        }

        .pagination>nav>div>span,
        .pagination>nav>div>a {
            font-size: 14px;
            padding: 6px 10px;
            margin: 0 2px;
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="content-wrapper">
        <a href="{{ route('admin.users.dashusers') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        <div class="table-container">
            <h3 class="heading-section">Daftar nama user</h3>

            <form method="GET" action="{{ route('admin.users.tabeluser') }}" class="filter-row">
                <input type="text" name="name" placeholder="Nama" value="{{ request('name') }}">
                <input type="text" name="email" placeholder="Email" value="{{ request('email') }}">
                <input type="text" name="seksi" placeholder="Seksi" value="{{ request('seksi') }}">
                <input type="text" name="role" placeholder="Role" value="{{ request('role') }}">
                <input type="text" name="group" placeholder="Group" value="{{ request('group') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pelapor</th>
                            <th>Email</th>
                            <th>Nama Seksi</th>
                            <th>Role</th>
                            <th>Group</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nama_seksi }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->group }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-nama="{{ $user->name }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="text-muted small">
                        Menampilkan {{ $users->firstItem() }} – {{ $users->lastItem() }} dari total
                        {{ $users->total() }} data
                    </div>
                    <div class="pagination">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.btn-delete');

                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');
                        const nama = this.dataset.nama || 'user ini';

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: `User ${nama} akan dihapus secara permanen.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
</body>

</html>
