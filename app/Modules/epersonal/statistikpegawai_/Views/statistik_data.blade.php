
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#statistik" data-toggle="tab"><i class="fa fa-bar-chart"></i> Statistik</a></li>
	<li class=""><a href="#grafik" data-toggle="tab"><i class="fa fa-table"></i> Grafik</a></li>
</ul>
<div class="tab-content" style="overflow:visible">
	<div class="tab-pane active" id="statistik">
		<div class="row-fluid">
			<div class="span12">
			<?php
			switch(Input::get('idkategori')){
				case 1: echo View::make('statistikpegawai::statistik_pendformal'); break;
                case 2: echo View::make('statistikpegawai::statistik_ukerja_pendformal'); break;
                case 3: echo View::make('statistikpegawai::statistik_ukerja_golongan'); break;
                case 4: echo View::make('statistikpegawai::statistik_jenkel_golongan'); break;
                case 5: echo View::make('statistikpegawai::statistik_statuskedu_pegawai'); break;
                case 6: echo View::make('statistikpegawai::statistik_diklat_struktural'); break;
                case 7: echo View::make('statistikpegawai::statistik_eselon'); break;
                case 8: echo View::make('statistikpegawai::statistik_jenkel_eselon'); break;
				case 9: echo View::make('statistikpegawai::statistik_agama'); break;
				case 10: echo View::make('statistikpegawai::statistik_usia'); break;
				case 11: echo View::make('statistikpegawai::statistik_perkawinan'); break;
				case 12: echo View::make('statistikpegawai::statistik_jabfungum'); break;
				case 13: echo View::make('statistikpegawai::statistik_jabfung'); break;
				case 14: echo View::make('statistikpegawai::statistik_jabfung_guru'); break;
                default: echo "<p><br>* Pilihan kategori harus diisi.</p>"; break;
			}
			?>
			</div>
		</div>				
	</div>
	<div class="tab-pane" id="grafik">
		<div class="row-fluid">
			<div class="span12" id="result-graph">
				<?php
				switch(Input::get('idkategori')){
					case 1: echo View::make('statistikpegawai::statistik_pendformal_graph'); break;
                    case 2: echo View::make('statistikpegawai::statistik_ukerja_pendformal_graph'); break;
                    case 3: echo View::make('statistikpegawai::statistik_ukerja_golongan_graph'); break;
                    case 4: echo View::make('statistikpegawai::statistik_jenkel_golongan_graph'); break;
                    case 5: echo View::make('statistikpegawai::statistik_statuskedu_pegawai_graph'); break;
                    case 6: echo View::make('statistikpegawai::statistik_diklat_struktural_graph'); break;
                    case 7: echo View::make('statistikpegawai::statistik_eselon_graph'); break;
                    case 8: echo View::make('statistikpegawai::statistik_jenkel_eselon_graph'); break;
					case 9: echo View::make('statistikpegawai::statistik_agama_graph'); break;
					case 10: echo View::make('statistikpegawai::statistik_usia_graph'); break;
					case 11: echo View::make('statistikpegawai::statistik_perkawinan_graph'); break;
					case 12: echo View::make('statistikpegawai::statistik_jabfungum_graph'); break;
					case 13: echo View::make('statistikpegawai::statistik_jabfung_graph'); break;
					case 14: echo View::make('statistikpegawai::statistik_jabfung_guru_graph'); break;
                    default: echo "<p><br>* Pilihan kategori harus diisi.</p>"; break;
				}
				?>
			</div>
		</div>				
	</div>
	
</div>	
		