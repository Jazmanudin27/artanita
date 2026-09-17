<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = User::where('username', $request->input('username'))->first();
            $token = $user->createToken('remember_token')->plainTextToken;
            $data = User::where('id', $user->id)->first();
            return response()->json(['kategori' => 'User', 'token' => $token, 'data' => $data], 200);
        } else if (Auth::guard('siswa')->attempt($credentials)) {
            $siswa = Siswa::where('username', $request->input('username'))->first();
            $token = $siswa->createToken('remember_token')->plainTextToken;
            $data = Siswa::where('kode_siswa', $siswa->kode_siswa)->first();
            return response()->json(['kategori' => 'Siswa', 'token' => $token, 'data' => $data], 200);
        } else if (Auth::guard('guru')->attempt($credentials)) {
            $guru = Guru::where('username', $request->input('username'))->first();
            $token = $guru->createToken('remember_token')->plainTextToken;
            $data = Guru::where('kode_guru', $guru->kode_guru)->first();
            return response()->json(['kategori' => 'Guru', 'token' => $token, 'data' => $data], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    public function logout($id)
    {
        $user = Auth::guard('api_guru')->user();
        if ($user) {
            DB::table('personal_access_tokens')
                ->where('tokenable_id', $id)
                ->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }
        return response()->json(['message' => 'User not found'], 404);

    }
}