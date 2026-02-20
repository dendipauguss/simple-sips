<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="generator" content="Hugo 0.87.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

        <title>Laporan {{ $laporan->status_persetujuan == 'setuju' ? 'Disetujui' : ($laporan->status_persetujuan == 'dikembalikan' ? 'Dikembalikan' : 'Dipending') }}
        </title>

        <link rel="shortcut icon" href="/img/kemendag-bappebti-logo.ico" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap"
            rel="stylesheet">

        <style>            

            body {
                font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
                font-size: 12px;
                line-height: 1.4;
            }

            /* .kop-container {
                width: 100%;
                border-bottom: 3px solid #000;
                padding-bottom: 10px;
                margin-bottom: 20px;
            } */

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
                padding: 4px;
                vertical-align: top;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            .no-bullets {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .kolom-nomor {
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: center;
                align-items: center;
                margin: 15px 0;
            }

            .kolom-nomor h3 {
                margin: 0;
                padding: 0;
            }

            .kolom-nomor span {
                margin: 0;
                padding: 0;
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
            /* tr {
                page-break-inside: avoid;
            } */

            @page {
                margin: 0.5cm 0.5cm 1cm 0.5cm;
            }
        </style>
    </head>

    <body>

        <!-- KOP SURAT -->
        <div class="kop-container">
            <table class="kop-table">
                <tr align="center">
                    <td width="20%">
                        <img src="{{ public_path('img/kop-logo-1.png') }}" width="90">
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
                <td style="padding:2px 0;">Ketua Tim Bidang Penindakan PBK, Pasar Fisik, SRG dan PLK</td>
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
            <thead style="font-size: 8pt">
                <th style="width: 6%">No</th>
                <th style="width: 18%">Nama Perusahaan</th>
                <th>Kategori Pelaku Usaha</th>
                <th>Periode (MMMM yyyy)</th>
                <th>Bentuk Sanksi</th>
                <th>Pelanggaran</th>
                <th>Tanggapan</th>
                <th>Tanggal Jatuh Tempo</th>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @foreach ($items as $namaPerusahaan => $kategoriGroup)
                    @php $firstPerusahaan = true; @endphp

                    @foreach ($kategoriGroup as $kategoriPU => $periodeGroup)
                        @php $firstKategori = true; @endphp

                        @foreach ($periodeGroup as $periode => $rows)
                            @php
                                $firstPeriode = true;
                                $noSanksi = 1; // ⬅️ reset per periode
                            @endphp

                            @foreach ($rows as $sp)
                                <tr>
                                    {{-- NO --}}
                                    <td class="center {{ !$firstPerusahaan ? 'no-border-top' : '' }}">
                                        {{ $firstPerusahaan ? $no++ : '' }}
                                    </td>

                                    {{-- NAMA PERUSAHAAN --}}
                                    <td class="{{ !$firstPerusahaan ? 'no-border-top' : '' }}">
                                        {{-- {{ $firstPerusahaan ? $namaPerusahaan : '' }} --}}
                                        @if ($firstPerusahaan)
                                            <strong>{{ $namaPerusahaan }}</strong>

                                            <div style="font-size:11px; margin-top:6px;">
                                                <div>Sudah Ditanggapi =
                                                    {{ $rekap_perusahaan[$namaPerusahaan]['sudah'] }}
                                                </div>
                                                <div>Belum Ditanggapi =
                                                    {{ $rekap_perusahaan[$namaPerusahaan]['belum'] }}
                                                </div>
                                                <div><strong>Total =
                                                        {{ $rekap_perusahaan[$namaPerusahaan]['total'] }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td class="{{ !$firstKategori ? 'no-border-top' : '' }}">
                                        <strong>{{ $firstKategori ? $kategoriPU : '' }}</strong>
                                    </td>

                                    {{-- PERIODE --}}
                                    <td class="{{ !$firstPeriode ? 'no-border-top' : '' }}">
                                        {{ $firstPeriode ? \Carbon\Carbon::createFromFormat('Y-m', $periode)->translatedFormat('F Y') : '' }}
                                    </td>

                                    {{-- BENTUK SANKSI (GABUNG SEMUA) --}}
                                    <td>

                                        @if ($sp->eskalasi_aktif)
                                            {{ $sp->eskalasi_aktif->sanksi->nama }}

                                            @if ($sp->eskalasi_aktif->sanksi->kode_surat === 'SP')
                                                {{ $sp->eskalasi_aktif->level }}
                                            @endif

                                            @if ($sp->eskalasi_aktif->is_denda)
                                                <br>
                                                <small class="text-danger">
                                                    Denda: Rp
                                                    {{ number_format($sp->eskalasi_aktif->nominal_denda, 0, ',', '.') }}
                                                </small>
                                            @endif
                                        @else
                                            -
                                        @endif

                                    </td>

                                    {{-- PELANGGARAN --}}
                                    <td>
                                        {{ $sp->jenis_pelanggaran->nama }}
                                    </td>

                                    {{-- TANGGAPAN --}}
                                    <td>
                                        @if ($sp->status_surat == 'belum_ditanggapi')
                                            Belum Ditanggapi
                                        @elseif($sp->status_surat == 'sudah_ditanggapi')
                                            Sudah Ditanggapi
                                        @else
                                            Pending
                                        @endif
                                    </td>

                                    {{-- TANGGAL JATUH TEMPO --}}
                                    <td>
                                        {{ \Carbon\Carbon::parse($sp->tanggal_selesai)->translatedFormat('l, d F Y') }}
                                    </td>
                                </tr>

                                @php
                                    $firstPerusahaan = false;
                                    $firstKategori = false;
                                    $firstPeriode = false;
                                    $noSanksi++;
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

                {{-- PAKAI ROWSPAN SEMULA TETAPI JIKA SATU PERUSAHAAN SANKSI NYA LEBIH DARI SATU HALAMAN AKAN RUSAK --}}


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
                <td style="padding:2px 0;">Pending
                </td>
                <td style="padding:2px 0;">=</td>
                <td style="padding:2px 0;"><strong>{{ $jumlah_status['pending'] }}</strong></td>
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
                    <strong>{{ $jumlah_status['belum'] + $jumlah_status['pending'] + $jumlah_status['sudah'] }}</strong>
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
                    PBK, SRG dan PLK<br>
                    <br>
                    @if ($laporan->status_persetujuan == 'pending')
                        <br><br><br><br>
                    @else
                        @if (!empty($qrBase64))
                            <div style="text-align:center; margin-top:20px;">
                                <img src="data:image/png;base64,{{ $qrBase64 }}" height="65">
                                <p style="font-size:10px; margin-top:5px;">
                                    Scan untuk verifikasi keaslian dokumen
                                </p>
                            </div>
                        @endif
                    @endif
                    <br>
                    <div style="text-align: center;">
                        <strong><u>{{ $laporan->user->nama ?? 'Ketua Tim Belum Validasi' }}</u></strong><br>
                    </div>
                    {{-- NIP. 19xxxxxxxxxxxx --}}
                </td>
            </tr>
        </table>
        <strong>Tembusan:</strong><br>
        Para Ketua Tim di lingkungan Biro Pengawasan dan Penindakan PBK, SRG dan PLK

        <br>
        <br>

    </body>

</html>
