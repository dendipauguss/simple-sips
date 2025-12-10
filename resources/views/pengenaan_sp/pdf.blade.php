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
                <th>Kategori Pelaku Usaha</th>
                <th>Nama Perusahaan</th>
                <th>Bentuk Sanksi</th>
                <th>Pelanggaran</th>
                <th>Tanggapan</th>
            </thead>
            <tbody>
                @foreach ($grouped as $jenis => $pelakuGroup)
                    @php
                        $rowspanJenis = $pelakuGroup->flatten()->count();
                        $jenisNama = $pelakuGroup->first()->first()->first()->pelaku_usaha->jenis_pelaku_usaha->nama;
                        $firstJenisRendered = false;
                    @endphp

                    @foreach ($pelakuGroup as $pelakuId => $sanksiGroup)
                        @php
                            $rowspanPelaku = $sanksiGroup->flatten()->count();
                            $pelakuNama = $sanksiGroup->first()->first()->pelaku_usaha->nama;
                            $firstPelakuRendered = false;
                        @endphp

                        @foreach ($sanksiGroup as $sanksiId => $items)
                            @php
                                $rowspanSanksi = count($items);
                                $sanksiNama = $items->first()->sanksi->nama;
                                $firstSanksiRendered = false;
                            @endphp

                            @foreach ($items as $item)
                                <tr>

                                    {{-- LEVEL 1: JENIS PELAKU USAHA --}}
                                    @if (!$firstJenisRendered)
                                        <td rowspan="{{ $rowspanJenis }}">
                                            {{ $jenisNama }}
                                        </td>
                                        @php $firstJenisRendered = true; @endphp
                                    @endif

                                    {{-- LEVEL 2: PELAKU USAHA --}}
                                    @if (!$firstPelakuRendered)
                                        <td rowspan="{{ $rowspanPelaku }}">
                                            {{ $pelakuNama }}
                                        </td>
                                        @php $firstPelakuRendered = true; @endphp
                                    @endif

                                    {{-- LEVEL 3: BENTUK SANKSI --}}
                                    @if (!$firstSanksiRendered)
                                        <td rowspan="{{ $rowspanSanksi }}">
                                            {{ $sanksiNama }}
                                        </td>
                                        @php $firstSanksiRendered = true; @endphp
                                    @endif

                                    {{-- LEVEL 4: JENIS PELANGGARAN --}}
                                    <td>{{ $item->jenis_pelanggaran->nama }}</td>

                                    {{-- LEVEL 5: STATUS --}}
                                    <td>{{ ucwords(str_replace('_', ' ', $item->status_surat)) }}</td>

                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <br><br>
        <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

    </body>

</html>
