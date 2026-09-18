<div class="table">
    <div class="box-body no-padding">
        <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
            <thead class="bg-primary">
                <tr>
                    <th style="vertical-align: middle;" rowspan="2" width="3%">NO</th>
                    <th style="vertical-align: middle;" rowspan="2"><div class="text-center">NIP<br>NAMA LENGKAP</div></th>
                    <th style="vertical-align: middle;" rowspan="2"><div class="text-center">GOL.<br>PANGKAT</div></th>
                    <th style="vertical-align: middle;" rowspan="2"><div class="text-center">JABATAN</div></th>
                    <th style="vertical-align: middle;" rowspan="2"><div class="text-center">JENIS CUTI</div></th>
                    <th style="vertical-align: middle;" colspan="3"><div class="text-center">TANGGAL</div></th>
                    <th style="vertical-align: middle;" colspan="3"><div class="text-center">STATUS</div></th>
                    <th style="vertical-align: middle;" rowspan="2" width="7%"><div class="text-center">AKSI</div></th>
                </tr>
                <tr>
                    <th><div class="text-center">MULAI</div></th>
                    <th><div class="text-center">SELESAI</div></th>
                    <th><div class="text-center">LAMA</div></th>

                    <th><div class="text-center">USULAN</div></th>
                    <th><div class="text-center">ATASAN</div></th>
                    <th><div class="text-center">WEWENANG</div></th>
                </tr>
            </thead>   

            <tbody>
                <?php
                $arr[0]= "";
                $n = 0;
                ?>
                @foreach ($wewenangs as $no => $wewenang)
                <?php
                $n++;
                $arr[$n] = $wewenang->nousul;
                if($arr[$n]!=$arr[$n-1]){
                    ?>
                    <tr>
                        <th style="position:relative;" colspan="8">
                            <div class="text-left">
                                NOMOR USULAN : {{$wewenang->nousul}}&nbsp;
                                <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($wewenang->tgl_usul))?>
                                &nbsp;
                                <?php echo "||&nbsp;".getskpdgroup(substr($wewenang->idskpd, 0,2)); ?>&nbsp;
                                <br>
                            </div>
                        </th>
                        <th style="position:relative;" colspan="6">
                            <div class="text-right">
                                &nbsp;<a href="javascript::void(0)" title="Tambah Pegawai Dalam Nominatif" class="tambahnominatif" 
                                recnousul="{!!$wewenang->nousul!!}" 
                                rectglusul="{!!$wewenang->tgl_usul!!}" 
                                style="color: green;"><i class="fa fa-plus"> Tambah</i></a> |

                                &nbsp;<a href="javascript::void(0)" target="_blank" class="cetaknominatif" 
                                recnousul="{!!$wewenang->nousul!!}" ><i class="fa fa-print"> Cetak</i></a> |&nbsp;

                                <?php // if(CekNominatifSudahAdaYangDisetujui($wewenang->nousul) == 0) ?>
                                <a href="javascript:void(0)" class="hapusnominatif" recnousul="{!!$wewenang->nousul!!}"
                                    title="Hapus Daftar Nominatif" style="color: red;"><i class="fa fa-trash-o"> Hapus</i></a>

                                    <!-- <a href="javascript:void(0)" class='text-danger sudahdisetujui' style="color: red;cursor: not-allowed;" disabled><i class="fa fa-trash-o"> Hapus</i></a> -->

                                </div>
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><center>{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</center></td>
                        <td>{!!$wewenang->nip!!}<br>{!!$wewenang->namalengkap!!}</td>
                        <td>{!!$wewenang->golru!!}<br>{!!$wewenang->pangkat!!}</td>
                        <td>{!!$wewenang->jabatan!!}</td>
                        <td style="vertical-align: middle;">{!!getJenisCuti($wewenang->id_jenis_cuti)!!}</td>
                        <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($wewenang->tgl_mulai))!!}</td>
                        <td style="vertical-align: middle;">{!!date('d-m-y',strtotime($wewenang->tgl_selesai))!!}</td>
                        <td class="text-center" style="vertical-align: middle;">{!!$wewenang->lama_cuti!!}</td>

                        <td class="text-center verusulan" recidusul="{!!$wewenang->id!!}" 
                            recnip="{!!$wewenang->nip!!}" 
                            recnousul="{!!$wewenang->nousul!!}" style="vertical-align: middle;">{!! getStatusCuti($wewenang->opd_status) !!}
                        </td>

                        <td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($wewenang->wewenang_status) !!}</td>
                        <td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($wewenang->wewenang_status) !!}</td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0)" class="text-info editusulan"
                                        recidusul="{!!$wewenang->id!!}" 
                                        recnip="{!!$wewenang->nip!!}" 
                                        recnousul="{!!$wewenang->nousul!!}">
                                        <i class="fa fa-pencil-square-o"></i>Edit
                                    </li>
                                    <li>
                                        @if(\Session::get('role_id') != 5 || \Session::get('role_id') != 3)
                                        <a href="javascript:void(0)" class="text-info verusulan"
                                        recidusul="{!!$wewenang->id!!}" 
                                        recnip="{!!$wewenang->nip!!}" 
                                        recnousul="{!!$wewenang->nousul!!}">
                                        <i class="fa fa-check"></i>Verifikasi Usulan
                                    </a>
                                    @else
                                    <a href="javascript:void(0)" class="text-info detailcuti">
                                        <i class="fa fa-search"></i>Preview Detail
                                    </a>
                                    @endif
                                </li>
                                <li>{!! ClaravelHelpers::btnDelete($wewenang->id) !!}</li>
                            </ul>
                        </div>
                    </td>
                </tr> 
                    <!-- <tr>
                        <td style="height: 10px;" colspan="11"><em>Pengajuan Cuti Terhadap Tanggal Mulai : <b>{!! getJarakDuaTanggal($wewenang->tgl_mulai) !!}</b></em> Hari</td>
                    </tr> -->
                    @endforeach
                </tbody>
            </table>
            <table border="0" class="table">
                <tr>
                    <td colspan="11">Keterangan :<br></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <span style="color:green;"><i class="fa fa-check-circle" title="Selesai diproses"/></span> - Disetujui
                    </td>
                    <td>
                        <span style="color:orange;"><i class="fa fa-pencil-square-o" title="Perubahan"/></span> - Perubahan
                    </td>
                    <td>
                        <span style="color:red;"><i class="fa fa-clock-o" title="Ditangguhkan"/></span> - Ditangguhkan
                    </td>
                    <td>
                        <span style="color:red;"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> - Tidak Disetujui
                    </td>
                    <td>
                        <span style="color:orange;"><i class="fa fa-clock-o" title="Sedang diproses"/></span> - Sedang Diproses
                    </td>
                    <td>
                        <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> - Sudah Cetak SK
                    </td>
                    <td>
                        <span style="color:#000000"><i class="fa fa-star" title="SK Dibatalkan"/></span> - SK Dibatalkan
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){

        });
    </script>
