<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saversaudara", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rsaudara')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama', 'Nama Saudara:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nama', null, array('class'=> 'form-control', 'placeholder'=>'Nama Saudara')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <label class="radio-inline">
                                    <input type="radio" name="idjenkel" id="idjenkel1" value="1"> Laki-laki
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="idjenkel" id="idjenkel2" value="2"> Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('stssaudara', 'Status Saudara:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboJnssaudara("stssaudara","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmlhr', 'Tempat Lahir:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tmlhr', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Lahir')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tglhr', 'Tgl. Lahir:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tglhr', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('peker', 'Pekerjaan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('peker', null, array('class'=> 'form-control', 'placeholder'=>'Pekerjaan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ket', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('ket', null, array('class'=> 'form-control', 'placeholder'=>'Keterangan')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> Batalkan</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.tab-content -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#form-rsaudara select').select2();
        $('#form-rsaudara .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rsaudara .date").mask("99-99-9999");
        $("#form-rsaudara .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rsaudara').on('submit',function(e){
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
                            if((html==1) || (html==4)){
                                notification('Data Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');
                                loadRsaudara();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        <?php if(Input::get("flag") == 2){ ?>
            $.ajax({
                url:'{!!url()!!}/epersonal/biodata/editriwayat',
                type:'post',
                data:{'id':'{!!Input::get("id")!!}','tb':'r_saudarakandung','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tglhr");
                    var arrayradio = new Array("idjenkel");
                    var arrselect2 = new Array("stssaudara");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rsaudara #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rsaudara #'+attrname).select2('val',ret[attrname]);
                            }
                            if($.inArray(attrname,arrayradio)!=-1){
                                $('#form-rsaudara input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rsaudara #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>