<?php

if (!function_exists('formatHariKeBulan')) {
    function formatHariKeBulan($hari)
    {
        $hari = abs($hari);
        $bulan = intdiv($hari, 30);
        $sisaHari = $hari % 30;

        if ($bulan > 0 && $sisaHari > 0) {
            return "{$bulan} bulan {$sisaHari} hari";
        } elseif ($bulan > 0) {
            return "{$bulan} bulan";
        }

        return "{$hari} hari";
    }
}
