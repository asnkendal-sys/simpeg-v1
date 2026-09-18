<!DOCTYPE html>
<html lang="id-ID" dir="ltr">
  <head>
    <title>Simpeg {!!getUtility('kab_instansi')!!}</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="dinustek | Rudi Kurniawan">
    <link rel="shortcut icon" href="{{ asset('packages/login/img/favicon.png') }}">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#2d2d2d">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#2d2d2d">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link href="{{ asset('packages/login/css/font-awesome.min.css') }}" rel="stylesheet" media="screen"> <!-- v4.6.1 -->
    <link href="{{ asset('packages/login/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('packages/login/css/login-style.css') }}" rel="stylesheet" media="screen">

    <script type="text/javascript" src="{{ asset('packages/login/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/login/js/bootstrap.min.js') }}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="{{ asset('packages/login/js/html5shiv.js') }}"></script>
      <script src="{{ asset('packages/login/js/respond.min.js') }}"></script>
    <![endif]-->
  </head>
  <body id="login-page">
  	<a href="#" id="kirim">Kirim</a>
</body>
<script type="text/javascript">
	$("#kirim").click(function () {
    var prev_response = "";
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'https://simpeg.kendalkab.go.id/webservices/storediklatall', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 3) {
            // Partial content loaded. remove the previous response   
            var partial_response = xhr.responseText.replace(prev_response,"");
            prev_response = xhr.responseText;
            //parse the data and do your stuff
            var data = $.parseJSON(partial_response);
            var p_value = parseInt(data.step*100)/data.all;        
            set_progressbar_value(p_value); 
        }
        else if(xhr.readyState == 4 && xhr.status == 200){
            set_progressbar_value(100);
            console.log("Completed");
        }

    }
    xhr.send("users="+ input_users); 

});
</script>
</html>
