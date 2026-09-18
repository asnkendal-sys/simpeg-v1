<?php

    if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4))){

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewver'=>1));

    }else{

        \DB::table('tr_kgb')->where(array('idkgb'=>Input::get('idkgb'),'nip'=>Input::get('nip')))->update(array('viewuser'=>1));

    }

?>



<form id="form-verifikasi" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikangajiberkala/penetapannominatif/verifikasikgb" accept-charset="UTF-8">



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

                        <input type="hidden" name="idkgb" id="idkgb" value="{!!Input::get('idkgb')!!}">

                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">

                        <input type="hidden" name="idskpd" id="idskpd" class="idskpd">

                        <input type="hidden" name="jnskgb" id="jnskgb" class="jnskgb">

                        <input type="hidden" name="golpnsskr" id="golpnsskr" class="golpnsskr">

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
                        <!-- <button class="btn btn-primary">Preview SK</button><br><br> -->
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="5%">No</th>
                                    <th width="35%">Dokumen Persyaratan</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="10%">Preview</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $x = 0;
                                    if(Input::get('idstspeg') == 3){
                                        $rs = callApi('get', 'http://10.5.2.131:2023/efile/dokumenpersyaratan?id=39&nip='.Input::get('nip'));
                                    }else{
                                        $rs = callApi('get', 'http://10.5.2.131:2023/efile/dokumenpersyaratan?id=3&nip='.Input::get('nip'));
                                    }
                                    
                                ?>

                                @if(count($rs) > 0)
                                    @foreach($rs as $item)
                                        <?php $x++;?>
                                        @if(isset($item->jmlfile))
                                        <tr>
                                            <td width="5%" class="text-center">{!!$x!!}</td>
                                            <td width="35%">{!!$item->syarat!!}</td>
                                            <td width="10%" class="text-center">{!!$item->jmlfile!!}</td>
                                            <td width="10%" class="text-center"><a href="javascript:void(0)" class="prefile btn btn-success" recjenis="{!!$item->jenis!!}" recsubjenis="{!!$item->subjenis!!}" recsyarat="{!!$item->syarat!!}"  recnip="{!!Input::get('nip')!!}"><i class="fa fa-search"></i> Preview</a></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td width="5%" class="text-center">{!!$x!!}</td>
                                            <td width="35%" colspan="2">{!!$item->syarat!!}</td>
                                            <td width="10%" class="text-center"><a href="javascript:void(0)" class="btn btn-default" onclick="bootbox.alert('Data belum tersedia.');"><i class="fa fa-search"></i> Preview</a></td>
                                        </tr>
                                        @endif
                                    @endforeach()
                                @else
                                    <tr>
                                        <td colspan="4">Data tidak ditemukan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="box-header">

                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> KENAIKAN GAJI BERKALA </h3>

                </div>

                <div class="box-body">

                    <div class="col-md-12 data-attribut">

                        <table class="table table-hovered table-stripped" width="100%">

                            <tr>

                                <th width="25%">KETERANGAN</th>

                                <th>KGB LAMA</th>

                                <th>KGB BARU</th>

                            </tr>

                            <tr>

                                <td widtd="25%">1. TMT KGB</td>

                                <td><span id="attr-tmtkgbl"></span></td>

                                <td><span id="attr-tmtkgbb"></span></td>

                            </tr>

                            <tr>

                                <td>2. Pangkat/Gol.</td>

                                <td><span id="attr-golpns"></td>

                                <td><span id="attr-golpnsskr"></td>

                            </tr>

                            <tr>

                                <td>3. Masa Kerja</td>

                                <td><span id="attr-mkkgbl"></span></td>

                                <td><span id="attr-mkkgbb"></span></td>

                            </tr>

                            <tr>

                                <td>4. Gaji</td>

                                <td><span id="attr-gajilama"></span></td>

                                <td><span id="attr-gajibaru"></span></td>

                            </tr>

                        </table>

                    </div>

                </div>



                <div class="box-header">

                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAPAN KGB </h3>

                </div>

                <div class="box-body">

                    <div class="data-penetap">

                        @if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4)))

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



                        <div id="ftampil2">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>

                                <div class="controls col-sm-7">

                                    <textarea rows="5" cols="6" name="kettms" id="kettms" class="form-control" placeholder="Keterangan Jika Tidak Memenuhi Syarat" ></textarea>

                                </div>

                            </div>

                        </div>



                        <div id="ftampil3">

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Keterangan</label>

                                <div class="controls col-sm-7">

                                    <textarea rows="5" cols="6" name="ketbtl" id="ketbtl" class="form-control" placeholder="Keterangan Jika Berkas Tidak Lengkap" ></textarea>

                                </div>

                            </div>

                        </div>



                        <div id="ftampil1">

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Status Proses</label>

                                <div class="controls col-sm-7">

                                    <select id="statussk" name="statussk" class="form-control" required>

                                        <option value="2">Dalam Proses</option>

                                        <option value="1">Proses Selesai</option>

                                    </select>

                                </div>

                            </div>

                        </div>



                        <div id="ftampil11">

                            <div class="form-group">

                                <label class="col-sm-3 control-label" for="noskkgbb">No. SK KGB</label>

                                <div class="controls col-sm-7">

                                    @if((session('role_id') < 3) or (session('skpd_id') == '001'))

                                        <input name="noskkgbb" value="" id="noskkgbb" maxlength="45" class="form-control" type="text" placeholder="Automatis" readonly>

                                    @else

                                        <input name="noskkgbb" value="" id="noskkgbb" maxlength="45" class="form-control" type="text" placeholder="No. SK KGB">

                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label" for="tglskkgbb">Tanggal SK KGB</label>

                                <div class="controls col-sm-7">

                                    <input name="tglskkgbb" value="" id="tglskkgbb" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text" required>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Jabatan Penetap</label>

                                <div class="controls col-sm-7">
                                    {!! comboPenetapsk("idpejab","","") !!}
                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Nama Jabatan</label>

                                <div class="controls col-sm-7">

                                    <input type="text" class="form-control" name="jabpenkgbb" id="jabpenkgbb" placeholder="Nama Jabatan">

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Pejabat Penetap</label>

                                <div class="controls col-sm-7">

                                    <input type="text" class="form-control" name="pejpenkgbb" id="pejpenkgbb" placeholder="Pejabat Penetap">

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">NIP Penetap</label>

                                <div class="controls col-sm-7">

                                    <input type="text" class="form-control" name="nippb" id="nippb" placeholder="Nomor Induk Penetap">

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label">Pangkat Penetap</label>

                                <div class="controls col-sm-7">

                                    <input type="text" class="form-control" name="golrupb" id="golrupb" placeholder="Golongan Ruang">

                                </div>

                            </div>

                        </div>

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



                        <div class="form-group">

                            <label for="" class="col-sm-3 control-label"></label>

                            <div class="col-sm-7">

                                <div class="checkbox">
                                    {!!\PenetapannominatifModel::cekKP(Input::get('nip'))!!}
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>

                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>

                                </div>

                            </div>

                        </div>

                        @else                        

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Status Proses</label>

                            <div class="controls col-sm-7">

                                <?php

                                    $item = \DB::table('tr_kgb')->where('idkgb', Input::get('idkgb'))->where('nip',Input::get('nip'))->first();



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

                                                    <label class="col-sm-3 control-label">Status SK</label>

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

    $(document).ready(function(){

        $('.tmt, .date').mask("99-99-9999");
        $('select').select2();



        $.ajax({

            url:'{!!url()!!}/kenaikangajiberkala/penetapannominatif/editkgb',

            data: { 'idkgb': "{!!Input::get('idkgb')!!}",'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},

            type:'post',

            success:function(response){

                var ret = $.parseJSON(response);

                $('.data-attribut #attr-tmtkgbl').html(ret.tmtkgbl);

                $('.data-attribut #attr-tmtkgbb').html(ret.tmtkgbb);

                $('.data-attribut #attr-golpns').html(ret.golru+' - '+ret.pangkat);

                $('.data-attribut #attr-golpnsskr').html(ret.golrub+' - '+ret.pangkatb);

                $('.data-attribut #attr-mkkgbl').html(ret.mktkgbl+' tahun '+ret.mkbkgbl+' bulan');

                $('.data-attribut #attr-mkkgbb').html(ret.mktkgbb+' tahun '+ret.mkbkgbb+' bulan');

                $('.data-attribut #attr-pendidikan').html(ret.jurusan);

                $('.data-attribut #attr-usia').html(ret.usiakgb.substr(0, 2)+" tahun "+ret.usiakgb.substr(2, 2)+" bulan");

                $('.data-attribut #attr-gajilama').html('Rp. '+ret.gkgbl);

                $('.data-attribut #attr-gajibaru').html('Rp. '+ret.gkgbb);



                $('.data-penetap #pejpenkgbb').val(ret.pejpenkgbb);

                $('.data-penetap #nippb').val(ret.nippb);

                $('.data-penetap #golrupb').val(ret.golrupb);

                $('.data-penetap #jabpenkgbb').val(ret.jabpenkgbb);

                $('.data-penetap #noskkgbb').val(ret.noskkgbb);

                $('.data-penetap input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);

            <?php if((session('role_id') < 3) or ((Input::get('jnskgb') == 1) and (session('role_id') == 4))){?>

                
                if(ret.idstspeg == 3){
                    if(ret.golpnsskr == 31){
                        $('.data-penetap #idpejab').select2("val", "033");
                    }else{
                        $('.data-penetap #idpejab').select2("val", ret.idpejab);
                    }
                }else{
                    $('.data-penetap #idpejab').select2("val", ret.idpejab);
                }

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

                if(ret.tglskkgbb_ != '00-00-0000') {

                    $('.data-penetap #tglskkgbb').val(ret.tglskkgbb_);

                }else{

                    $('.data-penetap #tglskkgbb').val("{!!date('d-m-Y')!!}");

                }

                $('.data-penetap #statususul').trigger('change');

                $('.data-penetap #statussk').trigger('change');



                $('.data-biodata #attr-nip').html(ret.nip);

                $('.data-biodata #idskpd').val(ret.kdskpdskr);

                $('.data-biodata #jnskgb').val(ret.jnskgb);

                $('.data-biodata #golpnsskr').val(ret.golpnsskr);

                $('.data-biodata #attr-nama').html(ret.nama);

                $('.data-biodata #attr-ttl').html(ret.tmplahir+','+ret.tgllahir_);

                $('.data-biodata #attr-goltmt').html(ret.golru+' , '+ret.tmtgollama_);

                $('.data-biodata #attr-esltmt').html(ret.eseloname+' , '+ret.tmteselon_);

                $('.data-biodata #attr-jskpd').html(ret.nmajab+' '+ret.tmpskpdskr);

                $('.data-biodata #attr-mkerja').html(ret.mkthn+' tahun '+ret.mkbln+' bulan');

                $('.data-biodata #attr-pendidikan').html(ret.jurusan);

                $('.data-biodata #attr-usia').html(ret.usiakgb.substr(0, 2)+" tahun "+ret.usiakgb.substr(2, 2)+" bulan");

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

        

        $('#form-verifikasi').on('submit',function(e){

            var $this = $(this);

            e.preventDefault();

            bootbox.confirm('Update Kenaikan Gaji Berkala ?',function(a){

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

                            if(html==4){

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

        //
        $('a.prefile').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/prefile',
                data: {'nip': $(this).attr('recnip'), 'jenis': $(this).attr('recjenis'), 'subjenis': $(this).attr('recsubjenis'), 'syarat': $(this).attr('recsyarat'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

    });

</script>
