<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembayaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Riwayat Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatPembayaran as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->translatedFormat('F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>