<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body">
               <!-- Custom Tabs -->
               <div class="nav-tabs-custom" style="box-shadow:none;">
                  <ul class="nav nav-tabs tab1" id="myTab2">
                     <li class="active"><a data-toggle="tab" href="#verjab"> <i class="fa fa-fw fa-check-square-o"></i> VERIFIKASI</a></li>
                     <li><a data-toggle="tab" href="#jab-akhir"> <i class="fa fa-fw fa-anchor"></i> JABATAN TERAKHIR</a></li>
                  </ul>

                  <div class="tab-content">
                     <div id="verjab" class="tab-pane active">
                        <form id="form-rjab" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrjab" accept-charset="UTF-8">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <?php
                                            $id = Input::get('id');
                                            $nip = Input::get('nip');
                                            $flag = Input::get('flag');

                                            $item = \DB::table('r_jab_temp')
                                                ->select(
                                                    'r_jab_temp.*','r_jab_temp.idskpd as kdskpd', 'a_esl.esl as elsjbt', 'a_tugasgurudosen.tugasgurudosen', 'a_tugasdokter.tugasdokter', 'a_penetapsk.jabatan as jabatanpenetap','tb_01.photo','tb_01.idskpd','a_skpd.path',
                                                    \DB::raw('if(r_jab_temp.idjenjab>4, "Struktural", if(r_jab_temp.idjenjab=2, "Fungsional Tertentu", if(r_jab_temp.idjenjab=3, "Jabatan Pelaksana", "-"))) as jenis_jabatan'),
                                                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                                                )
                                                ->join('tb_01', 'r_jab_temp.nip', '=', 'tb_01.nip')
                                                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                                ->leftjoin('a_esl', 'r_jab_temp.idesljbt', '=', 'a_esl.idesl')
                                                ->leftjoin('a_tugasgurudosen', 'r_jab_temp.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
                                                ->leftjoin('a_tugasdokter', 'r_jab_temp.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
                                                ->leftjoin('a_penetapsk', 'r_jab_temp.pejmen', '=', 'a_penetapsk.id')
                                                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                                ->where('r_jab_temp.id', $id)
                                                ->where('r_jab_temp.nip', $nip)
                                                ->first();

                                            $item2 = \DB::table('r_jab')
                                            ->select('r_jab.*', 'a_penetapsk.jabatan as pejmensk',
                                                \DB::raw('if(r_jab.idjenjab>4, "Struktural", if(r_jab.idjenjab=2, "Fungsional Tertentu", if(r_jab.idjenjab=3, "Jabatan Pelaksana", "-"))) as jenis_jabatan'))
                                            ->leftjoin('a_penetapsk', 'r_jab.pejmen', '=', 'a_penetapsk.id')
                                            ->where('r_jab.nip', $nip)
                                            ->where('r_jab.id', $item->id_rjab)
                                            ->first();

                                            if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                                                $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                                            }else{
                                                $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }

                                            if($flag != 1){
                                                $idskpd = ($item->kdskpd!=$item2->idskpd)?'alert-dangers':'';
                                                $jenjab = ($item->idjenjab!=$item2->idjenjab)?'alert-dangers':'';
                                                $najab  = ($item->idjab!=$item2->idjab)?'alert-dangers':'';
                                                $pejmen = ($item->pejmen!=$item2->pejmen)?'alert-dangers':'';
                                                $nosk   = ($item->nosk!=$item2->nosk)?'alert-dangers':'';
                                                $tgsk   = ($item->tgsk!=$item2->tgsk)?'alert-dangers':'';
                                                $tmtjab = ($item->tmtjab!=$item2->tmtjab)?'alert-dangers':'';
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
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT JABATAN ({!!$title1!!})</h3>
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
                                                        {!! Form::label('tmtjab', 'TMT Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tmtjab!='0000-00-00')?date('d-m-Y', strtotime($item2->tmtjab)):'-'}}</div>
                                                        </div>
                                                    </div>
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
                                                    {!! Form::hidden('id_rjab', null, array('class'=> 'form-control', 'id'=>'id_rjab')) !!}
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
                                                        {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                {!! Form::text('nosk', null, array('class'=> 'form-control ', 'placeholder'=> 'Nomor SK')) !!}
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
                                                        {!! Form::label('tmtjab', 'TMT Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tmtjab', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tmtjab!!} tmtjab">
                                                                <div class='input-group datepicker'>
                                                                    {!! Form::text('tmtjab', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                                </div>
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
                     <div id="jab-akhir" class="tab-pane">
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
                                                         <b class="box-title"><small>JABATAN TERAKHIR</small></b>
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
        $('.data-perubahan select').select2();
        $('.data-perubahan #skpd').val($('#simpan #idskpd').find(":selected").text());
        autoComplete('.data-perubahan #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');
        $('.data-perubahan #idskpd').on('change', function(e){
            e.preventDefault();
            $('.data-perubahan #skpd').val($(this).find(":selected").text());
            $('.data-perubahan #idskpd2').addClass('alert-dangers');

            /*$(".data-perubahan #idjab, .data-perubahan #idesljbt").data('select2').trigger('select', {
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

        $('#form-rjab').on('submit',function(e){
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
                                $('#myTabs #rjab').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rjab').trigger('click');
                                //refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
		
		$('.data-perubahan #idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            /*$.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan2',
                type:'post',
                data:{'idjenjab': idjenjab, 'idskpd': $('.data-perubahan  #idskpd').val(), 'nip': $('.data-perubahan  #nip').val(), 'id': $('.data-perubahan  #id').val(), 'flag':  $('.data-perubahan  #idjnsaksi').val() 'tb':  "r_jab_temp",'_token' : '{!!csrf_token()!!}', 'act': 'riwayat'},
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
            })*/

            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan2',
                type:'post',
                data:{'idjenjab': idjenjab, 'idskpd': $('.data-perubahan  #idskpd').val(), 'nip': $('.data-perubahan  #nip').val(), 'id': $('.data-perubahan  #id').val(), /*'flag':  $('.data-perubahan  #idjnsaksi').val()*/ 'tb':  "r_jab_temp",'_token' : '{!!csrf_token()!!}', 'act': 'riwayat'},
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
		    $('.data-perubahan #xjenisjabatan').html(respose);
                    $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
                @endif
                }
            })
        });

        $.ajax({
            url:'{!!url()!!}/epersonal/perubahanriwayat/editriwayat',
            type:'post',
            data:{'id':'{!!Input::get("id")!!}','tb':'r_jab_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk","tmtjab");
                var arrselect2 = new Array("idjenjab","jab","pejmen","idskpd");
                var arraytext = new Array("ketpermohonan","stspermohonan");
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
                    }

                    $(".data-perubahan #idskpd").data('select2').trigger('select', {
                        data: {"id":ret.idskpd,"text":ret.skpd}
                    });

                    @if(session('role_id') <= 3)
                        $('.data-verifikasi #status').select2('val',ret.status);
                        $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif

                    getistt(ret.idjenjab, ret.idskpd);
                }

                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });


    });

    function getistt(idjenjab, idskpd){
        $.ajax({
            url:'{{url()}}/epersonal/biodata/jenisjabatan2',
            type:'post',
            data:{'idjenjab': idjenjab,'idskpd': idskpd, 'nip': $('.data-perubahan  #nip').val(), 'id': $('.data-perubahan  #id').val(), /*'flag':  $('.data-perubahan  #idjnsaksi').val()*/ 'tb':  "r_jab_temp",'_token' : '{!!csrf_token()!!}', 'act': 'riwayat'},
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
    }
</script>
