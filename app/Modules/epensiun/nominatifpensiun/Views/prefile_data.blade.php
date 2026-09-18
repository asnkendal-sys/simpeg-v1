<?php
    $nip = Input::get('nip');
    $nama = Input::get('nama');
    $jenis = Input::get('jenis');
    $subjenis = Input::get('subjenis');
    $syarat = Input::get('syarat');

    $x = 0;
    $rs = callApi('get', 'https://simpeg.kendalkab.go.id/efile/myfile?jenis='.$jenis.'&subjenis='.$subjenis.'&nip='.$nip);
    $res = $rs->myfile;
    // dd($res);
?>

<b>{!!strtoupper($syarat)!!}</b>
<table class="table table-striped">
    <thead>
    <tr class="bg-primary">
        <th width="5%">No</th>
        <th width="35%" class="text-left">Preview</th>
        <!--<th width="10%">Nama File</th>-->
        <th width="10%">Jenis</th>
    </tr>
    </thead>
    <tbody>
        @if(count($res) > 0)
            @foreach($res as $item)
            <?php $x++;?>
            <tr>
                <td width="5%" class="text-center">{!!$x!!}</td>
                <td width="35%"><img class="gambar" src="{!!$item->thumbnailUrl!!}" link="{!!$item->url!!}"></td>
                <!--<td width="10%" class="text-center">{!!$item->name!!}</td>-->
                <td width="10%" class="text-center">{!!$item->jenis!!}</td>
            </tr>
            @endforeach()
        @else
        <tr>
            <td colspan="3">Data tidak ditemukan</td>
        </tr>
        @endif
    </tbody>
</table>
<a class="btn btn-success" style="float: right;" id="download" href="https://simpeg.kendalkab.go.id/efile/cetakdokumen?nip=<?=$nip?>&nama=<?=$nama?>&jenis=<?=$jenis?>&subjenis=<?=$subjenis?>&subsubjenis=undefined&jenisdokumen=undefined&ident=">Download</a>

<script type="text/javascript">
    $(function () {
        $('.gambar').click(function () {
            var img = $(this).attr('link');

            $('#modalPrev').html('<img src="'+img+'" width="650">');
            $('#main_modal4').modal('show');
        });
    }); 
</script>
