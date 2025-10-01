<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi diubah: tambahkan validasi untuk 'phone'
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:'.User::class], // Validasi untuk phone
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Pembuatan User diubah: tambahkan 'phone'
        $user = User::create([
            'name' => $request->name,
            'email' => Str::uuid()->toString() . '@example.com',
            'phone' => $request->phone, // Simpan nomor handphone
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
