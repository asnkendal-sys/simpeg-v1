<?php
    $n  = 0;
    $rs = BiodataModel::getRortu($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++; ?>
        @if($item->status_jkn == 1)
            <tr style="background-color: #08cf4d;">
        @else   
            <tr>
        @endif
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->nama_ortu!!}</td>
            <td>{!!$item->stat!!}</td>
            <td>{!!$item->tempat_lahir!!}</td>
            <td>{!!date('d-m-Y', strtotime($item->tgl_lahir))!!}</td>
            <td>{!!$item->alamat!!}</td>
            <td>{!!$item->pekerjaan!!}</td>
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Riwayat Orang Tua belum tersedia.</td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('#rortu a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Orang Tua','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rortu_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rortu a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_ortu', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRortu();
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
