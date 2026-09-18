<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK</title>
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

    div.print:hover{
        opacity:1;
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
            echo "404 Not Found.<br>";
            echo "Daftar PPPK tidak tersedia.<br>";
            echo "Cek status PPPK.<br>";
            exit();
        }

        function cetakSurat($item = null, $i=0){
            $pegawai = $item->pegawai;

            $template = \App\Models\PPPK\TemplateSurat::where('jnssurat','=',3)->first();
            $key = \TemplateluarkabupatenModel::rand_char();
            $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";
            $no_urut_zero = str_pad($item->no_urut, 4, '0', STR_PAD_LEFT);
            $nomor_spk = str_replace('[no_urut]',$no_urut_zero,$item->no_spk_induk);
            $nomor_spk_induk = str_replace('.[no_urut]','',$item->no_spk_induk);

            $arrsearch = array("search",
                "[no_spk]",
                "[jabatan]",
                "[unit_kerja]",
                "[tglsk_keputusan]",
                "[tahun]",
                "[namalengkap_sekda]",
                "[nip_sekda]",
                "[pangkat_sekda]",
                "[golongan_sekda]",
                "[jabatan_sekda]",
                "[no_sk]",
                "[tgl_sk]",
                "[no_urut]",
                "[namalengkap]",
                "[tmlhr]",
                "[tglhr]",
                "[nip]",
                "[tkpendid]",
                "[pangkat]",
                "[golongan]",
                "[tmtpkt]",
                "[jabatan]",
                "[gaji]",
                "[skpd]",
                "[instansi]",
                "[jablama]",
                "[jabbaru]",
                "[skpdbaru]",
                "[pendidikan]",
                "[jurusan]",
                "[tmt]",
                "[tglsurat]",
                "[kepalabkd]",
                "[jabkepalabkd]",
                "[pangkatbkd]",
                "[nipkepalabkd]",
                "[bupati]",
                "[copyright]",
                "[qrcode]",
                "[dasar2]",
                "[nomor_spk]",
                "[no_spk_induk]",
                "[tgl_spk_induk]",
                "[alamat]",
                '[golruakhir_pppk]',
                '[gajiakhir_pppk]',
                '[masa_kerja]',
                '[masa_kerja_sebelumnya]'
            );

            $arrreplace = array("replace",
                $item->no_spk,
                $item->jab,
                $item->unit_kerja,
                $item->tanggal_sk,
                substr($item->no_spk,-4),
                $item->kepalasekda,
                $item->nipsekda,
                $item->pangkatsekda,
                @(\App\Models\Pegawai::where('nip','=',$item->nipsekda)->first()->golongan),
                $item->jabkepalasekda,
                (($item->nosk_pppk!='')?$item->nosk_pppk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),
                formatTanggalPanjang($item->tglsk_pppk),
                0,
                $pegawai->nama_lengkap,
                $pegawai->tmlhr,
                $pegawai->tanggal_lahir,
                $item->nipbaru,
                $pegawai->jenjurusan->jenjurusan,
                $item->pangkat,
                $item->golru,
                $item->tmtpkt,
                $item->jab,
                uang($item->gaji),
                $item->nama_skpd,
                $item->unit_kerja,
                ucword($item->jabatan." ".
                    NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
                ucword($item->jabatanbaru." ".
                    NominatifdalamskpdModel::isSekdes($item->nip,$item->idjabfungumbaru)),
                ucword($item->skpdbaru),$item->tkpendid,$item->jenjurusan,
                '',
                '',$item->kepalabkd,$item->jabkepalabkd,ucword($item->pangkat),$item->nipkepalabkd,$item->bupati,$key_rand,
                '<div class="qrcode" recid='.$item->id.'></div>',(($item->no_suratrek!='')?"<li style='text-align: justify;'>
                    <span style='font-size:14px;'>
                    Surat ".ucword($item->surat_dari)." Kendal Nomor : ".$item->no_suratrek." Tanggal ".''." Perihal : ".$item->perihalrek."</span></li>":''),
                $nomor_spk,
                $nomor_spk_induk,
                formatTanggalPanjang($item->tgl_spk_induk),
                $pegawai->alm,
                $pegawai->golruangpppk->golru_p3k,
                "Rp. ".uang($pegawai->gajiakhir_pppk)." (".ucword(terbilang($pegawai->gajiakhir_pppk))." rupiah )",
                //formatTanggalPanjang($pegawai->tmtmulaiakhir_pppk).' - '.formatTanggalPanjang($pegawai->tmtakhirakhir_pppk),
                $item->tmt_awalkontrak.' s/d '.$item->tmt_akhirkontrak,
                $pegawai->mkthnakhir_pppk." Tahun ".$pegawai->mkblnakhir_pppk." Bulan"
            );

            echo str_replace($arrsearch,$arrreplace,$template->template);
        }

        $i = 0;
        if($jml>1){
            foreach($item as $it){
                $i++;
                cetakSurat($it, $i);
                if($jml != $i){
                    echo '<div class="pagebreak"> </div>';
                }
            }
        }else{
            cetakSurat($item, 1);
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
                text    : "{!!url().'/dsign/spk/' !!}"+$(this).attr('recid')
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
