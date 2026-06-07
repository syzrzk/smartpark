<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| LOGIN GOOGLE
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', function () {

    return Socialite::driver('google')->redirect();

})->name('google.login');

Route::get('/auth/google/callback', function () {

    try {

        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $user = User::updateOrCreate(

            ['email' => $googleUser->email],

            [
                'name' => $googleUser->name,
                'password' => bcrypt('google_login'),
                'role' => 'petugas'
            ]
        );

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(5);

        $user->save();

        Mail::raw(
            "Kode OTP kamu: $otp",

            function ($msg) use ($user) {

                $msg->to($user->email)
                    ->subject('OTP SmartPark');
            }
        );

        session([
            '2fa_user_id' => $user->id
        ]);

        return redirect('/verify-otp');

    } catch (\Exception $e) {

        return "ERROR: " . $e->getMessage();
    }

});

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/

Route::get('/verify-otp', function () {

    return view('auth.otp');

});

Route::post(
    '/verify-otp',
    [AuthController::class, 'verifyOtp']
);

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| FORM MASUK PARKIR
|--------------------------------------------------------------------------
*/

Route::get('/masuk', function () {

    return view('parkir.masuk');

})->name('masuk.form');

Route::get('/masuk/member-scan', function () {

    return view('parkir.masuk_member');

})->name('parkir.masuk.member');

/*
|--------------------------------------------------------------------------
| SCAN QR
|--------------------------------------------------------------------------
*/

Route::get('/scan', function () {

    return view('parkir.scan');

})->name('parkir.scan');

/*
|--------------------------------------------------------------------------
| PARKIR
|--------------------------------------------------------------------------
*/

Route::post(
    '/masuk',
    [ParkirController::class, 'masuk']
)->name('parkir.masuk');

Route::post(
    '/parkir/keluar',
    [ParkirController::class, 'keluar']
)->name('parkir.keluar');

Route::post(
    '/parkir/keluar-plat',
    [ParkirController::class, 'keluarByPlat']
)->name('parkir.keluarByPlat');

Route::get(
    '/parkir/{id}/verifikasi',
    [ParkirController::class, 'showVerifikasi']
)->name('parkir.verifikasi');

Route::post(
    '/parkir/{id}/verifikasi',
    [ParkirController::class, 'prosesVerifikasi']
)->name('parkir.prosesVerifikasi');


/*
|--------------------------------------------------------------------------
| PEMBAYARAN PARKIR
|--------------------------------------------------------------------------
*/

Route::post(
    '/bayar/{id}',
    [ParkirController::class, 'bayar']
)->name('bayar');

Route::post(
    '/bayar-cash/{id}',
    [ParkirController::class, 'bayarCash']
)->name('parkir.bayarCash');

Route::get(
    '/bayar/sukses/{id}',
    [ParkirController::class, 'sukses']
)->name('bayar.sukses');

/*
|--------------------------------------------------------------------------
| TIKET
|--------------------------------------------------------------------------
*/

Route::get(
    '/tiket/{id}',
    [ParkirController::class, 'tiket']
)->name('tiket');

/*
|--------------------------------------------------------------------------
| STRUK
|--------------------------------------------------------------------------
*/

Route::get(
    '/struk/{id}',
    [ParkirController::class, 'struk']
)->name('struk');

Route::get(
    '/struk/{id}/download',
    [ParkirController::class, 'downloadStruk']
)->name('struk.download');

/*
|--------------------------------------------------------------------------
| MEMBER
|--------------------------------------------------------------------------
*/

Route::get(
    '/members',
    [MemberController::class, 'index']
)->name('members.index');

Route::get(
    '/members/create',
    [MemberController::class, 'create']
)->name('members.create');

Route::post(
    '/member/store',
    [MemberController::class, 'store']
)->name('member.store');

Route::get(
    '/member/sukses/{id}',
    [MemberController::class, 'sukses']
)->name('members.sukses');

Route::get(
    '/members/{id}',
    [MemberController::class, 'show']
)->name('members.show');

Route::get(
    '/members/generate',
    [MemberController::class, 'generate']
)->name('members.generate');

Route::get(
    '/members/{id}/edit',
    [MemberController::class, 'edit']
)->name('members.edit');

Route::put(
    '/members/{id}',
    [MemberController::class, 'update']
)->name('members.update');

Route::delete(
    '/members/{id}',
    [MemberController::class, 'destroy']
)->name('members.destroy');

/*
|--------------------------------------------------------------------------
| API DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/api/dashboard', function () {

    $today = \Carbon\Carbon::today();

    return response()->json([

        'totalKendaraan' => \App\Models\Parkir::where(
            'status',
            'masuk'
        )->count(),

        'totalPendapatan' => \App\Models\Parkir::where(
            'status',
            'keluar'
        )
        ->whereDate('waktu_keluar', $today)
        ->sum('biaya'),

        'motor' => \App\Models\Parkir::where(
            'status',
            'masuk'
        )
        ->whereHas(
            'kendaraan',

            fn($q) =>
                $q->where('jenis_kendaraan', 'motor')
        )->count(),

        'mobil' => \App\Models\Parkir::where(
            'status',
            'masuk'
        )
        ->whereHas(
            'kendaraan',

            fn($q) =>
                $q->where('jenis_kendaraan', 'mobil')
        )->count(),

    ]);

})->name('api.dashboard');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::resource(
        'user',
        UserController::class
    );

    Route::resource(
        'tarif',
        TarifController::class
    );

    Route::get(
        '/kendaraan',
        [ParkirController::class, 'index']
    )->name('parkir.index');

    Route::delete(
        '/kendaraan/{id}',
        [ParkirController::class, 'destroy']
    )->name('parkir.destroy');

    {{-- Reporting Routes --}}
    Route::get(
        '/reporting',
        [ReportingController::class, 'index']
    )->name('reporting.index');

    Route::get(
        '/reporting/download-pdf',
        [ReportingController::class, 'downloadPdf']
    )->name('reporting.download-pdf');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| AUTH DEFAULT
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';