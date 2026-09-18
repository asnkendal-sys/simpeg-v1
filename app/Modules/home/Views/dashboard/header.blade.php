<!DOCTYPE html>
<html>
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108225647-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-108225647-1');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!!getUtility('nma_aplikasi')!!}</title>
    <meta name="robots" content="noindex">
    <link href="{{ asset('packages/tugumuda/img/favicon.png') }}" rel='icon' type='image/x-icon'/>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/bootstrap.min.css')!!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/font-awesome.min.css')!!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/ionicons.min.css')!!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/AdminLTE.min.css')!!}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
       <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/_all-skins.min.css')!!}">
       <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/fileinput.min.css')!!}">

       <!-- jquery file upload -->
       <link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/jQuery-File-Upload/css/jquery.fileupload.css')!!}">
       <link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css')!!}">

       <link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/sweetalert2/sweetalert2.min.css')!!}">

       <noscript><link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css')!!}"></noscript>
       <noscript><link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css')!!}"></noscript>

       <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
       <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jQuery 2.2.0 -->
    
<script src="{!!asset('packages/tugumuda/plugins/jQuery/jQuery-2.2.0.min.js')!!}"></script>
<script src="{{asset('/packages/tugumuda/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{!!asset('packages/tugumuda/js/bootstrap.min.js')!!}"></script>
<!-- AdminLTE App -->
<script src="{!!asset('packages/tugumuda/js/app.min.js')!!}"></script>
<!-- Sparkline -->
<!-- SlimScroll 1.3.0 -->
<script src="{!!asset('packages/tugumuda/plugins/slimScroll/jquery.slimscroll.min.js')!!}"></script>

<!--Legacy Framework Mbiyen-->
<script type="text/javascript" src="{{asset('packages/tugumuda/js/moment.js')}}"></script>
<link rel="stylesheet" href="{{asset('packages/tugumuda/css/bootstrap-datetimepicker.min.css')}}" />
<script type="text/javascript" src="{{asset('packages/tugumuda/js/bootstrap-datetimepicker.min.js')}}"></script>

<!-- JS BAHASA INDONESIA Add By Reza -->
<script src="{!!asset('packages/tugumuda/js/id.js')!!}"></script>

<!--NOTINY-->
<script type="text/javascript" src="{!!asset('packages/tugumuda/plugins/notiny/notiny.min.js')!!}"></script>
<link rel="stylesheet" href="{!!asset('packages/tugumuda/plugins/notiny/notiny.min.css')!!}">
<!--NOTINY-->

<!--CKEDITOR-->
<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/ckeditor/adapters/jquery.js')}}"></script>
<!--CKEDITOR-->

<!--chart-->
<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/chart/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/chart/data.js')}}"></script>
<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/chart/exporting.js')}}"></script>
<!--chart-->

<script type="text/javascript" src="{{asset('packages/tugumuda/plugins/Material-Preloader/js/materialPreloader.min.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('packages/tugumuda/plugins/Material-Preloader/css/materialPreloader.min.css')}}">

<!--    TABS  -->
<script type="text/javascript" src="{{asset('packages/tugumuda/js/bootstrap-tab.min.js')}}"></script>
<!--    TABS  -->

<!--    VALIDATION-->
<link rel="stylesheet" href="{{ asset('packages/tugumuda/plugins/validation-engine/css/validationEngine.jquery.css') }}" type="text/css"/>
<script src="{{ asset('packages/tugumuda/plugins/validation-engine/js/jquery.validationEngine-id.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('packages/tugumuda/plugins/validation-engine/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>
<!--    VALIDATION-->

<!--    TABLE-->
<link rel="stylesheet" href="{{ asset('packages/tugumuda/plugins/tablefix/tablefix.css') }}" type="text/css"/>
<script src="{{ asset('packages/tugumuda/plugins/tablefix/tablefix.js') }}" type="text/javascript" charset="utf-8"></script>
<!--    TABLE-->

