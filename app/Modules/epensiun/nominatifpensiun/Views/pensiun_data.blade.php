<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $(".datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".date").mask("99-99-9999");

        $('#form-pensiun .xpensiun').hide();
        $('#form-pensiun #idjenkedudupeg').change(function(e){
            e.preventDefault();
            var idjenkedudupeg = $('#form-pensiun #idjenkedudupeg').val();
            if((idjenkedudupeg == 99) || (idjenkedudupeg == 21)){
                $('#form-pensiun .xpensiun').fadeIn();
            }else{
                $('#form-pensiun .xpensiun').fadeOut();
            }
        }).trigger('change');

        $('#form-pensiun').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan Data ?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if((html=='1') || (html=='4')){
                                notification('Simpan Data Berhasil','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');

                                if(($('#cari #bulan1').val() === '01') && ($('#cari #bulan2').val() === '01') && ($('#cari #tahun').val() === '2011')){
                                    refresh_page();
                                }else{
                                    $('#cari').trigger('submit');
                                }
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    })
</script>

<?php
    $item = getDetailpegawai(Input::get('nip'));

    $pict = "default.jpg";
    if(file_exists("./packages/upload/photo/pegawai/".$item->photo)){
        $pict = $item->photo;
    }else {
        $pict = "default.jpg";
    }
?>
<form action="{{url()}}/epersonal/entripensiun/pensiun" name="form-pensiun" id="form-pensiun" method="post">
<input type="hidden" value="{!!csrf_token()!!}" name="_token">
<table class="table table-striped table-hover table-condensed">
    <tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">LOKASI KERJA</div></td></tr>
    <tr>
        <td width="">UNIT KERJAa</td>
        <td width="">:</td>
        <td width="">{!!$item->unit!!}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="">SUB UNIT KERJA</td>
        <td width="">:</td>
        <td width="">{!!$item->skpd!!}</td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">IDENTITAS PEGAWAI</div></td></tr>
    <tr>
        <td width="250">NIP</td>
        <td width="5">:</td>
        <td width="">{!!$item->nip!!}</td>
        <td width="150" rowspan="6"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}" width="130" height="170"></td>
    </tr>
    <tr>
        <td width="">NAMA</td>
        <td width="">:</td>
        <td width="">{!!$item->namalengkap!!}</td>
    </tr>
    <tr>
        <td width="">TEMPAT LAHIR</td>
        <td width="">:</td>
        <td width="">{!!$item->tmlhr!!}</td>
    </tr>
    <tr>
        <td width="">TANGGAL LAHIR</td>
        <td width="">:</td>
        <td width="">{!!$item->tglhr!!}</td>
    </tr>
    <tr>
        <td width="">JENIS KELAMIN</td>
        <td width="">:</td>
        <td width="">{!!$item->jenkel!!}</td>
    </tr>
    <tr>
        <td width="">AGAMA</td>
        <td width="">:</td>
        <td width="">{!!$item->agama!!}</td>
    </tr>
    <tr>
        <td width="">STATUS PEGAWAI</td>
        <td width="">:</td>
        <td width="">{!!$item->stspeg!!}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="">JENIS KEPEGAWAIAN</td>
        <td width="">:</td>
        <td width="">{!!$item->jenkepeg!!}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="">STATUS PERKAWINAN</td>
        <td width="">:</td>
        <td width="">{!!$item->stskawin!!}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="">KEDUDUKAN PEGAWAI</td>
        <td width="">:</td>
        <td width="">{!!$item->jenkedudupeg!!}</td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td width="">ALAMAT</td>
        <td width="">:</td>
        <td width="">{!!$item->alm.', '.$item->almkdpos!!}</td>
        <td>&nbsp;</td>
    </tr>

    <tr><td colspan="4" bgcolor="lightblue"><div style="font-weight: bold; font-size: 14px;">PENETAPAN PENSIUN</div></td></tr>

    <input type="hidden" name="nip" value="{{Input::get('nip')}}">
    <tr>
        <td width="">TMT Pensiun</td>
        <td width="">:</td>
        <td colspan="2">
            <div class='input-group datepicker'>
                {!! Form::text('tmtpens', ($item->tmtpens!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpens)):date('d-m-Y'), array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </td>
    </tr>
    <tr>
        <td width="">Kedudukan Pegawai</td>
        <td width="">:</td>
        <td width="" colspan="2">{!! comboJenkedudupeg("idjenkedudupeg",$item->idjenkedudupeg,"",1) !!}</td>
    </tr>
    <tr class="xpensiun">
        <td width="">Pilih Jenis Pensiun *</td>
        <td width="">:</td>
        <td width="" colspan="2">{!! comboJenpens("idjenpens",$item->idjenpens,"") !!}</td>
    </tr>
    <tr class="xpensiun">
        <td width="">No. SK Pensiun *</td>
        <td width="">:</td>
        <td width="" colspan="2">{!! Form::text('noskpens', ($item->noskpens!='')?$item->noskpens:'', array('class'=> 'form-control', 'placeholder'=> 'NO. SK')) !!}</td>
    </tr>
    <tr class="xpensiun">
        <td width="">Tgl. SK Pensiun *</td>
        <td width="">:</td>
        <td width="" colspan="2">
            <div class='input-group datepicker'>
                {!! Form::text('tglskpens', ($item->tglskpens!='0000-00-00')?date('d-m-Y', strtotime($item->tglskpens)):date('d-m-Y'), array('class'=> 'form-control date', 'placeholder'=> 'dd-mm-yyyy')) !!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </td>
    </tr>
    <tr class="xpensiun">
        <td width="">Nama Jabatan Penetap *</td>
        <td width="">:</td>
        <td width="" colspan="2">{!! comboPenetapsk("jbtpenetapens",$item->jbtpenetapens,"") !!}</td>
    </tr>
    <tr class="xpensiun">
        <td colspan="4"><em>* Diisi ketika SK Pensiun sudah keluar</em></td>
    </tr>
    <tr>
        <td colspan="2"><em>* Jika SK Pensiun belum keluar Status Kedudukan Pegawai : <b>Aktif</b> & cukup isikan <b>TMT Pensiun</b> saja.</em></td></td>
        <td width="35%" colspan="2">
            <button class="btn btn-success" type="submit"><i class="fa fa-graduation-cap"></i> Simpan</button>
            <button class="btn btn-warning" type="button" onclick="claravel_modal_close('main_modal')"><i class="fa fa-times-circle"></i> Batalkan</button>
        </td>
    </tr>
</table>
</form>

