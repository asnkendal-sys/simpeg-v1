<form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrdiktek" accept-charset="UTF-8">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <?php
                    $id = Input::get('id');
                    $nip = Input::get('nip');
                    $flag = Input::get('flag');

                    $item = \DB::table('r_diktek_temp')
                        ->select(
                            'r_diktek_temp.*','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                        )
                        ->join('tb_01', 'r_diktek_temp.nip', '=', 'tb_01.nip')
                        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                        ->where('r_diktek_temp.id', $id)
                        ->where('r_diktek_temp.nip', $nip)
                        ->first();

                    $item2 = \DB::table('r_diktek')
                    ->select('r_diktek.*')
                    ->where('r_diktek.nip', $nip)
                    ->where('r_diktek.id', $item->id_rdiktek)
                    ->first();

$dokumenpendukung = \DB::connection('efile_2017')->table('files_temp')
                        ->where('subjenis', '=', $item->id)
                        ->where('nip', '=', $item->nip)
                        ->where('jenis', '=', '11')
                        ->first();

                    if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                        $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                    }else{
                        $image = url()."/packages/upload/photo/pegawai/default.jpg";
                    }

                    if($flag != 1){
                        $diktek        = ($item->nmdiktek!=$item2->nmdiktek)?'alert-dangers':'';
                        $penyelenggara  = ($item->penyelenggara!=$item2->penyelenggara)?'alert-dangers':'';
                        $tmdiktek      = ($item->tmdiktek!=$item2->tmdiktek)?'alert-dangers':'';
                        $angkatan       = ($item->angkatan!=$item2->angkatan)?'alert-dangers':'';
                        $tgmul          = ($item->tgmul!=$item2->tgmul)?'alert-dangers':'';
                        $tgsel          = ($item->tgsel!=$item2->tgsel)?'alert-dangers':'';
                        $jamhari        = ($item->jamhari!=$item2->jamhari)?'alert-dangers':'';
                        $nosttpdiktek   = ($item->nosttpdiktek!=$item2->nosttpdiktek)?'alert-dangers':'';
                        $tgsttpdiktek   = ($item->tgsttpdiktek!=$item2->tgsttpdiktek)?'alert-dangers':'';
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
                        <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT DIKLAT TEKNIS ({!!$title1!!})</h3>
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
                                {!! Form::label('nmdiktek', 'Nama Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->nmdiktek!='')?$item2->nmdiktek:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tmdiktek', 'Tempat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->tmdiktek!='')?$item2->tmdiktek:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('penyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->penyelenggara!='')?$item2->penyelenggara:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('angkatan', 'Angkatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->angkatan!='')?$item2->angkatan:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->tgmul!='0000-00-00')?date('d-m-Y', strtotime($item2->tgmul)):'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->tgsel!='0000-00-00')?date('d-m-Y', strtotime($item2->tgsel)):'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('jamhari', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->jamhari!='')?$item2->jamhari:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nosttpdiktek', 'No. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->nosttpdiktek!='')?$item2->nosttpdiktek:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgsttpdiktek', 'Tgl. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->tgsttpdiktek!='0000-00-00')?date('d-m-Y', strtotime($item2->tgsttpdiktek)):'-'}}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                @endif

                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT DIKLAT TEKNIS ({!!$title2!!})</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12 data-perubahan">
                            <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                            {!!csrf_field()!!}
                            {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                            {!! Form::hidden('id_rdiktek', null, array('class'=> 'form-control', 'id'=>'id_rdiktek')) !!}
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
                                {!! Form::label('nmdiktek', 'Nama Diklat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    {!! Form::text('nmdiktek', null, array('class'=> 'form-control', 'id'=> 'nmdiktek', 'placeholder'=>'Nama Diklat')) !!}
                                @elseif($flag == 2)
                                    {!! Form::text('nmdiktek', null, array('class'=> 'form-control '.$diktek, 'id'=> 'nmdiktek', 'placeholder'=>'Nama Diklat')) !!}
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tmdiktek', 'Tempat:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    {!! Form::text('tmdiktek', null, array('class'=> 'form-control', 'placeholder'=>'Tempat Diklat')) !!}
                                @elseif($flag == 2)
                                    {!! Form::text('tmdiktek', null, array('class'=> 'form-control '.$tmdiktek, 'placeholder'=>'Tempat Diklat')) !!}
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('penyelenggara', 'Penyelenggara:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    {!! Form::text('penyelenggara', null, array('class'=> 'form-control', 'placeholder'=>'Penyelenggara')) !!}
                                @elseif($flag == 2)
                                    {!! Form::text('penyelenggara', null, array('class'=> 'form-control '.$penyelenggara, 'placeholder'=>'Penyelenggara')) !!}
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('angkatan', 'Angkatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    {!! Form::text('angkatan', null, array('class'=> 'form-control', 'placeholder'=>'Angkatan')) !!}
                                @elseif($flag == 2)
                                  {!! Form::text('angkatan', null, array('class'=> 'form-control '.$angkatan, 'placeholder'=>'Angkatan')) !!}
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    <div class='input-group datepicker'>
                                        {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Mulai')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    @elseif($flag == 2)
                                    <div style="width: auto;" class="{!!$tgmul!!} tgmul">
                                     <div class='input-group datepicker'>
                                        {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Mulai')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    <div class='input-group datepicker'>
                                        {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Selesai')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    @elseif($flag == 2)
                                    <div style="width: auto;" class="{!!$tgsel!!} tgsel">
                                    <div class='input-group datepicker'>
                                        {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. Selesai')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('jamhari', 'Lama:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    <div class='input-group'>
                                        {!! Form::text('jamhari', null, array('class'=> 'form-control num', 'placeholder'=>'Lama hitungan jam')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                @elseif($flag == 2)
                                <div class='input-group {{$jamhari}}'>
                                  <div class='input-group'>
                                        {!! Form::text('jamhari', null, array('class'=> 'form-control num', 'placeholder'=>'Lama hitungan jam')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nosttpdiktek', 'No. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    {!! Form::text('nosttpdiktek', null, array('class'=> 'form-control', 'placeholder'=>'No. STTP')) !!}
                                @elseif($flag == 2)
                                    {!! Form::text('nosttpdiktek', null, array('class'=> 'form-control '.$nosttpdiktek, 'placeholder'=>'No. STTP')) !!}
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgsttpdiktek', 'Tgl. STTP:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                @if(($flag == 1) or ($flag == 3))
                                    <div class='input-group datepicker'>
                                        {!! Form::text('tgsttpdiktek', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. STTP')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                @elseif($flag == 2)
                                <div style="width: auto;" class="{!!$tgsttpdiktek!!} tgsttpdiktek">
                                 <div class='input-group datepicker'>
                                        {!! Form::text('tgsttpdiktek', null, array('class'=> 'form-control date', 'placeholder'=>'Tgl. STTP')) !!}
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

        $('#form-perubahan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Verifikasi Perubahan Riwayat ? <br/> Perubahan akan sinkron dengan data siasn',function(a){
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
                                $('#myTabs #rdiktek').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rdiktek').trigger('click');
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_diktek_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array('tgmul','tgsel','tgsttpdiktek');
                var arraytext = new Array("ketpermohonan","stspermohonan");
                if(ret){
                    for(attrname in ret){
                        $('.data-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arraytext)!=-1){
                            $('#'+attrname).html(ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('.data-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }

                    @if(session('role_id') <= 3)
                    $('.data-verifikasi #status').select2('val',ret.status);
                    $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif
                }

                $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
            }
        });
    });
</script>
