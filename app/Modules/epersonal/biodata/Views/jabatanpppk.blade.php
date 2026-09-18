<?php
    $act = ((Input::get('act')=='riwayat')?'.data-perubahan':'#form-rpppk');
    $id = Input::get('id');
    $nip = Input::get('nip');
    $flag = Input::get('flag');

    if(!empty($flag)){
        $item = \DB::table('r_pppk as a')->select(
                    'a.idjab as idjabjbt', 'c.idjabfung', 'd.idjabfungum', 'g.idjabnonjob', 'a.idesl', 'a.iskepsek', 'a.idtugasgurudosen', 'a.idtugasdokter', 'a.isdiperbantukan', 'a.iddiperbantukan', 'a.idmatkulpel', 'a.nopak', 'b.idskpd', 'b.skpd',
                    'c.isguru','a.jab','c.jabfung','d.jabfungum','e.tugasgurudosen', 'f.matkulpel', 'g.jabnonjob', 'h.nmasekolah', 'a.iddesa', 'a.nmadesa','i.esl','a.idkepsek','a.tmtkepsek','a.noskkepsek','a.idjenjab','a.stsesl','a.tmtesljbt',
                    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,g.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('j.skpd as kepseksekolah')
                )
                ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                ->leftjoin('a_skpd as j', 'a.idkepsek', '=', 'j.idskpd')
                ->leftjoin('a_jabfung as c', 'a.idjab', '=', 'c.idjabfung')
                ->leftjoin('a_jabfungum as d', 'a.idjab', '=', 'd.idjabfungum')
                ->leftjoin('a_jabnonjob as g', 'a.idjab', '=', 'g.idjabnonjob')
                ->leftjoin('a_tugasgurudosen as e', 'a.idtugasgurudosen', '=', 'e.idtugasgurudosen')
                ->leftjoin('a_matkulpel as f', 'a.idmatkulpel', '=', 'f.idmatkulpel')
                ->leftjoin('a_sekolahswasta as h', 'a.iddiperbantukan', '=', 'h.id')
                ->leftjoin('a_esl as i', 'a.idesl', '=', 'i.idesl')
                ->where('a.id', '=', $rs->id_rpppk)
                ->where('a.nip', '=', $nip)
                ->first();

    if($flag != 1){
        $jabatan = ($item->idjabjbt!=$rs->idjabjbt)?'alert-dangers':'';
        $esl = ($item->esl!=$rs->esl)?'alert-dangers':'';
        $tmtesljbt = ($item->tmtesljbt!=$rs->tmtesljbt)?'alert-dangers':'';
        $stsesl = ($item->stsesl!=$rs->stsesl)?'alert-dangers':'';
    }
}
?>

<script type="text/javascript">
    @if(((count($rs) > 0)?$rs->isguru:0) == 1)
        $('{!!$act!!} #xtugasguru').fadeIn();
        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
        $('{!!$act!!} #xtugasdokterumum').fadeOut();
        $('{!!$act!!} #xnamadesa').fadeOut();
        @if(((count($rs) > 0)?$rs->isdiperbantukan:0) == 1)
            $('{!!$act!!} #xsekolahswasta').fadeIn();
        @endif
        @if(((count($rs) > 0)?$rs->iskepsek:0) == 1)
            $('{!!$act!!} #xkepalasekolah').fadeIn();
        @endif
    @elseif(((count($rs) > 0)?$rs->isguru:0) == 2)
        $('{!!$act!!} #xtugasguru').fadeOut();
        $('{!!$act!!} #xtugasdokter').fadeIn();
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

    $('{!!$act!!} #idesl').on('change', function(e){
        e.preventDefault();
        $('{!!$act!!} #esl').val($(this).find(":selected").text());
    });
</script>

