<script type="text/javascript">
    $('#simpan #jabatanx select').select2();
    $('#simpan #xsekolahswasta, #simpan #xkepalasekolah').fadeOut();

    @if(((count($rs) > 0)?$rs->isdiperbantukan:0) == 1)
        $('#simpan #xsekolahswasta').fadeIn();
    @endif
    @if(((count($rs) > 0)?$rs->isguru:0) == 1)
        $('#simpan #xtugasguru').fadeIn();
    $('#simpan #xtugasdokter').fadeOut();
    $('#simpan #xnamadesa').fadeOut();
    @if(((count($rs) > 0)?$rs->iskepsek:0) == 1)
        $('#simpan #xkepalasekolah').fadeIn();
    @endif
    @elseif(((count($rs) > 0)?$rs->isguru:0) == 2)
    $('#simpan #xtugasguru').fadeOut();
    $('#simpan #xtugasdokter').fadeIn();
    $('#simpan #xnamadesa').fadeOut();
    @elseif(((count($rs) > 0)?$rs->idjabfungum:0) == '4161004')
    $('#simpan #xtugasguru').fadeOut();
    $('#simpan #xtugasdokter').fadeOut();
    $('#simpan #xnamadesa').fadeIn();
    @else
    $('#simpan #xtugasguru, #simpan #xtugasdokter, #simpan #xnamadesa, #simpan #xsekolahswasta, #simpan #xkepalasekolah').fadeOut();
    @endif
</script>

