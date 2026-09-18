<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/pppk/pemberhentiankontrak/updatepppk" accept-charset="UTF-8">

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
                        <input type="hidden" name="idpppk" id="idpppk" value="{!!Input::get('idpppk')!!}">
                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> KONTRAK PPPK TERAKHIR </h3>
                </div>
                <div class="box-body">
                    <div class="data-pppkl">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> NO. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-noskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TGL. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-tmtpppkl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TGL. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-tgskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Golongan </label>
                            <div class="col-sm-7">
                                <span id="attr-golrul"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Masa Kerja </label>
                            <div class="col-sm-7">
                                <span id="attr-mskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gaji PPPK </label>
                            <div class="col-sm-7">
                                <span id="attr-gajil"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-warning">
            <div class="col-md-6">&nbsp;</div>
            <div class="col-md-6 data-attribut">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PEMBERHENTIAN PPPK </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('idgolru', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! comboGolrupppk("idgolru","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                        </div>
                        <div class="col-sm-1" style="margin-top: 7px;">
                            Tahun
                        </div>
                        <div class="col-sm-2">
                            {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                        </div>
                        <div class="col-sm-1" style="margin-top: 7px;">
                            Bulan
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('gaji', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class='input-group'>
                                <span class="input-group-addon">Rp.</span>
                                {!! Form::text('gaji', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bup">TMT Pemberhentian</label>
                        <div class="controls col-sm-7">
                            <input name="bup" value="" id="bup" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text" required>
                        </div>
                    </div>                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bup">Jenis Pemberhentian</label>
                        <div class="controls col-sm-7">
                            {!!PemberhentiankontrakModel::comboJenpensiun('idjenpens','','required')!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bup">Keterangan</label>
                        <div class="controls col-sm-7">
                            <textarea rows="5" cols="6" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan Pemberhentian" ></textarea>                            
                        </div>
                    </div>
                    <div id="xjenispens">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="no_dasar">Tanggal Dasar</label>
                            <div class="controls col-sm-7">
                                <input name="no_dasar" value="" id="no_dasar" class="form-control" placeholder="Nomor Dasar" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tgl_dasar">Tanggal Dasar</label>
                            <div class="controls col-sm-7">
                                <input name="tgl_dasar" value="" id="tgl_dasar" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmt_dasar">TMT Dasar / Tanggal Meninggal</label>
                            <div class="controls col-sm-7">
                                <input name="tmt_dasar" value="" id="tmt_dasar" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
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
            url:'{!!url()!!}/pppk/pemberhentiankontrak/editpppk',
            data: { 'idpppk': "{!!Input::get('idpppk')!!}",'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);
                $('.data-biodata #attr-nip').html(ret.nip);
                $('.data-biodata #attr-nama').html(ret.nama);
                $('.data-biodata #attr-ttl').html(ret.tmlhr+', '+ret.tglhr_);
                $('.data-biodata #attr-goltmt').html(ret.golrul+' , '+ret.tmtawall_);
                $('.data-biodata #attr-jskpd').html(ret.jab+' '+ret.skpd);
                $('.data-biodata #attr-mkerja').html(ret.thkerjal+' tahun '+ret.blkerjal+' bulan');
                $('.data-biodata #attr-pendidikan').html(ret.tkpendid+', '+ret.jenjurusan);

                $('.data-pppkl #attr-noskl').html(ret.noskl);
                $('.data-pppkl #attr-tmtpppkl').html(ret.tmtawall_+' sd '+ret.tmtakhirl_);
                $('.data-pppkl #attr-tgskl').html(ret.tgskl_);
                $('.data-pppkl #attr-golrul').html(ret.golrul+' , '+ret.tmtawall_);
                $('.data-pppkl #attr-mskl').html(ret.thkerjal+' tahun '+ret.blkerjal+' bulan');
                $('.data-pppkl #attr-gajil').html('Rp. '+ret.gajil.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

                $('.data-attribut #bup').val(ret.bup_);
                $('.data-attribut #idgolru').select2('val',ret.idgolru);
                $('.data-attribut #idjenpens').select2('val',ret.idjenpens);
                $('.data-attribut #keterangan').val(ret.keterangan);
                $('.data-attribut #thkerja').val(ret.thkerja);
                $('.data-attribut #blkerja').val(ret.blkerja);
                $('.data-attribut #gaji').val(ret.gaji);

                $('.data-attribut #no_dasar').val(ret.no_dasar);
                $('.data-attribut #tgl_dasar').val(ret.tgl_dasar_);
                $('.data-attribut #tmt_dasar').val(ret.tmt_dasar_);
            }
        });

        // $('#xjenispens').hide();
        $('.data-attribut #idjenpens').on('change', function(){
            var idjenpens = $('.data-attribut #idjenpens').val();
            if (idjenpens != '1') {                                                            
                $('#xjenispens').fadeIn();                        
                $('#no_dasar,#tgl_dasar,#tmt_dasar').prop('required', true);
            }else{                                                        
                $('#xjenispens').fadeOut();                    
                $('#no_dasar,#tgl_dasar,#tmt_dasar').prop('required', false);
                $('#no_dasar,#tgl_dasar,#tmt_dasar').val('');  
            }
        });

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Pemberhentian PPPK ?',function(a){
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
    });
</script>