<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Barang;
use App\Pesanan;
use App\PesananDetail;
use Auth;
use Carbon\Carbon;

class PesanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $barang = Barang::where('id', $id)->first();
        return view('pesan', compact('barang'));
    }

    public function pesan(Request $request, $id){
        $barang = Barang::where('id', $id)->first();
        $now = Carbon::now();

        // validasi stok
        if($request->jumlah > $barang->stok){
            return redirect('pesan/'.$id);
        }

        // cek validasi pesanan yang sama
        $cekPesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        if(empty($cekPesanan)){
            // simpan ke db pesanan
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $now;
            $pesanan->status = 0; //0 berarti masih checkout
            $pesanan->jumlah_harga = 0;
            $pesanan->save();
        }

        $pesananBaru = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // cek pesanan detail
        $cekPesananDetail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesananBaru->id)->first();

        if(empty($cekPesananDetail)){
            // simpan ke db pesanan_detail
            $pesananDetail = new PesananDetail;
            $pesananDetail->barang_id = $barang->id;
            $pesananDetail->pesanan_id = $pesananBaru->id;
            $pesananDetail->jumlah = $request->jumlah;
            $pesananDetail->jumlah_harga = $barang->harga*$request->jumlah;
            $pesananDetail->save();
        }else{
            $pesananDetail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesananBaru->id)->first();

            $pesananDetail->jumlah = $pesananDetail->jumlah+$request->jumlah;

            // harga
            $hargaBaru = $barang->harga*$request->jumlah;
            $pesananDetail->jumlah_harga = $pesananDetail->jumlah_harga+$hargaBaru;
            $pesananDetail->update();
        }

        // total
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga+$barang->harga*$request->jumlah;
        $pesanan->update();

        return redirect('home');

        //update
        // $pesanan_baru->jumlah_harga = $barang->harga*$request->jumlah_pesanan;
        return redirect('home');
    }
}
