<section class="content-header">
    <h1>
        Preview Data Skp <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Skp</a></li>
        <li class="active"> Preview Data Skp </li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <!-- <li>Isiakan tanggal usulan</li> -->
                        <li>Atribut Skp Dibawah berasal dari data skp simpeg</li>

                        <li>Klik tombol kirim data untuk mengrim data skp ke bkn</li>
                    </ul>
                </div>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-listnominatif form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                {{-- <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('nousul', 'Tahun :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!!comboTahun("tahun",Input::get('tahun'),"", "Tahun")!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nip', 'NIP / Nama :', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            <select name="nip" class="form-control nip" id="nip" style="width: 100%"></select>
                        </div>
                    </div>
                </div> --}}
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button id="save" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Kirim Data</button>
                            &nbsp;
                            &nbsp;
                            {!! ClaravelHelpers::btnCancel() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row" style="padding-left: 10px">
                        <div class="span12" id="daftar-usul">
                          <style>table.tb td{padding:5px;}.grad {-moz-box-shadow: inset 0 0 50px #888;-webkit-box-shadow: inset 0 0 50px#888;box-shadow: inner 0 0 50px #888;}.kedip {animation: blinker 1s linear infinite;}@keyframes blinker {50% {opacity: 0;}}</style>
                          <?php
                          $nip 	= Input::get('nip');
                          $item 	= \DB::table('tb_01 as a')
                          ->select(
                          	'a.nip','a.idjenjab','a.idskpd','a.idjenjab','a.idsapk',
                          	'b.jab',
                          	'a.idgolrupkt',
                          	'b.skpd','a_golruang.golru','a_golruang.pangkat',
                          	\DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
                          	\DB::raw('IF(a.idjenjab>4,b.idskpd,IF(a.idjenjab=2,c.idjabfung,IF(a.idjenjab=3,d.idjabfungum,IF(a.idjenjab=4,e.idjabnonjob,"-")))) as idjab'),
                          	\DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
                            )
                          ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
                          ->leftjoin('a_golruang', 'a.idgolrupkt', '=', 'a_golruang.idgolru')
                          ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
                          ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
                          ->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
                          ->where('a.nip', $nip)
                          ->first();
                          ?>
                          <div class="nomi" id="{!!Input::get('nip')!!}" >
                          	<table class="tb table-bordered" border="0" width="97%" style="margin-left: 15px;">
                          		<tbody>
                          			<tr>
                          				<th width="20%">NIP <br> Nama Lengkap</th>
                          				<th>Gol. Ruang</th>
                          				<th>Jabatan</th>
                          				<th>Unit Kerja</th>
                          				<td style="vertical-align: middle;"><span class="pull-right"><a class="remove_item" style="color: red;" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
                          			</tr>
                          			<tr>
                          				<td>
                          					<input type="hidden" name="{!!Input::get('n')!!}[nip]" class="nipnomi{!!Input::get('n')!!}" value="{!!Input::get('nip')!!}">
                          					<span id="ed1" style="display:none"><?=$item->nip?></span>
                          					<a title="popdetil" class="detailriwayat{!!Input::get('n')!!}" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
                          					{!!$item->namalengkap!!}
                          				</td>
                          				<td>{!!$item->golru!!}<br>{!!$item->pangkat!!}</td>
                          				<td>{!!$item->jabatan!!}</td>
                          				<!-- <td>{!!getSkpd($item->idskpd)!!}</td> -->
                          				<td>{!!$item->skpd!!}
                          				</td>
                          			</tr>
                          		</tbody>
                          	</table>
                          	<!-- START List Input type Hidden -->
                          	<input type="hidden" name="nip" value="{!! $item->nip !!}">
                            <input type="hidden" name="idsapk" value="{!! $item->idsapk !!}">
                            <input type="hidden" name="idskpd" value="{!! $item->idskpd !!}">
                            <input type="hidden" name="tahun" value="{!! \Input::get('tahun') !!}">
                          	<!-- END List Input type Hidden -->
                          	<div class="col-md-12">
                          		<div class="box box-warning">
                          			<div class="box-header with-border">
                          				<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT SKP SIMPEG - <a title="popdetil" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" class="detailriwayat{!!Input::get('n')!!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a> - {!!$item->namalengkap!!}</h3>
                          				<h3 class="box-title"><span class="tidak_valid{!!Input::get('n')!!}"></span></h3>
                          				<div class="box-tools pull-right">
                          					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          				</div>
                          			</div>
                          			<div class="box-body">
                          				<div class="col-md-6" style="margin-left: -10px;">
                          					<table class="table table-hovered table-stripped" width="100%">


                          						<tr>
                          							<td width="25%">ID Skp</td>
                          							<td class="text-center" width="2%"> : </td>
                          							<td>
                          							     	<input type="text" name="id_skp" class="form-control" value="{{$skp['idskpbkn']}}" readonly>
                          							</td>
                          						</tr>
                          						<tr>
                          							<td width="25%">Nil Skp</td>
                          							<td class="text-center" width="2%"> : </td>
                          							<td>
                                          	<input type="text" name="nilaiSkp" class="form-control" value="{{$skp['nilai']}}" readonly>
                          							</td>
                          						</tr>
                          						<tr>
                          							<td width="25%">Orientasi Pelayanan</td>
                          							<td class="text-center" width="2%"> : </td>
                          							<td>
                          								<input type="text" name="orientasiPelayanan" class="form-control" value="{{$skp['orpel']}}" readonly>
                          							</td>
                          						</tr>
                                      <tr>
                          							<td width="25%">Integritas</td>
                          							<td class="text-center" width="2%"> : </td>
                          							<td>
                          								<input type="text" name="integritas" class="form-control" value="{{$skp['integritas']}}" readonly>
                          							</td>
                          						</tr>
                                      <tr>
                          							<td width="25%">Komitmen</td>
                          							<td class="text-center" width="2%"> : </td>
                          							<td>
                          								<input type="text" name="komitmen" class="form-control" value="{{$skp['komitmen']}}" readonly>
                          							</td>
                          						</tr>
                                      <tr>
                                        <td width="25%">Disiplin</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="disiplin" class="form-control" value="{{$skp['disiplin']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Kerjasama</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="kerjasama" class="form-control" value="{{$skp['kerjasama']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Perilaku Kerja</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="nilaiPerilakuKerja" class="form-control" value="{{$skp['nilaiperilaku']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Prestasi Kerja</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="nilaiPrestasiKerja" class="form-control" value="{{$skp['nilaiprestasi']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Kepemimpinan</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="kepemimpinan" class="form-control" value="{{$skp['pim']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Jumlah</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="jumlah" class="form-control" value="{{$skp['jumlah']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Rata-rata</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="nilairatarata" class="form-control" value="{{$skp['nilairatarata']}}" readonly>
                                        </td>
                                      </tr>
                          					</table>
                          				</div>
                          				<div class="col-md-6" style="margin-left: -10px;">
                          					<table class="table table-hovered table-stripped" width="100%">

                                      <tr>
                                        <td width="25%">Nip Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="penilaiNipNrp" class="form-control" value="{{$skp['nippenilai']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Nama Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="pejabatPenilaiNama" class="form-control" value="{{$skp['pejpenilai']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Unit Kerja Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="penilaiUnorNama" class="form-control" value="{{$skp['penilaiUnorNama']}}" readonly>
                                        </td>
                                      </tr>


                                      <tr>
                                        <td width="25%">Jabatan Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="penilaiJabatan" class="form-control" value="{{$skp['penilaiJabatan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Gol Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="penilaiGolongan" class="form-control" value="{{$skp['penilaiGolongan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Tmt Gol Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="penilaiTmtGolongan" class="form-control" value="{{$skp['penilaiTmtGolongan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Sts Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="statusPenilai" class="form-control" value="{{$skp['statusPenilai']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Nip Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiNipNrp" class="form-control" value="{{$skp['penilaiNipNrp']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Nama  Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiNama" class="form-control" value="{{$skp['pejabatPenilaiNama']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Unit Kerja Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiUnorNama" class="form-control" value="{{$skp['penilaiUnorNama']}}" readonly>
                                        </td>
                                      </tr>


                                      <tr>
                                        <td width="25%">Jabatan Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiJabatan" class="form-control" value="{{$skp['penilaiJabatan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Gol  Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiGolongan" class="form-control" value="{{$skp['penilaiGolongan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Tmt Gol Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="atasanPenilaiTmtGolongan" class="form-control" value="{{$skp['penilaiTmtGolongan']}}" readonly>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td width="25%">Sts Ats Penilai</td>
                                        <td class="text-center" width="2%"> : </td>
                                        <td>
                                          <input type="text" name="statusAtasanPenilai" class="form-control" value="{{$skp['statusPenilai']}}" readonly>
                                        </td>
                                      </tr>

                          					</div>
                          				</div>
                          				{{-- <div class="box box-warning">
                          					<div class="box-footer with-border">
                          					</div>
                          				</div> --}}
                          			</div>
                          		</div>
                          	</div>

                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<script>
    var adaNipTerpilih = 0;
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
        //$('#save').hide();
        $('select').select2();


        autoCompleteimg('.nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');

        $(".nip").on('change', function(e){
            e.preventDefault();
            bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                if(r===true){
                  $('#daftar-usul').empty()
                    $.ajax({
                        url:'{!!url()!!}/webservices/skp/listambilskp',
                        type:'get',
                        data:{ 'nip':$('.nip').val(), 'tahun':$('#tahun').val(),'_token' : '{!!csrf_token()!!}'},
                        beforeSend:function(){},
                        success:function(response){
                            $('#daftar-usul').append(response);


                            $("#save").show();
                            $('#simpan .nip').focus();
                        }
                    });
                }
            });

        });

        $('.form-listnominatif').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    if ($(".unvalid")[0]){
                        bootbox.alert("<center><b>.: PERHATIAN :.</b> <br>Periksa Ulang Usulan Nominatif Cuti <i class='glyphicon glyphicon-exclamation-sign kedip' style='color:red;' title='Tidak Dapat Disimpan'></i></center>");
                    }else{
                        $.ajax({
                       url: '{{url()}}/webservices/skp/send', //ganti biar gag nabrak
                       type : 'POST',
                       data : $this.serialize(),
                       beforeSend: function(){
                        preloader.on();
                    },
                    success:function(html){
                        preloader.off();
                        if(html==1){
                            notification('Berhasil Disimpan','success');
                            refresh_page();

                        }else{
                            notification(html,'danger');
                        }
                        //bootbox.alert(html);
                    }
                });
                    }
                }
            });
        });

        function addList(){
            if($('#simpan .nip').val() != ''){
                if(isNaN(parseInt($('.nomi').attr('urutan')))){
                    count = 0;
                }else{
                    count = parseInt($('.nomi:last').attr('urutan'));
                }

                if(!$('#'+$('#simpan .nip').val()).html()){
                    bootbox.confirm("<b>Perhatian. </b>Tambahkan ke Data..?", function(r) {
                        if(r===true){
                            count += 1;
                            $.ajax({
                                url:'{!!url()!!}/ecuti/nominatifcuti/view/listnominatif',
                                type:'post',
                                data:{ 'nip':$('#simpan .nip').val(), '_token' : '{!!csrf_token()!!}', 'n':count },
                                beforeSend:function(){},
                                success:function(response){
                                    $('#daftar-usul').append(response);

                                    $('.remove_item').on('click', function(ev)
                                    {
                                        if (ev.type == 'click')
                                        {
                                            $(this).parents("#daftar-usul .nomi").fadeOut();
                                            $(this).parents("#daftar-usul .nomi").remove();
                                        }
                                    });

                                    $('#simpan .nip').focus();
                                }
                            });
                        }

                        $('#simpan .nip').empty();
                        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                    });
                }else{
                    $('#simpan .nip').empty();
                    bootbox.confirm("<b>Perhatian. </b>NIP/Nama sudah ada dalam daftar usulan sementara.", function(r) {
                        autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                    });
                }
            }else{
                $('#simpan .nip').empty();
                bootbox.confirm("<b>Perhatian. </b>Masukkan Nip / Nama", function(r) {
                    autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
                });
            }
        }
    });
</script>
