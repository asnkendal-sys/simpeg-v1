<?php
    $nousul = Input::get('nousul');
    $act = Input::get('act');

    $jumlah = \DB::table('tr_mutasi_masuk_daerah')->select('tr_mutasi_masuk_daerah.*')->where('nousul','=',$nousul)->get();

    $data = \DB::table('tr_mutasi_masuk_daerah')->select('tr_mutasi_masuk_daerah.*')->where('nousul','=',$nousul)->first();
?>

<div class="box box-primary">
    <div class="row">
        <div class="col-md-12">
        <?php
            if(count($jumlah) > 0){
        ?>
            {!! Form::open(array('url' => url().'/emutasi/nominatifmasukkabupaten/cetakall/suratpermohonanall', 'method' => 'POST', 'target' => '_blank', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <input type="hidden" id="nousul" name="nousul" value="{!!$nousul!!}" />
                <input type="hidden" id="_token" name="_token" value="{!!csrf_token()!!}" />
                <div class="box-body">
                    <div class="head-line">
                        <h3>Formulir Dokumen pengantar</h3>
                    </div></br>
                    <div class="form-group">
                        {!! Form::label('no_sp', 'Nomor Surat:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('no_sp', (($data->no_sp=='')?'822.3/.............../'.date('Y'):$data->no_sp), array('class'=> 'form-control', 'placeholder'=>'Nomor Surat Pengantar')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('tgl_sp', 'Tanggal Surat:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <div class='input-group datepicker'>
                                {!! Form::text('tgl_sp', (($data->tgl_sp!='0000-00-00')?date('d-m-Y', strtotime($data->tgl_sp)):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('berkas_sp', 'Banyak Berkas:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('berkas_sp', (($data->berkas_sp=='0')?count($jumlah):$data->berkas_sp), array('class'=> 'form-control', 'placeholder'=>'Nomor Induk Pegawai', 'maxlength'=>18)) !!}
                            <span id="vernip"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button class="btn btn-success" type="submit">Cetak</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        <?php
            }else{
                echo "<i>*Data nominatif tidak tersedia</i>";
                exit();
            }
        ?>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        $("#simpan .datepicker").datetimepicker({
           format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");


    });

</script>
