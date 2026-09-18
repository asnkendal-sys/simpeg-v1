<script type="text/javascript">
    $(document).ready(function(){        
        $(".tmt").mask("99-99-9999");        
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
    $row = \DB::table('tb_01')
        ->select('tb_01.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
            \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
            \DB::raw("IF(tb_01.idjenjab>=20,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
        )
        ->leftJoin('a_tkpendid','tb_01.idtkpendid','=','a_tkpendid.idtkpendid')
        ->leftJoin('a_jenjurusan','tb_01.idjenjurusan','=','a_jenjurusan.idjenjurusan')
        ->leftJoin('a_skpd','tb_01.idskpd','=','a_skpd.idskpd')
        ->leftJoin('a_jabfung','tb_01.idjabfung','=','a_jabfung.idjabfung')
        ->leftJoin('a_jabfungum','tb_01.idjabfungum','=','a_jabfungum.idjabfungum')
        ->leftJoin('a_golruang','tb_01.idgolrupkt','=','a_golruang.idgolru')
        ->where('tb_01.nip', Input::get('nip'))
        ->first();

    if(count($row) > 0){
?>
<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
	<table class="tb table table-bordered" border="0" width="100%">
		<tbody>
			<tr>
				<td rowspan="2" align="center" width="5%">
                    <?php
                        if(file_exists("./packages/upload/photo/pegawai/".$row->photo)){
                            $pict = "./packages/upload/photo/pegawai/".$row->photo;
                        }else{
                            $pict = "./packages/upload/photo/pegawai/default.jpg";
                        }
                    ?>
                    <div align="center"><img src="{!!$pict!!}" width="100"></div>
				</td>
                <th width="20%">NIP <br> Nama Lengkap</th>
                <th width="5%">Gol. Ruang</th>                
                <th width="10%">Pendidikan Terkahir</th>
                <th width="15%">Jurusan</th>
                <th width="15%">Jabatan Sekarang</th>
                <th width="25%">Unit Kerja</th>
                <th width="5%">PAK Lama</th>
            </tr>
            <tr>
				<td>
                    <input type="hidden" name="{!!Input::get('n')!!}[nip]" value="{!!Input::get('nip')!!}">
                    <span id="ed1" style="display:none"><?=$row->nip?></span>
                    <a title="popdetil" href="javascript:void(0)"><b><?=fnip($row->nip)?></b></a><br>
                    <?=$row->namalengkap?>
                </td>
				<td><?=$row->golru?><br><?=tglina($row->tmtpkt)?></td>
                <td><?=$row->tkpendid?></td>
                <td><?=$row->jenjurusan?></td>
                <td><?=$row->jabatan?> <br> <?=tglina($row->tmtjbt)?></td>
                <td><?=$row->path?></td>
                <td><?=($row->nopak=='')?'-':$row->nopak?></td>
            </tr>
            <tr>
                <td colspan="9">
                    <table width="100%" border="0">
                        <tr style="background-color: #ececec">
                            <td rowspan="2" style="vertical-align:middle">
                                <div align="center">Atribut Mutasi</div>
                            </td>
                            <td>Pemerintahan</td>
                            <td>Provinsi Pindah</td>
                            <td>Kab/Kota Pindah</td>
                            <td>Instansi Pindah</td>
                            <td>Tanggal Rujukan</td>
                            <td width="25%">Keterangan <span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="fa fa-trash-o"></i></a></span></td>
                        </tr>
                        <tr>
                            <td>
                                {!!NominatifluarkabupatenModel::comboPemerintah(Input::get('n')."[idpemerintah]","","")!!}
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[provinsi]" required class="form-control" placeholder="Provinsi Pindah">
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[kabupaten]" required class="form-control" placeholder="Kabupaten Pindah">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[jabpengantar]" value="<?php echo TemplateluarkabupatenModel::attrPengantarsk(substr($row->idskpd,0,2), 'jab')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[namapengantar]" value="<?php echo TemplateluarkabupatenModel::attrPengantarsk(substr($row->idskpd,0,2), 'nama')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[nippengantar]" value="<?php echo TemplateluarkabupatenModel::attrPengantarsk(substr($row->idskpd,0,2), 'nip')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[pangkatpengantar]" value="<?php echo TemplateluarkabupatenModel::attrPengantarsk(substr($row->idskpd,0,2), 'pangkat')?>">
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[instansi]" required class="form-control" placeholder="Instansi Pindah">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[kepalabkd]" value="<?php echo NominatifluarkabupatenModel::getPenetap('033', 'namalengkap')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[nipkepalabkd]" value="<?php echo NominatifluarkabupatenModel::getPenetap('033', 'nip')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[pangkatbkd]" value="<?php echo NominatifluarkabupatenModel::getPenetap('033', 'pangkat')?>">
                                <input type="hidden" class="input-large" name="{!!Input::get('n')!!}[bupati]" value="<?php echo NominatifluarkabupatenModel::getPenetap('005', 'namalengkap')?>">
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[tglskpermintaan]" required class="form-control tmt" placeholder="dd-mm-yyyy" style="width: 100px">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjab]" value="<?php echo $row->idjenjab?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabjbt]" value="<?php echo $row->idjabjbt?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabfung]" value="<?php echo $row->idjabfung?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjabfungum]" value="<?php echo $row->idjabfungum?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idskpd]" value="<?php echo $row->idskpd?>" required class="input-large">
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[Keterangan]" required class="form-control" placeholder="Keterangan Mutasi">
                                <input type="hidden" name="{!!Input::get('n')!!}[idtkpendid]" value="<?php echo $row->idtkpendid?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idjenjurusan]" value="<?php echo $row->idjenjurusan?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[thnlulus]" value="<?php echo $row->thijaz?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[idgolrupkt]" value="<?php echo $row->idgolrupkt?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtpkt]" value="<?php echo $row->tmtpkt?>" required class="input-large">
                                <input type="hidden" name="{!!Input::get('n')!!}[tmtjbt]" value="<?php echo $row->tmtjbt?>" required class="input-large">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</tbody>
	</table>
</div>
<?php } ?>