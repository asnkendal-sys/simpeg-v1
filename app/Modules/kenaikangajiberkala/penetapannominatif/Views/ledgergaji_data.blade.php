<?php
    $bulan = Input::get('bulan');
    $tahun = Input::get('tahun');
?>

<form id="form-pengantar" class="form-horizontal" method="POST" action="{!!url()!!}/kenaikangajiberkala/penetapannominatif/ledgergaji" accept-charset="UTF-8">

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> ATRIBUT LEDGER GAJI </h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 data-biodata">
                    {!!csrf_field()!!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">BULAN</label>
                        <div class="controls col-sm-7">
                            {!! comboBulangaji("led_bulan",$bulan,"",".: Bulan :.") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">TAHUN</label>
                        <div class="controls col-sm-7">
                            {!! comboTahun("led_tahun",$tahun,"",".: Tahun :.") !!}
                        </div>
                    </div>

                    @if(session('role_id') <= 3)
                    <div id="xfile"></div>
                    @else
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp</label>
                        <div class="controls col-sm-7">
                            <button type="button" class="btn btn-primary" id="prev_ledger"><i class="fa fa-search"></i> Preview</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</form>

<style type="text/css">
    .modal {
        overflow: auto !important;
    }
</style>

@if(session('role_id') <= 3)
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').select2();

            $('#led_bulan, #led_tahun').on('change', function(e){
                e.preventDefault();
                var bulan = $('#led_bulan').val();
                var tahun = $('#led_tahun').val();

                if((bulan != '') && (tahun != '')){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/ledgergajifile',
                        data: {'bulan': bulan, 'tahun': tahun, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#xfile').html(html);
                        }
                    });
                }else{
                    $('#xfile').html('');
                }
            }).trigger('change');

        });
    </script>
@else
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').select2();

            $('#prev_ledger').on('click', function(e){
                e.preventDefault();
                var bulan = $('#led_bulan').val();
                var tahun = $('#led_tahun').val();

                if((bulan != '') && (tahun != '')){
                    $.ajax({
                        type: 'post',
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/ledgergajiview',
                        data: {'idskpd': '{!!session('idskpd')!!}', 'bulan': bulan, 'tahun': tahun, '_token' : '{!!csrf_token()!!}'},
                        success:function(html){
                            $('#main_modal .modal-body').html(html);
                        }
                    });
                }else{
                    bootbox.alert('Bulan dan tahun harus diisi.');
                }
            });
        });
    </script>
@endif