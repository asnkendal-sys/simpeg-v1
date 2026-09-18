<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverortu", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rortu')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama_ortu', 'Nama Orang Tua:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nama_ortu', null, array('class'=> 'form-control', 'placeholder'=>'Nama Orang Tua')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nikortu', 'NIK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nikortu', null, array('class'=> 'form-control', 'placeholder'=>'NIK')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama_ortu', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboOrtu("status_ortu","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tempat_lahir', 'Tempat Lahir:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tempat_lahir', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Lahir')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgl_lahir', 'Tgl. Lahir:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgl_lahir', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('alamat', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <textarea rows="3" cols="250" name="alamat" id="alamat" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pekerjaan', 'Pekerjaan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pekerjaan', null, array('class'=> 'form-control', 'placeholder'=>'Pekerjaan')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                                    <label class="col-sm-3 control-label" for=""></label>
                                    <div class="col-sm-7">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="status_jkn" value="1"> Masukkan Daftar JKN
                                        </label>
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
        $('#form-rortu select').select2();
        $('#form-rortu .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rortu .date").mask("99-99-9999");
        $("#form-rortu .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rortu').on('submit',function(e){
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
                                loadRortu();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_ortu','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tgl_lahir");
                    var arraycheckjkn = new Array("status_jkn");
                    var arrselect2 = new Array("status_ortu");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rortu #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rortu #'+attrname).select2('val',ret[attrname]);
                            }
                            if ($.inArray(attrname, arraycheckjkn) != -1) {
                                $('#form-rortu input[name=' + attrname + ']').attr('checked', ((ret[attrname] == 1) ? true : false));
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rortu #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>