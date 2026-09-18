<?php
$n = 0;
$x = 0;
$rs = BiodataModel::getRpangkat($nip);
$rs2 = BiodataModel::getRpangkattemp($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}</td>
            <td>{!!$item->golru." - ".$item->pangkat!!} {!!($item->stspangkat == '4')?'(PMK)':''!!} </td>
            <td>{!!($item->jabatan!='')?$item->jabatan:$item->pejmenpkttext!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" ident="{{$item->idgolru}}" jns="SK Kenaikan Pengkat {!!$item->golru." - ".$item->pangkat." [".date('d-m-Y', strtotime($item->tgsk))."]"!!} " href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger {{(session('role_id') <= 3)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7">Riwayat Pangkat belum tersedia.</td>
    </tr>
@endif

@if(count($rs2->get()) > 0)
    <tr class="bg-primary">
        <th colspan="7" class="text-left bg-primary nover">PERMOHONAN PERUBAHAN DATA</th>
    </tr>
    @foreach($rs2->get() as $item)
    <?php $x++;?>
        <tr>
            <td rowspan="2"align="center">{!!$x!!}</td>
            <td align="left">{!!$item->golru." - ".$item->pangkat!!}</td>
            <td>{!!($item->jabatan!='')?$item->jabatan:$item->pejmenpkttext!!}</td>
            <td align="left">{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</td>
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
            <td><em><small>{!!getKetaksi($item->idjnsaksi)!!}</small></em></td>
            <td colspan="4" class="{!!($item->status == 2)?'alert-danger':''!!}"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('#rpangkat a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola  File Riwayat Pangkat','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            var ident = $(this).attr('ident');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': 5, 'subjenis': id, 'nama_jenis':nama_jenis,'ident': ident, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rpangkat a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Pangkat','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpangkat_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpangkat a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat Pangkat','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpangkat_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_gol_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpangkat a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Pangkat','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpangkat_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpangkat a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_gol', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpangkat();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rpangkat a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_gol_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpangkat();
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