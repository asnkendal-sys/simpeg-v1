<script>

    $(document).ready(function(){
        $('#form_pass_user').validationEngine();
        $('#form_pass_user').validationEngine('validate');
        $('#form_pass_user').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            if($this.validationEngine('validate')){
                bootbox.confirm('Ganti Password?',function(a){
                    if (a == true){
                        $.ajax({
                            url : $this.attr('action'),
                            type : 'POST',
                            data : $this.serialize(),
                            success:function(html){
                                if(html == 4){
                                    notification('Sukses Ganti Password');
                                    /*$('.pull-right').trigger('click');*/
                                    claravel_modal_close('main_modal');
                                }else{
                                    notification('Ganti Password Gagal!','danger');
                                }
                            }
                        });
                    }
                });

            }
        });
    });
</script>

<div class="row">
    {!! Form::open(array('url' => url().'/epersonal/biodata/passpegawai', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_pass_user')) !!}
    <div class="col-md-10" style="padding-top: 40px">
        {!!Form::hidden('nip',Input::get('nip'))!!}
        <div class="form-group">
            {!! Form::label('name', 'Password Baru:', array('class' => 'col-sm-5 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::password('password_baru1',array('id'=>'password_baru1','class'=> 'validate[required,minSize[5]] form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Konfirmasi Password Baru:', array('class' => 'col-sm-5 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::password('password_baru2',array('class'=> 'validate[required,minSize[5],equals[password_baru1]] form-control')) !!}
            </div>
        </div>

    </div>
    <div class="clearfix">
    </div>
    <hr>
    <div class="col-sm-offset-2 col-sm-10">
        {!! ClaravelHelpers::btnSave() !!}
        &nbsp;
    </div>
    {!! Form::close() !!}

</div>