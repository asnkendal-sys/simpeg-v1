<?php
    $n  = 0;
    $rs = BiodataModel::getRissu($nip);
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}.</td>
            <td>{!!$item->nmissu!!}</td>
            <td>{!!$item->tmlhr!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tglhr))!!}</td>
            <td>{!!$item->noaktanikah!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgnikah))!!}</td>
            <!-- <td>{!!($item->idstsissu==1)?"Hidup":($item->idstsissu==2)?"Cerai":($item->idstsissu==3)?"Meninggal":""!!}</td> -->
            @if($item->idstsissu==1)
                <td>Hidup</td>
            @elseif($item->idstsissu==2)
                <td>Cerai</td>
            @elseif($item->idstsissu==3)
                <td>Meninggal</td>
            @else
                <td>-</td>
            @endif
            <td>{!!$item->nipnrp!!}</td>
            <td>{!!$item->pendidum!!}</td>
            <!-- <td>{!!($item->peker==1)?"PNS Kab.Kendal":($item->peker==2)?"PNS Luar Kab.Kendal":"Non PNS"!!}</td> -->
            @if($item->peker==1)
                <td>PNS Kab.Kendal</td>
            @elseif($item->peker==2)
                <td>PNS Luar Kab.Kendal</td>
            @else
                <td>Non PNS</td>
            @endif
            <td>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
         <?php if(session('role_id')==1){?>
        
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info edit" recid="{!!$item->id!!}" idx="{!!$item->nipnrp!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                <li><a class="text-danger hapus" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
        
                    </ul>
         <?php } ?>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7">Riwayat Istri / Suami belum tersedia.</td>
    </tr>
@endif
<!-- data:'id=' + $this.attr('recid'), -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#rissu a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Istri / Suami','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rissu_form',      
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rissu a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_issu', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadRissu();
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