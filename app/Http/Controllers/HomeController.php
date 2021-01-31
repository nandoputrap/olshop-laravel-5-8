<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// eloquent
use App\Barang;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // menampilan semua barang
        $barangs = Barang::all();
        // pagination
        // $barangs = Barang::paginate(1);
        return view('home', compact('barangs'));
    }
}
