<form id="form-edit" class="form-horizontal" method="POST" action="{!!url()!!}/pppkpw/perpanjangankontrakpw/verifikasipppkpw" accept-charset="UTF-8">

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
                        <input type="hidden" name="idpppk" id="idpppk" value="{!!Input::get('idpppk')!!}">
                        <input type="hidden" name="nip" id="nip" value="{!!Input::get('nip')!!}">
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> KONTRAK PPPK PW TERAKHIR </h3>
                </div>
                <div class="box-body">
                    <div class="data-pppkl">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> NO. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-noskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TGL. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-tmtpppkl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TGL. SK Perjanjian </label>
                            <div class="col-sm-7">
                                <span id="attr-tgskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Golongan </label>
                            <div class="col-sm-7">
                                <span id="attr-golrul"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Masa Kerja </label>
                            <div class="col-sm-7">
                                <span id="attr-mskl"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gaji PPPK </label>
                            <div class="col-sm-7">
                                <span id="attr-gajil"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-warning">
            <div class="col-md-6 data-attribut">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PERPANJANGAN PPPK PW </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('status', 'Status Usulan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            <span id="attr-status"></span>
                        </div>
                    </div>                    
                    <div class="form-group xstatus_keterangan">
                        {!! Form::label('status_keterangan', 'Status Keterangan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">                            
                            <span id="attr-status_keterangan"></span>
                        </div>
                    </div>
                    <span class="xstatus">
                        <div class="form-group">
                            {!! Form::label('tmtawal', 'Masa Perjanjian Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-3">
                                <span id="attr-tmtpppk"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('idgolru', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <span id="attr-golru"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('thkerja', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <span id="attr-msk"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('gaji', 'Gaji PPPK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <span id="attr-gaji"></span>
                            </div>
                        </div>
                    </span>

                    {{-- start  dokumen --}}
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
                                $rs = callApi('get', 'http://10.5.2.131:2023/efile/dokumenpersyaratan?id=44&nip='.Input::get('nip'));                                
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

            <div class="col-md-6 data-attribut">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> VERIFIKASI PERPANJANGAN PPPK PW</h3>
                </div>
                <div class="box-body data-penetap">
                @if(session('role_id') < 3)
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status Berkas</label>
                        <div class="controls col-sm-7">
                            <select id="statususul" name="statususul" class="form-control">
                                <option value="0">.: Pilihan :.</option>
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
                                <select id="statussk" name="statussk" class="form-control">
                                    <option value="2">Dalam Proses</option>
                                    <option value="1">Proses Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="ftampil11">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="nosk">No. SK Perjanjian </label>
                            <div class="controls col-sm-7">
                                <input name="nosk" value="" id="nosk" maxlength="45" class="form-control" type="text" placeholder="No. SK Perjanjian">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tgsk">Tanggal SK Perjanjian</label>
                            <div class="controls col-sm-7">
                                <input name="tgsk" value="" id="tgsk" maxlength="10" class="date form-control" placeholder="dd-mm-yyyy" type="text" required>
                            </div>
                        </div>

                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAPAN BUPATI </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jabatan Penetap</label>
                            <div class="controls col-sm-7">
                                {!! comboPenetapsk("idpejab","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Bupati</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="bupati" id="bupati" placeholder="Nama Bupati">
                            </div>
                        </div>

                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAPAN KEPALA BKPSDM </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Jabatan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="jabkepalabkd" id="jabkepalabkd" placeholder="Nama Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pejabat Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="kepalabkd" id="kepalabkd" placeholder="Pejabat Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIP Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="nipkepalabkd" id="nipkepalabkd" placeholder="Nomor Induk Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pangkat Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="pangkatbkd" id="pangkatbkd" placeholder="Pangkat Penetap">
                            </div>
                        </div>

                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-fw fa-paper-plane-o"></i> PENETAPAN SEKDA </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Jabatan</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="jabkepalasekda" id="jabkepalasekda" placeholder="Nama Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pejabat Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="kepalasekda" id="kepalasekda" placeholder="Pejabat Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIP Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="nipsekda" id="nipsekda" placeholder="Nomor Induk Penetap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pangkat Penetap</label>
                            <div class="controls col-sm-7">
                                <input type="text" class="form-control" name="pangkatsekda" id="pangkatsekda" placeholder="Pangkat Penetap">
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
                                $item = \DB::table('tr_pppkpw')->where('idpppk', Input::get('idpppk'))->where('sts_kontrak', 2)->where('nip',Input::get('nip'))->first();
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

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt, .date').mask("99-99-9999");
        @if(session('role_id') < 3)
        $('select').select2();
        @endif

        $.ajax({
            url:'{!!url()!!}/pppkpw/perpanjangankontrakpw/editpppkpw',
            data: { 'idpppk': "{!!Input::get('idpppk')!!}",'nip':"{!!Input::get('nip')!!}", '_token' : '{!!csrf_token()!!}'},
            type:'post',
            success:function(response){
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk");
                var arrselect2 = new Array("statususul","statussk","idpejab");
                if(ret){
                    for(attrname in ret){
                        $('.data-penetap #'+attrname).val(ret[attrname]);
                        @if(session('role_id') < 3)
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('.data-penetap #'+attrname).select2('val',ret[attrname]);
                        }
                        @endif
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('.data-penetap #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }
                }
                $('.data-penetap input[name="iscetaksk"][value='+ret.iscetaksk+']').prop('checked',true);

                $('.data-biodata #attr-nip').html(ret.nip);
                $('.data-biodata #attr-nama').html(ret.nama);
                $('.data-biodata #attr-ttl').html(ret.tmlhr+', '+ret.tglhr_);
                $('.data-biodata #attr-goltmt').html(ret.golrul+' , '+ret.tmtawall_);
                $('.data-biodata #attr-jskpd').html(ret.jab+' '+ret.skpd);
                $('.data-biodata #attr-mkerja').html(ret.thkerjal+' tahun '+ret.blkerjal+' bulan');
                $('.data-biodata #attr-pendidikan').html(ret.tkpendid+', '+ret.jenjurusan);

                $('.data-pppkl #attr-noskl').html(ret.noskl);
                $('.data-pppkl #attr-tmtpppkl').html(ret.tmtawall_+' sd '+ret.tmtakhirl_);
                $('.data-pppkl #attr-tgskl').html(ret.tgskl_);
                $('.data-pppkl #attr-golrul').html(ret.golrul+' , '+ret.tmtawall_);
                $('.data-pppkl #attr-mskl').html(ret.thkerjal+' tahun '+ret.blkerjal+' bulan');
                $('.data-pppkl #attr-gajil').html('Rp. '+ret.gajil.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

                $('.data-attribut #attr-tmtpppk').html(ret.tmtawal_+' sd '+ret.tmtakhir_);
                $('.data-attribut #attr-golru').html(ret.golru);
                $('.data-attribut #attr-msk').html(ret.thkerja+ ' tahun ' +ret.blkerja+' bulan');
                $('.data-attribut #attr-gaji').html('Rp. '+ret.gaji.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                
                if(ret.status == 2){                    
                    var status = 'Tidak Diusulkan';
                    $('.xstatus').fadeOut();
                    $('.xstatus_keterangan').fadeIn();                                        
                }else{                                            
                    var status = 'Diusulkan';    
                    $('.xstatus').fadeIn();
                    $('.xstatus_keterangan').fadeOut();                                        
                }

                $('.data-attribut #attr-status').html(status);
                $('.data-attribut #attr-status_keterangan').html(ret.status_keterangan);

                $('.data-penetap #ftampil1').hide();
                $('.data-penetap #ftampil2').hide();
                $('.data-penetap #ftampil3').hide();
                $('.data-penetap #ftampil11').hide();
                $('.data-penetap #ftampil12').hide();

                @if(session('role_id') < 3)
                if(ret.statussk == 0){                    
                    $('.data-penetap #statussk').select2("val", 2);
                }else{                    
                    $('.data-penetap #statussk').select2("val", ret.statussk);
                }
                @endif

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
            }
        });

        $('#form-edit').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Update Perpanjangan PPPK PW ?',function(a){
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
