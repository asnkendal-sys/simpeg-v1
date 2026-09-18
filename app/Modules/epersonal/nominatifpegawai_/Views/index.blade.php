<section class="content-header" xmlns="http://www.w3.org/1999/html">
    <h1>
        Nominatif Pegawai<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Pegawai</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai','target'=>'_blank')) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idjenjab', 'Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboJenjab("idjenjab","","") !!}
                                </div>
                            </div>
                            <span id="xjabatan1">
                                <div class="form-group">
                                    {!! Form::label('idtkjabfung', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! comboJabfung2("idtkjabfung","","") !!}
                                    </div>
                                </div>
                            </span>
                            <span id="xtingkatan">
                                <div class="form-group">
                                    {!! Form::label('idjabfung', 'Tingkat Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7" id="xjabatan">
                                        <select name="idjabfung" class="idjabfung" style="width: 100%"></select>
                                    </div>
                                </div>
                            </span>
                            <span id="xjabatan2">
                                <div class="form-group">
                                    {!! Form::label('idjabfungum', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <select type="hidden" id="idjabfungum" style="width: 100%" data-placeholder=".: Pilihan :." name="idjabfungum"/></select>
                                    </div>
                                </div>
                            </span>
                            <div class="form-group">
                                {!! Form::label('idgolru', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-3">
                                    {!! comboGolru("idgolru","","") !!}
                                </div>
                                <div class="col-sm-1" style="margin-top: 5px;">
                                    s/d
                                </div>
                                <div class="col-sm-3">
                                    {!! comboGolru("idgolru2","","") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <label class="radio-inline">
                                        <input type="radio" checked="" value="1" id="opt1" name="opt"> Keatas
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="2" id="opt2" name="opt"> Kebawah
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="3" id="opt3" name="opt"> Antara
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idesl', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboEselon("idesl","","") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboJenkel("idjenkel","","") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboAgama("idagama","","") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idtkpendid', 'Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboTkpendidikan("idtkpendid","","") !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idjenkedudupeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboJenkedudupeg("idjenkedudupeg","","") !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tampilan', 'Tampilan Data:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <label class="checkbox"><input type="checkbox" value="idjenkel" name="idjenkel2"> Jenis Kelamin</label>
                                    <label class="checkbox"><input type="checkbox" value="idagama" name="idagama2"> Agama</label>
                                    <label class="checkbox"><input type="checkbox" value="idesljbt" name="idesljbt2"> Eselon</label>
                                    <label class="checkbox"><input type="checkbox" value="idgolrupkt" name="idgolrupkt2"> Golongan</label>
                                    <label class="checkbox"><input type="checkbox" value="tmtpkt" name="tmtpkt2"> Golongan TMT</label>
                                    <label class="checkbox"><input type="checkbox" value="idjenjab" name="idjenjab2"> Jenis Jabatan</label>
                                    <label class="checkbox"><input type="checkbox" value="idtkpendid" name="idtkpendid2"> Tingkat Pendidikan</label>
                                    <label class="checkbox"><input type="checkbox" value="idjenjurusan" name="idjenjurusan2"> Jurusan</label>
                                    <label class="checkbox"><input type="checkbox" value="sekolah" name="sekolah2"> Nama Sekolah</label>
                                    <label class="checkbox"><input type="checkbox" value="thijaz" name="thijaz2"> Tahun Lulus</label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('urutan', 'Urut Berdasarkan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <label class="radio">
                                        <input type="radio" value="1" id="optionsRadios1" name="urutan"> Gol. Ruang
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="2" id="optionsRadios2" name="urutan"> NIP
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="3" id="optionsRadios3" name="urutan"> Nama
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="4" id="optionsRadios4" name="urutan"> Usia
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('sorting', 'Model Urutan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <label class="radio">
                                        <input type="radio" value="asc" id="optionsRadios11" name="order"> Ascending
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="desc" id="optionsRadios12" name="order"> Discending
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-offset-3 col-sm-12">
                                    <button class="btn btn-success" type="button" id="prev-nominatif"><i class="fa fa-list-ul"></i> Lihat Nominatif</button>
                                    &nbsp;&nbsp;
                                    <button class="btn btn-success" type="button" id="cetak-nominatif"><i class="fa fa-print"></i> Cetak Nominatif</button>
                                    &nbsp;&nbsp;
                                    <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-12">
                <div id="result" class="table-responsive"></div>
            </div>
        </div>
    </div>
</section>

<script>
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }

    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('#buat').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#tabel').on('click','#hapus',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            $this.closest('tr').fadeOut(300,function(){
                                $(this).remove();
                            });
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/edit',
                        type : 'get',
                        data:'id=' + $this.attr('recid'),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });
        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/delete',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            iki.find('input[type=checkbox]').each(function (t){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').fadeOut(100)                                        
                                }
                            });
                            $('#deleteall').fadeOut(300);
                        }
                    });
                }
            });            
        });

        $('#xjabatan1').hide();
        $('#xjabatan2').hide();
        $('#xtingkatan').hide();

        $('#idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            if(idjenjab == 2){
                $('#xjabatan1').show();
                $('#xtingkatan').show();
                $('#xjabatan2').hide();
            }else if(idjenjab == 3){
                $('#xjabatan1').hide();
                $('#xtingkatan').hide();
                $('#xjabatan2').show();
                autoComplete('#idjabfungum', '{{url()}}/epersonal/biodata/jabfungum', '.: Pilihan :.', null, '', '', '');
            }else{
                $('#xjabatan1').hide();
                $('#xtingkatan').hide();
                $('#xjabatan2').hide();
            }
        });

        $('#idtkjabfung').on('change', function(e){
            e.preventDefault();
            var idtkjabfung = $(this).val();
            $.ajax({
                url : '{!!url()!!}/epersonal/nominatifpegawai/tkjabfung',
                type : 'post',
                data : {'idtkjabfung': idtkjabfung, '_token': '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#xjabatan').html('<i class="fa fa-spinner"></i> Loading...');
                },
                success:function(response){
                    $('#xjabatan').html(response);
                    $('select').select2();
                }
            });
        });

        $('#prev-nominatif').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/epersonal/nominatifpegawai/data/nominatif',
                type : 'post',
                data : $('#nominatif-pegawai').serialize(),
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Loading...');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });

        $('#cetak-nominatif').on('click', function(e){
            e.preventDefault();
            $('#nominatif-pegawai').attr("action", "{!!url()!!}/epersonal/nominatifpegawai/print/nominatif");
            $('#nominatif-pegawai').submit();
        });

        $('#excel-nominatif').on('click', function(e){
            e.preventDefault();
            $('#nominatif-pegawai').attr("action", "{!!url()!!}/epersonal/nominatifpegawai/excel/nominatif");
            $('#nominatif-pegawai').submit();
            /*cetak_excel('result');*/
        });
    });
</script>
