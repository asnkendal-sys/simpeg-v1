<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemberhentian</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style type="text/css">
    div.print{
        background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
        width:110px;
        height:110px;
        top:20;
        right:50;
        position:fixed;
        opacity:0.1;
        cursor:pointer;
        right: 5px;
    }
    .pagebreak { page-break-before: always; }
    .page-break { display:block; page-break-before:always; }

    div.print:hover{
        opacity:1;
    }
</style>

<style>
    @font-face {
        font-family: 'bookos';
        src: url('{!!url()!!}/storage/fonts/BOOKOS.TTF') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'bookos';
        src: url('{!!url()!!}/storage/fonts/BOOKOS.TTF') format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    body {
        font-family: 'bookos', sans-serif;
        font-size: 12px;
        background: white;
        line-height:1;
        letter-spacing: 0.5pt;
    }

    @page {
        size: F4 potrait;
        margin-left: 2.54cm; 
        margin-right: 2.54cm;
        margin-top: 2.54cm;
        margin-bottom: 3.75cm;
    }    

    .header{
        position: fixed;
        line-height:1;
        letter-spacing: 0.5pt;
    }

    .content{
        position: fixed;
        line-height:1;
        letter-spacing: 0.5pt;
    }

    .footer {
        position: fixed; 
        font-family:'bookos', sans-serif;
        font-size: 11pt;
        bottom: 1cm; 
        left: 0cm; 
        right: 0cm;
        height: 1cm;

        /** Extra personal styles **/
        text-align: center;font-size: 12px;font-family:'bookos', sans-serif;
        line-height: 1.5cm;
    }

    #ttefooter {
        position: fixed; 
        font-family:'bookos', sans-serif;
        font-size: 11pt;
        bottom: 1cm; 
        left: 0cm; 
        right: 0cm;
        height: 1cm;

        /** Extra personal styles **/
        text-align: center;font-size: 12px;font-family:'bookos', sans-serif;
        line-height: 1.5cm;
    }

    table {
        border-collapse: collapse;
    }

    table tbody > tr > td{
        vertical-align: top;
    }
</style>

<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>

<body>

    <div class="print"></div>
    <?php
        $jml = count($item);
        if($jml < 1){
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }

        function cetakSurat($item = null, $i=0){            
            $sekda = \App\Models\Pegawai::where('nip','=',$item->nipsekda)->first();

            switch ($item->idjenpens) {
                case 1: $jnssurat = 8; break; //bup
                case 3: $jnssurat = 4; break; //aps
                case 5: $jnssurat = 11; break; //diberhentikan / hukdis 
                case 7: $jnssurat = 10; break; //keuzuran
                case 8: $jnssurat = 9; break; //meninggal
                default: $jnssurat = 8; break;
            }        
            $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',$jnssurat)->first();

            $key = \TemplateluarkabupatenModel::rand_char();
            $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";

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
                "[alamat]",
                "[kepala_unitkerja]",
                "Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE), BSSN",
                '<tr>
				<td colspan="5">
					<div class="page-break">
						&nbsp;</div>
					<br />
					<br />
					<br />
					&nbsp;</td>
			</tr>',
                '<tr>
				<td colspan="5">
					<div class="page-break">
						&nbsp;</div>
					<br />
					<br />
					<br />
					<div style="text-align: center;">
						<span style="font-size: 12px; line-height: 1.5em; text-align: center;">MEMUTUSKAN :</span></div>
				</td>
			</tr>',
                );
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
            $item->no_dasar,
            formatTanggalPanjang($item->tgl_dasar),
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
            strtoupper($item->jabkepalasekda),
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
            url().'/packages/tte/noimage.jpg',
            url().'/packages/tugumuda/img/garuda.jpg',
            $item->alm.(($item->almrt!='')? ' RT. '.$item->almrt.'':'').(($item->almrt!='' && $item->almrw!='' )? ' / ':'').(($item->almrw!='')? ' RW. '.$item->almrw.'':'').(($item->almdesa!='')? ' Desa/Kel. '.$item->almdesa.'':'').(($item->almkec!='')? ' Kec. '.$item->almkec.'':'').(($item->almkab!='')? ' Kab/Kota. '.$item->almkab.'':'').(($item->almprov!='')? ' Prov. '.$item->almprov.'':'').(($item->almkdpos!='')? ' Kode Pos.'.$item->almkdpos.'':''),
            getKepskpd($item->kdunit,'jab'),
            '',
            '</table><div class="page-break"><br><br><br><br><br><br><table>',
            '</table><div class="page-break"><br><br><br><br><br><br><table><tr><td colspan="5"><div style="text-align: center;"><span style="font-size: 12px; line-height: 1.5em; text-align: center;">MEMUTUSKAN :</span></div></td><tr>',
        );

            echo str_replace($arrsearch,$arrreplace,$template->template);
        }

        $i = 0;
        if($jml>1){
            foreach($item as $it){
                if($it->statususul == 1){
                    $i++;
                    cetakSurat($it, $i);
                    if($jml != $i){
                        echo '<div class="pagebreak"> </div>';
                    }
                }                
            }
        }else{
            if($item[0]->statususul == 1){
                $i++;
                cetakSurat($item[0], 1);
            }else{
                if($item->statususul == 1){
                    $i++;
                    cetakSurat($item, 1);
                }
            }
        }

        if($i == 0){
            echo "<div align='center'>";
            echo "Data tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.";
            echo "</div>";
            exit();
        }
     ?>
</body>
</html>
<script>
    $(document).ready(function(){
        $('.qrcode').each(function() {
            $(this).qrcode({
                size    : 83.149606299,
                render  : "image",
                text    : "{!!url().'/dsign/sp/' !!}"+$(this).attr('recid')
            });
        });

        $('div.print').click(function(){
            $(this).hide();
            window.print();
            /*
               setTimeout(function() {
                   window.close();
               }, 1);
               */
           });

        $('img').each(function(index,item){
            $(item).error(function(){

                $(item).attr('src','no_image.jpg');
            });
        });


        $(document).on('mouseover',function(){
            $('div.print').show();
        });

    });

</script>