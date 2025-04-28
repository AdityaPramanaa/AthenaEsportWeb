@extends('layouts.admin-tailwind')

@section('title', 'Kelola Anggota')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Users</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Nama</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">NIM</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Prodi</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr>
                    <td class="px-4 py-2 text-gray-900">{{ $user->name }}</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->email }}</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->nim }}</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->prodi ?? 'Belum diisi' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : ($user->role == 'pengurus' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600') }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="px-4 py-2">
                        @if($user->status == 'active')
                            <span class="px-2 py-0.5 rounded text-xs bg-green-100 text-green-600">Aktif</span>
                        @elseif($user->status == 'pending')
                            <span class="px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-600">Pending</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs bg-red-100 text-red-600">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 flex flex-wrap gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 flex items-center gap-1"><i class="fas fa-edit"></i> Edit</a>
                        <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-xs hover:bg-gray-600 flex items-center gap-1"><i class="fas fa-eye"></i> Lihat</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 flex items-center gap-1"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                        @if($user->status == 'pending')
                        <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 flex items-center gap-1"><i class="fas fa-check"></i> Verifikasi</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Sweet Alert untuk konfirmasi verifikasi
    const verifyButtons = document.querySelectorAll('.verify-btn');
    verifyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const userName = this.closest('tr').querySelector('td:first-child').textContent;
            
            Swal.fire({
                title: 'Verifikasi User',
                html: `Apakah Anda yakin ingin memverifikasi user <strong>${userName}</strong>?<br>
                      <small class="text-muted">User akan mendapatkan akses sebagai anggota</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check"></i> Ya, Verifikasi!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                width: 'auto',
                padding: '2em',
                customClass: {
                    container: 'my-swal',
                    popup: 'rounded-lg shadow-lg',
                    header: 'border-bottom-0',
                    title: 'h5 mb-3',
                    content: 'text-center px-4',
                    confirmButton: 'btn btn-success px-4 me-2',
                    cancelButton: 'btn btn-secondary px-4',
                    actions: 'd-flex justify-content-center gap-2'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Sweet Alert untuk notifikasi sukses/error
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
    @endif
});
</script>
@endpush

@endsection 