<script src="{{ asset('packages/tugumuda/plugins/font-awesome/fontawesome-iconpicker.js') }}" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="{{ asset('packages/tugumuda/plugins/font-awesome/fontawesome-iconpicker.min.css') }}" type="text/css"/>

<script type="text/javascript" src="{{ asset('packages/tugumuda/plugins/AmaranJS/js/jquery.amaran.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('packages/tugumuda/plugins/select2/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('packages/tugumuda/plugins/select2/s2-docs.css') }}" />
<script type="text/javascript" src="{{ asset('packages/tugumuda/plugins/bootbox/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/tugumuda/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/tugumuda/plugins/mask/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/tugumuda/js/claravel.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/tugumuda/js/fileinput.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('packages/tugumuda/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/chartjs/Chart.min.js')}}"></script>

<!-- jquery file upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-primary start" disabled>
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start</span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel</span>
            </button>
            {% } %}
        </td>
    </tr>
    {% } %}
</script>

<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/tmpl.min.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/load-image.all.min.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/canvas-to-blob.min.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.blueimp-gallery.min.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-process.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-image.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-audio.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-video.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-validate.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/cors/jquery.postmessage-transport.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js')}}"></script>
<script src="{{ asset('packages/tugumuda/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>

<script>
    var xhr = $.ajax();
    $(document).ready(function(){
        $('#profil_user').on('click',function(e){
            e.preventDefault();
            claravel_modal('Profil Pengguna','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/profil',
                type : 'get',
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('#profil_user2').on('click',function(e){
            e.preventDefault();
            claravel_modal('Ganti Password','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/pass',
                type : 'get',
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        $('.login-efile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Konfirmasi Login E-file','Loading...','main_modal');
            $.ajax({
                url : '{{url()}}/efileconfirm',
                type : 'get',
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });

        });

        notifikasi();
    })

    CKEDITOR.disableAutoInline = true;
    $(document).ready(function(){
        /*Untuk mengatasi select2 yang tidak bekerja di modal*/
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            /*$('select').select2();*/
        }
    });

    var laravel_base = <?php echo "'".getBaseURL(true)."'"; ?>;
    function only_numeric(e){
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // ijinkan: backspace dan delete
                 (e.keyCode == 8) || (e.keyCode == 46) ||
                 // ijinkan: Enter
                 (e.keyCode == 13) ||
                 // ijinkan: Ctrl+A
                 (e.keyCode == 65 && e.ctrlKey === true) ||
                 // ijinkan: home, end, left, right
                 (e.keyCode >= 35 && e.keyCode <= 39)) {
          return;
                     // let it happen, don't do anything
                 }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

        function cetak_a4_landscape(html,panjang,lebar){
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
            printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
            printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: a4 landscape;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
            printWindow.document.write(html);
            printWindow.document.write('< / body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function cetak_a4_portrait(html,panjang,lebar){
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
            printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
            printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: a4 portrait;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
            printWindow.document.write(html);
            printWindow.document.write('< / body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function cetak_legal_landscape(html,panjang,lebar){
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
            printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
            printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal landscape;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
            printWindow.document.write(html);
            printWindow.document.write('< / body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function cetak_legal_portrait(html,panjang,lebar){
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=' + lebar + ',width=' + panjang + ',scrollbars=1');
            printWindow.document.write('<!DOCTYPE html><html><head><title>Cetak</title>');
            printWindow.document.write('<style>html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:8pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal portrait;margin-left: 0.4in;margin-right: 0.4in;margin-top: 0.4in;margin-bottom: 0.6in;counter-increment: page;@bottom-right {padding-right:20px;content: "Page " counter(page);}}  .page-break{ display:block; page-break-before:always; }}p{font-size:8pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:8pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>');
            printWindow.document.write(html);
            printWindow.document.write('< / body></html>');
            printWindow.document.close();
            printWindow.print();
        }


        function autoCompleteimg(element, url, ph, dataPost, id, text){
            $(element).select2({
                /*initSelection: function(element, callback) {
                    callback({id: id, text: text });
                },*/
                placeholder: ph,
                minimumInputLength: 3,
                closeOnSelect: true,
                allowClear: true,
                quietMillis: 250,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    type:'post',
                    data: function(params) {
                        return {
                            keyword: params.term, //search term
                            per_page: 10, // page size
                            page: params.page, // page number
                            _token : '{!!csrf_token()!!}'
                        };
                    },
                    processResults: function(data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.rows,
                            pagination: {
                                more: (params.page * 5) < data.result
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
            });

            if(id != '' && id != null){
                $(element).data('select2').trigger('select', {
                    data: {"id":id,"text":text}
                });
            }
        }

        function autoComplete(element, url, ph, dataPost, id, text, parent, parent2){
            $(element).select2({
                /*initSelection: function(element, callback) {
                    callback({id: id, text: text });
                },*/
                placeholder: ph,
                /*minimumInputLength: 3,*/
                closeOnSelect: true,
                allowClear: true,
                quietMillis: 250,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    type:'post',
                    data: function (params) {
                        return {
                            keyword: params.term, //search term
                            per_page: 10, // page size
                            page: params.page, // page number
                            parent : parent,
                            parent2 : parent2,
                            _token : '{!!csrf_token()!!}'
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used

                        params.page = params.page || 1;

                        return {
                            results: data.rows,
                            pagination: {
                                more: (params.page * 5) < data.result
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                //tags: true
                //  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                /*formatResult: FormatResult,
                formatSelection: FormatSelection*/
            });

            if(id != '' && id != null){
                $(element).data('select2').trigger('select', {
                    data: {"id":id,"text":text}
                });
            }
        }

        function autoComplete2(element, url, ph, dataPost, id, text, parent, parent2){
            $(element).select2({
                /*initSelection: function(element, callback) {
                    callback({id: id, text: text });
                },*/
                placeholder: ph,
                /*minimumInputLength: 3,*/
                closeOnSelect: true,
                allowClear: true,
                quietMillis: 250,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    type:'post',
                    data: function (params) {
                        return {
                            keyword: params.term, //search term
                            per_page: 10, // page size
                            page: params.page, // page number
                            parent : parent,
                            parent2 : parent2,
                            _token : '{!!csrf_token()!!}'
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used

                        params.page = params.page || 1;

                        return {
                            results: data.rows,
                            pagination: {
                                more: (params.page * 5) < data.result
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                tags: true,
                //  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                /*formatResult: FormatResult,
                formatSelection: FormatSelection*/
                templateResult: formatRepoku
            });

            if(id != '' && id != null){
                $(element).data('select2').trigger('select', {
                    data: {"id":id,"text":text}
                });
            }
        }
		
		function autoComplete3(element, url, ph, dataPost, id, text, parent, parent2){
            $(element).select2({
                /*initSelection: function(element, callback) {
                    callback({id: id, text: text });
                },*/
                placeholder: ph,
                /*minimumInputLength: 3,*/
                closeOnSelect: true,
                allowClear: true,
                quietMillis: 250,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    type:'post',
                    data: function (params) {
                        return {
                            keyword: params.term, //search term
                            per_page: 10, // page size
                            page: params.page, // page number
                            parent : parent,
                            parent2 : parent2,
                            _token : '{!!csrf_token()!!}'
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used

                        params.page = params.page || 1;

                        return {
                            results: data.rows,
                            pagination: {
                                more: (params.page * 5) < data.result
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                tags: true,
                templateSelection: formatRepoSelection,
                templateResult: formatRepoku
            });

            if(id != '' && id != null){
                $(element).data('select2').trigger('select', {
                    data: {"id":id,"text":text}
                });
            }
        }

        function formatRepoku(repo) {
            if (repo.loading) return repo.nama;

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'>" + repo.id + "</div>" +
                "<div class='select2-result-repository__description'>" + repo.text + " </div>" +
                "</div>";

            return markup;
        }

        function formatRepo(repo) {
            if (repo.loading) return repo.nama;

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'>" +
                "<img src='{{url()}}/packages/upload/photo/pegawai/" + repo.photo + "' " +
                "width='40' height='50' " +
                "onerror=\"this.onerror=null;this.src='{{url()}}/packages/upload/photo/pegawai/default.jpg';\" /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.namalengkap + "</div>" +
                "<div class='select2-result-repository__description'>" + repo.nip + "<br> " + repo.jabatan + " <br> " + repo.skpd + " </div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo) {
            return repo.id || repo.text;
        }

        function autoComplete(element, url, ph, dataPost, id, text, parent, parent2){
            $(element).select2({
                /*initSelection: function(element, callback) {
                    callback({id: id, text: text });
                },*/
                placeholder: ph,
                /*minimumInputLength: 3,*/
                closeOnSelect: true,
                allowClear: true,
                quietMillis: 250,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    type:'post',
                    data: function (params) {
                        return {
                            keyword: params.term, //search term
                            per_page: 10, // page size
                            page: params.page, // page number
                            parent : parent,
                            parent2 : parent2,
                            _token : '{!!csrf_token()!!}'
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used

                        params.page = params.page || 1;

                        return {
                            results: data.rows,
                            pagination: {
                                more: (params.page * 5) < data.result
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                //tags: true
                //  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                /*formatResult: FormatResult,
                formatSelection: FormatSelection*/
            });

            if(id != '' && id != null){
                $(element).data('select2').trigger('select', {
                    data: {"id":id,"text":text}
                });
            }
        }

        function loading(elemen){
            $('#' + elemen + '').html("<center><img src='<?=asset('packages/tugumuda/images/loading.gif')?>'></center>");
        }
        function loading_kecil(elemen){
            elemen.html("<center><img src='<?=asset('packages/tugumuda/img/loading_kecil.gif')?>'></center>");
        }

        function only_numeric(e){
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // ijinkan: backspace dan delete
            (e.keyCode == 8) || (e.keyCode == 46) ||
             // ijinkan: Enter
             (e.keyCode == 13) ||
             // ijinkan: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true) ||
             // ijinkan: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
                // let it happen, don't do anything
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

        function notification(pesan, jenis){
            if(jenis == 'success'){
                var bgcolor = '#00a65a';
                var color = '#fff';
                var jenis = jenis;
            }else
            if(jenis == 'danger'){
                var bgcolor = '#dd4b39';
                var color = '#fff';
                var jenis = jenis;
            }else
            if(jenis == 'warning'){
                var bgcolor = '#f39c12';
                var color = '#fff';
                var jenis = jenis;
            }else
            if(jenis == 'info'){
                var bgcolor = '#3c8dbc';
                var color = '#fff';
                var jenis = jenis;
            }else{
                var bgcolor = '#d2d6de';
                var color = '#000';
                var jenis = 'success';
            }
            $.notify(pesan, {align:"right", verticalAlign:"top", type : jenis});
            console.log(pesan);
        }

        function cetak_excel(elemen){
            uriContent = "data:application/vnd.ms-excel," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
            window.open(uriContent, 'myDocument');
        }

        function cetak_word(elemen){
            uriContent = "data:application/msword," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
            window.open(uriContent, 'myDocument');
        }
        function cetak_word2012(elemen){
            uriContent = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document," + encodeURIComponent( format_html($('#' + elemen + '').html()) );
            window.open(uriContent, 'myDocument');
        }

        function format_html(html){
            var konten;
            konten = '<!DOCTYPE html><html><head><title>Cetak</title>';
            konten += '<style>.fake>th{padding: 0;border-bottom: none;border-top: none;}html {overflow: -moz-scrollbars-vertical;font-family:arial;font-size:12pt;}.halaman{border: 2px #888888 solid;background-color: #000000;}h1, h2, h3, h4, h5, h6{line-height: 19px;margin:0px;}@media print {@page {size: legal landscape;margin-left: 2cm;margin-right: 2cm;margin-top: 2cm;margin-bottom: 2cm;counter-increment: page;@top-center {content: "Halaman " counter(page);}}   .page-break{ display:block; page-break-before:always; }}p{font-size:12pt;}table{width:100%;page-break-inside:auto;} th{padding-top:3px;padding-bottom:3px;} tr{ page-break-inside:avoid; page-break-after:auto;}  thead { display:table-header-group } tfoot { display:table-footer-group } table, th, td { font-family:arial;font-size:12pt;border: 1px black solid;border-collapse: collapse; }</style></head><body>';
            konten += html;
            konten += '< / body></html>';
            return konten;
        }

        function claravel_modal_close(elemen){
            $('#' + elemen + '').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        function claravel_modal_close_2(elemen){
            $('#' + elemen + '').modal('hide');
        }

        function claravel_modal(judul,isi,elemen){
            elemen = (elemen == '')?'modal2':elemen;
            $('#' + elemen + '').modal({ keyboard: true });
            $('#' + elemen + ' .modal-title').html(judul);
            $('#' + elemen + ' .modal-body').html(isi);
        }

        /*setInterval(function(){blink()}, 1000);
        function blink() {
            $(".label.label-danger, .label.bg-red").fadeTo(300, 0.1).fadeTo(500, 1.0);
        }*/

        function notifikasi(){
            xhr.abort();
            xhr = $.ajax({
                url: '{{url()}}/getnotifikasi',
                cache: false,
                success: function(response){
                    var ret = $.parseJSON(response);
                    $('.xnotifikasi').text('Anda tidak memiliki pemberitahuan terkini');
                    for(attrname in ret){
                        if(ret[attrname] > 0){
                            if(attrname.substr(0, 6) != 'jumlah'){
                                $('.'+attrname).html('<span class="label bg-red">'+ret[attrname]+ '</span>');
                            }else{
                                $('.'+attrname).html(ret[attrname]);
                            }
                            $('.xnotifikasi').text('Anda memiliki '+ret.epersonal+' pemberitahuan terkini');
                        }else{
                            if(attrname.substr(0, 6) != 'jumlah'){
                                $('.'+attrname).html('');
                            }else{
                                $('.'+attrname).html('0');
                            }
                        }
                    }
                }
            });

            @if((session('role_id') != 4) and (session('role_id') != 5))
            var waktu = setTimeout("notifikasi()",30000);
            @endif
        }
    </script>
</head>

<?php
if(session('role_id') <=2){
    $skin = 'skin-blue';
}else if(session('role_id') == 3){
    $skin = 'skin-red';
}else if(session('role_id') == 4){
    $skin = 'skin-green';
}else if(session('role_id') == 5){
    $skin = 'skin-yellow';
}else {
    $skin = 'skin-green';
}
?>

<body class="hold-transition fixed skin-blue sidebar-mini">
    <!-- <body class="sidebar-mini skin-red-light" style="height: auto;"> -->
        <div class="wrapper">

          <header class="main-header">

            <!-- Logo -->
            <a href="{!!url()!!}/dashboard" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini">
                  <b><img src="{!!url()!!}/packages/tugumuda/img/logo.png" width="35" height="auto"></b>
              </span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg">
                  <span class="pull-left">
                      <img src="{{ asset('/packages/tugumuda/img/logo.png') }}" width="35" height="auto">
                      <b>{!!getUtility('alias_aplikasi')!!} K<small>endal</small></b>
                  </span>
              </span>
          </a>

          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if(session('role_id') != 3)
                    <li class="dropdown messages-menu open">
                        <a href="javascript:void(0)" class="login-efile" title="E-file">
                            <i class="fa fa-paperclip"></i>
                            E-File
                        </a>
                    </li>
                    @endif
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="fa fa-bell-o"></i>
                          <span class="label label-danger"><span class="jumlahbiodata"></span></span>
                      </a>
                      <ul class="dropdown-menu">
                          <li class="header"><span class="xnotifikasi"></span></li>
                          <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                              @if(session('role_id') == 3)
                              <li><a href="javascript:void(0)"><i class="fa fa-arrow-circle-right text-aqua"></i> Notifikasi tidak tersedia</a></li>
                              @else
                              <li><a href="{!!url()!!}/epersonal/perubahanbiodata" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Biodata <span class="r_biodata"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rpangkat" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Pangkat <span class="r_pangkat"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rjab" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Jabatan <span class="r_jab"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rkgb" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat KGB <span class="r_kgb"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rpend" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Pendidikan <span class="r_pend"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rdikstru" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Dikstru <span class="r_dikstru"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rdikfung" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Dikfung <span class="r_dikfung"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rdiktek" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Diktek <span class="r_diktek"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rhukdis" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat Hukdis <span class="r_hukdis"></span></a></li>
                              <li><a href="{!!url()!!}/epersonal/perubahanriwayat/rpppk" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Perubahan Riwayat PPPK <span class="r_pppk"></span></a></li>
                              <!-- Start Of Reza E-Cuti -->
                              <li><a href="{!!url()!!}/ecuti/verifikasicuti/halamanverifikasiatasan?atasankhusus=1" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Verifikasi Cuti (Atasan) <span class="v_cutiatasan"></span></a></li>

                              <li><a href="{!!url()!!}/ecuti/verifikasicuti/halamanverifikasiwewenang?wewenangkhusus=2" class="links"><i class="fa fa-arrow-circle-right text-aqua"></i> Verifikasi Cuti (Wewenang) <span class="v_cutiwewenang"></span></a></li>
                              @endif
                          </ul>
                      </li>
                  </ul>
              </li>

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                  <?php
                  $pict = "default.jpg";
                  if(session('role_id') == 5){
                      if(file_exists("./packages/upload/photo/pegawai/".session('foto'))){
                          $pict = 'pegawai/'.session('foto');
                      }else {
                          $pict = "default.jpg";
                      }
                  }else{
                      if(file_exists("./packages/upload/photo/".session('user_id')."/".session('foto'))){
                          $pict = session('user_id').'/'.session('foto');
                      }else {
                          $pict = "default.jpg";
                      }
                  }
                  ?>
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                      <img alt="User Image" class="user-image" src="{!!asset('packages/upload/photo/'.$pict)!!}">
                      <span class="hidden-xs">{{session('name')}}</span>
                  </a>

                  <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header" style="height: auto;">
                        <img src="{!!asset('packages/upload/photo/'.$pict)!!}" class="img-circle" alt="User Image">

                        <p>
                          {{session('name')}}
                          <small>({{session('role')}})</small>
                          <small>{{(session('idskpd') != 0)?session('skpd'):''}}</small>
                      </p>
                  </li>
                  <!-- Menu Footer-->
                  @if(session('role_id') != 5)
                  <li><a id="profil_user" href="" class='btn btn-default'>Lihat/Edit Profil</a></li>
                  @endif

                  <li class="user-footer">
                    <div class="pull-left">
                      <a id='profil_user2' href="" class='btn btn-default'>Ubah Password</a>
                  </div>
                  <div class="pull-right">
                      <a href="{!!url()!!}/logout" class="btn btn-danger btn-flat">Sign out</a>
                  </div>
              </li>
          </ul>
      </li>
  </ul>
</div>

</nav>
    <style type="text/css">
        .center{
            text-align: center;
        }
    </style>

</header>
