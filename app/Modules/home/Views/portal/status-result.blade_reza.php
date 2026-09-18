<?php
    $nip = \Input::get('nip');
    $jenislayanan = \Input::get('jnslayanan');
    switch($jnslayanan){
        case(1) :
            $layanan = 'Fasilitas Pegawai';
            $table = 'fasilitas_usul';
        break;
        case(2) :
            $layanan = 'Kenaikan Gaji Berkala';
            $table = 'tr_kgb';
        break;
        case(3) :
            $layanan = 'Ijin Pegawai';
            $table1 = 'cuti_usulan';
            $table2 = 'ibel_usul';
            $table3 = 'cerai_usulan';
        break;
        case(4) :
            $layanan = 'Mutasi Pegawai';
            $table1 = 'tr_mutasi_dalam_skpd';
            $table2 = 'tr_mutasi_dalam_daerah';
            $table3 = 'tr_mutasi_luar_daerah';
            $table4 = 'tr_mutasi_masuk_daerah';
        break;
        case(5) :
            $layanan = 'Jabatan Pegawai';
            $table1 = 'jabfung_pengangkatan';
            $table2 = 'jabfung_kenaikan';
            $table3 = 'jabstruk_pengangkatan';
            $table4 = 'jabatan_kepsek';
        break;
        case(6) :
            $layanan = 'Hukuman Disiplin';
            $table = 'tb_hudis';
        break;
        case(7) :
            $layanan = 'Diklat Pegawai';
            $table1 = 'diklat_peserta';
            $table2 = 'diklatteknis_peserta';
            $table3 = 'diklat_p4_peserta';
            $table4 = 'diklat_p3_peserta';
            $table5 = 'diklat_p2_peserta';
        break;
        default :
            $layanan = '';
            $table = '';
        break;
    }

    $x = 0;
