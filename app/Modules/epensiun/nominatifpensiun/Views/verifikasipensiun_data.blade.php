<?php

    if((session('role_id') < 3) or ((session('role_id') == 4))){

        \DB::table('tr_kgb')->where(array('nip'=>Input::get('nip')))->update(array('viewver'=>1));

    }else{

        \DB::table('tr_kgb')->where(array('nip'=>Input::get('nip')))->update(array('viewuser'=>1));

    }

?>



<form id="form-verifikasi" class="form-horizontal" method="POST" action="{!!url()!!}/epensiun/nominatifpensiun/verifikasipensiun" accept-charset="UTF-8">



<div class="row">

    <div class="col-md-12">

        <div class="box box-warning">

            <div class="col-md-6">

                <div class="box-header">

                    <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA </h3>

                </div>

                <div class="box-body">

                    <div class="col-md-12 data-biodata">

                        {!!csrf_field()!!}

                        <!-- <input type="hidden" name="idkgb" id="idkgb" value="{!!Input::get('idkgb')!!}"> -->

                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">

                        <input type="hidden" name="idskpd" id="idskpd" class="idskpd">

                        <!-- <input type="hidden" name="jnskgb" id="jnskgb" class="jnskgb"> -->

                        <!-- <input type="hidden" name="golpnsskr" id="golpnsskr" class="golpnsskr"> -->

                        <div class="form-group">

                            <label class="col-sm-3 control-label">NIP </label>

                            <div class="col-sm-7">

                                <span id="attr-nip"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Nama </label>

                            <div class="col-sm-7">

                                <span id="attr-nama"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Tempat Tanggal Lahir </label>

                            <div class="col-sm-7">

                                <span id="attr-ttl"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Golongan - TMT </label>

                            <div class="col-sm-7">

                                <span id="attr-goltmt"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Eselon - TMT </label>

                            <div class="col-sm-7">

                                <span id="attr-esltmt"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Jabatan / Unit Kerja </label>

                            <div class="col-sm-7">

                                <span id="attr-jskpd"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Masa Kerja </label>

                            <div class="col-sm-7">

                                <span id="attr-mkerja"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Pendidikan Terakhir </label>

                            <div class="col-sm-7">

                                <span id="attr-pendidikan"></span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Usia </label>

                            <div class="col-sm-7">

                                <span id="attr-usia"></span>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor Rekening </label>
                            <div class="col-sm-7">
                                <span id="attr-usia"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor HP </label>
                            <div class="col-sm-7">
                                <span id="attr-hp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPWP </label>
                            <div class="col-sm-7">
                                <span id="attr-nonpwp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIK </label>
                            <div class="col-sm-7">
                                <span id="attr-noktp"></span>
                            </div>
                        </div>

                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="5%">a. </td>
                            <td width="30%">Keterangan Istri</td>
                            <td width="5%">:</td>
                            <td width="55%">&nbsp</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="5%">No</th>
                                            <th width="35%">Nama</th>
                                            <th width="35%">Tempat/Tanggal Lahir</th>
                                            <th width="25%">Tanggal Nikah</th>
                                            <th width="10%">Suami/Istri Ke</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rissu">
                                        <tr>
                                            <td colspan="4">Data tidak ditemukan, Mohon cek riwayat suami / istri pada E-Personal</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="5%">b. </td>
                            <td width="25%">Anak - anak</td>
                            <td width="5%">:</td>
                            <td width="55%">&nbsp</td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="5%">No</th>
                                            <th width="35%">Nama</th>
                                            <th width="35%">Tempat/Tanggal Lahir</th>
                                            <th width="25%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tbody class="ranak">
                                            <td colspan="4">Data tidak ditemukan, Mohon cek riwayat anak pada E-Personal</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="5%">No</th>
                                            <th width="35%">Dokumen Persyaratan</th>
                                            <th width="10%">Jumlah</th>
                                            <th width="10%">Preview</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_dokumenpersyaratan">
                                    </tbody>
                                </table>
                                <a id="download_zip"></a>
                            </td>
                        </tr>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="box-header">

                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> ATTRIBUT PENSIUN </h3>

                </div>
                @if(session('role_id') < 3)
                <div class="box-body">

                    <div class="col-md-12 data-attribut">                        
                            
                        <!-- <div class="form-group">

                            <label class="col-sm-3 control-label" for="tmtpens">TMT pensiun</label>

                            <div class="controls col-sm-7">

                                <input name="tmtpens" value="" id="tmtpens" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>

                        </div>  -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpkt">Masa Kerja Golongan</label>
                            <div class="col-sm-2">
                                <input name="mkthnpkt" value="" id="mkthnpkt" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpkt" value="" id="mkblnpkt" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpens">Masa Kerja Pensiun</label>
                            <div class="col-sm-2">
                                <input name="mkthnpens" value="" id="mkthnpens" class="form-control" maxlength="2" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpens" value="" id="mkblnpens" class="form-control" maxlength="2" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpnspens">Masa Kerja Sebelum Masuk PNS</label>
                            <div class="col-sm-2">
                                <input name="mkthnpnspens" value="" id="mkthnpnspens" class="form-control" maxlength="2" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpnspens" value="" id="mkblnpnspens" class="form-control" maxlength="2" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmtcpn">Mulai Masuk PNS</label>
                            <div class="controls col-sm-7">
                                <input name="tmtcpn" value="" id="tmtcpn" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>
                        </div>

                        <tr>
                            <h5 width="25%">ALAMAT SEKARANG</h5>
                            &nbsp;
                            <!-- <th>KGB LAMA</th>
                            <th>KGB BARU</th> -->
                        </tr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="alm" value="" id="alm" maxlength="10" class="form-control" placeholder="Jalan" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrt" value="" id="almrt" class="form-control" maxlength="2" type="text">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrw" value="" id="almrw" class="form-control" maxlength="2" type="text">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesa" value="" id="almdesa" maxlength="10" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkec" value="" id="almkec" maxlength="10" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkab" value="" id="almkab" maxlength="10" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almprov">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprov" value="" id="almprov" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <tr>
                            <h5 width="25%">ALAMAT SETELAH PENSIUN</h5>
                            &nbsp;
                            <!-- <th>KGB LAMA</th>
                            <th>KGB BARU</th> -->
                        </tr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="almpens" value="" id="almpens" maxlength="255" class="form-control" placeholder="Jalan" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrtpens" value="" id="almrtpens" class="form-control" maxlength="3" type="text" placeholder="00">
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrwpens" value="" id="almrwpens" class="form-control" maxlength="3" type="text" placeholder="00">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesapens" value="" id="almdesapens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkecpens" value="" id="almkecpens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkabpens" value="" id="almkabpens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprovpens" value="" id="almprovpens" maxlength="100" class="form-control" placeholder="" type="text">
                            </div>
                        </div>

                    </div>

                </div>
                @else
                <div class="box-body">

                    <div class="col-md-12 data-attribut">                        
                            
                        <!-- <div class="form-group">

                            <label class="col-sm-3 control-label" for="tmtpens">TMT pensiun</label>

                            <div class="controls col-sm-7">

                                <input name="tmtpens" value="" id="tmtpens" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                            </div>

                        </div>  -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpkt">Masa Kerja Golongan</label>
                            <div class="col-sm-2">
                                <input name="mkthnpkt" value="" id="mkthnpkt" class="form-control" maxlength="2" type="text" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpkt" value="" id="mkblnpkt" class="form-control" maxlength="2" type="text" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpens">Masa Kerja Pensiun</label>
                            <div class="col-sm-2">
                                <input name="mkthnpens" value="" id="mkthnpens" class="form-control" maxlength="2" type="text" placeholder="00" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpens" value="" id="mkblnpens" class="form-control" maxlength="2" type="text" placeholder="00" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="mkthnpnspens">Masa Kerja Sebelum Masuk PNS</label>
                            <div class="col-sm-2">
                                <input name="mkthnpnspens" value="" id="mkthnpnspens" class="form-control" maxlength="2" type="text" placeholder="00" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Tahun
                            </div>
                            <div class="col-sm-2">
                                <input name="mkblnpnspens" value="" id="mkblnpnspens" class="form-control" maxlength="2" type="text" placeholder="00" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                Bulan
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tmtcpn">Mulai Masuk PNS</label>
                            <div class="controls col-sm-7">
                                <input name="tmtcpn" value="" id="tmtcpn" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text" readonly>
                            </div>
                        </div>

                        <tr>
                            <h5 width="25%">ALAMAT SEKARANG</h5>
                            &nbsp;
                            <!-- <th>KGB LAMA</th>
                            <th>KGB BARU</th> -->
                        </tr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="alm" value="" id="alm" maxlength="10" class="form-control" placeholder="Jalan" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrt" value="" id="almrt" class="form-control" maxlength="2" type="text" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrw" value="" id="almrw" class="form-control" maxlength="2" type="text" readonly>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesa" value="" id="almdesa" maxlength="10" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkec" value="" id="almkec" maxlength="10" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkab" value="" id="almkab" maxlength="10" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almprov">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprov" value="" id="almprov" maxlength="100" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <tr>
                            <h5 width="25%">ALAMAT SETELAH PENSIUN</h5>
                            &nbsp;
                            <!-- <th>KGB LAMA</th>
                            <th>KGB BARU</th> -->
                        </tr>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="alm">Jalan</label>
                            <div class="controls col-sm-7">
                                <input name="almpens" value="" id="almpens" maxlength="255" class="form-control" placeholder="Jalan" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almrt">RT / RW</label>
                            <div class="col-sm-2">
                                <input name="almrtpens" value="" id="almrtpens" class="form-control" maxlength="3" type="text" placeholder="00" readonly>
                            </div>
                            <div class="col-sm-1" style="margin-top: 7px;">
                                /
                            </div>
                            <div class="col-sm-2">
                                <input name="almrwpens" value="" id="almrwpens" class="form-control" maxlength="3" type="text" placeholder="00" readonly>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almdesa">Kelurahan</label>
                            <div class="controls col-sm-7">
                                <input name="almdesapens" value="" id="almdesapens" maxlength="100" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkec">Kecamatan</label>
                            <div class="controls col-sm-7">
                                <input name="almkecpens" value="" id="almkecpens" maxlength="100" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Kabupaten / Kota</label>
                            <div class="controls col-sm-7">
                                <input name="almkabpens" value="" id="almkabpens" maxlength="100" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="almkab">Provinsi</label>
                            <div class="controls col-sm-7">
                                <input name="almprovpens" value="" id="almprovpens" maxlength="100" class="form-control" placeholder="" type="text" readonly>
                            </div>
                        </div>

                    </div>

                </div>
                @endif


                <div class="box-header">

                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAPAN PENSIUN </h3>

                </div>

                <div class="box-body">

                    <div class="data-penetap">

                        @if((session('role_id') < 3) or ((session('role_id') == 4)))
                        @if(session('role_id') < 3)
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Berkas</label>
                            <div class="controls col-sm-7">
                                <select id="statususul" name="statususul" class="form-control">
                                    <option value="">.: Status Usulan :.</option>
                                    <option value="1">Memenuhi Syarat</option>
                                    <option value="2">Tidak Memenuhi Syarat</option>
                                    <option value="3">Berkas Tidak Lengkap</option>
                                </select>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Berkas</label>
                            <div class="controls col-sm-7">
                                <select id="statususul" name="statususul" class="form-control" disabled>
                                    <option value="">.: Status Usulan :.</option>
                                    <option value="1">Memenuhi Syarat</option>
                                    <option value="2">Tidak Memenuhi Syarat</option>
                                    <option value="3">Berkas Tidak Lengkap</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        @if(session('role_id') < 3)
                        <div id="ftampil2">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="kettms" id="kettms" class="form-control" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="ftampil2">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="kettms" id="kettms" class="form-control" placeholder="Keterangan Jika Tidak Memenuhi Syarat" readonly></textarea>

                                </div>
                            </div>
                        </div>
                        @endif


                        @if(session('role_id') < 3)
                        <div id="ftampil3">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="ketbtl" id="ketbtl" class="form-control" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="ftampil3">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="controls col-sm-7">
                                    <textarea rows="5" cols="6" name="ketbtl" id="ketbtl" class="form-control" placeholder="Keterangan Jika Berkas Tidak Lengkap" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        @endif


                        @if(session('role_id') < 3)
                        <div id="ftampil1">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status Proses</label>
                                <div class="controls col-sm-7">
                                    <select id="statussk" name="statussk" class="form-control" required>
                                        <option value="2">Dalam Proses</option>
                                        <option value="1">Berkas Lengkap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="ftampil1">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status Proses</label>
                                <div class="controls col-sm-7">
                                    <select id="statussk" name="statussk" class="form-control" required disabled>
                                        <option value="2">Dalam Proses</option>
                                        <option value="1">Berkas Lengkap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('role_id') < 3)
                        <div id="ftampil11">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="noskpens">No. SK Pensiun</label>
                                <div class="controls col-sm-7">                                      
                                        <input name="noskpens" id="noskpens" maxlength="45" class="form-control" type="text" placeholder="No. SK Pensiun">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tgskpens">Tanggal SK Pensiun</label>
                                <div class="controls col-sm-7">
                                    <input name="tgskpens" value="" id="tgskpens" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jabatan Penetap</label>
                                <div class="controls col-sm-7">
                                    {!! comboPenetapsk("idpejabpens","","") !!}
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="ftampil11">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="noskpens">No. SK Pensiun</label>
                                <div class="controls col-sm-7">                                      
                                    <input name="noskpens" id="noskpens" maxlength="45" class="form-control" type="text" placeholder="No. SK Pensiun" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tgskpens">Tanggal SK Pensiun</label>
                                <div class="controls col-sm-7">
                                    <input name="tgskpens" value="" id="tgskpens" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jabatan Penetap</label>
                                <div class="controls col-sm-7">
                                    {!! comboPenetapskDis("idpejabpens","","") !!}
                                </div>
                            </div>
                        </div>
                        @endif


                        <div id='ftampil12'>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Status SK</label>

                                <div class="controls col-sm-7">

                                    <label class="radio" style="padding-left: 15px">

                                        <input name="iscetaksk" id="iscetaksk0" value="0" type="radio"> Belum Cetak SK

                                    </label>

                                    <label class="radio" style="padding-left: 15px">

                                        <input name="iscetaksk" id="iscetaksk1" value="1" type="radio"> Sudah Cetak SK

                                    </label>

                                    <label class="radio" style="padding-left: 15px">

                                        <input name="iscetaksk" id="iscetaksk2" value="2" type="radio"> Pembatalan SK

                                    </label>

                                </div>

                            </div>

                        </div>


                        @if(session('role_id') < 3)
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @else                        

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Status Proses</label>

                            <div class="controls col-sm-7">

                                <?php

                                    $item = \DB::table('tr_pensiun')->where('nip',Input::get('nip'))->first();



                                    if($item->statususul==1){

                                        echo '<span style="color:green"><i class="fa fa-check-circle"/></span> Memenuhi Syarat';

                                    }else if($item->statususul==2){

                                        echo '<span style="color:red"><i class="fa fa-times-circle"/></span> Tidak Memenuhi Syarat';

                                    }else if($item->statususul==3){

                                        echo '<span style="color:orange"><i class="fa fa-info-circle"/></span> Berkas Tidak Lengkap';

                                    }else{

                                        echo 'Belum ada tanggapan.';

                                    }

                                ?>

                            </div>

                        </div>

                        <?php

                            if($item->statususul==1){

                                if($item->statususul=='1' && $item->statussk=='2'){

                                    echo '<div class="form-group">

                                            <label class="col-sm-3 control-label">Status Berkas</label>

                                            <div class="controls col-sm-7">

                                                <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses

                                            </div>

                                        </div>';

                                }else if($item->statussk=='1'){

                                    echo '<div class="form-group">

                                            <label class="col-sm-3 control-label">Status Berkas</label>

                                            <div class="controls col-sm-7">

                                                <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses

                                            </div>

                                        </div>';

                                

                                        if($item->iscetaksk == 1){

                                            echo '<div class="form-group">

                                                    <label class="col-sm-3 control-label">Status SKsss</label>

                                                    <div class="controls col-sm-7">

                                                        <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK

                                                    </div>

                                                </div>';

                                        }else if($item->iscetaksk == 2){

                                            echo '<div class="form-group">

                                                    <label class="col-sm-3 control-label">Status SK</label>

                                                    <div class="controls col-sm-7">

                                                        <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak SK"/></span> SK Dibatalkan

                                                    </div>

                                                </div>';

                                        }

                                }

                            } else if($item->statususul==2){

                                echo '<div class="form-group">

                                    <label class="col-sm-3 control-label">Keterangan</label>

                                    <div class="controls col-sm-7">

                                        <span style="color:red"><i class="fa fa-times-circle"/></span> '.$item->kettms.'

                                    </div>

                                </div>';

                            }else if($item->statususul==3){

                                echo '<div class="form-group">

                                    <label class="col-sm-3 control-label">Keterangan</label>

                                    <div class="controls col-sm-7">

                                        <span style="color:orange"><i class="fa fa-info-circle"/></span> '.$item->ketbtl.'

                                    </div>

                                </div>';

                            }

                        ?>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



