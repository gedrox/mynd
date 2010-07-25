{include file="header.tpl"}

<div class="album">
<h1>Album</h1>

<ul class="breadCrumbs">
	<li><a href="{$baseUrl}/album/">Home</a></li>
	{assign var="_dir" value=""}
	{foreach from=$breadCrumbs item="folder" name="breadCrumbs"}
		&gt;
		<li><a href="?dir={$_dir}{$folder|escape:"uri"}">{$folder|escape}</a></li>
		{assign var="_dir" value=$_dir|cat:$folder|cat:'/'}
	{/foreach}
</ul>

<ul class="items">
{foreach from=$files item="file"}
	{if $file->isDir()}
		<li><a href="?dir={$dir|escape:uri}{$file->getFilename()}">{$file->getFilename()}</a></li>
	{/if}
{/foreach}
{foreach from=$files item="file"}
	{if $file->isFile()}
		<li>
			<a href="{$baseUrl}{$file->getImageSrc('large')|escape}" rel="lightbox[album]">
				<img src="{$baseUrl}{$file->getImageSrc('small')|escape}" alt="" border="0" />
			</a>
			<!--
			<label>{$file->getFilename()}</label>
			-->
		</li>
	{/if}
{/foreach}
</ul>
<div class="clear"><!-- --></div>

</div>

{include file="footer.tpl"}