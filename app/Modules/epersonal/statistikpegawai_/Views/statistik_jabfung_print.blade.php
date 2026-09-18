
<html>
<head>
<title>Simpeg Kendal Statistik Jabatan Fungsional</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link href="<?php echo base_url()?>assets/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: A4 potrait;
                margin-left: 0.4in;
                margin-right: 0.4in;
                margin-top: 0.4in;
                margin-bottom: 0.4in;
            }
            /*p.breakhere { page-break-after: always; }*/
            .page-break	{ display:block; page-break-before:always; }
        }

        div.print{
            background: url('<?php echo base_url()?>assets/images/print_icon.png') no-repeat;
            width:110px;
            height:110px;
            top:20;
            right:50;
            position:fixed;
            opacity:0.1;
            cursor:pointer;
        }

        div.print:hover{
            opacity:1;
        }

        hr {
            border: 1px dotted #000000;
            border-bottom: none;
            border-right: none;
            border-left: none;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>
<body>
<div class="print"></div>
<div class="page">

<?php
	$where = " ";
	$per_page = (($this->input->post('per_page')=='')?25:$this->input->post('per_page'));
	$cari = $this->input->post('cari');
    $itemgolru = $this->epersonal_list->getGolru($this->input->post('idgolru'));
	$itemskpd = $this->epersonal_list->getSkpd($this->input->post('idskpd'));
	$itemjabfung = $this->epersonal_list->getJabfunggroup($this->input->post('idtingkat'));
	switch($this->input->post('idskpd')){
		case "00":
			$whereskpd = "";
		break;
        case "":
            $whereskpd = "";
        break;
		default:
			//$whereskpd = " left(a.idskpd,2)='".$this->input->post('idskpd')."' and ";
            $whereskpd = " a.idskpd like '".$this->input->post('idskpd')."%' and ";
		break;
	}
	
	switch($this->input->post('idgolru')){
		case "notnull":
			$wheregolru = " and a.idgolrupkt between '11' and '45' ";
			$titleadd = strtoupper($itemskpd->skpd)." SEMUA GOLONGAN ";
		break;
		case "null":
			$wheregolru = " and a.idgolrupkt='' ";
			$titleadd = strtoupper($itemskpd->skpd)." YANG GOLONGANNYA KOSONG ";
		break;
		default:
			
			$wheregolru = " and a.idgolrupkt='".$this->input->post('idgolru')."'";
			$titleadd = strtoupper($itemskpd->skpd)." GOLONGAN ".$itemgolru->golru;
		break;
		
	}
	$where.= " where a.idjenkedudupeg not in('99','21') and a.idjenjab = 2 and ( $whereskpd a.idjabfung like '".$this->input->post('idtingkat')."%' $wheregolru )";
	
	$q = "select a.nip,CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama
    ,a.gdp,a.gdb,a.tmlhr,a.idjenkel
	,a.idgolrupkt,a.nokarpeg,ifnull(g.esl,'-') as esl,a.idesljbt
	,if(a.idesljbt between '11' and '52',date_format(a.tmtesljbt,'%d-%m-%Y'),'') as tmtesljbt_
	,b.agama,c.golru,
	IF(a.idjenjab=2,e.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',f.jab,if(a.idjenjab=3,j.jabfungum,''))) AS jab,
	date_format(a.tglhr,'%d-%m-%Y') as tglhr_,
	date_format(a.tmtpkt,'%d-%m-%Y') as tmtpkt_,
	if(date_format(a.tmtjbt,'%d-%m-%Y')='00-00-0000','',date_format(a.tmtjbt,'%d-%m-%Y')) as tmtjbt_,
	CONCAT(d.skpd, (IF(LENGTH(a.idskpd) > 2, d1.skpd, ''))) AS skpd,
	a.mkthnpkt,a.mkblnpkt,
	DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tmtcpn)), '%Y%m')+0 as mkskr,
	DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 as usia,
	h.jenjurusan,a.thijaz,i.dikstru,a.thdikstru
	from tb_01 a force index(index_skpd)
	left join a_agama b on a.idagama=b.idagama
	left join a_golruang c on a.idgolrupkt=c.idgolru
	LEFT JOIN skpd d ON a.idskpd=d.idskpd
	LEFT JOIN skpd d1 ON left(a.idskpd,2)=d1.idskpd
	LEFT JOIN a_jabfung e ON a.idjabfung=e.idjabfung
	left join skpd f on a.idjabjbt=f.idskpd
	left join a_esl g on a.idesljbt=g.idesl
	left join a_jenjurusan h on a.idjenjurusan=h.idjenjurusan
	left join a_dikstru i on a.iddikstru=i.iddikstru
	LEFT JOIN a_jabfungum j ON a.idjabfungum=j.idjabfungum
	";
	$rs = $this->db->query("$q $where order by a.idjabfung");
