<?php
    /*diisi query menampilkan data dari sapk SIASN*/
    $x = 0;
    $bkn = accessDatariwayatsiasn('pns/data-anak',$nip);
?>

@if(count($bkn->listAnak) > 0)
    @foreach($bkn->listAnak as $item)
        <?php $x++;?>
        <tr>
            <td align="center">{{$x}}.</td>
            <td>{{$item->nama}}</td>
            <td>{{$item->tempatLahir}}</td>
            <td>{{date('d-m-Y', strtotime($item->tglLahir))}}</td>
            <td>{{getJenkelBkn($item->jenisKelamin)}}</td>
            <td>{{getStatusAnakBkn($item->jenisAnak)}}</td>
            <td class="text-center">
                @if(cekBkn($item->id, 'r_anak'))
                    <i class="fa fa-check-square-o" title="Sudah Tersinkronisasi"></i>
                @else
                    <a class="text-info actsinkronsiasn btn btn-warning syncomsiasn" recid="x" idbkn="{{$item->id}}" href="javascript:void(0)"><i class="fa fa-search"></i> Sanding Data</a>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Riwayat Anak SIASN belum tersedia.</td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.syncomsiasn').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var idanakbkn = $(this).attr('idbkn');
            /*bootbox.confirm("Sinkronisasi data SIASN ?", function(confirmed) {*/
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{{url()}}/sinkronsiasn/ranak_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idanakbkn': idanakbkn, 'flag':2, '_token' : '{{csrf_token()}}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
            /*});*/
        });
    })
</script>