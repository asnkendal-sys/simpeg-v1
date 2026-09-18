<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Permohonan Pindah Tugas</title>
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.png">
    <!--<link href="<?php /*echo base_url()*/?>assets/css/normalize.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html" media="all">-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style type="text/css">
        div.print{
            background: url('<?php echo base_url()?>assets/images/print_icon.png') no-repeat;
            width:110px;
            height:110px;
            top:20;
            right:50;
            position:fixed;
            opacity:0.1;
            cursor:pointer;
            right: 5px;
        }

        div.print:hover{
            opacity:1;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        /*$idskpd = substr($this->input->post('idskpd'),0,2);*/
        $aksesmod = $this->session->userdata('aksesmod');
        $idskpd = ((strlen($aksesmod)==2) or ($aksesmod == 'all'))?substr($this->input->post('idskpd'),0,2):$aksesmod;
        $dt['nousul'] = $this->input->post('nousul');
        $data['no_sp'] = $this->input->post('no_sp');
        $data['berkas_sp'] = $this->input->post('berkas_sp');
        $data['tgl_sp'] = date("Y-m-d", strtotime($this->input->post('tgl_sp')));

        $this->db->update('mutasi_luar_daerah',$data,$dt);
        $template = ($this->emutasi_list->getTemplate($idskpd,'3.1','template') == '0')?$this->emutasi_list->getTemplate('all','3.1','template'):$this->emutasi_list->getTemplate($idskpd, '3.1', 'template');

        $rs = $this->db->query("
                SELECT a.nip,a.tglusul,a.nousul,a.statususul,a.statussk,a.idusul,a.tmt,b.idtkpendid,b.nopak,c.tkpendid
                ,d.jenjurusan,e.skpd,a.keterangan,j.golru,j.pangkat,b.tmtpkt,b.tmtjbt,a.iscetaksk,a.tglsurat,a.berkas_sp
                ,a.nosk,a.kettms,a.ketbtl,a.iscetaksk,a.statususul,a.statussk,b.tmlhr,b.tglhr,a.no_sp,a.tgl_sp,a.instansi,a.tglskpermintaan
                ,DATE_FORMAT(a.tglskpermintaan,'%d-%m-%Y') AS tglskpermintaan_,DATE_FORMAT(a.tglusul,'%d-%m-%Y') AS tglusul_
                ,DATE_FORMAT(a.tglsurat,'%d-%m-%Y') AS tglsurat_,DATE_FORMAT(a.tmt,'%d-%m-%Y') AS tmt_
                ,CONCAT(b.gdp,IF(LENGTH(b.gdp)>0,' ',''),b.nama,IF(LENGTH(b.gdb)>0,', ',''),b.gdb) AS namalengkap
                ,IF(a.idjenjab=2,f.jabfung,IF(a.idjenjab=1,h.jab,IF(a.idjenjab=3,g.jabfungum,'-'))) AS jabatan
                ,a.provinsi,a.kabupaten,a.noskpermintaan,a.tglskpermintaan,a.bupati
                FROM mutasi_luar_daerah a
                INNER JOIN tb_01 b FORCE INDEX(index_skpd) ON a.nip = b.nip
                LEFT JOIN a_tkpendid c ON a.idtkpendid=c.idtkpendid
                LEFT JOIN a_jenjurusan d ON a.idjenjurusan=d.idjenjurusan
                LEFT JOIN skpd e ON a.idskpd=e.idskpd
                LEFT JOIN a_jabfung f ON a.idjabfung=f.idjabfung
                LEFT JOIN a_jabfungum g ON a.idjabfungum=g.idjabfungum
                LEFT JOIN skpd h ON a.idjabjbt=h.idskpd
                LEFT JOIN a_golruang j ON a.idgolrupkt = j.idgolru
                WHERE a.nousul = \"".$dt['nousul']."\"
            ");

        /*akses mod jika admin*/
        $attr = $this->emutasi_list->attrPengantar($idskpd)->row();
        if($rs->num_rows() < 1){
            echo "404 Not Found.";
            exit();
        }

        $jml = $rs->num_rows;
        $i = 0;
        foreach($rs->result() as $item){
            $i++;
            $key = $this->emutasi_list->rand_char();
            $datas['user'] = $this->session->userdata('username');
            $datas['page'] = 'Pengantar Mutasi Antar SKPD';
            $datas['randchar'] = $key;
            $datas['attr'] = $item->nip;
            $datas['datetime'] = gmdate("Y-m-d H:i:s", time()+60*60*7);
            $this->db->insert('mast_key',$datas);
            $key_rand = "<em>e-Simpeg Kab. Cilacap ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />
				     <span class='kode bolditalic'>".$key."</span>";

            $arrsearch = array("search","[nosp]","[skpd]","[instansibaru]","[kabkota]","[tglpermintaan]","[namalengkap]","[nip]","[berkas_sp]","[tglsp]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
                "[nip_penetap]","[copyright]");
            $arrreplace = array("replace",$item->no_sp,$this->publik->ucword($this->emutasi_list->getSkpdgroup($idskpd)),$this->publik->ucword($item->instansi),$this->publik->ucword($item->kabupaten),$this->publik->formatTanggalPanjang($item->tglskpermintaan),$item->namalengkap,$this->emutasi_list->fnip($item->nip),$item->berkas_sp,($item->tgl_sp!='0000-00-00')?$this->publik->formatTanggalPanjang($item->tgl_sp):'',
                strtoupper($attr->jab),$attr->nama,$this->publik->ucword($attr->pangkat),$attr->nip,$key_rand);

            echo str_replace($arrsearch,$arrreplace,$template);

            if($i != $jml){
                echo "<div class='page-break'></div>";
            }

        }

    ?>
</body>
</html>

<script>
    $(document).ready(function(){
        //alert(window.orientation);
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