<?php
    $nip = Input::get('nip');
    $jenis = Input::get('jenis');
    $subjenis = Input::get('subjenis');
    $syarat = Input::get('syarat');

    $x = 0;
    $rs = callApi('get', 'http://10.5.2.131:2023/efile/myfile?jenis='.$jenis.'&subjenis='.$subjenis.'&nip='.$nip);

//echo $nip." - ".$jenis." - ".$subjenis." - ".$syarat;
//echo "<pre>";
//print_r($rs);
//echo "</pre>";
    $res = $rs->myfile;
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
            <?php
                $x++;
                $fileType = pathinfo($item->name, PATHINFO_EXTENSION);
            ?>
            <tr>
                <td width="5%" class="text-center">{!!$x!!}</td>
                @if($fileType == 'pdf')
                 <!-- <td width="35%"><a href="javascript:void(0)" class="prev-doc" nip="{!!$nip!!}" filename="{!!$item->name!!}" title="Preview Detail"><img src="{!!asset('packages/tugumuda/images/pdf.png')!!}"></a></td> -->
                <td width="35%"><a href="javascript:void(0)" class="prev-doc" nip="{!!$nip!!}" filename="{!!$item->name!!}" title="Preview Detail">{!!$item->jenis!!}</a></td>
                @else
                <td width="35%"><img class="gambar" src="{!!file_exists($item->thumbnailUrl)?$item->thumbnailUrl:asset('packages/tugumuda/images/img.png')!!}" link="{!!$item->url!!}"></td>
                @endif
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

<script type="text/javascript">
    $(function () {
        $('.gambar').click(function () {
            var img = $(this).attr('link');

            $('#modalPrev').html('<img src="'+img+'" width="650">');
            $('#main_modal4').modal('show');
        });

        $('.prev-doc').on('click', function(){
            var nip = $(this).attr('nip');
            var filename = $(this).attr('filename');
            $.ajax({
                url: '{!!url()!!}/epersonal/biodata/previewdoc',
                type: 'POST',
                data: 'nip='+nip+'&filename='+filename+'&_token={{csrf_token()}}',
            }).success(function (response) {
                    swal({
                        html: response,
                        showCloseButton: true,
                        width: '90%',
                        customClass: 'swal-wide',
                        showConfirmButton: false
                    })
                });
        });
    });
</script>
