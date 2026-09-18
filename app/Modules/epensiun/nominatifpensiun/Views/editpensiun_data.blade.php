<?php

    if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4))){

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewver'=>1));

    }else{

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewuser'=>1));

    }

?>

<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/epensiun/nominatifpensiun/updatepensiun" accept-charset="UTF-8">

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
                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">                        
                        <input type="hidden" name="idskpd" id="idskpd" class="idskpd">
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor Rekening </label>
                            <div class="col-sm-7">
                                <span id="attr-usia"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor HP </label>
                            <div class="col-sm-7">
                                <span id="attr-hp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPWP </label>
                            <div class="col-sm-7">
                                <span id="attr-nonpwp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIK </label>
                            <div class="col-sm-7">
                                <span id="attr-noktp"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> ATRIBUT PENSIUN </h3>
                </div>                                                    
                <div class="box-body">
                    <div class="data-attribut data-penetap">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmtpens">TMT pensiun</label>
                            <div class="controls col-sm-7">
                                <input name="tmtpens" value="" id="tmtpens" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>                                                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kedudukan Pegawai</label>
                            <div class="controls col-sm-7 div-disabled">
                                {!! comboJenkedudupeg("idjenkedudupeg","99","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Pensiun</label>
                            <div class="controls col-sm-7">
                                {!! comboJenpens("idjenpens","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="controls col-sm-7">
                                <textarea rows="5" class="form-control" name="keterangan" id="keterangan"></textarea>
                            </div>
                        </div>
                        <tr>
                            <h5 width="25%">ALAMAT SEKARANG</h5>
                            &nbsp;
                        </tr>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="alm" value="" id="alm" maxlength="10" class="form-control" placeholder="Jalan" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrt" value="" id="almrt" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrw" value="" id="almrw" class="form-control" maxlength="2" type="text">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesa" value="" id="almdesa" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkec" value="" id="almkec" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkab" value="" id="almkab" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almprov">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprov" value="" id="almprov" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>
                        
                        <tr>
                            <h5 width="25%">ALAMAT SETELAH PENSIUN</h5>
                            &nbsp;
                        </tr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="almpens" value="" id="almpens" maxlength="255" class="form-control" placeholder="Jalan" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrtpens" value="" id="almrtpens" class="form-control" maxlength="3" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrwpens" value="" id="almrwpens" class="form-control" maxlength="3" type="text" placeholder="00">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesapens" value="" id="almdesapens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkecpens" value="" id="almkecpens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkabpens" value="" id="almkabpens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprovpens" value="" id="almprovpens" maxlength="100" class="form-control" placeholder="" type="text">
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
            </div>

            <div class="col-md-6">
                <div class="box-body">
                    <div class="data-simpan">                        
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
                </div>
            </div>
            
        </div>
    </div> 
</div>

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt, .date, #tmtpens').mask("99-99-9999");
        $('select').select2();

        $.ajax({
            url:'{!!url()!!}/epensiun/nominatifpensiun/editpensiun',
            data: { 'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var reb = $.parseJSON(response);
                var ret = reb.data1;

                $('.data-biodata #attr-nip').html(ret.nip);
                $('.data-biodata #idskpd').html(ret.idskpd);              
                $('.data-biodata #attr-nama').html(ret.nama);
                $('.data-biodata #attr-ttl').html(ret.tmlhr+','+ret.tgllahir_);
                $('.data-biodata #attr-goltmt').html(ret.golpns_txt+' , '+ret.tmtgollama_);
                $('.data-biodata #attr-esltmt').html(ret.esl+' , '+ret.tmteselon_);
                $('.data-biodata #attr-jskpd').html(ret.jabatan+' '+ret.skpd);
                $('.data-biodata #attr-mkerja').html(String(ret.mkskr).substr(0,2)+' tahun '+String(ret.mkskr).substr(-2)+' bulan');
                $('.data-biodata #attr-pendidikan').html(ret.jenjurusan);
                $('.data-biodata #attr-usia').html(String(ret.usia).substr(0,2)+" tahun "+String(ret.usia).substr(2, 2)+" bulan");
                $('.data-biodata #attr-hp').html(ret.hp);
                $('.data-biodata #attr-nonpwp').html(ret.nonpwp);
                $('.data-biodata #attr-noktp').html(ret.noktp);

                $('.data-attribut #tmtpens').val(ret.tmtpens_);
                $('.data-attribut #keterangan').val(ret.keterangan);
                $('.data-attribut #idjenkedudupeg').select2("val", ret.idjenkedudupeg_);
                $('.data-attribut #idjenpens').select2("val", ret.idjenpens_);

                $('.data-attribut #alm').val(ret.almskrpens);
                $('.data-attribut #almrt').val(ret.almrtskrpens);
                $('.data-attribut #almrw').val(ret.almrwskrpens);
                $('.data-attribut #almdesa').val(ret.almdesaskrpens);
                $('.data-attribut #almkec').val(ret.almkecskrpens);
                $('.data-attribut #almkab').val(ret.almkabskrpens);
                $('.data-attribut #almprov').val(ret.almprovskrpens);

                $('.data-attribut #almpens').val(ret.almpens);
                $('.data-attribut #almrtpens').val(ret.almrtpens);
                $('.data-attribut #almrwpens').val(ret.almrwpens);
                $('.data-attribut #almdesapens').val(ret.almdesapens);
                $('.data-attribut #almkecpens').val(ret.almkecpens);
                $('.data-attribut #almkabpens').val(ret.almkabpens);
                $('.data-attribut #almprovpens').val(ret.almprovpens);
                
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

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Pensiun ?',function(a){
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
                            if(html=='4'){
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

        $('#form-edit .div-disabled').css('pointer-events','none');
        $('#form-edit .div-disabled .select2-selection, #simpan .div-disabled input').css('background-color','#ececec');
    });
</script>