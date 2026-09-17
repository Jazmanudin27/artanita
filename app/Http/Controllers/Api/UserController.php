<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json(['data' => $user], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        $user = User::create($validatedData);
        return response()->json(['message' => 'Siswa created', 'data' => $user], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);
        return response()->json(['message' => 'Siswa updated', 'data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Siswa deleted'], 200);
    }
}
