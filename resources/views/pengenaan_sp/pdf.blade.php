<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Surat Peringatan</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }

            .title {
                text-align: center;
                font-size: 16px;
                margin-bottom: 20px;
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

        <div class="title"><strong>SURAT PERINGATAN</strong></div>

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
