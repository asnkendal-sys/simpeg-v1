<?php
    use App\Models\SinkronisasiModel;
    $siasn = new SinkronisasiModel();
    /*diisi query menampilkan data dari sapk SIASN*/
    $x = 0;
    $bkn = accessDatariwayatsiasn('pns/rw-skp',$nip);

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

@if(count($bkn) > 0)
@foreach($bkn as $item)
<?php $x++;?>
<tr>
    <td align="center">{!!$x!!}.</td>
    <td>{!!$item->nilaiSkp." (".getNilai($item->nilaiSkp).")"!!}</td>
    <td>{!!$item->tahun!!}</td>
    <td>{!!$item->penilaiNama!!}</td>
    <td>{!!$item->penilaiJabatan!!}</td>
    <td class="text-center">
        @if(cekBkn($item->id, 'r_skp'))
            <i class="fa fa-check-square-o" title="Sudah Tersinkronisasi"></i> Sudah Sinkron
        @else
            <a class="text-info actsinkronsiasn btn btn-warning syncomsiasn" recid="x" idbkn="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="8">Riwayat Penilaian Prilaku Kerja Pegawai SIASN belum tersedia.</td>
</tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.syncomsiasn').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var idskpbkn = $(this).attr('idbkn');
            /*bootbox.confirm("Sinkronisasi data SIASN ?", function(confirmed) {*/
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
            /*});*/
        });
    })
</script>