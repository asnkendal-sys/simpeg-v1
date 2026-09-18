<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body">
               <!-- Custom Tabs -->
               <div class="nav-tabs-custom" style="box-shadow:none;">
                  <ul class="nav nav-tabs tab1" id="myTab2">
                     <li class="active"><a data-toggle="tab" href="#verkgb"> <i class="fa fa-fw fa-check-square-o"></i> VERIFIKASI</a></li>
                     <li><a data-toggle="tab" href="#kgb-akhir"> <i class="fa fa-fw fa-money"></i> KGB TERAKHIR</a></li>
                  </ul>

                  <div class="tab-content">
                     <div id="verkgb" class="tab-pane active">
                        <form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrkgb" accept-charset="UTF-8">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <?php
                                            $id = Input::get('id');
                                            $nip = Input::get('nip');
                                            $flag = Input::get('flag');

                                            $item = \DB::table('r_kgb_temp')
                                                ->select(
                                                    'r_kgb_temp.*', 'a_golruang.golru', 'a_golruang.pangkat', 'a_penetapsk.jabatan','tb_01.nip','tb_01.photo','tb_01.idskpd','a_skpd.path',
                                                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                                                )
                                                ->join('tb_01', 'r_kgb_temp.nip', '=', 'tb_01.nip')
                                                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                                ->leftjoin('a_golruang', 'r_kgb_temp.idgolru', '=', 'a_golruang.idgolru')
                                                ->leftjoin('a_penetapsk', 'r_kgb_temp.idpenetap', '=', 'a_penetapsk.id')
                                                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                                ->where('r_kgb_temp.id', $id)
                                                ->where('r_kgb_temp.nip', $nip)
                                                ->first();

                                            $item2 = \DB::table('r_kgb')
                                            ->select('r_kgb.*', 'a_penetapsk.jabatan as pejmensk','a_golruang.pangkat', 'a_golruang.golru')
                                            ->leftjoin('a_golruang', 'r_kgb.idgolru', '=', 'a_golruang.idgolru')
                                            ->leftjoin('a_penetapsk', 'r_kgb.idpenetap', '=', 'a_penetapsk.id')
                                            ->where('r_kgb.nip', $nip)
                                            ->where('r_kgb.id', $item->id_rkgb)
                                            ->first();

                                            if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                                                $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                                            }else{
                                                $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }

                                            if($flag != 1){
                                                $golru = ($item->idgolru!=$item2->idgolru)?'alert-dangers':'';
                                                $pejmen = ($item->idpenetap!=$item2->idpenetap)?'alert-dangers':'';
                                                $noskkgb   = ($item->noskkgb!=$item2->noskkgb)?'alert-dangers':'';
                                                $tmtkgb  = ($item->tmtkgb!=$item2->tmtkgb)?'alert-dangers':'';
                                                $tgskkgb  = ($item->tglkgb!=$item2->tglkgb)?'alert-dangers':'';
                                                $thkerja = ($item->mkthn!=$item2->mkthn)?'alert-dangers':'';
                                                $blkerja = ($item->mkbln!=$item2->mkbln)?'alert-dangers':'';
                                                $gapok  = ($item->gaji!=$item2->gaji)?'alert-dangers':'';
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
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT KGB ({!!$title1!!})</h3>
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
                                                            <div class="form-control">{{($item2->golru!='')?$item2->golru.' - '.$item2->pangkat:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idpenetap', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->pejmensk!='')?$item2->pejmensk:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('noskkgb', 'Nomor SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->noskkgb!='')?$item2->noskkgb:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtkgb', 'TMT KGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item2->tmtkgb)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tglkgb', 'Tanggal SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tglkgb!='0000-00-00')?date('d-m-Y', strtotime($item2->tglkgb)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('mkthn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-2">
                                                            <div class="form-control">{{($item->mkthn!='')?$item2->mkthn:'-'}}</div>
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Tahun
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-control">{{($item->mkbln!='')?$item2->mkbln:'-'}}</div>
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Bulan
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('gaji', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->gaji!='')?$item2->gaji:'-'}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT KGB ({!!$title2!!})</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-perubahan">
                                                    <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                                                    {!!csrf_field()!!}
                                                    {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                                                    {!! Form::hidden('id_rkgb', null, array('class'=> 'form-control', 'id'=>'id_rkgb')) !!}
                                                    {!! Form::hidden('user_id', session('user_id'), array('class'=> 'form-control')) !!}
                                                    {!! Form::hidden('role_id', null, array('class'=> 'form-control', 'id'=>'role_id')) !!}
                                                    {!! Form::hidden('idjnsaksi', null, array('class'=> 'form-control', 'id'=>'idjnsaksi')) !!}
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
                                                        {!! Form::label('idpenetap', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                               {!! comboPenetapsk("idpenetap","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$pejmen!!} pejmen">
                                                                    {!! comboPenetapsk("idpenetap","","") !!}
                                                                </div>
                                                            @endif
                                                            {!! Form::hidden('penetap', '', array('class'=> 'form-control', 'id'=>'penetap')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('noskkgb', 'Nomor SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('noskkgb', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SKKGB')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('noskkgb', null, array('class'=> 'form-control '.$noskkgb, 'placeholder'=>'Nomor SKKGB')) !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtkgb', 'TMT KGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tmtkgb', null, array('class'=> 'form-control date', 'placeholder'=>'TMT KGB')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            @elseif($flag == 2)
                                                            <div style="width: auto;" class="{!!$tmtkgb!!} tmtkgb">
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tmtkgb', null, array('class'=> 'form-control date', 'placeholder'=>'TMT KGB')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tglkgb', 'Tanggal SKKGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tglkgb', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            @elseif($flag == 2)
                                                            <div style="width: auto;" class="{!!$tgskkgb!!} tgskkgb">
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tglkgb', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('mkthn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-2">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('mkthn', null, array('class'=> 'form-control num', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('mkthn', null, array('class'=> 'form-control num '.$thkerja, 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Tahun
                                                        </div>
                                                        <div class="col-sm-2">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('mkbln', null, array('class'=> 'form-control num', 'id'=> 'mkbln', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('mkbln', null, array('class'=> 'form-control num '.$blkerja, 'id'=> 'mkbln', 'placeholder'=>'00', 'maxlength'=> '2')) !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1" style="margin-top: 7px;">
                                                            Bulan
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('gaji', 'Gaji Pokok:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('gaji', null, array('class'=> 'form-control', 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
                                                            @elseif($flag == 2)
                                                                {!! Form::text('gaji', null, array('class'=> 'form-control '.$gapok, 'placeholder'=>'Gaji Pokok', 'maxlength'=> '10')) !!}
                                                            @endif
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
                     <div id="kgb-akhir" class="tab-pane">
                        <form id="prev-kgbakhir" class="form-horizontal">
                           <div class="row ">
                              <div class="col-md-12">
                                 <!-- <div class="box box-primary"> -->
                                    <!-- <div class="box-body"> -->
                                       <div class="tab-content data-awal">
                                          <?php
                                             $nip = Input::get('nip');
                                             $item1 = getDetailpegawaiupdate($nip);
                                          ?>
                                          <div id="kgbakhir" class="tab-pane active">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>KGB TERAKHIR</small></b>
                                                      </div>
                                                   </p>

                                                   <div class="form-group">
                                                      {!! Form::label('pejmenkgb', 'Penetap:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->penetapkgb!='')?$item1->penetapkgb:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('idgolkgb', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->golrukgb!='')?$item1->golrukgb:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('noskkgb', 'NO. SP KGB:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->noskkgb!='')?$item1->noskkgb:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tgskkgb', ' TGL. SP:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tgskkgb!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskkgb)):'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tmtkgb', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtkgb)):'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('mkgolthnkgb', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkgolthnkgb!='')?$item1->mkgolthnkgb:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Tahun
                                                      </div>
                                                      <div class="col-sm-2">
                                                          <div class="form-control">{{($item1->mkgolblnkgb!='')?$item1->mkgolblnkgb:'-'}}</div>
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
                                       <!-- /.tab-content -->
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
        $('.data-verifikasi select').select2();
        $('.data-perubahan select').select2();
        $('.data-perubahan #idpenetap').select2({
            tags: true
        });
        $('.data-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $(".data-perubahan .date").mask("99-99-9999");
        $(".data-perubahan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
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

        $('.data-perubahan #idpenetap').on('change', function(e){
            e.preventDefault();
            $('.data-perubahan #penetap').val($(this).find(":selected").text());
        })

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
                                $('#myTabs #rkgb').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rkgb').trigger('click');
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_kgb_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tglkgb","tmtkgb");
                var arrselect2 = new Array("idpenetap","idgolru");
                var arraytext = new Array("ketpermohonan","stspermohonan");
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
                    }

                    var text = ret.penetap;
                    if(text.indexOf(ret.idpenetap) != -1){
                        var newOption = new Option(ret.penetap, ret.idpenetap, false, true);
                        $('.data-perubahan #idpenetap').append(newOption).trigger('change');
                    }

                    @if(session('role_id') <= 3)
                    $('.data-verifikasi #status').select2('val',ret.status);
                    $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif
                }

                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });

        $('.data-perubahan #idgolru').on('change', function(e){
            e.preventDefault();
            getgaji();
        });

        $('.data-perubahan #mkthn').on('keyup', function(e){
            e.preventDefault();
            getgaji();
        });
    });

    function getgaji(){
        var idgolru = $('.data-perubahan #idgolru').val();
        var mkthn = $('.data-perubahan #mkthn').val();

        $.ajax({
            url : '{!!url()!!}/epersonal/biodata/gaji',
            type : 'post',
            data : {'idgolru' : idgolru, 'mkthn' : mkthn, '_token' : '{!!csrf_token()!!}'},
            beforeSend : function(){},
            success : function(response){
                var ret = $.parseJSON(response);
                $('.data-perubahan #gaji').val(ret.gaji);
            }
        });
    }
</script>
