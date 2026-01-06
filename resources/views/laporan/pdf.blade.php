<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Laporan {{ $laporan->status_disetujui == 'setuju' ? 'Disetujui' : 'Belum Disetujui' }}</title>
        <style>
            /* @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Libre+Barcode+39&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Russo+One&display=swap'); */

            body {
                font-family: "Open Sans", sans-serif;
                font-size: 12px;
                line-height: 1.4;
            }

            .kop-container {
                width: 100%;
                /* border-bottom: 3px solid #000; */
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
                color: #1F3864;
            }

            .kop-subtitle {
                text-align: center;
                font-size: 11px;
                color: #1F3864;
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

            .kolom-nomor {
                display: flex;
                justify-content: center;
                text-align: center;
            }

            .kolom-nomor h3 {
                margin-bottom: none;
            }

            .tabel-word {
                border-collapse: collapse;
                width: 100%;
                /* Ubah ke 100% agar rapi */
                font-size: 9pt;
                table-layout: fixed;
                /* Penting agar kolom stabil */
                word-wrap: break-word;
            }

            .tabel-word td {
                border: 1px solid #fff;
                padding: 6px 8px;
                vertical-align: top;
                /* Pastikan teks selalu di atas */
            }

            .tabel-word th {
                border: 1px solid #fff;
                vertical-align: top;
                padding: 6px 8px;
                background-color: lightgray;
                text-align: center;
                font-weight: bold;
            }

            /* CLASS KHUSUS UNTUK FAKE ROWSPAN */
            .no-border-top {
                border-top: none !important;
            }

            /* Mencegah baris terpotong aneh (opsional) */
            tr {
                page-break-inside: avoid;
            }
        </style>
    </head>

    <body>

        <!-- KOP SURAT -->
        <div class="kop-container">
            <table class="kop-table">
                <tr align="center">
                    <td width="20%">
                        <img src="img/kop-logo-1.png" width="90">
                    </td>
                    <td width="80%">
                        <div class="kop-title" style="font-size: 13pt">KEMENTERIAN PERDAGANGAN</div>
                        <div class="kop-title" style="font-size: 11pt">BADAN PENGAWAS PERDAGANGAN BERJANGKA KOMODITI
                        </div>
                        <div class="kop-subtitle" style="font-size: 9pt">
                            Gedung Utama Lantai 4 Kementerian Perdagangan<br>
                            Jalan M. I. Ridwan Rais No. 5 Jakarta 10110<br>
                            Tel. 021-23528400 Ext 39900 Fax. 021-2352 8690<br>
                            www.kemendag.go.id
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="kolom-nomor" style="font-size: 11pt">
            <h3>NOTA DINAS</h3>
            <span>Nomor : {{ $nomor_laporan }}</span>
        </div>
        <!-- Bagian Kepada Yth -->
        <table style="font-size:11pt; line-height:1.2; border-collapse:collapse;">
            <tr>
                <td style="width:9%; padding:2px 0;">Yth</td>
                <td style="width:1%; padding:2px 0;">:</td>
                <td style="padding:2px 0;">Kepala Biro Pengawasan dan Penindakan PBK, SRG dan PLK</td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Dari</td>
                <td style="padding:2px 0;">:</td>
                <td style="padding:2px 0;">Ketua Tim Bidang Penindakan PBK, Pasar Fisik, SRG dan PLK serta Entitas PBK
                    Ilegal</td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Hal</td>
                <td style="padding:2px 0;">:</td>
                <td style="padding:2px 0;">
                    Laporan Monitoring Pengenaan Sanksi
                    @if ($laporan->bulan && $laporan->tahun)
                        {{ 'Periode Bulan ' . \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->translatedFormat('F Y') }}
                    @else
                        Semua Periode
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Tanggal</td>
                <td style="padding:2px 0;">:</td>
                <td style="padding:2px 0;">{{ $laporan->updated_at->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        {{-- <div class="title">Laporan Pengenaan Sanksi
            @if ($laporan->bulan && $laporan->tahun)
                {{ 'Periode Bulan ' . \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->translatedFormat('F Y') }}
            @else
                Semua Periode
            @endif
        </div> --}}
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

        <table border="1" cellpadding="4" cellspacing="0" class="tabel-word" align="center">
            <thead>
                <th style="width: 6%">No</th>
                <th>Nama Perusahaan</th>
                <th>Kategori Pelaku Usaha</th>
                <th>Bentuk Sanksi</th>
                <th>Pelanggaran</th>
                <th>Tanggapan</th>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @foreach ($items as $namaPerusahaan => $kategoriGroup)
                    @php
                        // Reset flag perusahaan setiap loop baru
                        $firstPerusahaan = true;
                    @endphp

                    @foreach ($kategoriGroup as $kategoriPU => $sanksiGroup)
                        @php
                            // Reset flag kategori
                            $firstKategori = true;
                        @endphp

                        @foreach ($sanksiGroup as $namaSanksi => $rows)
                            @php
                                // Reset flag sanksi
                                $firstSanksi = true;
                            @endphp

                            @foreach ($rows as $row)
                                <tr>
                                    {{-- 1. NO --}}
                                    {{-- Jika baris pertama perusahaan, cetak No. Jika tidak, kosong & hilangkan border atas --}}
                                    <td class="center {{ !$firstPerusahaan ? 'no-border-top' : '' }}">
                                        {{ $firstPerusahaan ? $no++ : '' }}
                                    </td>

                                    {{-- 2. NAMA PERUSAHAAN --}}
                                    <td class="{{ !$firstPerusahaan ? 'no-border-top' : '' }}">
                                        {{ $firstPerusahaan ? $namaPerusahaan : '' }}
                                    </td>

                                    {{-- 3. KATEGORI --}}
                                    {{-- Cek firstKategori (dan pastikan ini masih dalam blok perusahaan yg sama secara visual) --}}
                                    {{-- Logika: Jika ini baris pertama Kategori, cetak. Jika tidak, borderless. --}}
                                    {{-- Note: Karena loop nested, $firstKategori akan true tiap kali ganti kategori --}}
                                    <td class="{{ !$firstKategori ? 'no-border-top' : '' }}">
                                        {{ $firstKategori ? $kategoriPU : '' }}
                                    </td>

                                    {{-- 4. BENTUK SANKSI --}}
                                    <td class="{{ !$firstSanksi ? 'no-border-top' : '' }}">
                                        {{ $firstSanksi ? $namaSanksi : '' }}
                                    </td>

                                    {{-- 5. PELANGGARAN (Selalu tampil setiap baris) --}}
                                    <td>
                                        {{ $row->jenis_pelanggaran->nama }}
                                    </td>

                                    {{-- 6. TANGGAPAN (Selalu tampil setiap baris) --}}
                                    <td>
                                        {{ $row->status_surat == 'belum_ditanggapi' ? 'Belum Ditanggapi' : 'Sudah Ditanggapi' }}
                                    </td>
                                </tr>

                                @php
                                    // Matikan flag setelah baris pertama tercetak
                                    $firstPerusahaan = false;
                                    $firstKategori = false;
                                    $firstSanksi = false;
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

                {{-- PAKAI ROWSPAN SEMULA TETAPI JIKA SATU PERUSAHAAN SANKSI NYA LEBIH DARI SATU HALAMAN AKAN RUSAK --}}


                <!-- @foreach ($items as $namaPerusahaan => $kategoriGroup)
@php
    $rowspanPerusahaan = countDeep($kategoriGroup);
    $firstPerusahaan = true;
@endphp

                    @foreach ($kategoriGroup as $kategoriPU => $sanksiGroup)
@php
    $rowspanKategori = countDeep($sanksiGroup);
    $firstKategori = true;
@endphp

                        @foreach ($sanksiGroup as $namaSanksi => $rows)
@php
    $rowspanSanksi = count($rows);
    $firstSanksi = true;
@endphp

                            @foreach ($rows as $row)
<tr>

                                    {{-- NO --}}
                                    @if ($firstPerusahaan)
<td rowspan="{{ $rowspanPerusahaan }}" class="center">
                                            {{ $no++ }}
                                        </td>
@endif

                                    {{-- NAMA PERUSAHAAN --}}
                                    @if ($firstPerusahaan)
<td rowspan="{{ $rowspanPerusahaan }}">
                                            {{ $namaPerusahaan }}
                                        </td>
@endif

                                    {{-- KATEGORI --}}
                                    @if ($firstKategori && $firstSanksi)
<td rowspan="{{ $rowspanKategori }}">
                                            {{ $kategoriPU }}
                                        </td>
@endif

                                    {{-- BENTUK SANKSI --}}
                                    @if ($firstSanksi)
<td rowspan="{{ $rowspanSanksi }}">
                                            {{ $namaSanksi }}
                                        </td>
@endif

                                    {{-- PELANGGARAN --}}
                                    <td>{{ $row->jenis_pelanggaran->nama }}</td>

                                    {{-- TANGGAPAN --}}
                                    <td>
                                        {{ $row->status_surat == 'belum_ditanggapi' ? 'Belum Ditanggapi' : 'Sudah Ditanggapi' }}
                                    </td>

                                </tr>

                                @php
                                    $firstPerusahaan = false;
                                    $firstKategori = false;
                                    $firstSanksi = false;
                                @endphp
@endforeach
@endforeach
@endforeach
@endforeach -->
            </tbody>
        </table>

        <br><br>
        <table style="font-size:9pt; line-height:1.2; border-collapse:collapse;">
            <tr>
                <td style="width:17%; padding:2px 0;">Sudah Ditanggapi </td>
                <td style="width:2%; padding:2px 0;">=</td>
                <td style="padding:2px 0;"><strong>{{ $jumlah_status['sudah'] }}</strong></td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Belum Ditanggapi
                </td>
                <td style="padding:2px 0;">=</td>
                <td style="padding:2px 0;"><strong>{{ $jumlah_status['belum'] }}</strong></td>
            </tr>
            <tr>
                <td style="padding:2px 0;">Total
                </td>
                <td style="padding:2px 0;">=</td>
                <td style="padding:2px 0;">
                    <strong>{{ $jumlah_status['belum'] + $jumlah_status['sudah'] }}</strong>
                </td>
            </tr>
        </table>
        {{-- <ul class="no-bullets">
            <li>Sudah Ditanggapi = <strong>{{ $jumlah_status['belum'] }}</strong>,
                Belum Ditanggapi = <strong>{{ $jumlah_status['sudah'] }}</strong>,
                Total = <strong>{{ $jumlah_status['sudah'] + $jumlah_status['belum'] }}</strong>
            </li>
        </ul> --}}
        <br>
        <br>
        <br>

        <table width="100%" style="font-size:9pt;">
            <tr>
                {{-- TEMBUSAN (KIRI) --}}
                <td width="70%" style="vertical-align: bottom; justify-content: flex-start;">

                </td>

                {{-- TANDA TANGAN (KANAN) --}}
                <td width="25%" style="vertical-align: top; text-align: left;">
                    Ketua Tim Bidang Penindakan<br>
                    PBK, Pasar Fisik, SRG dan PLK<br>
                    serta Entitas PBK Ilegal,
                    <br>
                    @if ($laporan->status_persetujuan == 'setuju')
                        @if (!empty($qrBase64))
                            <div style="text-align:center; margin-top:20px;">
                                <img src="data:image/png;base64,{{ $qrBase64 }}" height="65">
                                <p style="font-size:10px; margin-top:5px;">
                                    Scan untuk verifikasi keaslian dokumen
                                </p>
                            </div>
                        @endif
                    @else
                        <br><br><br><br>
                    @endif
                    <br>
                    <div style="text-align: center;">
                        <strong><u>{{ $laporan->user->nama ?? 'Ketua Tim Belum Validasi' }}</u></strong><br>
                    </div>
                    NIP. 19xxxxxxxxxxxx
                </td>
            </tr>
        </table>
        <strong>Tembusan:</strong><br>
        Para Ketua Tim di lingkungan Biro Pengawasan dan Penindakan PBK, SRG dan PLK

        <br>
        <br>

    </body>

</html>
