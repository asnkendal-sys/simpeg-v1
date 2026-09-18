<?php
$n = 0;
$x = 0;
$rs = BiodataModel::getRdikstru($nip);
$rs2 = BiodataModel::getRdikstrutemp($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->dikstru!!}</td>
            <td>{!!$item->tmdikstru!!}</td>
            <td>{!!$item->penyelenggara!!}</td>
            <td>{!!$item->angkatan!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
            <td>{!!$item->jamhari!!} Jam </td>
            <td>{!!$item->nosttpdikstru!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsttpdikstru))!!}</td>
            <td class="text-center">{!!(($item->idsapk!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-danger sinkronsiasn" recid="{!!$item->id!!}" idbkn="{!!$item->idsapk!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai SIASN</a></li>
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Diklat Struktural {!!$item->dikstru!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger {!!(session('role_id') <= 3)?'hapus':'hapusmin'!!}" recid="{!!$item->id!!}" href="javascript:void(0)" id="hapus"><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="11">Riwayat Diklat Struktural belum tersedia.</td>
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
            <td>{!!$item->dikstru!!}</td>
            <td>{!!$item->tmdikstru!!}</td>
            <td>{!!$item->penyelenggara!!}</td>
            <td>{!!$item->angkatan!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
            <td>{!!$item->jamhari!!} Jam </td>
            <td>{!!$item->nosttpdikstru!!}</td>
            <td align="center">{!!date('d-m-Y',strtotime($item->tgsttpdikstru))!!}</td>
            <td class="text-center">{!!(($item->idsapk!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td rowspan="2" align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info editpermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapuspermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td width="15%"><em><small>{!!getKetaksi($item->idjnsaksi)!!}</small></em></td>
            <td colspan="9"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif

<tr>
    <td colspan="13">
        <a class="text-info prevsinkronsiasn btn btn-success" recid="" idbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data SIASN</a>
    </td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rdikstru a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Diklat Struktural','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{!!$nip!!}', 'jenis': 9, 'subjenis': id, 'nama_jenis':nama_jenis, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rdikstru a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Diklat Struktural','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rdikstru_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_dikstru', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rdikstru a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat Diklat Struktural','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rdikstru_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_dikstru_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rdikstru a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Diklat Struktural','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rdikstru_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb': 'r_dikstru', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rdikstru a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_dikstru', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRdikstru();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rdikstru a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_dikstru_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRdikstru();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rdikstru a.sinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var iddikstrubkn = $(this).attr('idbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rdikstru_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'iddikstrubkn': iddikstrubkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rdikstru a.prevsinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Riwayat Diklat Struktural SIASN','Loading...','main_modal2');
            var id = '';
            var iddikstrubkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rdikstru_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'iddikstrubkn': iddikstrubkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
    });
</script>