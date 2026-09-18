<?php
    if(session('role_id') <= 3){
        $alert = "Simpan data ?";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat KGB yang memiliki tmt KGB terbaru akan langsung terupdate ke biodata.</li></ul>";
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
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverkgb':'saverkgbtemp'), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rkgb')) !!}
                    @if(session('role_id') <= 3)
                        {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    @else
                        {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                        @if((Input::get('tb') == 'r_kgb') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rkgb', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                        @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rkgb', null, array('id'=> 'id_rkgb')) !!}
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
                            {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboGolru("idgolru","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idpenetap', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboPenetapsk("idpenetap","","") !!}
                                {!! Form::hidden('penetap', '', array('class'=> 'form-control', 'id'=>'penetap')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('noskkgb', 'Nomor SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('noskkgb', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SKKGB')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmtkgb', 'TMT KGB:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtkgb', null, array('class'=> 'form-control date', 'placeholder'=>'TMT KGB')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tglkgb', 'Tanggal SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tglkgb', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('mkthn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-2">
                                {!! Form::text('mkthn', null, array('class'=> 'form-control num', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                {!! Form::text('mkbln', null, array('class'=> 'form-control num', 'id'=> 'mkbln', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gaji', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('gaji', null, array('class'=> 'form-control', 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
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
        $('#form-rkgb select').select2();
        /*$('#form-rkgb #idpenetap').select2({
            tags: true
        });*/
        $('#form-rkgb .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rkgb .date").mask("99-99-9999");
        $("#form-rkgb .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rkgb #idpenetap').on('change', function(e){
            e.preventDefault();
            $('#form-rkgb #penetap').val($(this).find(":selected").text());
        });

        $('#form-rkgb').on('submit',function(e){
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
                                loadBiodata();
                                loadRkgb();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rkgb #idgolru').on('change', function(e){
            e.preventDefault();
            getgaji();
        });

        $('#form-rkgb #mkthn').on('keyup', function(e){
            e.preventDefault();
            getgaji();
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
                    var arrdate = new Array("tglkgb","tmtkgb");
                    var arrselect2 = new Array("idpenetap","idgolru");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rkgb #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rkgb #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rkgb #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }

                        var text = ret.penetap;
                        if(text.indexOf(ret.idpenetap) != -1){
                            var newOption = new Option(ret.penetap, ret.idpenetap, false, true);
                            $('#form-rkgb #idpenetap').append(newOption).trigger('change');
                        }
                    }
                }
            });
        <?php } ?>
    });

    function getgaji(){
        var idgolru = $('#form-rkgb #idgolru').val();
        var mkthn = $('#form-rkgb #mkthn').val();

        $.ajax({
            url : '{!!url()!!}/epersonal/biodata/gaji',
            type : 'post',
            data : {'idgolru' : idgolru, 'mkthn' : mkthn, '_token' : '{!!csrf_token()!!}'},
            beforeSend : function(){},
            success : function(response){
                var ret = $.parseJSON(response);
                $('#form-rkgb #gaji').val(ret.gaji);
            }
        });
    }

</script>