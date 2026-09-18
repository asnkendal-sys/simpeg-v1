<?php
$n = 0;
$rs = BiodataModel::getRcuti($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->nousul!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgl_usul))!!}</td>
            <td>{!!$item->nosurat!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->tgsurat))!!}</td>
            <td>{!!$item->jenis_cuti!!}</td>
            <td>{!!$item->ket!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->tgmul))!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->tgsel))!!}</td>
            <td>{!!$item->jmlhari!!} Hari</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="11">Riwayat Cuti belum tersedia.</td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
    });
</script>