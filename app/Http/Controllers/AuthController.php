<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'tanggal_lahir' => 'required',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);
        $user->assignRole('Member');

        return response(['status' => '200', 'messages' => 'Register Berhasil Dilakukan']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Invalid Username']
            ]);
        } elseif (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid Password']
            ]);
        }

        unset($user->email_verified_at, $user->created_at, $user->updated_at, $user->deleted_at);
        $user->tokens()->delete();
        $token = $user->createToken('sanctum')->plainTextToken;
        $user->token = $token;

        return response(['data' => $user, 'response' => '200', 'messages' => 'Login Berhasil']);
    }

    public function profile()
    {
        $user = auth()->user();
        return response(['data' => $user, 'response' => '200', 'messages' => 'Berhasil Tampilkan Data User']);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'jenis_kelamin' => 'required',
            'nomor_telfon' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required'
        ]);

        $user = auth()->user();

        $user->update($request->all());

        return response(['data' => $user, 'status' => '200', 'messages' => 'Profile Berhasil Diperbarui']);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return response(['messages' => 'Logout Berhasil']);
    }
}
