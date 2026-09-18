<?php
$n = 0;
$x = 0;
$c = 7;
$d = 6;
$rs = BiodataModel::getRjab($nip);
$rs2 = BiodataModel::getRjabtemp($nip);
$cek = \DB::table('tb_01 as a')->select('a.idjenjab', 'b.isguru')->leftjoin('a_jabfung as b', 'a.idjabfung', '=', 'b.idjabfung')->where('nip', $nip)->first();

if ($cek->idjenjab == 1) {
    $c = ($c + 1);
    $d = ($d + 1);
}

if ($cek->isguru == 1) {
    $c = ($c + 2);
    $d = ($d + 2);
} elseif ($cek->isguru == 2) {
    $c = ($c + 1);
    $d = ($d + 1);
}

if ($cek->idjenjab == 2) {
    $c = ($c + 1);
    $d = ($d + 1);
}
?>

@if(count($rs->get()) > 0)
    @foreach($rs->get() as $item)
        <?php $n++;?>
        <tr>
            <td align="center">{!!$n!!}</td>
            <td>{!!$item->jab!!}</td>
            @if($cek->idjenjab == 1)
                <td>{!!$item->esl!!}</td>
            @endif
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtjab))!!}</td>
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
            <td class="text-center">{!!(($item->idjabbkn!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td align="center">{!!$item->jmlfile!!}</td>
            <td align="right">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Aksi
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <!--<li><a class="text-danger sinkronbkn" recid="{!!$item->id!!}" recidjabbkn="{!!$item->idjabbkn!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai BKN</a></li>-->
                        <li><a class="text-danger sinkronsiasn" recid="{!!$item->id!!}" recidjabbkn="{!!$item->idjabbkn!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisai SIASN</a></li>
                        <li><a class="text-info kelolafile" recid="{!!$item->id!!}" ident="{{date('Y', strtotime($item->tgsk))}}" jenisdokumen="[{!!$item->jab!!}] [{!!date('d-m-Y', strtotime($item->tgsk))!!}]" href="javascript:void(0)" ><i class="fa fa-file-o"></i> Kelola File</a></li>
                        <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="text-danger {{(session('role_id') <= 3)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Hapus</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9">Riwayat Jabatan belum tersedia.</td>
    </tr>
@endif

@if(count($rs2->get()) > 0)
    <tr class="bg-primary">
        <th colspan="{!!$c!!}" class="text-left bg-primary nover">PERMOHONAN PERUBAHAN DATA</th>
    </tr>
    @foreach($rs2->get() as $item)
        <?php $x++;?>
        <tr>
            <td rowspan="2" align="center">{!!$x!!}</td>
            <td>{!!$item->jab!!}</td>
            @if($cek->idjenjab == 1)
                <td>{!!$item->esl!!}</td>
            @endif
            <td>{!!$item->nosk!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</td>
            <td align="center">{!!date('d-m-Y', strtotime($item->tmtjab))!!}</td>
            @if($cek->isguru == 1)
                <td>{!!$item->tugasgurudosen!!}</td>
                <td>{!!$item->matkulpel!!}</td>
            @elseif($cek->isguru == 2)
                <td>{!!$item->tugasdokter!!}</td>
            @endif
            @if($cek->idjenjab == 2)
                <td>{!!($item->nopak=='')?'':$item->nopak!!}</td>
            @endif
            <td class="text-center">{!!(($item->idjabbkn!='')?'<span class="label label-success">Sudah</span>':'<span class="label label-warning">Belum</span>')!!}</td>
            <td>{!!$item->skpd!!}</td>
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
            <td colspan="{!!$d!!}"><em><small>Keterangan : {!!($item->ketditolak!='')?$item->ketditolak:'Belum ada tanggapan.'!!}</small></em></td>
        </tr>
    @endforeach
@endif

<tr>
    <td colspan="9">
        <!--<a class="text-info prevsinkronbkn btn btn-success" recid="" recidjabbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data BKN</a>-->
        <a class="text-info prevsinkronsiasn btn btn-success" recid="" recidjabbkn="" href="javascript:void(0)"><i class="fa fa-search"></i> Preview Data SIASN</a>
    </td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('#rjab a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola File Riwayat Jabatan','Loading...','kelola_file');
            var id = $(this).attr('recid');
            var jenisdokumen = $(this).attr('jenisdokumen');
            var subsubjenis = $(this).attr('subsubjenis');
            var ident = $(this).attr('ident');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': 6, 'subjenis': id, 'jenisdokumen':jenisdokumen,'ident': ident, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });

        $('#rjab a.edit').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Jabatan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_jab', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rjab a.editpermohonan').on('click',function(e){
            e.preventDefault();
            claravel_modal('Permohonan Riwayat Jabatan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':2, 'tb': 'r_jab_temp', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rjab a.hapusmin').on('click',function(e){
            e.preventDefault();
            claravel_modal('Riwayat Jabatan','Loading...','main_modal');
            var id = $(this).attr('recid');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_form',
                data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_jab', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('#rjab a.hapus').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_jab', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRjab();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rjab a.hapuspermohonan').on('click',function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/epersonal/biodata/delriwayat',
                        data: {'nip': $('#nip').val(), 'id': id, 'flag':3, 'tb':'r_jab_temp', '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==9){
                                notification('Data Berhasil Dihapus.','success');
                                loadBiodata();
                                loadRjab();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#rjab a.sinkronbkn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai BKN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idjabbkn = $(this).attr('recidjabbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_sinkronbkn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idjabbkn': idjabbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rjab a.prevsinkronbkn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Riwayat Jabatan BKN','Loading...','main_modal2');
            var id = '';
            var idjabbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_sinkronbkn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idjabbkn': idjabbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rjab a.sinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            var id = $(this).attr('recid');
            var idjabbkn = $(this).attr('recidjabbkn');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idjabbkn': idjabbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });

        $('#rjab a.prevsinkronsiasn').on('click',function(e){
            e.preventDefault();
            claravel_modal('Preview Riwayat Jabatan SIASN','Loading...','main_modal2');
            var id = '';
            var idjabbkn = '';
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/data/rjab_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idjabbkn': idjabbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        });
    });
</script>