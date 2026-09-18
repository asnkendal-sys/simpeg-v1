<section class="content-header">
    <h1>
        SK Mutasi Antar OPD<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">skmutasiantaropd</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <p>&nbsp;</p>
            <div class="box-tools pull-right col-lg-10 pull-right">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' =>
                'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <table width="100%" id="tables" class="pull-right">
                    <tr>
                        <td style="padding: 5px;" width="40%">{!!
                            comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}</td>
                        <td style="padding: 5px;" width="20%">
                            <select id="statususul" name="statususul" class="input-large form-control">
                                <option value="">.: Status Berkas :.</option>
                                <option value="1">Memenuhi Syarat</option>
                                <option value="2">Tidak Memenuhi Syarat</option>
                                <option value="3">Berkas Tidak Lengkap</option>
                            </select>
                        </td>
                        <td style="padding: 5px;" width="20%">
                            <select id="statussk" name="statussk" class="input-large form-control">
                                <option value="">.: Status SK :.</option>
                                <option value="2">Dalam Proses</option>
                                <option value="1">Proses Selesai</option>
                            </select>
                        </td>
                        <td style="padding: 5px;" width="20%">
                            <div class="input-group" style="width: 200px;">
                                <input type="text" class="form-control" name="search"
                                    value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span
                                            class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' =>
        'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="">
            <div class="box-body">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                        <tr>
                            <th width="3%">NO</th>
                            <th>
                                <div class="text-center">NIP<br>NAMA LENGKAP</div>
                            </th>
                            <th>
                                <div class="text-center">GOL. RUANG</div>
                            </th>
                            <th>
                                <div class="text-center">PENDIDIKAN<br>TERAKHIR</div>
                            </th>
                            <th colspan="2">
                                <div class="text-center">JABATAN LAMA PADA SKPD</div>
                            </th>
                            <th colspan="2">
                                <div class="text-center">JABATAN BARU PADA SKPD</div>
                            </th>
                            <th>
                                <div class="text-center">STATUS</div>
                            </th>
                            <th>
                                <div class="text-center">PROSES</div>
                            </th>
                            <th width="5%">
                                <div class="text-center">AKSI</div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $arr[0] = "";
                        $n = 0;
                        ?>
                        @foreach ($skmutasiantarskpds as $no => $skmutasiantarskpd)
                        <?php
                        $n++;
                        $arr[$n] = $skmutasiantarskpd->nousul;
                        if ($arr[$n] != $arr[$n - 1]) {
                        ?>
                        <tr>
                            <th style="position:relative;" colspan="6">
                                <div class="text-left">
                                    NOMOR USULAN : {{$skmutasiantarskpd->nousul}}&nbsp;
                                    <i class="fa fa-calendar"></i>
                                    <?php echo date("d-m-Y", strtotime($skmutasiantarskpd->tglusul)) ?>
                                    &nbsp;
                                    <?php
                                        if ($skmutasiantarskpd->idskpd != "") {
                                            $ket = "";
                                        } else {
                                            $ket = "Penempatan CPNS";
                                        }

                                        echo "||&nbsp;" . getskpdgroup(substr($skmutasiantarskpd->idskpd, 0, 2)) . " " . $ket;
                                        ?>&nbsp;
                                    <br>
                                </div>
                            </th>
                            <th style="position:relative;" colspan="8">
                                <div class="text-right">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"
                                            type="button" aria-expanded="false">
                                            <span class="fa fa-print"></span> Cetak Petikan/Perintah
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(($skmutasiantarskpd->statususul == 1) or ($skmutasiantarskpd->statussk
                                            == 1))
                                            <li><a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skperintahkolektif/" . $skmutasiantarskpd->nousul ?>"
                                                    target="_blank" class="cetak" title="Cetak Pengantar Ke Sekda"><i
                                                        class="fa fa-print"> </i> Surat Perintah Kolektif</a></li>
                                            <li><a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skkolektif_daftar/" . $skmutasiantarskpd->nousul ?>"
                                                    class="cetak" title="Cetak SK Daftar Kolektif"
                                                    data-nousul="<?= $skmutasiantarskpd->tglusul ?>" target="_blank"><i
                                                        class="fa fa-list"></i> Lampiran SP Kolektif</a></li>
                                            <!-- LAMPIRAN CHECKLIST KE BUPATI <li><a href="" target="_blank" class="attrnominatifbupati" recnousul="{!!$skmutasiantarskpd->nousul!!}" act="nominatifbupati" class="cetak" title="Cetak Daftar Nominatif checklsit Bupati"><i class="fa fa-list"> </i> Lampiran Checklist</a></li> -->

                                            @else
                                            <li><a href="javascript:void(0)" class="cetak" style="color: red"
                                                    title="SK Kolektif Status Belum diproses"
                                                    data-nousul="<?= $skmutasiantarskpd->tglusul ?>"><i
                                                        class="fa fa-print"></i> Surat Perintah Kolektif</a></li>
                                            <li><a href="javascript:void(0)" class="cetak" style="color: red"
                                                    title="SK Daftar Kolektif Status Belum diproses"
                                                    data-nousul="<?= $skmutasiantarskpd->tglusul ?>"><i
                                                        class="fa fa-list"></i> Lampiran SP Kolektif</a></li>
                                            @endif

                                            <li><a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skperintahall/" . $skmutasiantarskpd->nousul ?>"
                                                    class="cetak" title="Cetak Semua SP" target="_blank"><i
                                                        class="fa fa-print"></i> Cetak Semua SP</a></li>

                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"
                                            type="button" aria-expanded="false">
                                            <span class="fa fa-print"></span> Cetak Nota Dinas
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(($skmutasiantarskpd->statususul == 1) or ($skmutasiantarskpd->statussk
                                            == 1))
                                            <li><a href="javascript::void(0)" class="printnota"
                                                    recnousul="{!!$skmutasiantarskpd->nousul!!}"
                                                    title="Cetak Pengantar Ke Sekda"><i class="fa fa-print"> </i> Nota
                                                    Dinas</a></li>
                                            <li><a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skkolektif_daftar/" . $skmutasiantarskpd->nousul ?>"
                                                    class="cetak" title="Cetak SK Daftar Kolektif"
                                                    data-nousul="<?= $skmutasiantarskpd->tglusul ?>" target="_blank"><i
                                                        class="fa fa-list"></i> Lampiran Pengantar</a></li>
                                            @else
                                            <li><a href="javascript:void(0)" title="Cetak Pengantar Ke Sekda"
                                                    class="cetak" style="color: red"><i class="fa fa-print"> </i> Nota
                                                    Dinas</a></li>
                                            <li><a href="javascript:void(0)" class="cetak" style="color: red"
                                                    title="SK Daftar Kolektif Status Belum diproses"
                                                    data-nousul="<?= $skmutasiantarskpd->tglusul ?>"><i
                                                        class="fa fa-list"></i> Lampiran Pengantar</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <center>{!!
                                    (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}
                                </center>
                            </td>
                            <td>{!!$skmutasiantarskpd->nip!!}<br>{!!$skmutasiantarskpd->namalengkap!!}
                                <a title="popdetil" href="javascript:void(0)"></a><br>
                                <div class="text-right" style="position:relative">
                                    @if($skmutasiantarskpd->iscetaksk == 1)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#ffcc00;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @elseif($skmutasiantarskpd->iscetaksk == 2)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#000000;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>{!!$skmutasiantarskpd->golru!!}<br>{!!($skmutasiantarskpd->tmtpkt!='0000-00-00')?date('d-m-Y',
                                strtotime($skmutasiantarskpd->tmtpkt)):''!!}</td>
                            <td>{!!$skmutasiantarskpd->tkpendid!!}<br>{!!$skmutasiantarskpd->jenjurusan!!}</td>
                            <td>{!!$skmutasiantarskpd->skpdlama!!}</td>

                            <td>{!!$skmutasiantarskpd->jabatan!!}<br>{!!($skmutasiantarskpd->tmtjbt!='0000-00-00')?date('d-m-Y',
                                strtotime($skmutasiantarskpd->tmtjbt)):''!!}</td>
                            <td>{!!$skmutasiantarskpd->skpdbaru!!}</td>
                            <td>{!!$skmutasiantarskpd->jabatanbaru!!}</td>
                            <td>
                                <div align="center">
                                    @if($skmutasiantarskpd->statususul==1)
                                    <span style="color:green">
                                        <i class="glyphicon glyphicon-ok" title="Memenuhi Syarat" />
                                        <span>
                                            @elseif($skmutasiantarskpd->statususul==2)
                                            <span style="color:red">
                                                <i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat" />
                                            </span>
                                            @elseif($skmutasiantarskpd->statususul==3)
                                            <span style="color:orange">
                                                <i class="glyphicon glyphicon-exclamation-sign"
                                                    title="Berkas Tidak Lengkap" />
                                            </span>
                                            @else
                                            -
                                            @endif
                                </div>
                            </td>
                            <td>
                                <div align="center">
                                    @if($skmutasiantarskpd->statususul=='1' && $skmutasiantarskpd->statussk=='2')
                                    <span style="color:orange"><i class="glyphicon glyphicon-time"
                                            title="Sedang diproses" /><span>
                                            @elseif($skmutasiantarskpd->statussk=='1')
                                            <span style="color:green"><i class="glyphicon glyphicon-ok"
                                                    title="Selesai diproses" /></span>
                                            @else
                                            -
                                            @endif
                                </div>
                            </td>
                            <td>
                                @if(($skmutasiantarskpd->statususul == 1) and ($skmutasiantarskpd->statussk == 1))
                                @if($skmutasiantarskpd->idjenjab == 2)
                                <a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skperintahfungsional/" . $skmutasiantarskpd->nousul . "/" . $skmutasiantarskpd->nip ?>"
                                    target="blank" title="Cetak Surat Perintah"><i class="fa fa-search"></i></a>
                                @else
                                <a href="<?php echo url() . "/emutasi/skmutasiantarskpd/cetak/skperintah/" . $skmutasiantarskpd->nousul . "/" . $skmutasiantarskpd->nip ?>"
                                    target="blank" title="Cetak Surat Perintah"><i class="fa fa-print"></i></a>
                                @endif

                                @else
                                <a href="javascript:void(0)" title="SK Perintah Belum Selesai Diproses"
                                    style="color: red"><i class="fa fa-print"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <?php echo $skmutasiantarskpds->appends(array('search' => Input::get('search')))->render(); ?>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div>
        <table border="0" width="100%">
            <tr>
                <td colspan="11">Keterangan :<br></td>
            </tr>
            <tr>
                <td>
                    <span style="color:green"><i class="glyphicon glyphicon-ok" title="Memenuhi Syarat" /></span>
                    Memenuhi Syarat<br>
                </td>
                <td>
                    <span style="color:red"><i class="glyphicon glyphicon-remove"
                            title="Tidak Memenuhi Syarat" /></span> Tidak Memenuhi Syarat<br>
                </td>
                <td>
                    <span style="color:orange"><i class="glyphicon glyphicon-exclamation-sign"
                            title="Berkas Tidak Lengkap" /></span> Berkas Tidak Lengkap<br>
                </td>
                <td>
                    <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses" /></span>
                    Sedang Diproses<br>
                </td>
                <td>
                    <span style="color:green"><i class="glyphicon glyphicon-ok" title="Selesai diproses" /></span>
                    Selesai diproses<br>
                </td>
                <td>
                    <span style="color:#ffcc00"><i class="glyphicon glyphicon-star" title="Sudah Cetak SK" /></span>
                    Sudah Cetak SK<br>
                </td>
                <td>
                    <span style="color:#000000"><i class="glyphicon glyphicon-star" title="Sudah Cetak SK" /></span> SK
                    Dibatalkan<br>
                </td>
            </tr>
        </table>
    </div><br>
