{!!View::make('home::portal.header')!!}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrappers" id='utama' style="padding-top: 50px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Digital Signature
            <!--<small>Version 2.0</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url()!!}/tracking"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Digital Signature</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-primary">
            <div class="row">
                <div class="col-md-12">

                    <?php
                    $item = \PenetapannominatifModel::getNominatifver($idkgb, $nip);
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
                                        <td width="24%">Jabatan</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!ucword($item->nmajab)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Pangkat / Golongan</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->golpnsskr_txt!!} / {!!ucword($item->golpns_txt)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Unit Kerja</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!ucword($item->tmpskpdskr)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Sub Unit Kerja</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!ucword($item->namaskpd)!!}</td>
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
                                        <td width="75%">Kenaikan Gaji Berkala</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Nomor SK</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->noskkgbb!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Tanggal SK</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!formatTanggalPanjang($item->tglskkgbb)!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Jabatan Penetap</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->jabpenkgbb!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Nama Penetap</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->pejpenkgbb!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Nip Penetap</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!$item->nippb!!}</td>
                                    </tr>
                                    <tr>
                                        <td width="24%">Pangkat Penetap</td>
                                        <td width="1%">:</td>
                                        <td width="75%">{!!ucword($item->golrupb)!!}</td>
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