<section class="content-header">
    <h1>
        Upload SK Pensiun<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Uploadskpensiun</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Upload Files (PDF/JPG)</h4>
                </div>
                <div class="card-body">
                    <form id="upload" action="{!!url()!!}/epensiun/nominatifpensiun/uploadfiles" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="files">Choose Files:</label>
                            <input type="file" name="filenames[]" id="files" class="form-control" accept=".pdf,.jpg,.jpeg" multiple required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <table border="0" width="100%" class="table-responsive table table-striped table-hover table-condensed table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>File Terupload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>
                            @if($pegawai->file_pensiun)
                                <!-- Jika file adalah PDF -->
                                @if(pathinfo($pegawai->file_pensiun, PATHINFO_EXTENSION) == 'pdf')
                                    <a href="{{ asset('public/pensiun/' . $pegawai->file_pensiun) }}" target="_blank">Lihat PDF</a>
                                <!-- Jika file adalah gambar (JPG/JPEG) -->
                                @elseif(in_array(pathinfo($pegawai->file_pensiun, PATHINFO_EXTENSION), ['jpg', 'jpeg']))
                                    <img src="{{ asset('public/pensiun/' . $pegawai->file_pensiun) }}" alt="File Pensiun" width="100">
                                @else
                                    {{ $pegawai->file_pensiun }}
                                @endif
                            @else
                                Tidak ada file
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
                url : $(this).attr('action') + '/uploadFiles',
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
