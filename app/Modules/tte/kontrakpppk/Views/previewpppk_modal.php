<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Petikan PPPK</title>
</head>

<body>
    <div class="row">
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-8">
            <?php 
                $texttoid="";
                foreach($previews as $no=>$tte_item){  
                    if($no == 0){
                        $texttoid.= $tte_item->id;
                    }else{
                        $texttoid.= ",".$tte_item->id;
                    }
                
                    $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',7)->first();        
                    $item = \PerpanjangankontrakModel::getNominatifver($tte_item->id_sk,$tte_item->nip_pengusul);
                    $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();
                    if(!count($item)){
                        echo "Kontrak PPPK tidak ditemukan.";
                        exit();
                    }
                    $arrsearch = array("search",
                            "[nosk_keputusan]",
                            "[no_urut]",
                            "[unit_kerja]",
                            "[namalengkap_sekda]",
                            '[nip_sekda]',
                            "[pangkat_sekda]",
                            "[golongan_sekda]",
                            "[jabatan_sekda]",
                            "[namalengkap_bkpp]",
                            '[nip_bkpp]',
                            "[pangkat_bkpp]",
                            "[golongan_bkpp]",
                            "[jabatan_bkpp]",
                            "[tglsurat]",
                            "[tmtawal]",
                            "[tmtakhir]",
                            "[namalengkap]",
                            "[tmlhr]",
                            "[tglhr]",
                            "[jenkel]",
                            "[nip]",
                            "[tkpendid]",
                            "[pangkat]",
                            "[golongan]",
                            "[mkgolthn]",
                            "[mkgolbln]",
                            "[gaji]",
                            "[qrcode]",
                            "[tglsk_keputusan]",
                            "[tahun]",
                            "[jabatan]",
                            "[unitkerja]",
                            "[skpdbaru]",
                            "[bupati]",
                            "[copyright]",
                            "[logo_tte]",
                            "[logo_garuda]",
                            "[kepala_unitkerja]",
                            );                

                    $arrreplace = array("replace",
                        (($item->nosk!='')?$item->nosk:'813/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),
                        $item->no_urut,//$i,
                        getSkpd($item->kdunit),
                        $item->kepalasekda,
                        $item->nipsekda,
                        $item->pangkatsekda,
                        empty($sekda)?'':$sekda->golongan,
                        $item->jabkepalasekda,
                        $item->kepalabkd,
                        $item->nipkepalabkd,
                        $item->pangkatbkd,
                        $sekda->golrubkd,            
                        strtoupper($item->jabkepalabkd),
                        formatTanggalPanjang($item->tgsk),
                        formatTanggalPanjang($item->tmtawal),
                        formatTanggalPanjang($item->tmtakhir),
                        $item->nama,
                        $item->tmlhr,
                        formatTanggalPanjang($item->tglhr),
                        ((substr($item->nip, 14, 1) == 1)?'Pria': 'Wanita'),
                        $item->nip,
                        $item->jenjurusan,
                        $item->pangkat,
                        $item->golru,
                        $item->thkerja,
                        $item->blkerja,
                        "Rp. ".uang($item->gaji),
                        '<div class="qrcode" recid='.$item->id.'></div>',
                        formatTanggalPanjang($item->tgsk),
                        date('Y', strtotime($item->tgsk)),
                        $item->jab,
                        $item->skpd,
                        $item->skpd,
                        $item->bupati,
                        '',
                        url().'/packages/tte/logo.png',
                        url().'/packages/tugumuda/img/garuda.jpg',
                        getKepskpd($item->kdunit,'jab'),
                    );
                    
                    echo str_replace($arrsearch,$arrreplace,$template->template);
                } 
            ?>
            <div class="col-md-6  col-md-offset-3" style="text-align:center;"><input type="password" name="tte-passphrase" id="tte-passphrase" class="form-control tte-passphrase" placeholder="Passphrase" style="margin-bottom:5px; text-align:center;"/>
            <a id="tte-kirim-selected" href="#" class="btn btn-success" recid="<?php echo $texttoid; ?>"><i class="fa  fa-key"></i> Tanda tangan</a></div>   
        </div>
        <div class="col-md-2">&nbsp;</div>
    </div>
</body>

<script>
    $(document).ready(function(){
        $('#main_modal2 #tte-kirim-selected').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var passphrase = $('#tte-passphrase').val();
            if(passphrase != ''){
                if(is_sending == false){
                    is_sending = true;
                    $.ajax({
                        url : '<?php echo url(); ?>/tte/pppk/sign_multiple',
                        type : 'post',
                        data: {'passphrase' : passphrase, 'id' : id, '_token' : '<?php echo csrf_token(); ?>'},                    
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if (html['code']==200) {
                                swal("Berhasil",html.message,'success');
                            }else{
                                swal("Gagal",html.message,'error');
                            }
                            is_sending = false;
                            $('#cari').trigger('submit');
                        },
                        complete:function(){
                            is_sending = false;
                        }
                    });
                }
            }else{
                bootbox.alert('Passphrase harus diisi.');
            }
        });
    });
</script>
</html>