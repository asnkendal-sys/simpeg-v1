<?php
$n = 0;
$rs = BiodataModel::getRakredit($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->pak!!}</td>
            <td>{!!$item->jabfung!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->periodemulai))!!}</td>
            <td align="center">{!!date("d-m-Y", strtotime($item->periodeselesai))!!}</td>
            <td>{!!$item->kubaru!!}</td>
            <td>{!!$item->kpbaru!!}</td>
            <td>{!!$item->kbtotal!!}</td>
            <td class="text-center">{!!(($item->idsapk!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-danger sinkronsiasn" recid="{!!$item->id!!}" idbkn="{!!$item->idsapk!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai SIASN</a></li>
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" ident="{!!date('Y', strtotime($item->tgsk))!!}" jns="Angka Kredit - {!!$item->jabfung!!} ({!!$item->pak!!})" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <!--<li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>-->
   
                   <li><a class="text-danger hapussinkron" recid="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-times-circle"></i>
                        Hapus dan Sinkron SIASN
                    </a></li>
                
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="11">Riwayat Angka Kredit belum tersedia.</td>
    </tr>
@endif

<tr>
    <td colspan="13">        
        <a class="text-info prevsinkronsiasn btn btn-success" recid="" idbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data SIASN</a>
    </td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rakredit a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Angka Kredit','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            var ident = $(this).attr('ident');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{!!$nip!!}', 'jenis': 16, 'subjenis': id, 'nama_jenis':nama_jenis,'ident': ident, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rakredit a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Angka Kredit','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rakredit_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rakredit a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_akredit', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRakredit();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rakredit a.sinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idakreditbkn = $(this).attr('idbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rakredit_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idakreditbkn': idakreditbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rakredit a.prevsinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Data Angka Kredit SIASN','Loading...','main_modal2');
            var id = '';
            var idakreditbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rakredit_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idakreditbkn': idakreditbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
        
        // candra
        $('#rakredit a.hapussinkron').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?', function(a) {
                if (a == true) {
                    $.ajax({
                        type: 'post',
                        url: '{!!url()!!}/epersonal/biodata/delsinkronriwayat',
                        data: {
                            'nip': $('#nip').val(),
                            'id': id,
                            'flag': 3,
                            'tb': 'r_akredit',
                            '_token': '{!!csrf_token()!!}'
                        },
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            preloader.off();
                            if (html == '9') {
                                notification('Data Berhasil Dihapus.', 'success');
                                loadRakredit();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });
        // candra end
    });
</script>