@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">Data User</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Filter & Data</h3>
                </div>
                <div class="card-body">

                    {{-- Form Filter --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="" class="fw-bold">Opsi Laporan</label>
                        </div>

                        {{-- Note: Input tanggal ini dikirim ke Controller, tapi logic filter query
                         harus disesuaikan di controller jika ingin memfilter berdasarkan created_at --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" name="tglawal" class="form-control" placeholder="Tanggal Awal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" name="tglakhir" class="form-control" placeholder="Tanggal Akhir">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <button class="btn btn-primary-light" onclick="filter()"><i class="fe fe-filter"></i>
                                Filter</button>
                            <button class="btn btn-secondary-light" onclick="reset()"><i class="fe fe-refresh-ccw"></i>
                                Reset</button>
                            <button class="btn btn-success-light" onclick="printWindow()"><i class="fe fe-printer"></i>
                                Print</button>
                            <button class="btn btn-danger-light" onclick="pdfWindow()"><i class="fa fa-file-pdf-o"></i>
                                PDF</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom dataTable no-footer">
                            <thead>
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0">Foto</th>
                                <th class="border-bottom-0">Nama Lengkap</th>
                                <th class="border-bottom-0">Username</th>
                                <th class="border-bottom-0">Role</th>
                                <th class="border-bottom-0">Status</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table;
        $(document).ready(function() {
            getData();
        });

        function getData() {
            table = $('#table-1').DataTable({
                "processing": true,
                "serverSide": true,
                "info": true,
                "order": [],
                "scrollX": true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                "ajax": {
                    "url": "{{ route('lap-user.show') }}", // Pastikan route ini ada
                    "data": function(d) {
                        d.tglawal = $('input[name="tglawal"]').val();
                        d.tglakhir = $('input[name="tglakhir"]').val();
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'img',
                        name: 'user_foto',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_nmlengkap',
                        name: 'user_nmlengkap'
                    },
                    {
                        data: 'user_nama',
                        name: 'user_nama'
                    },
                    {
                        data: 'role',
                        name: 'role_title'
                    },
                    {
                        data: 'status_akun',
                        name: 'updated_at'
                    },
                ]
            });
        }

        function filter() {
            table.ajax.reload(null, false);
        }

        function reset() {
            $('input[name="tglawal"]').val('');
            $('input[name="tglakhir"]').val('');
            table.ajax.reload(null, false);
        }

        function printWindow() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            window.open("{{ route('lap-user.print') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir, '_blank');
        }

        function pdfWindow() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            window.open("{{ route('lap-user.pdf') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir, '_blank');
        }
    </script>
@endsection
