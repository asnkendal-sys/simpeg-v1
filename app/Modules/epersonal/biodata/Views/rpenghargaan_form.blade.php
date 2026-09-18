<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverpenghargaan", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rpenghargaan')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('thn', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('thn', null, array('class'=> 'form-control num', 'placeholder'=>'Tahun', 'maxlength'=>4)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jenis', 'Jenis Tanda Jasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboTandajasa("jenis","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tandajasa', 'Tanda Jasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tandajasa', null, array('class'=> 'form-control', 'placeholder'=>'Tanda Jasa')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idpejab', 'Penetap Tanda Jasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="idpejab" class="form-control" id="idpejab" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                {!! Form::hidden('pejab', null, array('class'=> 'form-control', 'id'=> 'pejab', 'placeholder'=>'Tanda Jasa')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosk', 'No. Tanda Jasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'No. Tanda Jasa')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal Tanda Jasa:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal Tanda Jasa')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
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
        $('#form-rpenghargaan select').select2();
        autoComplete('#form-rpenghargaan #idpejab', '{{url()}}/epersonal/biodata/pejabat', '.: Pilihan :.', null, '', '', '');
        $('#form-rpenghargaan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rpenghargaan .date").mask("99-99-9999");
        $("#form-rpenghargaan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rpenghargaan #idpejab').on('change', function(e){
            e.preventDefault();
            $('#form-rpenghargaan #pejab').val($(this).find(":selected").text());
        });

        $('#form-rpenghargaan').on('submit',function(e){
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
                                loadRpenghargaan();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_tandajasa','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array('tgsk');
                    var arrselect2 = new Array('jenis');
                    if(ret){
                        for(attrname in ret){
                            $('#form-rpenghargaan #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rpenghargaan #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rpenghargaan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }

                        $("#form-rpenghargaan #idpejab").data('select2').trigger('select', {
                            data: {"id":ret.idpejab,"text":ret.pejab}
                        });
                    }
                }
            });
        <?php } ?>
    });

</script>