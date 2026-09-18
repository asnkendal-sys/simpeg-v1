<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverseminar", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rseminar')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nmseminar', 'Nama Seminar:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nmseminar', null, array('class'=> 'form-control', 'placeholder'=>'Nama Seminar')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('penyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('penyelenggara', null, array('class'=> 'form-control', 'placeholder'=>'Penyelenggara')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmseminar', 'Tempat Seminar:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tmseminar', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Seminar')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Mulai')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Selesai')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nopiagam', 'No Piagam:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nopiagam', null, array('class'=> 'form-control', 'placeholder'=>'No Piagam')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('jamhari', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group'>
                                    {!! Form::text('jamhari', null, array('class'=> 'form-control num', 'placeholder'=>'Lama hitungan jam')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
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
        $('#form-rseminar select').select2();
        $('#form-rseminar .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rseminar .date").mask("99-99-9999");
        $("#form-rseminar .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rseminar').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Data yang disimpan akan langsung tersinkronisasi dengan SIASN. <br>Simpan data?',function(a){
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
                                loadRseminar();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_seminar','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array('tgmul','tgsel');
                    if(ret){
                        for(attrname in ret){
                            $('#form-rseminar #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rseminar #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>