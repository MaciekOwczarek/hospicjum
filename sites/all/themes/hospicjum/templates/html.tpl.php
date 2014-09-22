<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" <?php print $rdf_namespaces; ?>> <!--<![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<head profile="<?php print $grddl_profile; ?>">
	<?php print $head; ?>
	<title><?php print $head_title; ?></title>
	<?php print $styles; ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<?php print $scripts; ?>
</head>

<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<!--[if lt IE 7]><p class="chromeframe">Twoja przeglądarka jest <em>antyczna!</em> <a href="http://browsehappy.com/">Zaktualizuj lub zmień przeglądarkę</a> lub <a href="http://www.google.com/chromeframe/?redirect=true"> zainstaluj Google Chrome Frame</a> aby lepiej doświadczyć tej strony.</p><![endif]-->
	<?php print $page_top; ?>
	<?php print $page; ?>
	<?php print $page_bottom; ?>
</body>
</html>