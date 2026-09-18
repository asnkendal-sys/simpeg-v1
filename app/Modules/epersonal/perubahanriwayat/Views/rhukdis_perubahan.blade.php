<form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/perubahanriwayat/verrhukdis" accept-charset="UTF-8">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <?php
                    $id = Input::get('id');
                    $nip = Input::get('nip');
                    $flag = Input::get('flag');

                    $item = \DB::table('r_hukdis_temp')
                        ->select(
                            'r_hukdis_temp.*','a_kathukdis.kathukdis', 'a_jenhukum.jenhukum', 'a_penetapsk.jabatan','tb_01.photo','tb_01.nip','tb_01.idskpd','a_skpd.path',
                            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
                        )
                        ->join('tb_01', 'r_hukdis_temp.nip', '=', 'tb_01.nip')
                        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                        ->leftjoin('a_jenhukum', 'r_hukdis_temp.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                        ->leftjoin('a_kathukdis', 'r_hukdis_temp.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                        ->leftjoin('a_penetapsk', 'r_hukdis_temp.pejab', '=', 'a_penetapsk.id')
                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                        ->where('r_hukdis_temp.id', $id)
                        ->where('r_hukdis_temp.nip', $nip)
                        ->first();

                    $item2 = \DB::table('r_hukdis')
                    ->select('r_hukdis.*', 'a_penetapsk.jabatan as pejmensk', 'a_kathukdis.kathukdis', 'a_jenhukum.jenhukum')
                    ->leftjoin('a_jenhukum', 'r_hukdis.idjenhukum', '=', 'a_jenhukum.idjenhukum')
                    ->leftjoin('a_kathukdis', 'r_hukdis.idtkhukum', '=', 'a_kathukdis.idkathukdis')
                    ->leftjoin('a_penetapsk', 'r_hukdis.pejab', '=', 'a_penetapsk.id')
                    ->where('r_hukdis.nip', $nip)
                    ->where('r_hukdis.id', $item->id_rhukdis)
                    ->first();

                    if(file_exists('./packages/upload/photo/pegawai/'.$item->photo)){
                        $image = url()."/packages/upload/photo/pegawai/".$item->photo;
                    }else{
                        $image = url()."/packages/upload/photo/pegawai/default.jpg";
                    }


                    if($flag != 1){
                        $jenhukum = ($item->idjenhukum!=$item2->idjenhukum)?'alert-dangers':'';
                        $tkhukum = ($item->idtkhukum!=$item2->idtkhukum)?'alert-dangers':'';
                        $pejmensk = ($item->pejab!=$item2->pejab)?'alert-dangers':'';
                        $nosk = ($item->nosk!=$item2->nosk)?'alert-dangers':'';
                        $tgsk = ($item->tgsk!=$item2->tgsk)?'alert-dangers':'';
                        $tgmul = ($item->tgmul!=$item2->tgmul)?'alert-dangers':'';
                        $tgsel = ($item->tgsel!=$item2->tgsel)?'alert-dangers':'';
                        $ket = ($item->ket!=$item2->ket)?'alert-dangers':'';
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
                        <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT HUKUMAN DISIPLIN TEKNIS ({!!$title1!!})</h3>
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
                                {!! Form::label('idjenhukum', 'Jenis Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->jenhukum!='')?$item2->jenhukum:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('idtkhukum', 'Tingkat Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->kathukdis!='')?$item2->kathukdis:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('pejab', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    <div class="form-control">{{($item2->pejmensk!='')?$item2->pejmensk:'-'}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nosk', 'No. SK:', array('class' => 'col-sm-3 control-label')) !!}
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
                                {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {{($item2->tgmul!='0000-00-00')?date('d-m-Y', strtotime($item2->tgmul)):'-'}}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tgsel', 'Tgl. Selesai:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {{($item2->tgsel!='0000-00-00')?date('d-m-Y', strtotime($item2->tgsel)):'-'}}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('ket', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {{($item2->ket!='')?$item2->ket:'-'}}
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                @endif

                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-dot-circle-o"></i> RIWAYAT HUKUMAN DISIPLIN TEKNIS ({!!$title2!!})</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12 data-perubahan">
                            <span class="{!!(Input::get('flag') == 3)?'div-disabled':''!!}">
                                {!!csrf_field()!!}
                                {!! Form::hidden('id', null, array('class'=> 'form-control', 'id'=>'id')) !!}
                                {!! Form::hidden('id_rhukdis', null, array('class'=> 'form-control', 'id'=>'id_rhukdis')) !!}
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
                                    {!! Form::label('idjenhukum', 'Jenis Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        @if(($flag == 1) or ($flag == 3))
                                            {!! comboJenhukum('idjenhukum','','') !!}
                                         @elseif($flag == 2)
                                            <div style="width: auto;" class="{!!$jenhukum!!} jenhukum">
                                                {!! comboJenhukum('idjenhukum','','') !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idtkhukum', 'Tingkat Hukuman:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7" id="xtkhukum">
                                            <select name="idtkhukum" class="form-control" id="idtkhukum" data-placeholder=".: Pilihan :." requierd style="width:100%%"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pejab', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        @if(($flag == 1) or ($flag == 3))
                                            {!! comboPenetapsk("pejab","","") !!}
                                        @elseif($flag == 2)
                                            <div style="width: auto;" class="{!!$pejmensk!!} pejmensk">
                                            {!! comboPenetapsk("pejab","","") !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nosk', 'No. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        @if(($flag == 1) or ($flag == 3))
                                            {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'No. SK')) !!}
                                        @elseif($flag == 2)
                                            {!! Form::text('nosk', null, array('class'=> 'form-control '.$nosk, 'placeholder'=>'No. SK')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                    @if(($flag == 1) or ($flag == 3))
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    @elseif($flag == 2)
                                        <div style="width: auto;" class="{!!$tgsk!!} tgsk">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgmul', 'Tgl. Mulai:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        @if(($flag == 1) or ($flag == 3))
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @elseif($flag == 2)
                                        <div style="width: auto;" class="{!!$tgmul!!} tgmul">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgmul', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
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
                                            {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @elseif($flag == 2)
                                        <div style="width: auto;" class="{!!$tgsel!!} tgsel">
                                        <div class='input-group datepicker'>
                                            {!! Form::text('tgsel', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ket', 'Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        @if(($flag == 1) or ($flag == 3))
                                            <textarea rows="5" cols="250" name="ket" id="ket" class="form-control"></textarea>
                                         @elseif($flag == 2)
                                            <textarea rows="5" cols="250" name="ket" id="ket" class="form-control {{$ket}}"></textarea>
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

        $('.data-perubahan #idjenhukum').change(function(){
            var idjenhukum = $('.data-perubahan #idjenhukum').val();
            $.ajax({
                url:'{!! url() !!}/epersonal/biodata/tkhukum',
                type:'post',
                data:{'idjenhukum':idjenhukum, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('.data-perubahan #xtkhukum').html('Looading..');
                },
                success:function(response){
                    @if($flag == 1 or $flag == 3)
                    $('.data-perubahan #xtkhukum').html(response);
                    @elseif($flag == 2)
                    $('.data-perubahan #xtkhukum').html(response);
                    @if($item->idtkhukum!=$item2->idtkhukum)
                    $('.data-perubahan #idtkhukum').addClass('alert-dangers').css({"width":"auto"});
                    @endif

                    @endif

                }
            });
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
                                $('#myTabs #rhukdis').trigger('click');
                                //refresh_page();
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                claravel_modal_close('main_modal2');
                                $('#myTabs #rhukdis').trigger('click');
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
            data:{'id':'{!!Input::get("id")!!}','tb':'r_hukdis_temp','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array('tgsk','tgmul','tgsel');
                var arrselect2 = new Array('idjenhukum','pejab');
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

                    $('.data-perubahan #idjenhukum').trigger('change');

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
