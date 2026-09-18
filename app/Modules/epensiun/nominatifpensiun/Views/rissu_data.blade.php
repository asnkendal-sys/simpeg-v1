<?php
    $n  = 0;
    $rs = \BiodataModel::getRissu($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->nmissu!!}</td>
            <td align="center">{!!$item->tmlhr!!}, {!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgnikah))!!}</td>
            <td align="center">{!!$n!!}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7">Data tidak ditemukan, Mohon cek riwayat suami / istri pada E-Personal</td>
    </tr>
@endif