?>


    @if($jnslayanan == '1')
    <!--efasilitasi-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
            <tr>
                <td align="center" width="2%">No.</td>
                <td align="center">NIP <br> Nama Lengkap</td>
                <td align="center" width="20%">Unit Kerja</td>
                <td align="center">Jenis Layanan</td>
                <td align="center">Tanggal Usul</td>
                <td align="center" colspan="2">Tanggal Kartu</td>
            </tr>
        </thead>
        <tbody>
        <?php
            $rs = \DB::connection('mysql2')->table('fasilitas_usul')
                ->leftjoin('fasilitas_jenis', 'fasilitas_usul.idfasilitas', '=', 'fasilitas_jenis.idfasilitas')
                ->select('nip', 'idskpd', 'keterangan', 'status', 'proses', 'tmstamp', 'jnsfasilitas', 'tgusul', 'tgl_kartubaru', 'tmtusul')
                ->where('nip', $nip)
                ->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jnsfasilitas}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tgusul))}}</td>
                    <td colspan="2" align="center">{{($item->tgl_kartubaru!='0000-00-00')?date('d-m-Y', strtotime($item->tgl_kartubaru)):'-'}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Response</td>
                    <td class="text-center">Tanggal Disetujui</td>
                    <td class="text-center">Sts Usul</td>
                    <td class="text-center">Sts Fasilitas</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                        if($item->status==1){
                            if($item->proses=='1'){
                                echo '<div class="control-group">
                                            <label class="control-label">Status Berkas</label>
                                            <div class="controls">
                                                <span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/></span> Sedang diproses
                                            </div>
                                        </div>';
                            }else if($item->proses=='2'){
                                echo '<div class="control-group">
                                            <label class="control-label">Status Berkas</label>
                                            <div class="controls">
                                                <span style="color:blue"><span class="fa fa-arrow-circle-o-up" title="Pengiriman berkas"/></span> Pengiriman berkas
                                            </div>
                                        </div>';
                            }else if($item->proses=='3'){
                                echo '<div class="control-group">
                                            <label class="control-label">Status Berkas</label>
                                            <div class="controls">
                                                <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span> Selesai diproses
                                            </div>
                                        </div>';
                            }
                        } else if($item->status==2){
                            echo '<div class="control-group">
                                        <label class="control-label">Keterangan</label>
                                        <div class="controls">
                                            <span style="color:red"><span class="glyphicon glyphicon-remove-circle"/></span> '.$item->keterangan.'
                                        </div>
                                    </div>';
                        }else if($item->status==3){
                            echo '<div class="control-group">
                                        <label class="control-label">Keterangan</label>
                                        <div class="controls">
                                            <span style="color:orange"><span class="glyphicon glyphicon-info-sign"/></span> '.$item->keterangan.'
                                        </div>
                                    </div>';
                        }
                        ?>

                    </td>
                    <td class="text-center">{{($item->tmtusul!='0000-00-00')?date('d-m-Y', strtotime($item->tmtusul)):'-'}}</td>
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
                        if($item->proses=='1'){
                            echo '<span style="color:orange"><span class="glyphicon glyphicon-time" title="Sedang diproses"/><span>';
                        }else if($item->proses=='2'){
                            echo '<span style="color:blue"><span class="fa fa-arrow-circle-o-up" title="Pengiriman berkas"/></span>';
                        }else if($item->proses=='3'){
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
        <?php $rs = \DB::connection('mysql2')->table($table)->where('nip', $nip)->get(); ?>
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
                                        <label class="control-label">Status SPT</label>
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
    @elseif($jnslayanan == '3')
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
    @elseif($jnslayanan == '4')
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
            $rs1 = \DB::connection('mysql2')->table($table1)->select('nip', \DB::raw("IF(nip!='','Mutasi Dalam OPD','-') AS jnsmutasi"), 'idskpd', 'tglusul', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'created_at', 'iscetaksk', 'nip as nama')->where('nip', $nip);
            /*mutasi_dalam_daerah*/
            $rs2 = \DB::connection('mysql2')->table($table2)->select('nip', \DB::raw("IF(nip!='','Mutasi Dalam Daerah','-') AS jnsmutasi"), 'idskpd', 'tglusul', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'created_at', 'iscetaksk', 'nip as nama')->where('nip', $nip);
            /*mutasi_luar_daerah*/
            $rs3 = \DB::connection('mysql2')->table($table3)->select('nip', \DB::raw("IF(nip!='','Mutasi Luar Daerah','-') AS jnsmutasi"), 'idskpd', 'tglusul', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'created_at', 'iscetaksk', 'nip as nama')->where('nip', $nip);
            /*mutasi_masuk_daerah*/
            $rs4 = \DB::connection('mysql2')->table($table4)->select('nip', \DB::raw("IF(nip!='','Mutasi Masuk Daerah','-') AS jnsmutasi"),  \DB::raw("idskpdbaru AS idskpd"), 'tglusul', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'created_at', 'iscetaksk', 'nama')->where('nip', $nip);
            $rs = $rs1->union($rs2)->union($rs3)->union($rs4)->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >
                        {{$item->nip}} <br> 
                        @if(count($row) > 0)
                            {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}
                        @else
                            {{$item->nama}}
                        @endif
                    </td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jnsmutasi}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tglusul))}}</td>
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
                                            <label class="control-label">Status SPT</label>
                                            <div class="controls">
                                                <span style="color:#ffcc00"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                            </div>
                                        </div>';
                                    }else if($item->iscetaksk == 2){
                                        echo '<div class="control-group">
                                            <label class="control-label">Status SPT</label>
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
    @elseif($jnslayanan == '5')
    <!--Jabatan Pegawai-->
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
            $rs1 = \DB::connection('mysql2')->table($table1)->select('nip', \DB::raw("IF(nip!='','Pengangkatan Jabatan Fungsional','-') AS jnsjabfung"), 'nip', 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tglusul', 'iscetaksk')->where('nip', $nip);
            /*mutasi_dalam_daerah*/
            $rs2 = \DB::connection('mysql2')->table($table2)->select('nip', \DB::raw("IF(nip!='','Kenaikan Jabatan Fungsional','-') AS jnsjabfung"), 'nip', 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tglusul', 'iscetaksk')->where('nip', $nip);
            /*mutasi_luar_daerah*/
            $rs3 = \DB::connection('mysql2')->table($table3)->select('nip', \DB::raw("IF(nip!='','Pengangkatan Jabatan Struktural','-') AS jnsjabfung"), 'nip', 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tglusul', 'iscetaksk')->where('nip', $nip);
            /*mutasi_masuk_daerah*/
            $rs4 = \DB::connection('mysql2')->table($table4)->select('nip', \DB::raw("IF(nip!='','Pengangkatan Jabatan Kepala Sekolah','-') AS jnsjabfung"), 'nip', 'idskpd', 'kettms', 'ketbtl', 'tmt', 'tglsurat', 'statususul', 'statussk', 'tglusul', 'iscetaksk')->where('nip', $nip);
            $rs = $rs1->union($rs2)->union($rs3)->union($rs4)->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jnsjabfung}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tglusul))}}</td>
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
                                        <label class="control-label">Status SPT</label>
                                        <div class="controls">
                                            <span style="color:#ffcc00"><span class="glyphicon glyphicon-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK
                                        </div>
                                    </div>';
                                }else if($item->iscetaksk == 2){
                                    echo '<div class="control-group">
                                        <label class="control-label">Status SPT</label>
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
    @elseif($jnslayanan == '6')
    <!--Hukum Dispilin-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
        <tr>
            <td align="center" width="2%">No.</td>
            <td align="center">NIP <br> Nama Lengkap</td>
            <td align="center" width="20%">Unit Kerja</td>
            <td align="center">Jenis Hukuman</td>
            <td align="center">Tanggal Usul</td>
            <td align="center" colspan="2">TMT Surat</td>
        </tr>
        </thead>
        <tbody>
        <?php
            $rs = \DB::connection('mysql2')->table('tb_hudis')
                ->leftjoin('mast_hudis', 'tb_hudis.jenis_hudis', '=', 'mast_hudis.id')
                ->select('nip', 'nip', 'idskpd', 'tgusul', 'no_sk', 'tgl_sk', 'jenis_hudis', 'mast_hudis.nama_hudis')
                ->where('nip', $nip)
                ->get();
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->nama_hudis}}</td>
                    <td align="center">{{date('d-m-Y', strtotime($item->tgusul))}}</td>
                    <td colspan="2" align="center">{{(date('d-m-Y', strtotime($item->tgl_sk))!='01-01-1970')?date('d-m-Y', strtotime($item->tgl_sk)):'-'}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Response</td>
                    <td class="text-center">Tanggal Surat</td>
                    <td class="text-center" colspan="2">Sts Usul</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                        if($item->no_sk!=''){
                            echo '<div class="control-group">
                                <label class="control-label">Status Berkas</label>
                                <div class="controls">
                                    <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai diproses"/></span> Selesai diproses
                                </div>
                            </div>';
                        } else if($item->no_sk==''){
                            echo '<div class="control-group">
                                <label class="control-label">Status Berkas</label>
                                <div class="controls">
                                    <span style="color:orange"><span class="glyphicon glyphicon-ok-circle" title="Sedang diproses"/></span> Sedang Diproses
                                </div>
                            </div>';
                        }else {
                            echo '<div class="control-group">
                                <label class="control-label">Status Berkas</label>
                                <div class="controls">
                                    -
                                </div>
                            </div>';
                        }
                        ?>
                    </td>
                    <td class="text-center">{{(date('d-m-Y', strtotime($item->tgl_sk)) != '01-01-1970')?date('d-m-Y', strtotime($item->tgl_sk)):'-'}}</td>
                    <td class="text-center">
                        <?php
                            if($item->no_sk!=''){
                                echo '<span style="color:orange"><i class="glyphicon glyphicon-time" title="Sedang diproses"/><i>';
                            }else if($item->no_sk==''){
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
    @elseif($jnslayanan == '7')
    <!--Diklat Pegawai-->
    <table class="table table-striped table-hover table-condensed table-bordered sortable">
        <thead class="bg-primary">
        <tr>
            <td align="center" width="2%">No.</td>
            <td align="center">NIP <br> Nama Lengkap</td>
            <td align="center" width="20%">Unit Kerja</td>
            <td align="center">Jenis Diklat</td>
            <td align="center" colspan="2">Tanggal Usul</td>
        </tr>
        </thead>
        <tbody>
        <?php
            /*mutasi_dalam_skpd*/
            $rs1 = \DB::connection('mysql2')->table($table1)->select('nip', \DB::raw("IF(nip!='','Diklat Prajab','-') AS jnsdiklat"), 'nip','idskpd','tgusul','lulus','no_sttl','tgl_sttl','diklatselesai')->where('nip', $nip);
            /*mutasi_dalam_daerah*/
            $rs2 = \DB::connection('mysql2')->table($table2)->select('nip', \DB::raw("IF(nip!='','Diklat Teknis/Fungsional','-') AS jnsdiklat"), 'nip','idskpd','tgusul',\DB::raw("IF(nip!='','Lulus','-') AS lulus"),'no_sttl','tgl_sttl','diklatselesai')->where('nip', $nip);
            /*mutasi_luar_daerah*/
            $rs3 = \DB::connection('mysql2')->table($table3)->select('nip', \DB::raw("IF(nip!='','Diklat PIM 4','-') AS jnsdiklat"), 'nip','idskpd','tgusul','lulus','no_sttl','tgl_sttl','diklatselesai')->where('nip', $nip);
            /*mutasi_masuk_daerah*/
            $rs4 = \DB::connection('mysql2')->table($table4)->select('nip', \DB::raw("IF(nip!='','Diklat PIM 3','-') AS jnsdiklat"), 'nip','idskpd','tgusul','lulus','no_sttl','tgl_sttl','diklatselesai')->where('nip', $nip);
            /*mutasi_masuk_daerah*/
            $rs5 = \DB::connection('mysql2')->table($table5)->select('nip', \DB::raw("IF(nip!='','Diklat PIM 2','-') AS jnsdiklat"), 'nip','idskpd','tgusul','lulus','no_sttl','tgl_sttl','diklatselesai')->where('nip', $nip);

            $rs = $rs1->union($rs2)->union($rs3)->union($rs4)->union($rs5)->get();
        ?>
        @if(count($rs) >0)
            @foreach($rs as $item)
                <?php $row = getPegawai($item->nip); $x++;?>
                <tr>
                    <td rowspan="3" align="center" width="2%">{{$x}}</td>
                    <td >{{$item->nip}} <br> {{(($row->gdp!='')?$row->gdp.'. ':'').''.$row->nama.''.(($row->gdb!='')?', '.$row->gdb:'')}}</td>
                    <td  width="20%">{{ucfirsts(getNameskpd($item->idskpd))}}</td>
                    <td >{{$item->jnsdiklat}}</td>
                    <td colspan="2" align="center">{{date('d-m-Y', strtotime($item->tgusul))}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Status Diklat</td>
                    <td class="text-center">Tgl Serfifikat</td>
                    <td class="text-center">No. Sertifikat</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                        if($item->lulus != 'Lulus'){
                            if($item->diklatselesai =='1'){
                                echo '<div class="control-group">
                                        <div class="controls">
                                            <span style="color:green"><span class="glyphicon glyphicon-ok-circle" title="Selesai Diklat"/></span> Selesai Diklat
                                        </div>
                                    </div>';
                            }else {
                                echo '<div class="control-group">
                                        <div class="controls">
                                            <span style="color:orange"><span class="glyphicon glyphicon-time" title="Masih Proses"/></span> Masih Proses
                                        </div>
                                    </div>';
                            }
                        }else{
                            echo "<div align='center'>-</div>";
                        }
                        ?>
                    </td>
                    <td class="text-center">{{(date('d-m-Y', strtotime($item->tgl_sttl))!='01-01-1970')?date('d-m-Y', strtotime($item->tgl_sttl)):'-'}}</td>
                    <td class="text-center">{{($item->no_sttl!='')?$item->no_sttl:'-'}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">Data tidak ditemukan.</td>
            </tr>
        @endif
        </tbody>
    </table>
    @endif
