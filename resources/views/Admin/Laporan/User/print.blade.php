<!DOCTYPE html>
<html lang="en">

<?php
use Carbon\Carbon;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$web->web_deskripsi ?? ''}}">
    <meta name="author" content="{{$web->web_nama ?? ''}}">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FAVICON -->
    @if(isset($web) && ($web->web_logo == '' || $web->web_logo == 'default.png'))
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/assets/default/web/default.png')}}" />
    @elseif(isset($web))
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('storage/web/' . $web->web_logo)}}" />
    @endif
    
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
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table1 th {
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
        }

        #table1 td {
            font-size: 11px;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-bold {
            font-weight: 600;
        }

        .d-2 {
            display: flex;
            align-items: flex-start;
            margin-top: 32px;
        }
    </style>

</head>

<body onload="window.print()">

    <center>
        @if(isset($web) && ($web->web_logo == '' || $web->web_logo == 'default.png'))
        <img src="{{url('/assets/default/web/default.png')}}" width="80px" alt="">
        @elseif(isset($web))
        <img src="{{asset('storage/web/' . $web->web_logo)}}" width="80px" alt="">
        @endif
    </center>

    <center>
        <h1 class="font-medium">Laporan Data User</h1>
        @if($tglawal == '')
        <h4 class="font-medium">Semua Data</h4>
        @else
        <h4 class="font-medium">{{Carbon::parse($tglawal)->translatedFormat('d F Y')}} - {{Carbon::parse($tglakhir)->translatedFormat('d F Y')}}</h4>
        @endif
    </center>

    <table border="1" id="table1">
        <thead>
            <tr>
                <th align="center" width="1%">NO</th>
                <th>FOTO</th>
                <th>NAMA LENGKAP</th>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>ROLE</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($data as $d)
            <tr>
                <td align="center">{{$no++}}</td>
                <td align="center">
                    @if($d->user_foto == '' || $d->user_foto == 'undraw_profile.svg')
                        {{-- Sesuaikan path default image Anda --}}
                        <img src="{{ url('/assets/img/undraw_profile.svg') }}" width="40px" style="border-radius: 50%">
                    @else
                        <img src="{{ asset('storage/users/' . $d->user_foto) }}" width="40px" style="border-radius: 50%">
                    @endif
                </td>
                <td>{{$d->user_nmlengkap}}</td>
                <td>{{$d->user_nama}}</td>
                <td>{{$d->user_email}}</td>
                <td align="center">{{$d->role_title}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>