@include('branches.edit', [
    'title' => 'Tambah Cabang',
    'action' => route('branches.store'),
    'method' => 'POST',
    'branch' => null,
])