@if(empty(Input::get('flag')))
    <div class="form-group">
        {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
        <div class="col-sm-7">
            <div style="width: auto;" class="" id="najab">
                <select name='idjab' class='form-control' id='idjab' style='width: 100%'></select>
                {!! Form::hidden('jab', ((count($rs) > 0)?$rs->jabatan:''), array('class'=> 'form-control', 'id'=> 'jab')) !!}
            </div>
        </div>
    </div>
@else
    @if(($flag == 1) or ($flag == 3))
        <div class="form-group">
            {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <div style="width: auto;" class="" id="najab">
                    <select name='idjab' class='form-control' id='idjab' style='width: 100%'></select>
                    {!! Form::hidden('jab', ((count($rs) > 0)?$rs->jabatan:''), array('class'=> 'form-control', 'id'=> 'jab')) !!}
                </div>
            </div>
        </div>
    @elseif($flag == 2)
        <div class="form-group">
            {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <div style="width: auto;" class="{!!$jabatan!!}" id="najab">
                    <select name='idjab' class='form-control' id='idjab' style='width: 100%'></select>
                    {!! Form::hidden('jab', ((count($rs) > 0)?$rs->jabatan:''), array('class'=> 'form-control', 'id'=> 'jab')) !!}
                </div>
            </div>
        </div>
    @endif
@endif

<span id="jabatanx">

    @if(($idjenjab == 20) or ($idjenjab == 30) or ($idjenjab == 40))
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', '{!!((count($rs) > 0)?$rs->idskpd:$idskpd)!!}', '{!!$idjenjab!!}');
            // autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', '{!!((count($rs) > 0)?$rs->idskpd:$idskpd)!!}', '{!!((count($rs) > 0)?$rs->idjenjab:$idjenjab)!!}');
            $('{!!$act!!} #idskpd').on('change', function(e){
                e.preventDefault();

                $('{!!$act!!} #idjenjab').on('change', function(e){
                    e.preventDefault();
                    var idjenjab = $(this).val();

                    $.ajax({
                        url:'{{url()}}/epersonal/biodata/jenisjabatan2',
                        type:'post',
                        data:{'idjenjab': $(this).val(), 'idskpd': $('{!!$act!!}  #idskpd').val(), 'nip': $('{!!$act!!}  #nip').val(), 'id': $('{!!$act!!}  #id').val(), 'tb':  "",'_token' : '{!!csrf_token()!!}', 'act': 'biodata'},
                        beforeSend:function(){
                            $('{!!$act!!} #jenisjabatan').html('Looading...');
                        },
                        success:function(respose){
                            $('{!!$act!!} #xjenisjabatan').html(respose);
                        }
                    })
                });

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
                        $('{!!$act!!} #idesl').select2('val',ret.idesl);
                    }
                })
            });

            if ($('{!!$act!!} :radio:checked').val() === '1') {
                $('{!!$act!!} .tmtesljbt').fadeIn();
            }else{
                $('{!!$act!!} .tmtesljbt').fadeOut();
            }

            $('{!!$act!!} .stsesl').on('change', function(e){
                e.preventDefault();
                var ischecked = $('{!!$act!!} :radio:checked').val();

                if (ischecked === '1') {
                    $('{!!$act!!} .tmtesljbt').fadeIn();
                }else{
                    $('{!!$act!!} .tmtesljbt').fadeOut();
                }
            });

            $("#jabatanx .date").mask("99-99-9999");
            $("#jabatanx .datepicker").datetimepicker({
                format: 'DD-MM-YYYY'
            });
        </script>

        @if(empty(Input::get('flag')))

            <div class="form-group">
                {!! Form::label('idesl', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboEselon("idesl",((count($rs) > 0)?$rs->idesl:''),"") !!}
                    {!! Form::hidden('esl', ((count($rs) > 0)?$rs->esl:''), array('class'=> 'form-control', 'id'=> 'esl')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('stsesl', 'Promosi Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <label class="radio-inline">
                        <input type="radio" value="1" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 1)?'checked':''):'')?> name="stsesl"> Ya
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 0)?'checked':''):'')?> name="stsesl"> Tidak
                    </label>
                </div>
            </div>
            <div class="form-group tmtesljbt">
                {!! Form::label('tmtesljbt', 'TMT Eselon:', array('class' => 'col-sm-3 control-label tmtesljbt')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                    {!! Form::text('tmtesljbt', ((count($rs) > 0)?date('d-m-Y', strtotime($rs->tmtesljbt)):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

        @else
            @if(($flag == 1) or ($flag == 3))
                <div class="form-group">
                    {!! Form::label('idesl', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        {!! comboEselon("idesl",((count($rs) > 0)?$rs->idesl:''),"") !!}
                        {!! Form::hidden('esl', ((count($rs) > 0)?$rs->esl:''), array('class'=> 'form-control', 'id'=> 'esl')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('stsesl', 'Promosi Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <label class="radio-inline">
                            <input type="radio" value="1" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 1)?'checked':''):'')?> name="stsesl"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 0)?'checked':''):'')?> name="stsesl"> Tidak
                        </label>
                    </div>
                </div>
                <div class="form-group tmtesljbt">
                    {!! Form::label('tmtesljbt', 'TMT Eselon:', array('class' => 'col-sm-3 control-label tmtesljbt')) !!}
                    <div class="col-sm-7">
                        <div class='input-group datepicker'>
                        {!! Form::text('tmtesljbt', ((count($rs) > 0)?date('d-m-Y', strtotime($rs->tmtesljbt)):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            @elseif($flag == 2)
                <div class="form-group">
                    {!! Form::label('idesl', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <div class='{!!$esl!!}'>
                        {!! comboEselon("idesl",((count($rs) > 0)?$rs->idesl:''),"") !!}
                        {!! Form::hidden('esl', ((count($rs) > 0)?$rs->esl:''), array('class'=> 'form-control', 'id'=> 'esl')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('stsesl', 'Promosi Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <div class='{!!$stsesl!!}'>
                        <label class="radio-inline">
                            <input type="radio" value="1" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 1)?'checked':''):'')?> name="stsesl"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" class="stsesl" <?php echo ((count($rs) > 0)?(($rs->stsesl == 0)?'checked':''):'')?> name="stsesl"> Tidak
                        </label>
                        </div>
                    </div>
                </div>
                <div class="form-group tmtesljbt">
                    {!! Form::label('tmtesljbt', 'TMT Eselon:', array('class' => 'col-sm-3 control-label tmtesljbt')) !!}
                    <div class="col-sm-7">
                        <div class='input-group {!!$tmtesljbt!!} datepicker'>
                        {!! Form::text('tmtesljbt', ((count($rs) > 0)?date('d-m-Y', strtotime($rs->tmtesljbt)):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    @elseif($idjenjab == 2)

        <script type="text/javascript">
            //autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfung', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', '');
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfung', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfung:'')!!}', '{!!((count($rs) > 0)?$rs->jabfung:'')!!}', '');
            autoComplete('{!!$act!!} #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idmatkulpel:'')!!}', '{!!((count($rs) > 0)?$rs->matkulpel:'')!!}', '');
            autoComplete('{!!$act!!} #iddiperbantukan', '{{url()}}/epersonal/biodata/sekolahswasta', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddiperbantukan:'')!!}', '{!!((count($rs) > 0)?$rs->nmasekolah:'')!!}', '');
            autoComplete('{!!$act!!} #idkepsek', '{{url()}}/epersonal/biodata/kepseksekolah', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idkepsek:'')!!}', '{!!((count($rs) > 0)?$rs->kepseksekolah:'')!!}', $('#idskpd').val());

            $('{!!$act!!} #idjab').on('change', function(e){
                e.preventDefault();
                var idjab = $('{!!$act!!} #idjab').val();
                if(idjab != null){
                    if(idjab.substr(0,3) == '120'){
                        $('{!!$act!!} #xtugasguru').fadeIn();
                        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
                        $('{!!$act!!} #xtugasdokterumum').fadeOut();
                    }else if(idjab.substr(0,3) == '009'){
                        $('{!!$act!!} #xtugasguru').fadeOut();
                        $('{!!$act!!} #xtugasdokterumum').fadeIn();
                        $('{!!$act!!} #xtugasdoktergigi').fadeOut();
                    }else if(idjab.substr(0,3) == '530'){
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
            }).trigger('change');

            $('{!!$act!!} #iskepsek').on('change', function(e){
                e.preventDefault();
                var iskepsek = $('{!!$act!!} #iskepsek').val();

                if(iskepsek == 1){
                    $('{!!$act!!} #xkepalasekolah').fadeIn();
                }else{
                    $('{!!$act!!} #xkepalasekolah').fadeOut();
                }

                autoComplete('{!!$act!!} #idkepsek', '{{url()}}/epersonal/biodata/kepseksekolah', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idkepsek:'')!!}', '{!!((count($rs) > 0)?$rs->kepseksekolah:'')!!}', $('#idskpd').val());
            }).trigger('change');

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
            <div class="form-group">
                {!! Form::label('isdiperbantukan', 'Status Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboYesno("isdiperbantukan",((count($rs) > 0)?$rs->isdiperbantukan:''),"")!!}
                </div>
            </div>
            <span id="xsekolahswasta">
                <div class="form-group">
                    {!! Form::label('iddiperbantukan', 'Sekolah Diperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7">
                        <select name="iddiperbantukan" class="form-control" id="iddiperbantukan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                    </div>
                </div>
            </span>
        </span>
        <span id="xtugasdoktergigi">
            <div class="form-group">
                {!! Form::label('idtugasdokter', 'Tugas Dokter:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboTgsdokter("idtugasdokter",((count($rs) > 0)?$rs->idtugasdokter:''),"","gigi")!!}
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
            {!! Form::label('nopak', 'Angka Kredit:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! Form::text('nopak', ((count($rs) > 0)?$rs->nopak:''), array('class'=> 'form-control', 'placeholder'=> 'Angka Kredit', 'maxlength'=> 10)) !!}
            </div>
        </div>
    @elseif($idjenjab == 3)
        <script type="text/javascript">
            //autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfungum', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', '');
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabfungum', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfungum:'')!!}', '{!!((count($rs) > 0)?$rs->jabfungum:'')!!}', '');
            autoComplete('{!!$act!!} #iddesa', '{{url()}}/epersonal/biodata/kelurahan', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddesa:'')!!}', '{!!((count($rs) > 0)?$rs->nmadesa:'')!!}', '');

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
    @elseif($idjenjab == 4)
        <script type="text/javascript">
            autoComplete('{!!$act!!} #idjab', '{{url()}}/epersonal/biodata/jabnonjob', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabnonjob:'')!!}', '{!!((count($rs) > 0)?$rs->jabnonjob:'')!!}', '');
        </script>
    @else
        <div class="form-group">
            {!! Form::label('idjab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjab' class='form-control' id='idjab' data-placeholder='.: Pilihan :.' style='width: 100%'></select>
                {!! Form::hidden('idesl', null, array('class'=> 'form-control')) !!}
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
