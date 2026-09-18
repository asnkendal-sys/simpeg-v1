<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#statistik" data-toggle="tab"><i class="fa fa-bar-chart"></i> Statistik</a></li>
    <li class=""><a href="#grafik" data-toggle="tab"><i class="fa fa-table"></i> Grafik</a></li>
</ul>
<div class="tab-content" style="overflow:visible">
    <div class="tab-pane active" id="statistik">
        <div class="row-fluid">
            <div class="span12">
                {!! View::make('statistikpegawai::statistikrekappensiun_statistik') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="grafik">
        <div class="row-fluid">
            <div class="span12" id="result-graph">
                {!! View::make('statistikpegawai::statistikrekappensiun_graph') !!}
            </div>
        </div>
    </div>

</div>