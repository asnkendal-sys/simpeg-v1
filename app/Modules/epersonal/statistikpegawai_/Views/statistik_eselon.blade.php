@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Eselon</title>
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
        $('#tb-statistik .link').on('click', function(e){
            e.preventDefault();
			var vidgolru = $(this).attr("data");
			var videsl = $(this).attr("ed1");
			var vidskpd = $(this).attr("ed2");

			$('#form-print #idgolru').val(vidgolru);
			$('#form-print #idskpd').val(vidskpd);
			$('#form-print #idesl').val(videsl);
			$('#form-print').submit();
			
		});
	});
</script>
<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistik_eselon" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
	<input type="hidden" id="idgolru" name="idgolru" value="" />
	<input type="hidden" id="idskpd" name="idskpd" value="" />
	<input type="hidden" id="idesl" name="idesl" value="" />
</form>
<h4 align="center">STATISTIK PEGAWAI BERDASARKAN ESELON DAN GOLONGAN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
    <thead class="bg-primary">
		<tr>
			<th rowspan="3"><div class="text-center">ESELON</div></th>
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
            $where = " b.idjenkedudupeg not in('21','99')";
            if(Input::get('idskpd') != ''){
                $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
            }else{
                $where .= "";
            }

            $rs = \DB::table('a_esl as a')
                ->select(
                    'a.idesl','a.esl',
                    \DB::raw("SUM(if(b.idgolrupkt!='',1,0)) as 'gol'"),
                    \DB::raw("SUM(if(b.idgolrupkt='',1,0)) as 'golempty'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS '_11'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS '_12'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS '_13'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS '_14'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS '_21'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS '_22'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS '_23'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS '_24'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS '_31'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS '_32'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS '_33'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS '_34'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS '_41'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS '_42'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS '_43'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS '_44'"),
                    \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS '_45'")
                )
                ->leftjoin('tb_01 as b', 'a.idesl', '=', 'b.idesljbt')
                ->whereRaw($where)
                ->orderBy('a.idesl', 'asc')
                ->groupBy('a.idesl')
                ->get();
            $n = 0;
        ?>

        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php
                    $n++;
                    $gol[] = $item->gol;
                    $golempty[] = $item->golempty;
                    $ia[] = $item->_11;
                    $ib[] = $item->_12;
                    $ic[] = $item->_13;
                    $id[] = $item->_14;
                    $iia[] = $item->_21;
                    $iib[] = $item->_22;
                    $iic[] = $item->_23;
                    $iid[] = $item->_24;
                    $iiia[] = $item->_31;
                    $iiib[] = $item->_32;
                    $iiic[] = $item->_33;
                    $iiid[] = $item->_34;
                    $iva[] = $item->_41;
                    $ivb[] = $item->_42;
                    $ivc[] = $item->_43;
                    $ivd[] = $item->_44;
                    $ive[] = $item->_45;
                ?>
                <tr>
                    <td><div class="text-left">{!!$item->esl!!}</div></td>
                    <td><div class="link text-center" data="notnull" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->gol!!}</div></div></td>
                    <td><div class="link text-center" data="null" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->golempty!!}</div></div></td>
                    <td><div class="link text-center" data="11" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_11!!}</div></div></td>
                    <td><div class="link text-center" data="12" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_12!!}</div></div></td>
                    <td><div class="link text-center" data="13" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_13!!}</div></div></td>
                    <td><div class="link text-center" data="14" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_14!!}</div></div></td>
                    <td><div class="link text-center" data="21" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_21!!}</div></div></td>
                    <td><div class="link text-center" data="22" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_22!!}</div></div></td>
                    <td><div class="link text-center" data="23" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_23!!}</div></div></td>
                    <td><div class="link text-center" data="24" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_24!!}</div></div></td>
                    <td><div class="link text-center" data="31" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_31!!}</div></div></td>
                    <td><div class="link text-center" data="32" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_32!!}</div></div></td>
                    <td><div class="link text-center" data="33" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_33!!}</div></div></td>
                    <td><div class="link text-center" data="34" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_34!!}</div></div></td>
                    <td><div class="link text-center" data="41" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_41!!}</div></div></td>
                    <td><div class="link text-center" data="42" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_42!!}</div></div></td>
                    <td><div class="link text-center" data="43" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_43!!}</div></div></td>
                    <td><div class="link text-center" data="44" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_44!!}</div></div></td>
                    <td><div class="link text-center" data="45" ed1="{!!$item->idesl!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_45!!}</div></div></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="23">Data tidak ditemukan.</td>
            </tr>
        @endif
	</tbody>
    @if(count($rs) > 0)
        <tfoot>
            <tr>
                <th>Total</th>
                <th><div class="text-center">{!!array_sum($gol)!!}</div></th>
                <th><div class="text-center">{!!array_sum($golempty)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ia)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ib)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ic)!!}</div></th>
                <th><div class="text-center">{!!array_sum($id)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iia)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iib)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iic)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iid)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iiia)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iiib)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iiic)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iiid)!!}</div></th>
                <th><div class="text-center">{!!array_sum($iva)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ivb)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ivc)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ivd)!!}</div></th>
                <th><div class="text-center">{!!array_sum($ive)!!}</div></th>
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