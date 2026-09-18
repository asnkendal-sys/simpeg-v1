<?php
    if(session('role_id') <= 3){
        $alert = "Simpan data ?";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat pangkat yang memiliki tmt pangkat terbaru akan langsung terupdate ke biodata.</li></ul>";
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
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverpangkat':'saverpangkattemp'), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rpangkat')) !!}
                    @if(session('role_id') <= 3)
                        {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    @else
                        {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                        @if((Input::get('tb') == 'r_gol') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rgol', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                        @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rgol', null, array('id'=> 'id_rgol')) !!}
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
                            {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboPenetapsk("pejmenpkt","","") !!}
                                {!! Form::hidden('pejmenpkttext', '', array('class'=> 'form-control', 'id'=>'pejmenpkttext')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SK')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmtpkt', 'TMT SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtpkt', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-2">
                                {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gapok', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('gapok', null, array('class'=> 'form-control', 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('stspangkat', 'Status Pangkat:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                                                <label class="radio-inline">
                                            <input type="radio" name="stspangkat" id="inlineRadio1" value="1"> Awal CPNS
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="stspangkat" id="inlineRadio2" value="2"> Awal PNS
                                        </label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="stspangkat" id="inlineRadio3" value="3" checked> Pangkat PNS
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="stspangkat" id="inlineRadio3" value="4" > PMK
                                        </label><br>
                                <em><small>(* Default Pangkat PNS jika bukan Awal CPNS atau PNS.)</small></em>
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
        $('#form-rpangkat select').select2();
        $('#form-rpangkat #pejmenpkt').select2({
            tags: true
        });
        $('#form-rpangkat .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rpangkat .date").mask("99-99-9999");
        $("#form-rpangkat .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rpangkat #pejmenpkt').on('change', function(e){
            e.preventDefault();
            $('#form-rpangkat #pejmenpkttext').val($(this).find(":selected").text());
        });

        $('#form-rpangkat').on('submit',function(e){
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
                                loadRpangkat();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rpangkat #idgolru').on('change', function(e){
            e.preventDefault();
            getgaji();
        });

        $('#form-rpangkat #thkerja').on('keyup', function(e){
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
                    var arrdate = new Array("tgsk","tmtpkt");
                    var arrselect2 = new Array("pejmenpkt","idgolru");
                    var arrayradio = new Array("stspangkat");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rpangkat #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rpangkat #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rpangkat #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                            if($.inArray(attrname,arrayradio)!=-1){
                                $('#form-rpangkat input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                            }
                        }

                        var text = ret.pejmenpkttext;
                        if(text.indexOf(ret.pejmenpkt) != -1){
                            var newOption = new Option(ret.pejmenpkttext, ret.pejmenpkt, false, true);
                            $('#form-rpangkat #pejmenpkt').append(newOption).trigger('change');
                        }
                    }
                }
            });
        <?php } ?>
    });

    function getgaji(){
        var idgolru = $('#form-rpangkat #idgolru').val();
        var mkthn = $('#form-rpangkat #thkerja').val();

        $.ajax({
            url : '{!!url()!!}/epersonal/biodata/gaji',
            type : 'post',
            data : {'idgolru' : idgolru, 'mkthn' : mkthn, '_token' : '{!!csrf_token()!!}'},
            beforeSend : function(){},
            success : function(response){
                var ret = $.parseJSON(response);
                $('#form-rpangkat #gapok').val(ret.gaji);
            }
        });
    }

</script>
