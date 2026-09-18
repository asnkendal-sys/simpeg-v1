<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverakredit", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rakredit')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjabfung', 'Jabatan Fungsional:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="idjabfung" class="form-control" id="idjabfung" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                {!! Form::hidden('jabfung', null, array('class'=> 'form-control', 'id'=> 'jabfung')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pak', 'Jumlah Angka Kredit Lama:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <?php 
                                $db=\DB::table('r_akredit')
                                ->select('r_akredit.*')
                                ->where('r_akredit.nip', '=', $nip)
                                ->orderBy('r_akredit.periodeselesai', 'desc')
                                ->first();

                                $hitung=count($db);
                                $kbtotal=($hitung==0)?'0':$db->kbtotal;
                                ?>
                                {!! Form::text('pak', $kbtotal, array('class'=> 'form-control num pak', 'placeholder'=>'000.000')) !!}
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
                            {!! Form::label('periodemulai', 'Periode Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('periodemulai', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('periodeselesai', 'Periode Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('periodeselesai', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                                     <div class="form-group">
                            {!! Form::label('jenisakred', 'Jenis Akreditasi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred1" value="1" checked=""> Pertama
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred2" value="2"> Integrasi
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="jenisakred" id="jenisakred3" value="3"> Konversi
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kubaru', 'Kredit Utama Baru:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kubaru', null, array('class'=> 'form-control num hitung', 'placeholder'=>'000.000')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kpbaru', 'Kredit Penunjang Baru:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kpbaru', null, array('class'=> 'form-control num hitung', 'placeholder'=>'000.000')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('kbtotal', 'Total Angka Kredit:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('kbtotal', null, array('class'=> 'form-control num', 'placeholder'=>'000.000', 'readonly'=> '')) !!}
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
        

        $('#form-rakredit select').select2();
        autoComplete('#form-rakredit #idjabfung', '{{url()}}/epersonal/biodata/jabfung', '.: Pilihan :.', null, '', '', '');
        $('#form-rakredit .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rakredit .date").mask("99-99-9999");
        $("#form-rakredit .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rakredit .hitung').keyup(function(e){
            e.preventDefault();
        var pak = parseFloat($('#pak').val()) || 0;
            var kubaru = parseFloat($('#kubaru').val()) || 0;
            var kpbaru = parseFloat($('#kpbaru').val()) || 0;

            var kbtotal = parseFloat(pak) +parseFloat(kubaru) + parseFloat(kpbaru);

            $('#kbtotal').val(kbtotal.toFixed(3));
        });

        $('#form-rakredit #idjabfung').on('change', function(e){
            e.preventDefault();
            $('#form-rakredit #jabfung').val($(this).find(":selected").text());
        })

         $('#form-rakredit .pak').on('change', function(e){
            e.preventDefault();
            var pak = parseFloat($(this).val()) || 0;
            var koma = '0.000'
            var pak_ = parseFloat(pak) + parseFloat(koma);

            $('.pak').val(pak_.toFixed(3));
        });

        $('#form-rakredit').on('submit',function(e){
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
                                loadRakredit();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_akredit','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array('tgsk','periodemulai','periodeselesai');
                    var arrselect2 = new Array('');
                 var arrayradio = new Array("jenisakred");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rakredit #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rakredit #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rakredit #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        if ($.inArray(attrname, arrayradio) != -1) {
                                $('input[name=' + attrname + '][value=' + ret[attrname] + ']').prop('checked', true);
                            }
                        }

                        $("#form-rakredit #idjabfung").data('select2').trigger('select', {
                            data: {"id":ret.idjabfung,"text":ret.jabfung}
                        });
                    var jns_akred = ((ret.jenisakred == 1) ? 'Pertama' : (ret.jenisakred == 2) ? 'Integrasi' : 'Konversi');
                    }
                }
            });
        <?php } ?>
    });

</script>