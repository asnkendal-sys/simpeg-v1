<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/pppk/perpanjangankontrak/updatepppk" accept-charset="UTF-8">

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
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PERPANJANGAN PPPK </h3>
                </div>
                <div class="box-body">
                    <div class="alert-danger status_berkas"></div>
                    <div class="form-group">
                        {!! Form::label('status', 'Status Usulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <label class="radio-inline">
                                <input type="radio" class="status" name="status" id="status" required value="1" data-toggle="tooltip" data-placement="top" data-original-title="Setujui Diusulkan"> Disulkan
                            </label>
                            
                            <label class="radio-inline">
                                <input type="radio" class="status" name="status" id="status" required value="2" data-toggle="tooltip" data-placement="top" data-original-title="Tidak Diusulkan"> Tidak Diusulkan
                            </label>
                        </div>
                    </div>                    
                    <div class="form-group xstatus_keterangan">
                        {!! Form::label('status_keterangan', 'Status Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <textarea rows="4" cols="6" name="status_keterangan" id="status_keterangan" class="form-control status_keterangan" placeholder="Keterangan Jika Tidak Diusulkan" ></textarea>
                        </div>
                    </div>
                    <span class="xstatus">
                        <div class="form-group">
                            {!! Form::label('tmtawal', 'Masa Perjanjian Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtawal', null, array('class'=> 'form-control date', 'id' => 'tmtawal', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                s.d
                            </div>
                            <div class="col-sm-3">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtakhir', null, array('class'=> 'form-control date', 'id' => 'tmtakhir', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

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

        $('#form-edit .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('.xstatus_keterangan', '.xstatus').hide();
        $('#form-edit .status').on('change', function() {            
            if ($(this).is(':checked')) {
                let status = $(this).val();
                var nip = $('#nip').val();
                if(status == 2){
                    $('.status_berkas').html('');
                    $('.xstatus').fadeOut();
                    $('.xstatus_keterangan').fadeIn();                    
                    $('#status_keterangan').prop('required', true);
                }else{                        
                    cekBerkas(nip);
                    $('.status_keterangan').val('');
                    $('.xstatus').fadeIn();
                    $('.xstatus_keterangan').fadeOut();                    
                    $('#status_keterangan').prop('required', false);
                }
            }
        });

        $.ajax({
            url:'{!!url()!!}/pppk/perpanjangankontrak/editpppk',
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

                $('.data-attribut #tmtawal').val(ret.tmtawal_);
                $('.data-attribut #tmtakhir').val(ret.tmtakhir_);
                $('.data-attribut #idgolru').select2('val',ret.idgolru);
                $('.data-attribut #thkerja').val(ret.thkerja);
                $('.data-attribut #blkerja').val(ret.blkerja);
                $('.data-attribut #gaji').val(ret.gaji);
                $('.data-attribut #status_keterangan').val(ret.status_keterangan);
                $('.data-attribut input[name=status][value='+ret.status+']').prop('checked',true);
                $('#form-edit .status').trigger('change');
            }
        });

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Perpanjangan PPPK ?',function(a){
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

    function cekBerkas(nip){
        $.ajax({
            url : '{{url('')}}/pppk/perpanjangankontrak/cekberkas',
            type : 'post',
            data : {
                'nip': nip,                         
                '_token': '{!!csrf_token()!!}'
            },
            success:function(html){
                if(html!=''){
                    $('.status').prop('checked', false);
                    bootbox.alert('<b>Usulan tidak dapat diproses karena :</b> <br> '+html+' <br> Mohon melengkapi berkas usulan pada E-File - Menu Layanan.');
                    $('.status_berkas').html(html);
                }else{
                    $('.status_berkas').html('');
                }
            }
        });
    }
</script>