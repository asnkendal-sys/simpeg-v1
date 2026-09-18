<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Kenaikan Gaji Berkala</title>
</head>

<body>
    <?php 
    $texttoid="";
    foreach($previews as $no=>$tte_item){  
        if($no == 0){
            $texttoid.= $tte_item->id;
        }else{
            $texttoid.= ",".$tte_item->id;
        }

        $rstemplate = \PenetapannominatifModel::getTemplate('all',9);
        $arrsearch = array("search","[tglskkgbb]","[noskkgbb]","[nama]","[nama]","[nip]","[tmplahir]","[tgllahir]","[pangkat]","[nmajab]",
            "[tmpskpdskr]","[gaji]","[gajinominal]","[pejmen]","[tgsk]","[nosk]","[tmt]","[mkgolthn]","[mkgolbln]","[gkgbb]","[nomgpb]",
            "[mktkgbb]","[mkbkgbb]","[golru]","[tmtkgbb]","[jabpenkgbb]","[pejpenkgbb]","[golrupb]","[nippb]","[qrcode]","[img_logo]",'[img_logo_tte]');

        $item = \PenetapannominatifModel::getNominatifver($tte_item->id_sk,$tte_item->nip_pengusul);

        if(!count($item)){
            echo "Data Kenaikan Gaji Berkala tidak ditemukan.";
            exit();
        }

        $arrreplace = array("replace",formatTanggalPanjang($item->tglskkgbb),$item->noskkgbb,$item->nama,$item->nama,fnip($item->nip),
            ucword($item->tmplahir),formatTanggalPanjang($item->tgllahir),$item->golpnsskr_txt,ucword($item->nmajab),$item->tmpskpdskr." ".(($item->iddiperbantukan != '')?'dipekerjakan pada '.ucword($item->lokdiperbantukan):''),
            uang($item->gkgbl),$item->nomgpl,ucword($item->pejpenkgbl_txt),formatTanggalPanjang($item->tglskkgbl),$item->noskkgbl,formatTanggalPanjang($item->tmtkgbl),$item->mktkgbl,$item->mkbkgbl,uang($item->gkgbb),$item->nomgpb,
            $item->mktkgbb,$item->mkbkgbb,ucword($item->golpns_txt),formatTanggalPanjang($item->tmtkgbb),$item->jabpenkgbb,$item->pejpenkgbb,$item->golrupb,
            fnip($item->nippb),'<div id="qrcode"></div>',asset('/packages/tugumuda/img/logo.png'),asset('/packages/tte/logo.png')); //html pake path

        // dd($arrreplace); die();
        echo str_replace($arrsearch,$arrreplace,$rstemplate);
    } 
    ?>
    <div class="col-md-6  col-md-offset-3" style="text-align:center;"><input type="password" name="tte-passphrase" id="tte-passphrase" class="form-control tte-passphrase" placeholder="Passphrase" style="margin-bottom:5px; text-align:center;"/>
    <a id="tte-kirim-selected" href="#" class="btn btn-success" recid="<?php echo $texttoid; ?>"><i class="fa  fa-key"></i> Tanda tangan</a></div>   
</body>

<script>
    $(document).ready(function(){
        $('#main_modal2').on('click','#tte-kirim-selected', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var passphrase = $('#tte-passphrase').val();
            if(is_sending == false){
                is_sending = true;
                $.ajax({
                    url : '<?php echo url(); ?>/tte/kgb/sign_multiple',
                    type : 'post',
                    data: {'passphrase' : passphrase, 'id' : id, '_token' : '<?php echo csrf_token(); ?>'},
                    // data: iki.serialize(),
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
        });
    });
</script>
</html>