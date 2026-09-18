<script>
    
    $(document).ready(function(){
        $('#batalkan').on('click',function(e){
            e.preventDefault();
            /*$('.pull-right').trigger('click');*/
        });
        $('#form_pass').validationEngine();
        $('#form_pass').validationEngine('validate');
        $('#form_pass').on('submit',function(e){
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
                                }
                            }
                        });
                    }
                });

            }
        });
    });
</script>
<div class="alert alert-info">
    Isikan Tanpa Tanda Baca
</div>
<div class="table-responsive">
    {!! Form::open(array('url' => url().'/passpegawai', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_pass')) !!}
    <div class="col-md-10" style="padding-top: 40px">
        {!!Form::hidden('nip',session('user_id'))!!}
        <div class="form-group">
            {!! Form::label('name', 'Password Lama:', array('class' => 'col-sm-5 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::password('password',array('class'=> 'validate[required] form-control')) !!}
            </div>
        </div>
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
