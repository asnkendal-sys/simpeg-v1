
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
                <td width='50%'><a href="{!!url().'/packages/upload/excel/rpppk/'.$attr->filename!!}" target="_blank">{!!$attr->filename_original!!}</a></td>
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
            <form action="{!!url()!!}/konversidata/riwayatpppk/excel/konversipppk" id="form-hasil" method="post" target="_blank">
                {!!csrf_field()!!}
                <input type="hidden" name="file" value="{!!Input::get('file')!!}">
                <input type="hidden" name="status" value="{!!Input::get('status')!!}">
                <button type="submit" title="Download Hasil Konversi" class="btn {!!$alert!!}" id="download-konversi"><i class="fa fa-file-excel-o"></i> HASIL {!!$title!!}</a>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <div class="box-body no-padding">
        <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
            <thead class="bg-primary">
                <tr>
                    <td>id</td>
                    <td>niplama</td>
                    <td>nip</td>
                    <td>nipbaru</td>
                    <td>idjab</td>
                    <td>jab</td>
                    <td>kdunit</td>
                    <td>idskpd</td>
                    <td>skpd</td>
                    <!-- <td>tmtjab</td> -->
                    <td>idjenjab</td>
                    <td>idesl</td>
                    <td>nosk</td>
                    <td>tgsk</td>
                    <td>nopak</td>
                    <td>pejmen</td>
                    <td>iskepsek</td>
                    <td>idkepsek</td>
                    <td>tmtkepsek</td>
                    <td>noskkepsek</td>
                    <td>idtugasdokter</td>
                    <td>idtugasgurudosen</td>
                    <td>idmatkulpel</td>
                    <td>matkulpel</td>
                    <td>isdiperbantukan</td>
                    <td>iddiperbantukan</td>
                    <!-- <td>idesljbt</td> -->
                    <td>esl</td>
                    <td>iddesa</td>
                    <td>nmadesa</td>
                    <td>user_id</td>
                    <td>role_id</td>
                    <td>created_at</td>
                    <td>updated_at</td>
                </tr>
            </thead>
            <tbod>
                @foreach($rs as $item)
                <tr>
                    <td>{!!$item->id_konversi!!}</td>
                    <td>{!!$item->niplama!!}</td>
                    <td>{!!$item->nip!!}</td>
                    <td>{!!$item->nipbaru!!}</td>
                    <td>{!!$item->idjab!!}</td>
                    <td>{!!$item->jab!!}</td>
                    <td>{!!$item->kdunit!!}</td>
                    <td>{!!$item->idskpd!!}</td>
                    <td>{!!$item->skpd!!}</td>
               
                    <td>{!!$item->idjenjab!!}</td>
                    <td>{!!$item->idesl!!}</td>
                    <td>{!!$item->nosk!!}</td>
                    <td>{!!$item->tgsk!!}</td>
                    <td>{!!$item->nopak!!}</td>
                    <td>{!!$item->pejmen!!}</td>
                    <td>{!!$item->iskepsek!!}</td>
                    <td>{!!$item->idkepsek!!}</td>
                    <td>{!!$item->tmtkepsek!!}</td>
                    <td>{!!$item->noskkepsek!!}</td>
                    <td>{!!$item->idtugasdokter!!}</td>
                    <td>{!!$item->idtugasgurudosen!!}</td>
                    <td>{!!$item->idmatkulpel!!}</td>
                    <td>{!!$item->matkulpel!!}</td>
                    <td>{!!$item->isdiperbantukan!!}</td>
                    <td>{!!$item->iddiperbantukan!!}</td>
                    
                    <td>{!!$item->esl!!}</td>
                    <td>{!!$item->iddesa!!}</td>
                    <td>{!!$item->nmadesa!!}</td>
                    <td>{!!$item->user_id!!}</td>
                    <td>{!!$item->role_id!!}</td>
                    <td>{!!$item->created_at!!}</td>
                    <td>{!!$item->updated_at!!}</td>
                </tr>
                @endforeach
            </tbod>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#download-konversi').on('click', function(e){
            e.preventDefault();            
            $('#form-hasil').submit();
        });        
    });
</script>