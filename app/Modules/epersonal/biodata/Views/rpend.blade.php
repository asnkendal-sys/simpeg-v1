<?php
$n = 0;
$x = 0;
$rs = BiodataModel::getRpend($nip);
$rs2 = BiodataModel::getRpendtemp($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->tkpendid!!}</td>
            <td>{!!$item->jenjurusan!!}</td>
            <td>{!!$item->namasekolah!!}</td>
            <td>{!!$item->tempat!!}</td>
            <td>{!!$item->noijaz!!}</td>
            <td>{!!date('d-m-Y', strtotime($item->tgijaz))!!}</td>
            <td>{!!$item->kepsek!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jenis="8" ident="{{$item->singkatan}}" jns="Ijazah {!!$item->tkpendid!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File Ijazah</a></li>
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jenis="77" ident="{{$item->singkatan}}" jns="Transkrip {!!$item->tkpendid!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File Transkrip</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger {{(session('role_id') <= 3)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9">Riwayat Pendidikan belum tersedia.</td>
    </tr>
@endif

@if(count($rs2->get()) > 0)
    <tr class="bg-primary">
        <th colspan="9" class="text-left bg-primary nover">PERMOHONAN PERUBAHAN DATA</th>
    </tr>
    @foreach($rs2->get() as $item)
        <?php $x++;?>
        <tr>
            <td rowspan="2" align="center">{!!$x!!}.</td>
            <td>{!!$item->tkpendid!!}</td>
            <td>{!!$item->jenjurusan!!}</td>
            <td>{!!$item->namasekolah!!}</td>
            <td>{!!$item->tempat!!}</td>
            <td>{!!$item->noijaz!!}</td>
            <td>{!!date('d-m-Y', strtotime($item->tgijaz))!!}</td>
            <td>{!!$item->kepsek!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td rowspan="2" align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <!-- <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Ijazah {!!$item->tkpendid!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li> -->
                        <li><a class="text-info editpermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapuspermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td width="15%"><em><small>{!!getKetaksi($item->idjnsaksi)!!}</small></em></td>
            <td colspan="6"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('#rpend a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Pendidikan','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            var jenis = $(this).attr('jenis');
            var ident = $(this).attr('ident');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': jenis, 'subjenis': id, 'nama_jenis':nama_jenis,'ident': ident, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rpend a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Pendidikan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpend_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_pend', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpend a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat Pendidikan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpend_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_pend_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpend a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Pendidikan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpend_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb': 'r_pend', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpend a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_pend', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpend();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rpend a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_pend_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpend();
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