<?php
	function getHeader($title, $css){

		$cssTab = explode(";", $css);
		$linkRel = "";
		for($i = 0; $i < count($cssTab); $i++){
			$linkRel .= '<link rel="stylesheet" href="css/'.$cssTab[$i].'">';
		}

		echo '
			<!DOCTYPE html>
			<html lang="en">
				<head>
					<meta charset="UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
					<meta http-equiv="X-UA-Compatible" content="ie=edge">

					<meta name="google" content="nositelinkssearchbox" />

					<meta name="Description" content="Wypożyczalnia Samochodów Luksusowych. Wynajem Aut w Dobrej Cenie. Nowe, Luksusowe Samochody. Sprawdź!">
					<meta name="Keywords" content="Wypożyczalnia, Luksusowych, Samochodów Kraków, Tarnów, Gładysz Motors, Łukanowice, Wrocławia, Rzeszowa, Katowice, wypożyczenie, infiniti, mercedes">


					<title>'.$title.'</title>
					<!--STYLESHEETS-->
						<link rel="stylesheet" href="css/normalize.css">
						<link rel="stylesheet" href="css/bootstrap.css">
						<link rel="stylesheet" href="css/sweetAlert.css">
						<link rel="stylesheet" href="css/datetimepicker.css"/>
						'.$linkRel.'
						<link rel="stylesheet" href="css/responsiveCss.css">
					<!--#END STYLESHEETS-->
					<!--SCRIPTS-->
						<script src="js/jquery.js"></script>
						<script src="js/bootstrap.js"></script>
						<script src="js/sweetAlert.js"></script>
						<script src="js/datetimepicker.js"></script>
						<script src="js/mainScript.js"></script>
						<script src="js/jquery.validate.js"></script>
					<!--#END SCRIPTS-->

					<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
					<link rel="icon" href="favicon.ico" type="image/x-icon">


					<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
					<link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32">
					<link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16">
					<link rel="manifest" href="favicons/manifest.json">
					<meta name="theme-color" content="#ffffff">

					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<script>
					  (adsbygoogle = window.adsbygoogle || []).push({
					    google_ad_client: "ca-pub-2956486560089802",
					    enable_page_level_ads: true
					  });
					</script>

					<!-- Google Analytics -->
						<script>
							(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
							(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
							m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
							})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
							ga("create", "UA-98453094-1", "auto");
							ga("send", "pageview");
						</script>
					<!-- End Google Analytics -->
				</head>
				<body>

				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.9&appId=901739873209201";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
	}
?>
