<section class="content-header">
    <h1>
        Penjadwalan KP<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Penjadwalan KP</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! ClaravelHelpers::btnCreate() !!}
        </div>
        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        {!!csrf_field()!!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <!-- content -->
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th><div class="text-center">NO</div></th>
                        <th><div class="text-center">PERIODE TAHUN</div></th>
                        <th><div class="text-center">PERIODE BULAN</div></th>
                        <th><div class="text-center">AWAL PENGUSULAN</div></th>
                        <th><div class="text-center">AKHIR PENGUSULAN</div></th>
                        <th><div class="text-center">KETERANGAN</div></th>
                        @if(session('role_id') <= '2')
                        <th align="center">AKSI</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                        <?php $n = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0; ?>
                        @foreach ($penjadwalankps as $item)
                        <?php $n++; ?>
                        <tr>
                            <td>{!!$n!!}</td>
                            <td>{!!$item->tahun!!}</td>
                            <td>{!!formatBulan($item->bulan)!!}</td>
                            <td>{!!$item->mulai!!}</td>
                            <td>{!!$item->selesai!!}</td>
                            <td>{!!$item->keterangan!!}</td>
                            @if(session('role_id') <= '2')
                            <td>
                                {!! ClaravelHelpers::btnEdit($item->id) !!}<br>
                                {!! ClaravelHelpers::btnDelete($item->id) !!}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end content -->
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              <!-- {!! ClaravelHelpers::btnDeleteAll() !!} -->
            </div>
            <div class="col-sm-6">
            </div>
          </div>
        </div>
        {!! Form::close() !!}
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
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
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
                            if(html=='9'){
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

       
    });
</script>
