@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
</div>
<div class="card-glass p-3 mb-4">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary-admin btn-sm"><i class="bi bi-search"></i></button>
    </form>
</div>
<div class="card-glass p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-qlc mb-0">
            <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Asesmen</th><th>Daftar</th><th></th></tr></thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="text-muted small">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td class="fw-medium">{{ $u->name }}</td>
                        <td class="text-muted small">{{ $u->email }}</td>
                        <td class="small">{{ $u->assessments()->where('status','completed')->count() }} tes</td>
                        <td class="text-muted small">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna ini?\nData asesmen juga akan terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.12); color:#fca5a5; font-size:.72rem;"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pengguna ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->withQueryString()->links() }}</div>
@endsection
