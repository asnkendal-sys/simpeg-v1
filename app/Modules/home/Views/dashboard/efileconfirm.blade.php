
<div class="table-responsive">
    <?php 
        $action = '';
        if(Session::get('role_id') == 5){
            $action = url()."/efile/loginfsimpeg_pg";
        }else{
            $action = url()."/efile/loginfsimpeg_adm";
        }
    ?>
    {!! Form::open(array('url' => $action, 'method' => 'GET', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form_profilb')) !!}
    <div class="col-md-10">
        <?php
//            echo "<pre>";
//                print_r(Session::all());
//            echo "</pre>";
        ?>
        <input type="hidden" name="role_id" class="username" value="{{Session::get('role_id')}}">
        @if(Session::get('role_id') == 5)
        <input type="hidden" name="username" class="username" value="{{Session::get('user_id')}}">
        @else
        <input type="hidden" name="username" class="username" value="{{Session::get('user_name')}}">
        @endif
        <input type="hidden" name="password" class="password" value="{{Session::get('_key')}}">
        Lanjutkan ke Halaman E-file ?
    </div>
    <div class="clearfix"><br><br></div>
    <div class="pull-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Lanjutkan</button>
        &nbsp;
        <button type="button" class="btn btn-warning" onclick="claravel_modal_close('main_modal')"><i class="fa fa-times-circle-o"></i> Batalkan</button>
    </div>
    {!! Form::close() !!}

</div>