<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/emutasi/nominatifdalamskpd/updatemutasi" accept-charset="UTF-8">
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
                               <td width="38%">{!!NominatifdalamskpdModel::comboJnsjabatan('idjenjabbaru','','','idjenjabbaru','')!!}</td>
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
                   <td width="18%"><label class="control-label">Bidang Baru</label></td>
                   <td class="text-center" width="2%"> : </td>
                   <td width="38%">
                    <select id="idskpdbaru" class="input-xlarge form-control idskpdbaru" name="idskpdbaru" style="width: 100%"/>
                </td>


            </tr>
            <tr>
               <td width="18%"><label class="control-label">Keterangan</label></td>
               <td class="text-center" width="2%"> : </td>
               <td width="38%"><input name="keterangan" value="" id="keterangan" class="form-control" type="text" ></td>
           </tr>
           <tr id="ftampilpenetap">
             <td width="18%"><label class="control-label">Nama Penetap</label></td>
             <td class="text-center" width="2%"> : </td>
             <td width="38%"><input name="kepalabkd" id="kepalabkd" class="form-control" type="text" readonly></td>
         </tr>
         <tr id="ftampilpenetap">
             <td width="18%"><label class="control-label">NIP</label></td>
             <td class="text-center" width="2%"> : </td>
             <td width="38%"><input name="nipkepalabkd" id="nipkepalabkd" class="form-control" type="text" readonly></td>
         </tr>
         <tr id="ftampilpenetap">
             <td width="18%"><label class="control-label">Pangkat</label></td>
             <td class="text-center" width="2%"> : </td>
             <td width="38%"><input name="pangkatbkd" id="pangkatbkd" class="form-control" type="text" readonly></td>
         </tr>
     </table>
     <div class="form-group">
       <label for="" class="col-sm-3 control-label"></label>
       <div class="col-sm-7">
           <div class="checkbox">
               <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
               <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
           </div>
       </div>
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

        $.ajax({
            url:'{!!url()!!}/emutasi/nominatifdalamskpd/editmutasi',
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
                $('.data-atribut #keterangan').val(ret.keterangan);
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
                $('.data-atribut #pangkatbkd').val(ret.pangkatbkd);
                if(ret.idjenjabbaru == 2){
                    autoComplete(".data-atribut #idjabfungbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabfung2', 'Jabatan Fungsional ..', null, ret.idjabfungbaru, ret.jabatanbaru);
                }
                else if(ret.idjenjabbaru == 3){
                    autoComplete(".data-atribut #idjabfungumbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabfungum2', 'Jabatan Fungsional ..', null, ret.idjabfungumbaru, ret.jabatanbaru);
                }
                else if(ret.idjenjabbaru >= 20){                                        
                    autoComplete(".data-atribut #idjabjbtbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabstruk2', 'Jabatan Struktural ..', null, ret.idjabjbtbaru, ret.jabatanbaru);
                }

                autoComplete(".data-atribut #idskpdbaru", '{{url()}}/emutasi/nominatifdalamskpd/cariwhereskpd2', 'Satker ..', null, ret.idskpdbaru, ret.skpdbaru);
                autoComplete(".data-atribut #idskpdbaru", '{{url()}}/emutasi/nominatifdalamskpd/cariwhereskpd2', 'Satker ..', null,  '', '',ret.idskpdbaru.substring(0,2));
            }
        });
        autoComplete(".data-atribut #idjabfungbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabfung2', 'Jabatan Fungsional ..', null, '', '');
        autoComplete(".data-atribut #idjabfungumbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabfungum2', 'Jabatan Fungsional ..', null, '', '');
        autoComplete(".data-atribut #idjabjbtbaru", '{{url()}}/emutasi/nominatifdalamskpd/listjabstruk2', 'Jabatan Struktural ..', null, '', '');

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Data Nominatif Mutasi Dalam SKPD ?',function(a){
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



    });
</script>
