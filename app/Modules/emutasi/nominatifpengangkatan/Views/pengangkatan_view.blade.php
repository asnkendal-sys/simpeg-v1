<script type="text/javascript">
    $(document).ready(function(){
        $(".tmt").mask("99-99-9999");
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
    });
</script>

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
<?php
$item = \DB::table('tb_01 as a')
->select(
    'a.*','a.nip', 'a.nama', 'a.photo','a.nopak','a.thijaz', 'b.skpd','a_tkpendid.tkpendid','a_tkpendid.idtkpendid','a.tmtjbt','a.tmtpkt','a_jenjurusan.jenjurusan','a_jenjurusan.idjenjurusan','a_golruang.golru'
    ,
    \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
    \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
)
->leftjoin('a_tkpendid', 'a.idtkpendid', '=', 'a_tkpendid.idtkpendid')
->leftjoin('a_golruang', 'a.idgolrupkt', '=', 'a_golruang.idgolru')
->leftjoin('a_jenjurusan', 'a.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
->where('a.nip', Input::get('nip'))
->first();
?>

@if(count($item) > 0)
<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
    <table class="tb table-bordered" border="0" width="98%">
        <tbody>
            <tr>
                <td rowspan="2" align="center" width="5%">
                    <?php
					if(file_exists("./packages/upload/photo/pegawai/".$item->photo)){
						$pict = $item->photo;
					}else {
						$pict = "default.jpg";
					}
					?>
                    <div align="center"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}"  width="100"></div>
                </td>
                <th width="17%">NIP <br> Nama Lengkap</th>
                <th width="5%">Gol. Ruang</th>
                <th width="10%">Pendidikan Terkahir</th>
                <th width="10%">Jurusan</th>
                <th width="20%">Jabatan Sekarang</th>
                <th width="20%">Unit Kerja</th>
                <th width="5%">PAK Lama</th>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="{!!Input::get('n')!!}[nip]" value="{!!Input::get('nip')!!}">
                    <span id="ed1" style="display:none"><?=$item->nip?></span>
                    <a title="popdetil" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
                    {!!$item->namalengkap!!}
                </td>
                <td>{!!$item->golru!!}<br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td>
                <td>{!!$item->tkpendid!!}</td>
                <td>{!!$item->jenjurusan!!}</td>
                <td>{!!$item->jabatan!!}<br>{!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</td>
                <td>{!!$item->skpd!!}</td>
                <td>
                    @if($item->nopak=='')-
                    @else
                    {!!$item->nopak!!}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <table width="100%" border="0">
                        <tr style="background-color: #ececec">
                            <td width="10%" rowspan="2" style="vertical-align:middle">
                                <div align="center">Atribut Mutasi</div>
                            </td>
                            <td width="15%">Jenis Jabatan</td>
                            <td width="15%">Jabatan Baru</td>
                            <td width="15%">Seksi/Bidang Baru</td>
                            <td width="20%">Keterangan Mutasi <span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
                        </tr>
                        <tr>
                            <td>
                                {!!NominatifpengangkatanModel::comboJnsjabatan('[idjenjabbaru]',$item->idjenjab,'','idjenjabbaru',Input::get('n'))!!}
                            </td>

                            <td>
                                <span id="xjab">
                                    <select name="<?php echo Input::get('n')."[idjabjbtbaru]"?>" id="idjabjbtbarux" class="idjabjbtbaru{!!Input::get('n')!!}  form-control" style="width: 100%" >
                                        <option value="0">.: Pilihan :.</option>
                                    </select>
                                </span>

                                <span id="xjab1">
                                    <select type="hidden" id="idjabjbtbaru{!!Input::get('n')!!}" class="idjabjbtbaru idjabjbtbaru{!!Input::get('n')!!} input-large form-control" name="<?php echo Input::get('n')."[idjabjbtbaru]"?>" style="width: 100%" >
                                    </select>
                                </span>
                                <span id="xjab2">
                                    <select type="hidden" id="idjabfungbaru{!!Input::get('n')!!}" class="idjabfungbaru idjabfungbaru{!!Input::get('n')!!} input-large form-control" name="<?php echo Input::get('n')."[idjabfungbaru]"?>" style="width: 100%" >
                                    </select>
                                </span>
                                <span id="xjab3">
                                    <select type="hidden" id="idjabfungumbaru{!!Input::get('n')!!}" class="idjabfungumbaru idjabfungumbaru{!!Input::get('n')!!} input-large form-control" name="<?php echo Input::get('n')."[idjabfungumbaru]"?>" style="width: 100%" >
                                    </select>
                                </span>

                                <input type="hidden" name="{!!Input::get('n')!!}[idtkpendid]" value="<?php echo $item->idtkpendid?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjurusan]" value="<?php echo $item->idjenjurusan?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[thnlulus]" value="<?php echo $item->thijaz?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idgolrupkt]" value="<?php echo $item->idgolrupkt?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtpkt]" value="<?php echo $item->tmtpkt?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtjbt]" value="<?php echo $item->tmtjbt?>" required class="input-large form-control">

                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjab]" value="<?php echo $item->idjenjab?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabjbt]" value="<?php echo $item->idjabjbt?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabfung]" value="<?php echo $item->idjabfung?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabfungum]" value="<?php echo $item->idjabfungum?>" required class="input-large form-control">
                                <input type="hidden" name="{!!Input::get('n')!!}[idskpd]" value="<?php echo $item->idskpd?>" id="idskpd{!!Input::get('n')!!}" required class="">

                                <?php
                                /*$aksesmod = $item->idskpd;
                                $idskpd = ((strlen($aksesmod)==2) or ($aksesmod == 'all'))?substr($aksesmod,0,2):$aksesmod;*/

                                $idskpd = '25';
                                ?>
                                <!-- KEPALA BKD -->
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[kepalabkd]" value="<?php echo NominatifpengangkatanModel::attrPengantarskpd($idskpd, 'namalengkap')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[jabkepalabkd]" value="<?php echo NominatifpengangkatanModel::attrPengantarskpd($idskpd, 'jab')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[nipkepalabkd]" value="<?php echo NominatifpengangkatanModel::attrPengantarskpd($idskpd, 'nip')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[pangkatbkd]" value="<?php echo NominatifpengangkatanModel::attrPengantarskpd($idskpd, 'pangkat')?>">
                                <!-- BUPATI -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[bupati]" value="{!! getPenetapsk('005','namalengkap') !!}">
                                <!-- SEKDA -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[kepalasekda]" value="{!! getKepskpd('01','nama') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabkepalasekda]" value="{!! getKepskpd('01','jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nipsekda]" value="{!! getKepskpd('01','nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatsekda]" value="{!! getKepskpd('01','pangkat') !!}">

                                <input type="hidden" name="{!!Input::get('n')!!}[isdiperbantukan]" value="<?php echo $item->isdiperbantukan?>" required class="">
                                <input type="hidden" name="{!!Input::get('n')!!}[iddiperbantukan]" value="<?php echo $item->iddiperbantukan?>" required class="">
                                
                            </td>
                            <td>
                                <select id="idskpdbaru{!!Input::get('n')!!}" class="input-large form-control" name="<?php echo Input::get('n')."[idskpdbaru]"?>">
                                </select>
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[keterangan]" required class=" form-control" placeholder="Keterangan Mutasi">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <em>* Jika tidak ada perubahan jabatan maka inputan jabatan baru diisi jabatan sekarang.</em><br>
                                <em>* Harap periksa kembali biodata PNS apabila jenis jabatan dan nama jabatan masih kosong atau belum sesuai dengan data sebenarnya.</em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $(".tmt").mask("99-99-9999");
        /*Disabled List Jenjab*/
        //$("#idjenjabbaru").prop('disabled', true);

        /*Disabled Lis Jab*/
        /*$(".idjabjbtbaru{!!Input::get('n')!!}").prop('disabled', true);
        $("#idjabfungbaru{!!Input::get('n')!!}").prop('disabled', true);
        $("#idjabfungumbaru{!!Input::get('n')!!}").prop('disabled', true);*/

        $('#xjab1,#xjab2,#xjab3').hide();  

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
            });
        }).trigger('change');

        /*select jabjbt xjab1*/
        autoComplete(".idjabjbtbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifpengangkatan/listjabstruk2', 'Jabatan Struktural ..', null, '{!!$item->idjabjbt!!}', '{!!$item->jabatan!!}');

               //jabatan fungsional xjab2
               autoComplete("#idjabfungbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifpengangkatan/listjabfung2', 'Jabatan Fungsional ..', null, '{!!$item->idjabfung!!}', '{!!$item->jabatan!!}');

                //jabatan fungsional xjab3 idjabfungumbaru
                autoComplete("#idjabfungumbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifpengangkatan/listjabfungum2', 'Jabatan Fungsional Umum ..', null, '{!!$item->idjabfungum!!}', '{!!$item->jabatan!!}');

                autoComplete("#idskpdbaru{!!Input::get('n')!!}", '{{url()}}/emutasi/nominatifpengangkatan/cariwhereskpd2', 'Satker ..', null, '{!!$item->idskpd!!}', '{!!$item->skpd!!}','{!! substr($item->idskpd,0,2) !!}');
            });
        </script>
