<div id="pangkat" class="tab-pane">
    <div class="row">
        <div class="col-md-6 div-disabled">
            <p>
            <div class="box-header with-border">
                <b class="box-title"><small>PANGKAT TERAKHIR</small></b>
            </div>
            </p>

            <div class="form-group">
                {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboPenetapsk("pejmenpkt","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idgolrupkt', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboGolru("idgolrupkt","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('noskpkt', ' NO. SK Gol.:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK Gol.')) !!}
                <div class="col-sm-7">
                    {!! Form::text('noskpkt', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Gol.')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgskpkt', ' TGL. SK Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgskpkt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtpkt', 'TMT Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtpkt', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('mkthnpkt', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-2">
                    {!! Form::text('mkthnpkt', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Tahun
                </div>
                <div class="col-sm-2">
                    {!! Form::text('mkblnpkt', null, array('class'=> 'form-control num', 'id'=> 'mkblnpkt', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Bulan
                </div>
            </div>
        </div>
    </div>
</div>
