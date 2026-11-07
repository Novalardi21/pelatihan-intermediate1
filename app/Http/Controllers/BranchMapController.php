<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchMapController extends Controller
{
    public function map()
    {
        $branches = Branch::select(
            'id',
            'nama',
            'alamat',
            'jenis',
            'telepon',
            'latitude',
            'longitude'
        )->get();
        return view('peta', compact('branches'));
    }
    public function index()
    {
        $branches = Branch::latest()->paginate(10);

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateBranch($request);

        Branch::create($data);

        return redirect()->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $this->validateBranch($request);

        $branch->update($data);

        return redirect()->route('branches.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }

    private function validateBranch(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'jenis' => ['required', Rule::in(['toko', 'bengkel'])],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);
    }
}
