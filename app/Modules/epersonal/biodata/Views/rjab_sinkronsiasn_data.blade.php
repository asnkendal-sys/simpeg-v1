<?php
    /*diisi query menampilkan data dari sapk bkn*/
    $x = 0;
    $bkn = accessDatariwayatsiasn('pns/rw-jabatan',$nip);
    /*echo "<pre>";
        print_r($bkn);
    echo "</pre>";
    exit();*/
?>

@if(count($bkn) > 0)
@foreach($bkn as $item)
<?php
$x++;
$field = getNamajabatanbkn($item->jenisJabatan);
$namajabatan = $item->$field;
?>
<tr>
    <td align="center">{!!$x!!}</td>
    <td>{!!getJenisjabatanbkn($item->jenisJabatan)!!}</td>
    <td>{!!$namajabatan!!}</td>
    <td>{!!$item->nomorSk!!}</td>
    <td align="center">{!!$item->tanggalSk!!}</td>
    <td align="center">{!!date('d-m-Y', strtotime($item->tmtJabatan))!!}</td>
    <td>{!!$item->unorNama!!} {!!$item->unorIndukNama!!}</td>
    <td class="text-center">
        @if(cekBkn($item->id, 'r_jab'))
        <i class="fa fa-check-square-o" title="Sudah Tersinkronisasi"></i>
        @else
        <a class="text-info actsinkronsiasn btn btn-warning syncomsiasn" recid="x" idbkn="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="9">Riwayat Jabatan Pegawai SIASN belum tersedia.</td>
</tr>
@endif

<style type="text/css">
        /*.modal {
            overflow: auto !important;
        }*/

        /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 80vh;
        overflow-y: auto;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('.syncomsiasn').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var idjabbkn = $(this).attr('idbkn');
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idjabbkn': idjabbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
    })
</script>