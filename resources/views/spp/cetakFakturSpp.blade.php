<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info span {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>KWITANSI PEMBAYARAN SPP</h2>
        </div>
        <div class="info">
            <p><span>Nomor Kwitansi:</span> KW012345</p>
            <p><span>Tanggal Pembayaran:</span> 12 Desember 2023</p>
            <p><span>Nama Siswa:</span> John Doe</p>
            <p><span>Kelas:</span> XII - A</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>SPP Bulan November 2023</td>
                    <td>Rp 500.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Denda Keterlambatan</td>
                    <td>Rp 50.000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total Pembayaran:</strong></td>
                    <td><strong>Rp 550.000</strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="footer">
            <p>Terima kasih atas pembayaran yang telah dilakukan.</p>
        </div>
    </div>
</body>

</html>
