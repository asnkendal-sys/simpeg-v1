<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverbahasa", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rbahasa')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jenis_bahasa', 'Jenis Bahasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboJnsbahasa($id="jenis_bahasa",$sel="",$required="") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama_bahasa', 'Nama Bahasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nama_bahasa', null, array('class'=> 'form-control', 'placeholder'=>'Nama Bahasa')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kemampuan', 'Kemampuan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboTingkat("kemampuan","","") !!}
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
        $('#form-rbahasa select').select2();
        $('#form-rbahasa .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rbahasa .date").mask("99-99-9999");
        $("#form-rbahasa .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rbahasa').on('submit',function(e){
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
                                loadRbahasa();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_bahasa','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrselect2 = new Array('jenis_bahasa', 'kemampuan');
                    if(ret){
                        for(attrname in ret){
                            $('#form-rbahasa #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rbahasa #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>