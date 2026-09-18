<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body">
               <!-- Custom Tabs -->
               <div class="nav-tabs-custom" style="box-shadow:none;">
                  <ul class="nav nav-tabs tab1" id="myTab2">
                     <li class="active"><a data-toggle="tab" href="#verpangkat"> <i class="fa fa-fw fa-check-square-o"></i> VERIFIKASI</a></li>
                     <li><a data-toggle="tab" href="#pangkat-akhir"> <i class="fa fa-fw fa-anchor"></i> PANGKAT TERAKHIR</a></li>
                  </ul>

                  <div class="tab-content">
                     <div id="verpangkat" class="tab-pane active">
                        <form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrpangkat" accept-charset="UTF-8">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <?php
                                            $id = Input::get('id');
                                            $nip = Input::get('nip');
                                            $flag = Input::get('flag');

                                            $item = \DB::table('r_gol_temp')
                                                ->select(
                                                'r_gol_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                                                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                                \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                                            )
                                                ->join('tb_01', 'r_gol_temp.nip', '=', 'tb_01.nip')
                                                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                                ->leftjoin('a_golruang', 'r_gol_temp.idgolru', '=', 'a_golruang.idgolru')
                                                ->leftjoin('a_penetapsk', 'r_gol_temp.pejmenpkt', '=', 'a_penetapsk.id')
                                                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                                ->where('r_gol_temp.id', $id)
                                                ->where('r_gol_temp.nip', $nip)
                                                ->first();

                                            $item2 = \DB::table('r_gol')
                                            ->select('r_gol.*', 'a_penetapsk.jabatan as pejmensk','a_golruang.pangkat', 'a_golruang.golru')
                                            ->leftjoin('a_golruang', 'r_gol.idgolru', '=', 'a_golruang.idgolru')
                                            ->leftjoin('a_penetapsk', 'r_gol.pejmenpkt', '=', 'a_penetapsk.id')
                                            ->where('r_gol.nip', $nip)
                                            ->where('r_gol.id', $item->id_rgol)
                                            ->first();

                                            if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                                                $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                                            }else{
                                                $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }

                                            if($flag != 1){
                                                $status = ($item->stspangkat!=$item2->stspangkat)?'alert-dangers':'';
                                                $golru = ($item->idgolru!=$item2->idgolru)?'alert-dangers':'';
                                                $pejmen = ($item->pejmenpkt!=$item2->pejmenpkt)?'alert-dangers':'';
                                                $nosk   = ($item->nosk!=$item2->nosk)?'alert-dangers':'';
                                                $tgsk   = ($item->tgsk!=$item2->tgsk)?'alert-dangers':'';
                                                $tmtsk  = ($item->tmtpkt!=$item2->tmtpkt)?'alert-dangers':'';
                                                $gapok  = ($item->gapok!=$item2->gapok)?'alert-dangers':'';
                                                $thkerja = ($item->thkerja!=$item2->thkerja)?'alert-dangers':'';
                                                $blkerja = ($item->blkerja!=$item2->blkerja)?'alert-dangers':'';
                                            }

                                            if($flag == 1){
                                                $title1 = " PENAMBAHAN DATA";
                                                $title2 = " PENAMBAHAN DATA";
                                            }else if($flag == 2){
                                                $title1 = " DATA AWAL";
                                                $title2 = " PERUBAHAN DATA";
                                            }else if($flag == 3){
                                                $title1 = " PENGHAPUSAN DATA";
                                                $title2 = " PENGHAPUSAN DATA";
                                            }else{
                                                $title1 = " - ";
                                                $title2 = " - ";
                                            }
                                        ?>

                                        @if(Input::get('flag') == 2)
                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT PANGKAT ({!!$title1!!})</h3>
                                            </div>

                                            <div class="box-body">
                                                <div class="col-md-12 data-awal">
                                                    <div class="form-group">
                                                        {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item->nip!='')?$item->nip:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->golru!='')?$item2->golru." / ".$item2->pangkat:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->pejmensk!='')?$item2->pejmensk:$item2->pejmenpkttext}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->nosk!='')?$item2->nosk:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tgsk!='0000-00-00')?date('d-m-Y', strtotime($item2->tgsk)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtpkt', 'TMT SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item2->tmtpkt)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-2">
                                                            <div class="form-control">{{($item2->thkerja!='')?$item2->thkerja:'-'}}</div>
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Tahun
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-control">{{($item2->blkerja!='')?$item2->blkerja:'-'}}</div>
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Bulan
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('gapok', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->gapok!='')?$item2->gapok:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('stspangkat', 'Status Pangkat:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <label class="radio-inline">
                                                                <input type="radio" disabled {{($item2->stspangkat=='1')?'checked':''}}> Awal CPNS
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" disabled {{($item2->stspangkat=='2')?'checked':''}}> Awal PNS
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" disabled {{($item2->stspangkat=='3')?'checked':''}}> Pangkat PNS
                                                            </label><br>
                                                            <em><small>(* Default Pangkat PNS jika bukan Awal CPNS atau PNS.)</small></em>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT PANGKAT ({!!$title2!!})</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-perubahan">
                                                    <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                                                    {!!csrf_field()!!}
                                                    {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                                                    {!! Form::hidden('id_rgol', null, array('class'=> 'form-control', 'id'=>'id_rgol')) !!}
                                                    {!! Form::hidden('user_id', session('user_id'), array('class'=> 'form-control')) !!}
                                                    {!! Form::hidden('role_id', null, array('class'=> 'form-control', 'id'=>'role_id')) !!}
                                                    {!! Form::hidden('idjnsaksi', null, array('class'=> 'form-control', 'id'=>'idjnsaksi')) !!}
                                                    @if($flag == 2)
                                                    <input type="hidden" name="status1" class="status1" value="{{$item->stspangkat}}">
                                                    <input type="hidden" name="status2" class="status2" value="{{$item2->stspangkat}}">
                                                    @endif
                                                    <div class="form-group">
                                                        {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! comboGolru("idgolru","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$golru!!} golru">
                                                                    {!! comboGolru("idgolru","","") !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! comboPenetapsk("pejmenpkt","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$pejmen!!} pejmen">
                                                                    {!! comboPenetapsk("pejmenpkt","","") !!}
                                                                </div>
                                                            @endif
                                                            {!! Form::hidden('pejmenpkttext', '', array('class'=> 'form-control', 'id'=>'pejmenpkttext')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        @if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SK')) !!}
                                                        @elseif($flag == 2)
                                                            {!! Form::text('nosk', null, array('class'=> 'form-control '.$nosk, 'placeholder'=> 'Nomor SK')) !!}
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tgsk!!} tgsk">
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtpkt', 'TMT SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tmtpkt', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tmtsk!!} tmtsk">
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tmtpkt', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-2">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('thkerja', null, array('class'=> 'form-control num '.$thkerja, 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Tahun
                                                        </div>
                                                        <div class="col-sm-2">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('blkerja', null, array('class'=> 'form-control num '.$blkerja, 'id'=> 'blkerja', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Bulan
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('gapok', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('gapok', null, array('class'=> 'form-control', 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('gapok', null, array('class'=> 'form-control '.$gapok, 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('stspangkat', 'Status Pangkat:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio1" value="1"> Awal CPNS
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio2" value="2"> Awal PNS
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio3" value="3"> Pangkat PNS
                                                                </label>
                                                             @else($flag == 2)
                                                                <label class="radio1 radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio1" value="1"> Awal CPNS
                                                                </label>
                                                                <label class="radio2 radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio2" value="2"> Awal PNS
                                                                </label>
                                                                <label class="radio0 radio-inline">
                                                                    <input type="radio" name="stspangkat" id="inlineRadio3" value="3"> Pangkat PNS
                                                                </label>
                                                             @endif
                                                            <br><em><small>(* Default Pangkat PNS jika bukan Awal CPNS atau PNS.)</small></em>
                                                        </div>
                                                    </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>

                                        @if((Input::get('flag') == 1) or (Input::get('flag') == 3))
                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PEGAWAI</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-awal">
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <td rowspan="5">
                                                                <div class="widget-user-image" align="center">
                                                                    <img alt="User Image" id='propic' class="img-circle" src="{!!$image!!}" width="128" height="128">
                                                                </div>
                                                            </td>
                                                            <td>NIP</td>
                                                            <td>:</td>
                                                            <td>{!!$item->nip!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>:</td>
                                                            <td>{!!$item->namalengkap!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>:</td>
                                                            <td>{!!$item->jabatan!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td>:</td>
                                                            <td>{!!$item->path!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="box box-warning">
                                        @if(Input::get('flag') == 2)
                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PEGAWAI</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-awal">
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <td rowspan="5">
                                                                <div class="widget-user-image" align="center">
                                                                    <img alt="User Image" id='propic' class="img-circle" src="{!!$image!!}" width="128" height="128">
                                                                </div>
                                                            </td>
                                                            <td>NIP</td>
                                                            <td>:</td>
                                                            <td>{!!$item->nip!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>:</td>
                                                            <td>{!!$item->namalengkap!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>:</td>
                                                            <td>{!!$item->jabatan!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td>:</td>
                                                            <td>{!!$item->path!!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-check"></i> VERIFIKASI SEMUA PERUBAHAN</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-verifikasi">
                                                    @if(session('role_id') <= 3)
                                                    <div class="form-group">
                                                        {!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <select name="status" id="status" class="form-control" required>
                                                                <option value="0">.: Pilihan :.</option>
                                                                <option value="1">Disetujui</option>
                                                                <option value="2">Ditolak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="xketditolak">
                                                        {!! Form::label('ketditolak', 'Keterangan :', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <textarea rows="5" cols="150" id="ketditolak" name="ketditolak" placeholder="Keterangan Jika Ditolak" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-7">
                                                            <div class="checkbox">
                                                                <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                                                <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="form-group">
                                                        {!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <span id='stspermohonan'></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('ketditolak', 'Keterangan :', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <span id='ketpermohonan'></span>
                                                        </div>
                                                    </div>
                                                    <em>* Perubahan biodata yang belum diverifikasi ditandai dengan inputan garis warna merah</em>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        </form>
                     </div>
                     <div id="pangkat-akhir" class="tab-pane">
                        <form id="prev-pangkatakhir" class="form-horizontal">
                           <div class="row ">
                              <div class="col-md-12">
                                 <!-- <div class="box box-primary"> -->
                                    <!-- <div class="box-body"> -->
                                       <div class="tab-content data-awal">
                                          <?php
                                             $nip = Input::get('nip');
                                             $item1 = getDetailpegawaiupdate($nip);
                                          ?>
                                          <div id="pangkatakhir" class="tab-pane active">
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>CPNS</small></b>
                                                      </div>
                                                   </p>
                                                   <div class="form-group">
                                                      {!! Form::label('pejmencpn', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->penetapcpn!='')?$item1->penetapcpn:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('idgolrucpn', 'Golongan :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->golrucpn!='')?$item1->golrucpn:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('noskcpn', ' NO. SK :', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK Gol.')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->noskcpn!='')?$item1->noskcpn:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('tgskcpn', ' TGL. SK :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tgskcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskcpn)):'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('tmtcpn', 'TMT :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtcpn)):'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('mkthncpn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkthncpn!='')?$item1->mkthncpn:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Tahun
                                                      </div>
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkblncpn!='')?$item1->mkblncpn:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Bulan
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
                                                                <div class="form-control nospmtcpn">{{($item1->nospmtcpn!='')?$item1->nospmtcpn:'-'}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7">
                                                                <div class="form-control tgspmtcpn">{{($item1->tgspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtcpn)):'-'}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7">
                                                                <div class="form-control tmtspmtcpn">{{($item1->tmtspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtcpn)):'-'}}</div>
                                                            </div>
                                                        </div>
                                                         <!-- End SPMT CPNS -->
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>PNS</small></b>
                                                      </div>
                                                   </p>
                                                   <div class="form-group">
                                                      {!! Form::label('pejmenpns', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control pejmenpns">{{($item1->penetappns!='')?$item1->penetappns:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('idgolrupns', 'Golongan :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control idgolrupns">{{($item1->golrupns!='')?$item1->golrupns:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('noskpns', ' NO. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control noskpns">{{($item1->noskpns!='')?$item1->noskpns:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tgskpns', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control tgskpns">{{($item1->tgskpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskpns)):'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tmtpns', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control tmtpns">{{($item1->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtpns)):'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('mkthnpns', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-2">
                                                          <div class="form-control mkthnpns">{{($item1->mkthnpns!='')?$item1->mkthnpns:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Tahun
                                                      </div>
                                                      <div class="col-sm-2">
                                                          <div class="form-control mkblnpns">{{($item1->mkblnpns!='')?$item1->mkblnpns:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Bulan
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
                                                               <div class="form-control nospmtpns">{{($item1->nospmtpns!='')?$item1->nospmtpns:'-'}}</div>
                                                           </div>
                                                       </div>
                                                       <div class="form-group">
                                                           {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               <div class="form-control tgspmtpns">{{($item1->tgspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtpns)):'-'}}</div>
                                                           </div>
                                                       </div>
                                                       <div class="form-group">
                                                           {!! Form::label('tmtspmtpns', ' TMT  SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               <div class="form-control tmtspmtpns">{{($item1->tmtspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtpns)):'-'}}</div>
                                                           </div>
                                                       </div>
                                                        <!-- End SPMT PNS -->
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>PANGKAT TERAKHIR</small></b>
                                                      </div>
                                                   </p>
                                                   <div class="form-group">
                                                      {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->penetappkt!='')?$item1->penetappkt:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('idgolrupkt', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->golrupkt!='')?$item1->golrupkt:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('noskpkt', ' NO. SK Gol.:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK Gol.')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->noskpkt!='')?$item1->noskpkt:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('tgskpkt', ' TGL. SK Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tgskpkt!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskpkt)):'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('tmtpkt', 'TMT Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtpkt)):'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('mkthnpkt', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkthnpkt!='')?$item1->mkthnpkt:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Tahun
                                                      </div>
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkblnpkt!='')?$item1->mkblnpkt:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Bulan
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                           <!-- /.tab-pane -->
                                       </div>
                                    <!-- </div> -->
                                 <!-- </div> -->
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<style type="text/css">
    .data-awal .form-control{
        height: auto;
        background-color: #ececec;
    }

    .alert-dangers{
        border: 2px solid red;
    }

    .modal {
      overflow: auto !important;
   }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var sts = $('.status1').val();
        var sts2 = $('.status2').val();
        if(sts == 1 && (sts!=sts2)){
            $('.radio1').addClass('alert-dangers');
        }else if(sts == 2 && (sts!=sts2)){
            $('.radio2').addClass('alert-dangers');
        }else if(sts == 0 && (sts!=sts2)){
            $('.radio0').addClass('alert-dangers');
        }
        $('.data-perubahan select').select2();
        $('.data-verifikasi select').select2();
        $('.data-perubahan #pejmenpkt').select2({
            tags: true
        });
        $('.data-perubahan .div-disabled').css('pointer-events','none');
        $('.data-verifikasi #status').on('change', function(e){
            e.preventDefault();
            var id = $('.data-verifikasi #status').val();
            if(id == 2){
                $('.data-verifikasi #xketditolak').fadeIn();
            }else{
                $('.data-verifikasi #xketditolak').fadeOut();
            }
        }).trigger('change');

        $('.data-perubahan #pejmenpkt').on('change', function(e){
            e.preventDefault();
            $('.data-perubahan #pejmenpkttext').val($(this).find(":selected").text());
        });

        $('#form-perubahan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Verifikasi Perubahan Riwayat ?',function(a){
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
                            if(html==4){
                                notification('Verifikasi Data Berhasil','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rpangkat').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rpangkat').trigger('click');
                                //refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $.ajax({
            url:'{!!url()!!}/epersonal/perubahanriwayat/editriwayat',
            type:'post',
            data:{'id':'{!!Input::get("id")!!}','tb':'r_gol_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk","tmtpkt");
                var arraytext = new Array("ketpermohonan","stspermohonan");
                var arrselect2 = new Array("pejmenpkt","idgolru");
                var arrayradio = new Array("stspangkat");
                if(ret){
                    for(attrname in ret){
                        $('.data-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arraytext)!=-1){
                            $('#'+attrname).html(ret[attrname]);
                        }
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('.data-perubahan #'+attrname).val(ret[attrname]).trigger('change.select2');
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('.data-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('.data-perubahan input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                        }
                    }

                    var text = ret.pejmenpkttext;
                    if(text.indexOf(ret.pejmenpkt) != -1){
                        var newOption = new Option(ret.pejmenpkttext, ret.pejmenpkt, false, true);
                        $('.data-perubahan #pejmenpkt').append(newOption).trigger('change');
                    }

                    @if(session('role_id') <= 3)
                    $('.data-verifikasi #status').select2('val',ret.status);
                    $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif
                }

                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });

        $('.data-perubahan select').select2();
        $('.data-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $(".data-perubahan .date").mask("99-99-9999");
        $(".data-perubahan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('.data-perubahan #idgolru').on('change', function(e){
            e.preventDefault();
            getgaji();
        });

        $('.data-perubahan #thkerja').on('keyup', function(e){
            e.preventDefault();
            getgaji();
        });
    });

    function getgaji(){
        var idgolru = $('.data-perubahan #idgolru').val();
        var mkthn = $('.data-perubahan #thkerja').val();

        $.ajax({
            url : '{!!url()!!}/epersonal/biodata/gaji',
            type : 'post',
            data : {'idgolru' : idgolru, 'mkthn' : mkthn, '_token' : '{!!csrf_token()!!}'},
            beforeSend : function(){},
            success : function(response){
                var ret = $.parseJSON(response);
                $('.data-perubahan #gapok').val(ret.gaji);
            }
        });
    }
</script>
