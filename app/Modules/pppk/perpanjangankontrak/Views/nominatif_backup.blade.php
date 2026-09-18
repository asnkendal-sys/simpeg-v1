<script type="text/javascript">
    $(document).ready(function(){
        $('.tmt').mask("99-99-9999");
    });
</script>

<style type='text/css'>
    table {
        font-family: 'Arial';
        font-size: 9pt;
        background: white;
        line-height:1.5;
    }

    table{
        border-collapse:collapse;
        border-width:1px;
        width:100%;
    }

    table thead tr th,table tfoot tr th{
        background-color:#337ab7;
        font-weight:bold;
        padding:4px;
    }

    table tbody tr td{
        padding:4px;
        vertical-align:top;
    }

    table.gen tbody tr td{
        /*height:40px; */
    }

    small{
        font-size: 11px;
    }

    table tbody td div.r,table tfoot td div.r,table tfoot th div.r{
        text-align:right;
    }
</style>
    <table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
        <thead class="bg-primary">
            <tr>
                <th><input type="checkbox" name="checkall"  id="checkall" checked></th>
                <th><div class="text-center">No.</div></th>
                <th>
                    <div class="text-center">NAMA</div>
                    <div class="text-center">TEMPAT, TGL LAHIR</div>
                </th>
                <th>
                    <div class="text-center">NIP</div>
                    <div class="text-center">KARPEG</div>
                </th>
                <th width="17%">
                    <div class="text-center">JABATAN </div>
                    <div class="text-center">UNIT KERJA</div>
                    <div class="text-center">TMT</div>
                </th>
                <th>
                    <div class="text-center">PANGKAT / GOL. PPPK</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA PPPK</div>
                </th>
{{--                 <th>
                    <div class="text-center">KENAIKAN SEKARANG</div>
                    <div class="text-center">TMT</div>
                    <div class="text-center">MASA KERJA GOLONGAN</div>
                </th> --}}
        </thead>
        {{-- <tr>
            <th colspan="2">&nbsp;</th>
            <th>
                <div class="text-center">NAMA</div>
                <div class="text-center">TEMPAT, TGL LAHIR</div>
            </th>
            <th>
                <div class="text-center">NIP</div>
                <div class="text-center">KARPEG</div>
            </th>
            <th>
                <div class="text-center">JABATAN </div>
                <div class="text-center">UNIT KERJA</div>
                <div class="text-center">TMT</div>
            </th>
            <th>
                <div class="text-center">ESELON</div>
                <div class="text-center">TMT</div>
            </th>
            <th>
                <div class="text-center">PANGKAT / GOL. CPNS</div>
                <div class="text-center">TMT</div>
                <div class="text-center">MASA KERJA CPNS</div>
            </th>
            <th>
                <div class="text-center">PANGKAT / GOL. PNS</div>
                <div class="text-center">TMT</div>
                <div class="text-center">MASA KERJA PNS</div>
            </th>
            <th>
                <div class="text-center">PANGKAT SEKARANG)</div>
                <div class="text-center">TMT</div>
                <div class="text-center">MASA KERJA GOLONGAN</div>
            </th> --}}
    <?php
        $i=0; $x=0; $yellow = 0; $heads = '';
    ?>

    @if(count($pegawai) > 0)
        <tbody>

        @foreach($pegawai as $item)
        <?php
            //$kp = $item->tmtpktnext;
            //$pen = $item->pensiunnext;
            //$months = getMonth($pen, $kp);
        ?>

        {{-- @if($months > 0) --}}
            <?php
                $x++;
                $thmker = $item->mkthnpkt;
                $thmker2 = intval($thmker)+4;
              
                if (strlen($thmker)==1) $thmker="0".$thmker;
              
                if (strlen($thmker2)==1) $thmker2="0".$thmker2;

                $style = (($item->nip=='')?' style="background-color:#f3f99a"':'');
                $disabled = (($item->nip=='')?'disabled':'');
                $class = (($item->nip=='')?'disabled':'pilihnip');

                $iscek = 0;
                if($x>1){
                    $heads = $head;
                }
                $tmt_mulai = date('d-m-Y',strtotime($item->tmtakhirakhir_pppk." +1 days"));
                $tmt_akhir = date('d-m-Y',strtotime($item->tmtakhirakhir_pppk." +5 years"));
                //$usiatahun = $item->usiaTahun($data['tahun']);
                //if($usiatahun >= 58){
                //    $tmt_akhir = date('d-m-Y',strtotime($item->tglhr." +58 years"));
                //}
            ?>

                <thead class="bg-primary">{!! $heads !!}</thead>
                    <tr {!! $style !!}>
                        <td><input type="checkbox" name="nip['.$i.']" value="'.$item->nip.'" class="{!! $class !!}" {!! $disabled.' '.(($iscek != 1)?"checked":"") !!}></td>
                        <td align="center">{!! $x !!}</td>
                        <td>
                            <span class="ed1" style="display:none">{!! $item->nip !!}</span>
                            <div class="text-left">
                                <b>
                                {{-- <a href="javascript:void(0);" class="prev-hudis" title="Preview Riwayat" isnip="'.$item->nip.'"> --}}
                                    {!! $item->nama !!}
                                {{-- </a> --}}
                                </b>
                            </div>
                            <small><div class="text-left">{!! $item->tmlhr.', '.(($item->tglhr!="0000-00-00")?date("d-m-Y", strtotime($item->tglhr)):"") !!}</div></small>
                            <input type="hidden" name="skpd['.$item->nip.']" value="'.$item->idskpd.'" id="skpd['.$item->nip.']" style="width:40px">
                        </td>
                        <td align="center">
                            <div class="text-center">{!! $item->nip !!}</div>
                            <div class="text-center">{!! $item->nokarpeg !!}</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $item->jabatan !!}</div>
                                <div class="text-left"><i>Pada</i></div>
                                <div class="text-left">{!! @$item->skpd->path_short !!}</div>
                                <div class="text-left">TMT : {!! (($item->tmtakhirawal_pppk!="0000-00-00")?date("d-m-Y", strtotime($item->tmtakhirawal_pppk)):"") !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $item->golongan.' - '.$item->pangkat !!}</div>
                                <div class="text-left">{!! (($item->tmtmulaiawal_pppk!="0000-00-00")?date("d-m-Y", strtotime($item->tmtmulaiawal_pppk)):"") !!}</div>
                                {{-- <div class="text-left">{!! (($item->mkthnpkt!="")?$item->mkthnpkt:"0").' Tahun '.(($item->mkblnpkt!="")?$item->mkblnpkt:"0") !!} Bulan</div> --}}
                            </small>
                        </td>
                    </tr>
                <tr {!! $style !!}>
                    <td colspan="11">
                        <table width="100%" style="border: 1px solid #ececec">
                            <tr style="background-color: #ececec">
                                <td rowspan="2" style="vertical-align:middle; border-right: 1px solid #ececec" width="40%">
                                    <div align="center">Atribut SK <br> Perpanjangan Kontrak</div>
                                </td>
                                <td>Golongan : </td>
                                <td colspan="4">Masa Perjanjian Kerja : </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="250px">{!! comboGolru("golpnsskr[".$item->nip."]", $item->idgolruakhir_pppk, $required="required",3) !!}</td>
                                <td><input type="text" class="input-medium tmt form-control" name="tmt_awal[{!! $item->nip !!}]" id="tmt_awal[{!! $item->nip !!}]" placeholder="dd-mm-yyyy" value="{!! $tmt_mulai !!}" required></td>
                                <td style="vertical-align: middle; text-align: center;">s/d</td>
                                <td><input type="text" class="input-medium tmt form-control" name="tmt_akhir[{!! $item->nip !!}]" id="tmt_akhir[{!! $item->nip !!}]" placeholder="dd-mm-yyyy" value="{!! $tmt_akhir !!}" required></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php $i++; ?>                
            {{-- @endif --}}
            </tbody>
        @endforeach
    @else
        <tbody><tr><td colspan="8">Daftar Nominasi Kenaikan Pangkat Tidak Tersedia.</td></tr></tbody>
    @endif
    </table>

    @if($yellow > 0)
        <span style='background-color:#f3f99a; border: 1px solid #ececec;'>&nbsp;&nbsp;&nbsp;&nbsp;</span> : Kenaikan Pangkat pada masa kerja dan golongan sudah habis.";
    @endif