@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Jabatan Dan Golongan</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
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
            background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
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
@else
    <style>
        .link{
            cursor:pointer;
        }
    </style>
@endif

<script>
	$(document).ready(function(){
		$('#tb-statistik .link').click(function(){
			var vidgolru = $(this).attr("data");
			var vidskpd = $(this).attr("ed1");
      var vidjenjab = $(this).attr("ed2");

			$('#form-print #idgolru').val(vidgolru);
			$('#form-print #idskpd').val(vidskpd);
      $('#form-print #idjenjab').val(vidjenjab);
			$('#form-print').submit();

		});
	});
</script>

<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistikrekap_jabatan_golongan" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
	<input type="hidden" id="idgolru" name="idgolru" value="" />
	<input type="hidden" id="idskpd" name="idskpd" value="" />
  <input type="hidden" id="idjenjab" name="idjenjab" value="" />
</form>
<h4 align="center">REKAPITULASI PNS DIRINCI MENURUT JABATAN STRUKTURAL, JABATAN FUNGSIONAL DAN STAFF PEMERINTAH KABUPATEN KENDAL TAHUN {{ date('Y')}}</h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
	<thead class="bg-primary">
		<tr>
			<th rowspan="2"><div class="text-center">NAMA SKPD</div></th>
      <th rowspan="2"><div class="text-center">JML</div></th>
      <th rowspan="2"><div class="text-center">JML GOL KOSONG</div></th>
      <th rowspan="2"><div class="text-center">JML JENJAB KOSONG</div></th>
			<th colspan="3"><div class="text-center">STRUKTURAL</div></th>
      <th colspan="4"><div class="text-center">FUNGSIONAL</div></th>
      <th colspan="4"><div class="text-center">STAFF</div></th>

		</tr>
		<tr>
			<th><div class="text-center">II</div></th>
			<th><div class="text-center">III</div></th>
			<th><div class="text-center">IV</div></th>
			 <!-- <th><div class="text-center">V</div></th> -->
			<th><div class="text-center">I</div></th>
			<th><div class="text-center">II</div></th>
			<th><div class="text-center">III</div></th>
			<th><div class="text-center">IV</div></th>
      <th><div class="text-center">I</div></th>
      <th><div class="text-center">II</div></th>
      <th><div class="text-center">III</div></th>
      <th><div class="text-center">IV</div></th>
		</tr>
	</thead>
	<tbody>
        <?php
        $where = " b.idjenkedudupeg not in('21','99')";
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }

        $rs = \DB::table('a_skpd as a')
            ->select(
                'b.idskpd', 'b.idgolrupkt', 'b.idjenjab', 'a.idskpd', 'a.skpd',
                \DB::raw("COUNT(*) AS 'gol'"),
                // \DB::raw("SUM(if(b.idjenjab!='' and b.idgolrupkt!='',1,0)) as 'gol'"),
                \DB::raw("SUM(if(b.idgolrupkt='',1,0)) as 'golempty'"),
                \DB::raw("SUM(if(isnull(idjenjab) or b.idjenjab='',1,0)) as 'jenjabempty'"),
                \DB::raw("SUM(IF(b.idjenjab>='20' and b.idgolrupkt!='',1,0)) AS 'struktural'"),
                \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'strukdua'"),
                \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'struktiga'"),
                \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'strukempat'"),
                \DB::raw("SUM(IF(b.idjenjab>='20' AND LEFT(b.idgolrupkt,1)='5',1,0)) AS 'struklima'"),
                \DB::raw("SUM(IF(b.idjenjab='2' and b.idgolrupkt!='',1,0)) AS 'fungsional'"),
                \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='1',1,0)) AS 'fungsatu'"),
                \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'fungdua'"),
                \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'fungtiga'"),
                \DB::raw("SUM(IF(b.idjenjab='2' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'fungempat'"),
                \DB::raw("SUM(IF(b.idjenjab='3' and b.idgolrupkt!='',1,0)) AS 'pelaksana'"),
                \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='1',1,0)) AS 'pelsatu'"),
                \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='2',1,0)) AS 'peldua'"),
                \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='3',1,0)) AS 'peltiga'"),
                \DB::raw("SUM(IF(b.idjenjab='3' AND LEFT(b.idgolrupkt,1)='4',1,0)) AS 'pelempat'")
            )
            ->join('tb_01 as b', \DB::raw("LEFT(b.idskpd,2)"), '=', 'a.idskpd')
            ->whereRaw($where)
            ->groupBy(\DB::raw("LEFT(b.idskpd,2)"))
            ->get();

        $n = 0;
    ?>

    @if(count($rs) > 0)
        @foreach($rs as $item)
            <?php
                $n++;
                $gol[] = $item->gol;
                $golempty[] = $item->golempty;
                $jenjabempty[] = $item->jenjabempty;
                $strukdua[] = $item->strukdua;
                $struktiga[] = $item->struktiga;
                $strukempat[] = $item->strukempat;
                $struklima[] = $item->struklima;
                $fungsatu[] = $item->fungsatu;
                $fungdua[] = $item->fungdua;
                $fungtiga[] = $item->fungtiga;
                $fungempat[] = $item->fungempat;
                $pelsatu[] = $item->pelsatu;
                $peldua[] = $item->peldua;
                $peltiga[] = $item->peltiga;
                $pelempat[] = $item->pelempat;
                $struktural[] = $item->struktural;
                $fungsional[] = $item->fungsional;
                $pelaksana[] = $item->pelaksana;
            ?>
            <tr>
                <td><div class="text-left">{!!$item->skpd!!}</div></td>
                <td><div class="link text-center" data="notnull" ed1="{!!$item->idskpd!!}">{!!$item->gol!!}</div></td>
                <td><div class="link text-center" data="nullgol" ed1="{!!$item->idskpd!!}">{!!$item->golempty!!}</div></td>
                <td><div class="link text-center" data="nulljab" ed1="{!!$item->idskpd!!}">{!!$item->jenjabempty!!}</div></td>
                <td><div class="link text-center" data="2" ed2="20" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->strukdua!!}</div></td>
                <td><div class="link text-center" data="3" ed2="20" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->struktiga!!}</div></td>
                <td><div class="link text-center" data="4" ed2="20" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->strukempat!!}</div></td>
                <!-- <td><div class="link text-center" data="5" ed2="20" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->struklima!!}</div></td> -->
                <td><div class="link text-center" data="1" ed2="2" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->fungsatu!!}</div></td>
                <td><div class="link text-center" data="2" ed2="2" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->fungdua!!}</div></td>
                <td><div class="link text-center" data="3" ed2="2" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->fungtiga!!}</div></td>
                <td><div class="link text-center" data="4" ed2="2" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->fungempat!!}</div></td>
                <td><div class="link text-center" data="1" ed2="3" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->pelsatu!!}</div></td>
                <td><div class="link text-center" data="2" ed2="3" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->peldua!!}</div></td>
                <td><div class="link text-center" data="3" ed2="3" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->peltiga!!}</div></td>
                <td><div class="link text-center" data="4" ed2="3" ed1="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->pelempat!!}</div></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="20">Data tidak ditemukan.</td>
        </tr>
    @endif
    </tbody>
    @if(count($rs) > 0)
        <tfoot class="breadcrumb">
            <tr>
                <th rowspan="2"><div class="text-center">TOTAL</div></th>
                <th rowspan="2"><div class="text-center">{!!array_sum($gol)!!}</div></th>
                <th rowspan="2"><div class="text-center">{!!array_sum($golempty)!!}</div></th>
                <th rowspan="2"><div class="text-center">{!!array_sum($jenjabempty)!!}</div></th>
                <th><div class="text-center">{!!array_sum($strukdua)!!}</div></th>
                <th><div class="text-center">{!!array_sum($struktiga)!!}</div></th>
                <th><div class="text-center">{!!array_sum($strukempat)!!}</div></th>
                <!-- <th><div class="text-center">{!!array_sum($struklima)!!}</div></th> -->
                <th><div class="text-center">{!!array_sum($fungsatu)!!}</div></th>
                <th><div class="text-center">{!!array_sum($fungdua)!!}</div></th>
                <th><div class="text-center">{!!array_sum($fungtiga)!!}</div></th>
                <th><div class="text-center">{!!array_sum($fungempat)!!}</div></th>
                <th><div class="text-center">{!!array_sum($pelsatu)!!}</div></th>
                <th><div class="text-center">{!!array_sum($peldua)!!}</div></th>
                <th><div class="text-center">{!!array_sum($peltiga)!!}</div></th>
                <th><div class="text-center">{!!array_sum($pelempat)!!}</div></th>

            </tr>
            <tr>
              <th colspan="4"><div class="text-center">{!!array_sum($struktural)!!}</div></th>
              <th colspan="4"><div class="text-center">{!!array_sum($fungsional)!!}</div></th>
              <th colspan="4"><div class="text-center">{!!array_sum($pelaksana)!!}</div></th>
            </tr>
        </tfoot>
    @endif
</table>

@if(Request::segment(3) == 'print')
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
@endif
