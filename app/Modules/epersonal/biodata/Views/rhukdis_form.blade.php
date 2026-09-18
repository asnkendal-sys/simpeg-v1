<?php
    if(session('role_id') <= 3){
        $alert = "Simpan data ?";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat Hukuman Disiplin yang memiliki tmt terbaru akan langsung terupdate ke biodata.</li></ul>";
    }
?>

<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverhukdis':'saverhukdistemp'), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rhukdis')) !!}
                    @if(session('role_id') <= 3)
                        {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    @else
                        {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                        @if((Input::get('tb') == 'r_hukdis') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rhukdis', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                        @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rhukdis', null, array('id'=> 'id_rhukdis')) !!}
                            {!! Form::hidden('idjnsaksi', null, array('id'=> 'idjnsaksi')) !!}
                        @endif
                    @endif
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenhukum', 'Jenis Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboJenhukum('idjenhukum','','') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idtkhukum', 'Tingkat Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7" id="xtkhukum">
                                <select name="idtkhukum" class="form-control" id="idtkhukum" data-placeholder=".: Pilihan :." requierd style="width:100%%"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejab', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboPenetapsk("pejab","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosk', 'No. SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'No. SK')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
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
                                    {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ket', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <textarea rows="5" cols="250" name="ket" id="ket" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    @if(Input::get('flag') == 1)
                                        <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    @elseif(Input::get('flag') == 2)
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> Update</button>
                                    @elseif(Input::get('flag') == 3)
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Hapus</button>
                                    @endif
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
        $('#form-rhukdis select').select2({
            tags: true
        });
        $('#form-rhukdis .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rhukdis .date").mask("99-99-9999");
        $("#form-rhukdis .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rhukdis #idjenhukum').change(function(){
            var idjenhukum = $(this).val();
            $.ajax({
                url:'{!! url() !!}/epersonal/biodata/tkhukum',
                type:'post',
                data:{'idjenhukum':idjenhukum, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('#form-rhukdis #xtkhukum').html('Looading..');
                },
                success:function(response){
                    $('#form-rhukdis #xtkhukum').html(response);
                }
            });
        });

        $('#form-rhukdis').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('{!!$alert!!}',function(a){
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
                                loadRhukdis();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        <?php if(Input::get("flag") > 1){ ?>
            $.ajax({
                url:'{!!url()!!}/epersonal/biodata/editriwayat',
                type:'post',
                data:{'id':'{!!Input::get("id")!!}','tb':'{!!Input::get("tb")!!}','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array('tgsk','tgmul','tgsel');
                    var arrselect2 = new Array('idjenhukum','pejab');
                    if(ret){
                        for(attrname in ret){
                            $('#form-rhukdis #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rhukdis #'+attrname).select2('val',ret[attrname]);
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rhukdis #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>