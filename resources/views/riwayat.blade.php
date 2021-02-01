@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Belanja</li>
            </ol>
        </nav>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Riwayat Belanja</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr class="">
                            <th scope="col">No</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1; 
                        ?>
                        @if (!empty($pesanans))
                            @foreach ($pesanans as $pesanan)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$pesanan->tanggal}}</td>
                                <td>Rp{{number_format($pesanan->jumlah_harga)}}</td>
                                <td>Belum dibayar</td>
                                <td>
                                    <form action="{{url('riwayatdetail')}}/{{$pesanan->id}}">
                                        <button type="submit" class="btn btn-info">Detail</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
