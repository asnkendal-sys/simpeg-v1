<section class="content-header">
    <h1>
        Statistik Pegawai<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Statistik ABK</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class=""><a href="{!!url()!!}/epersonal/statistikpegawai"> <i class="fa fa-fw fa-list-ul"></i> STATISTIK PEGAWAI</a></li>
                    @if(session('role_id') < 4)
                        <li class=""><a href="{!!url()!!}/epersonal/statistikpegawai/rekappegawai"> <i class="fa fa-fw fa-list-ul"></i> REKAP PEGAWAI</a></li>
                        <li class=""><a href="{!!url()!!}/epersonal/statistikpegawai/rekappensiun"> <i class="fa fa-fw fa-list-ul"></i> REKAP PENSIUN</a></li>
                        <li class="active"><a href="{!!url()!!}/epersonal/statistikpegawai/statistikabk"> <i class="fa fa-fw fa-list-ul"></i> STATISTIK ABK</a></li>
                        @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        {!! ClaravelHelpers::btnCreate() !!}
        <div class="box-tools pull-right">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
            {!!csrf_field()!!}
            <div class="input-group" style="width: 200px;">
                <input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <br />
    <div class="table-responsive">
        <div class="box-body no-padding">
            <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                <thead class="bg-primary">
                    <tr>
                        <th>Unit Organisasi</th>
                        <th>Bezeting</th>
                        <th>ABK</th>
                        <th>Status</th>
                        <th width="7%">Act.</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($statistikpegawais as $item)
                    <?php
                    $jml_keb = $item->abk - $item->jumlah;
                    ?>
                    <tr>
                        <td>{!! $item->path_short !!}</td>
                        <td>{!! $item->jumlah !!}</td>
                        <td>{!! $item->abk !!}</td>
                        @if($jml_keb>0)
                        <td style="background-color:#FFFF00;">
                            KURANG
                        </td>
                        @elseif($jml_keb==0)
                        <td>
                            SESUAI
                        </td>
                        @else
                        <td style="background-color:#FF0000;">
                            LEBIH
                        </td>
                        @endif
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            <div style="height: 50px; width: 100%;">

            </div>
        </div>
    </div>
    <div class="box-footer clearfix">
        <div class="row">
            <div class="col-sm-6">
                {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
                <?php echo $statistikpegawais->appends(array('search' => Input::get('search')))->render(); ?>
            </div>
        </div>
    </div>
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
    
     // Create overlay div and append to body
        $('body').append('<div id="gform-overlay"><div class="gform-spinner"></div></div>');

        // Add CSS for overlay and spinner
        $('head').append(`
            <style>
                #gform-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    pointer-events: none;
                    visibility: hidden;
                }

                #gform-overlay.active {
                    opacity: 1;
                    pointer-events: all;
                    visibility: visible;
                }

                .gform-spinner {
                    width: 50px;
                    height: 50px;
                    background-image: url('data:image/svg+xml,<svg width="24" height="24" stroke="%23fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>');
                    background-repeat: no-repeat;
                    background-size: 50px;
                    background-position: center center;
                }
            </style>
        `);
    
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change', function() {
            if ($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('ul#myTab').on('click', 'a', function(e) {
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if (n > 0) {} else {
                e.preventDefault();
                e.stopImmediatePropagation();
                preloader = new $.materialPreloader({
                    position: 'top',
                    height: '5px',
                    col_1: '#159756',
                    col_2: '#da4733',
                    col_3: '#3b78e7',
                    col_4: '#fdba2c',
                    fadeIn: 200,
                    fadeOut: 200
                });

                $.ajax({
                    type: 'get',
                    url: $(this).attr('href'),
                    beforeSend: function() {
                        preloader.on();
                    },
                    success: function(data) {
                        preloader.off();
                        $('#utama').html(data);
                    }
                });
            }
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
                            if (html == '9') {
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

        $('#setjadwal').on('click', function(e) {
            e.preventDefault();
            e.preventDefault();
            claravel_modal('Setting Jadwal Pengguna', 'Loading...', 'main_modal');
            $.ajax({
                url: '{{url()}}/administrator/manajemenuser/setting',
                type: 'get',
                success: function(html) {
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('#setuserpeg').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('actval');
            if (id == 1) {
                var text = 'Non aktifkan user pegawai ?';
                var val = 0;
            } else {
                var text = 'Aktifkan user pegawai ?';
                var val = 1;
            }

            bootbox.confirm(text, function(a) {
                if (a == true) {
                    $.ajax({
                        url: '{{url()}}/administrator/manajemenuser/settingpegawai',
                        type: 'post',
                        data: {
                            'usiapens': val,
                            '_token': '{!!csrf_token()!!}'
                        },
                        success: function(html) {
                            preloader.off();
                            if (html == '4') {
                                notification('Aktifasi user pegawai berhasil diubah', 'success');
                                refresh_page();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        })

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
                  $('#gform-overlay').addClass('active');
                    preloader.on();
                },
                success: function(html) {
                $('#gform-overlay').removeClass('active');
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
    });
</script>