@extends('layouts.app')

@section('title', 'Dashboard - FaceAbsen')

@section('styles')
<style>
    @section('styles')
<style>
    /* Container */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .dashboard-header h1 {
        color: #2563EB;
        margin-bottom: 0.5rem;
    }

    /* Section Card */
    .section {
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .section h2 {
        color: #2563EB;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Form */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        background: #f9fafb;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #111827;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
    }

    /* Table */
    .table-container {
        overflow-x: auto;
        margin-top: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #e0f2fe;
    }

    th {
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        color: #2563EB;
        border-bottom: 2px solid #badcff;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    tbody tr:hover {
        background: #f1f5f9;
    }

    /* Image */
    .user-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #3B82F6;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-success {
        background: #dcfce7;
        color: #16A34A;
        border: 1px solid #16A34A;
    }

    .status-failed {
        background: #fee2e2;
        color: #DC2626;
        border: 1px solid #DC2626;
    }

    /* Alerts */
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-success {
        background: #dcfce7;
        border: 1px solid #16A34A;
        color: #16A34A;
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #DC2626;
        color: #DC2626;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.4;
    }
</style>
@endsection

</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-line"></i> Dashboard Sistem Absensi</h1>
        <p style="color: #9CA3AF;">Kelola data user dan monitoring absensi</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Form Tambah User -->
    <div class="section">
        <h2><i class="fas fa-user-plus"></i> Tambah Data User</h2>
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="image"><i class="fas fa-image"></i> Upload Foto (JPEG/PNG)</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data
            </button>
        </form>
    </div>

    <!-- Tabel Data User -->
    <div class="section">
        <h2><i class="fas fa-users"></i> Data User Terdaftar</h2>
        <div class="table-container">
            @if($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Foto</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            <img src="{{ asset($user->image) }}" alt="{{ $user->username }}" class="user-image">
                        </td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <p>Belum ada data user terdaftar</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tabel Data Absensi -->
    <div class="section">
        <h2><i class="fas fa-clipboard-check"></i> Riwayat Absensi</h2>
        <div class="table-container">
            @if($absens->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Waktu Absen</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absens as $index => $absen)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $absen->username }}</td>
                        <td>{{ $absen->time_absen->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ $absen->location }}" target="_blank" style="color: #3B82F6;">
                                <i class="fas fa-map-marker-alt"></i> Lihat Maps
                            </a>
                        </td>
                        <td>
                            <span class="status-badge {{ $absen->status === 'success' ? 'status-success' : 'status-failed' }}">
                                <i class="fas fa-{{ $absen->status === 'success' ? 'check' : 'times' }}"></i>
                                {{ strtoupper($absen->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('absen.destroy', $absen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data absensi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-clipboard"></i>
                <p>Belum ada riwayat absensi</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection