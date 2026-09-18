<?php
    $n  = 0;
    $x  = 0;
    $c  = 7;
    $d  = 6;
    $rs = BiodataModel::getrpppk($nip);
    $rs2 = BiodataModel::getrpppktemp($nip);
    $cek = \DB::table('tb_01 as a')->select('a.idjenjab', 'b.isguru')->leftjoin('a_jabfung as b', 'a.idjabfung', '=', 'b.idjabfung')->where('nip', $nip)->first();
    if($cek != null) {
          if($cek->idjenjab == 1){
              $c = ($c+1);
              $d = ($d+1);
          }
          if($cek->isguru == 1){
              $c = ($c+2);
              $d = ($d+2);
          }elseif($cek->isguru == 2){
              $c = ($c+1);
              $d = ($d+1);
          }
          if($cek->idjenjab == 2){
              $c = ($c+1);
              $d = ($d+1);
          }
    }
?>
@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++; ?>
        <tr>
            <td align="center">{!!$n!!}</td>
            <td>{!!$item->jab!!}</td>
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtawal))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtakhir))!!}</td>
            @if($cek->isguru == 1)
                <td>{!!$item->tugasgurudosen!!}</td>
                <td>{!!$item->matkulpel!!}</td>
            @elseif($cek->isguru == 2)
                <td>{!!$item->tugasdokter!!}</td>
            @endif
            @if($cek->idjenjab == 2)
                <td>{!!($item->nopak=='')?'':$item->nopak!!}</td>
            @endif
            <td>{!!$item->skpd!!}</td>

            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="center">{!!$item->jmlverified!!}</td>
            <td align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" jenisdokumen="[{!!$item->jab!!}] [{!!date('d-m-Y', strtotime($item->tgsk))!!}]" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <!--@if(session('role_id') <= 3)
                           <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit </a></li>
                        @else
                           <li><a class="text-info" recid="" href="#" onclick="bootbox.alert('Edit Data PPPK saat ini sedang di tutup')"><i class="fa fa-pencil-square-o"></i> Edit </a></li>
                        @endif-->
                         <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit </a></li>
                        <li><a class="text-danger {{(session('role_id') <= 33)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="13">Riwayat PPPK belum tersedia.</td>
    </tr>
@endif
@if(count($rs2->get()) > 0)
    <tr class="bg-primary">
        <th colspan="12" class="text-left bg-primary nover">PERMOHONAN PERUBAHAN DATA</th>
    </tr>
    @foreach($rs2->get() as $item)
        <?php $x++; ?>
        <tr>
            <td rowspan="2" align="center">{!!$x!!}</td>
            <td>{!!$item->jab!!}</td>
            @if($cek->idjenjab == 1)
                <td>{!!$item->esl!!}</td>
            @endif
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtawal))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtakhir))!!}</td>
            @if($cek->isguru == 1)
                <td>{!!$item->tugasgurudosen!!}</td>
                <td>{!!$item->matkulpel!!}</td>
            @elseif($cek->isguru == 2)
                <td>{!!$item->tugasdokter!!}</td>
            @endif
            @if($cek->idjenjab == 2)
                <td>{!!($item->nopak=='')?'':$item->nopak!!}</td>
            @endif
            <td>{!!$item->skpd!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="center">{!!$item->jmlverified!!}</td>
            <td rowspan="2" align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        {{-- <li><a class="text-info kelolafile" recid="{!!$item->id_rpppk!!}" jenisdokumen="[{!!$item->jab!!}] [{!!date('d-m-Y', strtotime($item->tgsk))!!}]" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li> --}}
                        @if(session('role_id') <= 33)
                           <li><a class="text-info editpermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        @else
                           <li><a class="text-info" recid="" href="#" onclick="bootbox.alert('Edit Data PPPK saat ini sedang di tutup')"><i class="fa fa-pencil-square-o"></i> Edit </a></li>
                        @endif
                        <li><a class="text-danger hapuspermohonan" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td><em><small>{!!getKetaksi($item->idjnsaksi)!!}</small></em></td>
            <td colspan="{!!$d!!}"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $('#rpppk a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat PPPK','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var jenisdokumen = $(this).attr('jenisdokumen');
            var subsubjenis = $(this).attr('subsubjenis');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': 6, 'subjenis': id, 'jenisdokumen':jenisdokumen, 'tb': 'r_pppk', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });
        $('#rpppk a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat PPPK','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpppk_form',
                data: {'nip': '{{$nip}}', 'id': id, 'flag':2, 'tb': 'r_pppk', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        $('#rpppk a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat PPPK','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpppk_form',
                data: {'nip': '{{$nip}}', 'id': id, 'flag':2, 'tb': 'r_pppk_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        $('#rpppk a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat PPPK','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rpppk_form',
                data: {'nip': '{{$nip}}', 'id': id, 'flag':3, 'tb':'r_pppk', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });
        $('#rpppk a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': '{{$nip}}', 'id': id, 'flag':3, 'tb':'r_pppk', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpppk();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
        $('#rpppk a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': '{{$nip}}', 'id': id, 'flag':3, 'tb':'r_pppk_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRpppk();
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
