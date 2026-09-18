<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/emutasi/nominatifpengangkatan/verifikasipengangkatanpelaksana" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA</h3>
                </div>
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-md-12 data-biodata">
                            {!!csrf_field()!!}
                            <input type="hidden" name="idusul" id="idusul" value="{!!Input::get('idusul')!!}">
                            <input type="hidden" name="nousul" id="nousul" value="{!!Input::get('nousul')!!}">
                            <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">
                            <table class="table table-hovered table-stripped" width="100%">
                                <tr>
                                    <td width="18%"><label class="control-label">NIP </label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nip"></span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Nama </label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nama"></span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Gol Ruang </label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-golru"></span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Pendidikan Terakhir </label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-pendid"></span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Jabatan Lama </label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nmjabatan"></span></td>
                                </tr>
                                <tr>
                                    <td width="18%"><label class="control-label">Unit Kerja Lama</label></td>
                                    <td class="text-center" width="2%"> : </td>
                                    <td width="38%"><span id="attr-nmskpd"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
               <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT MUTASI DALAM OPD </h3>
            </div>
            <div class="box box-warning">
               <div class="box-body">
                   <div class="col-md-12 data-atribut">
                       {!!csrf_field()!!}
                       <table class="table table-hovered table-stripped" width="100%">
                           <tr>
                               <td width="18%"><label class="control-label">Nomor Usulan</label></td>
                               <td class="text-center" width="2%"> : </td>
                               <td width="38%"><input name="nousul" value="" id="nousul" class="form-control" type="text" readonly></td>
                           </tr>
                           <tr>
                               <td width="18%"><label class="control-label">Tanggal Usulan</label></td>
                               <td class="text-center" width="2%"> : </td>
                               <td width="38%"><input name="tglusul" value="" id="tglusul" class="form-control" type="text" readonly></td>
                           </tr>
                           <tr>
                               <td width="18%"><label class="control-label">Jenis Jabatan</label></td>
                               <td class="text-center" width="2%"> : </td>
                               <td width="38%">{!!NominatifpengangkatanModel::comboJnsjabatan('idjenjabbaru','','','idjenjabbaru','')!!}</td>
                           </tr>
                           <tr>
                               <td width="18%"><label class="control-label">Jabatan Baru</label></td>
                               <td class="text-center" width="2%"> : </td>
                               <td width="38%">
                                   <span id="xjab">
                                    <select name="idjabjbtbarux" id="idjabjbtbarux" class="idjabjbtbarux input-xlarge form-control" style="width: 100%">
                                        <option value="0">.: Pilihan :.</option>
                                    </select>
                                </span>

                                <span id="xjab1">
                                    <select type="hidden" id="idjabjbtbaru" class="idjabjbtbaru input-large form-control" name="idjabjbtbaru" style="width: 100%">
                                    </select>
                                </span>
                                <span id="xjab2">
                                    <select type="hidden" id="idjabfungbaru" class="idjabfungbaru input-large form-control" name="idjabfungbaru" style="width: 100%"/>
                                </select>
                            </span>
                            <span id="xjab3">
                                <select type="hidden" id="idjabfungumbaru" class="idjabfungumbaru input-large form-control" name="idjabfungumbaru" style="width: 100%"/>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                   <td width="18%"><label class="control-label">Unit Kerja</label></td>
                   <td class="text-center" width="2%"> : </td>
                   <td width="38%">
                    <select id="idskpdbaru" class="input-xlarge form-control" name="idskpdbaru" style="width: 100%" />
                </td>


            </tr>
            <tr>
             <td width="18%"><label class="control-label">Keterangan</label></td>
             <td class="text-center" width="2%"> : </td>
             <td width="38%"><input name="keterangan" value="" id="keterangan" class="form-control" type="text" ></td>
         </tr>
         <tr>
           <td width="18%"><label class="control-label">Ceklist Berkas</label></td>
           <td class="text-center" width="2%"> : </td>
           <td width="38%"> 
            <!-- <input type="checkbox" name="ispengantar" id="ispengantar" value="1" class="a"> Surat Pengantar OPD<br> -->
            <input type="checkbox" name="ispermohonan" id="ispermohonan" value="1" class="a"> Surat Permohonan YBS<br>
            <input type="checkbox" name="isskpkt" id="isskpkt" value="1" class="a"> SK Pangkat Terakhir</td>
        </tr>
        <tr>
            <td width="18%"><label class="control-label">Status Berkas</label></td>
            <td class="text-center" width="2%"> : </td>
            <td width="38%">
                <select id="statususul" name="statususul" class="input-large form-control" required style="width: 100%">
                    <option value="0">.: Status Usulan :.</option>
                    <option value="1">Memenuhi Syarat</option>
                    <option value="2">Tidak Memenuhi Syarat</option>
                    <option value="3">Berkas Tidak Lengkap</option>
                </select></td>
            </tr>

            <tr id='ftampil1'>
                <td width="18%"><label class="control-label">Status proses</label></td>
                <td class="text-center" width="2%"> : </td>
                <td width="38%">
                    <select id="statussk" name="statussk" class="form-control" required style="width: 100%">
                        <option value="0">.: PILIHAN :.</option>
                        <option value="2">Dalam Proses</option>
                        <option value="1">Proses Selesai</option>
                    </select>
                </td>
            </td>
            <!-- STATRT OF -->
            <!-- <tr id="ftampil11">
                <td width="18%"><label class="control-label">Nomor SP</label></td>
                <td class="text-center" width="2%"> : </td>
                <td width="38%">
                    <input type="text" class="input-large form-control" name="nosk" id="nosk" placeholder="Nomor SP Mutasi">
                </td>
            </tr> -->
            <!-- <tr id="ftampil11">
                <td width="18%"><label class="control-label">Tanggal SP</label></td>
                <td class="text-center" width="2%"> : </td>
                <td width="38%">
                    <input type="text" class="input-large tmt form-control" name="tglsurat" id="tglsurat" placeholder="dd-mm-yyyy" value="">
                </td>
            </tr>
            <tr id="ftampil11">
                <td width="18%"><label class="control-label">TMT Berlaku</label></td>
                <td class="text-center" width="2%"> : </td>
                <td width="38%">
                    <input type="text" class="input-large tmt form-control" name="tmt" id="tmt" placeholder="dd-mm-yyyy" value="">
                </td>
            </tr>
            <tr id="ftampil11">
                <td width="18%"><label class="control-label">Status SP</label></td>
                <td class="text-center" width="2%"> : </td>
                <td width="38%" style="padding-left: 30px; ">
                    <label class="radio a">
                        <input type="radio" name="iscetaksk" id="iscetaksk0" value="0" class="a"> Belum Cetak SP
                    </label>
                    <label class="radio a">
                        <input type="radio" name="iscetaksk" id="iscetaksk1" value="1" class="a"> Sudah Cetak SP
                    </label>
                    <label class="radio a ">
                        <input type="radio" name="iscetaksk" id="iscetaksk2" value="2" class="a"> Pembatalan Cetak SP
                    </label>
                </td>
            </tr>
        </tr> -->
        <!-- END OF -->
        <tr id='ftampil2'>
            <td width="18%"><label class="control-label">Keterangan</label></td>
            <td class="text-center" width="2%"> : </td>
            <td width="38%">
                <textarea rows="" cols="6" class="form-control" name="kettms" id="kettms" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>
            </td>
        </tr>
        <tr id='ftampil3'>
            <td width="18%"><label class="control-label">Keterangan</label></td>
            <td class="text-center" width="2%"> : </td>
            <td width="38%">
                <textarea rows="" cols="" class="form-control" name="ketbtl" id="ketbtl" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>
            </td>
        </tr>
    <!-- <tr id="ftampilpenetap">
         <td width="18%"><label class="control-label">Nama Penetap</label></td>
         <td class="text-center" width="2%"> : </td>
         <td width="38%"> -->
            <input name="kepalabkd" id="kepalabkd" class="form-control" type="hidden" >
        <!-- </td>
     </tr>
     <tr id="ftampilpenetap">
         <td width="18%"><label class="control-label">NIP Penetap</label></td>
         <td class="text-center" width="2%"> : </td>
         <td width="38%"> -->
            <input name="nipkepalabkd" id="nipkepalabkd" class="form-control" type="hidden" >
        <!-- </td>
     </tr> -->
     <!-- <tr id="ftampilpenetap">
         <td width="18%"><label class="control-label">Jab Penetap</label></td>
         <td class="text-center" width="2%"> : </td>
         <td width="38%"> -->
         <input name="jabkepalabkd" id="jabkepalabkd" class="form-control" type="hidden"><!-- </td>
     </tr> -->
     <!-- <tr id="ftampilpenetap">
         <td width="18%"><label class="control-label">Pangkat Penetap</label></td>
         <td class="text-center" width="2%"> : </td>
         <td width="38%"> -->
            <input name="pangkatbkd" id="pangkatbkd" class="form-control" type="hidden" ><!-- </td>
     </tr> -->
 </td>
