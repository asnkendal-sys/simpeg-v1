<div id="lokasijab" class="tab-pane">
    <div class="row">
        <div class="col-md-6">
            <p>
            <div class="box-header with-border">
                <b class="box-title"><small>LOKASI KERJA</small></b>
            </div>
            </p>
            <div class="form-group div-disabled">
                {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboSkpdunit("kdunit","","") !!}
                </div>
            </div>
            <div class="form-group div-disabled">
                {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <label class="radio-inline">
                        <input type="radio" name="idstspeg" id="idstspeg1" value="1" checked=""> CPNS
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="idstspeg" id="idstspeg2" value="2"> PNS
                    </label>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboJenkepeg("idjenkepeg","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboJenkedudupeg("idjenkedudupeg","","") !!}
                </div>
            </div>
        </div>
        <div class="col-md-6 div-disabled">
            <p>
            <div class="box-header with-border">
                <b class="box-title"><small>JABATAN TERAKHIR</small></b>
            </div>
            </p>
            <div class="form-group">
                {!! Form::label('pejmenjbt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboPenetapsk("pejmenjbt","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboJenjab("idjenjab","","") !!}
                </div>
            </div>
            <div id="xjenisjabatan">
                <div class="form-group">
                    {!! Form::label('idjabjbt', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-7" id="jenisjabatan">
                        <select name="idjabjbt" class="form-control" id="idjabjbt" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('noskjbt', ' NO. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! Form::text('noskjbt', null, array('class'=> 'form-control', 'placeholder'=> 'No. SK Jabatan')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgskjbt', 'TGL. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgskjbt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtjbt', 'TMT Jab:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtjbt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
