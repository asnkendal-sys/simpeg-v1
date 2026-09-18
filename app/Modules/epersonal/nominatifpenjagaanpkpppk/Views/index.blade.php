<section class="content-header">
    <h1>
        Nominatif Penjagaan Masa Perjanjian Kerja PPPK<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Nominatif Penjagaan Masa Perjanjian Kerja PPPK</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="row">
            <div class="col-md-12">
                  <ul class="nav nav-tabs tab1" id="myTab">
                        <li class="active"><a href="{!!url()!!}/epersonal/nominatifpenjagaanpkpppk"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PENJAGAAN PK PPPK</a></li>
                        @if(session('role_id') <= 3)
                        <li class=""><a href="{!!url()!!}/epersonal/nominatifpenjagaanpkpppk/nominatifpenjagaanperpanjanganpppk"> <i class="fa fa-fw fa-list-ul"></i> NOMINATIF PENJAGAAN PERPANJANGAN PPPK</a></li>
                        @endif
                  </ul>

                {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai', 'target'=>'_blank')) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('idskpd', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-7">
                            {!!comboSkpd("idskpd","","",session('idskpd'))!!}
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        {!! Form::label('idjenjab', 'Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-4">
                            {!! comboJenjab("idjenjab","","") !!}
                        </div>
                    </div> -->
                    <div class="form-group">
                        {!! Form::label('bulan1', 'Bulan Antara:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! comboBulan("bulan1","","") !!}
                        </div>
                        <div class="col-sm-2">
                            {!! comboBulan("bulan2","","") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('tahun1', 'Tahun Antara:', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! comboTahun("tahun1",date('Y'),"") !!}
                        </div>
                        <div class="col-sm-2">
                            {!! comboTahun("tahun2",date('Y'),"") !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <button class="btn btn-success" type="button" id="prev-nominatif"><i class="fa fa-list-ul"></i> Lihat Nominatif</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-success" type="button" id="cetak-nominatif"><i class="fa fa-print"></i> Cetak Nominatif</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download Excel</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-12">
                <div id="result" class="table-responsive"></div>
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
      $('.checkme,.checkall').on('change',function(){
      if($(this).is(':checked'))
            $('#deleteall').fadeIn(300);
      else
            $('#deleteall').fadeOut(300);
      });

      $('ul#myTab').on('click','a',function(e){
      var str = $(this).attr('href');
      var n = str.search("dashboard");
      loading('utama');
      if(n > 0){
      }
      else{
            e.preventDefault();
            e.stopImmediatePropagation();
            preloader = new $.materialPreloader({
                  position: 'top',
                  height: '5px',
                  col_1: '#159756',
                  col_2: '#da4733',
                  col_3: '#3b78e7',
                  col_4: '#fdba2c',
                  fadeIn: 200,
                  fadeOut: 200
            });

            $.ajax({
                  type: 'get',
                  url : $(this).attr('href'),
                  beforeSend: function(){
                  preloader.on();
                  },
                  success: function(data) {
                  preloader.off();
                  $('#utama').html(data);
                  }
            });
      }
      });

      //   $('#buat').on('click',function(e){
      //       e.preventDefault();
      //       $.ajax({
      //           url : $(this).attr('href'),
      //           //url : laravel_base + '/' + $(this).attr('href'),
      //           type : 'get',
      //           beforeSend: function(){
      //               preloader.on();
      //           },
      //           success:function(html){
      //               preloader.off();
      //               $('#utama').html(html);
      //           }
      //       });
      //   });

      //   <?php
      //   echo 'var index_page=laravel_base + "/'.\Request::path().'";';
      //   ?>

      //   $('#tabel').on('click','#hapus',function(e){
      //       e.preventDefault();
      //       var $this =$(this);
      //       bootbox.confirm('Hapus?',function(a){
      //           if(a == true){
      //               $.ajax({
      //                   url : index_page + '/delete',
      //                   type : 'post',
      //                   data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
      //                   beforeSend: function(){
      //                       preloader.on();
      //                   },
      //                   success:function(html){
      //                       preloader.off();
      //                       notification(html,'success');
      //                       $this.closest('tr').fadeOut(300,function(){
      //                           $(this).remove();
      //                       });
      //                   }
      //               });
      //           }
      //       });
      //   });
      //   $('#tabel').on('click','#edit',function(e){
      //       e.preventDefault();
      //       var $this =$(this);
      //       bootbox.confirm('Edit?',function(a){
      //           if(a == true){
      //               $.ajax({
      //                   url : index_page + '/edit',
      //                   type : 'get',
      //                   data:'id=' + $this.attr('recid'),
      //                   beforeSend: function(){
      //                       preloader.on();
      //                   },
      //                   success:function(html){
      //                       preloader.off();
      //                       $('#utama').html(html);
      //                   }
      //               });
      //           }
      //       });
      //   });
      //   $('#cari').on('submit',function(e){
      //       e.preventDefault();
      //       $.ajax({
      //           url : $(this).attr('action'),
      //           data:$(this).serialize(),
      //           type : 'get',
      //           beforeSend: function(){
      //               preloader.on();
      //           },
      //           success:function(html){
      //               preloader.off();
      //               $('#utama').html(html);
      //           }
      //       });
      //   });
      //   $('#data').on('submit',function(e){
      //       e.preventDefault();
      //       var iki = $(this);
      //       bootbox.confirm('Hapus?',function(r){
      //           if(r){
      //               $.ajax({
      //                   url : iki.attr('action') + '/delete',
      //                   type : 'post',
      //                   data:iki.serialize(),
      //                   beforeSend: function(){
      //                       preloader.on();
      //                   },
      //                   success:function(html){
      //                       preloader.off();
      //                       notification(html,'success');
      //                       iki.find('input[type=checkbox]').each(function (t){
      //                           if($(this).is(':checked')){
      //                               $(this).closest('tr').fadeOut(100)
      //                           }
      //                       });
      //                       $('#deleteall').fadeOut(300);
      //                   }
      //               });
      //           }
      //       });
      //   });

        $('#prev-nominatif').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url : '{!!url()!!}/epersonal/nominatifpenjagaanpkpppk/data/nominatif',
                type : 'post',
                data : $('#nominatif-pegawai').serialize(),
                beforeSend:function(){
                    $('#result').html('<i class="fa fa-spinner"></i> Loading...');
                },
                success:function(response){
                    $('#result').html(response);
                }
            });
        });

        $('#cetak-nominatif').on('click', function(e){
            e.preventDefault();
            $('#nominatif-pegawai').attr("action", "{!!url()!!}/epersonal/nominatifpenjagaanpkpppk/print/nominatif");
            $('#nominatif-pegawai').submit();
        });

        $('#excel-nominatif').on('click', function(e){
            e.preventDefault();
            $('#nominatif-pegawai').attr("action", "{!!url()!!}/epersonal/nominatifpenjagaanpkpppk/excel/nominatif");
            $('#nominatif-pegawai').submit();
            /*cetak_excel('result');*/
        });
    });
</script>
