<style>
    .paginate-a {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }

    .paginate-a > li {
        display: inline;
    }

    .paginate-a>.active>a, .paginate-a>.active>a:focus, .paginate-a>.active>a:hover, .paginate-a>.active>span, .paginate-a>.active>span:focus, .paginate-a>.active>span:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }

    .pagination>li:first-child>a, .pagination>li:first-child>span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    
    .paginate-a > li > a {
        background: #fafafa;
        color: #666;
    }

    .paginate-a > li > a, .paginate-a > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
</style>
{!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                        <tr>
                            <th width="3%">NO</th>
                            <th>NIP</th>
                            <th>Hari Kerja</th>
                            <th>Cuti Tahunan</th>
                            <th>Cuti Besar</th>
                            <th>Cuti Sakit</th>
                            <th>Cuti Melahirkan</th>
                            <th>Cuti Alasan Penting</th>
                            <th>CLTN</th>
                            <th width="7%">Act.</th>
                        </tr>
                    </thead>   
                        <!-- {-- {{Session::get('role_id')}} --} -->
                    <tbody>
                        @foreach ($penyesuaiankuotacutis as $no =>  $penyesuaiankuotacuti)
                        <tr>
                            <td class="text-right">{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</td>
                            <td>{!!$penyesuaiankuotacuti->nip!!}<br>{!!$penyesuaiankuotacuti->namalengkap!!}</td>
                            <td class="text-center" style="vertical-align: middle;">{!!$penyesuaiankuotacuti->hari_kerja!!}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if($penyesuaiankuotacuti->k_tahunan_n2 !=0 ||$penyesuaiankuotacuti->k_tahunan_n1 !=0 || $penyesuaiankuotacuti->k_tahunan_n!=0)
                                {!! ($penyesuaiankuotacuti->k_tahunan_n2+$penyesuaiankuotacuti->k_tahunan_n1+$penyesuaiankuotacuti->k_tahunan_n) !!} Hari</td>
                                @endif
                                <td class="text-center" style="vertical-align: middle;">
                                    {!! ($penyesuaiankuotacuti->k_besar_bulan!=0)?$penyesuaiankuotacuti->k_besar_bulan." Bulan":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_besar_hari!=0)?$penyesuaiankuotacuti->k_besar_hari." Hari":"" !!}
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    {!! ($penyesuaiankuotacuti->k_sakit_tahun!=0)?$penyesuaiankuotacuti->k_sakit_tahun." Tahun":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_sakit_bulan!=0)?$penyesuaiankuotacuti->k_sakit_bulan." Bulan":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_sakit_hari!=0)?$penyesuaiankuotacuti->k_sakit_hari." Hari":"" !!}
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    {!! ($penyesuaiankuotacuti->k_lahir_bulan!=0)?$penyesuaiankuotacuti->k_lahir_bulan." Bulan":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_lahir_hari!=0)?$penyesuaiankuotacuti->k_lahir_hari." Hari":"" !!}
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    {!! ($penyesuaiankuotacuti->k_penting_bulan!=0)?$penyesuaiankuotacuti->k_penting_bulan." Bulan":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_penting_hari!=0)?$penyesuaiankuotacuti->k_penting_hari." Hari":"" !!}
                                </td>

                                <td class="text-center" style="vertical-align: middle;">
                                    {!! ($penyesuaiankuotacuti->k_cltn_tahun!=0)?$penyesuaiankuotacuti->k_cltn_tahun." Tahun":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_cltn_bulan!=0)?$penyesuaiankuotacuti->k_cltn_bulan." Bulan":"" !!}
                                    {!! ($penyesuaiankuotacuti->k_cltn_hari!=0)?$penyesuaiankuotacuti->k_cltn_hari." Hari":"" !!}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="caret"></span> Aksi
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="javascript:void(0)" class="text-info" id="edit" 
                                                recid="{!!$penyesuaiankuotacuti->id!!}" 
                                                recnip="{!!$penyesuaiankuotacuti->nip!!}">
                                                <i class="fa fa-pencil"></i>Penyesuaian Kuota
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer clearfix">
              <div class="row">
                <div class="col-sm-6">
                  {!! ClaravelHelpers::btnDeleteAll() !!}
              </div>
              <div class="col-sm-6">
                  <?php echo $penyesuaiankuotacutis->appends(array('nip' => Input::get('nip'),'idskpd' => Input::get('idskpd'),'search' => Input::get('search')))->render(); ?>
                
                  <?php //echo $penyesuaiankuotacutis->render(); ?>
              </div>
          </div>
      </div>
      {!! Form::close() !!}
    
<script>
    $(document).ready(function() {
        <?php
            echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('.pagination').addClass('pagination-sm no-margin pull-right paginate-a');
        $('.paginate-a').removeClass('pagination');

        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        // url : index_page + '/edit',
                        url : '{{url()}}/ecuti/penyesuaiankuotacuti/edit',
                        type : 'get',
                        // data:'id=' + $this.attr('recid'),
                        data: {'id' : $this.attr('recid'),'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
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
        
        $('.paginate-a li').click(function(e) {
            e.preventDefault();
            // e.stopPropagation();
            var href = $(this).find('a').attr('href');
            console.log(href);
            $.ajax({
                url: href,
                type: 'get',
                success: function(response) {
                    $('#result').html(response);
                }
            })
        });
    })
</script>