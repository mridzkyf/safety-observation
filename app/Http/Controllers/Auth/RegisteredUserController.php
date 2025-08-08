<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
      $areas = Area::all(); // Ambil semua area sebagai daftar seksi
      return view('auth.register', compact('areas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_seksi' => ['required', 'string'],
            'group' => ['required', 'in:DAY TIME,GROUP A,GROUP B,GROUP C,GROUP D'],
        ]);
    // Cari ID area berdasarkan nama seksi
    $area = Area::where('name', $request->nama_seksi)->first();
    $areaId = $area ? $area->id : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_seksi' => $request->nama_seksi,
            'group' => $request->group,
            'area_id' => $areaId, // otomatis diisi berdasarkan nama seksi
            'is_admin' => 0, //semua yang register jadi admin.
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
