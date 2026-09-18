{!!View::make('home::portal.header')!!}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrappers" id='utama' style="padding-top: 50px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            E- Cuti Digital Signature
            <!--<small>Version 2.0</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url()!!}/tracking"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">E-Cuti Digital Signature</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-primary">
            <div class="row">
                <div class="col-md-12">

                    <?php
                    $where = "tr_ijin_cuti.nip = '".$nip."' and tr_ijin_cuti.nousul = '".$nousul."' AND view_kuota_cuti.nousul = \"".$nousul."\" ";

                    $item = \DB::table('tr_ijin_cuti')
                    ->select('tb_01.idgolrupkt','view_kuota_cuti.*','tr_ijin_cuti.*','a_golruang.golru','a_golruang.pangkat')
                    ->leftJoin('view_kuota_cuti', function($join)
                    {
                        $join->on('view_kuota_cuti.nip', '=', 'tr_ijin_cuti.nip');
                    })
                    ->leftjoin('tb_01', 'tr_ijin_cuti.nip', '=', 'tb_01.nip')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->whereRaw($where)
                    ->first();

                    if(count($item) < 0){
                        echo "Data tidak ditemukan.<br><a href='".url()."'>Kembali</a>";
                        exit();
                        
                    }
                    ?>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table-hover table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="24%">NIP</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->nip!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nama</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->nama!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Pangkat / Golongan</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->pangkat!!} / {!!ucword($item->golru)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Jabatan</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->jab)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->skpd)!!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-fw fa-fire"></i> DIGITAL SIGNATURE</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table-hover table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="24%">Jenis Dokumen</td>
                                            <td width="1%">:</td>
                                            <td width="75%">SK Cuti</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Jenis Cuti</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!getJenisCuti($item->id_jenis_cuti)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Tanggal Cuti</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!formatTanggalPanjang($item->tgl_mulai)!!} s/d {!!formatTanggalPanjang($item->tgl_selesai)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Nomor SK</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->nosk_cuti!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Tanggal SK</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!formatTanggalPanjang($item->tglsk_cuti)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Jabatan PYBMC</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->wewenang_jab!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Nama PYBMC</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->wewenang_nama!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">NIP PYBMC</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->wewenang_nip!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Pangkat PYBMC</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!ucword($item->wewenang_pangkat)!!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- ./box-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.box -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

{!!View::make('home::portal.footer')!!}
