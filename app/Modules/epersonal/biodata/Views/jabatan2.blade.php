<?php
    if(Input::get('act')=='sinkron2'){
        $act = '#form-rjab2';
    }else{
        $act = ((Input::get('act')=='riwayat')?'.data-perubahan':'#form-rjab');
    }
?>


<!-- view subkoordinator -->
<?php
$idjenjab = Input::get('idjenjab');
$cek = \DB::table('a_skpd')->where('idskpd', Input::get('idskpd'))->first();
$id = Input::get('id');
$nip = Input::get('nip');
if($id==null){
	$ras = \DB::table('r_jab')
		->where('nip', '=', $nip)
        ->orderBy('id', 'desc')
		->first();
}else{
	$ras = \DB::table('r_jab')
		->where('id', '=', $id)
		->where('nip', '=', $nip)
        ->orderBy('id', 'desc')
		->first();
}

if($idjenjab<4){
    if(count($cek) > 0) {
        if($cek->isttb != '0'){
            echo '
                <div class="form-group">
                    <label for="isttb" class="col-sm-3 control-label">'.(($cek->isttb==1)?"Menjabat Ketua TIM / Sub Koordinator":"Menjabat Ketua TIM / Sub Koordinator").'</label>
                    <div class="col-sm-7">
                        <div class="checkbox">
                            <input type="radio" name="isttb" value="0" required id="isttb2" '.((@$ras->isttb==0)?"checked":"").'/> Tidak
                            <input type="radio" name="isttb" value="1" required id="isttb1" '.((@$ras->isttb==1)?"checked":"").'/> Ya
                        </div>
                    </div>
                </div>

                <div class="form-group xkoordinator">
                    <label for="isttb" class="col-sm-3 control-label">Ketua TIM / Sub Koordinator</label>
                    <div class="col-sm-7">
                        <div class="checkbox">
                            '.comboSubkoord("idkoord",((count($ras) > 0)?$ras->idkoord:''),((count($ras) > 0)?$ras->idskpd:Input::get('idskpd'))).'
                        </div>
                    </div>
                </div>
            ';
        }
    }
}
?>

<script>
    $(document).ready(function(){
        var isttb = "{!! @$ras->isttb !!}";
		
        if (isttb == 1) {
            $('{!!$act!!} .xkoordinator').show();
        }else{
            $('{!!$act!!} .xkoordinator').hide();
        }

        $('{!!$act!!} input[type="radio"][name="isttb"]').click(function() {
            if($(this).val() == 1)
            {
                $('{!!$act!!} .xkoordinator').fadeIn();
            }else{
                $('{!!$act!!} .xkoordinator').fadeOut();
            }
        }).trigger('change');
    
    });
</script>
<!-- end -->


<script type="text/javascript">
    @if(((count($rs) > 0)?$rs->isdiperbantukan:0) == 1)
        $('{!!$act!!} #xsekolahswasta').fadeIn();
    @endif

    @if(((count($rs) > 0)?$rs->isguru:0) == 1)
        $('{!!$act!!} #xtugasguru').fadeIn();
        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
        $('{!!$act!!} #xtugasdokterumum').fadeOut();
        $('{!!$act!!} #xnamadesa').fadeOut();
        @if(((count($rs) > 0)?$rs->iskepsek:0) == 1)
            $('{!!$act!!} #xkepalasekolah').fadeIn();
        @else
            $('{!!$act!!} #xkepalasekolah').fadeOut();
        @endif
    @elseif(((count($rs) > 0)?$rs->isguru:0) == 2)
        $('{!!$act!!} #xtugasguru').fadeOut();
        $('{!!$act!!} #xtugasdokter').fadeIn();
        $('{!!$act!!} #xnamadesa').fadeOut();
