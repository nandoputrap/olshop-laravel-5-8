<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Barang;
use App\Pesanan;
use App\PesananDetail;
use Auth;
use Alert;
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

        // Alert::success('Berhasil menambah ke keranjang', 'Sukses');
        // alert('Berhasil');
        // alert()->success('Berhasil menambah ke keranjang', 'Sukses');
        return redirect('home');

        //update
        // $pesanan_baru->jumlah_harga = $barang->harga*$request->jumlah_pesanan;
    }

    public function keranjang(){
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        if(!empty($pesanan)){
            $pesananDetails = PesananDetail::where('pesanan_id', $pesanan->id)->get();
            return view('keranjang', compact('pesanan', 'pesananDetails'));
        }else{
            return view('keranjang', compact('pesanan'));
        }
    }

    public function hapus($id){
        $pesananDetail = PesananDetail::where('id', $id)->first();

        // mengurangi jumlah harga total pesanan
        $pesanan = Pesanan::where('id', $pesananDetail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesananDetail->jumlah_harga;

        $pesanan->update();

        $pesananDetail->delete();
        return redirect('keranjang');
    }

    public function konfirmasi(){
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesananId = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();

        $pesananDetails = PesananDetail::where('pesanan_id', $pesananId)->get();

        foreach($pesananDetails as $item){
            $barang = Barang::where('id', $item->barang_id)->first();
            $barang->stok = $barang->stok-$item->jumlah;
            $barang->update();
        }

        return redirect('home');
    }

    public function riwayat_detail($id){
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $pesananDetails = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        return view('riwayatdetail', compact('pesanan', 'pesananDetails'));
        // return $pesananDetails;
    }

    public function riwayat(){
        $pesanans = Pesanan::where('user_id', Auth::user()->id)->get();
        // $pesananDetails = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        return view('riwayat', compact('pesanans'));
        // return $pesanans;
        // return $pesananDetails;
    }
}
