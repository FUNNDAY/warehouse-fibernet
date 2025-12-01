<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Proteksi: Cek apakah variabel $web ada datanya --}}
    <meta name="description" content="{{ $web->web_deskripsi ?? 'Laporan' }}">
    <meta name="author" content="{{ $web->web_nama ?? 'Admin' }}">
    
    <title>{{$title}}</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        #table1 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 32px;
        }

        #table1 td,
        #table1 th {
            border: 1px solid #000; /* Ubah jadi hitam agar tegas saat diprint */
            padding: 6px;
        }

        #table1 th {
            background-color: #f2f2f2; /* Tambah warna header agar rapi */
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
            text-align: center;
        }

        #table1 td {
            font-size: 11px;
        }

        .font-medium {
            font-weight: 500;
        }
        
        /* Utility Helper */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>

</head>

<body>

    <div style="text-align: center;">
        <h2 class="font-medium" style="margin-bottom: 5px;">Laporan Barang Keluar</h2>
        
        {{-- Tampilkan Nama Web jika ada --}}
        @if(isset($web))
            <h3 style="margin-top: 0; margin-bottom: 5px;">{{ $web->web_nama }}</h3>
        @endif

        @if($tglawal == '')
            <h4 class="font-medium" style="margin-top: 0;">Semua Tanggal</h4>
        @else
            <h4 class="font-medium" style="margin-top: 0;">
                {{ \Carbon\Carbon::parse($tglawal)->translatedFormat('d F Y') }} - 
                {{ \Carbon\Carbon::parse($tglakhir)->translatedFormat('d F Y') }}
            </h4>
        @endif
    </div>

    <table border="1" id="table1">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">TGL KELUAR</th>
                <th width="15%">KODE TRANSAKSI</th>
                <th width="15%">KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th width="10%">QTY</th>
                <th>TUJUAN</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($data as $d)
            <tr>
                <td class="text-center">{{$no++}}</td>
                <td class="text-center">
                    {{-- Proteksi Carbon: Jika tanggal kosong, tampilkan strip --}}
                    {{ $d->bk_tanggal ? \Carbon\Carbon::parse($d->bk_tanggal)->translatedFormat('d F Y') : '-' }}
                </td>
                <td>{{$d->bk_kode}}</td>
                <td>{{$d->barang_kode}}</td>
                <td>{{$d->barang_nama}}</td>
                <td class="text-center">{{$d->bk_jumlah}}</td>
                <td>{{$d->bk_tujuan}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>