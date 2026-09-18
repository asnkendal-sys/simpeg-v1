<?php
    $nip = \Input::get('nip');
    $jenislayanan = \Input::get('jnslayanan');
    switch($jnslayanan){
        case(1) :
            $layanan = 'Kenaikan Gaji Berkala';
            $table = 'tr_kgb';
        break;
        case(2) :
            $layanan = 'Ijin Cuti';
            $table = 'tr_ijin_cuti';
        break;
        case(3) :
            $layanan = 'Ijin Belajar';
            $table = 'tr_ibel_usul';
        break;
        default :
            $layanan = '';
            $table = '';
        break;
    }

    $x = 0;
?>

    @if($jnslayanan == '1')
    <!--kenaikan gaji berkala-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
            <tr>
                <td align="center" width="2%">No.</td>
                <td align="center">NIP <br> Nama Lengkap</td>
                <td align="center" width="20%">Unit Kerja</td>
                <td align="center">Jenis Layanan</td>
                <td align="center">Tanggal Usul</td>
                <td align="center" colspan="2">TMT Surat</td>
            </tr>
        </thead>
        <tbody>
        <?php $rs = \DB::table($table)->where('nip', $nip)->get(); ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
            <?php $x++; ?>
            <tr>
                <td rowspan="3" align="center" width="2%">{{$x}}</td>
                <td >{{$item->nip}} <br> {{$item->nama}}</td>
                <td  width="20%">{{ucfirsts($item->namaskpd)}} {{ucfirsts($item->tmpskpdskr)}}</td>
                <td >{{$layanan}}</td>
                <td align="center">{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td colspan="2" align="center">{{date('d-m-Y', strtotime($item->tmtkgbb))}}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">Response</td>
                <td class="text-center">Tanggal Surat</td>
                <td class="text-center">Sts Usul</td>
                <td class="text-center">Sts SK</td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php
                        if($item->statususul==1){
                            if($item->statususul=='1' && $item->statussk=='2'){
                                echo '<div class="control-group">
                                    <label class="control-label">Status Berkas</label>
                                    <div class="controls">
                                        <span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/></span> Sedang Diproses
                                    </div>
                                </div>';
                            }else if($item->statussk=='1'){
                                echo '<div class="control-group">
                                    <label class="control-label">Status Berkas</label>
                                    <div class="controls">
                                        <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span> Selesai diproses
                                    </div>
                                </div>';

                                if($item->iscetaksk == 1){
                                    echo '<div class="control-group">
                                        <label class="control-label">Status SPT</label>
                                        <div class="controls">
                                            <span style="color:#ffcc00"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                        </div>
                                    </div>';
                                }else if($item->iscetaksk == 2){
                                    echo '<div class="control-group">
                                        <label class="control-label">Status SK</label>
                                        <div class="controls">
                                            <span style="color:#000000"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> SK Dibatalkan
                                        </div>
                                    </div>';
                                }
                            }
                        } else if($item->statususul==2){
                            echo '<div class="control-group">
                                <label class="control-label">Keterangan</label>
                                <div class="controls">
                                    <span style="color:red"><span class="glyphicon glyphicon-remove-circle"/></span> '.$item->kettms.'
                                </div>
                            </div>';
                        }else if($item->statususul==3){
                            echo '<div class="control-group">
                                <label class="control-label">Keterangan</label>
                                <div class="controls">
                                    <span style="color:orange"><span class="glyphicon glyphicon-info-sign"/></span> '.$item->ketbtl.'
                                </div>
                            </div>';
                        }
                    ?>

                </td>
                <td class="text-center">{{($item->tglskkgbb!='0000-00-00')?date('d-m-Y', strtotime($item->tglskkgbb)):'-'}}</td>
                <td class="text-center">
                    <?php
                        if($item->statususul==1){
                            echo '<span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Memenuhi Syarat"/><span>';
                        }else if($item->statususul==2){
                            echo '<span style="color:red"><span class="glyphicon glyphicon-remove-circle" title="Tidak Memenuhi Syarat"/></span>';
                        }else if($item->statususul==3){
                            echo '<span style="color:orange"><span class="glyphicon glyphicon-info-sign" title="Berkas Tidak Lengkap"/></span>';
                        }else{
                            echo '-';
                        }
                    ?>
                </td>
                <td class="text-center">
                    <?php
                        if($item->statususul=='1' && $item->statussk=='2'){
                            echo '<span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/><span>';
                        }else if($item->statussk=='1'){
                            echo '<span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span>';
                        }else {
                            echo '-';
                        }
                    ?>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">Data tidak ditemukan.</td>
            </tr>
        @endif
        </tbody>
    </table>
    @elseif($jnslayanan == '2')
    <!--Ijin Pegawai-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
        <tr>
            <td align="center" width="2%">No.</td>
            <td align="center">NIP <br> Nama Lengkap</td>
            <td align="center" width="20%">Unit Kerja</td>
            <td align="center">Jenis Layanan</td>
            <td align="center">Tanggal Usul</td>
            <td class="text-center">Tanggal SK</td>
        </tr>
        </thead>
        <tbody>
        <?php
            /*ijin belajar*/
            $rs1 = \DB::connection('mysql2')->table('ibel_usul')->select('nip', \DB::raw("IF(nip!='','Ijin Belajar','-') AS jenisijin"), 'idskpd', \DB::raw("tgusul as tglusul"), 'status', \DB::raw("status as statproses"), 'no_skep', 'tgl_skep', \DB::raw("alasanditolak as ketkurang"), \DB::raw("ketlain as kettambahan"))->where('nip', $nip);
            /*ijin cuti*/
            $rs2 = \DB::connection('mysql2')->table('cuti_usulan')->leftjoin('ijin_jeniscuti', 'cuti_usulan.jenisijin', '=', 'ijin_jeniscuti.id')->select('nip', 'ijin_jeniscuti.jenis', 'idskpd', 'tglusul', 'status', 'statproses', \DB::raw("nosurat as no_skep"), \DB::raw("tglterbit as tgl_skep"), 'ketkurang', 'kettambahan')->where('nip', $nip);
            /*ijin cerai*/
            $rs3 = \DB::connection('mysql2')->table('cerai_usulan')->select('nip', \DB::raw("IF(nip!='','Ijin Cerai','-') AS jenisijin"), 'idskpd', 'tglusul', \DB::raw("status_usul as status"), \DB::raw("status_cerai as statproses"), 'no_skep', 'tgl_skep', \DB::raw("ketlain as ketkurang"), \DB::raw("ketlain as kettambahan"))->where('nip', $nip);
            $rs = $rs1->union($rs2)->union($rs3)->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jenisijin}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tglusul))}}</td>
                    <td class="text-center">{{(date('d-m-Y', strtotime($item->tgl_skep))!='01-01-1970')?date('d-m-Y', strtotime($item->tgl_skep)):'-'}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Response</td>
                    <td class="text-center">Sts Usul</td>
                    <td class="text-center">Sts SK</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                            if($item->status==1){
                                echo '<b>Status Berkas :</b><br> <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Memenuhi Syarat"/><span> Memenuhi Syarat';
                            }else if($item->status==2){
                                echo '<b>Status Berkas :</b><br> <span style="color:red"><span class="glyphicon glyphicon-remove-circle" title="Tidak Memenuhi Syarat"/></span> '.$item->ketkurang;
                            }else if($item->status==3){
                                echo '<b>Status Berkass :</b><br> <span style="color:orange"><span class="glyphicon glyphicon-info-sign" title="Berkas Tidak Lengkap"/></span> '.$item->kettambahan;
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            if($item->status==1){
                                echo '<span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Memenuhi Syarat"/><span>';
                            }else if($item->status==2){
                                echo '<span style="color:red"><span class="glyphicon glyphicon-remove-circle" title="Tidak Memenuhi Syarat"/></span>';
                            }else if($item->status==3){
                                echo '<span style="color:orange"><span class="glyphicon glyphicon-info-sign" title="Berkas Tidak Lengkap"/></span>';
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            if(($item->jenisijin = 'Ijin Belajar') or ($item->jenisijin = 'Ijin Cerai')){
                                if($item->status=='1'){
                                    if($item->no_skep != '') {
                                        echo '<span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span>';
                                    } else {
                                        echo '<span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/><span>';
                                    }
                                } else{
                                    echo '-';
                                }
                            }else{
                                if($item->statproses=='1'){
                                    echo '<span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/><span>';
                                }else if($item->statproses=='2'){
                                    echo '<span style="color:blue"><span class="fa fa-arrow-circle-o-up" title="Pengiriman berkas"/></span>';
                                }else if($item->statproses=='3'){
                                    echo '<span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span>';
                                }else {
                                    echo '-';
                                }
                            }

                        ?>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">Data tidak ditemukan.</td>
            </tr>
        @endif
        </tbody>
    </table>
    @elseif($jnslayanan == '3')
    <!--Mutasi Pegawai-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
        <tr>
            <td align="center" width="2%">No.</td>
            <td align="center">NIP <br> Nama Lengkap</td>
            <td align="center" width="20%">Unit Kerja</td>
            <td align="center">Jenis Layanan</td>
            <td align="center">Tanggal Usul</td>
            <td align="center" colspan="2">TMT Surat</td>
        </tr>
        </thead>
        <tbody>
        <?php
            /*mutasi_dalam_skpd*/
            $rs1 = \DB::connection('mysql2')->table($table1)->select('nip', \DB::raw("IF(nip!='','Mutasi Dalam SKPD','-') AS jnsmutasi"), 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tgin', 'iscetaksk')->where('nip', $nip);
            /*mutasi_dalam_daerah*/
            $rs2 = \DB::connection('mysql2')->table($table2)->select('nip', \DB::raw("IF(nip!='','Mutasi Dalam Daerah','-') AS jnsmutasi"), 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tgin', 'iscetaksk')->where('nip', $nip);
            /*mutasi_luar_daerah*/
            $rs3 = \DB::connection('mysql2')->table($table3)->select('nip', \DB::raw("IF(nip!='','Mutasi Luar Daerah','-') AS jnsmutasi"), 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tgin', 'iscetaksk')->where('nip', $nip);
            /*mutasi_masuk_daerah*/
            $rs4 = \DB::connection('mysql2')->table($table4)->select('nip', \DB::raw("IF(nip!='','Mutasi Masuk Daerah','-') AS jnsmutasi"),  \DB::raw("IF(nip!='','-','-') AS idskpd"), 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tgin', 'iscetaksk')->where('nip', $nip);
            $rs = $rs1->union($rs2)->union($rs3)->union($rs4)->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jnsmutasi}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tgin))}}</td>
                    <td colspan="2" align="center">{{($item->tmt!='0000-00-00')?date('d-m-Y', strtotime($item->tmt)):'-'}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Response</td>
                    <td class="text-center">Tanggal Surat</td>
                    <td class="text-center">Sts Usul</td>
                    <td class="text-center">Sts SK</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                            if($item->statususul==1){
                                if($item->statususul=='1' && $item->statussk=='2'){
                                    echo '<div class="control-group">
                                        <label class="control-label">Status Berkas</label>
                                        <div class="controls">
                                            <span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/></span> Sedang Diproses
                                        </div>
                                    </div>';
                                }else if($item->statussk=='1'){
                                    echo '<div class="control-group">
                                        <label class="control-label">Status Berkas</label>
                                        <div class="controls">
                                            <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span> Selesai diproses
                                        </div>
                                    </div>';

                                    if($item->iscetaksk == 1){
                                        echo '<div class="control-group">
                                            <label class="control-label">Status SK</label>
                                            <div class="controls">
                                                <span style="color:#ffcc00"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                            </div>
                                        </div>';
                                    }else if($item->iscetaksk == 2){
                                        echo '<div class="control-group">
                                            <label class="control-label">Status SK</label>
                                            <div class="controls">
                                                <span style="color:#000000"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> SK Dibatalkan
                                            </div>
                                        </div>';
                                    }
                                }
                            } else if($item->statususul==2){
                                echo '<div class="control-group">
                                    <label class="control-label">Keterangan</label>
                                    <div class="controls">
                                        <span style="color:red"><span class="glyphicon glyphicon-remove-circle"/></span> '.$item->kettms.'
                                    </div>
                                </div>';
                            }else if($item->statususul==3){
                                echo '<div class="control-group">
                                    <label class="control-label">Keterangan</label>
                                    <div class="controls">
                                        <span style="color:orange"><span class="glyphicon glyphicon-info-sign"/></span> '.$item->ketbtl.'
                                    </div>
                                </div>';
                            }
                        ?>
                    </td>
                    <td class="text-center">{{($item->tglsurat!='0000-00-00')?date('d-m-Y', strtotime($item->tglsurat)):'-'}}</td>
                    <td class="text-center">
                        <?php
                            if($item->statususul==1){
                                echo '<span style="color:green"><i class="glyphicon glyphicon-ok-circle" title="Memenuhi Syarat"/><i>';
                            }else if($item->statususul==2){
                                echo '<span style="color:red"><i class="glyphicon glyphicon-remove-circle" title="Tidak Memenuhi Syarat"/></i>';
                            }else if($item->statususul==3){
                                echo '<span style="color:orange"><i class="glyphicon glyphicon-info-sign" title="Berkas Tidak Lengkap"/></i>';
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            if($item->statususul=='1' && $item->statussk=='2'){
                                echo '<span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/><i>';
                            }else if($item->statussk=='1'){
                                echo '<span style="color:green"><i class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></i>';
                            }else {
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">Data tidak ditemukan.</td>
            </tr>
        @endif
        </tbody>
    </table>
    @endif
