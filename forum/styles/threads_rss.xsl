<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" 
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<head>
<style>
body {
	background: #F9F1D9;
	font-family: sans-serif;
	font-size: 10pt;
}
.item {
	background: #FCF9ED;
	width: 500px;
	border: 1px solid #EFDB9C;
	float: left;
	padding: 20px;
	margin: 20px;
}
.title {
	font-weight: bold;
}
a:link {
	color: #D6A923;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:visited {
	color: #7C6314;
}
.content {
	margin-top: 20px;
}
h1 {
	margin-left: 20px;
	font-size: 12pt;
	color: #7C6314;
}
h2 {
	margin-left: 20px;
	font-size: 10pt;
	color: #D6A923;
}
</style>
</head>
<body>
<h1><xsl:value-of select="rss/channel/title"/></h1>
<h2><xsl:value-of select="rss/channel/description"/></h2>
<xsl:for-each select="rss/channel/item">
<xsl:variable name="linkurl" select="link"/>
<div class="item">
	<div class="title"><a href="{$linkurl}"><xsl:value-of select="title"/></a></div>
	<div class="content"><xsl:value-of select="description"/></div>
</div>
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>