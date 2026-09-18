{!!View::make('home::portal.header')!!}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrappers" id='utama' style="padding-top: 50px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tracking
            <!--<small>Version 2.0</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url()!!}/tracking"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tracking Layanan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-primary">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA </h3>
                    </div>
                    <div class="box-body">
                        Tracking layanan merupakan menu untuk melakukan pengecekan usulan layanan yang dilakukan oleh Pegawai Negeri Sipil di Kabupaten Kendal meliputi
                        Kenaikan Gaji Berkala dan Mutasi.
                        <hr>
                        <form id="form-status" class="form-horizontal form-" accept-charset="UTF-8" action="{!!url()!!}/validasi-layanan" method="POST">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="nip">NIP :</label>
                                    <div class="col-sm-7">
                                        <input type="text" id="nip" name="nip" class="form-control validate[required] num" placeholder="NIP" maxlength="18">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="jnslayanan">Jenis Layanan :</label>
                                    <div class="col-sm-7">
                                        {!!comboLayanan('jnslayanan','','')!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="jnslayanan">Centang Keamanan :</label>
                                    <div class="col-sm-7">
                                        <div class="g-recaptcha" data-sitekey="6Lc7pDsUAAAAAL0sV4ww2uSaurHGP8q-mcoJQsG-" id="rc-imageselect" style="transform:scale(0.72);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-7">
                                        <button class="btn btn-success" type="submit" id="submit"><i class="glyphicon glyphicon-zoom-in"></i> Status Layanan</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.row -->

                    <!-- ./box-body -->
                </div>

                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-search"></i> DETAIL LAYANAN </h3>
                    </div>
                    <div class="box-body">
                        <div id='status-result'>
                            <div class="callout callout-danger">
                                <ul style="padding-left: 15px">
                                    <li>Detail layanan belum tersedia.</li>
                                </ul>
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

<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        function beforeCall(form, options){
            if (window.console)
                console.log("Right before the AJAX form validation call");
            return true;
        }

        function ajaxValidationCallback(status, form, json, options){
            if (window.console)
                console.log(status);

            if (status === true) {
                $.ajax({
                    url  : '{!!url()!!}/status-layanan',
                    type : 'POST',
                    data : $("#form-status").serialize(),
                    beforeSend: function(){
                        $('#status-result').html('<i class="fa fa-fw fa-spinner"></i> Looading..');
                    },
                    success:function(response){
                        $('#status-result').html(response);
                    }
                });
            }
        }

        jQuery("#form-status").validationEngine('attach',{
            ajaxFormValidation: true,
            ajaxFormValidationMethod: 'post',
            onAjaxFormComplete: ajaxValidationCallback
        });

//        $('#form-status').on('submit',function(e){
//            var $this = $(this);
//            e.preventDefault();
//
//            if($("#form-status").validationEngine('validate')) {
//                $.ajax({
//                    url : $this.attr('action'),
//                    type : 'POST',
//                    data : $this.serialize(),
//                    beforeSend: function(){
//                        $('#status-result').html('<i class="fa fa-fw fa-spinner"></i> Looading..');
//                    },
//                    success:function(response){
//                        $('#status-result').html(response);
//                    }
//                });
//            }
//        });
    });
</script>

{!!View::make('home::portal.footer')!!}


