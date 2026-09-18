<?php
    /*diisi query menampilkan data dari sapk bkn*/
    $n = 0;
    $rs = BiodataModel::getRjab($nip);
    $cek = \DB::table('tb_01 as a')->select('a.idjenjab', 'b.isguru')->leftjoin('a_jabfung as b', 'a.idjabfung', '=', 'b.idjabfung')->where('nip', $nip)->first();

    if ($cek->idjenjab == 1) {
        $c = ($c + 1);
        $d = ($d + 1);
    }

    if ($cek->isguru == 1) {
        $c = ($c + 2);
        $d = ($d + 2);
    } elseif ($cek->isguru == 2) {
        $c = ($c + 1);
        $d = ($d + 1);
    }

    if ($cek->idjenjab == 2) {
        $c = ($c + 1);
        $d = ($d + 1);
    }
?>

@if(count($rs->get()) > 0)
@foreach($rs->get() as $item)
<?php $n++;?>
<tr>
    <td align="center">{!!$n!!}</td>
    <td>{!!$item->jab!!}</td>
    @if($cek->idjenjab == 1)
        <td>{!!$item->esl!!}</td>
    @endif
    <td>{!!$item->nosk!!}</td>
    <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
    <td align="center">{!!date('d-m-Y', strtotime($item->tmtjab))!!}</td>
    @if($cek->isguru == 1)
        <td>{!!$item->tugasgurudosen!!}</td>
        <td>{!!$item->matkulpel!!}</td>
    @elseif($cek->isguru == 2)
        <td>{!!$item->tugasdokter!!}</td>
    @endif
    @if($cek->idjenjab == 2)
        <td>{!!($item->nopak=='')?'':$item->nopak!!}</td>
    @endif
    <td>{!!$item->skpd!!}</td>
    <td class="text-center">
        @if($item->idjabbkn==1)
        -
        @else
        <a class="text-info actsinkronbkn btn btn-success xconfirm" recid="16214" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="9">Riwayat Jabatan Pegawai BKN belum tersedia.</td>
</tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $("a.xconfirm").click(function(e) {
            e.preventDefault();
            bootbox.confirm("Sinkronisasi data BKN ?", function(confirmed) {
                notification('Data Berhasil Tersinkronisasi.','success');
                claravel_modal_close('main_modal2');
            });
        });
    })
</script>