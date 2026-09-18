<?php
    use App\Models\SinkronisasiModel;
    $siasn = new SinkronisasiModel();
    /*diisi query menampilkan data dari sapk SIASN*/
    $x = 0;
    $bkn = accessDatariwayatsiasn('pns/rw-kursus',$nip);
?>

@if(count($bkn) > 0)
    @foreach($bkn as $item)
        @if(($item->jenisKursusSertifikat != 'DIKLAT FUNGSIONAL') AND ($item->jenisKursusSertifikat != 'DIKLAT TEKNIS'))
        <?php $x++;?>
        <tr>
            <td align="center">{!!$x!!}.</td>
            <td>{!!$item->tahunKursus!!}</td>
            <td>{!!$item->namaKursus!!}</td>
            <td>{!!$item->institusiPenyelenggara!!}</td>
            <td>{!!$item->tanggalKursus!!}</td>
            <td>{!!$item->jumlahJam!!}</td>
            <td>{!!$item->noSertipikat!!}</td>
            <td class="text-center">
            @if($siasn->fileSiasn($item->path) != '')
                <?php
                    /*$mode = 'prod';
                    if ($mode == 'train') {
                        $base_url = 'https://training-apimws.bkn.go.id:8243/api/1.0/';
                    } else if ($mode == 'prod') {
                        $base_url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/';
                    }

                    $resultApi = apiResult($base_url.'download-dok?filePath='.$siasn->fileSiasn($item->path));
                    $nama_file_unduhan = 'packages/upload/file/'.$nip.'-'.strtolower($item->namaKursus).'.pdf';
                    file_put_contents($nama_file_unduhan, $resultApi);*/
                ?>
                <a class="text-info btn btn-success" href="{!!url().'/syncprevfile/kursus/'.$nip.'/'.$item->id.'/'.$siasn->clean($item->namaKursus)!!}" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> Download File</a>
            @else
                Dokumen Tidak Tersedia
            @endif
            </td>
            <td class="text-center">
                @if(cekBkn($item->id, 'r_seminar'))
                    <i class="fa fa-check-square-o" title="Sudah Tersinkronisasi"></i> Sudah Sinkron
                @else
                    <a class="text-info actsinkronsiasn btn btn-warning syncomsiasn" recid="x" idbkn="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
                @endif
            </td>
        </tr>
        @endif
    @endforeach

    @if($x == 0)
    <tr>
        <td colspan="8">Riwayat Seminar SIASN belum tersedia.</td>
    </tr>
    @endif
@else
    <tr>
        <td colspan="8">Riwayat Seminar SIASN belum tersedia.</td>
    </tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.syncomsiasn').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var idseminarbkn = $(this).attr('idbkn');
            /*bootbox.confirm("Sinkronisasi data SIASN ?", function(confirmed) {*/
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rseminar_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idseminarbkn': idseminarbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
            /*});*/
        });
    })
</script>