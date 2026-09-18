<section class="content-header">
    <h1>
        Buat Penetapan Non Nominatif Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Penetapan Non Nominatif</a></li>
        <li class="active">Buat Penetapan Non Nominatif Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                <ul style="padding-left: 15px">
                    <li>Ketikkan NIP / Nama pada kolom isian, Kemudian akan tampil detail pegawai</li>
                    <li>Isikan atribut Kenaikan Gaji Berkala</li>
                    <li>Untuk menyimpan nominatif Kenaikan Gaji Berkala pilih tombol simpan</li>
                </ul>

                " Penetapan non nominatif digunakan melakukan penetapan Kenaikan Gaji Berkala dengan ketentuan PNS yang akan naik gaji berkalanya tidak ada di daftar nominatif "
            </div>

            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">

            <div class="row-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="nip">NIP / Nama</label>
                                <div class="controls col-sm-7">
                                    <select name="nip" class="form-control nip" id="nip" style="width: 100%"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="nip">&nbsp;</label>
                                <div class="controls col-sm-7">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="accordion-heading">
                            <p>
                                <div class="box-header with-border">
                                    <b class="box-title"><small>BIODATA</small></b>
                                </div>
                            </p>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="nama">Nama</label>
                                <div class="controls col-sm-7">
                                    <p><input readonly="" id="gdp" name="gdp" class="form-control" maxlength="20" placeholder="Ex: Ir." style="width:150px" type="text"></p>
                                    <p><input readonly="" id="nama" name="nama" class="form-control" maxlength="50" placeholder="Nama Lengkap" type="text"></p>
                                    <p><input readonly="" id="gdb" name="gdb" class="form-control" maxlength="20" placeholder="Ex: S.Kom,ST" style="width:150px" type="text"></p>
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="tmlhr">Tempat / Tgl Lahir</label>
                                <div class="col-sm-4">
                                    <select name="tmlhr" class="form-control awal" id="tmlhr" style="width: 100%"></select>
                                </div>
                                <div class="col-sm-3">
                                    <input name="tglhr" readonly="" value="" id="tglhr" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="jenkel">Jenis Kelamin</label>
                                <div class="controls col-sm-7">
                                    <div class="caption" id="jenkel">
                                        <div class="checkbox">
                                            <input readonly="" name="idjenkel" value="1" id="idjenkel1" checked="" type="radio"> Laki-laki
                                            <input readonly="" name="idjenkel" value="2" id="idjenkel2" type="radio"> Perempuan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="agama">Agama</label>
                                <div class="controls col-sm-7">
                                    {!! comboAgama("idagama","","") !!}
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="agama">Status Pegawai</label>
                                <div class="controls col-sm-7">
                                    {!! comboStspns("idstspeg","","") !!}
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="stskawin">Status Marital</label>
                                <div class="controls col-sm-7">
                                    {!! comboStsmarital("idstskawin","","") !!}
                                </div>
                            </div>
                            <div class="form-group div-disabled">
                                <label class="col-sm-3 control-label" for="alm">Alamat</label>
                                <div class="controls col-sm-7">
                                    <div class="caption" for="alm">
                                        <textarea name="alm" id="alm" maxlength="150" class="form-control" placeholder="Ex: Jl. Pemuda No. 12 RT 1 RW 2" readonly=""></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end of col-md-5 -->

                    <div class="col-md-6">
                        <p>
                            <div class="box-header with-border">
                                <b class="box-title"><small>CPNS</small></b>
                            </div>
                        </p>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="idgolrucpn">Gol. Ruang</label>
                            <div class="controls col-sm-7">
                                {!! comboGolru("idgolrucpn","","",3) !!}
                            </div>
                        </div>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="tmtcpn">TMT</label>
                            <div class="controls col-sm-7">
                                <div class="caption">
                                    <input name="tmtcpn" value="" id="tmtcpn" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" readonly="" type="text">
                                </div>
                            </div>
                        </div>

                        <p>
                            <div class="box-header with-border">
                                <b class="box-title"><small>PNS</small></b>
                            </div>
                        </p>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="idgolrupns">Gol. Ruang</label>
                            <div class="controls col-sm-7">
                                {!! comboGolru("idgolrupns","","",3) !!}
                            </div>
                        </div>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="tmtpns">TMT</label>
                            <div class="controls col-sm-7">
                                <div class="caption">
                                    <input name="tmtpns" value="" id="tmtpns" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" readonly="" type="text">
                                </div>
                            </div>
                        </div>

                        <p>
                            <div class="box-header with-border">
                                <b class="box-title"><small>PANGKAT TERAKHIR</small></b>
                            </div>
                        </p>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="idgolrupkt">Gol. Ruang</label>
                            <div class="controls col-sm-7">
                                {!! comboGolru("idgolrupkt","","",3) !!}
                            </div>
                        </div>
                        <div class="form-group div-disabled">
                            <label class="col-sm-3 control-label" for="tmtpkt">TMT</label>
                            <div class="controls col-sm-7">
                                <div class="caption">
                                    <input name="tmtpkt" value="" id="tmtpkt" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" readonly="" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group div-disabled">
                            {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboSkpdunit("kdunit","","") !!}
                            </div>
                        </div>
                        <div class="form-group div-disabled">
                            {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">&nbsp;</label>
                            <div class="controls col-sm-7">
                                &nbsp;
                            </div>
                        </div>
                    </div><!-- end of col-md-5 -->

                    <div class="col-md-6">
                        <div class="accordion-heading">

                            <p>
                                <div class="box-header with-border">
                                    <b class="box-title"><small>KP / KGB TERKHIR</small></b>
                                </div>
                            </p>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="idacuan">Dasar </label>
                                <div class="controls col-sm-7">
                                    <div class="checkbox">
                                        <input name="idacuan" value="1" id="idacuan1" class="idacuan" type="radio"> KGB
                                        <input name="idacuan" value="2" id="idacuan2" class="idacuan" type="radio"> KP
                                        <input name="idacuan" value="3" id="idacuan3" class="idacuan" type="radio"> PNS
                                        <input name="idacuan" value="4" id="idacuan4" class="idacuan" type="radio"> CPNS
                                        &nbsp; <span id="resacuan"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="golru">Pangkat/Golru KP/KGB</label>
                                <div class="controls col-sm-7">
                                    {!! comboGolru("golru","","",3) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tmt">TMT KP/KGB</label>
                                <div class="controls col-sm-7">
                                    <input name="tmt" value="" id="tmt" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="mkgolthn">Masa Kerja</label>
                                <div class="col-sm-2">
                                    <input name="mkgolthn" value="" id="mkgolthn" class="form-control" maxlength="2" type="text">
                                </div>
                                <div class="col-sm-1" style="margin-top: 7px;">
                                    Tahun
                                </div>
                                <div class="col-sm-2">
                                    <input name="mkgolbln" value="" id="mkgolbln" class="form-control" maxlength="2" type="text">
                                </div>
                                <div class="col-sm-1" style="margin-top: 7px;">
                                    Bulan
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="gaji">Gaji Golru</label>
                                <div class="controls col-sm-7">
                                    <input name="gaji" value="" id="gaji" maxlength="13" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="nosk">No. SK KP/KGB</label>
                                <div class="controls col-sm-7">
                                    <input name="nosk" value="" id="nosk" maxlength="45" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tgsk">Tanggal SK KP/KGB</label>
                                <div class="controls col-sm-7">
                                    <input name="tgsk" value="" id="tgsk" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="pejmen">Pejabat Penetap</label>
                                <div class="controls col-sm-7">
                                    {!! comboPenetapsk("pejmen","","") !!}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end of col-md-5 -->

                    <div class="col-md-6">

                        <p>
                            <div class="box-header with-border">
                                <b class="box-title"><small>KGB BARU</small></b>
                            </div>
                        </p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmtkgbb">TMT KGB</label>
                            <div class="controls col-sm-7">
                                <input name="tmtkgbb" value="" id="tmtkgbb" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mktkgbb">Masa Kerja</label>
                            <div class="col-sm-2">
                                <input name="mktkgbb" value="" id="mktkgbb" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkbkgbb" value="" id="mkbkgbb" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="gajikgb">Gaji Golru</label>
                            <div class="controls col-sm-7">
                                <input name="gajikgb" value="" id="gajikgb" maxlength="13" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="noskkgbb">No. SK KGB</label>
                            <div class="controls col-sm-7">
                                <input name="noskkgbb" value="" id="noskkgbb" maxlength="45" class="form-control" type="text" placeholder="Automatis" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tgskkgb">Tanggal SK KGB</label>
                            <div class="controls col-sm-7">
                                <input name="tgskkgb" value="" id="tgskkgb" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>
                    </div><!-- end of col-md-5 -->

                </div>

            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-7">
                        {!! ClaravelHelpers::btnSave() !!}
                        &nbsp;
                        &nbsp;
                        {!! ClaravelHelpers::btnCancel() !!}
                    </div>
                </div> 
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
</section>

<script>
    function refresh_page(){
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) -1;
        unset ($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/'.$index.'";';
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
        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");
        $('#simpan .div-disabled').css('pointer-events','none');
        $('#simpan .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color','#ececec');
        autoCompleteimg('#simpan #nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        $('#simpan #kdunit').on('change', function(e){
            e.preventDefault();
            autoComplete('#simpan #idskpd', '{{url()}}/epersonal/biodata/skpdunit', '.: Pilihan :.', null, $(this).val(), $(this).find(":selected").text(),  $(this).val());
        });

        $('#simpan #nip').on('change', function(e){
            e.preventDefault();
            loadBiodata2();
        });

        $('#simpan .idacuan').on('click', function(e){
            e.preventDefault();
            var idacuan = $('input[name=idacuan]:checked').val();
            var nip = $("#simpan .nip").val();

            //var idacuan = $(this).val();
            //alert(idacuan+" Test "+nip);

            $.ajax({
                url: '{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/acuan',
                type: 'post',
                data:{'idacuan': idacuan, 'nip': nip, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#resacuan').html('<i class="fa fa-refresh"></i> Looading..');
                },
                success:function(response){
                    $('#resacuan').html('');
                    var ret = $.parseJSON(response);
                    $('#golru').select2('val',ret[0].golru);
                    $('#tmt').val(ret[0].tmt);
                    $('#mkgolthn').val(ret[0].mkgolthn);
                    $('#mkgolbln').val(ret[0].mkgolbln);
                    $('#gaji').val(ret[0].gaji);
                    $('#nosk').val(ret[0].nosk);
                    $('#tgsk').val(ret[0].tgsk);
                    $('#pejmen').select2('val',ret[0].pejmen);

                    /*$('#tmtkgbb').val(ret[0].tmtkgb);
                    $('#mktkgbb').val(ret[0].mkgolthnkgb);
                    $('#mkbkgbb').val(ret[0].mkgolblnkgb);*/
                    $('#gajikgb').val(ret[0].gajikgb);
                    $('#tgskkgb').val(ret[0].tgskkgb);
                    $('#noskkgbb').val(ret[0].noskkgb);
                    $('input[name=idacuan][value='+ret[0].idacuan+']').prop('checked',true);
                }
            });
        });

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });

    function loadBiodata2(){
        var nip = $('#simpan #nip').val();
        autoComplete('#simpan #tmlhr', '{{url()}}/epersonal/biodata/tempatlahir', '.: Pilihan :.', null, '', '', '');

        $.ajax({
            url  : '{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/detailpegawai',
            type : 'POST',
            data : {'nip': nip, '_token' : '{!!csrf_token()!!}'},
            beforeSend: function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tglhr","tmtjbt","tgskcpn","tmtcpn","tmtpns","tmtpkt");
                var arraytext = new Array("skpdunit");
                var arrayradio = new Array("idjenkel","idacuan");
                var arrselect2 = new Array("idagama","idstspeg","idstskawin", "idskpd","kdunit","idgolrucpn","idgolrupns","idgolrupkt");

                if(ret){
                    $('#simpan #tmtkgbb').val(ret.tmtkgbnext);
                    $('#simpan #mktkgbb').val(ret.mkgolthnkgb);
                    $('#simpan #mkbkgbb').val(ret.mkgolblnkgb);
                    for(attrname in ret){
                        $('#simpan #id').val(ret.nip);
                        $('#simpan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arraytext)!=-1){
                            $('#'+attrname).html('(<i class="fa fa-fw fa-map-marker"></i>'+ret[attrname]+')');
                        }
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                        }
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#simpan #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#simpan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }

                    $('#simpan .awal').attr('disabled', false);
                    $("#simpan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/"+ret.photo+"" );
                    $('#simpan #changeimage').fadeIn();
                    $("#simpan #idskpd").data('select2').trigger('select', {
                        data: {"id":ret.idskpd,"text":ret.skpd}
                    });

                    $("#simpan #tmlhr").data('select2').trigger('select', {
                        data: {"id":ret.tmlhr,"text":ret.tmlhr}
                    });

                    if(ret.idjenjab == 1){
                        $('#simpan .xjabstruk').fadeIn();
                    }else if(ret.idjenjab == 2){
                        $('#simpan .xjabfung').fadeIn();
                    }else{
                        $('#simpan .xjabstruk, #simpan .xjabfung').fadeOut();
                    }

                    if(ret.isguru == 1){
                        $('#simpan .xisguru').fadeIn();
                    }else if(ret.isguru == 2){
                        $('#simpan .xisdokter').fadeIn();
                    }else{
                        $('#simpan .xisguru, #simpan .xisdokter').fadeOut();
                    }

                    $('#simpan .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color','#ececec');

                    $("#simpan input[name=idacuan]:checked").trigger('click');
                }else{
                    $('#simpan .awal').attr('disabled', true);
                    $('#simpan #myTab li').addClass('disabled');
                    $('#simpan #myTab li').css({ 'pointer-events': 'none'});
                    $('#simpan #myTab li, #simpan .tab-pane').removeClass('active');

                    $("#simpan").find('input:text, input:password, input:file, select, textarea').val('');
                    $("#simpan").find('#idagama, #idstspeg, #idstskawin, #idgoldarah, #kdunit, #idjenkepeg, #idjenkedudupeg, #idjenjab, #pejmencpn, #idgolrucpn, #pejmenpns, #idgolrupns, #pejmenpkt, #idgolrupkt, #pejmenkgb, #idgolkgb, #idtkpendidawal, #idtkpendid, #idtugasgurudosen').val('').trigger('change');
                    $("#simpan").find('#tmlhr, #idskpd, #idjabjbt, #idjabfung, #idjabfungum, #idjenjurusanawal, #idjenjurusan, #idmatkulpel').data('select2').trigger('select', {
                        data: {"id":"","text":""}
                    });
                    $('#simpan #changeimage, #simpan .alert-biodata').fadeOut();
                    $("#skpdunit").html('');
                    $("#simpan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/default.jpg" );
                    $("#simpan").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                    $('#simpan .xjabstruk, #simpan .xjabfung, #simpan .xisguru, #simpan .xisdokter').fadeOut();
                }
            }
        });
    }
</script>
