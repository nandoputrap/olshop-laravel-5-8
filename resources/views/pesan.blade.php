@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$barang->nama_barang}}</li>
            </ol>
        </nav>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6 d-flex justify-content-center">
            <img src="{{url('images')}}/{{$barang->gambar}}" style="width: 300px">
        </div>
        <div class="col-md-6">
            <h1>{{$barang->nama_barang}}</h1>
            <i>{{$barang->nama_latin}}</i>
            <p>{{$barang->keterangan}}</p>
            <p>Stok: {{$barang->stok}}</p>
            <strong>Harga: Rp{{number_format($barang->harga)}}</strong>
            <form action="{{url('pesan')}}/{{$barang->id}}" method="POST">
                @csrf
                <input type="number" name="jumlah" class="form-control form-inline mt-3" style="width: 75px;" value="0" required>
                <button type="submit" class="btn btn-danger mt-3">Tambah ke keranjang</button>
                <a href="/home" class="btn btn-outline-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
