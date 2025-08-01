<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran Kost</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 20px;
            padding: 0;
            background: #ffffff;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .kop {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kop .left {
            max-width: 50%;
        }

        .kop h2 {
            margin: 0;
            color: #007bff;
        }

        .kop p {
            margin: 3px 0;
            font-size: 13px;
        }

        .kop .right {
            text-align: right;
        }

        .kop .right h3 {
            margin: 0;
            color: #007bff;
        }

        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table.detail th,
        table.detail td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        table.detail th {
            background: #f4f4f4;
        }

        .total-area {
            margin-top: 20px;
            width: 100%;
            border-top: 2px solid #007bff;
            padding-top: 10px;
        }

        .total-area table {
            width: 300px;
        }

        .total-area td {
            padding: 6px 8px;
        }

        .bg-blue {
            background-color: #007bff;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .status-display {
            margin-top: 30px;
            text-align: right;
        }

        .status-display span {
            font-size: 30px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
        }

        .status-lunas span {
            background-color: #e6ffed;
            color: #28a745;
            border: 2px solid #28a745;
        }

        .status-proses span {
            background-color: #fff3cd;
            color: #ffc107;
            border: 2px solid #ffc107;
        }

        .status-belum span {
            background-color: #f8d7da;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        hr.dashed {
            border: none;
            border-top: 1px dashed #007bff;
            margin: 30px 0;
        }

        .recipient-box {
            background-color: #f1f9ff;
            padding: 15px 20px;
            border-left: 5px solid #007bff;
            margin-top: 25px;
            border-radius: 8px;
        }

        .recipient-box .label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .recipient-box .recipient-name {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 3px;
        }

        .recipient-box .recipient-contact {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="kop">
            <div class="left">
                <h2>KOST ARI</h2>
                <p>Jl. Kaliurang, Kab Sleman, Daerah Istimewa Yogyakarta</p>
                <p>Telp: 0878-3953-7706</p>
            </div>
            <div class="right">
                <h3>INVOICE #{{ $pembayaran->id }}</h3>
            </div>
        </div>

        <div class="recipient-box">
            <div class="label">Kepada:</div>
            <div class="recipient-name">{{ strtoupper($pembayaran->penghuni->nama) }}</div>
            <div class="recipient-contact">{{ $pembayaran->penghuni->no_hp }}</div>
        </div>

        <table class="detail">
            <thead>
                <tr>
                    <th>KAMAR</th>
                    <th>HARGA</th>
                    <th>SEWA</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ strtoupper($pembayaran->penghuni->kamar->nama_kamar) }}</td>
                    <td>Rp.{{ number_format($pembayaran->penghuni->kamar->harga, 0, ',', '.') }}</td>
                    <td>1 Bulan</td>
                    <td class="bg-blue">Rp.{{ number_format($pembayaran->penghuni->kamar->harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-area">
            <table>
                <tr>
                    <td>JUMLAH</td>
                    <td class="text-right">
                        Rp.{{ number_format($pembayaran->jumlah + $pembayaran->diskon, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td class="text-right">
                        Rp.{{ number_format($pembayaran->diskon, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td class="text-right">
                        <strong>Rp.{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </table>
        </div>
        @php
            $status = strtolower($pembayaran->status);
            $statusClass = $status === 'lunas' ? 'status-lunas' : ($status === 'proses' ? 'status-proses' : 'status-belum');
        @endphp

        <div class="status-display {{ $statusClass }}">
            <span>[ {{ ucfirst($status) }} ]</span>
        </div>

    </div>
</body>

</html>