<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-body">
               <!-- Custom Tabs -->
               <div class="nav-tabs-custom" style="box-shadow:none;">
                  <ul class="nav nav-tabs tab1" id="myTab2">
                     <li class="active"><a data-toggle="tab" href="#verpend"> <i class="fa fa-fw fa-check-square-o"></i> VERIFIKASI</a></li>
                     <li><a data-toggle="tab" href="#pend-akhir"> <i class="fa fa-fw fa-graduation-cap"></i> PENDIDIKAN TERAKHIR</a></li>
                  </ul>

                  <div class="tab-content">
                     <div id="verpend" class="tab-pane active">
                        <form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrpend" accept-charset="UTF-8">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <?php
                                            $id = Input::get('id');
                                            $nip = Input::get('nip');
                                            $flag = Input::get('flag');

                                            $item = \DB::table('r_pend_temp')
                                                    ->select(
                                                    'r_pend_temp.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                                                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                                                )
                                                ->join('tb_01', 'r_pend_temp.nip', '=', 'tb_01.nip')
                                                ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                                ->leftjoin('a_tkpendid', 'r_pend_temp.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                                                ->leftjoin('a_jenjurusan', 'r_pend_temp.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                                                ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                                ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                                ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                                ->where('r_pend_temp.id', $id)
                                                ->where('r_pend_temp.nip', $nip)
                                                ->first();

                                            $item2 = \DB::table('r_pend')
                                            ->select('r_pend.*', 'a_tkpendid.tkpendid', 'a_jenjurusan.jenjurusan')
                                            ->leftjoin('a_tkpendid', 'r_pend.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                                            ->leftjoin('a_jenjurusan', 'r_pend.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                                            ->where('r_pend.nip', $nip)
                                            ->where('r_pend.id', $item->id_rpend)
                                            ->first();

                                            if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                                                $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                                            }else{
                                                $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                            }

                                            if($flag != 1){
                                            	$tkpendid = ($item->idtkpendid!=$item2->idtkpendid)?'alert-dangers':'';
                                            	$jenjurusan = ($item->idjenjurusan!=$item2->idjenjurusan)?'alert-dangers':'';
                                                $noijaz = ($item->noijaz!=$item2->noijaz)?'alert-dangers':'';
                                                $tgijaz = ($item->tgijaz!=$item2->tgijaz)?'alert-dangers':'';
                                                $namasekolah = ($item->namasekolah!=$item2->namasekolah)?'alert-dangers':'';
                                                $tempat = ($item->tempat!=$item2->tempat)?'alert-dangers':'';
                                                $kepsek   = ($item->kepsek!=$item2->kepsek)?'alert-dangers':'';
                                                $awal   = ($item->isawal!=$item2->isawal)?'alert-dangers':'';
                                                $akhir   = ($item->isakhir!=$item2->isakhir)?'alert-dangers':'';
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
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT PENDIDIKAN ({!!$title1!!})</h3>
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
                                                        {!! Form::label('idtkpendid', 'Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tkpendid!='')?$item2->tkpendid:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('jenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->jenjurusan!='')?$item2->jenjurusan:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->noijaz!='')?$item2->noijaz:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tgijaz', ' Tanggal Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tgijaz!='0000-00-00')?date('d-m-Y', strtotime($item2->tgijaz)):'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->namasekolah!='')?$item2->namasekolah:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tempat', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->tempat!='')?$item2->tempat:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control">{{($item2->kepsek!='')?$item2->kepsek:'-'}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-7">
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" disabled {{($item2->isawal=='1')?'checked':''}}> Awal CPNS/PPPK
                                                            </label>
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" disabled {{($item2->isakhir=='1')?'checked':''}}> Akhir PNS/PPPK
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT PENDIDIKAN ({!!$title2!!})</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-12 data-perubahan">
                                                    <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                                                    {!!csrf_field()!!}
                                                    {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                                                    {!! Form::hidden('id_rpend', null, array('class'=> 'form-control', 'id'=>'id_rpend')) !!}
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
                                                        {!! Form::label('idtkpendid', 'Tingkat Pendidikan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                       			{!! comboTkpendidikan($id="idtkpendid",$sel="",$required="") !!}
                                                            @elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$tkpendid!!} tkpendid">
                                                                	{!! comboTkpendidikan($id="idtkpendid",$sel="",$required="") !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('jenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                        		<select name="idjenjurusan" class="form-control" id="idjenjurusan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                            	{!! Form::hidden('jenjurusan', null, array('class'=> 'form-control','id'=>'jenjurusan')) !!}
                        									@elseif($flag == 2)
                                                                <div style="width: auto;" class="{!!$jenjurusan!!} jenjurusan">
                                                                	<select name="idjenjurusan" class="form-control" id="idjenjurusan" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                                            		{!! Form::hidden('jenjurusan', null, array('class'=> 'form-control','id'=>'jenjurusan')) !!}
                                                                </div>
                        									@endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        @if(($flag == 1) or ($flag == 3))
                                                        	{!! Form::text('noijaz', null, array('class'=> 'form-control', 'placeholder'=> 'Nomor Ijazah')) !!}
                        								@elseif($flag == 2)
                        									{!! Form::text('noijaz', null, array('class'=> 'form-control '.$noijaz, 'placeholder'=> 'Nomor Ijazah')) !!}
                        								@endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tgijaz', ' Tanggal Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tgijaz', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            @elseif($flag == 2)
                                                            <div style="width: auto;" class="{!!$tgijaz!!} tgijaz">
                                                            <div class='input-group datepicker'>
                                                                {!! Form::text('tgijaz', null, array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('namasekolah', null, array('class'=> 'form-control', 'placeholder'=> 'Nama Sekolah / Kampus')) !!}
                                                            @elseif($flag == 2)
                                                            {!! Form::text('namasekolah', null, array('class'=> 'form-control '.$namasekolah, 'placeholder'=> 'Nama Sekolah / Kampus')) !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('tempat', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                            {!! Form::text('tempat', null, array('class'=> 'form-control', 'placeholder'=> 'Alamat Sekolah / Kampus')) !!}
                                                            @elseif($flag == 2)
                                                            {!! Form::text('tempat', null, array('class'=> 'form-control '.$tempat, 'placeholder'=> 'Alamat Sekolah / Kampus')) !!}
                        									@endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            @if(($flag == 1) or ($flag == 3))
                        									{!! Form::text('kepsek', null, array('class'=> 'form-control', 'placeholder'=> 'Kepala Sekolah / Rektor')) !!}
                        									@elseif($flag == 2)
                        									{!! Form::text('kepsek', null, array('class'=> 'form-control '.$kepsek, 'placeholder'=> 'Kepala Sekolah / Rektor')) !!}
                        									@endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-7">
                                                        	@if(($flag == 1) or ($flag == 3))
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" name="isawal" value="1"> Awal CPNS
                                                            </label>
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" name="isakhir" value="1"> Akhir PNS
                                                            </label>
                                                            @elseif($flag == 2)
                                                            <label class="checkbox-inline {{$awal}}">
                                                                <input type="checkbox" name="isawal" value="1"> Awal CPNS
                                                            </label>
                                                            <label class="checkbox-inline {{$akhir}}">
                                                                <input type="checkbox" name="isakhir" value="1"> Akhir PNS
                                                            </label>
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
                     <div id="pend-akhir" class="tab-pane">
                        <form id="prev-pendakhir" class="form-horizontal">
                           <div class="row ">
                              <div class="col-md-12">
                                 <!-- <div class="box box-primary"> -->
                                    <!-- <div class="box-body"> -->
                                       <div class="tab-content data-awal">
                                          <?php
                                             $nip = Input::get('nip');
                                             $item1 = getDetailpegawaiupdate($nip);
                                          ?>
                                          <div id="pendakhir" class="tab-pane active">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small>PENDIDIKAN AWAL</small></b>
                                                      </div>
                                                   </p>

                                                   <div class="form-group">
                                                      {!! Form::label('idtkpendidawal', 'Pendidikan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->tkpendidawal!='')?$item1->tkpendidawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('idjenjurusanawal', 'Jurusan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->jenjurusanawal!='')?$item1->jenjurusanawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('noijazawal', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->noijazawal!='')?$item1->noijazawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('thijazawal', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->thijazawal!='')?$item1->thijazawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('namasekolahawal', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->namasekolahawal!='')?$item1->namasekolahawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('almsekolahawal', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->almsekolahawal!='')?$item1->almsekolahawal:'-'}}</div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      {!! Form::label('kepsekawal', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                          <div class="form-control">{{($item1->kepsekawal!='')?$item1->kepsekawal:'-'}}</div>
                                                      </div>
                                                  </div>

                                                </div>
                                                <div class="col-md-6">
                                                   <p>
                                                   <div class="box-header with-border">
                                                       <b class="box-title"><small>PENDIDIKAN AKHIR</small></b>
                                                   </div>
                                                   </p>

                                                   <div class="form-group">
                                                       {!! Form::label('idtkpendid', 'Pendidikan Terakhir:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->idtkpendid!='')?$item1->tkpendidakhir:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idjenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->idjenjurusan!='')?$item1->jenjurusanakhir:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->noijaz!='')?$item1->noijaz:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('thijaz', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->thijaz!='')?$item1->thijaz:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->namasekolah!='')?$item1->namasekolah:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('almsekolah', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->almsekolah!='')?$item1->almsekolah:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control">{{($item1->kepsek!='')?$item1->kepsek:'-'}}</div>
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

        $('.data-perubahan #idtkpendid').on('change', function(e){
            e.preventDefault();
            autoComplete('.data-perubahan #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
        });

        $('.data-perubahan #idjenjurusan').on('change', function(e){
            e.preventDefault();
            $('.data-perubahan #jenjurusan').val($(this).find(":selected").text());
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
                                $('#myTabs #rpend').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rpend').trigger('click');
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_pend_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgijaz");
                var arraycheck = new Array("isawal","isakhir");
                var arrselect2 = new Array("idtkpendid","idjenjurusan");
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
                        if($.inArray(attrname,arraycheck)!=-1){
                            $('.data-perubahan input[name='+attrname+']').attr('checked',((ret[attrname]==1)?true:false));
                        }
                    }

                    @if(session('role_id') <= 3)
                    $('.data-verifikasi #status').select2('val',ret.status);
                    $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif
                }

                autoComplete('.data-perubahan #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, ret.idjenjurusan, ret.jenjurusan, ret.idtkpendid);
                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });
    });
</script>
