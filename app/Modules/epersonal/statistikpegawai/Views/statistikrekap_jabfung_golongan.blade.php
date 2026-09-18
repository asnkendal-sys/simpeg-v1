@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Jabatan Fungsional dan Golongan</title>
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
			var vidjenjab = $(this).attr("ed1");

			$('#form-print #idgolru').val(vidgolru);
      $('#form-print #idjenjab').val(vidjenjab);
			$('#form-print').submit();

		});
	});
</script>

<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistikrekap_jabfung_golongan" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
	<input type="hidden" id="idgolru" name="idgolru" value="" />
  <input type="hidden" id="idjenjab" name="idjenjab" value="" />
</form>
<h4 align="center">REKAPITULASI JABATAN FUNGSIONAL BERDASARKAN GOLONGAN RUANG PER - {{strtoupper(formatBulan(date('m')))}} {{ date('Y')}}</h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
	<thead class="bg-primary">
		<tr>
			<th rowspan="2"><div class="text-center">GOLONGAN RUANG</div></th>
      <th rowspan="2"><div class="text-center">JUMLAH</div></th>
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

        $rs = \DB::table('a_golruang as a')
            ->select(
                'a.golru', 'b.idjenjab', 'b.idgolrupkt','b.idskpd',
                \DB::raw("SUM(IF(a.idgolru=b.idgolrupkt AND b.idjenjab='2',1,0)) AS 'jumlah'"),
                \DB::raw("SUM(if(left(b.idgolrupkt,1)='1' AND b.idjenjab='2',1,0)) as 'satu'"),
                \DB::raw("SUM(if(left(b.idgolrupkt,1)='2' AND b.idjenjab='2',1,0)) as 'dua'"),
                \DB::raw("SUM(if(left(b.idgolrupkt,1)='3' AND b.idjenjab='2',1,0)) as 'tiga'"),
                \DB::raw("SUM(if(left(b.idgolrupkt,1)='4' AND b.idjenjab='2',1,0)) as 'empat'")
            )
            ->join('tb_01 as b','a.idgolru', '=', 'b.idgolrupkt')
            ->whereRaw($where)
            ->groupBy('a.idgolru')
            ->get();

        $n = 0;
        $arr[0]= ""
    ?>

    @if(count($rs) > 0)
        @foreach($rs as $item)
          <?php
              $n++;
              $jumlah[] = $item->jumlah;
              $satu[] = $item->satu;
              $dua[] = $item->dua;
              $tiga[] = $item->tiga;
              $empat[] = $item->empat;
           ?>

            <tr>
                <td><div class="text-left">Golongan - {!!$item->golru!!}</div></td>
                <td><div class="link text-center" data="{!!$item->idgolrupkt!!}" ed1="{!!$item->idjenjab!!}">{!!$item->jumlah!!}</div></td>
            </tr>
            <?php
              if($n == '4'){
            ?>
            <tr>
              <td><div class="text-left" style="font-weight:bold;">Jumlah Golongan - I</div></td>
              <th><div class="text-center">{!!array_sum($satu)!!}</div></th>
            </tr>
          <?php } ?>

          <?php
            if($n == '8'){
          ?>
          <tr>
            <td><div class="text-left" style="font-weight:bold;">Jumlah Golongan - II</div></td>
            <th><div class="text-center">{!!array_sum($dua)!!}</div></th>
          </tr>
        <?php } ?>

        <?php
          if($n == '12'){
        ?>
        <tr>
          <td><div class="text-left" style="font-weight:bold;">Jumlah Golongan - III</div></td>
          <th><div class="text-center">{!!array_sum($tiga)!!}</div></th>
        </tr>
      <?php } ?>

      <?php
        if($n == '17'){
      ?>
      <tr>
        <td><div class="text-left" style="font-weight:bold;">Jumlah Golongan - IV</div></td>
        <th><div class="text-center">{!!array_sum($empat)!!}</div></th>
      </tr>
    <?php } ?>

        @endforeach
    @else
        <tr>
            <td colspan="20">Data tidak ditemukan.</td>
        </tr>
    @endif
    </tbody>
    @if(count($rs) > 0)
        <tfoot class="breadcrumb">
          <th rowspan="2"><div class="text-center">TOTAL</div></th>
          <th rowspan="2"><div class="text-center">{!!array_sum($jumlah)!!}</div></th>
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
