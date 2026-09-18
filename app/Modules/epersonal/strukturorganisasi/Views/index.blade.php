<section class="content-header">
    <h1>
        Struktur Organisasi <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Struktur Organisasi</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path().'/sotkview', 'method' => 'POST', 'target' => '_blank', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!! comboSkpdunit("idskpd",session('idskpd'),"") !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button class="btn btn-success" type="submit" id=""><i class="fa fa-street-view"></i> Lihat Struktur Organisasi</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('select').select2();
    });
</script>