<span id="jabatanx">

    @if(($idjenjab == 20) or ($idjenjab == 30) or ($idjenjab == 40))
        <script type="text/javascript">
            autoComplete('#simpan #idjabjbt', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabjbt:'')!!}', '{!!((count($rs) > 0)?$rs->jab:'')!!}', $('#simpan #idskpd').val());
            $('#simpan #idjabjbt').on('change', function(e){
                e.preventDefault();
                var idjabjbt = $(this).val();
                $.ajax({
                    url:'{{url()}}/epersonal/biodata/eselon',
                    type:'post',
                    data:{'idjabjbt': idjabjbt, '_token' : '{!!csrf_token()!!}'},
                    beforeSend:function(){},
                    success:function(response){
                        var ret = $.parseJSON(response);
                        $('#simpan #idesljbt').select2('val',ret.idesl);
                        $('#jabatanx .select2-selection, #jabatanx input').css('background-color','#ececec');
                    }
                })
            })
        </script>
        <div class="form-group">
            {!! Form::label('idjabjbt', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjabjbt' class='form-control' id='idjabjbt' style='width: 100%'></select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('idesljbt', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                {!! comboEselon("idesljbt",((count($rs) > 0)?$rs->idesljbt:''),"") !!}
            </div>
        </div>
    @elseif($idjenjab == 2)
        <script type="text/javascript">
            autoComplete('#simpan #idjabfung', '{{url()}}/epersonal/biodata/jabfung', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfung:'')!!}', '{!!((count($rs) > 0)?$rs->jabfung:'')!!}', '');
            autoComplete('#simpan #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idmatkulpel:'')!!}', '{!!((count($rs) > 0)?$rs->matkulpel:'')!!}', '');
            autoComplete('#simpan #iddiperbantukan', '{{url()}}/epersonal/biodata/sekolahswasta', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddiperbantukan:'')!!}', '{!!((count($rs) > 0)?$rs->nmasekolah:'')!!}', '');
            autoComplete('#simpan #idkepsek', '{{url()}}/epersonal/biodata/kepseksekolah', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idkepsek:'')!!}', '{!!((count($rs) > 0)?$rs->kepseksekolah:'')!!}', '');

            $('#simpan #idjabfung').on('change', function(e){
                e.preventDefault();
                var idjabfung = $('#simpan #idjabfung').val();
                if(idjabfung != null){
                    if(idjabfung.substr(0,3) == '300'){
                        $('#simpan #xtugasguru').fadeIn();
                        $('#simpan #xtugasdokter').fadeOut();
                    }else if(idjabfung.substr(0,3) == '220'){
                        $('#simpan #xtugasguru').fadeOut();
                        $('#simpan #xtugasdokter').fadeIn();
                    }else{
                        $('#simpan #xtugasguru, #simpan #xtugasdokter').fadeOut();
                    }
                }else{
                    $('#simpan #xtugasguru, #simpan #xtugasdokter, #simpan #xsekolahswasta, #simpan #xkepalasekolah').fadeOut();
                }
            });

            $('#simpan #iskepsek').on('change', function(e){
                e.preventDefault();
                var iskepsek = $('#simpan #iskepsek').val();

                if(iskepsek == 1){
                    $('#simpan #xkepalasekolah').fadeIn();
                }else{
                    $('#simpan #xkepalasekolah').fadeOut();
                }
            });

            $('#simpan #isdiperbantukan').on('change', function(e){
                e.preventDefault();
                var isdiperbantukan = $('#simpan #isdiperbantukan').val();

                if(isdiperbantukan == 1){
                    $('#simpan #xsekolahswasta').fadeIn();
                }else{
                    $('#simpan #xsekolahswasta').fadeOut();
                }
            });

            $('#simpan #idtugasgurudosen').on('change', function(e){
                e.preventDefault();
                autoComplete('#simpan #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '', '',  $(this).val());
                $('#jabatanx .select2-selection, #jabatanx input').css('background-color','#ececec');
            });
        </script>
        <div class="form-group">
            {!! Form::label('idjabfung', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjabfung' class='form-control' id='idjabfung' style='width: 100%'></select>
            </div>
        </div>
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
            </span>
        </span>
        <span id="xtugasdokter">
            <div class="form-group">
                {!! Form::label('idtugasdokter', 'Tugas Dokter:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboTgsdokter("idtugasdokter",((count($rs) > 0)?$rs->idtugasdokter:''),"")!!}
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
            autoComplete('#simpan #idjabfungum', '{{url()}}/epersonal/biodata/jabfungum', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabfungum:'')!!}', '{!!((count($rs) > 0)?$rs->jabfungum:'')!!}', '');
            autoComplete('#simpan #iddesa', '{{url()}}/epersonal/biodata/kelurahan', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddesa:'')!!}', '{!!((count($rs) > 0)?$rs->nmadesa:'')!!}', '');
            autoComplete('#simpan #iddiperbantukan', '{{url()}}/epersonal/biodata/sekolahswasta', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->iddiperbantukan:'')!!}', '{!!((count($rs) > 0)?$rs->nmasekolah:'')!!}', '');

            $('#simpan #idjabfungum').on('change', function(e){
                e.preventDefault();
                var idjab = $('#simpan #idjabfungum').val();
                if(idjab != null){
                    if(idjab == '4161004'){
                        $('#simpan #xnamadesa').fadeIn();
                    }else{
                        $('#simpan #xnamadesa').fadeOut();
                    }
                }else{
                    $('#simpan #xnamadesa').fadeOut();
                }
            });

            $('#simpan #isdiperbantukan').on('change', function(e){
                e.preventDefault();
                var isdiperbantukan = $('#simpan #isdiperbantukan').val();

                if(isdiperbantukan == 1){
                    $('#simpan #xsekolahswasta').fadeIn();
                }else{
                    $('#simpan #xsekolahswasta').fadeOut();
                }
            }).trigger('change');
        </script>
        <div class="form-group">
            {!! Form::label('idjabfungum', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjabfungum' class='form-control' id='idjabfungum' style='width: 100%'></select>
            </div>
        </div>
        <span id="xnamadesa">
            <div class="form-group">
                {!! Form::label('iddesa', 'Nama Desa:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="iddesa" class="form-control" id="iddesa" data-placeholder=".: Pilihan :." style="width: 100%"></select>
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
            autoComplete('#simpan #idjabnonjob', '{{url()}}/epersonal/biodata/jabnonjob', '.: Pilihan :.', null, '{!!((count($rs) > 0)?$rs->idjabnonjob:'')!!}', '{!!((count($rs) > 0)?$rs->jabnonjob:'')!!}', '');
        </script>
        <div class="form-group">
            {!! Form::label('idjabnonjob', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjabnonjob' class='form-control' id='idjabnonjob' style='width: 100%'></select>
            </div>
        </div>
    @else
        <div class="form-group">
            {!! Form::label('idjabjbt', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-7">
                <select name='idjabjbt' class='form-control' id='idjabjbt' data-placeholder='.: Pilihan :.' style='width: 100%'></select>
            </div>
        </div>
    @endif
</span>


<script type="text/javascript">
    $('#jabatanx .select2-selection, #jabatanx input').css('background-color','#ececec');
</script>