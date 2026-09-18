<?php
$n = 0;
$rs = BiodataModel::getRkinerjaasn($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->tahun!!}</td>
            <td>{!!$item->pejpenilai!!}</td>
            <td>{!!$item->jabpenilai!!}</td>
            <td>{!!$item->capaiankinerja!!}</td>
            <td>{!!$item->ratinghasil!!}</td>
			<td>{!!$item->ratingperilaku!!}</td>
            <td>{!!$item->predikatkinerja!!}</td>
            <td class="text-center">{!!(($item->idsapk!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <!--td align="center">{!!$item->verified!!}</td-->
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-danger sinkronsiasn" recid="{!!$item->id!!}" idbkn="{!!$item->idsapk!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai SIASN</a></li>
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Kinerja ASN Tahun {!!$item->tahun!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6">Riwayat Penilaian Prilaku Kerja Pegawai belum tersedia.</td>
    </tr>
@endif

<tr>
    <td colspan="11"><a class="text-info prevsinkronsiasn btn btn-success" recid="" idbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data SIASN</a></td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rkinerjaasn a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Kinerja ASN','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{!!$nip!!}', 'jenis': 116, 'subjenis': id, 'nama_jenis':nama_jenis, 'tb': 'r_kinerjaasn', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rkinerjaasn a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Sasaran Kinerja Pegawai','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rkinerjaasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rkinerjaasn a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_kinerjaasn', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRkinerjaasn();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rkinerjaasn a.sinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idskpbkn = $(this).attr('idbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp22_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rkinerjaasn a.prevsinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Data SKP SIASN','Loading...','main_modal2');
            var id = '';
            var idskpbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp22_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
    });
</script>