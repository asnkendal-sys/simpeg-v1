<?php
    use App\Models\SinkronisasiModel;
    $siasn = new SinkronisasiModel();
    /*diisi query menampilkan data dari sapk SIASN*/
    $x = 0;
    $bkn = accessDatariwayatsiasn('pns/rw-skp22',$nip);
?>

@if(count($bkn) > 0)
@foreach($bkn as $item)
<?php $x++;?>
<tr>
    <td align="center">{!!$x!!}.</td>
    <td>{!!$item->tahun!!}</td>
    <td>{!!$item->hasilKinerjaNilai." | ".$item->hasilKinerja!!}</td>
    <td>{!!$item->PerilakuKerjaNilai." | ".$item->perilakuKerja!!}</td>
    <td>{!!$item->KuadranKinerjaNilai." | ".$item->kuadranKinerja!!}</td>
    <td>{!!$item->namaPenilai!!}</td>
    <td>{!!$item->penilaiJabatanNm!!}</td>
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
        <a class="text-info btn btn-success" href="{!!url().'/syncprevfile/skp22/'.$nip.'/'.$item->id.'/'.$siasn->clean($item->tahun)!!}" target="_blank"><i class="fa fa-download"></i> Download File</a>
    @else
        Dokumen Tidak Tersedia
    @endif
    </td>
    <td class="text-center">
        @if(cekBkn($item->id, 'r_kinerjaasn'))
            <i class="fa fa-check-square-o" title="Sudah Tersinkronisasi"></i> Sudah Sinkron
        @else            
            <a class="text-info actsinkronsiasn btn btn-warning syncomsiasn" recid="x" idbkn="{!!$item->id!!}" href="javascript:void(0)"><i class="fa fa-repeat"></i> Sinkronisasi</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="8">Riwayat Penilaian Prilaku Kerja Pegawai SIASN belum tersedia.</td>
</tr>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.syncomsiasn').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('recid');
            var idskpbkn = $(this).attr('idbkn');
            /*bootbox.confirm("Sinkronisasi data SIASN ?", function(confirmed) {*/
            claravel_modal('Sinkronisai SIASN','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/sinkronsiasn/rskp22_sinkronsiasn_form',
                data: {'nip': $('#nip').val(), 'id': id, 'idskpbkn': idskpbkn, 'flag':2, '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
            /*});*/
        });
    })
</script>