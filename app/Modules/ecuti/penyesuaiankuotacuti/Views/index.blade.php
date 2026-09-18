<style type="text/css">table.tableheader td{padding: 5px;}</style>
<section class="content-header">
    <h1>
        Penyesuaian Kuota Cuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">penyesuaiankuotacuti</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
            {!!csrf_field()!!}
            <div class="col-lg-12 table-responsive">
                <table width="100%" id="tables" class="tableheader" >
                    <tr>
                        <td width="42%"><select name="nip" class="form-control" id="nip" style="width: 100%"></select></td>
                        <td width="50%">
                            {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                        </td>

                        <td class="" width="8%">
                            <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </td>
                    </tr>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
        <div id="result">
            
            <?php //echo View::make('penyesuaiankuotacuti::all_data', compact('penyesuaiankuotacutis')) ?>
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

    function getData() {
        var load = '<p id="load" class="text-center text-danger"><i class="fa fa-spinner fa-spin"></i> <strong><i>Loading...</i></strong></p>';
        $('#result').html(load);
        // $('#result #load').css('display', 'block');
        var xhr = $.ajax({
            url: '{{url()}}/ecuti/penyesuaiankuotacuti/alldata',
            type: 'get',
            beforeSend: function() {
                preloader.on();
            },
            success: function(response) {
                preloader.off();
                $('#result').html(response);
                $('.paginate-a li').click(function(e) {
                    e.preventDefault();
                    // console.log('a');
                    var href = $(this).find('a').attr('href');
                    console.log(href);
                    // $(this).attr('href', '');
                    $.ajax({
                        url: href,
                        type: 'get',
                        success: function(response) {
                            $('#result').html(response);
                        }
                    })
                })
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    
    $(document).ready(function(){
        $('select').select2();

        //getData();
        // $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
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
        })
        
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
        // $('#tabel').on('click','#edit',function(e){
        //     e.preventDefault();
        //     var $this =$(this);
        //     bootbox.confirm('Edit?',function(a){
        //         if(a == true){
        //             $.ajax({
        //                 url : index_page + '/edit',
        //                 type : 'get',
        //                 // data:'id=' + $this.attr('recid'),
        //                 data: {'id' : $this.attr('recid'),'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
        //                 beforeSend: function(){
        //                     preloader.on();
        //                 },
        //                 success:function(html){
        //                     preloader.off();
        //                     $('#utama').html(html);
        //                 }
        //             });
        //         }
        //     });
        // });
        $('#cari').on('submit',function(e){
            var load = '<p id="load" class="text-center text-danger"><i class="fa fa-spinner fa-spin"></i> <strong><i>Loading...</i></strong></p>';
            $('#result').html(load);
            e.preventDefault();
            $.ajax({
                // url : $(this).attr('action'),
                url: '{{url()}}/ecuti/penyesuaiankuotacuti/alldata',
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                    // xhr.abort();
                    // console.log(xhr.abort());
                },
                success:function(html){
                    preloader.off();
                    window.stop();
                    // $('#utama').html(html);
                    $('#result').html(html);
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
                    })
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
        autoCompleteimg('#nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '{!!Input::get("id")!!}', '{!!Input::get("id")!!}', '');
    });
</script>
