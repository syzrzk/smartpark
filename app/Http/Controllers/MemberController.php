<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Snap;

class MemberController extends Controller
{
    /**
     * =========================================================
     * LIST MEMBER
     * =========================================================
     */
    public function index()
    {
        $members = Member::latest()->get();

        return view('members.index', compact('members'));
    }

    /**
     * =========================================================
     * FORM CREATE
     * =========================================================
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * =========================================================
     * STORE + MIDTRANS
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama' => 'required',

            'plat_nomor' => 'required|unique:members',

            'jenis_kendaraan' => 'required',

            'tipe' => 'required',

            'expired_at' => 'required|date',

        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN MEMBER
        |--------------------------------------------------------------------------
        */

        $member = Member::create([

            'nama' => $request->nama,

            'plat_nomor' =>
                strtoupper($request->plat_nomor),

            'jenis_kendaraan' =>
                $request->jenis_kendaraan,

            'tipe' =>
                $request->tipe,

            'expired_at' =>
                $request->expired_at,

            'is_active' => false,

        ]);

        /*
        |--------------------------------------------------------------------------
        | HARGA MEMBER
        |--------------------------------------------------------------------------
        */

        if ($request->tipe == 'vip') {

            $harga = 100000;

        } else {

            $harga = 50000;
        }

        /*
        |--------------------------------------------------------------------------
        | CONFIG MIDTRANS
        |--------------------------------------------------------------------------
        */

        Config::$serverKey =
            env('MIDTRANS_SERVER_KEY');

        Config::$isProduction = false;

        Config::$isSanitized = true;

        Config::$is3ds = true;

        /*
        |--------------------------------------------------------------------------
        | PARAMETER MIDTRANS
        |--------------------------------------------------------------------------
        */

        $params = [

            'transaction_details' => [

                'order_id' =>
                    'MEMBER-' .
                    $member->id .
                    '-' .
                    time(),

                'gross_amount' => $harga,
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | GENERATE SNAP TOKEN
        |--------------------------------------------------------------------------
        */

        $snapToken =
            Snap::getSnapToken($params);

        /*
        |--------------------------------------------------------------------------
        | HALAMAN BAYAR
        |--------------------------------------------------------------------------
        */

        return view(
            'members.bayar',

            compact(
                'member',
                'snapToken',
                'harga'
            )
        );
    }

    /**
     * =========================================================
     * PEMBAYARAN BERHASIL
     * =========================================================
     */
    public function sukses($id)
    {
        $member = Member::findOrFail($id);

        $member->is_active = true;

        $member->save();

        return redirect()
            ->route('members.index')
            ->with(
                'success',
                'Member berhasil diaktifkan'
            );
    }

    /**
     * =========================================================
     * SHOW
     * =========================================================
     */
    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return view(
            'members.show',
            compact('member')
        );
    }

    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);

        return view(
            'members.edit',
            compact('member')
        );
    }

    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        string $id
    )
    {
        $member = Member::findOrFail($id);

        $request->validate([

            'nama' => 'required',

            'plat_nomor' =>
                'required|unique:members,plat_nomor,' .
                $member->id,

            'jenis_kendaraan' => 'required',

            'tipe' => 'required',

            'expired_at' => 'required|date',

        ]);

        $member->update([

            'nama' => $request->nama,

            'plat_nomor' =>
                strtoupper($request->plat_nomor),

            'jenis_kendaraan' =>
                $request->jenis_kendaraan,

            'tipe' =>
                $request->tipe,

            'expired_at' =>
                $request->expired_at,

        ]);

        return redirect()
            ->route('members.index')
            ->with(
                'success',
                'Member berhasil diupdate'
            );
    }

    /**
     * =========================================================
     * DELETE
     * =========================================================
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return redirect()
            ->route('members.index')
            ->with(
                'success',
                'Member berhasil dihapus'
            );
    }

    /**
     * =========================================================
     * HALAMAN GENERATE QR MEMBER
     * =========================================================
     */
    public function generate()
    {
        return view('members.generate');
    }
}