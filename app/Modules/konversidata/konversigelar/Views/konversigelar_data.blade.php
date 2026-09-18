
<div class="alert {!!$alert!!} alert-biodata" role="alert" style="display: block;">
    <span class="fa fa-dropbox" aria-hidden="true"></span>
    DETAIL {!!$title!!}
</div>

<div class="row">
    <div class="col-xs-7">
        <table>
            <tr>
                <td width='45%'>Nama File</td>
                <td width='5%'> : </td>
                <td width='50%'><a href="{!!url().'/packages/upload/excel/gelar/'.$attr->filename!!}" target="_blank">{!!$attr->filename_original!!}</a></td>
            </tr>
            <tr>
                <td>Lama Konversi</td>
                <td>: </td>
                <td>{!!round($attr->waktu, 3)!!} Menit</td>
            </tr>
            <tr>
                <td>Tanggal Konversi</td>
                <td>: </td>
                <td>{!!date('d-m-Y H:i:s',strtotime($attr->created_at))!!}</td>
            </tr>
        </table><br>
    </div>
    <div class="col-xs-5">
        <div align="right">
            <form action="{!!url()!!}/konversidata/konversigelar/excel/konversigelar" id="form-hasil" method="post" target="_blank">
                {!!csrf_field()!!}
                <input type="hidden" name="file" value="{!!Input::get('file')!!}">
                <input type="hidden" name="status" value="{!!Input::get('status')!!}">
                <button type="submit" title="Download Hasil Konversi" class="btn {!!$alert!!}" id="download-konversi"><i class="fa fa-file-excel-o"></i> HASIL {!!$title!!}</a>
            </form>
        </div>
    </div>
</div>

<table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
    <thead class="bg-primary">
        <tr>
            <td>id</td>
            <td>niplama</td>
            <td>nip</td>
            <td>gdp</td>
            <td>gdb</td>
        </tr>
    </thead>
    <tbod>        
        @foreach($rs as $item)        
        <tr>
            <td>{!!$item->id_konversi!!}</td>
            <td>{!!$item->niplama!!}</td>
            <td>{!!$item->nip!!}</td>
            <td>{!!$item->gdp!!}</td>
            <td>{!!$item->gdb!!}</td>
        </tr>
        @endforeach
    </tbod>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        $('#download-konversi').on('click', function(e){
            e.preventDefault();            
            $('#form-hasil').submit();
        });        
    });
</script>