</section>

<script>
function refresh_page() {
    <?php
        echo 'var index_page=laravel_base + "/' . \Request::path() . '";';
        ?>
    $.ajax({
        url: index_page,
        type: 'GET',
        beforeSend: function() {
            preloader.on();
        },
        success: function(html) {
            preloader.off();
            $('#utama').html(html);
        }
    });
}

$(document).ready(function() {
    $('select').select2();
    $('.pagination').addClass('pagination-sm no-margin pull-right');
    $('.checkme,.checkall').on('change', function() {
        if ($(this).is(':checked'))
            $('#deleteall').fadeIn(300);
        else
            $('#deleteall').fadeOut(300);
    });

    $('.printnota').on('click', function(e) {
        e.preventDefault();

        claravel_modal('Penetapan Tanggal Nota Dinas', 'Loading...', 'main_modal');
        $.ajax({
            type: 'post',
            url: '{!!url()!!}/emutasi/skmutasiantarskpd/data/modalprint',
            data: {
                'nousul': $(this).attr('recnousul'),
                '_token': '{!!csrf_token()!!}'
            },
            success: function(html) {
                $('#main_modal .modal-body').html(html);
            }
        });
    })

    $('#buat').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            beforeSend: function() {
                preloader.on();
            },
            success: function(html) {
                preloader.off();
                $('#utama').html(html);
            }
        });
    });

    <?php
        echo 'var index_page=laravel_base + "/' . \Request::path() . '";';
        ?>

    $('#tabel').on('click', '#hapus', function(e) {
        e.preventDefault();
        var $this = $(this);
        bootbox.confirm('Hapus?', function(a) {
            if (a == true) {
                $.ajax({
                    url: index_page + '/delete',
                    type: 'post',
                    data: {
                        'id': $this.attr('recid'),
                        '_token': '{!!csrf_token()!!}'
                    },
                    beforeSend: function() {
                        preloader.on();
                    },
                    success: function(html) {
                        preloader.off();
                        if (html == 9) {
                            notification('Berhasil Dihapus', 'success');
                            $this.closest('tr').fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            notification(html, 'danger');
                        }
                    }
                });
            }
        });
    });
    $('#tabel').on('click', '#edit', function(e) {
        e.preventDefault();
        var $this = $(this);
        bootbox.confirm('Edit?', function(a) {
            if (a == true) {
                $.ajax({
                    url: index_page + '/edit',
                    type: 'get',
                    data: 'id=' + $this.attr('recid'),
                    beforeSend: function() {
                        preloader.on();
                    },
                    success: function(html) {
                        preloader.off();
                        $('#utama').html(html);
                    }
                });
            }
        });
    });
    $('#cari').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'get',
            beforeSend: function() {
                preloader.on();
            },
            success: function(html) {
                preloader.off();
                $('#utama').html(html);
            }
        });
    });
    $('#data').on('submit', function(e) {
        e.preventDefault();
        var iki = $(this);
        bootbox.confirm('Hapus?', function(r) {
            if (r) {
                $.ajax({
                    url: iki.attr('action') + '/delete',
                    type: 'post',
                    data: iki.serialize(),
                    beforeSend: function() {
                        preloader.on();
                    },
                    success: function(html) {
                        preloader.off();
                        notification(html, 'success');
                        iki.find('input[type=checkbox]').each(function(t) {
                            if ($(this).is(':checked')) {
                                $(this).closest('tr').fadeOut(100)
                            }
                        });
                        $('#deleteall').fadeOut(300);
                    }
                });
            }
        });
    });


    $('.nokolektif').on('click', function(e) {
        e.preventDefault();

        claravel_modal('Input No SK Kolektif', 'Loading...', 'main_modal');
        $.ajax({
            type: 'post',
            url: '{!!url()!!}/emutasi/skmutasiantarskpd/data/nokolektif',
            data: {
                'nousul': $(this).attr('recnousul'),
                '_token': '{!!csrf_token()!!}'
            },
            success: function(html) {
                $('#main_modal .modal-body').html(html);
            }
        });
    })

    $('.attrnominatifbupati').on('click', function(e) {
        e.preventDefault();

        claravel_modal('Atribut Daftar Nominatif Checklist Bupati', 'Loading...', 'main_modal');
        $.ajax({
            type: 'post',
            url: '{!!url()!!}/emutasi/skmutasiantarskpd/data/attrnominatifbupati',
            data: {
                'nousul': $(this).attr('recnousul'),
                '_token': '{!!csrf_token()!!}'
            },
            success: function(html) {
                $('#main_modal .modal-body').html(html);
            }
        });
    })
    $('.attrpengantarsekda').on('click', function(e) {
        e.preventDefault();

        claravel_modal('Atribut Pengantar Ke Sekda', 'Loading...', 'main_modal');
        $.ajax({
            type: 'post',
            url: '{!!url()!!}/emutasi/skmutasiantarskpd/data/attrpengantarsekda',
            data: {
                'nousul': $(this).attr('recnousul'),
                '_token': '{!!csrf_token()!!}'
            },
            success: function(html) {
                $('#main_modal .modal-body').html(html);
            }
        });
    })
});
</script>