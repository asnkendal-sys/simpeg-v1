<?php
    if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4))){

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewver'=>1));

    }else{

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewuser'=>1));

    }

?>

<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikangajiberkala/penetapannominatif/updatekgb" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA </h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 data-biodata">
                        {!!csrf_field()!!}
                        <input type="hidden" name="idkgb" id="idkgb" value="{!!Input::get('idkgb')!!}">
                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">
                        <input type="hidden" name="jnskgb" id="jnskgb" class="jnskgb">
                        <input type="hidden" name="idskpd" id="idskpd" class="idskpd">
                        <input type="hidden" name="idstspeg" id="idstspeg" class="idstspeg">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIP </label>
                            <div class="col-sm-7">
                                <span id="attr-nip"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama </label>
                            <div class="col-sm-7">
                                <span id="attr-nama"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tempat Tanggal Lahir </label>
                            <div class="col-sm-7">
                                <span id="attr-ttl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Golongan - TMT </label>
                            <div class="col-sm-7">
                                <span id="attr-goltmt"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Eselon - TMT </label>
                            <div class="col-sm-7">
                                <span id="attr-esltmt"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jabatan / Unit Kerja </label>
                            <div class="col-sm-7">
                                <span id="attr-jskpd"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Masa Kerja </label>
                            <div class="col-sm-7">
                                <span id="attr-mkerja"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pendidikan Terakhir </label>
                            <div class="col-sm-7">
                                <span id="attr-pendidikan"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Usia </label>
                            <div class="col-sm-7">
                                <span id="attr-usia"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> KP / KGB TERAKHIR </h3>
                </div>
                <div class="box-body">
                    <div class="data-acuan">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="acuan">Dasar </label>
                            <div class="controls col-sm-7">
                                <div class="checkbox">
                                    <?php if(Input::get('idstspeg') == 3){?>
                                    <input name="acuan" value="1" id="acuan1" class="acuan" type="radio"> KGB
                                    <input name="acuan" value="2" id="acuan2" class="acuan" type="radio"> PPPK
                                    <?php }else{?>
                                    <input name="acuan" value="1" id="acuan1" class="acuan" type="radio"> KGB
                                    <input name="acuan" value="2" id="acuan2" class="acuan" type="radio"> KP
                                    <input name="acuan" value="3" id="acuan3" class="acuan" type="radio"> PNS
                                    <input name="acuan" value="4" id="acuan4" class="acuan" type="radio"> CPNS
                                    <?php } ?>
                                    &nbsp; <span id="resacuan"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="golru">Pangkat/Golru KP/KGB</label>
                            <div class="controls col-sm-7">
                            <?php //$idstspeg = '<input type="text" name="idstspeg" id="idstspeg" class="idstspeg">'; ?>
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
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-warning">
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> ATRIBUT KGB </h3>
                </div>
                <div class="box-body">
                    <div class="data-attribut">
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
                            <label class="col-sm-3 control-label" for="gkgbb">Gaji Golru Baru</label>
                            <div class="controls col-sm-7">
                                <input name="gkgbb" value="" id="gkgbb" maxlength="13" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAP KGB </h3>
                </div>
                <div class="box-body">
                    <div class="data-attribut">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jabatan Penetap</label>
                            <div class="controls col-sm-7">
                                {!! comboPenetapsk("idpejab","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Jabatan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="jabpenkgbb" id="jabpenkgbb" placeholder="Nama Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pejabat Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="pejpenkgbb" id="pejpenkgbb" placeholder="Pejabat Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIP Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="nippb" id="nippb" placeholder="Nomor Induk Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gol. Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="golrupb" id="golrupb" placeholder="Golongan Ruang">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="data-penetap">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Berkas</label>
                            <div class="controls col-sm-7">
                                <select id="statususul" name="statususul" class="form-control" required>
                                    <option value="">.: Status Usulan :.</option>
                                    <option value="1">Memenuhi Syarat</option>
                                    <option value="2">Tidak Memenuhi Syarat</option>
                                    <option value="3">Berkas Tidak Lengkap</option>
                                </select>
                            </div>
                        </div>

                        <div id="ftampil2">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="kettms" id="kettms" class="form-control" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="ftampil3">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="ketbtl" id="ketbtl" class="form-control" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="ftampil1">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status Proses</label>
                                <div class="controls col-sm-7">
                                    <select id="statussk" name="statussk" class="form-control" required>
                                        <option value="2">Dalam Proses</option>
                                        <option value="1">Proses Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="ftampil11">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="noskkgbb">No. SK KGB</label>
                                <div class="controls col-sm-7">
                                    <input name="noskkgbb" id="noskkgbb" maxlength="45" class="form-control" type="text" placeholder='Automatis' readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tglskkgbb">Tanggal SK KGB</label>
                                <div class="controls col-sm-7">
                                    <input name="tglskkgbb" value="" id="tglskkgbb" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                </div>
                            </div>
                        </div>

                        <div id='ftampil12'>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status SPT</label>
                                <div class="controls col-sm-7">
                                    <label class="radio" style="padding-left: 15px">
                                        <input name="iscetaksk" id="iscetaksk0" value="0" type="radio"> Belum Cetak SPT
                                    </label>
                                    <label class="radio" style="padding-left: 15px">
                                        <input name="iscetaksk" id="iscetaksk1" value="1" type="radio"> Sudah Cetak SPT
                                    </label>
                                    <label class="radio" style="padding-left: 15px">
                                        <input name="iscetaksk" id="iscetaksk2" value="2" type="radio"> Pembatalan SPT
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>-->

                </div>
            </div>
        </div>
    </div>
</div>

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt, .date').mask("99-99-9999");
        $('select').select2();

        $.ajax({
            url:'{!!url()!!}/kenaikangajiberkala/penetapannominatif/editkgb',
            data: { 'idkgb': "{!!Input::get('idkgb')!!}",'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);

                $('.data-acuan input[name="acuan"][value='+ret.acuan+']').prop('checked',true);
                // $(".data-acuan input[name=acuan]:checked").trigger('click'); //biar ga ketrigger click

                $('.data-acuan #golru').select2("val", ret.golpns);
                $('.data-acuan #tmt').val(ret.tmtkgbl);
                $('.data-acuan #mkgolthn').val(ret.mktkgbl);
                $('.data-acuan #mkgolbln').val(ret.mkbkgbl);
                $('.data-acuan #gaji').val(ret.gkgbl);
                $('.data-acuan #nosk').val(ret.noskkgbl);
                $('.data-acuan #tgsk').val(ret.tglskkgbl);
                $('.data-acuan #pejmen').select2("val", ret.pejpenkgbl);

                $('.data-attribut #tmtkgbb').val(ret.tmtkgbb_);
                $('.data-attribut #mktkgbb').val(ret.mktkgbb);
                $('.data-attribut #mkbkgbb').val(ret.mkbkgbb);
                $('.data-attribut #gkgbb').val(ret.gkgbb);

                $('.data-attribut #pejpenkgbb').val(ret.pejpenkgbb);
                $('.data-attribut #nippb').val(ret.nippb);
                $('.data-attribut #golrupb').val(ret.golrupb);
                $('.data-attribut #jabpenkgbb').val(ret.jabpenkgbb);
                //$('.data-attribut #idpejab').val(ret.idpejab);
                $('.data-attribut #idpejab').select2("val", ret.idpejab);

                $('.data-penetap #noskkgbb').val(ret.noskkgbb);
                if(ret.statususul == 0){
                    $('.data-penetap #statususul').val('');
                }else{
                    $('.data-penetap #statususul').val(ret.statususul);
                }

                if(ret.statussk == 0){
                    $('.data-penetap #statussk').val(2);
                }else{
                    $('.data-penetap #statussk').val(ret.statussk);
                }

                $('.data-penetap #kettms').val(ret.kettms);
                $('.data-penetap #ketbtl').val(ret.ketbtl);
                if(ret.tglskkgbb_ != '00-00-0000') {
                    $('.data-penetap #tglskkgbb').val(ret.tglskkgbb_);
                }else{
                    $('.data-penetap #tglskkgbb').val("{!!date('d-m-Y')!!}");
                }
                $('.data-penetap #statususul').trigger('change');
                $('.data-penetap #statussk').trigger('change');

                $('.data-penetap input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);

                $('.data-biodata #attr-nip').html(ret.nip);
                $('.data-biodata #idskpd').html(ret.kdskpdskr);
                $('.data-biodata #jnskgb').val(ret.jnskgb);
                $('.data-biodata #idstspeg').val(ret.idstspeg);
                $('.data-biodata #attr-nama').html(ret.nama);
                $('.data-biodata #attr-ttl').html(ret.tmplahir+','+ret.tgllahir_);
                $('.data-biodata #attr-goltmt').html(ret.golru+' , '+ret.tmtgollama_);
                $('.data-biodata #attr-esltmt').html(ret.eseloname+' , '+ret.tmteselon_);
                $('.data-biodata #attr-jskpd').html(ret.nmajab+' '+ret.tmpskpdskr);
                $('.data-biodata #attr-mkerja').html(ret.mkthn+' tahun '+ret.mkbln+' bulan');
                $('.data-biodata #attr-pendidikan').html(ret.jurusan);
                $('.data-biodata #attr-usia').html(ret.usiakgb.substr(0, 2)+" tahun "+ret.usiakgb.substr(2, 2)+" bulan");
            }
        });

        $('.data-penetap #statususul').on('change',function(e){
            e.preventDefault();
            if($('.data-penetap #statususul').val() == 1){
                $('.data-penetap #ftampil1').show();
                $('.data-penetap #ftampil2').hide();
                $('.data-penetap #ftampil3').hide();

                $('.data-penetap #statussk').on('change',function(e){
                    e.preventDefault();
                    if($('.data-penetap #statussk').val() == 1){
                        $('.data-penetap #ftampil11').show();
                        $('.data-penetap #ftampil12').show();
                    }else{
                        $('.data-penetap #ftampil11').show();
                        $('.data-penetap #ftampil12').hide();
                    }
                }).trigger('change');
            }else if($('.data-penetap #statususul').val() == 2){
                $('.data-penetap #ftampil1').hide();
                $('.data-penetap #ftampil2').show();
                $('.data-penetap #ftampil3').hide();
                $('.data-penetap #ftampil11').hide();
                $('.data-penetap #ftampil12').hide();
            }else if($('.data-penetap #statususul').val() == 3){
                $('.data-penetap #ftampil1').hide();
                $('.data-penetap #ftampil2').hide();
                $('.data-penetap #ftampil3').show();
                $('.data-penetap #ftampil11').hide();
                $('.data-penetap #ftampil12').hide();
            }else{
                $('.data-penetap #ftampil1').hide();
                $('.data-penetap #ftampil2').hide();
                $('.data-penetap #ftampil3').hide();
                $('.data-penetap #ftampil11').hide();
                $('.data-penetap #ftampil12').hide();
            }
        }).trigger('change');

        $('.data-acuan .acuan').on('click', function(e){
            e.preventDefault();

            var acuan = $('.data-acuan input[name=acuan]:checked').val();
            var idkgb = $('.data-biodata input[name=idkgb]').val();
            var nip = $('.data-biodata input[name=nip]').val();

            $.ajax({
                url: '{!!url()!!}/kenaikangajiberkala/penetapannominatif/acuan',
                type: 'post',
                data:{'acuan': acuan, 'nip': nip, 'idkgb': idkgb, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('.data-acuan #resacuan').html('<i class="fa fa-refresh"></i> Looading..');
                },
                success:function(response){
                    $('.data-acuan #resacuan').html('');
                    var ret = $.parseJSON(response);
                    //$('.data-acuan #golru').val(ret[0].golru);
                    $('.data-acuan #golru').select2("val", ret[0].golru);
                    $('.data-acuan #idstspeg').val(ret[0].idstspeg);
                    $('.data-acuan #tmt').val(ret[0].tmt);
                    $('.data-acuan #mkgolthn').val(ret[0].mkgolthn);
                    $('.data-acuan #mkgolbln').val(ret[0].mkgolbln);
                    $('.data-acuan #gaji').val(ret[0].gaji);
                    $('.data-acuan #nosk').val(ret[0].nosk);
                    $('.data-acuan #tgsk').val(ret[0].tgsk);
                    //$('.data-acuan #pejmen').val(ret[0].pejmen);
                    $('.data-acuan #pejmen').select2("val", ret[0].pejmen);

                    $('.data-acuan input[name="acuan"][value='+ret[0].idacuan+']').prop('checked',true);
                    //$('.data-acuan #mktkgbb').val(ret[0].mkgolthnkgb);
                    //$('.data-acuan #mkbkgbb').val(ret[0].mkgolblnkgb);
                    //$('.data-acuan #gajikgb').val(ret[0].gajikgb);

                    //$('#mdl-editkgb #tmtkgbb').val(ret[0].tmtkgb);
                    //$('#mdl-editkgb #tgskkgb').val(ret[0].tgskkgb);
                    //$('#mdl-editkgb #noskkgbb').val(ret[0].noskkgb);
                    //$('#mdl-editkgb #pejmenkgb').val(ret[0].pejmenkgb);
                    //$('#mdl-editkgb #pejmenkgb').trigger('change');
                }
            });
        });

        $('#form-edit #mktkgbb').on('change', function(e){
            e.preventDefault();
            var mktkgbb = $(this).val();
            var golru = $('#form-edit #golru').val();


        });

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Kenaikan Gaji Berkala ?',function(a){
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
                            if(html==4){
                                notification('Berhasil Disimpan','success');
                                claravel_modal_close('main_modal2');
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
</script>