@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Riwayat Belanja</li>
            </ol>
        </nav>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Detail Riwayat Belanja</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr class="">
                            <th scope="col">No</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1; 
                        ?>
                        @if (!empty($pesananDetails))
                            @foreach ($pesananDetails as $item)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td><img src="{{url('images')}}/{{$item->barang->gambar}}" alt="" style="width: 100px;"></td>
                                <td>{{$item->barang->nama_barang}}</td>
                                <td>{{$item->jumlah}}</td>
                                <td>Rp{{number_format($item->jumlah_harga)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total Harga</strong></td>
                                <td><strong>Rp{{number_format($pesanan->jumlah_harga)}}</strong></td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
