<?php
    $bulan = Input::get('bulan');
    $tahun = Input::get('tahun');

    $rsopd = \DB::table('a_skpd')
        ->select('a_skpd.skpd','a_skpd.idskpd', 'tr_kgb_ledger.tahun', 'tr_kgb_ledger.bulan', 'tr_kgb_ledger.file')
        ->leftJoin('tr_kgb_ledger', function($join)use($bulan,$tahun){
            $join->on('a_skpd.idskpd', '=', 'tr_kgb_ledger.idskpd')
                ->where('tr_kgb_ledger.bulan','=',$bulan)
                ->where('tr_kgb_ledger.tahun','=',$tahun);
        })
        ->where('a_skpd.idparent', '')->orWhere('a_skpd.issatker', 1)
        ->orderBy('a_skpd.skpd')->get();
?>
<div style="max-height: 350px; overflow-y: scroll;">
    <table class="table">
        <tr class="bg-primary">
            <th width="5%">NO</th>
            <th class="text-left">PILIHAN UNIT KERJA</th>
            <th width="10%">AKSI</th>
        </tr>
        <?php $x = 0;?>
        @foreach($rsopd as $item)
        <?php $x++;?>
        <tr>
            <td class="text-center">{!!$x!!}</td>
            <td class="text-left">{!!$item->skpd!!}</td>
            <td class="text-center">
                @if($item->file != '')
                <a href="javascript:void(0)" title="Preview File Pendukung" class="prevfile" recidskpd="{!!$item->idskpd!!}" recbulan="{!!$bulan!!}" rectahun="{!!$tahun!!}">
                    <div class="mybutton">
                        <i class="fa fa-search"></i> Preview
                    </div>
                </a>
                @else
                <div class="mybutton">
                    <input type="file" class="myfile" name="upload" recidskpd="{!!$item->idskpd!!}" recbulan="{!!$bulan!!}" rectahun="{!!$tahun!!}" title=".pdf" accept=".pdf"/>
                    <i class="fa fa-cloud-upload"></i> Upload
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div><br/>

<script type="text/javascript">
    $(document).ready(function(){
        $('.myfile').change(function(e) {
            e.preventDefault();
            var form_data = new FormData();
            var idskpd = $(this).attr('recidskpd');
            var tahun = $(this).attr('rectahun');
            var bulan = $(this).attr('recbulan');
            var file_data = $(this).prop('files')[0];
            bootbox.confirm('Simpan Ledger Gaji ?',function(a){
                if(a == true){
                    form_data.append('file', file_data);
                    form_data.append('idskpd', idskpd);
                    form_data.append('tahun', tahun);
                    form_data.append('bulan', bulan);
                    form_data.append('_token', '{!!csrf_token()!!}');
                    $.ajax({
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/uploadfile',
                        type : 'post',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
                            if(html==4){
                                notification('Berhasil Diupload','success');
                                $('#led_bulan, #led_tahun').trigger('change');
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('a.prevfile').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview File','Loading...','main_modal');

            preview($(this).attr('recidskpd'), $(this).attr('recbulan'), $(this).attr('rectahun'));
        });
    });

    function preview(idskpd, bulan, tahun){
        $.ajax({
            type: 'post',
            url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/ledgergajiview',
            data: {'idskpd': idskpd, 'bulan': bulan, 'tahun': tahun, '_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    }
</script>

<style type="text/css">
    div.mybutton {

        /* IMPORTANT STUFF */
        overflow: hidden;
        position: relative;
        cursor:   pointer;

        /* SOME CUSTOM STYLING */
        width:  80px;
        padding: 7px;
        text-align: center;
        border: 1px solid green;
        font-weight: bold
        background: red;
    }

    div.mybutton:hover {
        background: green;
    }


    input.myfile {
        height: 20px;
        cursor: pointer;
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 100px;
        z-index: 2;

        opacity: 0.0; /* Standard: FF gt 1.5, Opera, Safari */
        filter: alpha(opacity=0); /* IE lt 8 */
        -ms-filter: "alpha(opacity=0)"; /* IE 8 */
        -khtml-opacity: 0.0; /* Safari 1.x */
        -moz-opacity: 0.0; /* FF lt 1.5, Netscape */
    }
</style>