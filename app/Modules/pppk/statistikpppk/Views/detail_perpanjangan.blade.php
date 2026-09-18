<h4 class="text-center">{!!$title!!}</h4>
<table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
    <thead class="bg-primary">
    <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2" width="15%">NIP<br>NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>                                
        <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA </th>
        <th colspan="2">PENDIDIKAN TERAKHIR</th>
        <th rowspan="2">GOLONGAN</th>
        <th colspan="2">MASA KERJA</th>
        <th colspan="2">RENCANA KONTRAK</th>
        <th colspan="2">RENCANA PERJANJIAN</th>
        <th rowspan="2" width="10%">USIA</th>
        <th colspan="4">STATUS</th>        
    </tr>
    <tr>
        <th>JENJANG</th>
        <th>JURUSAN</th>
        <th>THN</th>
        <th>BLN</th>
        <th>THN</th>
        <th>BLN</th>
        <th>MULAI</th>
        <th>SELESAI</th>                                
        <th>USUL</th>
        <th>PROS</th>
        <th>SK</th>
        <th>TTE</th>
    </tr>
    </thead>
    <tbody>
    <?php $x = 0; ?>
    @foreach ($detail as $pppk)
    <?php $x++; ?>
    <tr>
        <td class="text-center">{!! $x !!}</td>
        <td>
            <b>{!!$pppk->nip!!}</b> <br>
            <b>{!!$pppk->nama !!}</b> <br>
            <small>{!!$pppk->tmlhr.", ".(($pppk->tglhr != '0000-00-00')?date('d-m-Y', strtotime($pppk->tglhr)):'')!!}</small>
            <div class="text-right" style="position:relative">
                <?php
                if($pppk->iscetaksk == 1){
                    echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                }else if($pppk->iscetaksk == 2){
                    echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                }
                ?>
            </div>
        </td>                                    
        <td><small>{!! $pppk->jab." PADA ".$pppk->skpd!!}</small></td>
        <td align="left">{!! $pppk->tkpendid !!}</td>
        <td align="left">{!! $pppk->jenjurusan !!}</td>
        <td class="text-center">{!!$pppk->golru!!}</td>
        <td class="text-center">{!!$pppk->thkerja!!}</td>
        <td class="text-center">{!!$pppk->blkerja!!}</td>
        @if($pppk->status==1)
        <td align="center">{!! $pppk->perpanjangan !!}</td>
        <td align="center">{!! $pppk->perpanjangan_bulan !!}</td>
        <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtawal)) !!}</td>
        <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtakhir)) !!}</td>                                    
        @else
        <td colspan="4"><b>Tidak Diusulkan</b> <br>{!! $pppk->status_keterangan !!}</td>
        @endif
        <td class="text-center">{!!substr($pppk->usia,0,2)." thn ".substr($pppk->usia,2,2)." bln"!!}</td>
        <td class="text-center">
            <?php 
                if($pppk->status==1){
                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Diusulkan"/><span>';
                }else{
                    echo '<span style="color:red"><i class="fa fa-minus-circle" title="Tidak Diusulkan"/></span>';
                }    
            ?>
        </td>   
        <td class="text-center">
            <?php
                if($pppk->statususul==1){
                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                }else if($pppk->statususul==2){
                    echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                }else if($pppk->statususul==3){
                    echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                }else{
                    echo '-';
                }
            ?>
        </td>
        <td class="text-center">
            <?php
                if($pppk->statususul=='1' && $pppk->statussk=='2'){
                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                }else if($pppk->statussk=='1'){
                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                }else {
                    echo '-';
                }
            ?>
        </td>
        <td class="text-center">
            @if($pppk->sts_kontrak == 2)
                <?php  $proses_tte = $pppk->statusTTE(); ?>

                @if($proses_tte == "Selesai")
                    <span style="color:green"><i class="fa fa-check-square" title="Selesai"/></span>
                @elseif($proses_tte == "Mengusulkan")
                    <span style="color:blue"><i class="fa  fa-caret-square-o-up" title="Mengusulkan"/></span>
                @else
                    -
                @endif
            @endif
        </td>        
    </tr>
    @endforeach
    </tbody>
</table>