<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN FASILITAS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            font-size: 12px
        }

        .laporan {
            border-collapse: collapse;
            margin-top: 20px;
        }

        .laporan th,
        .laporan td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .laporan th {
            background-color: #f2f2f2;
        }

        .laporan tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .laporan tr:hover {
            background-color: #ddd;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-sm-4 {
            flex: 0 0 37%;
            padding: 10px;
            box-sizing: border-box;
        }

        .col-sm-3 {
            flex: 0 0 25.5%;
            padding: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h2>LAPORAN SARANA & PRASARANA SEKOLAH</h2>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <table class="laporan">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center">FASILITAS</th>
                    </tr>
                    <tr>
                        <th style="width:1%">No</th>
                        <th>Fasilitas</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:20%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sapras = DB::table('fasilitas')->orderBy('fasilitas', 'ASC')->get();
                    @endphp
                    @foreach ($sapras as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strtoupper($l->fasilitas) }}</td>
                            <td>{{ number_format($l->jumlah) }}</td>
                            <td>{{ strtoupper($l->keterangan) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-4">
            <table class="laporan">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center">SARANA & PRASARANA</th>
                    </tr>
                    <tr>
                        <th style="width:1%">No</th>
                        <th>Jenis Sapras</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:10%">Baik</th>
                        <th style="width:10%">Rusak</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sapras = DB::table('sarana_prasarana')->orderBy('jenis_sapras', 'ASC')->get();
                    @endphp
                    @foreach ($sapras as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strtoupper($l->jenis_sapras) }}</td>
                            <td>{{ number_format($l->jumlah) }}</td>
                            <td>{{ number_format($l->baik) }}</td>
                            <td>{{ number_format($l->rusak) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-3">
            <table class="laporan">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center">PENGGUNAAN TANAH</th>
                    </tr>
                    <tr>
                        <th style="width:1%">No</th>
                        <th>Penggunaan Tanah</th>
                        <th>Luas Tanah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sapras = DB::table('tanah')->orderBy('penggunaan_tanah', 'ASC')->get();
                    @endphp
                    @foreach ($sapras as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strtoupper($l->penggunaan_tanah) }}</td>
                            <td>{{ strtoupper($l->luas_tanah) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
