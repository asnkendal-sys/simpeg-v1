<?php
$n = 0;
$rs = BiodataModel::getRpenghargaan($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->tandajasa!!}</td>
            <td>{!!$item->namatandajasa!!}</td>
            <td align="center">{!!$item->thn!!}</td>
            <td>{!!$item->nama!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jns="Tanda Jasa {!!$item->tandajasa!!}" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7">Riwayat Tanda Jasa belum tersedia.</td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('#rpenghargaan a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Tanda Jasa','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var nama_jenis = $(this).attr('jns');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': 13, 'subjenis': id, 'nama_jenis':nama_jenis, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rpenghargaan a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Penghargaan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpenghargaan_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rpenghargaan a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_tandajasa', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRpenghargaan();
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