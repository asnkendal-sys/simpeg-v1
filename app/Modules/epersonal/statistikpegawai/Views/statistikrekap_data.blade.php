
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
				case 1: echo View::make('statistikpegawai::statistikrekap_jabatan_golongan'); break;
				case 2: echo View::make('statistikpegawai::statistikrekap_jabstru_golongan'); break;
				case 3: echo View::make('statistikpegawai::statistikrekap_jabfung_golongan'); break;
        case 4: echo View::make('statistikpegawai::statistikrekap_jabfungum_golongan'); break;
				case 5: echo View::make('statistikpegawai::statistikrekap_profil_pns'); break;
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
					case 1: echo View::make('statistikpegawai::statistikrekap_jabatan_golongan_graph'); break;
					case 2: echo View::make('statistikpegawai::statistikrekap_jabstru_golongan_graph'); break;
					case 3: echo View::make('statistikpegawai::statistikrekap_jabfung_golongan_graph'); break;
	        case 4: echo View::make('statistikpegawai::statistikrekap_jabfungum_golongan_graph'); break;
					case 5: echo View::make('statistikpegawai::statistikrekap_profil_pns_graph'); break;
          default: echo "<p><br>* Pilihan kategori harus diisi.</p>"; break;
				}
				?>
			</div>
		</div>
	</div>

</div>
