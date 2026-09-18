<form enctype="multipart/form-data" method="post" action="{{url()}}/epersonal/daftarjabatankosong/penetapan" class="form-horizontal" name="formplt" id="formplt">
    <input type="hidden" value="{{Input::get('idskpd')}}" name="idskpd" id="idskpd">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="plt_nip">Nama Pegawai:</label>
            <div class="col-sm-7">
                <select name="plt_nip" class="form-control" id="plt_nip" style="width: 100%"></select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('plt_nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::text('plt_nosk', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SK')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('plt_tgl', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::text('plt_tgl', null, array('class'=> 'form-control date datepicker', 'placeholder'=>'dd-mm-yyyy')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('plt_tmt', 'Tanggal TMT:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::text('plt_tmt', null, array('class'=> 'form-control date datepicker', 'placeholder'=>'dd-mm-yyyy')) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">&nbsp;</label>
            <div class="col-sm-7">
                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Simpan</button>
                <button class="btn btn-warning" type="reset" onclick="claravel_modal_close('main_modal')"><i class="fa fa-times-circle"></i> Batalkan</button>
            </div>
        </div>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function(){
        $('#formplt select').select2();
        autoCompleteimg('#formplt #plt_nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
        $('#formplt .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#formplt .date").mask("99-99-9999");
        $("#formplt .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#formplt').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan penetapan PLT..?',function(a){
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
                                notification('Penetapan Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        <?php if(Input::get('plt') != ''){?>
            $.ajax({
                url:'{!!url()!!}/epersonal/daftarjabatankosong/editpenetapan',
                type:'post',
                data:{'idskpd':'{!!Input::get("idskpd")!!}','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("plt_tgl","plt_tmt");
                    var arrselect2 = new Array("plt_nip");
                    if(ret){
                        for(attrname in ret){
                            $('#formplt #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#formplt #'+attrname).select2('val',ret[attrname]);
                            }
                            if($.inArray(attrname,arrdate)!=-1){
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#formplt #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                            }
                        }

                        $("#formplt #plt_nip").data('select2').trigger('select', {
                            data: {"id":ret.plt_nip,"text":ret.namalengkap}
                        });
                    }
                }
            });
       <?php } ?>
    });

</script>
