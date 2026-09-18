<style>
table.tb td{
  padding:5px;
}

.grad {
  -moz-box-shadow: inset 0 0 50px #888;
  -webkit-box-shadow: inset 0 0 50px#888;
  box-shadow: inner 0 0 50px #888;
}

</style>

<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
	<table class="tb table" border="0" width="100%">
		<tbody>
			<tr>
				<td rowspan="2" align="center" width="10%">
                    <div align="center"><img src="{!!url()!!}/packages/upload/photo/pegawai/default.jpg" width="100"></div>
                </td>
                <th width="45%">BIODATA PRIBADI</th>
                <th width="45%">BIODATA PRIBADI<span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="fa fa-trash" aria-hidden="true"></i></a></span></th>
            </tr>
            <tr>
                <td>
                    <table class="table">
                        <tr>
                            <td width="13%">NIP</td>
                            <td width="2%">:</td>
                            <td width="30%"><input type="text" name="{!!Input::get('n')!!}[nip]" required class="form-control" placeholder="NIP" value="{!!Input::get('nip')!!}" readonly></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[gdp]" class="form-control" placeholder="Gelar Depan">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[nama]" required class="form-control" placeholder="Nama Lengkap">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[gdb]" class="form-control" placeholder="Gelar Belakang">
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td> : </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[tmlhr]" required class="form-control" placeholder="Tempat Lahir">
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td> : </td>
                            <td>
                                <div class="input-group datepicker">
                                    {!! Form::text(Input::get('n').'[tglhr]', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td> : </td>
                            <td>
                                {!! comboAgama(Input::get('n').'[idagama]','','') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td> : </td>
                            <td>
                                {!! comboJenkel(Input::get('n').'[idjenkel]','','required') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Status Marital</td>
                            <td> : </td>
                            <td>
                                {!! comboStsmaritalmutasi(Input::get('n').'[idstskawin]','','idstskawin',Input::get('n'),'') !!}
                            </td>
                        </tr>
                        <tr id="stsdujan{!!Input::get('n')!!}">
                            <td>Status Duda/Janda</td>
                            <td> : </td>
                            <td>
                                {!! comboStsDujan(Input::get('n').'[idstsdujan]','','required') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[alm]" required class="form-control" placeholder="Alamat">
                            </td>
                        </tr>
                        <tr>
                            <td>RT</td>
                            <td> : </td>
                            <td>
                                <div class="col-sm-4">
                                 <input type="text" name="{!!Input::get('n')!!}[almrt]" required class="form-control" placeholder="RT" maxlength="3">
                             </div>
                             <div class="col-sm-1" style="margin-top: 7px;">
                                 <b>RW: </b>
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" name="{!!Input::get('n')!!}[almrw]" required class="form-control" placeholder="RW" maxlength="3">
                             </div>
                         </td>
                     </tr>
                     <tr>
                        <td>Desa/Kelurahan</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[almdesa]" required class="form-control" placeholder="Desa/Kelurahan">
                        </td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[almkec]" required class="form-control" placeholder="Kecamatan">
                        </td>
                    </tr>
                    <tr>
                        <td>Kabupaten/Kota</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[almkab]" required class="form-control" placeholder="Kabupaten">
                        </td>
                    </tr>
                    <tr>
                        <td>Provinsi</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[almprov]" required class="form-control" placeholder="Provinsi">
                        </td>
                    </tr>
                    <tr>
                        <td>Kode Pos</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[almkdpos]" required class="form-control" placeholder="Kode Pos">
                        </td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[telp]" required class="form-control" placeholder="Nomor Telepon">
                        </td>
                    </tr>
                    <tr>
                        <td>HP</td>
                        <td> : </td>
                        <td>
                            <input type="text" name="{!!Input::get('n')!!}[hp]" required class="form-control" placeholder="Nomor Hp">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="table">
                  <tr>
                    <td>Pendidikan Terkahir</td>
                    <td>:</td>
                    <td>{!! comboTkpendidikanmutasi(Input::get('n').'[idtkpendid]','','idtkpendid','') !!}
                    </td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>
                        <span id="xjur">
                            <select name="idjenjurusan" id="idjenjurusan" class="idjenjurusan form-control" style="width: 100%;">
                                <option value="">.: Pilihan :.</option>
                            </select>
                        </span>
                        <span id="xjur1">
                            <select type="hidden" id="idjenjurusan{!!Input::get('n')!!}" class="idjenjurusan idjenjurusan{!!Input::get('n')!!} form-control" name="{!!Input::get('n')!!}[idjenjurusan]" style="width: 100%">
                            </select>
                        </span>
                        <input type="hidden" name="{!!Input::get('n')!!}[n]" id="n" required class="n form-control" placeholder="" value="{!!Input::get('n')!!}">
                    </td>
                </tr>
                <tr>
                    <td>Tahun Lulus</td>
                    <td>:</td>
                    <td><input type="text" name="{!!Input::get('n')!!}[thnlulus]" required class="form-control" maxlength="4" placeholder="Tahun Lulus"></td>
                </tr>
                <tr>
                    <td>Golongan Ruang</td>
                    <td>:</td>
                    <td>{!! comboGolru(Input::get('n').'[idgolrupkt]','','required') !!}</td>
                </tr>
                <tr>
                    <td>Jabatan Lama</td>
                    <td> : </td>
                    <td>
                        <input type="text" name="{!!Input::get('n')!!}[jabatanlama]" required class="form-control" placeholder="Jabatan Lama">
                    </td>
                </tr>
                <tr>
                    <td>SKPD Lama</td>
                    <td> : </td>
                    <td>
                        <input type="text" name="{!!Input::get('n')!!}[skpdlama]" required class="form-control" placeholder="SKPD Lama">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <center>
                         <b>MUTASI MASUK DAERAH</b>
                     </center>
                 </td>
             </tr>
             <tr>
                <td colspan="3">
                    <div class="alert alert-success" style="margin-bottom: 0px;margin-top:0px">
                        <b>Penempatan Pindah Masuk</b> <em>(* Abaikan Jika Belum Tersedia)</em>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Jenis Jabatan</td>
                <td>:</td>
                <td>{!! comboJenjabmutasi(Input::get('n').'[idjenjabbaru]','','idjenjabbaru','') !!}</td>
            </tr>
            <tr>
                <td>Nama Jabatan</td>
                <td>:</td>
                <td>
                    <span id="xjab">
                        <select name="idjabjbtbaru" id="idjabjbtbaru" class="idjabjbtbaru form-control" style="width: 100%;">
                            <option value="">.: Pilihan :.</option>
                        </select>
                    </span>
                    <span id="xjab1">
                        <select type="hidden" id="idjabjbtbaru{!!Input::get('n')!!}" class="idjabjbtbaru idjabjbtbaru{!!Input::get('n')!!} form-control" name="{!!Input::get('n')!!}[idjabjbtbaru]" style="width: 100%">
                        </select>
                    </span>
                    <span id="xjab2">
                        <select type="hidden" id="idjabfungbaru{!!Input::get('n')!!}" class="idjabfungbaru idjabfungbaru{!!Input::get('n')!!} form-control" name="{!!Input::get('n')!!}[idjabfungbaru]" style="width: 100%"/>
                    </select>
                </span>
                <span id="xjab3">
                    <select type="hidden" id="idjabfungumbaru{!!Input::get('n')!!}" class="idjabfungumbaru idjabfungumbaru{!!Input::get('n')!!} form-control" name="{!!Input::get('n')!!}[idjabfungumbaru]" style="width: 100%"/>
                </select>
            </span>
        </td>
    </tr>
    <tr>
        <td>SKPD Baru</td>
        <td>:</td>
        <td>{!! comboSkpdunit(Input::get('n').'[idskpdbaru]','','') !!}</td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="alert alert-success" style="margin-bottom: 0px;">
                <b>Mutasi Pindah Masuk Dari</b>
            </div>
        </td>
    </tr>
    <!-- Start Of Reza -->
    <tr>
        <td width="13%">Kementarian/Lembaga/Daerah (K/L/D)</td>
        <td width="2%">:</td>
        <td width="30%">
            {!!NominatifmasukkabupatenModel::comboPemerintah(Input::get('n')."[idpemerintah]","","","",Input::get('n'))!!}
        </td>
    </tr>
    <tr class="{!!Input::get('n')!!}provkabkota">
        <td width="13%">Dari Provinsi</td>
        <td width="2%">:</td>
        <td width="30%"><input type="text" name="{!!Input::get('n')!!}[provinsi]"  class="form-control" placeholder="Provinsi Pindah"></td>
    </tr>
    <tr>
        <td>Dari Kabupaten/Kota</td>
        <td>:</td>
        <td><input type="text" name="{!!Input::get('n')!!}[kabupaten]"  class="form-control" placeholder="Kabupaten / Kota Pindah"></td>
    </tr>
    <tr class="{!!Input::get('n')!!}kemlem">
        <td>Dari Instansi</td>
        <td>:</td>
        <td><input type="text" name="{!!Input::get('n')!!}[instansi]"  class="form-control" placeholder="Instansi Pindah"></td>
    </tr>
    <!-- endof Reza -->
    <tr>
        <td>Nomor Rujukan</td>
        <td>:</td>
        <td><input type="text" name="{!!Input::get('n')!!}[noskpermintaan]" required class="form-control" placeholder="No SK Rujukan"></td>
    </tr>
    <tr>
        <td>Tanggal Rujukan</td>
        <td>:</td>
        <td>
            <div class="input-group datepicker">
                {!! Form::text(Input::get('n').'[tglskpermintaan]', null, array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) !!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td>
            <input type="text" name="{!!Input::get('n')!!}[Keterangan]" required class="form-control" placeholder="Keterangan Mutasi">
            <!-- BKD -->
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[kepalabkd]" value="{!! getKepskpd('25','nama') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabkepalabkd]" value="{!! getKepskpd('25','jab') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nipkepalabkd]" value="{!! getKepskpd('25','nip') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatbkd]" value="{!! getKepskpd('25','pangkat') !!}">
            <!-- Bupati -->
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[bupati]" value="{!! getPenetapsk('005','namalengkap') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabbupati]" value="{!! getPenetapsk('005','jabatan') !!}">
            <!-- Sekda -->
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[kepalasekda]" value="{!! getKepskpd('01','nama') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabkepalasekda]" value="{!! getKepskpd('01','jab') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nipsekda]" value="{!! getKepskpd('01','nip') !!}">
            <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatsekda]" value="{!! getKepskpd('01','pangkat') !!}">
        </td>
    </tr>
</table>
</td>
</tr>
</tbody>
</table>
</div>
<script>
    $(document).ready(function(){
        $('select').select2();
        $(".nomi .datepicker").datetimepicker({
           format: 'DD-MM-YYYY'
       });
        /*Start Of Reza*/
        $(".idpemerintah{!!Input::get('n')!!}").change(function(){

            var jos = $(".idpemerintah{!!Input::get('n')!!}").val();
            //alert(jos);
            if(jos == 1 ||  jos == 2 || jos == 3){
                $(".{!!Input::get('n')!!}provkabkota").show();
                $(".{!!Input::get('n')!!}kemlem").hide();
            }else{
                $(".{!!Input::get('n')!!}provkabkota").hide();
                $(".{!!Input::get('n')!!}kemlem").show();
            }

        }).trigger('change');
        $(".{!!Input::get('n')!!}provkabkota").show();
        $(".{!!Input::get('n')!!}kemlem").hide();
        /*EndofReza*/
        $(".nomi .date").mask("99-99-9999");

        $('#stsdujan{!!Input::get("n")!!},#xjur1,#xjab1,#xjab2,#xjab3').hide();

        $.each($('.idjenjabbaru'), function(index,item){
            $(item).change(function(){
                var vId1 = $("select[id=idjenjabbaru]:eq("+index+")").val();

                if(vId1 == 1){
                    $("span[id=xjab]:eq("+index+")").hide();
                    $("span[id=xjab1]:eq("+index+")").show();
                    $("span[id=xjab2]:eq("+index+")").hide();
                    $("span[id=xjab3]:eq("+index+")").hide();
                }else if(vId1 == 2){
                    $("span[id=xjab]:eq("+index+")").hide();
                    $("span[id=xjab1]:eq("+index+")").hide();
                    $("span[id=xjab2]:eq("+index+")").show();
                    $("span[id=xjab3]:eq("+index+")").hide();
                }else if(vId1 == 3){
                    $("span[id=xjab]:eq("+index+")").hide();
                    $("span[id=xjab1]:eq("+index+")").hide();
                    $("span[id=xjab2]:eq("+index+")").hide();
                    $("span[id=xjab3]:eq("+index+")").show();
                }else{
                    $("span[id=xjab]:eq("+index+")").show();
                    $("span[id=xjab1]:eq("+index+")").hide();
                    $("span[id=xjab2]:eq("+index+")").hide();
                    $("span[id=xjab3]:eq("+index+")").hide();
                }

                autoComplete("#idjabjbtbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabstruk2', 'Jabatan Struktural ..', null, '', '');

                autoComplete("#idjabfungbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfung2', 'Jabatan Fungsional ..', null, '', '');

                autoComplete("#idjabfungumbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifmasukkabupaten/listjabfungum2', 'Jabatan Fungsional Umum ..', null, '', '');
            });
        }).trigger('change');

        $.each($('.idtkpendid'), function(index,item){
            $(item).change(function(){
                var tkpendid = $("select[id=idtkpendid]:eq("+index+")").val();

                if(tkpendid != ''){
                    $("span[id=xjur]:eq("+index+")").hide();
                    $("span[id=xjur1]:eq("+index+")").show();
                }else{
                    $("span[id=xjur]:eq("+index+")").show();
                    $("span[id=xjur1]:eq("+index+")").hide();
                }

                autoComplete("#idjenjurusan{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifmasukkabupaten/jenjurusan?idtkpendid=' + tkpendid, 'Jurusan Pendidikan ..', null, '', '');
            });
        }).trigger('change');

        $('.idstskawin').on('change', function(e){
           e.preventDefault();
           var kawin = $(this).val();
           var idx =  $(this).attr('idx');

           if(kawin == 2){
            $('#stsdujan'+idx).show();
        }else{
            $('#stsdujan'+idx).hide();

        }
    }).trigger('change');

    });

</script>
