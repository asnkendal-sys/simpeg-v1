<section class="content-header">
    <h1>
        SK Mutasi Dalam OPD<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">skmutasidalamopd</li>
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
                                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
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
                                <div class="text-center">JABATAN LAMA PADA OPD</div>
                            </th>
                            <th colspan="2">
                                <div class="text-center">JABATAN BARU PADA OPD</div>
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
                        $x = (!empty(Input::get('page'))) ? ((Input::get('page') - 1) * 25) : 0;
                        ?>
                        @foreach ($skmutasidalamskpds as $skmutasidalamskpd)
                        <?php
                        $x++;
                        $n++;
                        $arr[$n] = $skmutasidalamskpd->nousul;
                        if ($arr[$n] != $arr[$n - 1]) {
                        ?>
                            <tr>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-left">
                                        NOMOR USULAN : {{$skmutasidalamskpd->nousul}}&nbsp;
                                        <i class="fa fa-calendar"></i>
                                        <?php echo date("d-m-Y", strtotime($skmutasidalamskpd->tglusul)) ?>
                                        &nbsp;
                                        <?php echo "||&nbsp;" . getskpdgroup(substr($skmutasidalamskpd->idskpd, 0, 2)); ?>&nbsp;
                                        <br>
                                    </div>
                                </th>
                                <th style="position:relative;" colspan="6">
                                    <div class="text-right">
                                        &nbsp;<a href="javascript::void(0)" target="_blank" class="nokolektif" recnousul="{!!$skmutasidalamskpd->nousul!!}" act="pengantar" title="Cetak Surat Pengantar"><i class="fa fa-pencil"> No Kolektif</i></a> |

                                        &nbsp;<a href="{!!url()!!}/emutasi/skmutasidalamskpd/cetak/skperintahkolektif/{!!$skmutasidalamskpd->nousul!!}" target="_blank" class="" act="" title="Cetak Surat Perintah Kolektif"><i class="fa fa-print"> SK Kolektif</i></a> |

                                        &nbsp;<a href="#" class="attrnominatif" recnousul="{!!$skmutasidalamskpd->nousul!!}" act="nominatif" title="Cetak Lampiran Nominatif"><i class="fa fa-list">
                                                Nominatif</i></a> |


                                    </div>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <center>{!! $x !!}</center>
                            </td>
                            <td>{!!$skmutasidalamskpd->nip!!}<br>{!!$skmutasidalamskpd->namalengkap!!}
                                <a title="popdetil" href="javascript:void(0)"></a><br>
                                <div class="text-right" style="position:relative">
                                    @if($skmutasidalamskpd->iscetaksk == 1)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#ffcc00;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @elseif($skmutasidalamskpd->iscetaksk == 2)
                                    <div style="position:absolute;right:-3px;top:-6px;color:#000000;">
                                        <i class="glyphicon glyphicon-star" title="Sudah Cetak SK"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>{!!$skmutasidalamskpd->golru!!}<br>{!!$skmutasidalamskpd->tmtpkt!!}</td>
                            <td>{!!$skmutasidalamskpd->tkpendid!!}<br>{!!$skmutasidalamskpd->jenjurusan!!}</td>
                            <td>{!!$skmutasidalamskpd->skpdlama!!}</td>

                            <td>{!!$skmutasidalamskpd->jabatan!!}<br>{!!$skmutasidalamskpd->tmtjbt!!}</td>
                            <td>{!!$skmutasidalamskpd->skpdbaru!!}</td>
                            <td>{!!$skmutasidalamskpd->jabatanbaru!!}</td>
                            <td>
                                <div align="center">
                                    @if($skmutasidalamskpd->statususul==1)
                                    <span style="color:green">
                                        <i class="glyphicon glyphicon-ok" title="Memenuhi Syarat" />
                                        <span>
                                            @elseif($skmutasidalamskpd->statususul==2)
                                            <span style="color:red">
                                                <i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat" />
                                            </span>
                                            @elseif($skmutasidalamskpd->statususul==3)
                                            <span style="color:orange">
                                                <i class="glyphicon glyphicon-exclamation-sign" title="Berkas Tidak Lengkap" />
                                            </span>
                                            @else
                                            -
                                            @endif
                                </div>
                            </td>
                            <td>
                                <div align="center">
                                    @if($skmutasidalamskpd->statususul=='1' && $skmutasidalamskpd->statussk=='2')
                                    <span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses" /><span>
                                            @elseif($skmutasidalamskpd->statussk=='1')
                                            <span style="color:green"><i class="glyphicon glyphicon-ok" title="Selesai diproses" /></span>
                                            @else
                                            -
                                            @endif
                                </div>
                            </td>
                            <td>
                                @if(($skmutasidalamskpd->statususul == 1) and ($skmutasidalamskpd->statussk == 1))
                                @if($skmutasidalamskpd->idjenjab == 3)
                                <a href="<?php echo url() . "/emutasi/skmutasidalamskpd/cetak/skperintah/" . $skmutasidalamskpd->nousul . "/" . $skmutasidalamskpd->nip ?>" target="blank" title="Cetak Surat Perintah"><i class="fa fa-print"></i></a>
                                @else
                                <a href="<?php echo url() . "/emutasi/skmutasidalamskpd/cetak/skperintahfungsional/" . $skmutasidalamskpd->nousul . "/" . $skmutasidalamskpd->nip ?>" target="blank" title="Cetak Surat Perintah"><i class="fa fa-print"></i></a>
                                @endif
                                @else
                                <a href="javascript:void(0)" title="SK Perintah Belum Selesai Diproses" style="color: red"><i class="fa fa-print"></i></a>
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
                <div class="col-sm-6">&nbsp;</div>
                <div class="col-sm-6">
                    <?php echo $skmutasidalamskpds->appends(array('search' => Input::get('search')))->render(); ?>
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
                    <span style="color:red"><i class="glyphicon glyphicon-remove" title="Tidak Memenuhi Syarat" /></span> Tidak Memenuhi Syarat<br>
                </td>
                <td>
                    <span style="color:orange"><i class="glyphicon glyphicon-exclamation-sign" title="Berkas Tidak Lengkap" /></span> Berkas Tidak Lengkap<br>
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

        $('#buat').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
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

            claravel_modal('Atribut Dokumen SK Kolektif', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/emutasi/skmutasidalamskpd/data/nokolektif',
                data: {
                    'nousul': $(this).attr('recnousul'),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('.attrpengantar').on('click', function(e) {
            e.preventDefault();

            claravel_modal('Atribut Dokumen', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/emutasi/skmutasidalamskpd/data/attrpengantar',
                data: {
                    'nousul': $(this).attr('recnousul'),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('.attrnominatif').on('click', function(e) {
            e.preventDefault();

            claravel_modal('Atribut Dokumen', 'Loading...', 'main_modal');
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/emutasi/skmutasidalamskpd/data/attrnominatif',
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