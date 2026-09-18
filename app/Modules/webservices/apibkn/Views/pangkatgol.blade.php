<div id="pangkatgol" class="tab-pane">
    <div class="row">
        <div class="col-md-6">
        <div class="div-disabled">
            <p>
            <div class="box-header with-border">
                <b class="box-title"><small>CPNS</small></b>
            </div>
            </p>

            <div class="form-group">
                {!! Form::label('pejmencpn', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboPenetapsk("pejmencpn","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idgolrucpn', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboGolru("idgolrucpn","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('noskcpn', ' NO. SK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                <div class="col-sm-7">
                    {!! Form::text('noskcpn', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgskcpn', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgskcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtcpn', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('mkthncpn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-2">
                    {!! Form::text('mkthncpn', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Tahun
                </div>
                <div class="col-sm-2">
                    {!! Form::text('mkblncpn', null, array('class'=> 'form-control num', 'id'=> 'mkblncpn', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Bulan
                </div>
            </div>
            </div>
            <div>
            <!-- Start SPMT CPNS -->
            <hr>
            <p>
                <div class="box-header with-border">
                    <b class="box-title"><small>SPMT CPNS</small></b>
                </div>
            </p>
            <div class="form-group">
                {!! Form::label('nospmtcpn', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. Surat SPMT')) !!}
                <div class="col-sm-7">
                    {!! Form::text('nospmtcpn', null, array('class'=> 'form-control', 'placeholder'=> 'NO. Surat SPMT')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgspmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtspmtcpn', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <!-- End SPMT CPNS -->
        </div>
        </div>


        <div class="col-md-6">
        <div class="div-disabled">
            <p>
            <div class="box-header with-border">
                <b class="box-title"><small>PNS</small></b>
            </div>
            </p>
            <div class="form-group">
                {!! Form::label('pejmenpns', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboPenetapsk("pejmenpns","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('idgolrupns', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! comboGolru("idgolrupns","","") !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('noskpns', ' NO. SK:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! Form::text('noskpns', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgskpns', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgskpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtpns', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('mkthnpns', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-2">
                    {!! Form::text('mkthnpns', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Tahun
                </div>
                <div class="col-sm-2">
                    {!! Form::text('mkblnpns', null, array('class'=> 'form-control num', 'id'=> 'mkblnpns', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                </div>
                <div class="col-sm-1" style="margin-top: 7px;">
                    Bulan
                </div>
            </div>
        </div>
        <div>
            <!-- Start SPMT PNS -->
            <hr>
            <p>
                <div class="box-header with-border">
                    <b class="box-title"><small>SPMT PNS</small></b>
                </div>
            </p>
            <div class="form-group">
                {!! Form::label('nospmtpns', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    {!! Form::text('nospmtpns', null, array('class'=> 'form-control', 'placeholder'=> 'NO. Surat SPMT')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tgspmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tmtspmtpns', ' TMT  SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-7">
                    <div class='input-group datepicker'>
                        {!! Form::text('tmtspmtpns', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <!-- End SPMT PNS -->
        </div>
        </div>
    </div>
</div>
