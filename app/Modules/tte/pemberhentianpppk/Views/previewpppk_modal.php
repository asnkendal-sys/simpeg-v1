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
                                    
                    $item = \PemberhentiankontrakModel::getNominatifver($tte_item->id_sk,$tte_item->nip_pengusul);
                    switch ($item->idjenpens) {
                        case 1: $jnssurat = 8; break; //bup
                        case 3: $jnssurat = 4; break; //aps
                        case 5: $jnssurat = 11; break; //diberhentikan / hukdis 
                        case 7: $jnssurat = 10; break; //keuzuran
                        case 8: $jnssurat = 9; break; //meninggal
                        default: $jnssurat = 8; break;
                    }
                    
                    $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',$jnssurat)->first();        
                    $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();
                    if(!count($item)){
                        echo "Kontrak PPPK tidak ditemukan.";
                        exit();
                    }
                    $arrsearch = array("search",
                            "[nosk_keputusan]",
                            "[no_urut]",
                            "[unit_kerja]",
                            "[no_dasar]",
                            "[tgl_dasar]",
                            "[tmt_dasar]",
                            "[pernjanjian_akhir]",
                            "[usia]",
                            "[usia_nominal]",
                            "[bup]",
                            "[tmtpensiun]",
                            "[nosk_awal]",
                            "[tglsk_awal]",
                            "[namalengkap_sekda]",
                            '[nip_sekda]',
                            "[pangkat_sekda]",
                            "[golongan_sekda]",
                            "[jabatan_sekda]",
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
                            "[alamat]",
                            "[kepala_unitkerja]",
                            );                

                    // $tglpensiun = date('Y', strtotime($item->bup)).date('-m-d', strtotime($item->tglhr));        
                    
                    // $tglhr = new DateTime($item->tglhr);
                    // $tglpensiun2 = new DateTime($tglpensiun);
                    // $selisih = $tglhr->diff($tglpensiun2);
                    // $usia = $selisih->y;

                    $birthday = date_create($item->tglhr);
                    $today = date_create($item->bup);
                    $diff = date_diff($birthday, $today);
                    $usia = date_interval_format($diff, "%y");

                    $interval = new DateInterval('P'.$usia.'Y');
                    $tglpensiun = $birthday->add($interval);

                    $arrreplace = array("replace",
                        (($item->nosk!='')?$item->nosk:'813/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),
                        $item->no_urut,//$i,
                        getSkpd($item->kdunit),
                        $item->no_dasar." asda",
                        formatTanggalPanjang($item->tgl_dasar)." asdasd",
                        formatTanggalPanjang($item->tmt_dasar),
                        formatTanggalPanjang($item->tmtakhirl),
                        $usia,
                        terbilang($usia),
                        formatTanggalPanjang($tglpensiun->format('Y-m-d')),
                        formatTanggalPanjang($item->bup),
                        $item->nosk_pppk,
                        formatTanggalPanjang($item->tglsk_pppk),
                        $item->kepalasekda,
                        $item->nipsekda,
                        $item->pangkatsekda,
                        empty($sekda)?'':$sekda->golongan,
                        $item->jabkepalasekda,
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
                        $item->alm.(($item->almrt!='')? ' RT. '.$item->almrt.'':'').(($item->almrt!='' && $item->almrw!='' )? ' / ':'').(($item->almrw!='')? ' RW. '.$item->almrw.'':'').(($item->almdesa!='')? ' Desa/Kel. '.$item->almdesa.'':'').(($item->almkec!='')? ' Kec. '.$item->almkec.'':'').(($item->almkab!='')? ' Kab/Kota. '.$item->almkab.'':'').(($item->almprov!='')? ' Prov. '.$item->almprov.'':'').(($item->almkdpos!='')? ' Kode Pos.'.$item->almkdpos.'':''),
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