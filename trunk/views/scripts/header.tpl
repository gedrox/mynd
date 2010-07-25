<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$headTitle}</title>
<link rel="stylesheet" href="{$baseUrl}/style.css" type="text/css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript" src="{$baseUrl}/js/prototype.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="{$baseUrl}/js/lightbox.js"></script>
<link rel="stylesheet" href="{$baseUrl}/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript">
LightboxOptions.fileLoadingImage = "{$baseUrl}/" + LightboxOptions.fileLoadingImage;
LightboxOptions.fileBottomNavCloseImage = "{$baseUrl}/" + LightboxOptions.fileBottomNavCloseImage;
</script>
</head>
<body>
	<div id="header">
		<div id="navbar">
			<ul>
				{if $session->loggedIn}
				<li class="username">Logged in as {$session->user|escape}</li>
				{/if}
				<li><a href="{$baseUrl}/">Home</a></li>
				<li><a href="{$baseUrl}/album/">Album</a></li>
				{if $session->loggedIn}
					<li><a href="{$baseUrl}/logout/">Logout</a></li>
				{else}
					<li><a href="{$baseUrl}/login/">Login</a></li>
				{/if}
			</ul>
		</div>
	</div>
	<div id="content">
	{*
		<div id="blogroll">
			<h2>Recent Posts</h2>
			<h3><a href="#">imperdiet holluim</a><br/>
			<a href="#">Lorem Ipsum</a><br/>
			<a href="#">dolor sit amet</a><br/>
			<a href="#">donec quam felis</a><br/>
			<a href="#">nullam dictum</a><br/>
			<a href="#">Hello world</a><br/>
			</h3>
		</div>
	*}