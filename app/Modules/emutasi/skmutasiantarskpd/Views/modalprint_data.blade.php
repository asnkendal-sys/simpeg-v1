{!! Form::open(array('url' => url().'/emutasi/skmutasiantarskpd/modalprint', 'method' => 'POST', 'target' => '_blank', 'class'=>'form-horizontal> form-'.\Config::get('claravel::ajax'),'id'=>'form-modaluntukprint')) !!}
<table class="table table-striped table-hover table-condensed table-bordered" id="tabel">
    <tr>
        <td>Nomor Usulan</td>
        <td>:</td>
        <td>
            <input type='text' name="nousul" class="form-control" value="{{Input::get('nousul')}}" disabled />
        </td>
    </tr>
    <tr>
     <td>Tanggal Nota Dinas</td>
     <td>:</td>
     <td>
        <div class='input-group date datetimepicker1'>
            <input type='text' name="tgl_notadinas" class="form-control datetime" value="{{date('d-m-Y')}}" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </td>
</tr>
</table>
{!! Form::hidden('nousul', Input::get('nousul')) !!}

<div class="pull-right">
    <button id="" type="submit" class="btn btn-success"><i class="fa fa-forward"></i> Print</button>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();
        $('.datetimepicker1').datetimepicker({format: 'DD-MM-YYYY'});
        $(".datetime").mask("99-99-9999");

        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
    });
</script>