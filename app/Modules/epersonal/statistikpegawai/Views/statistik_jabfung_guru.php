
<?php if($this->uri->segment(3) == 'view') { ?>
<html>
<head>
    <title>Simpeg Kendal Statistik Jabatan Fungsional Guru</title>
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
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.js"></script>

</head>
<body>
<div class="print"></div>
<div class="page">
<?php }else{ ?>
    <style>
        .link{
            cursor:pointer;
        }
    </style>
<?php } ?>

<script>
	$(document).ready(function(){
		$('#tb-statistik .link').click(function(){
			var index = $('#tb-statistik .link').index($(this));
			var par = $('#tb-statistik .link').eq(index).parent().parent();
			var vidgolru = $('#tb-statistik .link').eq(index).attr("data");
			var vidissek = $(par).find('.ed1').html();
			var vidskpd = $(par).find('.ed2').html();
            // alert("Index : "+index+" - Par : "+par+" - idgolru : "+vidgolru+" - issek : "+vidissek+" - idskpd : "+vidskpd);
			$('#form-print #idgolru').val(vidgolru);
			$('#form-print #idskpd').val(vidskpd);
			$('#form-print #issek').val(vidissek);
			$('#form-print').submit();
			
		});
	});
</script>
<?php
$item = $this->epersonal_list->getSkpd($this->input->post('idskpd'));
?>
<form id="form-print" name="form-print" action="<?=base_url()?>epersonal/page/view/statistik_jabfung_guru_print" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
	<input type="hidden" id="idgolru" name="idgolru" value="" />
	<input type="hidden" id="idskpd" name="idskpd" value="" />
	<input type="hidden" id="issek" name="issek" value="" />
