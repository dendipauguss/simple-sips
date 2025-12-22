<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Verifikasi Dokumen</title>

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                background: #f4f6f9;
                margin: 0;
                padding: 40px;
            }

            .card {
                max-width: 700px;
                margin: auto;
                background: #fff;
                border-radius: 6px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
                padding: 30px;
            }

            .status {
                text-align: center;
                margin-bottom: 25px;
            }

            .status .icon {
                font-size: 64px;
                color: #28a745;
            }

            .status.invalid .icon {
                color: #dc3545;
            }

            h1 {
                text-align: center;
                font-size: 22px;
                margin-bottom: 10px;
            }

            .subtitle {
                text-align: center;
                color: #666;
                font-size: 14px;
                margin-bottom: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            table td {
                padding: 8px 4px;
                vertical-align: top;
            }

            table td:first-child {
                width: 35%;
                font-weight: bold;
            }

            .badge {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: bold;
            }

            .badge-success {
                background: #28a745;
                color: #fff;
            }

            .badge-warning {
                background: #ffc107;
                color: #000;
            }

            .badge-danger {
                background: #dc3545;
                color: #fff;
            }

            .footer {
                margin-top: 30px;
                font-size: 12px;
                color: #777;
                text-align: center;
            }
        </style>
    </head>

    <body>

        <div class="card">

            <div class="status">
                <div class="icon">✔</div>
                <h1>DOKUMEN TERVERIFIKASI</h1>
                <div class="subtitle">
                    Tanda tangan digital dinyatakan <strong>SAH</strong>
                </div>
            </div>

            <table>
                <tr>
                    <td>Jenis Dokumen</td>
                    <td>Laporan Pengenaan Sanksi</td>
                </tr>

                <tr>
                    <td>Bulan / Tahun</td>
                    <td>
                        {{ \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->translatedFormat('F Y') }}
                    </td>
                </tr>

                <tr>
                    <td>Status Persetujuan</td>
                    <td>
                        @if ($laporan->status_persetujuan === 'setuju')
                            <span class="badge badge-success">DISETUJUI</span>
                        @elseif ($laporan->status_persetujuan === 'dikembalikan')
                            <span class="badge badge-danger">DIKEMBALIKAN</span>
                        @else
                            <span class="badge badge-warning">MENUNGGU</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>Disetujui Oleh</td>
                    <td>{{ $user->nama }}</td>
                </tr>

                <tr>
                    <td>Peran</td>
                    <td>{{ ucwords(str_replace('_', ' ', $decoded->role)) }}</td>
                </tr>

                <tr>
                    <td>Tanggal Persetujuan</td>
                    <td>
                        {{ \Carbon\Carbon::createFromTimestamp($decoded->iat)->translatedFormat('d F Y H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <td>Hash Verifikasi</td>
                    <td style="word-break: break-all;">
                        {{ $laporan->approval_hash }}
                    </td>
                </tr>
            </table>

            <hr>
            {{-- @if ($laporan->catatan)
                <strong>Catatan:</strong>
                <p>{{ $laporan->catatan }}</p>
            @endif --}}

            <div class="footer">
                Dokumen ini diverifikasi secara elektronik menggunakan<br>
                <strong>QR Code & JSON Web Token (JWT)</strong><br><br>
                <strong style="font-size: 12pt">Sistem Informasi Operasional Manajemen Pengenaan Sanksi</strong>
            </div>

        </div>

    </body>

</html>
