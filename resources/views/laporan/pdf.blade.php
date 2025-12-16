<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Laporan {{ $laporan->status_disetujui == 1 ? 'Disetujui' : 'Belum Disetujui' }}</title>
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

            table th,
            table td {
                padding: 5px;
                vertical-align: top;
            }

            .no-bullets {
                list-style-type: none;
                padding: 0;
                margin: 0;
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
            @if ($laporan->bulan && $laporan->tahun)
                {{ 'Bulan ' . \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->translatedFormat('F Y') }}
            @else
                Semua Periode
            @endif
        </div>
        @php
            function countDeep($data)
            {
                $count = 0;

                foreach ($data as $item) {
                    if (is_array($item) || $item instanceof \Illuminate\Support\Collection) {
                        $count += countDeep($item);
                    } else {
                        $count++;
                    }
                }

                return $count;
            }
        @endphp

        <table border="1" cellpadding="4" cellspacing="0" width="100%">
            <thead>
                <th style="width: 5%">No</th>
                <th>Kategori Pelaku Usaha</th>
                <th>Nama Perusahaan</th>
                <th>Bentuk Sanksi</th>
                <th>Pelanggaran</th>
                <th>Tanggapan</th>
            </thead>
            <tbody>
                @php $no =1; @endphp
                @foreach ($items as $jenisPU => $pelakuGroup)
                    @php
                        $rowspan_1 = countDeep($pelakuGroup);
                        $i1 = 0;
                    @endphp

                    @foreach ($pelakuGroup as $pelakuNama => $sanksiGroup)
                        @php
                            $rowspan_2 = countDeep($sanksiGroup);
                            $i2 = 0;
                        @endphp

                        @foreach ($sanksiGroup as $sanksiNama => $rowItems)
                            @php
                                $rowspan_3 = count($rowItems);
                                $i3 = 0;
                            @endphp

                            @foreach ($rowItems as $item)
                                <tr>
                                    {{-- NOMOR --}}
                                    <td align="center">{{ $no++ }}</td>

                                    {{-- LEVEL 1 --}}
                                    @if ($i2 == 0 && $i3 == 0)
                                        <td rowspan="{{ $rowspan_2 }}">{{ $pelakuNama }}</td>
                                    @endif

                                    {{-- LEVEL 2 --}}
                                    @if ($i1 == 0 && $i2 == 0 && $i3 == 0)
                                        <td rowspan="{{ $rowspan_1 }}" align="center">{{ $jenisPU }}</td>
                                    @endif

                                    {{-- LEVEL 3 --}}
                                    @if ($i3 == 0)
                                        <td rowspan="{{ $rowspan_3 }}" align="center">{{ $sanksiNama }}</td>
                                    @endif

                                    {{-- LEVEL 4 --}}
                                    <td align="center">{{ $item->jenis_pelanggaran->nama }}</td>

                                    {{-- LEVEL 5 --}}
                                    <td align="center">{{ ucwords(str_replace('_', ' ', $item->status_surat)) }}</td>

                                </tr>
                                @php $i3++; @endphp
                            @endforeach

                            @php $i2++; @endphp
                        @endforeach

                        @php $i1++; @endphp
                    @endforeach
                @endforeach

            </tbody>
        </table>

        <br><br>
        <ul class="no-bullets">
            <li>Sudah Ditanggapi = <strong>{{ $jumlah_status['sudah'] }}</strong>, Belum Ditanggapi =
                <strong>{{ $jumlah_status['belum'] }}</strong></li>
        </ul>

        <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>


        <br>
        <br><br>
        <strong
            style="text-align: center">{{ $laporan->status_disetujui == 1 ? 'Disetujui' : 'Belum Disetujui' }}</strong>
        <br>
        <strong>Catatan : </strong>
        <br>
        <p>{{ $laporan->catatan }}</p>
    </body>

</html>
