<script type="text/javascript">
    $(document).ready(function(){
        $('#table-notifikasi input[name=idkategori]').on('change', function(e){
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                url : '{!!url()!!}/administrator/sistemnotifikasi/data/notifikasi_form',
                type : 'post',
                data: {'id' : id, '_token' : '{!!csrf_token()!!}'},
                beforeSend: function(){
                    $('#table-notifikasi #xpenerima').html("Looading");
                },
                success:function(html){
                    $('#table-notifikasi #xpenerima').html(html);
                }
            });
        });

        $('#form-penerima').on('submit',function(e){
            var $this = $(this);
            var formData = new FormData(this);
            e.preventDefault();
            bootbox.confirm('Update Penerima Notifikasi..?',function(a){
                if (a == true){
                    $.ajax({
                        type:'POST',
                        url: $this.attr('action'),
                        data:formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            if(html=='4'){
                                notification('Berhasil Disimpan','success');
                                claravel_modal_close('main_modal');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        },
                        error: function(html){
                        }
                    });
                }
            });
        });

        $('#table-notifikasi .pen-remove').on('click', function(e){
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('recid');
            var txt = $this.attr('rectxt');

            bootbox.confirm('Hapus Penerima dari "'+txt+'"...?',function(a){
                if(a == true){
                    $.ajax({
                        url: '{!!url()!!}/administrator/sistemnotifikasi/deletepenerima',
                        type : 'post',
                        data: {'id' : id, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.remove();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })
    })
</script>

<?php
    $id = Input::get('id');    
    $rs1 = SistemnotifikasiModel::getNotifikasi($id);
?>

{!! Form::open(array('url' => url().'/administrator/sistemnotifikasi/savepenerimanotif', 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-penerima')) !!}
    <input type="hidden" name="idnotifikasi" value="<?php echo $id ?>">
    <div class="row-fluid">
        <div class="span12">
            <table id="table-notifikasi" class="table" cellpadding="5" cellspacing="5" width="100%">
                <tr>
                    <td colspan="3"><h4 class="text-center">TAMBAH PENERIMA SISTEM NOTIFIKASI</h4></td>
                </tr>
                <tr>
                    <td width="25%">Judul</td>
                    <td class="text-center" width="2%"> : </td>
                    <td><?php echo $rs1->title?></td>
                </tr>
                <tr>
                    <td width="25%">Notifikasi</td>
                    <td class="text-center" width="2%"> : </td>
                    <td><?php echo $rs1->notification?></td>
                </tr>
                <tr>
                    <td>Rencana Publish</td>
                    <td class="text-center" width="2%"> : </td>
                    <td><?=$rs1->tgl_publish?></td>
                </tr>
                <tr>
                    <td valign="top">Kategori Penerima</td>
                    <td valign="top" class="text-center" width="2%"> : </td>
                    <td valign="top">
                        <input type="radio" class="idkategori" value="1" name="idkategori"> Semua Pegawai <br>
                        <input type="radio" class="idkategori" value="2" name="idkategori"> Berdasarkan OPD <br>
                        <input type="radio" class="idkategori" value="3" name="idkategori"> Pegawai Tertentu <br>
                        <input type="radio" class="idkategori" value="4" name="idkategori"> Upload Excel <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" id="xpenerima"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
                        <a class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">Penerima Notifikasi : </td>
                    <td>&nbsp;</td>
                    <td>
                        {!!SistemnotifikasiModel::getPenerima($id)!!}
                    </td>
                </tr>
            </table>
        </div> <!-- end of span5 -->
    </div>
</form>