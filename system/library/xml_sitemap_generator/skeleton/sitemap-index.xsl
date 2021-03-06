<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40" 
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" 
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <title>{{ title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/js/jquery.tablesorter.min.js"></script>
				<script	type="text/javascript"><![CDATA[
					$(document).ready(function() { 
            $('.table').on('sortEnd', function(){
              $(this).find('tbody > tr').removeClass('odd');
              $(this).find('tbody > tr:even').addClass('odd');
            })
            .tablesorter();
					});
				]]></script>        
        <style type="text/css">
					body {
						font-family: Helvetica, Arial, sans-serif;
						font-size: 13px;
						color: #545353;
            padding: 50px;
					}
					a {
						color: #000;
						text-decoration: none;
					}
					a:hover {
						text-decoration: underline;
					}          
					p {
						margin: 10px 3px;
						line-height: 1.3em;
					}
					p a {
						color: #CC3300;
						font-weight: bold;
					}
					table {
						border-collapse: collapse;
						border: none;
					}
					th, 
          td {
						text-align: left;
						font-size: 13px;
						padding: 7px;
            vertical-align: middle;          
					}
					#content {
						margin: 0 auto;
						width: auto;
					}
					.table {
            table-layout: fixed;
            width: 100%;
            max-width: 100%;
            margin-bottom: 30px;   
					}
					.table thead {
						border-bottom: 1px solid #000;
					}
					.table thead th {
						cursor: pointer;
					}
					.table tbody {
						border-bottom: 1px solid #000;
					}
					.table tbody td {
						padding: 7px;
            vertical-align: middle;    
					}
					.table tr.odd {
						background-color: #eee;
					}
					.table tbody tr:hover {
						background-color: #ccc;
					}
					.table tbody tr:hover td, 
          .table tbody tr:hover td a {
						color: #000;
					}
					.copyright a {
						color: #CC3300;
						font-weight: bold;
					}
				</style>
			</head>
			<body>
				<div id="content">
					<h1>{{ title }}</h1>
					<p>
						Generated by <a href="https://www.opencart.com/index.php?route=marketplace/extension&amp;filter_member=cuispi" target="_blank">Cuispi</a>'s <a href="https://www.opencart.com/index.php?route=marketplace/extension/info&amp;extension_id=32389" target="_blank">XML Sitemap Generator</a>, this is an XML Sitemap, meant for consumption by search engines.
					</p>
					<p>
						You can find more information about XML sitemaps on <a href="http://sitemaps.org" target="_blank">sitemaps.org</a>.
					</p>
					<p>
						This sitemap index contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> URL<xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) > 1">s</xsl:if>.
					</p>         
					<table class="table">
						<thead>
							<tr>
                <th width="80%">URL</th>
                <th width="20%">Last Modified</th>                
							</tr>
						</thead>
						<tbody>
							<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
							<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
              <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
								<tr>
                  <xsl:if test="position() mod 2 = 1">
                    <xsl:attribute name="class">odd</xsl:attribute>
                  </xsl:if>                  
									<td>
										<xsl:variable name="sitemapURL">
											<xsl:value-of select="sitemap:loc"/>
										</xsl:variable>
										<a href="{$sitemapURL}">
											<xsl:value-of select="sitemap:loc"/>
										</a>
									</td>
									<td>
										<xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)))"/>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
          <div class="copyright">
            Copyright &#169; <a href="https://www.opencart.com/index.php?route=marketplace/extension&amp;filter_member=cuispi" target="_blank">Cuispi</a> 2018. All rights reserved.
          </div>          
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>