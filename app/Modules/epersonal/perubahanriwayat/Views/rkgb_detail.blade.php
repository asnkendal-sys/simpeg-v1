<section class="content">
   <div class="box box-primary">
      {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
         <div class="table-responsive">
            <div class="box-body no-padding">
               <div id="riwayat" class="tab-pane">
                  <p>
                     <div class="nav-tabs-custom" style="box-shadow:none;">
                        <ul class="nav nav-tabs tab2" id="myTabs">
                           <li><a data-toggle="tab" href="#" id="biodata" recnip="{!! Input::get('nip') !!}"><i class="fa fa-fw fa-dot-circle-o"></i> BIODATA</a></li>
                           <li><a data-toggle="tab" href="#" id="rpangkat" recnip="{!! Input::get('nip') !!}"><i class="fa fa-fw fa-dot-circle-o"></i> PANGKAT</a></li>
                           <li><a data-toggle="tab" href="#" id="rjab" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> JABATAN</a></li>
                           <li class="active"><a data-toggle="tab" href="#" id="rkgb" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> KGB</a></li>
                           <li><a data-toggle="tab" href="#" id="rpend" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> PENDIDIKAN</a></li>
                           <li><a data-toggle="tab" href="#" id="rdikstru" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT STRUKTURAL</a></li>
                           <li><a data-toggle="tab" href="#" id="rdikfung" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT FUNGSIONAL</a></li>
                           <li><a data-toggle="tab" href="#" id="rdiktek" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT TEKNIS</a></li>
                           <li><a data-toggle="tab" href="#" id="rhukdis" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> HUKUM DISIPLIN</a></li>
                            <li><a data-toggle="tab" href="#" id="rpppk" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> PPPK</a></li>
                        </ul>

                        <div class="tab-content">
                           <div id="kgb" class="tab-pane active">
                              <p>
                                 <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rkgb">
                                    <thead class="bg-primary">
                                       <tr>
                                          <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                                          <th rowspan="2"><div class="text-center">NO SKKGB</div></th>
                                          <th rowspan="2"><div class="text-center">TMT KGB</div></th>
                                          <th rowspan="2"><div class="text-center">TGL KGB</div></th>
                                          <th rowspan="2"><div class="text-center">GOLONGAN</div></th>
                                          <th colspan="2"><div class="text-center">MASA KERJA</div></th>
                                          <th rowspan="2"><div class="text-center">GAJI</div></th>
                                          <th rowspan="2"><div class="text-center">PENETAP</div></th>
                                          <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    <?php $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0; ?>
                                    @foreach ($rkgbs as $rkgb)
                                    <?php $x++; ?>
                                    <tr>
                                        <td rowspan="2"align="center">{!!$x!!}</td>
                                        <td>{!!$rkgb->noskkgb!!}</td>
                                        <td align="center">{!!date('d-m-Y', strtotime($rkgb->tmtkgb))!!}</td>
                                        <td align="center">{!!date('d-m-Y', strtotime($rkgb->tglkgb))!!}</td>
                                        <td>{!!$rkgb->golru." - ".$rkgb->pangkat!!}</td>
                                        <td align="center">{!!$rkgb->mkthn!!}</td>
                                        <td align="center">{!!$rkgb->mkbln!!}</td>
                                        <td>{!!"Rp. ".number_format($rkgb->gaji)!!}</td>
                                        <td>{!!($rkgb->jabatan!='')?$rkgb->jabatan:$rkgb->penetap!!}</td>
                                        <td rowspan="2" align="right">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span> Aksi
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a class="text-info prevperubahan2" recid="{!!$rkgb->id!!}" recnip="{!!$rkgb->nip!!}" recflag="{!!$rkgb->idjnsaksi!!}" href="javascript:void(0)" ><i class="{!!(session('role_id') <= 3)?'fa fa-check':'fa fa-search'!!}"></i> {!!(session('role_id') <= 3)?'Verifikasi':'Preview'!!}</a></li>
                                                    <li><a class="text-danger btlperubahan" recid="{!!$rkgb->id!!}" recnip="{!!$rkgb->nip!!}" recflag="{!!$rkgb->idjnsaksi!!}" href="javascript:void(0)" ><i class="fa fa-times-circle"></i> Batalkan</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><em><small>{!!$rkgb->nip."<br>".$rkgb->namalengkap!!}</small></em></td>
                                        <td colspan="3"><em><small>{!!$rkgb->path!!}</small></em></td>
                                        <td colspan="4" class="{!!($rkgb->status == 2)?'alert-danger':''!!}">
                                            <em><small>{!!getKetaksi($rkgb->idjnsaksi)!!}</small></em><br>
                                            <em><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keterangan : {!!($rkgb->ketditolak!='')?$rkgb->ketditolak:'Belum ada tanggapan.'!!}</small></em>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                 </table>
                              </p>
                           </div>
                        </div>
                     </div>
                  </p>
               </div>
               <!-- /.tab-pane -->
            </div>
         </div>
         <div class="box-footer clearfix">
            <div class="row">
               <div class="col-sm-6">
                 &nbsp;
               </div>
               <div class="col-sm-6">
                   <?php echo $rkgbs->appends(array('idskpd'=>Input::get('idskpd'), 'search' => Input::get('search')))->render(); ?>
               </div>
            </div>
         </div>
      {!! Form::close() !!}
   </div>

   <form id="prev-kgbakhir" class="form-horizontal">
      <div class="row ">
         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-body">
                  <!-- Custom Tabs -->
                  <div class="nav-tabs-custom" style="box-shadow:none;">
                     <ul class="nav nav-tabs tab1" id="myTab2">
                        <li class="active"><a data-toggle="tab" href="#kgbakhir"> <i class="fa fa-fw fa-money"></i> DAFTAR KGB</a></li>
                     </ul>

                     <div class="tab-content data-awal">
                        <?php
                           $nip = Input::get('nip');
                           $n  = 0;
                           $x  = 0;
                           $rs = BiodataModel::getRkgb($nip);
                           $rs2 = BiodataModel::getRkgbtemp($nip);
                        ?>
                        <div id="kgbakhir" class="tab-pane active">
                           <div class="row">
                              <table class="table table-striped table-hover table-condensed table-bordered" role='grid' id="tb-rkgb">
                                  <thead class="bg-primary">
                                      <tr>
                                          <th rowspan="2" width="2%"><div class="text-center">NO</div></th>
                                          <th rowspan="2"><div class="text-center">NO SKKGB</div></th>
                                          <th rowspan="2"><div class="text-center">TMT KGB</div></th>
                                          <th rowspan="2"><div class="text-center">TGL KGB</div></th>
                                          <th rowspan="2"><div class="text-center">GOLONGAN</div></th>
                                          <th colspan="2"><div class="text-center">MASA KERJA</div></th>
                                          <th rowspan="2"><div class="text-center">GAJI</div></th>
                                          <th rowspan="2"><div class="text-center">PENETAP</div></th>
                                          <!-- <th rowspan="2" width="8%"><div class="text-center">AKSI</div></th> -->
                                      </tr>
                                      <tr>
                                          <th><div class="text-center">TAHUN</div></th>
                                          <th><div class="text-center">BULAN</div></th>
                                      </tr>
                                  </thead>
                                  <tbody id="result">
                                     @if(count($rs->get()) > 0)
                                         @foreach($rs->get() as $item)
                                             <?php $n++; ?>
                                             <tr>
                                                 <td align="center">{!!$n!!}</td>
                                                 <td>{!!$item->noskkgb!!}</td>
                                                 <td align="center">{!!date('d-m-Y', strtotime($item->tmtkgb))!!}</td>
                                                 <td align="center">{!!date('d-m-Y', strtotime($item->tglkgb))!!}</td>
                                                 <td>{!!$item->golru." - ".$item->pangkat!!}</td>
                                                 <td align="center">{!!$item->mkthn!!}</td>
                                                 <td align="center">{!!$item->mkbln!!}</td>
                                                 <td>{!!"Rp. ".number_format($item->gaji)!!}</td>
                                                 <td>{!!($item->jabatan!='')?$item->jabatan:$item->penetap!!}</td>
                                                 <!-- <td align="right">
                                                     <div class="btn-group">
                                                         <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                                             <span class="caret"></span> Aksi
                                                         </button>
                                                         <ul class="dropdown-menu pull-right">
                                                             <li><a class="text-info edit" recid="{!!$item->id!!}" href="javascript:void(0)" id="edit"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                                             <li><a class="text-danger {{(session('role_id') <= 3)?'hapus':'hapusmin'}}" recid="{!!$item->id!!}" href="javascript:void(0)" id="hapus"><i class="fa fa-times-circle"></i> Hapus</a></li>
                                                         </ul>
                                                     </div>
                                                 </td> -->
                                             </tr>
                                         @endforeach
                                     @else
                                         <tr>
                                             <td colspan="10">Riwayat Kenaikan Gaji Berkala belum tersedia.</td>
                                         </tr>
                                     @endif
                                  </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- /.tab-pane -->
                     </div>
                  </div>
                  <!-- /.tab-content -->
               </div>
            </div>
         </div>
      </div>
   </form>
</section>

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

<script>
   $(document).ready(function(){
      $('select').select2();
      $('.pagination').addClass('pagination-sm no-margin pull-right');
      $('.checkme,.checkall').on('change',function(){
         if($(this).is(':checked'))
            $('#deleteall').fadeIn(300);
         else
            $('#deleteall').fadeOut(300);
      });

      /*function preview perubahan data*/
      $('ul#myTabs').on('click','a',function(e){
         e.preventDefault(e);
         var ket = $(this).attr('id');
         if(ket == 'biodata'){
           var tipe = 'post';
           var alamat = '{!!url()!!}/epersonal/biodata/data/perubahan_biodata_all/biodata';
         }else{
           var tipe = 'get';
           var alamat = '{!!url()!!}/epersonal/perubahanriwayat/'+ket+'detail/'+ket;
         }

         $.ajax({
             type: tipe,
             url : alamat,
             data: {'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
           beforeSend:function(){
                $('.modal-body').html('Looading..');
           },
             success:function(html){
                 $('#main_modal3 .modal-body').html(html);
             }
         });

      });

      /*function preview perubahan data*/
      $('.prevperubahan2').on('click', function(e){
          e.preventDefault(e);
          claravel_modal('Perubahan Riwayat KGB','Loading...','main_modal2');
          $.ajax({
             type:'post',
             url : '{!!url()!!}/epersonal/perubahanriwayat/data/rkgb_perubahan',
             data: {'id': $(this).attr('recid'), 'nip': $(this).attr('recnip'), 'flag': $(this).attr('recflag'), '_token' : '{!!csrf_token()!!}'},
             success:function(html){
                 $('#main_modal2 .modal-body').html(html);
             }
          });
      });

      /*function delete perubahan data*/
      $('.btlperubahan').on('click', function(e){
          e.preventDefault();
          var $this =$(this);
          bootbox.confirm('Batalkan perubahan data ?',function(a){
             if(a == true){
                 $.ajax({
                      url : '{!!url()!!}/epersonal/perubahanriwayat/btlperubahan',
                      type : 'post',
                      data: {'id' : $this.attr('recid'), 'tb':'r_kgb_temp', '_token' : '{!!csrf_token()!!}'},
                      beforeSend: function(){
                          preloader.on();
                      },
                      success:function(html){
                          preloader.off();
                          if(html==9){
                              notification('Data Berhasil Dibatalkan','success');
                              $this.closest('tr').fadeOut(300,function(){
                                  $(this).remove();
                              });
                          }else{
                              notification(html,'danger');
                          }
                      }
                 });
             }
          });
      });

      $('#buat').on('click',function(e){
          e.preventDefault();
          $.ajax({
             url : $(this).attr('href'),
             //url : laravel_base + '/' + $(this).attr('href'),
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

      <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
      ?>

      $('#tabel').on('click','#hapus',function(e){
          e.preventDefault();
          var $this =$(this);
          bootbox.confirm('Hapus?',function(a){
             if(a == true){
                 $.ajax({
                      url : index_page + '/delete',
                      type : 'post',
                      data: {'id' : $this.attr('recid'), '_token' : '{!!csrf_token()!!}'},
                      beforeSend: function(){
                          preloader.on();
                      },
                      success:function(html){
                          preloader.off();
                          if(html==9){
                              notification('Berhasil Dihapus','success');
                              $this.closest('tr').fadeOut(300,function(){
                                  $(this).remove();
                              });
                          }else{
                              notification(html,'danger');
                          }
                      }
                 });
             }
          });
      });

      $('#tabel').on('click','#edit',function(e){
          e.preventDefault();
          var $this =$(this);
          bootbox.confirm('Edit?',function(a){
             if(a == true){
                 $.ajax({
                      url : index_page + '/edit',
                      type : 'get',
                      data:'id=' + $this.attr('recid'),
                      beforeSend: function(){
                          preloader.on();
                      },
                      success:function(html){
                          preloader.off();
                          $('#utama').html(html);
                      }
                 });
             }
          });
      });
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
      $('#data').on('submit',function(e){
          e.preventDefault();
          var iki = $(this);
          bootbox.confirm('Hapus?',function(r){
             if(r){
                 $.ajax({
                      url : iki.attr('action') + '/delete',
                      type : 'post',
                      data:iki.serialize(),
                      beforeSend: function(){
                          preloader.on();
                      },
                      success:function(html){
                          preloader.off();
                          notification(html,'success');
                          iki.find('input[type=checkbox]').each(function (t){
                              if($(this).is(':checked')){
                                  $(this).closest('tr').fadeOut(100)
                              }
                          });
                          $('#deleteall').fadeOut(300);
                      }
                 });
             }
          });
      });

    });
</script>
