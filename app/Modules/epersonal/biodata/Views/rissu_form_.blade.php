<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverissu", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rissu')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nmissu', 'Nama Istri/Suami:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nmissu', null, array('class'=> 'form-control', 'placeholder'=>'Nama Istri/Suami')) !!}
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
                            {!! Form::label('noaktanikah', 'No. Akta Nikah:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('noaktanikah', null, array('class'=> 'form-control', 'placeholder'=>'No. Akta Nikah')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgnikah', 'Tanggal Nikah:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgnikah', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group stsdujan">
                             {!! Form::label('idstsissu', 'Status Duda/Janda :', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboStsIssu("idstsissu","idstsissu","") !!}
                                </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idpendidum', 'Pendidikan Umum:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboTkpendidikan("idpendidum","","") !!}
                                {!! Form::hidden('pendidum', null, array('class'=> 'form-control', 'id'=>'pendidum')) !!}
                            </div>
                        </div>
                        <div class="form-group peker">
                            {!! Form::label('peker', 'Pekerjaan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboStspekerjaan("peker","","") !!}
                            </div>
                        </div>
                        <!-- <div class="form-group nipnrp">
                            {!! Form::label('nipnrp', 'NIP/NRP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nipnrp', null, array('class'=> 'form-control', 'placeholder'=>'NIP/NRP')) !!}
                            </div>
                        </div> -->
                        <div class="form-group nipnrp">
                            {!! Form::label('nipnrp', 'NIP Istri/Suami :', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                @if(session('role_id') == 5)
                                <input type="text" value="{!!session('user_id')!!}" id="nipnrp" name="nipnrp" readonly class="form-control">
                                @else
                                <select name="nipnrp" class="form-control" id="nipnrp" style="width: 100%"></select>
                                @endif
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
        $('#form-rissu select').select2();
        $('.nipnrp').hide();
        $('#form-rissu .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rissu .date").mask("99-99-9999");
        $("#form-rissu .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rissu #idpendidum').on('change', function(e){
            $('#form-rissu #pendidum').val($(this).find(":selected").text());
        });

        $('#form-rissu #nipnrp').on('change', function(e){
            e.preventDefault();
            $('#form-rissu #nipnrp').val($(this).find(":selected").text());
        })

        $('#form-rissu #nipnrp').val($('#simpan #nipnrp').find(":selected").text());
        // autoComplete('#form-rjab #nipnrp', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');

        @if(session('role_id') = 5)
        autoCompleteimg('#form-rissu #nipnrp', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '{!!Input::get("id")!!}', '{!!Input::get("id")!!}', '');
        @endif
        autoComplete('#form-rissu #tmplhr', '{{url()}}/epersonal/biodata/tempatlahir', '.: Pilihan :.', null, '', '', '');
       
        $("#peker").change(function(){
            var prj = $('#peker').val();
            if(prj == 1){
                $('.nipnrp').show();
            }else{
                $('#nipnrp').select2('val','');
                $('.nipnrp').hide();
            }
        }).trigger('change');

        $('#form-rissu').on('submit',function(e){
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
                                loadRissu();
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
                data:{'id':'{!!Input::get("id")!!}','tb':'r_issu','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tgnikah","tglhr");
                    var arrselect2 = new Array("idpendidum","peker");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rissu #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rissu #'+attrname).select2('val',ret[attrname]);
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rissu #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }
                    }
                }
            });
        <?php } ?>
    });

</script>