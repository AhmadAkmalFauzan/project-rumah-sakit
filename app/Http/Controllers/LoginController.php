<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login()
    {
        // if(Auth::check()){
        //     return view('welcome');
        // }else{
            return view('login');
        // }
    }

    public function register()
    {
        return view('register');
    }

    public function actionlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->with('error','Email yang anda Masukkan Salah');
        }

        if (Auth::attempt($credentials)) {
            // return redirect()->route('dokter.index');
            return redirect('/');
        }

        return back()->with('error', 'Login gagal karena alasan tidak diketahui.');
    }


    public function actionlogout()
    {
        Auth::logout();
        // return redirect()->route('login');
        return redirect('/');
    }


    public function actionregister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => $request->role ?? 'user',
            'role' => 'user',
            'email_verified_at' => now(),
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
        ]);

        // Auth::login($user);

        return redirect()->route('login');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = $foto->getClientOriginalName(); // nama asli
            $foto->move(public_path('profil'), $fotoName);

            // Hapus foto lama kalau ada
            // if ($user->foto && file_exists(public_path('profil/' . $user->foto))) {
            //     unlink(public_path('profil/' . $user->foto));
            // }

            // Simpan nama file di database
            $user->foto = $fotoName;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diubah.');
    }

}