</form>
<h4 align="center">STATISTIK PEGAWAI BERDASARKAN JABATAN FUNGSIONAL TERTENTU GURU <?=($item->skpd!='')?"PADA ".strtoupper($item->skpd):''?></h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="<?php echo ($this->uri->segment(3)=='view')?'1':'0';?>">
	<thead class="breadcrumb">
		<tr>
			<th rowspan="3"><div class="text-center">GURU PENDIDIKAN FORMAL</div></th>
			<th rowspan="3"><div class="text-center">JML GOL.</div></th>
			<th rowspan="3"><div class="text-center">JML GOL. KOSONG</div></th>
			<th colspan="17"><div class="text-center">JUMLAH PER-GOLONGAN</div></th>
		</tr>
		<tr>
			<th colspan="4"><div class="text-center">GOL I</div></th>
			<th colspan="4"><div class="text-center">GOL II</div></th>
			<th colspan="4"><div class="text-center">GOL III</div></th>
			<th colspan="5"><div class="text-center">GOL IV</div></th>
		</tr>
		<tr>
			<th><div class="text-center">I/a</div></th>
			<th><div class="text-center">I/b</div></th>
			<th><div class="text-center">I/c</div></th>
			<th><div class="text-center">I/d</div></th>
			<th><div class="text-center">II/a</div></th>
			<th><div class="text-center">II/b</div></th>
			<th><div class="text-center">II/c</div></th>
			<th><div class="text-center">II/d</div></th>
			<th><div class="text-center">III/a</div></th>
			<th><div class="text-center">III/b</div></th>
			<th><div class="text-center">III/c</div></th>
			<th><div class="text-center">III/d</div></th>
			<th><div class="text-center">IV/a</div></th>
			<th><div class="text-center">IV/b</div></th>
			<th><div class="text-center">IV/c</div></th>
			<th><div class="text-center">IV/d</div></th>
			<th><div class="text-center">IV/e</div></th>
		</tr>
	</thead>
	<tbody>
		<?php
		switch($this->input->post('idskpd')){
			case "00":
				$whereskpd = "";
			break;
            case "":
                $whereskpd = "";
                break;
			default:
				//$whereskpd = " and left(c.idskpd,2)='".$this->input->post('idskpd')."' ";
				$whereskpd = " and c.idskpd like '".$this->input->post('idskpd')."%' ";
			break;
		}
		$rs = $this->db->query("
		    SELECT a.idskpd,a.skpd,a.issek,IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'SMA',IF(a.issek=5,'SMK','-'))))) AS jenjang
            ,SUM(IF(c.idgolrupkt!='',1,0)) AS 'gol'
            ,SUM(IF(c.idgolrupkt='',1,0)) AS 'golempty'
            ,SUM(IF(c.idgolrupkt='11',1,0)) AS 'ia'
            ,SUM(IF(c.idgolrupkt='12',1,0)) AS 'ib'
            ,SUM(IF(c.idgolrupkt='13',1,0)) AS 'ic'
            ,SUM(IF(c.idgolrupkt='14',1,0)) AS 'id'
            ,SUM(IF(c.idgolrupkt='21',1,0)) AS 'iia'
            ,SUM(IF(c.idgolrupkt='22',1,0)) AS 'iib'
            ,SUM(IF(c.idgolrupkt='23',1,0)) AS 'iic'
            ,SUM(IF(c.idgolrupkt='24',1,0)) AS 'iid'
            ,SUM(IF(c.idgolrupkt='31',1,0)) AS 'iiia'
            ,SUM(IF(c.idgolrupkt='32',1,0)) AS 'iiib'
            ,SUM(IF(c.idgolrupkt='33',1,0)) AS 'iiic'
            ,SUM(IF(c.idgolrupkt='34',1,0)) AS 'iiid'
            ,SUM(IF(c.idgolrupkt='41',1,0)) AS 'iva'
            ,SUM(IF(c.idgolrupkt='42',1,0)) AS 'ivb'
            ,SUM(IF(c.idgolrupkt='43',1,0)) AS 'ivc'
            ,SUM(IF(c.idgolrupkt='44',1,0)) AS 'ivd'
            ,SUM(IF(c.idgolrupkt='45',1,0)) AS 'ive'
            FROM skpd a
            LEFT JOIN tb_01 c ON a.idskpd=c.idskpd
            WHERE c.idjenkedudupeg NOT IN('21','99')
            AND c.idjenjab = 2 AND LEFT(c.idjabfung,3) = '004'
            $whereskpd
            GROUP BY a.issek
            ORDER BY a.issek
		");
		$n = 0;
		foreach($rs->result() as $item){ $n++;
		$gol[] = $item->gol;
		$golempty[] = $item->golempty;
		$ia[] = $item->ia;
		$ib[] = $item->ib;
		$ic[] = $item->ic;
		$id[] = $item->id;
		$iia[] = $item->iia;
		$iib[] = $item->iib;
		$iic[] = $item->iic;
		$iid[] = $item->iid;
		$iiia[] = $item->iiia;
		$iiib[] = $item->iiib;
		$iiic[] = $item->iiic;
		$iiid[] = $item->iiid;
		$iva[] = $item->iva;
		$ivb[] = $item->ivb;
		$ivc[] = $item->ivc;
		$ivd[] = $item->ivd;
		$ive[] = $item->ive;
		
		
		?>
		<tr>
			<td>
			<span class="ed1" style="display:none"><?=$item->issek?></span>
			<span class="ed2" style="display:none"><?=$this->input->post('idskpd')?></span>
			<div class="text-left"><?=$item->jenjang?></div></td>
			<td><div class="link text-center" data="notnull"><div align='center'><?=$item->gol?></div></div></td>
			<td><div class="link text-center" data="null"><div align='center'><?=$item->golempty?></div></div></td>
			<td><div class="link text-center" data="11" title="Lihat Detail"><div align='center'><?=$item->ia?></div></div></td>
			<td><div class="link text-center" data="12" title="Lihat Detail"><div align='center'><?=$item->ib?></div></div></td>
			<td><div class="link text-center" data="13" title="Lihat Detail"><div align='center'><?=$item->ic?></div></div></td>
			<td><div class="link text-center" data="14" title="Lihat Detail"><div align='center'><?=$item->id?></div></div></td>
			<td><div class="link text-center" data="21" title="Lihat Detail"><div align='center'><?=$item->iia?></div></div></td>
			<td><div class="link text-center" data="22" title="Lihat Detail"><div align='center'><?=$item->iib?></div></div></td>
			<td><div class="link text-center" data="23" title="Lihat Detail"><div align='center'><?=$item->iic?></div></div></td>
			<td><div class="link text-center" data="24" title="Lihat Detail"><div align='center'><?=$item->iid?></div></div></td>
			<td><div class="link text-center" data="31" title="Lihat Detail"><div align='center'><?=$item->iiia?></div></div></td>
			<td><div class="link text-center" data="32" title="Lihat Detail"><div align='center'><?=$item->iiib?></div></div></td>
			<td><div class="link text-center" data="33" title="Lihat Detail"><div align='center'><?=$item->iiic?></div></div></td>
			<td><div class="link text-center" data="34" title="Lihat Detail"><div align='center'><?=$item->iiid?></div></div></td>
			<td><div class="link text-center" data="41" title="Lihat Detail"><div align='center'><?=$item->iva?></div></div></td>
			<td><div class="link text-center" data="42" title="Lihat Detail"><div align='center'><?=$item->ivb?></div></div></td>
			<td><div class="link text-center" data="43" title="Lihat Detail"><div align='center'><?=$item->ivc?></div></div></td>
			<td><div class="link text-center" data="44" title="Lihat Detail"><div align='center'><?=$item->ivd?></div></div></td>
			<td><div class="link text-center" data="45" title="Lihat Detail"><div align='center'><?=$item->ive?></div></div></td>
		</tr>
		<?php
		}
		?>
	</tbody>
	<tfoot class="breadcrumb">
		<tr>
			<th>Total</th>
			<th><div class="text-center"><?=array_sum($gol)?></div></th>
			<th><div class="text-center"><?=array_sum($golempty)?></div></th>
			<th><div class="text-center"><?=array_sum($ia)?></div></th>
			<th><div class="text-center"><?=array_sum($ib)?></div></th>
			<th><div class="text-center"><?=array_sum($ic)?></div></th>
			<th><div class="text-center"><?=array_sum($id)?></div></th>
			<th><div class="text-center"><?=array_sum($iia)?></div></th>
			<th><div class="text-center"><?=array_sum($iib)?></div></th>
			<th><div class="text-center"><?=array_sum($iic)?></div></th>
			<th><div class="text-center"><?=array_sum($iid)?></div></th>
			<th><div class="text-center"><?=array_sum($iiia)?></div></th>
			<th><div class="text-center"><?=array_sum($iiib)?></div></th>
			<th><div class="text-center"><?=array_sum($iiic)?></div></th>
			<th><div class="text-center"><?=array_sum($iiid)?></div></th>
			<th><div class="text-center"><?=array_sum($iva)?></div></th>
			<th><div class="text-center"><?=array_sum($ivb)?></div></th>
			<th><div class="text-center"><?=array_sum($ivc)?></div></th>
			<th><div class="text-center"><?=array_sum($ivd)?></div></th>
			<th><div class="text-center"><?=array_sum($ive)?></div></th>
		</tr>
	</tfoot>	
	
</table>

<?php if($this->uri->segment(3) == 'view') { ?>
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
<?php } ?>