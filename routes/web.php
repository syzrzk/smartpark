<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

/*
|--------------------------------------------------------------------------
| LOGIN GOOGLE (FINAL FIX)
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');
Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('tarif', TarifController::class);
});
Route::get('/verify-otp', function () {
    return view('auth.otp');
});

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/auth/google/callback', function () {

    try {

        /** @var \Laravel\Socialite\Two\GoogleProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'password' => bcrypt('google_login'),
                'role' => 'petugas'
            ]
        );

        // 🔥 generate OTP
        $otp = rand(100000, 999999);

        // 🔥 simpan OTP
        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        // 🔥 kirim email
        Mail::raw("Kode OTP kamu: $otp", function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject('OTP SmartPark');
        });

        // 🔥 simpan session
        session(['2fa_user_id' => $user->id]);

        return redirect('/verify-otp');

    } catch (\Exception $e) {
        return "ERROR: " . $e->getMessage();
    }
});



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// Form masuk parkir
Route::get('/masuk', function () {
    return view('parkir.masuk');
})->name('masuk.form');

// Scan QR
Route::get('/scan', function () {
    return view('parkir.scan');
})->name('parkir.scan');

// Proses parkir
Route::post('/masuk', [ParkirController::class, 'masuk'])->name('parkir.masuk');
Route::post('/parkir/keluar', [ParkirController::class, 'keluar'])->name('parkir.keluar');
Route::post('/parkir/keluar-plat', [ParkirController::class, 'keluarByPlat'])->name('parkir.keluarByPlat');
Route::post('/bayar/{id}', [ParkirController::class, 'bayar'])->name('bayar');
Route::get('/bayar/sukses/{id}', [ParkirController::class, 'sukses'])->name('bayar.sukses');
// Tiket & struk
Route::get('/tiket/{id}', [ParkirController::class, 'tiket'])->name('tiket');
Route::get('/struk/{id}', [ParkirController::class, 'struk'])->name('struk');
Route::get('/struk/{id}/download', [ParkirController::class, 'downloadStruk'])
    ->name('struk.download');

// API dashboard (live refresh)
Route::get('/api/dashboard', function () {
    $today = \Carbon\Carbon::today();
    return response()->json([
        'totalKendaraan'   => \App\Models\Parkir::where('status','masuk')->count(),
        'totalPendapatan'  => \App\Models\Parkir::where('status','keluar')
                                ->whereDate('waktu_keluar', $today)->sum('biaya'),
        'motor' => \App\Models\Parkir::where('status','masuk')
                    ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan','motor'))->count(),
        'mobil' => \App\Models\Parkir::where('status','masuk')
                    ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan','mobil'))->count(),
    ]);
})->name('api.dashboard');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('user', UserController::class);

    // Data Kendaraan Masuk
    Route::get('/kendaraan', [ParkirController::class, 'index'])->name('parkir.index');
    Route::delete('/kendaraan/{id}', [ParkirController::class, 'destroy'])->name('parkir.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';