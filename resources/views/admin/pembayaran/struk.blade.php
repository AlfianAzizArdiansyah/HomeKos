<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Tagihan Pembayaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .struk-container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border: 1px solid #ccc;
            background: #fff;
        }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }

        .kop p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
        }

        .kop hr {
            margin-top: 10px;
            border: 0;
            border-top: 2px solid #666;
        }

        .judul {
            text-align: center;
            margin: 30px 0 20px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            color: #333;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            padding: 10px 8px;
            text-align: left;
        }

        .details th {
            width: 40%;
            color: #555;
        }

        .status-box {
            margin-top: 20px;
            padding: 12px 16px;
            background-color: #eee;
            border-left: 5px solid #bbb;
            font-weight: bold;
            color: #333;
            border-radius: 4px;
        }

        .status-box.lunas {
            background-color: #e7f7ec;
            border-left-color: #4caf50;
            color: #2e7d32;
        }

        .status-box.belum {
            background-color: #fdeaea;
            border-left-color: #e53935;
            color: #b71c1c;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #555;
        }

        .footer p {
            margin: 4px 0;
        }

        .note {
            font-style: italic;
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="struk-container">
        <!-- KOP -->
        <div class="kop">
            <h1>KOST ARI</h1>
            <p>Jl. Kaliurang, Kab Sleman, Daerah Istimewa Yogyakarta</p>
            <p>
                <center>Telp: 0857-1234-5678</center>
            </p>
            <hr>
        </div>

        <!-- Judul -->
        <div class="judul">Struk Pembayaran Kost Bulanan</div>

        <!-- Detail Pembayaran -->
        <div class="details">
            <table>
                <tr>
                    <th>Nama Penghuni</th>
                    <td>: {{ $pembayaran->penghuni->nama }}</td>
                </tr>
                <tr>
                    <th>Kamar</th>
                    <td>: {{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Tagihan</th>
                    <td>: Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Jatuh Tempo</th>
                    <td>: {{ \Carbon\Carbon::parse($pembayaran->jatuh_tempo)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td>: {{ ucfirst($pembayaran->status) }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>:
                        {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') : '-' }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Status Box -->
        <div class="status-box {{ strtolower($pembayaran->status) === 'lunas' ? 'lunas' : 'belum' }}">
            Status Saat Ini: {{ strtoupper($pembayaran->status) }}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Yogyakarta, {{ now()->format('d M Y') }}</p>
            <p>Admin Kost</p>
            <br><br><br>
            <p><strong>__________________________</strong></p>
        </div>

        <!-- Note -->
        <div class="note">
            Struk ini dicetak otomatis oleh sistem dan tidak memerlukan tanda tangan basah.
        </div>
    </div>
</body>

</html>