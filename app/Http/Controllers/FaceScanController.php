<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaceScanController extends Controller
{
    /**
     * Menampilkan halaman untuk scan wajah.
     */
    public function index()
    {
        return view('facescan.index');
    }
}