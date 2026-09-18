<section class="content-header">
    <h1>
        Buat Nominatifpenjagaanpkpppk Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatifpenjagaanpkpppk</a></li>
        <li class="active">Buat Nominatifpenjagaanpkpppk Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
            <div class="box-body">
                				<div class="form-group">
					{!! Form::label('nama', 'nama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nama', null, array('class'=> 'form-control', 'placeholder'=>'nama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gdp', 'gdp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gdp', null, array('class'=> 'form-control', 'placeholder'=>'gdp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gdb', 'gdb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gdb', null, array('class'=> 'form-control', 'placeholder'=>'gdb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmlhr', 'tmlhr:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmlhr', null, array('class'=> 'form-control', 'placeholder'=>'tmlhr')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglhr', 'tglhr:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglhr', null, array('class'=> 'form-control', 'placeholder'=>'tglhr')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkel', 'idjenkel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkel', null, array('class'=> 'form-control', 'placeholder'=>'idjenkel')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idagama', 'idagama:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idagama', null, array('class'=> 'form-control', 'placeholder'=>'idagama')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idstspeg', 'idstspeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idstspeg', null, array('class'=> 'form-control', 'placeholder'=>'idstspeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkepeg', 'idjenkepeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkepeg', null, array('class'=> 'form-control', 'placeholder'=>'idjenkepeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenkedudupeg', 'idjenkedudupeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenkedudupeg', null, array('class'=> 'form-control', 'placeholder'=>'idjenkedudupeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('ket', 'ket:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('ket', null, array('class'=> 'form-control', 'placeholder'=>'ket')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtket', 'tmtket:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtket', null, array('class'=> 'form-control', 'placeholder'=>'tmtket')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idstskawin', 'idstskawin:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idstskawin', null, array('class'=> 'form-control', 'placeholder'=>'idstskawin')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('alm', 'alm:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('alm', null, array('class'=> 'form-control', 'placeholder'=>'alm')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almrt', 'almrt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almrt', null, array('class'=> 'form-control', 'placeholder'=>'almrt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almrw', 'almrw:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almrw', null, array('class'=> 'form-control', 'placeholder'=>'almrw')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almdesa', 'almdesa:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almdesa', null, array('class'=> 'form-control', 'placeholder'=>'almdesa')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almkec', 'almkec:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almkec', null, array('class'=> 'form-control', 'placeholder'=>'almkec')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almkab', 'almkab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almkab', null, array('class'=> 'form-control', 'placeholder'=>'almkab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almprov', 'almprov:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almprov', null, array('class'=> 'form-control', 'placeholder'=>'almprov')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almkdpos', 'almkdpos:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almkdpos', null, array('class'=> 'form-control', 'placeholder'=>'almkdpos')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idlokkel', 'idlokkel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idlokkel', null, array('class'=> 'form-control', 'placeholder'=>'idlokkel')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idlokkec', 'idlokkec:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idlokkec', null, array('class'=> 'form-control', 'placeholder'=>'idlokkec')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idlokkab', 'idlokkab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idlokkab', null, array('class'=> 'form-control', 'placeholder'=>'idlokkab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idlokpro', 'idlokpro:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idlokpro', null, array('class'=> 'form-control', 'placeholder'=>'idlokpro')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('telp', 'telp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('telp', null, array('class'=> 'form-control', 'placeholder'=>'telp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('hp', 'hp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('hp', null, array('class'=> 'form-control', 'placeholder'=>'hp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgoldarah', 'idgoldarah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgoldarah', null, array('class'=> 'form-control', 'placeholder'=>'idgoldarah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nokarpeg', 'nokarpeg:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nokarpeg', null, array('class'=> 'form-control', 'placeholder'=>'nokarpeg')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noaskes', 'noaskes:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noaskes', null, array('class'=> 'form-control', 'placeholder'=>'noaskes')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('notaspen', 'notaspen:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('notaspen', null, array('class'=> 'form-control', 'placeholder'=>'notaspen')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nokaris', 'nokaris:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nokaris', null, array('class'=> 'form-control', 'placeholder'=>'nokaris')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nonpwp', 'nonpwp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nonpwp', null, array('class'=> 'form-control', 'placeholder'=>'nonpwp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noktp', 'noktp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noktp', null, array('class'=> 'form-control', 'placeholder'=>'noktp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nobapertarum', 'nobapertarum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nobapertarum', null, array('class'=> 'form-control', 'placeholder'=>'nobapertarum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('photo', 'photo:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('photo', null, array('class'=> 'form-control', 'placeholder'=>'photo')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('userin', 'userin:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('userin', null, array('class'=> 'form-control', 'placeholder'=>'userin')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmstamp', 'tmstamp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmstamp', null, array('class'=> 'form-control', 'placeholder'=>'tmstamp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('userup', 'userup:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('userup', null, array('class'=> 'form-control', 'placeholder'=>'userup')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmstampup', 'tmstampup:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmstampup', null, array('class'=> 'form-control', 'placeholder'=>'tmstampup')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('password', 'password:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('password', null, array('class'=> 'form-control', 'placeholder'=>'password')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('lastlogin', 'lastlogin:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('lastlogin', null, array('class'=> 'form-control', 'placeholder'=>'lastlogin')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nobkncpn', 'nobkncpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nobkncpn', null, array('class'=> 'form-control', 'placeholder'=>'nobkncpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgbkncpn', 'tgbkncpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgbkncpn', null, array('class'=> 'form-control', 'placeholder'=>'tgbkncpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejmencpn', 'pejmencpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejmencpn', null, array('class'=> 'form-control', 'placeholder'=>'pejmencpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskcpn', 'noskcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskcpn', null, array('class'=> 'form-control', 'placeholder'=>'noskcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskcpn', 'tgskcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskcpn', null, array('class'=> 'form-control', 'placeholder'=>'tgskcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgolrucpn', 'idgolrucpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgolrucpn', null, array('class'=> 'form-control', 'placeholder'=>'idgolrucpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtcpn', 'tmtcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtcpn', null, array('class'=> 'form-control', 'placeholder'=>'tmtcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthncpn', 'mkthncpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthncpn', null, array('class'=> 'form-control', 'placeholder'=>'mkthncpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblncpn', 'mkblncpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblncpn', null, array('class'=> 'form-control', 'placeholder'=>'mkblncpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmttgscpn', 'tmttgscpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmttgscpn', null, array('class'=> 'form-control', 'placeholder'=>'tmttgscpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosttpdikcpn', 'nosttpdikcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosttpdikcpn', null, array('class'=> 'form-control', 'placeholder'=>'nosttpdikcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsttpdikcpn', 'tgsttpdikcpn:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsttpdikcpn', null, array('class'=> 'form-control', 'placeholder'=>'tgsttpdikcpn')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejmenpns', 'pejmenpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejmenpns', null, array('class'=> 'form-control', 'placeholder'=>'pejmenpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskpns', 'noskpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskpns', null, array('class'=> 'form-control', 'placeholder'=>'noskpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskpns', 'tgskpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskpns', null, array('class'=> 'form-control', 'placeholder'=>'tgskpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgolrupns', 'idgolrupns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgolrupns', null, array('class'=> 'form-control', 'placeholder'=>'idgolrupns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtpns', 'tmtpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpns', null, array('class'=> 'form-control', 'placeholder'=>'tmtpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idsumpahpns', 'idsumpahpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idsumpahpns', null, array('class'=> 'form-control', 'placeholder'=>'idsumpahpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nobknpkt', 'nobknpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nobknpkt', null, array('class'=> 'form-control', 'placeholder'=>'nobknpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgbknpkt', 'tgbknpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgbknpkt', null, array('class'=> 'form-control', 'placeholder'=>'tgbknpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejmenpkt', 'pejmenpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejmenpkt', null, array('class'=> 'form-control', 'placeholder'=>'pejmenpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskpkt', 'noskpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskpkt', null, array('class'=> 'form-control', 'placeholder'=>'noskpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskpkt', 'tgskpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskpkt', null, array('class'=> 'form-control', 'placeholder'=>'tgskpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgolrupkt', 'idgolrupkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgolrupkt', null, array('class'=> 'form-control', 'placeholder'=>'idgolrupkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtpkt', 'tmtpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpkt', null, array('class'=> 'form-control', 'placeholder'=>'tmtpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnpkt', 'mkthnpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnpkt', null, array('class'=> 'form-control', 'placeholder'=>'mkthnpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnpkt', 'mkblnpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnpkt', null, array('class'=> 'form-control', 'placeholder'=>'mkblnpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('akpkt', 'akpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('akpkt', null, array('class'=> 'form-control', 'placeholder'=>'akpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejmenkgb', 'pejmenkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejmenkgb', null, array('class'=> 'form-control', 'placeholder'=>'pejmenkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosuratkgb', 'nosuratkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosuratkgb', null, array('class'=> 'form-control', 'placeholder'=>'nosuratkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsuratkgb', 'tgsuratkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsuratkgb', null, array('class'=> 'form-control', 'placeholder'=>'tgsuratkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskkgb', 'noskkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskkgb', null, array('class'=> 'form-control', 'placeholder'=>'noskkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskkgb', 'tgskkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskkgb', null, array('class'=> 'form-control', 'placeholder'=>'tgskkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgolkgb', 'idgolkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgolkgb', null, array('class'=> 'form-control', 'placeholder'=>'idgolkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtkgb', 'tmtkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtkgb', null, array('class'=> 'form-control', 'placeholder'=>'tmtkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkgolthnkgb', 'mkgolthnkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkgolthnkgb', null, array('class'=> 'form-control', 'placeholder'=>'mkgolthnkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkgolblnkgb', 'mkgolblnkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkgolblnkgb', null, array('class'=> 'form-control', 'placeholder'=>'mkgolblnkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kantorkgb', 'kantorkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kantorkgb', null, array('class'=> 'form-control', 'placeholder'=>'kantorkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idsatker', 'idsatker:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idsatker', null, array('class'=> 'form-control', 'placeholder'=>'idsatker')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idsekolah', 'idsekolah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idsekolah', null, array('class'=> 'form-control', 'placeholder'=>'idsekolah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kdunit', 'kdunit:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kdunit', null, array('class'=> 'form-control', 'placeholder'=>'kdunit')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idskpd', 'idskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idskpd', null, array('class'=> 'form-control', 'placeholder'=>'idskpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpkdunit', 'tmpkdunit:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpkdunit', null, array('class'=> 'form-control', 'placeholder'=>'tmpkdunit')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidskpd', 'tmpidskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidskpd', null, array('class'=> 'form-control', 'placeholder'=>'tmpidskpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtskpd', 'tmtskpd:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtskpd', null, array('class'=> 'form-control', 'placeholder'=>'tmtskpd')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almloker', 'almloker:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almloker', null, array('class'=> 'form-control', 'placeholder'=>'almloker')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almlokertelp', 'almlokertelp:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almlokertelp', null, array('class'=> 'form-control', 'placeholder'=>'almlokertelp')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('sekolah', 'sekolah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('sekolah', null, array('class'=> 'form-control', 'placeholder'=>'sekolah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejmenjbt', 'pejmenjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejmenjbt', null, array('class'=> 'form-control', 'placeholder'=>'pejmenjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskjbt', 'noskjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskjbt', null, array('class'=> 'form-control', 'placeholder'=>'noskjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgskjbt', 'tgskjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgskjbt', null, array('class'=> 'form-control', 'placeholder'=>'tgskjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjab', 'idjenjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjab', null, array('class'=> 'form-control', 'placeholder'=>'idjenjab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idesljbt', 'idesljbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idesljbt', null, array('class'=> 'form-control', 'placeholder'=>'idesljbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtesljbt', 'tmtesljbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtesljbt', null, array('class'=> 'form-control', 'placeholder'=>'tmtesljbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('stsesl', 'stsesl:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('stsesl', null, array('class'=> 'form-control', 'placeholder'=>'stsesl')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idkeljab', 'idkeljab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idkeljab', null, array('class'=> 'form-control', 'placeholder'=>'idkeljab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabjbt', 'idjabjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabjbt', null, array('class'=> 'form-control', 'placeholder'=>'idjabjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfung', 'idjabfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfung', null, array('class'=> 'form-control', 'placeholder'=>'idjabfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabfungum', 'idjabfungum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabfungum', null, array('class'=> 'form-control', 'placeholder'=>'idjabfungum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjabnonjob', 'idjabnonjob:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjabnonjob', null, array('class'=> 'form-control', 'placeholder'=>'idjabnonjob')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iddesa', 'iddesa:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iddesa', null, array('class'=> 'form-control', 'placeholder'=>'iddesa')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nmadesa', 'nmadesa:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nmadesa', null, array('class'=> 'form-control', 'placeholder'=>'nmadesa')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidjenjab', 'tmpidjenjab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidjenjab', null, array('class'=> 'form-control', 'placeholder'=>'tmpidjenjab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidjabjbt', 'tmpidjabjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidjabjbt', null, array('class'=> 'form-control', 'placeholder'=>'tmpidjabjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidjabfung', 'tmpidjabfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidjabfung', null, array('class'=> 'form-control', 'placeholder'=>'tmpidjabfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidjabfungum', 'tmpidjabfungum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidjabfungum', null, array('class'=> 'form-control', 'placeholder'=>'tmpidjabfungum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmpidesljbt', 'tmpidesljbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmpidesljbt', null, array('class'=> 'form-control', 'placeholder'=>'tmpidesljbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtjbt', 'tmtjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtjbt', null, array('class'=> 'form-control', 'placeholder'=>'tmtjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtjabfung', 'tmtjabfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtjabfung', null, array('class'=> 'form-control', 'placeholder'=>'tmtjabfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nolantikjbt', 'nolantikjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nolantikjbt', null, array('class'=> 'form-control', 'placeholder'=>'nolantikjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglantikjbt', 'tglantikjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglantikjbt', null, array('class'=> 'form-control', 'placeholder'=>'tglantikjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tunjjbt', 'tunjjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tunjjbt', null, array('class'=> 'form-control', 'placeholder'=>'tunjjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idsumpahjbt', 'idsumpahjbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idsumpahjbt', null, array('class'=> 'form-control', 'placeholder'=>'idsumpahjbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskmutasijbt', 'noskmutasijbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskmutasijbt', null, array('class'=> 'form-control', 'placeholder'=>'noskmutasijbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglskmutasijbt', 'tglskmutasijbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglskmutasijbt', null, array('class'=> 'form-control', 'placeholder'=>'tglskmutasijbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtmutasijbt', 'tmtmutasijbt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtmutasijbt', null, array('class'=> 'form-control', 'placeholder'=>'tmtmutasijbt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtkpendid', 'idtkpendid:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtkpendid', null, array('class'=> 'form-control', 'placeholder'=>'idtkpendid')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjurusan', 'idjenjurusan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjurusan', null, array('class'=> 'form-control', 'placeholder'=>'idjenjurusan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idalmamater', 'idalmamater:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idalmamater', null, array('class'=> 'form-control', 'placeholder'=>'idalmamater')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('thijaz', 'thijaz:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('thijaz', null, array('class'=> 'form-control', 'placeholder'=>'thijaz')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noijaz', 'noijaz:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noijaz', null, array('class'=> 'form-control', 'placeholder'=>'noijaz')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('namasekolah', 'namasekolah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('namasekolah', null, array('class'=> 'form-control', 'placeholder'=>'namasekolah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almsekolah', 'almsekolah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almsekolah', null, array('class'=> 'form-control', 'placeholder'=>'almsekolah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kepsek', 'kepsek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kepsek', null, array('class'=> 'form-control', 'placeholder'=>'kepsek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtkpendidawal', 'idtkpendidawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtkpendidawal', null, array('class'=> 'form-control', 'placeholder'=>'idtkpendidawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenjurusanawal', 'idjenjurusanawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenjurusanawal', null, array('class'=> 'form-control', 'placeholder'=>'idjenjurusanawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('thijazawal', 'thijazawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('thijazawal', null, array('class'=> 'form-control', 'placeholder'=>'thijazawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noijazawal', 'noijazawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noijazawal', null, array('class'=> 'form-control', 'placeholder'=>'noijazawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('namasekolahawal', 'namasekolahawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('namasekolahawal', null, array('class'=> 'form-control', 'placeholder'=>'namasekolahawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('almsekolahawal', 'almsekolahawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('almsekolahawal', null, array('class'=> 'form-control', 'placeholder'=>'almsekolahawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kepsekawal', 'kepsekawal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kepsekawal', null, array('class'=> 'form-control', 'placeholder'=>'kepsekawal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('flag_dikprajab', 'flag_dikprajab:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('flag_dikprajab', null, array('class'=> 'form-control', 'placeholder'=>'flag_dikprajab')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iddikstru', 'iddikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iddikstru', null, array('class'=> 'form-control', 'placeholder'=>'iddikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nmdikstru', 'nmdikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nmdikstru', null, array('class'=> 'form-control', 'placeholder'=>'nmdikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmdikstru', 'tmdikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmdikstru', null, array('class'=> 'form-control', 'placeholder'=>'tmdikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('penyelenggara_dikstru', 'penyelenggara_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('penyelenggara_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'penyelenggara_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('angkatan_dikstru', 'angkatan_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('angkatan_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'angkatan_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgmul_dikstru', 'tgmul_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgmul_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'tgmul_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsel_dikstru', 'tgsel_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsel_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'tgsel_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jamhari_dikstru', 'jamhari_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jamhari_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'jamhari_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosttp_dikstru', 'nosttp_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosttp_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'nosttp_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsttp_dikstru', 'tgsttp_dikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsttp_dikstru', null, array('class'=> 'form-control', 'placeholder'=>'tgsttp_dikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iddikfung', 'iddikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iddikfung', null, array('class'=> 'form-control', 'placeholder'=>'iddikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nmdikfung', 'nmdikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nmdikfung', null, array('class'=> 'form-control', 'placeholder'=>'nmdikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmdikfung', 'tmdikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmdikfung', null, array('class'=> 'form-control', 'placeholder'=>'tmdikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('penyelenggara_dikfung', 'penyelenggara_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('penyelenggara_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'penyelenggara_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('angkatan_dikfung', 'angkatan_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('angkatan_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'angkatan_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgmul_dikfung', 'tgmul_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgmul_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'tgmul_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsel_dikfung', 'tgsel_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsel_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'tgsel_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jamhari_dikfung', 'jamhari_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jamhari_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'jamhari_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosttp_dikfung', 'nosttp_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosttp_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'nosttp_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsttp_dikfung', 'tgsttp_dikfung:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsttp_dikfung', null, array('class'=> 'form-control', 'placeholder'=>'tgsttp_dikfung')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iddiktek', 'iddiktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iddiktek', null, array('class'=> 'form-control', 'placeholder'=>'iddiktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nmdiktek', 'nmdiktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nmdiktek', null, array('class'=> 'form-control', 'placeholder'=>'nmdiktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmdiktek', 'tmdiktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmdiktek', null, array('class'=> 'form-control', 'placeholder'=>'tmdiktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('penyelenggara_diktek', 'penyelenggara_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('penyelenggara_diktek', null, array('class'=> 'form-control', 'placeholder'=>'penyelenggara_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('angkatan_diktek', 'angkatan_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('angkatan_diktek', null, array('class'=> 'form-control', 'placeholder'=>'angkatan_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgmul_diktek', 'tgmul_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgmul_diktek', null, array('class'=> 'form-control', 'placeholder'=>'tgmul_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsel_diktek', 'tgsel_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsel_diktek', null, array('class'=> 'form-control', 'placeholder'=>'tgsel_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jamhari_diktek', 'jamhari_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jamhari_diktek', null, array('class'=> 'form-control', 'placeholder'=>'jamhari_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nosttp_diktek', 'nosttp_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nosttp_diktek', null, array('class'=> 'form-control', 'placeholder'=>'nosttp_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgsttp_diktek', 'tgsttp_diktek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgsttp_diktek', null, array('class'=> 'form-control', 'placeholder'=>'tgsttp_diktek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gaji', 'gaji:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gaji', null, array('class'=> 'form-control', 'placeholder'=>'gaji')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('gajidasar', 'gajidasar:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('gajidasar', null, array('class'=> 'form-control', 'placeholder'=>'gajidasar')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('flagkaris', 'flagkaris:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('flagkaris', null, array('class'=> 'form-control', 'placeholder'=>'flagkaris')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtpensiun', 'tmtpensiun:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpensiun', null, array('class'=> 'form-control', 'placeholder'=>'tmtpensiun')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnpns', 'mkthnpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnpns', null, array('class'=> 'form-control', 'placeholder'=>'mkthnpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnpns', 'mkblnpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnpns', null, array('class'=> 'form-control', 'placeholder'=>'mkblnpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nmissu', 'nmissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nmissu', null, array('class'=> 'form-control', 'placeholder'=>'nmissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmlhrissu', 'tmlhrissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmlhrissu', null, array('class'=> 'form-control', 'placeholder'=>'tmlhrissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglhrissu', 'tglhrissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglhrissu', null, array('class'=> 'form-control', 'placeholder'=>'tglhrissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgnikah', 'tgnikah:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgnikah', null, array('class'=> 'form-control', 'placeholder'=>'tgnikah')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pendidumissu', 'pendidumissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pendidumissu', null, array('class'=> 'form-control', 'placeholder'=>'pendidumissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pekerissu', 'pekerissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pekerissu', null, array('class'=> 'form-control', 'placeholder'=>'pekerissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nipnrpissu', 'nipnrpissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nipnrpissu', null, array('class'=> 'form-control', 'placeholder'=>'nipnrpissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tunjissu', 'tunjissu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tunjissu', null, array('class'=> 'form-control', 'placeholder'=>'tunjissu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('rwthukdis', 'rwthukdis:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('rwthukdis', null, array('class'=> 'form-control', 'placeholder'=>'rwthukdis')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgcerai', 'tgcerai:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgcerai', null, array('class'=> 'form-control', 'placeholder'=>'tgcerai')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskcerai', 'noskcerai:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskcerai', null, array('class'=> 'form-control', 'placeholder'=>'noskcerai')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtkgbnext', 'tmtkgbnext:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtkgbnext', null, array('class'=> 'form-control', 'placeholder'=>'tmtkgbnext')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkblnkgb', 'mkblnkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkblnkgb', null, array('class'=> 'form-control', 'placeholder'=>'mkblnkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthnkgb', 'mkthnkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthnkgb', null, array('class'=> 'form-control', 'placeholder'=>'mkthnkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejkgb', 'pejkgb:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejkgb', null, array('class'=> 'form-control', 'placeholder'=>'pejkgb')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('pejpkt', 'pejpkt:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('pejpkt', null, array('class'=> 'form-control', 'placeholder'=>'pejpkt')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idgaji', 'idgaji:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idgaji', null, array('class'=> 'form-control', 'placeholder'=>'idgaji')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kdgaji', 'kdgaji:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kdgaji', null, array('class'=> 'form-control', 'placeholder'=>'kdgaji')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('karpeg_bu', 'karpeg_bu:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('karpeg_bu', null, array('class'=> 'form-control', 'placeholder'=>'karpeg_bu')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenhukum', 'idjenhukum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenhukum', null, array('class'=> 'form-control', 'placeholder'=>'idjenhukum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmthukdis1', 'tmthukdis1:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmthukdis1', null, array('class'=> 'form-control', 'placeholder'=>'tmthukdis1')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmthukdis2', 'tmthukdis2:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmthukdis2', null, array('class'=> 'form-control', 'placeholder'=>'tmthukdis2')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('email', 'email:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('email', null, array('class'=> 'form-control', 'placeholder'=>'email')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kel', 'kel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kel', null, array('class'=> 'form-control', 'placeholder'=>'kel')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('nopak', 'nopak:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('nopak', null, array('class'=> 'form-control', 'placeholder'=>'nopak')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgpak', 'tgpak:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgpak', null, array('class'=> 'form-control', 'placeholder'=>'tgpak')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tghonorer', 'tghonorer:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tghonorer', null, array('class'=> 'form-control', 'placeholder'=>'tghonorer')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('lokdikstru', 'lokdikstru:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('lokdikstru', null, array('class'=> 'form-control', 'placeholder'=>'lokdikstru')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenharga', 'idjenharga:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenharga', null, array('class'=> 'form-control', 'placeholder'=>'idjenharga')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgjenharga', 'tgjenharga:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgjenharga', null, array('class'=> 'form-control', 'placeholder'=>'tgjenharga')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tgjenhukum', 'tgjenhukum:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tgjenhukum', null, array('class'=> 'form-control', 'placeholder'=>'tgjenhukum')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('lokber', 'lokber:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('lokber', null, array('class'=> 'form-control', 'placeholder'=>'lokber')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idskpd1', 'idskpd1:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idskpd1', null, array('class'=> 'form-control', 'placeholder'=>'idskpd1')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idjenpens', 'idjenpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idjenpens', null, array('class'=> 'form-control', 'placeholder'=>'idjenpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtpens', 'tmtpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtpens', null, array('class'=> 'form-control', 'placeholder'=>'tmtpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskpens', 'noskpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskpens', null, array('class'=> 'form-control', 'placeholder'=>'noskpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglskpens', 'tglskpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglskpens', null, array('class'=> 'form-control', 'placeholder'=>'tglskpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglpens', 'tglpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglpens', null, array('class'=> 'form-control', 'placeholder'=>'tglpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('jbtpenetapens', 'jbtpenetapens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('jbtpenetapens', null, array('class'=> 'form-control', 'placeholder'=>'jbtpenetapens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('ketpens', 'ketpens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('ketpens', null, array('class'=> 'form-control', 'placeholder'=>'ketpens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglmeninggal', 'tglmeninggal:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglmeninggal', null, array('class'=> 'form-control', 'placeholder'=>'tglmeninggal')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tglujikesehatan', 'tglujikesehatan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tglujikesehatan', null, array('class'=> 'form-control', 'placeholder'=>'tglujikesehatan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('penerimapensiun', 'penerimapensiun:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('penerimapensiun', null, array('class'=> 'form-control', 'placeholder'=>'penerimapensiun')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtmasuk', 'tmtmasuk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtmasuk', null, array('class'=> 'form-control', 'placeholder'=>'tmtmasuk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iskepsek', 'iskepsek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iskepsek', null, array('class'=> 'form-control', 'placeholder'=>'iskepsek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idkepsek', 'idkepsek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idkepsek', null, array('class'=> 'form-control', 'placeholder'=>'idkepsek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tmtkepsek', 'tmtkepsek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tmtkepsek', null, array('class'=> 'form-control', 'placeholder'=>'tmtkepsek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('noskkepsek', 'noskkepsek:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('noskkepsek', null, array('class'=> 'form-control', 'placeholder'=>'noskkepsek')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idmatkulpel', 'idmatkulpel:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idmatkulpel', null, array('class'=> 'form-control', 'placeholder'=>'idmatkulpel')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtugasgurudosen', 'idtugasgurudosen:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtugasgurudosen', null, array('class'=> 'form-control', 'placeholder'=>'idtugasgurudosen')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('idtugasdokter', 'idtugasdokter:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('idtugasdokter', null, array('class'=> 'form-control', 'placeholder'=>'idtugasdokter')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('isdiperbantukan', 'isdiperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('isdiperbantukan', null, array('class'=> 'form-control', 'placeholder'=>'isdiperbantukan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('iddiperbantukan', 'iddiperbantukan:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('iddiperbantukan', null, array('class'=> 'form-control', 'placeholder'=>'iddiperbantukan')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('tinggi', 'tinggi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('tinggi', null, array('class'=> 'form-control', 'placeholder'=>'tinggi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('berat', 'berat:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('berat', null, array('class'=> 'form-control', 'placeholder'=>'berat')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('rambut', 'rambut:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('rambut', null, array('class'=> 'form-control', 'placeholder'=>'rambut')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('muka', 'muka:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('muka', null, array('class'=> 'form-control', 'placeholder'=>'muka')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('kulit', 'kulit:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('kulit', null, array('class'=> 'form-control', 'placeholder'=>'kulit')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('ciri', 'ciri:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('ciri', null, array('class'=> 'form-control', 'placeholder'=>'ciri')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('cacat', 'cacat:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('cacat', null, array('class'=> 'form-control', 'placeholder'=>'cacat')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('hobby1', 'hobby1:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('hobby1', null, array('class'=> 'form-control', 'placeholder'=>'hobby1')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('hobby2', 'hobby2:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('hobby2', null, array('class'=> 'form-control', 'placeholder'=>'hobby2')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('hobby3', 'hobby3:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('hobby3', null, array('class'=> 'form-control', 'placeholder'=>'hobby3')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mkthpns', 'mkthpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mkthpns', null, array('class'=> 'form-control', 'placeholder'=>'mkthpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('mktbpns', 'mktbpns:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('mktbpns', null, array('class'=> 'form-control', 'placeholder'=>'mktbpns')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('akret', 'akret:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('akret', null, array('class'=> 'form-control', 'placeholder'=>'akret')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('usiapens', 'usiapens:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('usiapens', null, array('class'=> 'form-control', 'placeholder'=>'usiapens')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('id_presensi', 'id_presensi:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('id_presensi', null, array('class'=> 'form-control', 'placeholder'=>'id_presensi')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('imei', 'imei:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('imei', null, array('class'=> 'form-control', 'placeholder'=>'imei')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('id_sapk', 'id_sapk:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('id_sapk', null, array('class'=> 'form-control', 'placeholder'=>'id_sapk')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('user_id', 'user_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('user_id', null, array('class'=> 'form-control', 'placeholder'=>'user_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('role_id', 'role_id:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('role_id', null, array('class'=> 'form-control', 'placeholder'=>'role_id')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('created_at', 'created_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('created_at', null, array('class'=> 'form-control', 'placeholder'=>'created_at')) !!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('updated_at', 'updated_at:', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-7">
						{!! Form::text('updated_at', null, array('class'=> 'form-control', 'placeholder'=>'updated_at')) !!}
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
    function refresh_page(){
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) -1;
        unset ($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/'.$index.'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        }); 
    }
    $(document).ready(function(){
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });
        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
