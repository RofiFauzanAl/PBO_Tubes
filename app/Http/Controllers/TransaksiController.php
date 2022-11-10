<?php

namespace App\Http\Controllers;
use PDF;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function generate_pdf()
  {
    $data = [
      'foo' => 'bar'
    ];
    $pdf = PDF::loadView('pdf.document', $data);
    return $pdf->stream('document.pdf');
  }
}