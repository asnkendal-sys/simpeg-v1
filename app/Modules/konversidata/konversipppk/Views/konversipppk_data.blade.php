
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
                <td width='50%'><a href="{!!url().'/packages/upload/excel/cpns/'.$attr->filename!!}" target="_blank">{!!$attr->filename_original!!}</a></td>
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
            <form action="{!!url()!!}/konversidata/konversicpns/excel/konversicpns" id="form-hasil" method="post" target="_blank">
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
                    <td>no</td>
                    <td>nip</td>
                    <td>nama</td>
                    <td>gdp</td>
                    <td>gdb</td>
                    <td>tmlhr</td>
                    <td>tglhr</td>
                    <td>idjenkel</td>
                    <td>idagama</td>
                    <td>alm</td>
                    <td>idstskawin</td>
                    <td>idgolrucpn</td>
                    <td>mkthncpn</td>
                    <td>mkblncpn</td>
                    <td>tmtcpn</td>
                    <td>tgskcpn</td>
                    <td>idtkpendid</td>
                    <td>idjenjurusan</td>
                    <td>noijaz</td>
                    <td>thijaz</td>
                    <td>idtkpendidawal</td>
                    <td>idjenjurusanawal</td>
                    <td>noijazawal</td>
                    <td>thijazawal</td>
                    <td>idjabfung</td>
                    <td>idjabfungum</td>
                    <td>kdunit</td>
                    <td>idskpd</td>
                    <td>idstspeg</td>
                    <td>idjenkedudupeg</td>
                    <td>idjenjab</td>
                </tr>
            </thead>
            <tbod>
                @foreach($rs as $item)
                <tr>
                    <td>{!!$item->id_konversi!!}</td>
                    <td>{!!$item->nip!!}</td>
                    <td>{!!$item->nama!!}</td>
                    <td>{!!$item->gdp!!}</td>
                    <td>{!!$item->gdb!!}</td>
                    <td>{!!$item->tmlhr!!}</td>
                    <td>{!!$item->tglhr!!}</td>
                    <td>{!!$item->idjenkel!!}</td>
                    <td>{!!$item->idagama!!}</td>
                    <td>{!!$item->alm!!}</td>
                    <td>{!!$item->idstskawin!!}</td>
                    <td>{!!$item->idgolrucpn!!}</td>
                    <td>{!!$item->mkthncpn!!}</td>
                    <td>{!!$item->mkblncpn!!}</td>
                    <td>{!!$item->tmtcpn!!}</td>
                    <td>{!!$item->tgskcpn!!}</td>
                    <td>{!!$item->idtkpendid!!}</td>
                    <td>{!!$item->idjenjurusan!!}</td>
                    <td>{!!$item->noijaz!!}</td>
                    <td>{!!$item->thijaz!!}</td>
                    <td>{!!$item->idtkpendidawal!!}</td>
                    <td>{!!$item->idjenjurusanawal!!}</td>
                    <td>{!!$item->noijazawal!!}</td>
                    <td>{!!$item->thijazawal!!}</td>
                    <td>{!!$item->idjabfung!!}</td>
                    <td>{!!$item->idjabfungum!!}</td>
                    <td>{!!$item->kdunit!!}</td>
                    <td>{!!$item->idskpd!!}</td>
                    <td>{!!$item->idstspeg!!}</td>
                    <td>{!!$item->idjenkedudupeg!!}</td>
                    <td>{!!$item->idjenjab!!}</td>
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