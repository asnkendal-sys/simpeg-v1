<style type="text/css">
	.previewfile{
		width: 660px;
	}
	.tombolcetak{
		position: absolute;
		right: 0px;
		top: 20px;
	}
</style>
<!-- <img class="previewfile" src="{{$gambar}}">
<a role="button" href="{!!url()!!}/epersonal/biodata/cetakpdf?nip={!!\Input::get('nip')!!}&filename={!!\Input::get('filename')!!}" target="_blank" title="Cetak Dokumen" class="tombolcetak btn btn-primary btn-lg"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a> -->

<?php
$path = $gambar;
$ext = pathinfo($path, PATHINFO_EXTENSION);
if ($ext == 'pdf') {
?>

	<body>
		<iframe src="{{$gambar}}" width="100%" height="500"></iframe>
        <a href="{{ $gambar }}" target="_blank" title="Download Dokumen" download class="btn btn-primary pull-right"><i class="fa fa-download"></i> Download</a>
	</body>
<?
} else {
?>
	<img class="previewfile" src="{{$gambar}}">
	<a role="button" href="{!!url()!!}/epersonal/biodata/cetakpdf?nip={!!\Input::get('nip')!!}&filename={!!\Input::get('filename')!!}" target="_blank" title="Cetak Dokumen" class="tombolcetak btn btn-primary btn-lg"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
<?php
}
?>