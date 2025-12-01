<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CustomerModel;
use App\Models\Admin\WebModel;
use Illuminate\Http\Request;

class LapCustomerController extends Controller
{
    public function print(Request $request)
    {
        // Ambil semua data customer urut dari yang terbaru
        $data['data'] = CustomerModel::orderBy('customer_id', 'DESC')->get();

        $data["title"] = "Print Data Customer";
        $data['web'] = WebModel::first();
        $data['tglawal'] = date('Y-m-d'); // Default tanggal hari ini (opsional)
        $data['tglakhir'] = date('Y-m-d');

        return view('Admin.Laporan.Customer.print', $data);
    }
}