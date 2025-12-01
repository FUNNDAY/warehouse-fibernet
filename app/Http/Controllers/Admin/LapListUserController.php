<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserModel;
use App\Models\Admin\WebModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan pakai ini biar aman
use Carbon\Carbon;

class LapListUserController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Laporan Data User";
        return view('Admin.Laporan.User.index', $data);
    }

    public function print(Request $request)
    {
        // Query Data User (Join dengan Role)
        $data['data'] = UserModel::leftJoin('tbl_role', 'tbl_role.role_id', '=', 'tbl_user.role_id')
                        ->orderBy('user_id', 'DESC')
                        ->get();

        $data["title"] = "Print Data User";
        $data['web'] = WebModel::first();
        
        // Kita simpan variabel ini kalau-kalau nanti butuh filter tanggal created_at
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;

        return view('Admin.Laporan.User.print', $data);
    }

    public function pdf(Request $request)
    {
        // Query Data User (Sama dengan Print)
        $data['data'] = UserModel::leftJoin('tbl_role', 'tbl_role.role_id', '=', 'tbl_user.role_id')
                        ->orderBy('user_id', 'DESC')
                        ->get();

        $data["title"] = "PDF Data User";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;

        // Load View PDF
        $pdf = Pdf::loadView('Admin.Laporan.User.pdf', $data);
        
        // Setting Paper (Opsional, biasanya A4 Portrait untuk list user)
        $pdf->setPaper('a4', 'portrait');

        if($request->tglawal){
            return $pdf->download('lap-user-'.$request->tglawal.'-'.$request->tglakhir.'.pdf');
        }else{
            return $pdf->download('lap-user-semua.pdf');
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            // Query DataTables
            $data = UserModel::leftJoin('tbl_role', 'tbl_role.role_id', '=', 'tbl_user.role_id')
                    ->orderBy('user_id', 'DESC')
                    ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    // Logic Foto User
                    if($row->user_foto != 'undraw_profile.svg'){
                        $url = asset('storage/users/' . $row->user_foto);
                    } else {
                        $url = asset('assets/img/undraw_profile.svg'); // Sesuaikan path default Anda
                    }
                    $img = '<img src="'.$url.'" width="40" height="40" class="rounded-circle">';
                    return $img;
                })
                ->addColumn('role', function ($row) {
                    // Badge untuk Role
                    return '<span class="badge bg-primary">'.$row->role_title.'</span>';
                })
                ->addColumn('status_akun', function($row){
                    // Contoh kolom tambahan logic (misal user login terakhir)
                    return $row->updated_at ? Carbon::parse($row->updated_at)->diffForHumans() : '-';
                })
                ->rawColumns(['img', 'role', 'status_akun']) // Render HTML
                ->make(true);
        }
    }
}
