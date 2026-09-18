<?php
    /*diisi query menampilkan data dari sapk bkn*/
    $n = 0;
    $rs = BiodataModel::getRskp($nip);

    function getNilai($nilai)
    {
        $nhuruf = '';
        if (($nilai >= 91) and ($nilai <= 100)) {
            $nhuruf = 'Sangat baik';
        } else if (($nilai >= 76) and ($nilai <= 90)) {
            $nhuruf = 'Baik';
        } else if (($nilai >= 61) and ($nilai <= 75)) {
            $nhuruf = 'Cukup';
        } else if (($nilai >= 51) and ($nilai <= 60)) {
            $nhuruf = 'Kurang';
        } else if ($nilai < 50) {
            $nhuruf = 'Buruk';
        }

        return $nhuruf;
    }
?>

@if(count($rs->get()) > 0)
@foreach($rs->get() as $item)
<?php $n++;?>
<tr>
    <td align="center">{!!$n!!}.</td>
    <td>{!!$item->nilai." (".getNilai($item->nilai).")"!!}</td>
    <td>{!!$item->tahun!!}</td>
    <td>{!!$item->pejpenilai!!}</td>
    <td>{!!$item->jabpenilai!!}</td>
    <td class="text-center">
        @if($item->idskpbkn==1)
        -
        @else
        <a class="text-info actsinkronbkn btn btn-success xconfirm" recid="16214" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="8">Riwayat Penilaian Prilaku Kerja Pegawai BKN belum tersedia.</td>
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