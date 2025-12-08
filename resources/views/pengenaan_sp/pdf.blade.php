<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Surat Peringatan</title>
        <style>
            body {
                font-family: Calibri, Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
            }

            .kop-container {
                width: 100%;
                border-bottom: 3px solid #000;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .kop-table {
                width: 100%;
            }

            .kop-table td {
                vertical-align: top;
            }

            .kop-title {
                text-align: center;
                font-weight: bold;
                font-size: 14px;
            }

            .kop-subtitle {
                text-align: center;
                font-size: 11px;
            }

            .title {
                text-align: center;
                font-size: 16px;
                margin-bottom: 10px;
                margin-top: 20px;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            td {
                padding: 5px;
                vertical-align: top;
            }
        </style>
    </head>

    <body>

        <!-- KOP SURAT -->
        <div class="kop-container">
            <table class="kop-table">
                <tr>
                    <td width="20%">
                        <img src="logo.png" width="90">
                    </td>
                    <td width="80%">
                        <div class="kop-title">KEMENTERIAN PERDAGANGAN</div>
                        <div class="kop-title">BADAN PENGAWAS PERDAGANGAN BERJANGKA KOMODITI</div>
                        <div class="kop-subtitle">
                            Gedung Utama Lantai 4 Kementerian Perdagangan<br>
                            Jalan M. I. Ridwan Rais No. 5 Jakarta 10110<br>
                            Tel. 021-23528400 Ext 39900 Fax. 021-2352 8690<br>
                            www.kemendag.go.id
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Bagian Kepada Yth -->
        <p>
            Kepada Yth:<br>
            1. Direktur Utama Pialang Berjangka Peserta Sistem Perdagangan Alternatif;<br>
            2. Direktur Utama Pialang Berjangka yang mengajukan permohonan persetujuan sebagai Pialang Berjangka Peserta
            Sistem Perdagangan Alternatif;<br>
            3. Direktur Utama Bursa Berjangka;<br>
            4. Ketua Aspebtindo.
        </p>

        <div class="title">SURAT PERINGATAN</div>

        <p><strong>No:</strong> {{ $sp->no_sp }}</p>

        <table>
            <tr>
                <td width="30%">Tanggal Mulai</td>
                <td>: {{ \Carbon\Carbon::parse($sp->tanggal_mulai)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Selesai</td>
                <td>: {{ \Carbon\Carbon::parse($sp->tanggal_selesai)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Pelaku Usaha</td>
                <td>: {{ $sp->pelaku_usaha->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Pelanggaran</td>
                <td>: {{ $sp->jenis_pelanggaran->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kategori SP</td>
                <td>: {{ $sp->kategori_sp->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Detail Pelanggaran</td>
                <td>: {{ $sp->detail_pelanggaran }}</td>
            </tr>
        </table>

        <br><br>
        <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

    </body>

</html>