</form>



<style type="text/css">

    .data-awal .form-control{

        height: auto;

        background-color: #ececec;

    }



    .alert-dangers{

        border: 2px solid red;

    }



    .modal {

        overflow: auto !important;

    }

</style>



<script type="text/javascript">
    function clickModal(jenis,subjenis,syarat,nip){
            claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epensiun/nominatifpensiun/data/prefile',
                data: {'nip': nip, 'jenis': jenis, 'subjenis': subjenis, 'syarat': syarat, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        }

        function getDokumenPersyaratan(response,nip,nama,folderName){
            var html = "";
            var x = 1;
            if(response.length > 0){
                response.forEach(item => {
                    if (typeof item.jmlfile !== 'undefined') {
                    html += `
                    <tr>
                        <td width="5%" class="text-center">${x++}</td>
                        <td width="35%">${item.syarat}</td>
                        <td width="10%" class="text-center">${item.jmlfile}</td>
                        <td width="10%" class="text-center"><a href="javascript:void(0)" class="prefile btn btn-success" onclick="clickModal('${item.jenis}','${item.subjenis}','${item.syarat}','${nip}')"><i class="fa fa-search"></i> Preview</a></td>
                    </tr>
                    `;
                    }else{
                        html += `
                        <tr>
                            <td width="5%" class="text-center">${x++}</td>
                            <td width="35%" colspan="2">${item.syarat}</td>
                            <td width="10%" class="text-center"><a href="javascript:void(0)" class="btn btn-default" onclick="bootbox.alert('Data belum tersedia.');"><i class="fa fa-search"></i> Preview</a></td>
                        </tr>
                        `;
                    }
                })
            }else{
                html = `<tr>
                <td colspan="4">Data tidak ditemukan.</td>
                </tr>`
            }

            $("#tb_dokumenpersyaratan").html(html);
            var hostname = "https://simpeg.kendalkab.go.id/efile/"
            // var hostname = "http://localhost:8001/"

            var rtr = response.filter(item => item.jmlfile < 1 ? false : true)
console.log(rtr);
            $("#download_zip").attr("href",`${hostname}jadikanzip?nip=${nip}&pegawai=${nama}&nama_folder=${folderName}&data=${JSON.stringify(rtr)}`)
            .attr("target","_blank")
            .attr("class","btn btn-primary float-right")
            .html("Download Zip")

        }
    $(document).ready(function(){

        $('.tmt, .date').mask("99-99-9999");
        $('select').select2();
        
        /*$('#statususul').on('change', function () {
            if($('#statususul').val() == 1){
            //     console.log('yes');
                //attrpengantar
                $.ajax({
                    url:'{!!url()!!}/epensiun/nominatifpensiun/attrpengantar',
                    data: {'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
                    type:'post',
                        success:function(response){

                        var ret = $.parseJSON(response);
                        // console.log(ret);
                        $('.data-penetap #pejpenpens').val(ret.nama);
                        $('.data-penetap #nippenpens').val(ret.nip);
                        $('.data-penetap #golrupenpens').val(ret.pangkat);
                        $('.data-penetap #jabpenpens').val(ret.jab);
                        // $('.data-penetap #idpejabpens').select2("val", ret.idpejab);
                        $('.data-penetap #idpejabpens').val(ret.jab);
                        
                        }
                });
            }            
        });*/

       
       

        $.ajax({

            url:'{!!url()!!}/epensiun/nominatifpensiun/editpensiun',
            
            data: {'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            // data: {'nip':"198305152011011014", '_token' : '{!!csrf_token()!!}'},

            type:'post',

            success:function(response){

                var reb = $.parseJSON(response);
                var ret = reb.data1;

                getDokumenPersyaratan(reb.data2,ret.nip,ret.nama,reb.folder);
               
                $('.data-penetap #noskpens').val(ret.noskpensiun);
                <?php if(session('role_id') < 3){?>
                $('.data-penetap input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);
                <?php }else{ ?>
                $('.data-penetap input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);
                $(':radio:not(:checked)').attr('disabled', true);
                <?php } ?>


            <?php if((session('role_id') < 3) or ((session('role_id') == 4))){?>

                //$('.data-penetap #idpejab').val(ret.idpejab);
                // $('.data-penetap #idpejabpens').select2("val", ret.idpejabpens);
                $('.data-penetap #idpejabpens').val(ret.jab);

                if(ret.statususul == 0){

                    //$('.data-penetap #statususul').val('');
                    $('.data-penetap #statususul').select2("val", '');

                }else{

                    //$('.data-penetap #statususul').val(ret.statususul);
                    $('.data-penetap #statususul').select2("val", ret.statususul);

                }

                if(ret.statussk == 0){

                    //$('.data-penetap #statussk').val(2);
                    $('.data-penetap #statussk').select2("val", 2);

                }else{

                    //$('.data-penetap #statussk').val(ret.statussk);
                    $('.data-penetap #statussk').select2("val", ret.statussk);

                }

            <?php } ?>

                $('.data-penetap #kettms').val(ret.kettms);

                $('.data-penetap #ketbtl').val(ret.ketbtl);

                if(ret.tgskpens_ != '00-00-0000') {

                    $('.data-penetap #tgskpens').val(ret.tgskpens_);

                }else{

                    $('.data-penetap #tgskpens').val("{!!date('d-m-Y')!!}");

                }

                $('.data-penetap #statususul').trigger('change');

                $('.data-penetap #statussk').trigger('change'); 


                $('.data-biodata #attr-nip').html(ret.nip);

                $('.data-biodata #idskpd').val(ret.idskpd);
    

                $('.data-biodata #attr-nama').html(ret.nama);

                $('.data-biodata #attr-ttl').html(ret.tmlhr+','+ret.tgllahir_);

                $('.data-biodata #attr-goltmt').html(ret.golpns_txt+' , '+ret.tmtgollama_);

                $('.data-biodata #attr-esltmt').html(ret.esl+' , '+ret.tmteselon_);

                $('.data-biodata #attr-jskpd').html(ret.jabatan+' '+ret.skpd);

                $('.data-biodata #attr-mkerja').html(ret.mkskr.substr(0,2)+' tahun '+ret.mkskr.substr(-2)+' bulan');

                $('.data-biodata #attr-pendidikan').html(ret.jenjurusan);

                $('.data-biodata #attr-usia').html(String(ret.usia).substr(0,2)+" tahun "+String(ret.usia).substr(2, 2)+" bulan");
                $('.data-biodata #attr-hp').html(ret.hp);
                $('.data-biodata #attr-nonpwp').html(ret.nonpwp);
                $('.data-biodata #attr-noktp').html(ret.noktp);
             
                 //cek kgb terakhir          
                 var kgbTerakhir = new Date(ret.tmtkgb);
                 var nowDate2 = $.datepicker.formatDate('yy/mm/dd', new Date());          
                var selisih = date_diff_inyear(kgbTerakhir,nowDate2);
                  
                //masa kerja golongan
                if(ret.idgolrucpn <= 14 && ret.idgolrupkt >= 41) {//gol 1 ke 4                  
                        let golpens = parseInt(ret.mkgolthnkgb) + 11 + selisih;
                        $('.data-attribut #mkthnpkt').val(golpens);
                }else if (ret.idgolrucpn <= 14 && ret.idgolrucpn >= 21 && ret.idgolrupkt <= 34) {//gol 1 ke 3                        
                        let golpens = parseInt(ret.mkgolthnkgb) + 11 + selisih;
                        $('.data-attribut #mkthnpkt').val(golpens);
                }else if (ret.idgolrucpn <= 14 && ret.idgolrucpn >= 21 && ret.idgolrupkt <= 24) {//gol 1 ke 2                      
                        let golpens = parseInt(ret.mkgolthnkgb) + 6 + selisih;
                        $('.data-attribut #mkthnpkt').val(golpens);
                }else if (ret.idgolrucpn >= 21 && ret.idgolrucpn <= 24 &&  ret.idgolrupkt >= 41){//gol 2 ke 4        
                        let golpens = parseInt(ret.mkgolthnkgb) + 5 + selisih;
                        $('.data-attribut #mkthnpkt').val(golpens);
                }else {                 
                        let golpens = parseInt(ret.mkgolthnkgb) + selisih;
                        $('.data-attribut #mkthnpkt').val(golpens);
                }          
                //masa kerja golongan bulan
                $('.data-attribut #mkblnpkt').val(ret.mkgolblnkgb);

                //menentukan masa kerja pensiun tahun
                //cek pangkat terakhir          
                 var kgbTerakhir = new Date(ret.tmtpkt);
                 var nowDate2 = $.datepicker.formatDate('yy/mm/dd', new Date());          
                var selisihpangkat = date_diff_inyear(kgbTerakhir,nowDate2);
            //     console.log(selisihpangkat, parseInt(ret.mkthnpkt), selisihpangkat + parseInt(ret.mkthnpkt));

                if(ret.idgolrucpn <= 14 && ret.idgolrupkt >= 41) {//gol 1 ke 4                  
                        let golpens = parseInt(ret.mkthnpkt) + 11 + selisihpangkat;
                        $('.data-attribut #mkthnpens').val(golpens);
                }else if (ret.idgolrucpn <= 14 && ret.idgolrucpn >= 21 && ret.idgolrupkt <= 34) {//gol 1 ke 3                        
                        let golpens = parseInt(ret.mkthnpkt) + 11 + selisihpangkat;
                        $('.data-attribut #mkthnpens').val(golpens);
                }else if (ret.idgolrucpn <= 14 && ret.idgolrucpn >= 21 && ret.idgolrupkt <= 24) {//gol 1 ke 2                      
                        let golpens = parseInt(ret.mkthnpkt) + 6 + selisihpangkat;
                        $('.data-attribut #mkthnpens').val(golpens);
                }else if (ret.idgolrucpn >= 21 && ret.idgolrucpn <= 24 &&  ret.idgolrupkt >= 41){//gol 2 ke 4        
                        let golpens = parseInt(ret.mkthnpkt) + 5 + selisihpangkat;
                        $('.data-attribut #mkthnpens').val(golpens);
                }else {                 
                        let golpens = parseInt(ret.mkthnpkt) + selisihpangkat;
                        $('.data-attribut #mkthnpens').val(golpens);
                }
            //     $('.data-attribut #mkthnpens').val(ret.mkthnpens);
                $('.data-attribut #mkblnpens').val(ret.mkblnpkt);
                $('.data-attribut #mkthnpnspens').val(ret.mkthnpnspens);
                $('.data-attribut #mkblnpnspens').val(ret.mkblnpnspens);
                $('.data-attribut #tmtcpn').val(ret.tmtcpn_);
                $('.data-attribut #alm').val(ret.almskrpens);
                $('.data-attribut #almrt').val(ret.almrtskrpens);
                $('.data-attribut #almrw').val(ret.almrwskrpens);
                $('.data-attribut #almdesa').val(ret.almdesaskrpens);
                $('.data-attribut #almkec').val(ret.almkecskrpens);
                $('.data-attribut #almkab').val(ret.almkabskrpens);
                $('.data-attribut #almprov').val(ret.almprovskrpens);

                $('.data-attribut #almpens').val(ret.almpens);
                $('.data-attribut #almrtpens').val(ret.almrtpens);
                $('.data-attribut #almrwpens').val(ret.almrwpens);
                $('.data-attribut #almdesapens').val(ret.almdesapens);
                $('.data-attribut #almkecpens').val(ret.almkecpens);
                $('.data-attribut #almkabpens').val(ret.almkabpens);
                $('.data-attribut #almprovpens').val(ret.almprovpens);

                $('.data-penetap #idpejabpens').select2("val", ret.idpejabpens);
                $('.data-penetap #jabpenpens').val(ret.jabpenpens);
                $('.data-penetap #nippenpens').val(ret.nippenpens);
                $('.data-penetap #pejpenpens').val(ret.pejpenpens);
                $('.data-penetap #pangkatpenpens').val(ret.pangkatpenpens);
                $('.data-penetap #golrupenpens').val(ret.golrupenpens);

                loadRanak(ret.nip);
                loadRissu(ret.nip);                       

            }

        });



        $('.data-penetap #ftampil1').hide();

        $('.data-penetap #ftampil2').hide();

        $('.data-penetap #ftampil3').hide();

        $('.data-penetap #ftampil11').hide();

        $('.data-penetap #ftampil12').hide();



        $('.data-penetap #statususul').on('change',function(e){

            e.preventDefault();

            if($('.data-penetap #statususul').val() == 1){

                $('.data-penetap #ftampil1').show();

                $('.data-penetap #ftampil2').hide();

                $('.data-penetap #ftampil3').hide();



                $('.data-penetap #statussk').on('change',function(e){

                    e.preventDefault();

                    if($('.data-penetap #statussk').val() == 1){

                        $('.data-penetap #ftampil11').show();

                        $('.data-penetap #ftampil12').show();

                    }else{

                        $('.data-penetap #ftampil11').show();

                        $('.data-penetap #ftampil12').hide();

                    }

                }).trigger('change');

            }else if($('.data-penetap #statususul').val() == 2){

                $('.data-penetap #ftampil1').hide();

                $('.data-penetap #ftampil2').show();

                $('.data-penetap #ftampil3').hide();

                $('.data-penetap #ftampil11').hide();

                $('.data-penetap #ftampil12').hide();

            }else if($('.data-penetap #statususul').val() == 3){

                $('.data-penetap #ftampil1').hide();

                $('.data-penetap #ftampil2').hide();

                $('.data-penetap #ftampil3').show();

                $('.data-penetap #ftampil11').hide();

                $('.data-penetap #ftampil12').hide();

            }else{

                $('.data-penetap #ftampil1').hide();

                $('.data-penetap #ftampil2').hide();

                $('.data-penetap #ftampil3').hide();

                $('.data-penetap #ftampil11').hide();

                $('.data-penetap #ftampil12').hide();

            }

        }).trigger('change');

        $('a.prefile').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epensiun/nominatifpensiun/data/prefile',
                data: {'nip': $(this).attr('recnip'), 'jenis': $(this).attr('recjenis'), 'subjenis': $(this).attr('recsubjenis'), 'syarat': $(this).attr('recsyarat'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });
      
      
        $('#form-verifikasi').on('submit',function(e){

            var $this = $(this);

            e.preventDefault();

            bootbox.confirm('Update Pensiun ?',function(a){

                if (a == true){

                    $.ajax({

                        url : $this.attr('action'),

                        type : 'POST',

                        data : $this.serialize(),

                        beforeSend: function(){

                            preloader.on();

                        },

                        success:function(html){

                            preloader.off();

                            if(html=='4'){

                                notification('Berhasil Disimpan','success');

                                claravel_modal_close('main_modal2');

                                refresh_page();

                            }else{

                                notification(html,'danger');

                            }

                        }

                    });

                }

            });

        });

    });

    function loadRanak(nip){
        if(nip != ''){
            $.ajax({
                type:'post',
                url:'{!!url()!!}/epensiun/nominatifpensiun/data/ranak',
                data:{ 'nip': nip, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('.ranak').html('Looading..');
                },
                success:function(response){
                    $('.ranak').html(response);
                }
            });
        }else{
            $('.ranak').html(response);
        }
    }

    function loadRissu(nip){
        if(nip != ''){
            $.ajax({
                type:'post',
                url:'{!!url()!!}/epensiun/nominatifpensiun/data/rissu',
                data:{ 'nip': nip, '_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    $('.rissu').html('Looading..');
                },
                success:function(response){
                    $('.rissu').html(response);
                }
            });
        }else{
            $('.rissu').html(response);
        }
    }

      function date_diff_inyear(date1, date2) {
            dt1 = new Date(date1);
            dt2 = new Date(date2);
            return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24 * 7 * 4 * 12));
      }

</script>
