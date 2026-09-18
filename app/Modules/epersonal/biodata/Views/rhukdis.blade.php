<?php
$n = 0;
$x = 0;
$rs = BiodataModel::getRhukdis($nip);
$rs2 = BiodataModel::getRhukdistemp($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->jenhukum!!}</td>
            <td>{!!$item->kathukdis!!}</td>
            <td>{!!$item->jabatan!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
            <td>{!!$item->ket!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <?php if(session('role_id')!=5){?>
                    <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Hukdis {!!$item->jenhukum!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                    <?php } ?>
                          <?php if(session('role_id')==2){?>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        
                         <li><a class="text-danger {{(session('role_id') <= 3)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10">Riwayat Hukuman Disiplin belum tersedia.</td>
    </tr>
@endif

@if(count($rs2->get()) > 0)
    <tr class="bg-primary">
        <th colspan="11" class="text-left bg-primary nover">PERMOHONAN PERUBAHAN DATA</th>
    </tr>
    @foreach($rs2->get() as $item)
        <?php $x++;?>
        <tr>
            <td rowspan="2" align="center">{!!$x!!}.</td>
            <td>{!!$item->jenhukum!!}</td>
            <td>{!!$item->kathukdis!!}</td>
            <td>{!!$item->jabatan!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
            <td>{!!$item->ket!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td rowspan="2" align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                    	<li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Hukdis {!!$item->jenhukum!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info editpermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapuspermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td width="15%"><em><small>{!!getKetaksi($item->idjnsaksi)!!}</small></em></td>
            <td colspan="7"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif

<script type="text/javascript">
    $(document).ready(function(){
    	$('#rhukdis a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Hukdis','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': 14, 'subjenis': id, 'nama_jenis':nama_jenis, 'tb': 'r_skp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rhukdis a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Hukuman Disiplin','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rhukdis_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_hukdis', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rhukdis a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat Hukuman Disiplin','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rhukdis_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_hukdis_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rhukdis a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Hukuman Dispilin','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rhukdis_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb': 'r_hukdis', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rhukdis a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_hukdis', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRhukdis();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rhukdis a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_hukdis_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRhukdis();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>