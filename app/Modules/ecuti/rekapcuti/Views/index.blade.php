<style>table.tb td{padding:5px;} .control-label{font-weight: bold;}</style>
<section class="content-header">
    <h1>
        Rekap Cuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Rekapcuti</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'rekap-cuti', 'target'=>'_blank')) !!}
                <div class="box-body">
                    <center>
                        <table width="60%" class="tb center" border="0">
                            <tr>
                                <td width="20%" class="control-label">Jenis Cuti</td>
                                <td width="1%">:</td>
                                <td colspan="3">{!!comboJenisCuti("id_jenis_cuti")!!}</td>
                            </tr>
                            <tr>
                                <td width="20%" class="control-label">Unit Kerja</td>
                                <td width="1%">:</td>
                                <td colspan="3">{!!comboSkpd("idskpd","","",session('idskpd'))!!}</td>
                            </tr>
                            <tr>
                                <td width="20%" class="control-label">Cari Berdasarkan </td>
                                <td width="1%">:</td>
                                <td>
                                    <label><input type="radio" name="pil" id="istangal"> Tanggal</label>&nbsp;
                                    <label><input type="radio" name="pil" id="isbulan" checked=""> Bulan</label>&nbsp;
                                </td>
                            </tr>
                            <tr id="inbulan">
                                <td width="20%" class="control-label">Periode Cuti </td>
                                <td width="1%">:</td>
                                <td>{!! comboBulan("bulan",date('m'),"",".: Bulan :.") !!}</td>
                                <td>{!! comboTahun("tahun",date('Y'),"",".: Tahun :.") !!}</td>
                            </tr>
                            <tr id="inbetween">
                                <td width="20%" class="control-label">Periode Cuti </td>
                                <td width="1%">:</td>
                                <td>
                                    <div class='input-group datepicker'>
                                        <input type="text" name="tanggal1" id="tanggal1" class="form-control date awal" value="{!!Input::get('tanggal1')!!}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    &nbsp;s/d&nbsp;
                                </td>
                                <td>
                                    <div class='input-group datepicker'>
                                        <input type="text" name="tanggal2" id="tanggal2" class="form-control date awal" value="{!!Input::get('tanggal2')!!}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="4">
                                    <table width="100%" class="tb" border="0">
                                        <tr>
                                            <td class="pull-right">
                                                <button class="btn btn-success" type="button" id="prev-daftar"><i class="fa fa-list-ul"></i> Lihat Daftar</button>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-success" type="button" id="cetak-daftar"><i class="fa fa-print"></i> Cetak Daftar</button>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-success" type="button" id="excel-daftar"><i class="fa fa-file-excel-o"></i> Download Excel</button>  
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </div>
                <br>
            </div>
            {!! Form::close() !!}
            <div class="col-md-12">
                <div id="result" class="table-responsive"></div>
            </div>
        </div>
    </div>
</div>
</section>         

<script>
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        });
    }

    $(document).ready(function(){
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');


        $(".datepicker").datetimepicker({format: 'DD-MM-YYYY',locale: 'id'});
        $(".date").mask("99-99-9999");
        /*funciton untuk filter*/
        $('#inbulan').show();
        $('#inbetween').hide();
        $('input[type="radio"][name="pil"]').click(function() {
            if($('#isbulan').is(':checked'))
            {
                $('#tanggal1').val('');
                $('#tanggal2').val('');

                $('#inbulan').show();
                $('#inbetween').hide();
            }
            else if($('#istangal').is(':checked'))
            {
                $('#bulan').select2('val','');
                $('#tahun').select2('val','');

                $('#inbetween').show();
                $('#inbulan').hide();
            }
        });

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#prev-daftar').on('click', function(e){
            e.preventDefault();
            var id_jenis_cuti = $('#id_jenis_cuti').val();
            var jenis_cuti = "";
            
            // alert(id_jenis_cuti);

            if (id_jenis_cuti == 1) {
                jenis_cuti = "rekapdalamopd";
            }else if (id_jenis_cuti == 2) {
                jenis_cuti = "rekapantaropd";
            }else if (id_jenis_cuti == 3) {
                jenis_cuti = "rekapluarkab";
            }else if (id_jenis_cuti == 4) {
                jenis_cuti = "rekapmasukkab";
            }else{
                jenis_cuti = "";
            }
            if(id_jenis_cuti != ''){
                $.ajax({
                    url : '{!!url()!!}/ecuti/rekapcuti/data/'+jenis_cuti,
                    type : 'post',
                    data : $('#rekap-cuti').serialize(),
                    beforeSend:function(){
                        $('#result').html('<i class="fa fa-spinner"></i> Loading...');

                    },
                    success:function(response){
                        $('#result').html(response);
                    }
                });
            }else{
                bootbox.alert('Pilihan Jenis cuti harus diisi !');
            }
        });

        $('#cetak-daftar').on('click', function(e){
            e.preventDefault();
            if($('#id_jenis_cuti').val() != ''){
                $('#rekap-cuti').attr("action", "{!!url()!!}/ecuti/rekapcuti/print/rekapcuti");
                $('#rekap-cuti').submit();
            }else{
                bootbox.alert('Pilihan Jenis Cuti harus diisi !');
            }
        });

        $('#excel-daftar').on('click', function(e){
            e.preventDefault();
            if($('#id_jenis_cuti').val() != ''){
                $('#rekap-cuti').attr("action", "{!!url()!!}/ecuti/rekapcuti/excel/rekapcuti");
                $('#rekap-cuti').submit();
            }else{
                bootbox.alert('Pilihan Jenis Muti harus diisi !');
            }
        });

    });
</script>
