<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Surat Peringatan</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Libre+Barcode+39&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Russo+One&display=swap');

            body {
                font-family: "Open Sans", sans-serif;
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
                table-layout: fixed;
                /* <- penting supaya kolom tidak melebar */
                font-size: 10px;
                /* <- kecilkan sedikit */
                word-wrap: break-word;
                /* <- wrap konten */
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
                        <img src="img/kemendag-bappebti-logo.jpg" width="90">
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

        <div class="title">Laporan Pengenaan Sanksi
            {{ !empty($tahun) ? 'Tahun ' . \Carbon\Carbon::parse($tahun)->translatedFormat('Y') : '' }}</div>

        <table border="1" cellpadding="4" cellspacing="0" width="100%">
            <thead>
                <th>No. Surat</th>
                <th>Tanggal Surat</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Sanksi</th>
                <th>Perusahaan</th>
                <th>Jenis Pelaku Usaha</th>
                <th>Jenis Pelanggaran</th>
                <th>Kategori</th>
                <th>Detail Pelanggaran</th>
                <th>Tanggapan</th>
            </thead>
            <tbody>
                @foreach ($sp as $d)
                    <tr>
                        <td>{{ $d->no_surat }}</td>
                        <td>{{ $d->tanggal_mulai }}</td>
                        <td>{{ $d->tanggal_selesai }}</td>
                        <td>{{ $d->sanksi->nama }}</td>
                        <td>{{ $d->pelaku_usaha->nama }}</td>
                        <td>{{ $d->pelaku_usaha->jenis_pelaku_usaha->nama }}</td>
                        <td>{{ $d->jenis_pelanggaran->nama }}</td>
                        <td>{{ $d->kategori_sp->nama }}</td>
                        <td>{{ $d->detail_pelanggaran }}</td>
                        <td>{{ $d->tanggapan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br><br>
        <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

    </body>

</html>
