<h3>Laporan Penindakan</h3>

<table border="1" cellpadding="4" cellspacing="0" width="100%">
    <tr>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Perusahaan</th>
        <th>Sanksi</th>
    </tr>
    @foreach ($data as $d)
        <tr>
            <td>{{ $d->tanggal_mulai }}</td>
            <td>{{ $d->tanggal_selesai }}</td>
            <td>{{ $d->perusahaan->nama }}</td>
            <td>{{ $d->sanksi->nama }}</td>
        </tr>
    @endforeach
</table>
