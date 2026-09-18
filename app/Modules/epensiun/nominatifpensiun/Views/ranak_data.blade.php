<?php
    $n  = 0;
    $rs = \BiodataModel::getRanak($nip);
    $rs->where('tunjangan','1')->whereRaw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(r_anak.tglhr)), '%Y%m')+0  < 2500 AND r_anak.stskawin = 1 AND r_anak.peker IN ('mahasiswa','-') ");

?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->nmanak!!}</td>
            <td>{!!$item->tmlhr!!}, {!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
            <td align="center">{!!$item->stskeluarga!!}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10">Data tidak ditemukan, Anak Tidak Dapat Tunjangan atau Mohon cek riwayat anak pada E-Personal.</td>
    </tr>
@endif