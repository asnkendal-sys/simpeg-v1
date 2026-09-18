<?php
    $x = 0;
    $sts_kontrak = Input::get('sts_kontrak');
    switch ($sts_kontrak) {
        case 2:
            $kode = 42;
        break;
        case 3:
            $kode = 43;
        break;
        default:
            $kode = 0;
        break;
    }
    $rs = callApi('get', 'https://simpeg.kendalkab.go.id/efile/dokumenpersyaratan?id='.$kode.'&nip='.Input::get('nip'));
    $pegawai = getDetailpegawai(Input::get('nip'));
?>
<div class="row">
    <div class="col-md-4">
        <table class="table table-stripped">
            <tr>
                <td width="20%">NIP</td>
                <td width="3%">:</td>
                <td width="77%">{!! @$pegawai->nip !!}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{!! @$pegawai->namalengkap !!}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{!! @$pegawai->jabatan !!}</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td>{!! @$pegawai->skpd." ".((@$pegawai->skpd!=@$pegawai->unit)?@$pegawai->unit:'') !!}</td>
            </tr>            
        </table>
    </div>
    <div class="col-md-8">
        {{-- start  dokumen --}}
        <table class="table table-striped">
            <thead>
                <tr class="bg-primary">
                    <th width="5%">No</th>
                    <th width="35%">Dokumen Persyaratan</th>
                    <th width="10%">Jumlah</th>
                    <th width="10%">Preview</th>
                </tr>
            </thead>
            <tbody>            
                @if(count($rs) > 0)
                    @foreach($rs as $item)
                        <?php $x++;?>
                        @if(isset($item->jmlfile))
                        <tr>
                            <td width="5%" class="text-center">{!!$x!!}</td>
                            <td width="35%">{!!$item->syarat!!}</td>
                            <td width="10%" class="text-center">{!!$item->jmlfile!!}</td>
                            <td width="10%" class="text-center"><a href="javascript:void(0)" class="prefile btn btn-success" recjenis="{!!$item->jenis!!}" recsubjenis="{!!$item->subjenis!!}" recsyarat="{!!$item->syarat!!}"  recnip="{!!Input::get('nip')!!}"><i class="fa fa-search"></i> Preview</a></td>
                        </tr>
                        @else
                        <tr>
                            <td width="5%" class="text-center">{!!$x!!}</td>
                            <td width="35%" colspan="2">{!!$item->syarat!!}</td>
                            <td width="10%" class="text-center"><a href="javascript:void(0)" class="btn btn-default" onclick="bootbox.alert('Data belum tersedia.');"><i class="fa fa-search"></i> Preview</a></td>
                        </tr>
                        @endif
                    @endforeach()
                @else
                    <tr>
                        <td colspan="4">Data tidak ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        Keterangan : Berkas persyaratan dapat diupload melalui E-File</a> menu Manajemen Dokumen > Upload Hasil Scan Dokumen > Persyaratan Layanan.
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('a.prefile').on('click', function(e){
            e.preventDefault();
            claravel_modal('Preview Berkas Layanan','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/prefile',
                data: {'nip': $(this).attr('recnip'), 'jenis': $(this).attr('recjenis'), 'subjenis': $(this).attr('recsubjenis'), 'syarat': $(this).attr('recsyarat'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });
    })
</script>