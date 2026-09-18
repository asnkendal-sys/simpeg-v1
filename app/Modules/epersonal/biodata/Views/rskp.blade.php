<?php
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
            <td class="text-center">{!!(($item->idskpbkn!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td class="text-center">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <!--<li><a class="text-danger sinkronbkn" recid="{!!$item->id!!}" recidskpbkn="{!!$item->idskpbkn!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai BKN</a></li>-->
                        <!--<li><a class="text-danger sinkronsiasn" recid="{!!$item->id!!}" idbkn="{!!$item->idskpbkn!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai SIASN</a></li>-->
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" ident="{!!$item->tahun!!}" jns="PPK {!!$item->nilai.' ('.getNilai($item->nilai).')'!!} Tahun {!!$item->tahun!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Riwayat Penilaian Prilaku Kerja Pegawai belum tersedia.</td>
    </tr>
@endif

<tr>
    <td colspan="8">
        <!--<a class="text-info prevsinkronbkn btn btn-success" recid="" recidskpbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data BKN</a>-->
        <!--<a class="text-info prevsinkronsiasn btn btn-success" recid="" idbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data SIASN</a>-->
    </td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rskp a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat SKP','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            var ident = $(this).attr('ident');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{!!$nip!!}', 'jenis': 15, 'subjenis': id, 'nama_jenis':nama_jenis,'ident': ident, 'tb': 'r_skp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rskp a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Sasaran Kinerja Pegawai','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rskp_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rskp a.sinkronbkn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai BKN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idskpbkn = $(this).attr('recidskpbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rskp_sinkronbkn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rskp a.prevsinkronbkn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Data PPK BKN','Loading...','main_modal2');
            var id = '';
            var idskpbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rskp_sinkronbkn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rskp a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_skp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRskp();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rskp a.sinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idskpbkn = $(this).attr('idbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rskp a.prevsinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Data PPK SIASN','Loading...','main_modal2');
            var id = '';
            var idskpbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
    });
</script>