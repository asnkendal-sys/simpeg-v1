<form id="form-perubahan" class="form-horizontal" method="POST" action="{!!url()!!}/epersonal/biodata/verbiodataall" accept-charset="UTF-8">
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-primary">
               <div class="table-responsive">
                  <div class="box-body no-padding">
                     <div id="riwayat" class="tab-pane">
                        <p>
                           <div class="nav-tabs-custom" style="box-shadow:none;">
                              <ul class="nav nav-tabs tab2" id="myTabs">
                                 <li class="active"><a data-toggle="tab" href="#" id="biodata" recnip="{!! Input::get('nip') !!}"><i class="fa fa-fw fa-dot-circle-o"></i> BIODATA</a></li>
                                 <li><a data-toggle="tab" href="#" id="rpangkat" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> PANGKAT</a></li>
                                 <li><a data-toggle="tab" href="#" id="rjab" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> JABATAN</a></li>
                                 <li><a data-toggle="tab" href="#" id="rkgb" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> KGB</a></li>
                                 <li><a data-toggle="tab" href="#" id="rpend" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> PENDIDIKAN</a></li>
                                 <li><a data-toggle="tab" href="#" id="rdikstru" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT STRUKTURAL</a></li>
                                 <li><a data-toggle="tab" href="#" id="rdikfung" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT FUNGSIONAL</a></li>
                                 <li><a data-toggle="tab" href="#" id="rdiktek" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> DIKLAT TEKNIS</a></li>
                                 <li><a data-toggle="tab" href="#" id="rhukdis" recnip="{!! Input::get('nip')!!}"><i class="fa fa-fw fa-dot-circle-o"></i> HUKUM DISIPLIN</a></li>
                              </ul>

                              <div class="tab-content">
                                 <div id="pangkat" class="tab-pane active">
                                    <p>
                                       <div class="">
                                          <div class="col-md-6">
                                             <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI (DATA AWAL)</h3>
                                             </div>
                                             <?php
                                                $nip = Input::get('nip');
                                                $item1 = getDetailpegawaiupdate($nip);
                                                $item2 = \DB::table('tb_01_temp')->where('nip', $nip)->first();

                                                if(file_exists('./packages/upload/photo/pegawai/'.$item1->photo)){
                                                   $image = url()."/packages/upload/photo/pegawai/".$item1->photo;
                                                }else{
                                                   $image = url()."/packages/upload/photo/pegawai/default.jpg";
                                                }

                                                $photo = ($item1->photo!=$item2->photo)?'alert-dangers':'';
                                                $nips = ($item1->nip!=$item2->nip)?'alert-dangers':'';
                                                $niplama = ($item1->niplama!=$item2->niplama)?'alert-dangers':'';
                                                $nama = ($item1->nip!=$item2->nip)?'alert-dangers':'';
                                                $gdp = ($item1->gdp!=$item2->gdp)?'alert-dangers':'';
                                                $nama = ($item1->nama!=$item2->nama)?'alert-dangers':'';
                                                $gdb = ($item1->gdb!=$item2->gdb)?'alert-dangers':'';
                                                $tmlhr = ($item1->tmlhr!=$item2->tmlhr)?'alert-dangers':'';
                                                $tglhr = ($item1->tglhr!=$item2->tglhr)?'alert-dangers':'';
                                                $idagama = ($item1->idagama!=$item2->idagama)?'alert-dangers':'';
                                                $idjenkel = ($item1->idjenkel!=$item2->idjenkel)?'alert-dangers':'';
                                                $idstskawin = ($item1->idstskawin!=$item2->idstskawin)?'alert-dangers':'';
                                                $idgoldarah = ($item1->idgoldarah!=$item2->idgoldarah)?'alert-dangers':'';
                                                $alm = ($item1->alm!=$item2->alm)?'alert-dangers':'';
                                                $almrt = ($item1->almrt!=$item2->almrt)?'alert-dangers':'';
                                                $almrw = ($item1->almrw!=$item2->almrw)?'alert-dangers':'';
                                                $almdesa = ($item1->almdesa!=$item2->almdesa)?'alert-dangers':'';
                                                $almkec = ($item1->almkec!=$item2->almkec)?'alert-dangers':'';
                                                $almkab = ($item1->almkab!=$item2->almkab)?'alert-dangers':'';
                                                $almprov = ($item1->almprov!=$item2->almprov)?'alert-dangers':'';
                                                $almkdpos = ($item1->almkdpos!=$item2->almkdpos)?'alert-dangers':'';
                                                $telp = ($item1->telp!=$item2->telp)?'alert-dangers':'';
                                                $hp = ($item1->hp!=$item2->hp)?'alert-dangers':'';
                                                $email = ($item1->email!=$item2->email)?'alert-dangers':'';
                                                $nokarpeg = ($item1->nokarpeg!=$item2->nokarpeg)?'alert-dangers':'';
                                                $noaskes = ($item1->noaskes!=$item2->noaskes)?'alert-dangers':'';
                                                $notaspen = ($item1->notaspen!=$item2->notaspen)?'alert-dangers':'';
                                                $nokaris = ($item1->nokaris!=$item2->nokaris)?'alert-dangers':'';
                                                $nonpwp = ($item1->nonpwp!=$item2->nonpwp)?'alert-dangers':'';
                                                $noktp = ($item1->noktp!=$item2->noktp)?'alert-dangers':' ';
                                                $nobapertarum = ($item1->nobapertarum!=$item2->nobapertarum)?'alert-dangers':'';
                                                $kdunit = ($item1->kdunit!=$item2->kdunit)?'alert-dangers':'';
                                                $idskpd = ($item1->idskpd!=$item2->idskpd)?'alert-dangers':'';
                                                $idstspeg = ($item1->idstspeg!=$item2->idstspeg)?'alert-dangers':'';
                                                $idjenkepeg = ($item1->idjenkepeg!=$item2->idjenkepeg)?'alert-dangers':'';
                                                $idjenkedudupeg = ($item1->idjenkedudupeg!=$item2->idjenkedudupeg)?'alert-dangers':'';
                                                $pejmencpn = ($item1->pejmencpn!=$item2->pejmencpn)?'alert-dangers':'';
                                                $idgolrucpn = ($item1->idgolrucpn!=$item2->idgolrucpn)?'alert-dangers':'';
                                                $noskcpn = ($item1->noskcpn!=$item2->noskcpn)?'alert-dangers':'';
                                                $tgskcpn = ($item1->tgskcpn!=$item2->tgskcpn)?'alert-dangers':'';
                                                $tmtcpn = ($item1->tmtcpn!=$item2->tmtcpn)?'alert-dangers':'';
                                                $mkthncpn = ($item1->mkthncpn!=$item2->mkthncpn)?'alert-dangers':'';
                                                $mkblncpn = ($item1->mkblncpn!=$item2->mkblncpn)?'alert-dangers':'';
                                                $nospmtcpn = ($item1->nospmtcpn!=$item2->nospmtcpn)?'alert-dangers':'';
                                                $tgspmtcpn = ($item1->tgspmtcpn!=$item2->tgspmtcpn)?'alert-dangers':'';
                                                $tmtspmtcpn = ($item1->tmtspmtcpn!=$item2->tmtspmtcpn)?'alert-dangers':'';
                                                $pejmenpns = ($item1->pejmenpns!=$item2->pejmenpns)?'alert-dangers':'';
                                                $idgolrupns = ($item1->idgolrupns!=$item2->idgolrupns)?'alert-dangers':'';
                                                $tgskpns = ($item1->tgskpns!=$item2->tgskpns)?'alert-dangers':'';
                                                $noskpns = ($item1->noskpns!=$item2->noskpns)?'alert-dangers':'';
                                                $tmtpns = ($item1->tmtpns!=$item2->tmtpns)?'alert-dangers':'';
                                                $mkthnpns = ($item1->mkthnpns!=$item2->mkthnpns)?'alert-dangers':'';
                                                $mkblnpns = ($item1->mkblnpns!=$item2->mkblnpns)?'alert-dangers':'';
                                                $nospmtpns = ($item1->nospmtpns!=$item2->nospmtpns)?'alert-dangers':'';
                                                $tgspmtpns = ($item1->tgspmtpns!=$item2->tgspmtpns)?'alert-dangers':'';
                                                $tmtspmtpns = ($item1->tmtspmtpns!=$item2->tmtspmtpns)?'alert-dangers':'';
                                                $tinggi = ($item1->tinggi!=$item2->tinggi)?'alert-dangers':'';
                                                $berat = ($item1->berat!=$item2->berat)?'alert-dangers':'';
                                                $rambut = ($item1->rambut!=$item2->rambut)?'alert-dangers':'';
                                                $muka = ($item1->muka!=$item2->muka)?'alert-dangers':'';
                                                $kulit = ($item1->kulit!=$item2->kulit)?'alert-dangers':'';
                                                $ciri = ($item1->ciri!=$item2->ciri)?'alert-dangers':'';
                                                $cacat = ($item1->cacat!=$item2->cacat)?'alert-dangers':'';
                                                $hobby1 = ($item1->hobby1!=$item2->hobby1)?'alert-dangers':'';
                                                $hobby2 = ($item1->hobby2!=$item2->hobby2)?'alert-dangers':'';
                                                $hobby3 = ($item1->hobby3!=$item2->hobby3)?'alert-dangers':'';
                                                $password = ($item1->password!=$item2->password)?'alert-dangers':'';
                                             ?>
                                             <div class="box-body">
                                                <div class="col-md-12 data-awal">
                                                   <p><input type="hidden" name="nipasli" class="form-control nip" value="{!!$nip!!}"></p>
                                                   {!!csrf_field()!!}
                                                   <div class="form-group">
                                                      <label class="col-sm-3 control-label">
                                                         <div class="widget-user-image" align="center">
                                                            <img alt="User Image" id='propic' class="img-circle" src="{!!$image!!}" width="128" height="128">
                                                         </div>
                                                      </label>
                                                      <div class="col-sm-7">
                                                         <p><div class="form-control {!!$nips!!} nips">{{($item1->nip!='')?$item1->nip:'-'}}</div></p>
                                                      </div>
                                                      <div class="col-sm-4">
                                                         <p><div class="form-control {!!$gdp!!} gdp">{{($item1->gdp!='')?$item1->gdp:'-'}}</div></p>
                                                      </div>
                                                      <div class="col-sm-3">
                                                         <p><div class="form-control {!!$gdb!!} gdb">{{($item1->gdb!='')?$item1->gdb:'-'}}</div></p>
                                                      </div>
                                                      <div class="col-sm-7">
                                                         <p><div class="form-control {!!$nama!!} nama">{{($item1->nama!='')?$item1->nama:'-'}}</div></p>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('niplama', 'NIP Lama', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$niplama!!} niplama">{{($item1->niplama!='')?$item1->niplama:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('tmlhr', 'Kelahiran :', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-4">
                                                         <div class="form-control {!!$tmlhr!!} tmlhr">{{($item1->tmlhr!='')?$item1->tmlhr:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-3">
                                                         <div class="form-control {!!$tglhr!!} tglhr">{{($item1->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item1->tglhr)):'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$idagama!!} idagama">{{($item1->agama!='')?$item1->agama:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$idjenkel!!} idjenkel">{{($item1->jenkel!='')?$item1->jenkel:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('idstskawin', 'Status Marital:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$idstskawin!!} idstskawin">{{($item1->stskawin!='')?$item1->stskawin:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('idgoldarah', 'Golongan Darah:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$idgoldarah!!} idgoldarah">{{($item1->goldarah!='')?$item1->goldarah:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('alm', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$alm!!} alm">{{($item1->alm!='')?$item1->alm:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almrt', 'RT:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-3">
                                                         <div class="form-control {!!$almrt!!} almrt">{{($item1->almrt!='')?$item1->almrt:'-'}}</div>
                                                      </div>
                                                      <div class="col-sm-1" style="margin-top: 7px;">
                                                         <b>RW: </b>
                                                      </div>
                                                      <div class="col-sm-3">
                                                         <div class="form-control {!!$almrw!!} almrw">{{($item1->almrw!='')?$item1->almrw:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almdesa', 'Desa/Kelurahan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$almdesa!!} almdesa">{{($item1->almdesa!='')?$item1->almdesa:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almkec', 'Kecamatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$almkec!!} almkec">{{($item1->almkec!='')?$item1->almkec:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almkab', 'Kabupaten/Kota:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$almkab!!} almkab">{{($item1->almkab!='')?$item1->almkab:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almprov', 'Provinsi:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$almprov!!} almprov">{{($item1->almprov!='')?$item1->almprov:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('almkdpos', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$almkdpos!!} almkdpos">{{($item1->almkdpos!='')?$item1->almkdpos:'-'}}</div>
                                                      </div>
                                                   </div><hr>

                                                   <div class="form-group">
                                                        {!! Form::label('telp', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$telp!!} telp">{{($item1->telp!='')?$item1->telp:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('hp', 'No HP:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$hp!!} hp">{{($item1->hp!='')?$item1->hp:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('email', 'E-Mail Pribadi:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$email!!} email">{{($item1->email!='')?$item1->email:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('nokarpeg', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$nokarpeg!!} nokarpeg">{{($item1->nokarpeg!='')?$item1->nokarpeg:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('noaskes', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$noaskes!!} noaskes">{{($item1->noaskes!='')?$item1->noaskes:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('notaspen', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$notaspen!!} notaspen">{{($item1->notaspen!='')?$item1->notaspen:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('nokaris', ' No. Karis/Karsu:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$nokaris!!} nokaris">{{($item1->nokaris!='')?$item1->nokaris:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('nonpwp', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$nonpwp!!} nonpwp">{{($item1->nonpwp!='')?$item1->nonpwp:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('noktp', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$noktp!!} noktp">{{($item1->noktp!='')?$item1->noktp:'-'}}</div>
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        {!! Form::label('nobapertarum', 'Bapertarum:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$nobapertarum!!} nobapertarum">{{($item1->nobapertarum!='')?$item1->nobapertarum:'-'}}</div>
                                                        </div>
                                                   </div>

                                                   <!-- Start SPMT CPNS -->
                                                   <p>
                                                       <div class="box-header with-border">
                                                           <b class="box-title"><small>SPMT CPNS / PPPK</small></b>
                                                       </div>
                                                   </p>
                                                   <div class="form-group">
                                                       {!! Form::label('nospmtcpn', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$nospmtcpn!!} nospmtcpn">{{($item1->nospmtcpn!='')?$item1->nospmtcpn:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$tgspmtcpn!!} tgspmtcpn">{{($item1->tgspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtcpn)):'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$tmtspmtcpn!!} tmtspmtcpn">{{($item1->tmtspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtcpn)):'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <!-- End SPMT CPNS -->

                                                   <!-- Start SPMT PNS -->
                                                   <p>
                                                       <div class="box-header with-border">
                                                           <b class="box-title"><small>SPMT PNS</small></b>
                                                       </div>
                                                   </p>
                                                   <div class="form-group">
                                                       {!! Form::label('nospmtpns', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$nospmtpns!!} nospmtpns">{{($item1->nospmtpns!='')?$item1->nospmtpns:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$tgspmtpns!!} tgspmtpns">{{($item1->tgspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtpns)):'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('tmtspmtpns', ' TMT  SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$tmtspmtpns!!} tmtspmtpns">{{($item1->tmtspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtpns)):'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <!-- End SPMT PNS -->

                                                   <p>
                                                   <div class="box-header with-border">
                                                       <b class="box-title"><small><i class="fa fa-fw fa-street-view"></i> STATUS PEGAWAI</small></b>
                                                   </div>
                                                   </p>

                                                   <div class="form-group">
                                                       {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$idstspeg!!} idstspeg">{{($item1->stspeg!='')?$item1->stspeg:'-'}}</div>
                                                       </div>

                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$idjenkepeg!!} idjenkepeg">{{($item1->jenkepeg!='')?$item1->jenkepeg:'-'}}</div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                       <div class="col-sm-7">
                                                           <div class="form-control {!!$idjenkedudupeg!!} idjenkedudupeg">{{($item1->jenkedudupeg!='')?$item1->jenkedudupeg:'-'}}</div>
                                                       </div>
                                                   </div>

                                                   <p>
                                                   <div class="box-header with-border">
                                                        <b class="box-title"><small><i class="fa fa-fw fa-recycle"></i> KETERANGAN BADAN</small></b>
                                                   </div>
                                                   </p>

                                                   <div class="form-group">
                                                      {!! Form::label('tinggi', 'Tinggi:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$tinggi!!} tinggi">{{($item1->tinggi!='')?$item1->tinggi:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('berat', 'Berat:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$berat!!} berat">{{($item1->berat!='')?$item1->berat:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('rambut', 'Rambut:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$rambut!!} rambut">{{($item1->rambut!='')?$item1->rambut:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('muka', ' Bentuk Muka:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$muka!!} muka">{{($item1->muka!='')?$item1->muka:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('kulit', ' Warna Kulit:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$kulit!!} kulit">{{($item1->kulit!='')?$item1->kulit:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('ciri', 'Ciri Khas:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$ciri!!} ciri">{{($item1->ciri!='')?$item1->ciri:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('cacat', 'Cacat Tubuh:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$cacat!!} cacat">{{($item1->cacat!='')?$item1->cacat:'-'}}</div>
                                                      </div>
                                                   </div>

                                                   <p>
                                                   <div class="box-header with-border">
                                                        <b class="box-title"><small><i class="fa fa-fw fa-recycle"></i> HOBBY</small></b>
                                                   </div>
                                                   </p>

                                                   <div class="form-group">
                                                      {!! Form::label('hobby1', 'Hobby 1:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$hobby1!!} hobby1">{{($item1->hobby1!='')?$item1->hobby1:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('hobby2', 'Hobby 2:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$hobby2!!} hobby2">{{($item1->hobby2!='')?$item1->hobby2:'-'}}</div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      {!! Form::label('hobby3', 'Hobby 3:', array('class' => 'col-sm-3 control-label')) !!}
                                                      <div class="col-sm-7">
                                                         <div class="form-control {!!$hobby3!!} hobby3">{{($item1->hobby3!='')?$item1->hobby3:'-'}}</div>
                                                      </div>
                                                   </div>

                                                   <!--<p>
                                                   <div class="box-header with-border">
                                                        <b class="box-title"><small><i class="fa fa-fw fa-recycle"></i> Password</small></b>
                                                   </div>
                                                   </p>

                                                   <div class="form-group">
                                                        {!! Form::label('password', 'Password:', array('class' => 'col-sm-3 control-label')) !!}
                                                        <div class="col-sm-7">
                                                            <div class="form-control {!!$password!!} hobby1">{{($item1->password!='')?$item1->password:'-'}}</div>
                                                        </div>
                                                   </div>-->
                                                </div>
                                             </div>
                                             <!-- /.box-body -->
                                          </div>

                                          <div class="col-md-6">
                                             <div class="box-header">
                                                 <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI (PERUBAHAN DATA)</h3>
                                             </div>
                                             <div class="box-body">
                                                <div class="col-md-12 data-perubahan">
                                                   <span class="{!!(session('role_id') > 3)?'div-disabled':''!!}">
                                                      <div class="form-group">
                                                         <label class="col-sm-3 control-label">
                                                            <div class="widget-user-image" align="center">
                                                               <img alt="User Image" id='propic' class="img-circle {!!$photo!!}" src="{!!url()!!}/packages/upload/photo/pegawai/default.jpg" width="128" height="128">
                                                               <input type="hidden" name="photo" id="photo" class="form-control {!!$photo!!}">
                                                               @if($item1->photo!=$item2->photo)
                                                                  <a href="javascript:void(0)" title="Verifikasi Foto Pegawai" valupdate="photo" class="photo ver-perubahan"><i class="fa fa-check"></i></a>
                                                               @endif
                                                            </div>
                                                         </label>
                                                         <div class="col-sm-7">
                                                            <p><input type="text" name="nip" id="nip" class="form-control {!!$nips!!}" value="{!!$nip!!}"></p>
                                                         </div>
                                                         @if($item1->nip!=$item2->nip)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi NIP" valupdate="nip" class="nip ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                         <div class="{{($item1->gdp!=$item2->gdp)?'col-sm-3':'col-sm-4'}}">
                                                            <p>{!! Form::text('gdp', null, array('class'=> 'form-control awal '.$gdp, 'id'=>'gdp', 'placeholder'=>'Ex: Drs. ')) !!}</p>
                                                         </div>
                                                         @if($item1->gdp!=$item2->gdp)
                                                            <div class="col-sm-1">
                                                               <p><a href="javascript:void(0)" title="Verifikasi Gelar Depan" valupdate="gdp" class="gdp ver-perubahan"><i class="fa fa-check"></i></a></p>
                                                            </div>
                                                         @endif
                                                         <div class="col-sm-3">
                                                            <p>{!! Form::text('gdb', null, array('class'=> 'form-control awal '.$gdb, 'id'=>'gdb', 'placeholder'=>'Ex: SE, M.Kom')) !!}</p>
                                                         </div>
                                                         @if($item1->gdb!=$item2->gdb)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi gelar belakang" valupdate="gdb" class="gdb ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                         <div class="col-sm-7">
                                                            <p>{!! Form::text('nama', null, array('class'=> 'form-control awal '.$nama, 'id'=>'nama', 'placeholder'=>'Nama Lengkap')) !!}</p>
                                                         </div>
                                                         @if($item1->nama!=$item2->nama)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Nama Lengkap" valupdate="nama" class="nama ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>

                                                      <div class="form-group">
                                                         {!! Form::label('niplama', 'NIP Lama', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('niplama', null, array('class'=> 'form-control awal '.$niplama, 'id'=>'niplama', 'placeholder'=>'NIP Lama', 'maxlength'=>9)) !!}
                                                         </div>
                                                         @if($item1->niplama!=$item2->niplama)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi NIP Lama" valupdate="niplama" class="niplama ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('tmlhr', 'Kelahiran :', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="{{($item1->tmlhr!=$item2->tmlhr)?'col-sm-3':'col-sm-4'}}">
                                                            <div style="width: auto;" class="{!!$tmlhr!!} tmlhr">
                                                               <select name="tmlhr" class="form-control awal" id="tmlhr" style="width: 100%;"></select>
                                                            </div>
                                                         </div>
                                                         @if($item1->tmlhr!=$item2->tmlhr)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi tempat lahir" valupdate="tmlhr" class="tmlhr ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                         <div class="col-sm-3">
                                                            {!! Form::text('tglhr', null, array('class'=> 'form-control date awal '.$tglhr, 'id'=>'tglhr', 'placeholder'=>'Tanggal Lahir')) !!}
                                                         </div>
                                                         @if($item1->tglhr!=$item2->tglhr)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi tanggal lahir" valupdate="tglhr" class="tglhr ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('idagama', 'Agama:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            <div style="width: auto;" class="{!!$idagama!!} idagama">
                                                               {!! comboAgama("idagama","","") !!}
                                                            </div>
                                                         </div>
                                                         @if($item1->idagama!=$item2->idagama)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Agama" valupdate="idagama" class="idagama ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('idjenkel', 'Jenis Kelamin:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            <div style="width: auto;" class="{!!$idjenkel!!} idjenkel">
                                                               <select name="idjenkel" id="idjenkel" class="form-control">
                                                                  <option value="1">Laki-laki</option>
                                                                  <option value="2">Perempuan</option>
                                                               </select>
                                                            </div>
                                                         </div>
                                                         @if($item1->idjenkel!=$item2->idjenkel)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Jenis Kelamin" valupdate="idjenkel" class="idjenkel ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('idstskawin', 'Status Marital:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            <div style="width: auto;" class="{!!$idstskawin!!} idstskawin">
                                                               {!! comboStsmarital("idstskawin","","") !!}
                                                            </div>
                                                         </div>
                                                         @if($item1->idstskawin!=$item2->idstskawin)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Status Marital" valupdate="idstskawin" class="idstskawin ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('idgoldarah', 'Golongan Darah:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            <div style="width: auto;" class="{!!$idgoldarah!!} idgoldarah">
                                                               {!! comboGoldarah("idgoldarah","","") !!}
                                                            </div>
                                                         </div>
                                                         @if($item1->idgoldarah!=$item2->idgoldarah)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Golongan Darah" valupdate="idgoldarah" class="idgoldarah ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('alm', 'Alamat:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            <textarea class="form-control {!!$alm!!}" name="alm" style="height: auto" id="alm"></textarea>
                                                         </div>
                                                         @if($item1->alm!=$item2->alm)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Alamat" valupdate="alm" class="alm ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>

                                                      <div class="form-group">
                                                           {!! Form::label('almrt', 'RT:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-3">
                                                               {!! Form::text('almrt', null, array('class'=> 'form-control num '.$almrt, 'placeholder'=> 'RT', 'maxlength'=>3)) !!}
                                                           </div>
                                                           <div class="col-sm-1" style="margin-top: 7px; padding: 0px">
                                                               @if($item1->almrt!=$item2->almrt)
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat RT" valupdate="almrt" class="almrt ver-perubahan"><i class="fa fa-check"></i></a>
                                                               @endif
                                                               <b>RW:</b>
                                                           </div>
                                                           <div class="col-sm-3">
                                                               {!! Form::text('almrw', null, array('class'=> 'form-control num '.$almrw, 'id'=>'almrw', 'placeholder'=> 'RW', 'maxlength'=>3)) !!}
                                                           </div>
                                                           @if($item1->almrw!=$item2->almrw)
                                                               <div class="col-sm-1" style="margin-top: 7px;">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat RW" valupdate="almrw" class="almrw ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('almdesa', 'Desa/Kelurahan:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('almdesa', null, array('class'=> 'form-control '.$almdesa, 'placeholder'=> 'Desa/Kelurahan')) !!}
                                                           </div>
                                                           @if($item1->almdesa!=$item2->almdesa)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat Desa/Kelurahan" valupdate="almdesa" class="almdesa ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('almkec', 'Kecamatan:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('almkec', null, array('class'=> 'form-control '.$almkec, 'placeholder'=> 'Kecamatan')) !!}
                                                           </div>
                                                           @if($item1->almkec!=$item2->almkec)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat Kecamatan" valupdate="almkec" class="almkec ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('almkab', 'Kabupaten/Kota:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('almkab', null, array('class'=> 'form-control '.$almkab, 'placeholder'=> 'Kabupaten')) !!}
                                                           </div>
                                                           @if($item1->almkab!=$item2->almkab)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat Kabupaten/Kota" valupdate="almkab" class="almkab ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('almprov', 'Provinsi:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('almprov', null, array('class'=> 'form-control '.$almprov, 'placeholder'=> 'Provinsi')) !!}
                                                           </div>
                                                           @if($item1->almprov!=$item2->almprov)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat Provinsi" valupdate="almprov" class="almprov ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('almkdpos', 'Kode POS:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('almkdpos', null, array('class'=> 'form-control '.$almkdpos, 'placeholder'=> 'Kode Pos', 'maxlength'=>6)) !!}
                                                           </div>
                                                           @if($item1->almkdpos!=$item2->almkdpos)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Alamat Kode POS" valupdate="almkdpos" class="almkdpos ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div><hr>

                                                      <div class="form-group">
                                                           {!! Form::label('telp', 'Telepon:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('telp', null, array('class'=> 'form-control '.$telp, 'placeholder'=> 'Telepon')) !!}
                                                           </div>
                                                           @if($item1->telp!=$item2->telp)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Telepon" valupdate="telp" class="telp ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('hp', 'No HP:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('hp', null, array('class'=> 'form-control '.$hp, 'placeholder'=> 'Handphone')) !!}
                                                           </div>
                                                           @if($item1->hp!=$item2->hp)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi No. HP" valupdate="hp" class="hp ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('email', 'E-Mail Pribadi:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('email', null, array('class'=> 'form-control '.$email, 'placeholder'=> 'Handphone')) !!}
                                                          </div>
                                                          @if($item1->email!=$item2->email)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi E-Mail" valupdate="email" class="email ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('nokarpeg', 'No. Karpeg/KPE:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('nokarpeg', null, array('class'=> 'form-control '.$nokarpeg, 'placeholder'=> 'No. Karpeg/KPE')) !!}
                                                           </div>
                                                           @if($item1->nokarpeg!=$item2->nokarpeg)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi No. Karpeg/KPE" valupdate="nokarpeg" class="nokarpeg ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('noaskes', 'No. Askes:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('noaskes', null, array('class'=> 'form-control '.$noaskes, 'placeholder'=> 'No. Askes')) !!}
                                                           </div>
                                                           @if($item1->noaskes!=$item2->noaskes)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi No. Askes" valupdate="noaskes" class="noaskes ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('notaspen', 'Taspen:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('notaspen', null, array('class'=> 'form-control '.$notaspen, 'placeholder'=> 'Taspen')) !!}
                                                           </div>
                                                           @if($item1->notaspen!=$item2->notaspen)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi Taspen" valupdate="notaspen" class="notaspen ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('nokaris', ' No. Karis/Karsu:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('nokaris', null, array('class'=> 'form-control '.$nokaris, 'placeholder'=> 'Karis/Karsu')) !!}
                                                           </div>
                                                           @if($item1->nokaris!=$item2->nokaris)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi No. Karis/Karsu" valupdate="nokaris" class="nokaris ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('nonpwp', 'NPWP:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('nonpwp', null, array('class'=> 'form-control '.$nonpwp, 'placeholder'=> 'NPWP')) !!}
                                                           </div>
                                                           @if($item1->nonpwp!=$item2->nonpwp)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi NPWP" valupdate="nonpwp" class="nonpwp ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                           {!! Form::label('noktp', 'No. KTP:', array('class' => 'col-sm-3 control-label')) !!}
                                                           <div class="col-sm-7">
                                                               {!! Form::text('noktp', null, array('class'=> 'form-control '.$noktp, 'placeholder'=> 'No. KTP')) !!}
                                                           </div>
                                                           @if($item1->noktp!=$item2->noktp)
                                                               <div class="col-sm-1">
                                                                   <a href="javascript:void(0)" title="Verifikasi No. KTP" valupdate="noktp" class="noktp ver-perubahan"><i class="fa fa-check"></i></a>
                                                               </div>
                                                           @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('nobapertarum', 'Bapertarum:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('nobapertarum', null, array('class'=> 'form-control '.$nobapertarum, 'placeholder'=> 'Bapertarum')) !!}
                                                         </div>
                                                         @if($item1->nobapertarum!=$item2->nobapertarum)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Bapertarum" valupdate="nobapertarum" class="nobapertarum ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>

                                                      <!-- Start SPMT CPNS -->
                                                      <p>
                                                          <div class="box-header with-border">
                                                              <b class="box-title"><small>SPMT CPNS / PPPK</small></b>
                                                          </div>
                                                      </p>
                                                      <div class="form-group">
                                                          {!! Form::label('nospmtcpn', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('nospmtcpn', null, array('class'=> 'form-control '.$nospmtcpn, 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                          </div>
                                                          @if($item1->nospmtcpn!=$item2->nospmtcpn)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi NO. SPMT CPNS" valupdate="nospmtcpn" class="nospmtcpn ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('tgspmtcpn', null, array('class'=> 'form-control date '.$tgspmtcpn, 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                          </div>
                                                          @if($item1->tgspmtcpn!=$item2->tgspmtcpn)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi TGL SPMT CPNS" valupdate="tgspmtcpn" class="tgspmtcpn ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('tmtspmtcpn', null, array('class'=> 'form-control date '.$tmtspmtcpn, 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                          </div>
                                                          @if($item1->tmtspmtcpn!=$item2->tmtspmtcpn)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi TMT SPMT CPNS" valupdate="tmtspmtcpn" class="tmtspmtcpn ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <!-- End SPMT CPNS -->

                                                      <!-- Start SPMT PNS -->
                                                      <p>
                                                          <div class="box-header with-border">
                                                              <b class="box-title"><small>SPMT PNS</small></b>
                                                          </div>
                                                      </p>
                                                      <div class="form-group">
                                                          {!! Form::label('nospmtpns', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('nospmtpns', null, array('class'=> 'form-control '.$nospmtpns, 'placeholder'=> 'NO. Surat SPMT')) !!}
                                                          </div>
                                                          @if($item1->nospmtpns!=$item2->nospmtpns)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi NO. SPMT PNS" valupdate="nospmtpns" class="nospmtpns ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('tgspmtpns', null, array('class'=> 'form-control date '.$tgspmtpns, 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                          </div>
                                                          @if($item1->tgspmtpns!=$item2->tgspmtpns)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi TGL. SPMT PNS" valupdate="tgspmtpns" class="tgspmtpns ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('tmtspmtpns', ' TMT  SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              {!! Form::text('tmtspmtpns', null, array('class'=> 'form-control date '.$tmtspmtpns, 'placeholder'=> 'dd-mm-yyyy')) !!}
                                                          </div>
                                                          @if($item1->tmtspmtpns!=$item2->tmtspmtpns)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi TMT. SPMT PNS" valupdate="tmtspmtpns" class="tmtspmtpns ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <!-- End SPMT PNS -->

                                                      <p>
                                                      <div class="box-header with-border">
                                                          <b class="box-title"><small><i class="fa fa-fw fa-street-view"></i> STATUS PEGAWAI</small></b>
                                                      </div>
                                                      </p>

                                                      <div class="form-group">
                                                          {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              <div style="width: auto;" class="{!!$idstspeg!!} idstspeg">
                                                                  {!! comboStsPegawai('idstspeg','','','idstspeg') !!}
                                                              </div>
                                                          </div>
                                                          @if($item1->idstspeg!=$item2->idstspeg)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi Status Pegawai" valupdate="idstspeg" class="idstspeg ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              <div style="width: auto;" class="{!!$idjenkepeg!!} idjenkepeg">
                                                                  {!! comboJenkepeg("idjenkepeg","","") !!}
                                                              </div>
                                                          </div>
                                                          @if($item1->idjenkepeg!=$item2->idjenkepeg)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi Jenis Kepegawaian" valupdate="idjenkepeg" class="idjenkepeg ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                          {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                                          <div class="col-sm-7">
                                                              <div style="width: auto;" class="{!!$idjenkedudupeg!!} idjenkedudupeg">
                                                                  {!! comboJenkedudupeg("idjenkedudupeg","","") !!}
                                                              </div>
                                                          </div>
                                                          @if($item1->idjenkedudupeg!=$item2->idjenkedudupeg)
                                                              <div class="col-sm-1">
                                                                  <a href="javascript:void(0)" title="Verifikasi Kedudukan Pegawai" valupdate="idjenkedudupeg" class="idjenkedudupeg ver-perubahan"><i class="fa fa-check"></i></a>
                                                              </div>
                                                          @endif
                                                      </div>

                                                      <p>
                                                      <div class="box-header with-border">
                                                           <b class="box-title"><small><i class="fa fa-fw fa-recycle"></i> KETERANGAN BADAN</small></b>
                                                      </div>
                                                      </p>

                                                      <div class="form-group">
                                                         {!! Form::label('tinggi', 'Tinggi:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('tinggi', null, array('class'=> 'form-control num '.$tinggi, 'placeholder'=> 'Tinggi', 'maxlength'=>3)) !!}
                                                         </div>
                                                         @if($item1->tinggi!=$item2->tinggi)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Tinggi Badan" valupdate="tinggi" class="tinggi ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('berat', 'Berat:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('berat', null, array('class'=> 'form-control num '.$berat, 'placeholder'=> 'Berat', 'maxlength'=>3)) !!}
                                                         </div>
                                                         @if($item1->berat!=$item2->berat)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Berat Badan" valupdate="berat" class="berat ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('rambut', 'Rambut:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('rambut', null, array('class'=> 'form-control '.$rambut, 'placeholder'=> 'Rambut')) !!}
                                                         </div>
                                                         @if($item1->rambut!=$item2->rambut)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Rambut" valupdate="rambut" class="rambut ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('muka', ' Bentuk Muka:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('muka', null, array('class'=> 'form-control '.$muka, 'placeholder'=> 'Bentuk Muka')) !!}
                                                         </div>
                                                         @if($item1->muka!=$item2->muka)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Bentuk Muka" valupdate="muka" class="muka ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('kulit', ' Warna Kulit:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('kulit', null, array('class'=> 'form-control '.$kulit, 'placeholder'=> 'Warna Kulit')) !!}
                                                         </div>
                                                         @if($item1->kulit!=$item2->kulit)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Warna Kulit" valupdate="kulit" class="kulit ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('ciri', 'Ciri Khas:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('ciri', null, array('class'=> 'form-control '.$ciri, 'placeholder'=> 'Ciri Khas')) !!}
                                                         </div>
                                                         @if($item1->ciri!=$item2->ciri)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Ciri Khas" valupdate="ciri" class="ciri ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('cacat', 'Cacat Tubuh:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('cacat', null, array('class'=> 'form-control '.$cacat, 'placeholder'=> 'Cacat Tubuh')) !!}
                                                         </div>
                                                         @if($item1->cacat!=$item2->cacat)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Cacat Tubuh" valupdate="cacat" class="cacat ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>

                                                      <p>
                                                      <div class="box-header with-border">
                                                         <b class="box-title"><small><i class="fa fa-fw fa-recycle"></i> HOBBY</small></b>
                                                      </div>
                                                      </p>

                                                      <div class="form-group">
                                                         {!! Form::label('hobby1', 'Hobby 1:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('hobby1', null, array('class'=> 'form-control '.$hobby1, 'placeholder'=> 'Hobby 1')) !!}
                                                         </div>
                                                         @if($item1->hobby1!=$item2->hobby1)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Hobby 1" valupdate="hobby1" class="hobby1 ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('hobby2', 'Hobby 2:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('hobby2', null, array('class'=> 'form-control '.$hobby2, 'placeholder'=> 'Hobby 2')) !!}
                                                         </div>
                                                         @if($item1->hobby2!=$item2->hobby2)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Hobby 2" valupdate="hobby2" class="hobby2 ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('hobby3', 'Hobby 3:', array('class' => 'col-sm-3 control-label')) !!}
                                                         <div class="col-sm-7">
                                                            {!! Form::text('hobby3', null, array('class'=> 'form-control '.$hobby3, 'placeholder'=> 'Hobby 3')) !!}
                                                         </div>
                                                         @if($item1->hobby3!=$item2->hobby3)
                                                            <div class="col-sm-1">
                                                               <a href="javascript:void(0)" title="Verifikasi Hobby 3" valupdate="hobby3" class="hobby3 ver-perubahan"><i class="fa fa-check"></i></a>
                                                            </div>
                                                         @endif
                                                      </div>
                                                   </span>
                                                </div>
                                             </div>
                                               <!-- /.box-body -->
                                          </div>
                                       </div>
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </p>
                     </div>
                     <!-- /.tab-pane -->
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-body">
                  <!--<div class="col-md-12">-->
                  <!-- Custom Tabs -->
                  <div class="nav-tabs-custom" style="box-shadow:none;">
                     <ul class="nav nav-tabs tab1" id="myTab2">
                        <li class="active"><a data-toggle="tab" href="#lokasijab"> <i class="fa fa-fw fa-map-marker"></i> LOKASI & JABATAN</a></li>
                        <li><a data-toggle="tab" href="#pangkatgol"> <i class="fa fa-fw fa-paper-plane-o"></i> CPNS / PNS</a></li>
                        <li><a data-toggle="tab" href="#pangkatakhir"> <i class="fa fa-fw fa-anchor"></i> PANGKAT TERKHIR</a></li>
                        <li><a data-toggle="tab" href="#kgbterakhir"> <i class="fa fa-fw fa-money"></i> KGB TERAKHIR</a></li>
                        <li><a data-toggle="tab" href="#pendidikan"> <i class="fa fa-fw fa-graduation-cap"></i> PENDIDIKAN</a></li>
                     </ul>

                     <div class="tab-content data-awal">
                        <div id="lokasijab" class="tab-pane active">
                           <div class="row">
                              <div class="col-md-6">
                                 <p>
                                    <div class="box-header with-border">
                                       <b class="box-title"><small>LOKASI KERJA</small></b>
                                    </div>
                                 </p>
                                 <div class="form-group">
                                     {!! Form::label('kdunit', 'Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                     <div class="col-sm-7">
                                         <div class="form-control kdunit">{{($item1->unitskpd!='')?$item1->unitskpd:'-'}}</div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     {!! Form::label('idskpd', 'Sub Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                     <div class="col-sm-7">
                                         <div class="form-control idskpd">{{($item1->skpd!='')?$item1->skpd:'-'}}</div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     {!! Form::label('idstspeg', 'Status Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                     <div class="col-sm-7">
                                         <div class="form-control idstspeg">{{($item1->stspeg!='')?$item1->stspeg:'-'}}</div>
                                     </div>

                                 </div>
                                 <div class="form-group">
                                     {!! Form::label('idjenkepeg', 'Jenis Kepegawaian:', array('class' => 'col-sm-3 control-label')) !!}
                                     <div class="col-sm-7">
                                         <div class="form-control idjenkepeg">{{($item1->jenkepeg!='')?$item1->jenkepeg:'-'}}</div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     {!! Form::label('idjenkedudupeg', 'Kedudukan Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                                     <div class="col-sm-7">
                                         <div class="form-control idjenkedudupeg">{{($item1->jenkedudupeg!='')?$item1->jenkedudupeg:'-'}}</div>
                                     </div>
                                 </div>
                              </div>

                              <div class="col-md-6 div-disabled">
                                 <p>
                                    <div class="box-header with-border">
                                       <b class="box-title"><small>JABATAN TERAKHIR</small></b>
                                    </div>
                                 </p>
                                 <div class="form-group">
                                    {!! Form::label('pejmenjbt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->penetappkt!='')?$item1->penetappkt:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->jenjab!='')?$item1->jenjab:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idjabjbt', 'Nama Jabatan :', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7" id="jenisjabatan">
                                        <div class="form-control">{{($item1->jabatan!='')?$item1->jabatan:'-'}}</div>
                                    </div>
                                </div>
                                @if($item1->idjenjab == '1')
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" class="esl">Eselon:</label>
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->esl!='')?$item1->esl:'-'}}</div>
                                    </div>
                                </div>
                                @endif

                                @if($item1->isguru == '1')
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" class="tugasgurudosen">Tugas Guru:</label>
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tugasgurudosen!='')?$item1->tugasgurudosen:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" class="matkulpel">Mata Pelajaran:</label>
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->matkulpel!='')?$item1->matkulpel:'-'}}</div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    {!! Form::label('noskjbt', ' NO. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->noskjbt!='')?$item1->noskjbt:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgskjbt', 'TGL. SK Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tgskjbt!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskjbt)):'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tmtjbt', 'TMT Jab:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtjbt)):'-'}}</div>
                                    </div>
                                </div>
                              </div>
                           </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div id="pangkatgol" class="tab-pane">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="div-disabled">
                                    <p>
                                       <div class="box-header with-border">
                                          <b class="box-title"><small>CPNS</small></b>
                                       </div>
                                    </p>
                                    <div class="form-group">
                                        {!! Form::label('pejmencpn', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class="form-control pejmencpn">{{($item1->penetapcpn!='')?$item1->penetapcpn:'-'}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('idgolrucpn', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class="form-control idgolrucpn">{{($item1->golrucpn!='')?$item1->golrucpn:'-'}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('noskcpn', ' NO. SK:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK')) !!}
                                        <div class="col-sm-7">
                                            <div class="form-control noskcpn">{{($item1->noskcpn!='')?$item1->noskcpn:'-'}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('tgskcpn', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class="form-control tgskcpn">{{($item1->tgskcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskcpn)):'-'}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('tmtcpn', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-7">
                                            <div class="form-control tmtcpn">{{($item1->tmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtcpn)):'-'}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('mkthncpn', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-2">
                                            <div class="form-control mkthncpn">{{($item1->mkthncpn!='')?$item1->mkthncpn:'-'}}</div>
                                        </div>
                                        <div class="col-sm-1" style="margin-top: 7px;">
                                            Tahun
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-control mkblncpn">{{($item1->mkblncpn!='')?$item1->mkblncpn:'-'}}</div>
                                        </div>
                                        <div class="col-sm-1" style="margin-top: 7px;">
                                            Bulan
                                        </div>
                                    </div>
                                 </div>

                                 <div>
                                 <!-- Start SPMT CPNS -->
                                    <hr>
                                       <p>
                                          <div class="box-header with-border">
                                             <b class="box-title"><small>SPMT CPNS</small></b>
                                          </div>
                                       </p>
                                       <div class="form-group">
                                          {!! Form::label('nospmtcpn', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. Surat SPMT')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control nospmtcpn">{{($item1->nospmtcpn!='')?$item1->nospmtcpn:'-'}}</div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          {!! Form::label('tgspmtcpn', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control tgspmtcpn">{{($item1->tgspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtcpn)):'-'}}</div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          {!! Form::label('tmtspmtcpn', ' TMT SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control tmtspmtcpn">{{($item1->tmtspmtcpn!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtcpn)):'-'}}</div>
                                          </div>
                                      </div>
                                       <!-- End SPMT CPNS -->
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="div-disabled">
                                    <p>
                                       <div class="box-header with-border">
                                          <b class="box-title"><small>PNS</small></b>
                                       </div>
                                    </p>
                                    <div class="form-group">
                                       {!! Form::label('pejmenpns', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-7">
                                           <div class="form-control pejmenpns">{{($item1->penetappns!='')?$item1->penetappns:'-'}}</div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       {!! Form::label('idgolrupns', 'Golongan :', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-7">
                                           <div class="form-control idgolrupns">{{($item1->golrupns!='')?$item1->golrupns:'-'}}</div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       {!! Form::label('noskpns', ' NO. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-7">
                                           <div class="form-control noskpns">{{($item1->noskpns!='')?$item1->noskpns:'-'}}</div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       {!! Form::label('tgskpns', 'TGL. SK:', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-7">
                                           <div class="form-control tgskpns">{{($item1->tgskpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskpns)):'-'}}</div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       {!! Form::label('tmtpns', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-7">
                                           <div class="form-control tmtpns">{{($item1->tmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtpns)):'-'}}</div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       {!! Form::label('mkthnpns', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                       <div class="col-sm-2">
                                           <div class="form-control mkthnpns">{{($item1->mkthnpns!='')?$item1->mkthnpns:'-'}}</div>
                                       </div>
                                       <div class="col-sm-1" style="margin-top: 7px;">
                                           Tahun
                                       </div>
                                       <div class="col-sm-2">
                                           <div class="form-control mkblnpns">{{($item1->mkblnpns!='')?$item1->mkblnpns:'-'}}</div>
                                       </div>
                                       <div class="col-sm-1" style="margin-top: 7px;">
                                           Bulan
                                       </div>
                                   </div>
                                 </div>

                                 <div>
                                    <!-- Start SPMT PNS -->
                                    <hr>
                                       <p>
                                          <div class="box-header with-border">
                                             <b class="box-title"><small>SPMT PNS</small></b>
                                          </div>
                                       </p>
                                       <div class="form-group">
                                          {!! Form::label('nospmtpns', ' NO. Surat SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control nospmtpns">{{($item1->nospmtpns!='')?$item1->nospmtpns:'-'}}</div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          {!! Form::label('tgspmtpns', 'TGL. SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control tgspmtpns">{{($item1->tgspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tgspmtpns)):'-'}}</div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          {!! Form::label('tmtspmtpns', ' TMT  SPMT:', array('class' => 'col-sm-3 control-label')) !!}
                                          <div class="col-sm-7">
                                              <div class="form-control tmtspmtpns">{{($item1->tmtspmtpns!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtspmtpns)):'-'}}</div>
                                          </div>
                                      </div>
                                       <!-- End SPMT PNS -->
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- /.tab-pane -->
                        <div id="pangkatakhir" class="tab-pane">
                           <div class="row">
                              <div class="col-md-6 div-disabled">
                                 <p>
                                    <div class="box-header with-border">
                                       <b class="box-title"><small>PANGKAT TERAKHIR</small></b>
                                    </div>
                                 </p>

                                 <div class="form-group">
                                    {!! Form::label('pejmenpkt', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->penetappkt!='')?$item1->penetappkt:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idgolrupkt', 'Golongan Ruang:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->golrupkt!='')?$item1->golrupkt:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('noskpkt', ' NO. SK Gol.:', array('class' => 'col-sm-3 control-label', 'placeholder'=> 'NO. SK Gol.')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->noskpkt!='')?$item1->noskpkt:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgskpkt', ' TGL. SK Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tgskpkt!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskpkt)):'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tmtpkt', 'TMT Gol.:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtpkt)):'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('mkthnpkt', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        <div class="form-control">{{($item1->mkthnpkt!='')?$item1->mkthnpkt:'-'}}</div>
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 7px;">
                                        Tahun
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-control">{{($item1->mkblnpkt!='')?$item1->mkblnpkt:'-'}}</div>
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 7px;">
                                        Bulan
                                    </div>
                                </div>
                              </div>
                           </div>
                        </div>
                         <!-- /.tab-pane -->

                        <div id="kgbterakhir" class="tab-pane">
                           <div class="row">
                              <div class="col-md-6 div-disabled">
                                 <p>
                                    <div class="box-header with-border">
                                       <b class="box-title"><small>KGB TERAKHIR</small></b>
                                    </div>
                                 </p>

                                 <div class="form-group">
                                    {!! Form::label('pejmenkgb', 'Penetap:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->penetapkgb!='')?$item1->penetapkgb:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idgolkgb', 'Golongan:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->golrukgb!='')?$item1->golrukgb:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('noskkgb', 'NO. SP KGB:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->noskkgb!='')?$item1->noskkgb:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tgskkgb', ' TGL. SP:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tgskkgb!='0000-00-00')?date('d-m-Y', strtotime($item1->tgskkgb)):'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tmtkgb', ' TMT:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tmtkgb!='0000-00-00')?date('d-m-Y', strtotime($item1->tmtkgb)):'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('mkgolthnkgb', 'Masa Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-2">
                                        <div class="form-control">{{($item1->mkgolthnkgb!='')?$item1->mkgolthnkgb:'-'}}</div>
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 7px;">
                                        Tahun
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-control">{{($item1->mkgolblnkgb!='')?$item1->mkgolblnkgb:'-'}}</div>
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 7px;">
                                        Bulan
                                    </div>
                                </div>
                              </div>
                           </div>
                        </div>
                         <!-- /.tab-pane -->

                        <div id="pendidikan" class="tab-pane">
                           <div class="row">
                              <div class="col-md-6 div-disabled">
                                 <p>
                                    <div class="box-header with-border">
                                       <b class="box-title"><small>PENDIDIKAN AWAL</small></b>
                                    </div>
                                 </p>

                                 <div class="form-group">
                                    {!! Form::label('idtkpendidawal', 'Pendidikan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->tkpendidawal!='')?$item1->tkpendidawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('idjenjurusanawal', 'Jurusan Awal:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->jenjurusanawal!='')?$item1->jenjurusanawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('noijazawal', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->noijazawal!='')?$item1->noijazawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('thijazawal', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->thijazawal!='')?$item1->thijazawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('namasekolahawal', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->namasekolahawal!='')?$item1->namasekolahawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('almsekolahawal', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->almsekolahawal!='')?$item1->almsekolahawal:'-'}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('kepsekawal', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7">
                                        <div class="form-control">{{($item1->kepsekawal!='')?$item1->kepsekawal:'-'}}</div>
                                    </div>
                                </div>

                                 </div>

                                 <div class="col-md-6 div-disabled">
                                     <p>
                                     <div class="box-header with-border">
                                         <b class="box-title"><small>PENDIDIKAN AKHIR</small></b>
                                     </div>
                                     </p>

                                     <div class="form-group">
                                         {!! Form::label('idtkpendid', 'Pendidikan Terakhir:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->idtkpendid!='')?$item1->tkpendidakhir:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('idjenjurusan', 'Jurusan:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->idjenjurusan!='')?$item1->jenjurusanakhir:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('noijaz', ' Nomor Ijazah:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->noijaz!='')?$item1->noijaz:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('thijaz', ' Tahun Lulus:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->thijaz!='')?$item1->thijaz:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('namasekolah', ' Nama Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->namasekolah!='')?$item1->namasekolah:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('almsekolah', ' Alamat Sekolah / Kampus:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->almsekolah!='')?$item1->almsekolah:'-'}}</div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         {!! Form::label('kepsek', ' Kepala Sekolah / Rektor:', array('class' => 'col-sm-3 control-label')) !!}
                                         <div class="col-sm-7">
                                             <div class="form-control">{{($item1->kepsek!='')?$item1->kepsek:'-'}}</div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- /.tab-pane -->
                     </div>
                  </div>
                  <!-- /.tab-content -->
               </div>

            </div>
         </div>
      </div>

      @if($item2->status != '1')
      <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
               <div class="col-md-6">
                     <div class="box-header">
                          <h3 class="box-title"><i class="fa fa-fw fa-check"></i> VERIFIKASI SEMUA PERUBAHAN BIODATA </h3>
                     </div>
                     <div class="box-body">
                          <div class="col-md-12 data-verifikasi">
                             @if(session('role_id') <= 3)
                             <div class="form-group">
                                  {!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                                  <div class="col-sm-7">
                                      <select name="status" id="status" class="form-control" required>
                                          <option value="0">.: Pilihan :.</option>
                                          <option value="1">Disetujui</option>
                                          <option value="2">Ditolak</option>
                                      </select>
                                  </div>
                             </div>
                             <div class="form-group" id="xketditolak">
                                  {!! Form::label('ketditolak', 'Keterangan :', array('class' => 'col-sm-3 control-label')) !!}
                                  <div class="col-sm-7">
                                      <textarea rows="5" cols="150" id="ketditolak" name="ketditolak" placeholder="Keterangan Jika Ditolak" class="form-control"></textarea>
                                  </div>
                             </div>
                             <div class="form-group">
                                  <label for="" class="col-sm-3 control-label"></label>
                                  <div class="col-sm-7">
                                      <div class="checkbox">
                                          <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                          <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" onclick="claravel_modal_close('main_modal2');"></i> Batalkan</button>
                                      </div>
                                  </div>
                             </div>
                             @else
                             <div class="form-group">
                                  {!! Form::label('status', 'Status:', array('class' => 'col-sm-3 control-label')) !!}
                                  <div class="col-sm-7">
                                      <span id='stspermohonan'></span>
                                  </div>
                             </div>
                             <div class="form-group">
                                  {!! Form::label('ketditolak', 'Keterangan :', array('class' => 'col-sm-3 control-label')) !!}
                                  <div class="col-sm-7">
                                      <span id='ketpermohonan'></span>
                                  </div>
                             </div>
                             <em>* Perubahan biodata yang belum diverifikasi ditandai dengan inputan garis warna merah</em>
                             @endif
                          </div>
                     </div>
                 </div>
                 <div class="col-md-6">&nbsp;</div>
             </div>
        </div>
      </div>
      @endif
   </section>
</form>

<style type="text/css">
    .data-awal .form-control{
        height: auto;
        background-color: #ececec;
    }

    .alert-dangers{
        border: 2px solid red;
    }

    .modal {
      overflow: auto !important;
   }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('.data-perubahan select').select2();
        $('.data-verifikasi select').select2();
        $('.data-perubahan #xketditolak').fadeOut();
        $('.data-verifikasi #xketditolak').fadeOut();
        //$('.data-perubahan #changeimage, .data-perubahan .xjabstruk, .data-perubahan .xjabfung, .data-perubahan .xisguru, .data-perubahan .xisdokter, .data-perubahan .alert-biodata').fadeOut();
        $('.data-perubahan #changeimage, .data-perubahan .alert-biodata').fadeOut();
        $('.data-perubahan .div-disabled').css('pointer-events','none');
        $('.data-perubahan .div-disabled .select2-selection, .data-perubahan .div-disabled input, .data-perubahan .div-disabled textarea').css('background-color','#ececec');
        @if(session('role_id') > 3)
            $('.data-perubahan .div-disabled a').fadeOut();
        @endif
        $('.data-perubahan .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $(".data-perubahan .date").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".data-perubahan .date").mask("99-99-9999");

        autoComplete('.data-perubahan #tmlhr', '{{url()}}/epersonal/biodata/tempatlahir', '.: Pilihan :.', null, '', '', '');

      //   $('.data-perubahan #idtkpendidawal').on('change', function(e){
      //       e.preventDefault();
      //       autoComplete('.data-perubahan #idjenjurusanawal', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '', $(this).val());
      //       $('.data-perubahan .div-disabled .select2-selection').css('background-color','#ececec');
      //   });

      //   $('.data-perubahan #idtkpendid').on('change', function(e){
      //       e.preventDefault();
      //       autoComplete('.data-perubahan #idjenjurusan', '{{url()}}/epersonal/biodata/jenjurusan', '.: Pilihan :.', null, '', '',  $(this).val());
      //       $('.data-perubahan .div-disabled .select2-selection').css('background-color','#ececec');
      //   });

      //   $('.data-perubahan #kdunit').on('change', function(e){
      //       e.preventDefault();
      //       autoComplete('.data-perubahan #idskpd', '{{url()}}/epersonal/biodata/skpdunit', '.: Pilihan :.', null, $(this).val(), $(this).find(":selected").text(),  $(this).val());
      //   });

      //   $('.data-perubahan #idskpd').on('change', function(e){
      //       e.preventDefault();
      //       autoComplete('.data-perubahan #idjabjbt', '{{url()}}/epersonal/biodata/jabstruk', '.: Pilihan :.', null, '', '', $(this).val());
      //   });

      //   $('.data-perubahan #idtugasgurudosen').on('change', function(e){
      //       e.preventDefault();
      //       autoComplete('.data-perubahan #idmatkulpel', '{{url()}}/epersonal/biodata/matkulpel', '.: Pilihan :.', null, '', '',  $(this).val());
      //   });

      //   $('.data-perubahan #idjenjab').on('change', function(e){
      //       e.preventDefault();
      //       var idjenjab = $(this).val();
      //       $.ajax({
      //           url:'{{url()}}/epersonal/biodata/jenisjabatanperubahan',
      //           type:'post',
      //           data:{'idjenjab': $(this).val(), 'nip': $('.data-awal .nip').val(), '_token' : '{!!csrf_token()!!}'},
      //           beforeSend:function(){
      //               $('.data-perubahan #jenisjabatan').html('Looading...');
      //           },
      //           success:function(respose){
      //               $('.data-perubahan #xjenisjabatan').html(respose);
      //           }
      //       })
      //   });

        $('.data-verifikasi #status').on('change', function(e){
            e.preventDefault();
            var id = $('.data-verifikasi #status').val();
            if(id == 2){
                $('.data-verifikasi #xketditolak').fadeIn();
            }else{
                $('.data-verifikasi #xketditolak').fadeOut();
            }
        }).trigger('change');

        perubahanBiodata();

        $('.ver-perubahan').on('click', function(e){
            e.preventDefault(e);
            var nip = $('.data-awal .nip').val();
            var text = $(this).attr('valupdate');
            var title = $(this).attr('title');
            var value = $('.data-perubahan #'+text).val();

            bootbox.confirm(title+' ?',function(a){
                if (a == true){
                    $.ajax({
                        url  : '{{url()}}/epersonal/biodata/verbiodata',
                        type : 'POST',
                        data : {'nip': nip, 'text': text, 'value': value, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==4){
                                notification('Data Berhasil Diverifikasi','success');
                                $('.data-perubahan #'+text).removeClass('alert-dangers');
                                $('div.'+text).removeClass('alert-dangers');
                                $('a.'+text).fadeOut();
                                loadBiodata2();
                            }else if(html==5){
                                notification('Semua Perubahan Sudah Diverifikasi','success');
                                claravel_modal_close('main_modal3');
                                @if(Request::segment(5) == 'biodata')
                                    refresh_page();
                                @else
                                    loadBiodata2();
                                @endif
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-perubahan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Verifikasi Semua Perubahan Data ?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html==4){
                                notification('Verifikasi Data Berhasil','success');
                                claravel_modal_close('main_modal3');
                                @if(Request::segment(5) == 'biodata')
                                    refresh_page();
                                @else
                                    loadBiodata2();
                                @endif
                            }else if(html==5){
                                notification('Success Verifikasi Ditolak','success');
                                @if(Request::segment(5) == 'biodata')
                                    refresh_page();
                                @endif
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });

        /*function preview perubahan data*/
        $('ul#myTabs').on('click','a',function(e){
           e.preventDefault(e);
           var ket = $(this).attr('id');
           if(ket == 'biodata'){
             var tipe = 'post';
             var alamat = '{!!url()!!}/epersonal/biodata/data/perubahan_biodata_all/biodata';
           }else{
             var tipe = 'get';
             var alamat = '{!!url()!!}/epersonal/perubahanriwayat/'+ket+'detail/'+ket;
           }

           $.ajax({
               type: tipe,
               url : alamat,
               data: {'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
             beforeSend:function(){
                  $('.modal-body').html('Looading..');
             },
               success:function(html){
                   $('#main_modal3 .modal-body').html(html);
               }
           });

        });
    });

    function perubahanBiodata(){
       var nip = $('.data-awal .nip').val();

       $.ajax({
            url  : '{{url()}}/epersonal/biodata/detailpegawaiperubahan',
            type : 'POST',
            data : {'nip': nip, '_token' : '{!!csrf_token()!!}'},
            beforeSend: function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
               //  var arrdate = new Array("tglhr","tgskjbt","tmtjbt","tgskcpn","tmtcpn","tgspmtcpn","tmtspmtcpn","tgskpns","tmtpns","tgspmtpns","tmtspmtpns","tgskpkt","tmtpkt","tgskkgb","tmtkgb");
               var arrdate = new Array("tglhr","tgspmtcpn","tmtspmtcpn","tgspmtpns","tmtspmtpns");
                var arraytext = new Array("ketpermohonan","stspermohonan");
                /*var arrayradio = new Array("idjenkel","idstspeg");*/
               //  var arrselect2 = new Array("idagama","idstskawin","idgoldarah","idjenkepeg","idjenkedudupeg","idskpd","kdunit","pejmenjbt","idjenjab","pejmencpn","idgolrucpn","pejmenpns","idgolrupns","pejmenpkt","idgolrupkt","pejmenkgb","idgolkgb","idgolkgb","idtkpendid","idtkpendidawal","idjenkel","idstspeg");
                var arrselect2 = new Array("idagama","idstskawin","idgoldarah","idjenkepeg","idjenkedudupeg","idjenkel","idstspeg");

                if(ret){
                    for(attrname in ret){
                        $('.data-perubahan #id').val(ret.nip);
                        $('.data-perubahan #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arraytext)!=-1){
                            $('#'+attrname).html(ret[attrname]);
                        }
                        /*if($.inArray(attrname,arrayradio)!=-1){
                            $('input[name='+attrname+'][value='+ret[attrname]+']').prop('checked',true);
                        }*/
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('.data-perubahan #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('.data-perubahan #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }

                    @if(session('role_id') <= 3)
                    $('.data-verifikasi #status').select2('val',ret.status);
                    $('.data-verifikasi #ketditolak').val(ret.ketditolak);
                    @endif

                    $('.data-perubahan .awal').attr('disabled', false);
                    $('.data-perubahan #myTab li').removeClass('disabled');

                    $('.data-perubahan .tab1 li, .data-perubahan .tab2 li, .data-perubahan .tab3 li').removeClass('active');
                    $('.data-perubahan #myTab li').first().addClass('active');

                    $('.data-perubahan .tab-content div').removeClass('active');
                    $('.data-perubahan .tab-content #biodata').addClass('active');
                    $('.data-perubahan #myTab li').css({ 'pointer-events': ''});

                    $(".data-perubahan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/"+ret.photo+"" );
                    $('.data-perubahan #changeimage').fadeIn();
                  //   $(".data-perubahan #idskpd").data('select2').trigger('select', {
                  //       data: {"id":ret.idskpd,"text":ret.skpd}
                  //   });

                  //   $(".data-perubahan #idjenjurusanawal").data('select2').trigger('select', {
                  //       data: {"id":ret.idjenjurusanawal,"text":ret.jenjurusanawal}
                  //   });

                  //   $(".data-perubahan #idjenjurusan").data('select2').trigger('select', {
                  //       data: {"id":ret.idjenjurusan,"text":ret.jenjurusan}
                  //   });

                    $(".data-perubahan #tmlhr").data('select2').trigger('select', {
                        data: {"id":ret.tmlhr,"text":ret.tmlhr}
                    });

                  //   if(ret.idjenjab == 1){
                  //       $('.data-perubahan .xjabstruk').fadeIn();
                  //   }else if(ret.idjenjab == 2){
                  //       $('.data-perubahan .xjabfung').fadeIn();
                  //   }else{
                  //       $('.data-perubahan .xjabstruk, .data-perubahan .xjabfung').fadeOut();
                  //   }

                  //   if(ret.isguru == 1){
                  //       $('.data-perubahan .xisguru').fadeIn();
                  //   }else if(ret.isguru == 2){
                  //       $('.data-perubahan .xisdokter').fadeIn();
                  //   }else{
                  //       $('.data-perubahan .xisguru, .data-perubahan .xisdokter').fadeOut();
                  //   }
                }else{
                    $('.data-perubahan .awal').attr('disabled', true);
                    $('.data-perubahan #myTab li').addClass('disabled');
                    $('.data-perubahan #myTab li').css({ 'pointer-events': 'none'});
                    $('.data-perubahan #myTab li, .data-perubahan .tab-pane').removeClass('active');

                    $(".data-perubahan").find('input:text, input:password, input:file, select, textarea').val('');
                  //   $(".data-perubahan").find('#idagama, #idstskawin, #idgoldarah, #kdunit, #idjenkepeg, #idjenkedudupeg, #idjenjab, #pejmencpn, #idgolrucpn, #pejmenpns, #idgolrupns, #pejmenpkt, #idgolrupkt, #pejmenkgb, #idgolkgb, #idtkpendidawal, #idtkpendid, #idtugasgurudosen').val('').trigger('change');
                   $(".data-perubahan").find('#idagama, #idstskawin, #idgoldarah,  #idjenkepeg, #idjenkedudupeg').val('').trigger('change');
                    $(".data-perubahan").find('#tmlhr').data('select2').trigger('select', {
                        data: {"id":"","text":""}
                    });
                    $('.data-perubahan #changeimage, .data-perubahan .alert-biodata').fadeOut();
                    //$("#skpdunit").html('');
                    $(".data-perubahan #propic").attr( "src", "{!!url()!!}/packages/upload/photo/pegawai/default.jpg" );
                    $(".data-perubahan").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                  //   $('.data-perubahan .xjabstruk, .data-perubahan .xjabfung, .data-perubahan .xisguru, .data-perubahan .xisdokter').fadeOut();
                }
            }
       });
    }
</script>
