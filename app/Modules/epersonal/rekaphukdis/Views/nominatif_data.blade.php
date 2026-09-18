
<style type='text/css'>
	table {
		font-family: 'Arial';
		font-size: 9pt;
		background: white;
		line-height:1.5;
	}

	table{
	border-collapse:collapse;
	border-width:1px;
	width:100%;
	}

	table thead tr th,table tfoot tr th{
        background-color:#337ab7;
		font-weight:bold;
		padding:4px;
	}

	table tbody tr td{
		padding:4px;
		vertical-align:top;
	}

	table.gen tbody tr td{
		/*height:40px; */
	}

	table tbody td div.r,table tfoot td div.r,table tfoot th div.r{
		text-align:right;
	}
</style>

<?php
    /* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1')).' S/D '.formatBulan(Input::get('bulan2'));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan1'));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $titlebulan = ' BULAN '.formatBulan(Input::get('bulan2'));
    }
?>
<br><div align="center">
<h4>DAFTAR NOMINATIF HUKUMAN DISIPLIN</h4>
<h4>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'')!!}
    {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h4>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th rowspan="2"><div class="text-center">NO</div></th>
        <th rowspan="2">
            <div class="text-center">NIP</div>
        </th>
        <th rowspan="2">
            <div class="text-left">NAMA</div>
            <div class="text-left">TEMPAT, TGL LAHIR</div>
        </th>
        <th rowspan="2">
            <div class="text-center">JENIS HUKUM DISIPLIN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">TINGKAT</div>
        </th>
        <th rowspan="2">
            <div class="text-center">PEJABAT</div>
        </th>
        <th rowspan="2">
            <div class="text-center">NO. SK</div>
        </th>
        <th rowspan="2">
            <div class="text-center">TGL. SK</div>
        </th>
        <th colspan="2">
            <div class="text-center">LAMA HUKUMAN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">KETERANGAN</div>
        </th>
        <!-- <th rowspan="2">
            <div class="text-center">AGAMA</div>
            <div class="text-center">USIA</div>
        </th> -->
    </tr>
    <tr>
        <th>
            <div class="text-center">TGL. MULAI</div>
        </th>
        <th>
            <div class="text-center">TGL. SELESAI</div>
        </th>
    </tr>
  </thead>
  <tbody>
    <?php

    if(count($rs) != ''){
    $n = 0;
	foreach($rs as $item){ $n++;
	?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td align="center">
            <div class="text-center">{!!fnip($item->nip)!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->jenhukum!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->kathukdis!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->namapejab!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->nosk!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tgsk))!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tgmul))!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!date('d-m-Y', strtotime($item->tgsel))!!}</div>
        </td>
        <td>
            <div class="text-left">{!!$item->ket!!}</div>
        </td>
    </tr>
        <?php
            }} else {
        ?>
            <tr>
                <td align="center" colspan="15"><h4>Data Tidak Ditemukan</h4></td>
            </tr>
        <?php  }

        ?>
  </tbody>
</table>