?>
<center>
<h3>DAFTAR PEGAWAI PADA  <?=$titleadd?></h3>
<h3>BERDASARKAN JABATAN FUNGSIONAL <?=strtoupper($itemjabfung->jabfung2)?></h3>
</center><br>
<table border="1">
  <colgroup>
	<col style="width:20px" />
	<col style="width:200px" />
	<col style="width:150px" />
	<col style="width:83px" />
	<col style="width:83px" />
	<col style="width:250px" />
	<col style="width:25px" />
	<col style="width:25px" />
	<col style="width:25px" />
	<col style="width:25px" />
	<col style="width:80px" />
	<col style="width:100px" />
	<!--<col style="width:100px" />-->
      <col style="width:80px" />
	
  </colgroup>
  <thead class="breadcrumb">
	<tr>
	  <th rowspan="2"><div class="text-center">#</div></th>
	  <th rowspan="2">
	  <div class="text-left">NAMA</div>
	  <div class="text-left">TEMPAT, TGL LAHIR</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">NIP</div>
	  <div class="text-center">KARPEG</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">GOL.</div>
	  <div class="text-center">TMT</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">ESELON</div>
	  <div class="text-center">TMT</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">JABATAN</div>
	  <div class="text-center">UNIT KERJA</div>
	  <div class="text-center">TMT</div>
	  </th>
	  <th colspan="2">
	  <div class="text-center">MASA KERJA</div>
	  </th>
	  <th colspan="2">
	  <div class="text-center">s/d SEKARANG</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">DIKLAT STRUKTURAL</div>
	  <div class="text-center">TAHUN</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">PENDIDIKAN TERAKHIR</div>
	  <div class="text-center">TAHUN</div>
	  </th>
	  <th rowspan="2">
	  <div class="text-center">AGAMA</div>
	  <div class="text-center">USIA</div>
	  </th>
	</tr>
	<tr>
		<th>
		<div class="text-center">THN</div>
		</th>
		<th>
		<div class="text-center">BLN</div>
		</th>
		<th>
		<div class="text-center">THN</div>
		</th>
		<th>
		<div class="text-center">BLN</div>
		</th>
	</tr>
  </thead>
  <tbody>
	<?php
    $n = 0;
	foreach($rs->result() as $item){ $n++;
	?>
	<tr>
	  <td align="center"><?=$n?>.</td>
	  <td>
	  <span class="ed1" style="display:none"><?=$item->nip?></span>
	  <div class="text-left"><?=$item->nama?></div>
	  <small><div class="text-left"><?=$item->tmlhr?>, <?=$item->tglhr_?></div></small>
	  </td>
	  <td align="center">
	  <div class="text-center"><?=$this->epersonal_list->fnip($item->nip)?></div>
	  <div class="text-center"><?=$item->nokarpeg?></div>
	  </td>
	  <td align="center">
	  <div class="text-center"><?=$item->golru?></div>
	  <div class="text-center"><?=$item->tmtpkt_?></div>
	  </td>
	  <td align="center">
	  <div class="text-center"><?=$item->esl?></div>
	  <div class="text-center"><?=$item->tmtesljbt_?></div>
	  </td>
	  <td>
	  <small>
	  <div class="text-left"><?=$item->jab?></div>
	  <div class="text-left"><i>Pada</i></div>
	  <div class="text-left"><?=$item->skpd?></div>
	  <div class="text-left">TMT : <?=$item->tmtjbt_?></div>
	  </small>
	  </td>
	  <td align="center">
		<div class="text-center"><?=$item->mkthnpkt?></div>
	  </td>
	  <td align="center">
		<div class="text-center"><?=$item->mkblnpkt?></div>
	  </td>
	  <td align="center">
		<div class="text-center"><?=substr($item->mkskr,0,-2)?></div>
	  </td>
	  <td align="center">
		<div class="text-center"><?=substr($item->mkskr,-2)?></div>
	  </td>
	  <td>
		<div class="text-left"><?=ucwords(strtolower($item->dikstru))?></div>
		<div class="text-left"><?=(($item->thdikstru==0)?"":$item->thdikstru)?></div>
	  </td>
	  <td>
		<div class="text-left"><?=ucwords(strtolower($item->jenjurusan))?></div>
		<div class="text-left"><?=$item->thijaz?></div>
	  </td>
	  <td align="center">
		<div class="text-center"><?=$item->agama?></div>
		<div class="text-center"><?=substr($item->usia,0,2)?> thn <?=substr($item->usia,2,2)?> bln</div>
	  </td>
	</tr>
	<?php
	}
	?>
  </tbody>
</table>
</div>

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

<?php /*echo $this->db->last_query();*/?>