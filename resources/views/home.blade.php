@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Selamat datang di Ndos Garden Shop</h1>
    </div>
    <div class="row mt-5">
        @foreach ($barangs as $barang)
        <div class="col-md-4 d-flex justify-content-center">
            <div class="card mb-5" style="width: 18rem;">
                <img class="card-img-top" src="{{url('images')}}/{{$barang->gambar}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><a href="pesan/{{$barang->id}}">{{$barang->nama_barang}}</a></h5>
                    <i>{{$barang->nama_latin}}</i>
                    <p class="card-text price mt-3"><strong>Rp{{number_format($barang->harga)}}</strong></p>
                    <a href="pesan/{{$barang->id}}" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