</tr>
</table>
<div class="form-group">
   <label for="" class="col-sm-3 control-label"></label>
   <div class="col-sm-7">
    <?php if(session::get('role_id')<=2) { ?>
        <div class="checkbox">
           <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
           <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
       </div>
   <?php }else{ ?>
       <div class="checkbox">
        <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Kembali</button>
    <?php }?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
        $('.data-atribut select').select2();
        /*Disabled FORM*/
        var cek_role =  {!! Session::get('role_id') !!};
        if (cek_role>2) {
            $('.form-control').prop('disabled', true);
            $('select2').prop('disabled', true);
            $('select').prop('disabled', true);
            $('.a').prop('disabled', true);
            refresh_page();
        }
        /*END OF Disabled FORM*/

        $.ajax({
            url:'{!!url()!!}/emutasi/nominatifpengangkatan/verpengangkatan',
            data: { 'idusul': "{!!Input::get('idusul')!!}",'nip':"{!!Input::get('nip')!!}", 'nousul':"{!!Input::get('nousul')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);
                /*UNTUK FORM*/
                var str0 = ret.tglusul;
                var res0 = str0.split("-");
                $('.data-atribut #tglusul').val(res0[2]+'-'+res0[1]+'-'+res0[0]);

                $('.data-atribut #nousul').val(ret.nousul);
                $('.data-atribut #idusul').val(ret.idusul);
                $('.data-atribut #idjenjabbaru').val(ret.idjenjabbaru);
                $('.data-atribut .idjenjabbaru').trigger('change');
                $('.data-atribut #statususul').val(ret.statususul).trigger('change');
                $('.data-atribut #statussk').val(ret.statussk).trigger('change');
                $('.data-atribut #keterangan').val(ret.keterangan);
                $('.data-atribut #ketbtl').val(ret.ketbtl);
                $('.data-atribut #kettms').val(ret.kettms);
                $('.data-atribut #skpdbaru').val(ret.skpdbaru);

                
                $('.data-atribut #ispengantar').attr('checked',((ret.ispengantar==1)?true:false));
                $('.data-atribut #ispermohonan').attr('checked',((ret.ispermohonan==1)?true:false));
                $('.data-atribut #isskpkt').attr('checked',((ret.isskpkt==1)?true:false));
                /*UNTUK NON FORM*/
                $('.data-biodata #attr-nip').html(ret.nip);
                $('.data-biodata #attr-nama').html(ret.namalengkap);
                var str1 = ret.tmtpkt;
                var res1 = str1.split("-");
                ret.tmtpkt = res1[2]+'-'+res1[1]+'-'+res1[0];
                $('.data-biodata #attr-golru').html(ret.pangkat+' ('+ret.golru+") <br>"+ret.tmtpkt); 
                $('.data-biodata #attr-pendid').html(ret.tkpendid);
                $('.data-biodata #attr-nmjabatan').html(ret.jabatan);
                $('.data-biodata #attr-nmskpd').html(ret.skpdlama);
                /*PENETAP*/
                $('.data-atribut #kepalabkd').val(ret.kepalabkd);
                $('.data-atribut #nipkepalabkd').val(ret.nipkepalabkd);
                $('.data-atribut #jabkepalabkd').val(ret.jabkepalabkd);
                $('.data-atribut #pangkatbkd').val(ret.pangkatbkd);
                
                /*Tambahan*/
                $('.data-atribut #nosk').val(ret.nosk);
                /*Function Tanggal JON*/
                var str4 = ret.tglsurat;
                var res4 = str4.split("-");
                $('.data-atribut #tglsurat').val(res4[2]+'-'+res4[1]+'-'+res4[0]);

                var str99 = ret.tmt;
                var res99 = str99.split("-");
                $('.data-atribut #tmt').val(res99[2]+'-'+res99[1]+'-'+res99[0]);

                if(ret.iscetaksk==0)
                {
                    $('.data-atribut #iscetaksk0').val(ret.iscetaksk).attr('checked', 'checked');
                }
                else if(ret.iscetaksk==1)
                {
                    $('.data-atribut #iscetaksk1').val(ret.iscetaksk).attr('checked', 'checked');
                }
                else if(ret.iscetaksk==2)
                {
                    $('.data-atribut #iscetaksk2').val(ret.iscetaksk).attr('checked', 'checked');
                }
                if(ret.idjenjabbaru==2){
                    autoComplete(".data-atribut #idjabfungbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabfung2', 'Jabatan Fungsional ..', null, ret.idjabfungbaru, ret.jabatanbaru);
                }
                else if(ret.idjenjabbaru==3){
                    autoComplete(".data-atribut #idjabfungumbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabfungum2', 'Jabatan Fungsional ..', null, ret.idjabfungumbaru, ret.jabatanbaru);
                }
                else{
                    autoComplete(".data-atribut #idjabjbtbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabstruk2', 'Jabatan Struktural ..', null, ret.idjabjbtbaru, ret.jabatanbaru);
                }

                autoComplete(".data-atribut #idskpdbaru", '{{url()}}/emutasi/nominatifpengangkatan/cariwhereskpd2', 'Satker ..', null,  ret.idskpdbaru, ret.skpdbaru, ret.idskpdbaru);
            }
        });
autoComplete(".data-atribut #idjabfungbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabfung2', 'Jabatan Fungsional ..', null, '', '');
autoComplete(".data-atribut #idjabfungumbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabfungum2', 'Jabatan Fungsional ..', null, '', '');
autoComplete(".data-atribut #idjabjbtbaru", '{{url()}}/emutasi/nominatifpengangkatan/listjabstruk2', 'Jabatan Struktural ..', null, '', '');
autoComplete(".data-atribut #idskpdbaru", '{{url()}}/emutasi/nominatifpengangkatan/cariwhereskpd2', 'Satker ..', null,  '','');

/*select jabjbt xjab1*/
        // autoComplete("#idjabfungbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabfung2', 'Jabatan Fungsional ..', null, '', '');

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Data Nominatif Pengangkatan Pelaksana ?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
                            if(html=='4'){
                                notification('Berhasil Disimpan','success');
                                claravel_modal_close('main_modal2');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#xjab1,#xjab2,#xjab3').hide();  

        $('.data-atribut #idjenjabbaru').on('change', function(e){
            e.preventDefault();
            var vId1 = $(".data-atribut #idjenjabbaru").val();

            if(vId1 >= 20){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').show();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').hide();
            }else if(vId1 == 2){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').show();
                $('.data-atribut #xjab3').hide();
            }else if(vId1 == 3){
                $('.data-atribut #xjab').hide();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').show();
            }else{
                $('.data-atribut #xjab').show();
                $('.data-atribut #xjab1').hide();
                $('.data-atribut #xjab2').hide();
                $('.data-atribut #xjab3').hide();
            }            
        }).trigger('change');

        $('.data-atribut #ftampil1').hide();
        $('.data-atribut #ftampil2').hide();
        $('.data-atribut #ftampil3').hide();
        $('.data-atribut #ftampil11').hide();
        $('.data-atribut #ftampilpenetap').hide();

        $('.data-atribut #statususul').change(function(){
            if($('.data-atribut #statususul').val() == 1){
                $('.data-atribut #ftampil1').show();
                $('.data-atribut #ftampil2').hide();
                $('.data-atribut #ftampil3').hide();

                $('.data-atribut #statussk').change(function(){
                    if($('.data-atribut #statussk').val() == 1){
                        $('.data-atribut #ftampil11').show();
                        $('.data-atribut #ftampilpenetap').show();
                        $('.data-atribut #ftampil12').hide();
                    }else if($('.data-atribut #statussk').val() == 2){
                        $('.data-atribut #ftampil11').hide();
                        $('.data-atribut #ftampilpenetap').hide();
                        $('.data-atribut #ftampil12').show();
                    }else{
                        $('.data-atribut #ftampil11').hide();
                        $('.data-atribut #ftampil12').hide();
                        $('.data-atribut #ftampilpenetap').hide();
                    }
                }).trigger('change');
            }else if($('.data-atribut #statususul').val() == 2){
                $('.data-atribut #ftampil1').hide();
                $('.data-atribut #ftampil2').show();
                $('.data-atribut #ftampil3').hide();
                $('.data-atribut #ftampil11').hide();
                $('.data-atribut #ftampilpenetap').hide();
            }else if($('.data-atribut #statususul').val() == 3){
                $('.data-atribut #ftampil1').hide();
                $('.data-atribut #ftampil2').hide();
                $('.data-atribut #ftampil3').show();
                $('.data-atribut #ftampil11').hide();
                $('.data-atribut #ftampilpenetap').hide();
            }else{
                $('.data-atribut #ftampil1').hide();
                $('.data-atribut #ftampil2').hide();
                $('.data-atribut #ftampil3').hide();
                $('.data-atribut #ftampil11').hide();
                $('.data-atribut #ftampilpenetap').hide();
            }
        }).trigger('change');


    });
</script>