@elseif(((count($rs) > 0)?substr($rs->idjabfung,0,3):0) == 210)
        $('{!!$act!!} #xtugasguru').fadeOut();
         $('{!!$act!!} #xtugasdoktergigi').fadeIn();
        $('{!!$act!!} #xtugasdokterumum').fadeOut();
        $('{!!$act!!} #xnamadesa').fadeOut();
    @elseif(((count($rs) > 0)?$rs->idjabfungum:0) == '7901001')
        $('{!!$act!!} #xtugasguru').fadeOut();
        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
        $('{!!$act!!} #xtugasdokterumum').fadeOut();
        $('{!!$act!!} #xnamadesa').fadeIn();
    @else
        $('{!!$act!!} #xtugasguru, {!!$act!!} #xtugasdoktergigi, {!!$act!!} #xtugasdokterumum, {!!$act!!} #xnamadesa, {!!$act!!} #xsekolahswasta, {!!$act!!} #xkepalasekolah').fadeOut();
    @endif

    $('{!!$act!!} #jabatanx select').select2();
    $('{!!$act!!} #idjab').on('change', function(e){
        e.preventDefault();
        $('{!!$act!!} #jab').val($(this).find(":selected").text());
    });

    $('{!!$act!!} #idmatkulpel').on('change', function(e){
        e.preventDefault();
        $('{!!$act!!} #matkulpel').val($(this).find(":selected").text());
    });

    $('{!!$act!!} #iddesa').on('change', function(e){
        e.preventDefault();
        $('{!!$act!!} #nmadesa').val($(this).find(":selected").text());
    });

    $('{!!$act!!} #idesljbt').on('change', function(e){
        e.preventDefault();
        $('{!!$act!!} #esl').val($(this).find(":selected").text());
    });
</script>

