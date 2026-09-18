<h4 class="text-center">{!!$title!!}</h4>
<table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
    <thead class="bg-primary">
    <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2" width="15%">NIP<br>NAMA LENGKAP<br>TEMPAT TANGGAL LAHIR</th>                                                                
        <th rowspan="3" width="20%">JABATAN <br> UNIT KERJA </th>
        <th colspan="2">PENDIDIKAN TERAKHIR</th>
        <th rowspan="2">GOLONGAN</th>
        <th colspan="2">PERJANJIAN KERJA</th>
        <th rowspan="2">JENIS PEMBERHENTIAN</th>
        <th rowspan="2" width="10%">BUP <br> USIA</th>
        <th colspan="2">STATUS</th>         
    </tr>
    <tr>
        <th>JENJANG</th>
        <th>JURUSAN</th>
        <th>MULAI</th>
        <th>SELESAI</th>
        <th>USUL</th>
        <th>SK</th>        
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
        <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtawal)) !!}</td>
        <td align="center">{!! date('d-m-Y', strtotime($pppk->tmtakhir)) !!}</td>
        <td class="text-center">{!!$pppk->jenpens!!}</td>
        <td align="center">
            {!! date('d-m-Y', strtotime($pppk->bup)) !!} <br>
            {!!substr($pppk->usia,0,2)." thn ".substr($pppk->usia,2,2)." bln"!!}
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
    </tr>
    @endforeach
    </tbody>
</table>