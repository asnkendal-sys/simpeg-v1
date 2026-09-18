<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body">
               <!-- Custom Tabs -->
               <div class="nav-tabs-custom" style="box-shadow:none;">
                  <ul class="nav nav-tabs tab1" id="myTab2">
                     <li class="active"><a data-toggle="tab" href="#verpppk"> <i class="fa fa-fw fa-check-square-o"></i> VERIFIKASI</a></li>
                     <li><a data-toggle="tab" href="#ppk-akhir"> <i class="fa fa-fw fa-anchor"></i> PPPK TERAKHIR</a></li>
                  </ul>

                  <div class="tab-content">
                     <div id="verpppk" class="tab-pane active">
                        <form id="form-rpppk" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrpppk" accept-charset="UTF-8">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <?php
                                            $id = Input::get('id');
                                            $nip = Input::get('nip');
                                            $flag = Input::get('flag');

                                            $item = \DB::table('r_pppk_temp')
                                                ->select(
                                                    'r_pppk_temp.*','r_pppk_temp.idskpd as kdskpd', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan as jabatanpenetap','tb_01.photo','tb_01.idskpd','a_skpd.path',
                                                    \DB::raw('if(r_pppk_temp.idjenjab>4, "Struktural", if(r_pppk_temp.idjenjab=2, "Fungsional Tertentu", if(r_pppk_temp.idjenjab=3, "Jabatan Pelaksana", "-"))) as jenis_jabatan'),
                                                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                                                )
                                                ->join('tb_01', 'r_pppk_temp.nip', '=', 'tb_01.nip')
                                                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                                ->leftjoin('a_esl', 'r_pppk_temp.idesl', '=', 'a_esl.idesl')
                                                ->leftjoin('a_tugasgurudosen', 'r_pppk_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                                                ->leftjoin('a_tugasdokter', 'r_pppk_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                                                ->leftjoin('a_penetapsk', 'r_pppk_temp.pejmen', '=', 'a_penetapsk.id')
                                                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                                ->where('r_pppk_temp.id', $id)
                                                ->where('r_pppk_temp.nip', $nip)
                                                ->first();

                                            $item2 = \DB::table('r_pppk')
                                            ->select('r_pppk.*', 'a_penetapsk.jabatan as pejmensk', 'a_esl.esl as elsjbt',
                                                \DB::raw('if(r_pppk.idjenjab>4, "Struktural", if(r_pppk.idjenjab=2, "Fungsional Tertentu", if(r_pppk.idjenjab=3, "Jabatan Pelaksana", "-"))) as jenis_jabatan'))
                                            ->leftjoin('a_penetapsk', 'r_pppk.pejmen', '=', 'a_penetapsk.id')
                                            ->leftjoin('a_esl', 'r_pppk.esl', '=', 'a_esl.idesl')
                                            ->where('r_pppk.nip', $nip)
                                            ->where('r_pppk.id', $item->id_rpppk)
                                            ->first();

  $dokumenpendukung = \DB::connection('efile_2017')->table('files_temp')
                                                        ->where('subjenis', '=', $item->id)
                                                        ->where('nip', '=', $item->nip)
                                                        ->where('jenis', '=', '6')
                                                        ->first();

                                            if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                                                $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                                            }else{
                                                $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }

                                            if($flag != 1){
                                                $nosk_pppk = ($item->nosk_pppk!=$item2->nosk_pppk)?'alert-dangers':'';
                                                $tglsk_pppk = ($item->tglsk_pppk!=$item2->tglsk_pppk)?'alert-dangers':'';
                                                $idskpd = ($item->kdskpd!=$item2->idskpd)?'alert-dangers':'';
                                                $jenjab = ($item->idjenjab!=$item2->idjenjab)?'alert-dangers':'';
                                                $najab  = ($item->idjab!=$item2->idjab)?'alert-dangers':'';
                                                $pejmen = ($item->pejmen!=$item2->pejmen)?'alert-dangers':'';
                                                $idgolru = ($item->idgolru!=$item2->idgolru)?'alert-dangers':'';
                                                $thkerja = ($item->thkerja!=$item2->thkerja)?'alert-dangers':'';
                                                $blkerja = ($item->blkerja!=$item2->blkerja)?'alert-dangers':'';
                                                $gaji = ($item->gaji!=$item2->gaji)?'alert-dangers':'';
                                                $nosk = ($item->nosk!=$item2->nosk)?'alert-dangers':'';
                                                $tgsk = ($item->tgsk!=$item2->tgsk)?'alert-dangers':'';
                                                $tmtawal = ($item->tmtawal!=$item2->tmtawal)?'alert-dangers':'';
                                                $tmtakhir = ($item->tmtakhir!=$item2->tmtakhir)?'alert-dangers':'';
                                                $sts_kontrak = ($item->sts_kontrak!=$item2->sts_kontrak)?'alert-dangers':'';
                                                $nosk_calon = ($item->nosk_calon!=$item2->nosk_calon)?'alert-dangers':'';
                                                $tglsk_calon = ($item->tglsk_calon!=$item2->tglsk_calon)?'alert-dangers':'';
                                                $nipbaru = ($item->nipbaru!=$item2->nipbaru)?'alert-dangers':'';
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
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT PPPk ({!!$title1!!})</h3>
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
                                                        {!! Form::label('nosk_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->nosk_pppk!='')?$item2->nosk_pppk:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tglsk_pppk', 'TGL. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tglsk_pppk!='')?$item2->tglsk_pppk:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idskpd','Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->skpd!='')?$item2->skpd:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->jenis_jabatan!='')?$item2->jenis_jabatan:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->jab!='')?$item2->jab:'-'}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('pejmen', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->pejmensk!='')?$item2->pejmensk:'-'}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->idgolru!='')?$item2->idgolru:'-'}}</div>
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
                                                        {!! Form::label('gaji', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->gaji!='')?$item2->gaji:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('nosk', 'NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->nosk!='')?$item2->nosk:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tgsk', 'TGL. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tgsk!='0000-00-00')?date('d-m-Y', strtotime($item2->tgsk)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtawal', 'TMT Mulai PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tmtawal!='0000-00-00')?date('d-m-Y', strtotime($item2->tmtawal)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tmtakhir', 'TMT Akhir PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tmtakhir!='0000-00-00')?date('d-m-Y', strtotime($item2->tmtakhir)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sts_kontrak', 'Status PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">
                                                                @if($item2->sts_kontrak == 1)
                                                                    Pengangkatan
                                                                @elseif($item2->sts_kontrak == 2)
                                                                    Perpanjangan
                                                                @else
                                                                    -
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($item2->sts_kontrak == 1)
                                                        <div class="form-group">
                                                            {!! Form::label('nosk_calon', ' NO. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7">
                                                                <div class="form-control">{{($item2->nosk_calon!='')?$item2->nosk_calon:'-'}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::label('tglsk_calon', 'TGL. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7">
                                                                <div class="form-control">{{($item2->tglsk_calon!='0000-00-00')?date('d-m-Y', strtotime($item2->tglsk_calon)):'-'}}</div>
                                                            </div>
                                                        </div>
                                                    @elseif($item2->sts_kontrak == 2)
                                                        <div class="form-group">
                                                            {!! Form::label('nipbaru', 'NIP Baru:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7">
                                                                <div class="form-control">{{($item2->nipbaru!='')?$item2->nipbaru:'-'}}</div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT JABATAN ({!!$title2!!})</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-perubahan">
                                                    <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                                                    {!!csrf_field()!!}
                                                    {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                                                    {!! Form::hidden('id_rpppk', null, array('class'=> 'form-control', 'id'=>'id_rpppk')) !!}
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
                                                        {!! Form::label('nosk_pppk', ' NO. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('nosk_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK PPPK')) !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$nosk_pppk!!} nosk_pppk">
                                                                    {!! Form::text('nosk_pppk', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK PPPK')) !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tglsk_pppk', 'TGL. SK PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tglsk_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tglsk_pppk!!} tglsk_pppk">
                                                                    <div class='input-group datepicker'>
                                                                        {!! Form::text('tglsk_pppk', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idskpd','Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                                {!! Form::hidden('skpd', '', array('class'=> 'form-control', 'id'=>'skpd')) !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$idskpd!!} idskpd">
                                                                    <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                                    {!! Form::hidden('skpd', '', array('class'=> 'form-control', 'id'=>'skpd')) !!}
                                                                </div>
                                                            @endif
                                                            <em><small>(* Isian Unit Kerja isi dengan sub unit kerja terkecil.)</small></em>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! comboJenjab("idjenjab","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$jenjab!!} jenjab">
                                                                    {!! comboJenjab("idjenjab","","") !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="xjenisjabatan">
                                                        <div class="form-group">
                                                            {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                            <div class="col-sm-7" id="jenisjabatan">
                                                                <select name="jab" class="form-control" id="jab" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('pejmen', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! comboPenetapsk("pejmen","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$pejmen!!} pejmen">
                                                                    {!! comboPenetapsk("pejmen","","") !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('idgolru', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! comboGolrupppk("idgolru","","") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$idgolru!!} idgolru">
                                                                    {!! comboGolrupppk("idgolru","","") !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                  <div class="form-group">
                                                      {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-2">
                                                          @if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$thkerja!!} thkerja">
                                                                  {!! Form::text('thkerja', null, array('class'=> 'form-control num', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Tahun
                                                      </div>
                                                      <div class="col-sm-2">
                                                          @if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$blkerja!!} blkerja">
                                                                  {!! Form::text('blkerja', null, array('class'=> 'form-control num', 'id'=> 'blkerja', 'maxlength'=> '2', 'placeholder'=> '00')) !!}
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                          Bulan
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('gaji', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                              <div class='input-group'>
                                                                  <span class="input-group-addon">Rp.</span>
                                                                  {!! Form::text('gaji', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                                                              </div>
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$gaji!!} gaji">
                                                                  <div class='input-group'>
                                                                      <span class="input-group-addon">Rp.</span>
                                                                      {!! Form::text('gaji', null, array('class'=> 'form-control num', 'placeholder'=> 'Gaji PPPK')) !!}
                                                                  </div>
                                                              </div>
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('nosk', 'NO. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('nosk', null, array('class'=> 'form-control tambah-rpppk', 'placeholder'=>'Nomor SK Perjanjian','id'=>'nosk', 'required'=>'required')) !!}
                                                          @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$nosk!!} nosk">
                                                                    {!! Form::text('nosk', null, array('class'=> 'form-control tambah-rpppk', 'placeholder'=>'Nomor SK Perjanjian','id'=>'nosk', 'required'=>'required')) !!}
                                                                </div>
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tgsk', 'TGL. SK Perjanjian:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                              <div class='input-group datepicker'>
                                                                  {!! Form::text('tgsk', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'Tanggal SK Perjanjian','id'=>'tgsk', 'required'=>'required')) !!}
                                                                  <span class="input-group-addon">
                                                                      <span class="glyphicon glyphicon-calendar"></span>
                                                                  </span>
                                                              </div>
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$tgsk!!} tgsk">
                                                                  <div class='input-group datepicker'>
                                                                      {!! Form::text('tgsk', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'Tanggal SK Perjanjian','id'=>'tgsk', 'required'=>'required')) !!}
                                                                      <span class="input-group-addon">
                                                                          <span class="glyphicon glyphicon-calendar"></span>
                                                                      </span>
                                                                  </div>
                                                              </div>
                                                          @endif
                                                      </div>
                                                  </div>


                                                  <div class="form-group">
                                                      {!! Form::label('tmtawal', 'TMT Mulai PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                              <div class='input-group datepicker'>
                                                                  {!! Form::text('tmtawal', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Awal','id'=>'tmtawal', 'required'=>'required')) !!}
                                                                  <span class="input-group-addon">
                                                                      <span class="glyphicon glyphicon-calendar"></span>
                                                                  </span>
                                                              </div>
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$tmtawal!!} tmtawal">
                                                                  <div class='input-group datepicker'>
                                                                      {!! Form::text('tmtawal', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Awal','id'=>'tmtawal', 'required'=>'required')) !!}
                                                                      <span class="input-group-addon">
                                                                          <span class="glyphicon glyphicon-calendar"></span>
                                                                      </span>
                                                                  </div>
                                                              </div>
                                                          @endif
                                                      </div>
                                                  </div>

                                                  <div class="form-group">
                                                      {!! Form::label('tmtakhir', 'TMT Akhir PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                              <div class='input-group datepicker'>
                                                                  {!! Form::text('tmtakhir', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Akhir','id'=>'tmtakhir', 'required'=>'required')) !!}
                                                                  <span class="input-group-addon">
                                                                      <span class="glyphicon glyphicon-calendar"></span>
                                                                  </span>
                                                              </div>
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$tmtakhir!!} tmtakhir">
                                                                  <div class='input-group datepicker'>
                                                                      {!! Form::text('tmtakhir', null, array('class'=> 'form-control date tambah-rpppk', 'placeholder'=>'TMT Akhir','id'=>'tmtakhir', 'required'=>'required')) !!}
                                                                      <span class="input-group-addon">
                                                                          <span class="glyphicon glyphicon-calendar"></span>
                                                                      </span>
                                                                  </div>
                                                              </div>
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('sts_kontrak', 'Status PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          @if(($flag == 1) or ($flag == 3))
                                                              <label class="radio-inline">
                                                                  <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio1" value="1" required> Pengangkatan
                                                              </label>
                                                              <label class="radio-inline">
                                                                  <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio2" value="2" required> Perpanjangan
                                                              </label>
                                                          @elseif($flag == 2)
                                                              <div style="width: auto;" class="{!!$sts_kontrak!!} sts_kontrak">
                                                                  <label class="radio-inline">
                                                                      <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio1" value="1" required> Pengangkatan
                                                                  </label>
                                                                  <label class="radio-inline">
                                                                      <input type="radio" name="sts_kontrak" class="sts_kontrak" id="inlineRadio2" value="2" required> Perpanjangan
                                                                  </label>
                                                              </div>
                                                          @endif
                                                          <p><em><small>(* Status Riwayat PPPK Perpanjangan akan merubah data NIP Keseluruhan data pegawai.)</small></em></p>
                                                      </div>
                                                  </div>

                                                  <div id="xpengangkatan">
                                                      <div class="form-group">
                                                          {!! Form::label('nosk_calon', ' NO. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('nosk_calon', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Calon PPPK')) !!}
                                                              @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$nosk_calon!!} nosk_calon">
                                                                    {!! Form::text('nosk_calon', null, array('class'=> 'form-control', 'placeholder'=> 'NO. SK Calon PPPK')) !!}
                                                                </div>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('tglsk_calon', 'TGL. SK Calon PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              @if(($flag == 1) or ($flag == 3))
                                                                  <div class='input-group datepicker'>
                                                                      {!! Form::text('tglsk_calon', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                  </div>
                                                              @elseif($flag == 2)
                                                                  <div style="width: auto;" class="{!!$tglsk_calon!!} tglsk_calon">
                                                                      <div class='input-group datepicker'>
                                                                          {!! Form::text('tglsk_calon', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                                      </div>
                                                                  </div>
                                                              @endif
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div id="xperpanjangan">
                                                      <div class="form-group">
                                                          {!! Form::label('nipbaru', 'NIP Baru:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('nipbaru', null, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai Baru')) !!}
                                                              @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tglsk_calon!!} tglsk_calon">
                                                                    {!! Form::text('nipbaru', null, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai Baru')) !!}
                                                                </div>
                                                              @endif
                                                          </div>
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
                                                            <div class="card-body">
                                                                <?php
                                                                $destinationPath = url() . '/efile/packages/upload/files/' . substr($dokumenpendukung->nip, 0, 4) . '/' . $dokumenpendukung->nip;
                                                                $imagependukung = $destinationPath . '/' . $dokumenpendukung->filename;
$destinationPathKosong = url() . '/packages/pdf/oops.pdf';
                                                                if (file_exists($imagependukung)) {

                                                                    echo '<iframe src="' . $imagependukung . '"
                                                                                    width="800" height="500" id="transkrip"></iframe>';
                                                                }else{
                                                                 echo '<iframe src="' . $destinationPathKosong . '"
                                                                                    width="800" height="500" id="transkrip"></iframe>';
                                                                }

                                                                ?>

                                                            </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="box box-warning">
                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-file"></i> FILES <small>(file dibawah ini akan otomatis terverifikasi bersama data riwayat)</small></h3>
                                            </div>
                                            <div class="box-body">
                                                <?php
                                                    $temp = \DB::table('r_pppk_temp')
                                                    ->where('id','=',\Input::get('id'))
                                                    ->where('nip','=',\Input::get('nip'))
                                                    ->where('id_rpppk','!=',0)
                                                    ->first();

                                                    if(count($temp) > 0){
                                                        $files = \DB::connection('efile_2017')->table('files')
                                                        ->where('nip','=',\Input::get('nip'))
                                                        ->where('subjenis','=',$temp->id_rpppk)
                                                        ->get();
                                                    }else{
                                                        $files = array();
                                                    }
                                                ?>
                                                <table class="table table-condensed" id="tabel-file">
                                                    <tr>
                                                        <td>Preview</td>
                                                        <td>Status</td>
                                                        <td>Aksi</td>
                                                    </tr>
                                                    @if(count($files) == 0)
                                                        <tr>
                                                            <td colspan="3">Tidak terdapat file</td>
                                                        </tr>
                                                    @endif
                                                    @foreach($files as $row)
                                                    <tr>
                                                        <td>
                                                            <a href="{!!url()!!}/packages/upload/files/{{\Input::get('nip')}}/{{$row->filename}}" target="_blank"><img src="{!!url()!!}/packages/image.php?width=200&image=/packages/upload/files/{{\Input::get('nip')}}/{{$row->filename}}" style="width: 200px;"></a>
                                                        </td>
                                                        <td>
                                                            {{$row->verified == 0 ? 'Belum Diverifikasi' : 'Sudah Diverifikasi'}}
                                                        </td>
                                                        <td>
                                                            @if($row->verified == 0)
                                                            <button type="button" class="btn btn-danger btn-xs" id="hapusfile" fileid="{{$row->id}}">Hapus</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
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
                     <div id="pppk-akhir" class="tab-pane">
                        <form id="prev-jabakhir" class="form-horizontal">
                           <div class="row ">
                              <div class="col-md-12">
                                 <!-- <div class="box box-primary"> -->
                                    <!-- <div class="box-body"> -->
                                       <div class="tab-content data-awal">
                                          <?php
                                             $nip = Input::get('nip');
                                             $item1 = getDetailpegawaiupdate($nip);
                                          ?>
                                          <div id="lokasijab" class="tab-pane active">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>LOKASI KERJA</small></b>
                                                      </div>
                                                   </p>
                                                   <div class="form-group">
                                                       {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control kdunit">{{($item1->unitskpd!='')?$item1->unitskpd:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control idskpd">{{($item1->skpd!='')?$item1->skpd:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control idstspeg">{{($item1->stspeg!='')?$item1->stspeg:'-'}}</div>
                                                       </div>

                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control  idjenkepeg">{{($item1->jenkepeg!='')?$item1->jenkepeg:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control  idjenkedudupeg">{{($item1->jenkedudupeg!='')?$item1->jenkedudupeg:'-'}}</div>
                                                       </div>
                                                   </div>
                                                </div>

                                                <div class="col-md-6 div-disabled">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>PPPK TERAKHIR</small></b>
                                                      </div>
                                                   </p>
                                                   <div class="form-group">
                                                      {!! Form::label('pejmenjbt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->penetappkt!='')?$item1->penetappkt:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->jenjab!='')?$item1->jenjab:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('idjabjbt', 'Nama Jabatan :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7" id="jenisjabatan">
                                                          <div class="form-control">{{($item1->jabatan!='')?$item1->jabatan:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  @if($item1->idjenjab == '1')
                                                  <div class="form-group">
                                                      <label class="col-sm-3 control-label" class="esl">Eselon:</label>
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->esl!='')?$item1->esl:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  @endif

                                                  @if($item1->isguru == '1')
                                                  <div class="form-group">
                                                      <label class="col-sm-3 control-label" class="tugasgurudosen">Tugas Guru:</label>
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tugasgurudosen!='')?$item1->tugasgurudosen:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-sm-3 control-label" class="matkulpel">Mata Pelajaran:</label>
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->matkulpel!='')?$item1->matkulpel:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  @endif

                                                  <div class="form-group">
                                                      {!! Form::label('noskjbt', ' NO. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->noskjbt!='')?$item1->noskjbt:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tgskjbt', 'TGL. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tgskjbt!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskjbt)):'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('tmtjbt', 'TMT Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtjbt)):'-'}}</div>
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
        $('#tabel-file').on('click','#hapusfile',function(){
            var fileid = $(this).attr('fileid');
            var $this =$(this);
            if(confirm("Hapus file ini?")){
                $.ajax({
                    url : '{!!url()!!}/hapusfile',
                    type : 'POST',
                    data : 'fileid='+fileid+'&role_id={{\Session::get("role_id")}}',
                    success:function(html){
                        $this.closest("tr").remove();
                    }
                });
            }
        });

        $('.data-perubahan select').select2();
        $('.data-perubahan #skpd').val($('#simpan #idskpd').find(":selected").text());
        autoComplete('.data-perubahan #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');
        $('.data-perubahan #idskpd').on('change', function(e){
            e.preventDefault();
            $('.data-perubahan #skpd').val($(this).find(":selected").text());
            $('.data-perubahan #idskpd2').addClass('alert-dangers');

            /*$(".data-perubahan #idjab, .data-perubahan #esl").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });*/
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

        $('.data-verifikasi select').select2();
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

        $('#xpengangkatan, #xperpanjangan').hide();
        $('input[name=sts_kontrak]').on('change', function(){
            var sts_kontrak = $('input[name="sts_kontrak"]:checked').val();
            if(sts_kontrak == 1){
                $('#xpengangkatan').fadeIn();
                $('#xperpanjangan').fadeOut();
            }else if(sts_kontrak == 2){
                $('#xpengangkatan').fadeOut();
                $('#xperpanjangan').fadeIn();
            }
        });

        $('#form-rpppk').on('submit',function(e){
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
                                $('#myTabs #rpppk').trigger('click');
                                // refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rpppk').trigger('click');
                                // refresh_page();
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_pppk_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk","tmtawal","tmtakhir","tglsk_calon","tglsk_pppk");
                var arrselect2 = new Array("idjenjab","jab","pejmen","idskpd","idgolru");
                var arraytext = new Array("ketpermohonan","stspermohonan");
                var arrayradio = new Array("sts_kontrak");
                if(ret){
                    for(attrname in ret){
                        $('.data-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arraytext)!=-1){
                            $('#'+attrname).html(ret[attrname]);
                        }
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('.data-perubahan #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('.data-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                        if($.inArray(attrname,arrayradio)!=-1){
                            $('#form-rpppk input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                        }
                    }

                    $(".data-perubahan #idskpd").data('select2').trigger('select', {
                        data: {"id":ret.idskpd,"text":ret.skpd}
                    });

                    $('input[name=sts_kontrak]').trigger('change');

                    @if(session('role_id') <= 3)
                        $('.data-verifikasi #status').select2('val',ret.status);
                        $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif
                }

                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });

        $('.data-perubahan #idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatanpppk',
                type:'post',
                data:{'idjenjab': $(this).val(), 'nip': $('.data-perubahan  #nip').val(), 'id': $('.data-perubahan  #id').val(), 'flag':  {!!$flag!!}, 'tb':  "r_pppk_temp",'_token' : '{!!csrf_token()!!}', 'act': 'riwayat'},
                beforeSend:function(){
                    $('.data-perubahan #jenisjabatan').html('Looading...');
                },
                success:function(respose){
                    @if($flag == 1)
                        $('.data-perubahan #xjenisjabatan').html(respose);
                    @elseif($flag == 2)
                        $('.data-perubahan #xjenisjabatan').html(respose);
                        @if($item->idjab!=$item2->idjab)
                            $('#najab').addClass('alert-dangers').css({"width":"auto"});
                        @endif
                    @elseif($flag == 3)
                        $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
                    @endif
                }
            })
        });
    });
</script>
