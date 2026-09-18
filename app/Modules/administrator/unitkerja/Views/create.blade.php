<section class="content-header">
    <h1>
        Buat Unit Kerja Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Unit Kerja</a></li>
        <li class="active">Buat Unit Kerja Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('skpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('skpd', null, array('class'=> 'form-control', 'placeholder'=> 'Nama Unit Kerja')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idparent', 'Parent Unit:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! comboSkpd("idparent","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('tmpidparent', 'Kode Parent dan Unit Kerja Terakhir:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('tmpidparent', null, array('class'=> 'form-control', 'placeholder'=> '(auto)', 'disabled'=>'disabled')) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::text('tmpidskpd', UnitkerjaModel::getLastidskpd(), array('class'=> 'form-control', 'id' => 'tmpidskpd', 'placeholder'=> '(auto)', 'disabled'=>'disabled')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Kode Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! Form::text('idskpd', null, array('class'=> 'form-control', 'placeholder'=> 'Isikan Dengan Kode Unit Kerja Terakhir')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('path', 'Path:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('path', null, array('class'=> 'form-control', 'placeholder'=> 'Path / Nama Lengkap Unit Kerja')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('path_short', 'Path Short:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('path_short', null, array('class'=> 'form-control', 'placeholder'=> 'Path / Nama Singkat Unit Kerja')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('jab', 'Penyebutan Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('jab', null, array('class'=> 'form-control', 'placeholder'=> 'Penyebutan Jabatan')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('jab_utuh', 'Penyebutan Jabatan Utuh:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('jab_utuh', null, array('class'=> 'form-control', 'placeholder'=> 'Penyebutan Jabatan')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idesl', 'Eselon:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! comboEselon("idesl","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('jab_asn', 'Jenis Jabatan ASN:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! comboJabasn("jab_asn","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('bup', 'Usia Pensiun:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! Form::text('bup', null, array('class'=> 'form-control num', 'placeholder'=>'Usia Pensiun', 'maxlength'=>2)) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('flag', 'Status Aktif:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! listPublish("flag","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('idsapk', 'idsapk:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('idsapk', null, array('class'=> 'form-control', 'placeholder'=> 'ID SIASN')) !!}
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            {!! ClaravelHelpers::btnSave() !!}
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<script>
    function refresh_page() {
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) - 1;
        unset($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/' . $index . '";';
        ?>
        $.ajax({
            url: index_page,
            type: 'GET',
            beforeSend: function() {
                preloader.on();
            },
            success: function(html) {
                preloader.off();
                $('#utama').html(html);
            }
        });
    }
    $(document).ready(function() {
        $('select').select2();
        $('.num').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $('#batalkan,#back').on('click', function(e) {
            e.preventDefault();
            refresh_page();
        });

        $('#idparent').on('change', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{url()}}/administrator/unitkerja/autoidskpd',
                type: 'post',
                data: {
                    'idparent': $(this).val(),
                    '_token': '{!!csrf_token()!!}'
                },
                success: function(response) {
                    var ret = $.parseJSON(response);
                    $('#tmpidparent').val(ret.idparent);
                    $('#idskpd').val(ret.idbaru);
                    $('#tmpidskpd').val(ret.lastid);
                    $('#path').val($('#skpd').val() + ' ' + ret.path);
                }
            });
        });

        $('#simpan').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?', function(a) {
                if (a == true) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        data: $this.serialize(),
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            if (html == '1') {
                                notification('Berhasil Disimpan', 'success');
                                refresh_page();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>