<div class="form-group">
    {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-7">
        <div style="width: auto;" class="" id="najab">
            <select name='idjab' class='form-control' id='idjab' style='width: 100%'></select>
            {!! Form::hidden('jab', ((count($rs) > 0)?$rs->jabatan:''), array('class'=> 'form-control', 'id'=> 'jab')) !!}
        </div>    
    </div>
</div>
<span id="jabatanx">
     
    @if(($idjenjab == 20) or ($idjenjab == 30) or ($idjenjab == 40))
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', '{!!((count($rs) > 0)?$rs->idskpd:$idskpd)!!}', '{!!((count($rs) > 0)?$rs->idjenjab:$idjenjab)!!}');
            $('{!!$act!!} #idskpd').on('change', function(e){
                e.preventDefault();
                autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '', '', $('{!!$act!!} #idskpd').val(),  $('{!!$act!!} #idjenjab').val());
            });            
            
            $('{!!$act!!} #idjab').on('change', function(e){
                e.preventDefault();
                var idjabjbt = $(this).val();
                $.ajax({
                    url:'{{url()}}/epersonal/biodata/eselon',
                    type:'post',
                    data:{'idjabjbt': idjabjbt, '_token' : '{!!csrf_token()!!}'},
                    beforeSend:function(){},
                    success:function(response){
                        var ret = $.parseJSON(response);
                        $('{!!$act!!} #idesljbt').select2('val',ret.idesl);
                    }
                })
            })
        </script>
        <div class="form-group">
            {!! Form::label('idesljbt', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! comboEselon("idesljbt",((count($rs) > 0)?$rs->idesljbt:''),"") !!}
                {!! Form::hidden('esl', ((count($rs) > 0)?$rs->esl:''), array('class'=> 'form-control', 'id'=> 'esl')) !!}
            </div>
        </div>
    @elseif($idjenjab == 2)
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfung', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfung:'')!!}', '{!!((count($rs) > 0)?$rs->jabfung:'')!!}', '');
            autoComplete('{!!$act!!} #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idmatkulpel:'')!!}', '{!!((count($rs) > 0)?$rs->matkulpel:'')!!}', '');
            autoComplete('{!!$act!!} #iddiperbantukan', '{{url()}}/epersonal/biodata/sekolahswasta', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddiperbantukan:'')!!}', '{!!((count($rs) > 0)?$rs->nmasekolah:'')!!}', '');
            autoComplete('{!!$act!!} #idkepsek', '{{url()}}/epersonal/biodata/kepseksekolah', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idkepsek:'')!!}', '{!!((count($rs) > 0)?$rs->kepseksekolah:'')!!}', '{!!((count($rs) > 0)?$rs->idskpd:$idskpd)!!}'); //$('#idskpd').val()

            $('{!!$act!!} #idjab').on('change', function(e){
                e.preventDefault();
                var idjab = $('{!!$act!!} #idjab').val();
                if(idjab != null){
                    if(idjab.substr(0,3) == '300'){
                        $('{!!$act!!} #xtugasguru').fadeIn();
                        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
                        $('{!!$act!!} #xtugasdokterumum').fadeOut();
                    }else if(idjab.substr(0,3) == '220'){
                        $('{!!$act!!} #xtugasguru').fadeOut();
                        $('{!!$act!!} #xtugasdokterumum').fadeIn();
                        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
                    }else if(idjab.substr(0,3) == '210'){
                        $('{!!$act!!} #xtugasguru').fadeOut();
                        $('{!!$act!!} #xtugasdokterumum').fadeOut();
                        $('{!!$act!!} #xtugasdoktergigi').fadeIn();
                    }else{
                        $('{!!$act!!} #xtugasguru, {!!$act!!} #xtugasdoktergigi, {!!$act!!} #xtugasdokterumum').fadeOut();
                    }
                }else{
                    $('{!!$act!!} #xtugasguru, {!!$act!!} #xtugasdoktergigi, {!!$act!!} #xtugasdokterumum, {!!$act!!} #xsekolahswasta, {!!$act!!} #xkepalasekolah').fadeOut();
                }
            });

            $('{!!$act!!} #isdiperbantukan').on('change', function(e){
                e.preventDefault();
                var isdiperbantukan = $('{!!$act!!} #isdiperbantukan').val();

                if(isdiperbantukan == 1){
                    $('{!!$act!!} #xsekolahswasta').fadeIn();
                }else{
                    $('{!!$act!!} #xsekolahswasta').fadeOut();
                }
            });

            $('{!!$act!!} #iskepsek').on('change', function(e){
                e.preventDefault();
                var iskepsek = $('{!!$act!!} #iskepsek').val();

                if(iskepsek == 1){
                    $('{!!$act!!} #xkepalasekolah').fadeIn();
                }else{
                    $('{!!$act!!} #xkepalasekolah').fadeOut();
                }
            });

            $('{!!$act!!} #idtugasgurudosen').on('change', function(e){
                e.preventDefault();
                autoComplete('{!!$act!!} #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '', '',  $(this).val());
            });

            $("#jabatanx .date").mask("99-99-9999");
            $("#jabatanx .datepicker").datetimepicker({
                format: 'DD-MM-YYYY'
            });
        </script>
        <span id="xtugasguru">
            <div class="form-group">
                {!! Form::label('idtugasgurudosen', 'Tugas Guru:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboTgsgurudosen("idtugasgurudosen",((count($rs) > 0)?$rs->idtugasgurudosen:''),"")!!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idmatkulpel', 'Mata Pelajaran:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="idmatkulpel" class="form-control" id="idmatkulpel" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                    {!! Form::hidden('matkulpel', ((count($rs) > 0)?$rs->matkulpel:''), array('class'=> 'form-control', 'id'=> 'matkulpel')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('iskepsek', 'Menjabat Kepala Sekolah:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboYesno("iskepsek",((count($rs) > 0)?$rs->iskepsek:''),"")!!}
                </div>
            </div>
            <span id="xkepalasekolah">
                <div class="form-group">
                    {!! Form::label('idkepsek', 'Kepala Sekolah di:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <select name="idkepsek" class="form-control" id="idkepsek" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tmtkepsek', 'TMT dan No. SK Kepsek:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-3">
                        {!! Form::text('tmtkepsek', ((count($rs) > 0)?date('d-m-Y', strtotime($rs->tmtkepsek)):''), array('class'=> 'form-control datepicker date', 'placeholder'=> 'dd-mm-yyyy', 'maxlength'=> 10)) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('noskkepsek', ((count($rs) > 0)?$rs->noskkepsek:''), array('class'=> 'form-control', 'placeholder'=> 'No. SK Kepsek', 'maxlength'=> 35)) !!}
                    </div>
                </div>
            </span>
        </span>
        <span id="xtugasdoktergigi">
            <div class="form-group">
                {!! Form::label('idtugasdoktergigi', 'Tugas Dokterr:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboTgsdokter("idtugasdoktergigi",((count($rs) > 0)?$rs->idtugasdokter:''),"","gigi")!!}
                </div>
            </div>
        </span>
        <span id="xtugasdokterumum">
            <div class="form-group">
                {!! Form::label('idtugasdokter', 'Tugas Dokter:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboTgsdokter("idtugasdokter",((count($rs) > 0)?$rs->idtugasdokter:''),"","")!!}
                </div>
            </div>
        </span>
        <div class="form-group">
            {!! Form::label('isdiperbantukan', 'Status Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! comboYesno("isdiperbantukan",((count($rs) > 0)?$rs->isdiperbantukan:''),"")!!}
            </div>
        </div>
        <span id="xsekolahswasta">
            <div class="form-group">
                {!! Form::label('iddiperbantukan', 'Lokasi Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="iddiperbantukan" class="form-control" id="iddiperbantukan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                </div>
            </div>
        </span>
        <div class="form-group">
            {!! Form::label('nopak', 'Angka Kredit:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::text('nopak', ((count($rs) > 0)?$rs->nopak:''), array('class'=> 'form-control', 'placeholder'=> 'Angka Kredit', 'maxlength'=> 10)) !!}
            </div>
        </div>
    @elseif($idjenjab == 3)
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfungum', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfungum:'')!!}', '{!!((count($rs) > 0)?$rs->jabfungum:'')!!}', '');
            autoComplete('{!!$act!!} #iddesa', '{{url()}}/epersonal/biodata/kelurahan', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddesa:'')!!}', '{!!((count($rs) > 0)?$rs->nmadesa:'')!!}', '');
            autoComplete('{!!$act!!} #iddiperbantukan', '{{url()}}/epersonal/biodata/sekolahswasta', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddiperbantukan:'')!!}', '{!!((count($rs) > 0)?$rs->nmasekolah:'')!!}', '');

            $('{!!$act!!} #idjab').on('change', function(e){
                e.preventDefault();
                var idjab = $('{!!$act!!} #idjab').val();
                if(idjab != null){
                    if(idjab == '4161004'){
                        $('{!!$act!!} #xnamadesa').fadeIn();
                    }else{
                        $('{!!$act!!} #xnamadesa').fadeOut();
                    }
                }else{
                    $('{!!$act!!} #xnamadesa').fadeOut();
                }
            });

            $('{!!$act!!} #isdiperbantukan').on('change', function(e){
                e.preventDefault();
                var isdiperbantukan = $('{!!$act!!} #isdiperbantukan').val();

                if(isdiperbantukan == 1){
                    $('{!!$act!!} #xsekolahswasta').fadeIn();
                }else{
                    $('{!!$act!!} #xsekolahswasta').fadeOut();
                }
            }).trigger('change');
        </script>
        <span id="xnamadesa">
            <div class="form-group">
                {!! Form::label('iddesa', 'Nama Desa:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="iddesa" class="form-control" id="iddesa" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                    {!! Form::hidden('nmadesa', ((count($rs) > 0)?$rs->nmadesa:''), array('class'=> 'form-control', 'id'=> 'nmadesa')) !!}
                </div>
            </div>
        </span>
        <div class="form-group">
            {!! Form::label('isdiperbantukan', 'Status Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! comboYesno("isdiperbantukan",((count($rs) > 0)?$rs->isdiperbantukan:''),"")!!}
            </div>
        </div>
        <span id="xsekolahswasta">
            <div class="form-group">
                {!! Form::label('iddiperbantukan', 'Lokasi Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="iddiperbantukan" class="form-control" id="iddiperbantukan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                </div>
            </div>
        </span>
    @elseif($idjenjab == 4)
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabnonjob', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabnonjob:'')!!}', '{!!((count($rs) > 0)?$rs->jabnonjob:'')!!}', '');
        </script>
    @else
        <div class="form-group">
            {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjab' class='form-control' id='idjab' data-placeholder='.: Pilihan :.' style='width: 100%'></select>
                {!! Form::hidden('idesljbt', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('esl', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('nopak', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('idtugasgurudosen', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('idtugasdokter', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('idmatkulpel', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('isdiperbantukan', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('iddiperbantukan', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('iskepsek', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('idkepsek', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('iddesa', null, array('class'=> 'form-control')) !!}
                {!! Form::hidden('nmadesa', null, array('class'=> 'form-control')) !!}
            </div>
        </div>
    @endif
</span>
