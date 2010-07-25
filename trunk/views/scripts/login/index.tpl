{include file="header.tpl"}

{if $error}
	<p class="error">Access denied!</p>
{/if}

<form action="{$baseUrl}/login/submit/" method="post">

	<dl>
		<dt><label for="id_login">Login</label></dt>
		<dd><input type="text" name="login" id="id_login" value="{$smarty.post.login|escape}" /></dd>
		<dt><label for="id_password">Password</label></dt>
		<dd><input type="password" name="password" id="id_password" /></dd>
		<dt></dt>
		<dd><input type="submit" value="Sign in" /></dd>
	</dl>

</form>

{include file="footer.tpl"}