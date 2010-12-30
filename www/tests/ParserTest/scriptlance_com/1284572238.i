
	<html>
	<head>
	<title>post 6 Sites 2 - ScriptLance Programming Project</title>
	<!-- We need six sites posted to our hosting service and edited immediately, please do not post an offering if you are not prepared to start this immediately... basic sites nothing too extavagent, but requ... Programming Project posted on ScriptLance. -->
	<meta name="description" content="We need six sites posted to our hosting service and edited immediately, please do not post an offering if you are not prepared to start this immediately... basic sites nothing too extavagent, but requ... Programming Project posted on ScriptLance.">
	
<meta name="keywords" content="programming, freelance, programmers, outsource, outsourcing, custom programming, project bid, web programmer, bidding, designers">
<link rel=stylesheet href=/st.css>
<link rel="alternate" type="application/rss+xml" title="Scriptlance Projects" href="https://www.scriptlance.com/rss/rss_projects_d.xml" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 
<link rel="search" href="https://www.scriptlance.com/opensearch.xml" type="application/opensearchdescription+xml" title="ScriptLance" />
</head>

<SCRIPT language=Javascript>
function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
}
function GetCookie( name ) 
{
var start = document.cookie.indexOf(" " + name + "=");
var len   = start+name.length+2;
if ( start == -1 ) 
{
    start = document.cookie.indexOf(name + "=");
    if (start != 0)
        return null;
    len   = start+name.length+1;
}
var end = document.cookie.indexOf( ";", len );
if ( end == -1 ) 
    end = document.cookie.length;
return unescape( document.cookie.substring(len,end) );
}
var ref = getQueryVariable("ref");
if (document.cookie.length==0)
{
    expires = new Date();
    expires.setTime(expires.getTime() + (1000 * 3600) * 24 * 365);

    if(ref)
        document.cookie = "refer=" + ref + "; path=/; expires=" + expires.toGMTString();

    var XMLHttpRequestObject = false; 

    if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
    else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    XMLHttpRequestObject.open("GET", "/cgi-bin/freelancers/ref_click.cgi?ref="+ref+"&http="+escape(window.document.referrer), true);

    XMLHttpRequestObject.onreadystatechange = function() 
    { 
     	if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
	{ 
        	document.cookie = "hrefid=" + XMLHttpRequestObject.responseText + "; path=/; expires=" + expires.toGMTString();
        } 
    } 
    XMLHttpRequestObject.send(null);
}
function getElementById(id)
{
    if (document.getElementById && document.getElementById(id))
	return document.getElementById(id);
    else if (document.id)
    	return document.id;
    else if (document.all)
   	return document.all.id;
    else
	return null;
}
function FillName()
{
var username = GetCookie('username');
var f_username = GetCookie('f_username');
var password = GetCookie('password');
var f_password = GetCookie('f_password');
var logindiv = getElementById('login');
if (username && password)
    logindiv.innerHTML = "<table><tr><td>Welcome, <b>" + username + "</b><br><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?manage=1' class=ml>Manage Account</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?viewprojects=all' class=ml>View My Projects</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?new=project' class=ml>Post Project</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?new=job' class=ml>Post Job Listing</a></li><li><a href='https://www.scriptlance.com/top/programmers' class=ml>View Top Programmers</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?logout=1' class=ml>Logout</a></li></td></tr></table>";
if (f_username && f_password)
{
    logindiv.innerHTML += "<table><tr><td>Welcome, <b>" + f_username + "</b><br><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?manage=1' class=ml>Manage Account</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?viewprojects=all' class=ml>View My Bids</a></li><li><a href='https://www.scriptlance.com/programmers/projects.shtml' class=ml>View Projects</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/search.cgi' class=ml>Find  Projects</a></li><li><a href='https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?logout=1' class=ml>Logout</a></li></td></tr></table>";
    if (! username || ! password)
   	logindiv.innerHTML += "<br><table><tr><td><a href='https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?login=1'>Login as Buyer...</a></td></tr></table>";
}
else if (username && password)
    logindiv.innerHTML += "<br><table><tr><td><a href='https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?login=1'>Login as Programmer...</a></td></tr></table>";
else
{
    if (username)
	uname = username;
    else if (f_username)
	uname = f_username;
    else
	uname = '';
    if (typeof(nologin) != "undefined" && nologin)
            logindiv.innerHTML = "<table width=100% cellpadding=3><tr><td colspan=2 height=25></td></tr><tr><td align=right><font size=2>Please use the login form on your right.</font></td> <td><img src=/images/arrow_blue_right.png width=13 height=15 border=0></td><td width=10></td></tr><tr><td colspan=2 height=25></td></tr></table>";
    else
    logindiv.innerHTML =  
	"    <form method=POST action=https://www.scriptlance.com/cgi-bin/freelancers/auto_login.cgi name=login>" +
	"<table cellspacing=0 cellpadding=0>" +
	"	<tr><td height=9 colspan=3></td></tr>" +
	"        <tr><td align=right width=64 class=pa>Login: &nbsp; </td><td colspan=2><input type=text name=username class=go1 value='" + uname + "'></td></tr>" +
	"        <tr><td align=right width=64 class=pa>Password: &nbsp; </td><td><input type=password name=password class=go2></td><td><input type=image src=/images/buttons/m16.gif width=30 height=19 name=submit value=Login></td></tr>" +
	"        <tr><td width=64></td><td colspan=2><input type=checkbox name=remember_me value=1> Remember me</td></tr>" +
	"</table>"+
	"    </form>" +
	"<table>" +
	"<TR><TD align=right ><IMG height=8 hspace=5 src=/images/m18.gif width=8> <A class=ml  href=https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?forgot=find>Forgot password?</A> <IMG height=8 hspace=5 src=/images/m99.gif width=8> <A class=ml href=https://www.scriptlance.com/cgi-bin/freelancers/auto_login.cgi?logout=1>Logout</A></TD></TR>" +
	"</table>";
}
}
</SCRIPT>

<body topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0 marginwidth=0 marginheight=0>
 <table cellspacing=0 cellpadding=0 height=100% width=100%>
   <tr><td valign=top class=bg3>
         <table cellspacing=0 cellpadding=0 bgcolor=#ffffff>
         <tr><td><a href=/><img src=/images/m01.gif width=166 height=104 border=0></a><img src=/images/m02.gif width=181 height=104><img src=/images/m03.jpg width=167 height=104></td>
             <td>
             <table cellspacing=0 cellpadding=0>
<form method="GET" action="/cgi-bin/freelancers/search.cgi">
               <tr><td colspan=3><img src=/images/m11.jpg width=261 height=19></td></tr>
               <tr><td colspan=3><img src=/images/m12.gif width=261 height=53></td></tr>
               <tr><td><img src=/images/m13.gif width=69 height=31></td><td bgcolor=#196ADB width=122><input type=text name=keywords class=go></td><td bgcolor=#196ADB width=70>&nbsp;<input type="image" src="/images/m04.gif" alt="Search" width="47" height="18" border=0 value="Go" name="submit"></td></tr>
               <tr><td colspan=3 height=1></td></tr>
		 <input type="hidden" name="showstatus" value="open">
		 <input type="hidden" name="desc" value="1">
</form>
			  </table>
             </td>
         </tr>
        </table>

        <table cellspacing=0 cellpadding=0 width=100%>
         <tr><td><a href=/cgi-bin/freelancers/buyers.cgi?new=project><img src="/images/header_postproject.gif" alt="Post Project" width="124" height="31" border="0"></a><a href=/go.cgi?b><img src="/images/header_buyers.gif" alt="Buyers" width="84" height="31" border="0" longdesc="https://www.scriptlance.com/webmasters/more_info.shtml"></a><a href=/go.cgi?f><img src="/images/header_programmers.gif" alt="Programmers" width="124" height="31" border="0"></a><a href=/faq.shtml><img src="/images/header_faq.gif" alt="FAQ" width="70" height="31" border="0"></a><a href=http://forum.scriptlance.net><img src="/images/header_forum.gif" alt="Forum" width="85" height="31" border="0"></a><a href=/contact.shtml><img src="/images/header_contact.gif" alt="Contact" width="88" height="31" border="0"></a><a href="/rss"><img src="/images/header_left_rss.gif" width=31 height=31 border=0 alt="RSS"></a></td><td></td></tr>
         <tr><td height=1></td></tr>
        </table>

        <table cellspacing=0 cellpadding=0 width=100% bgcolor=#ffffff>
         <tr><td valign=top width=185 style="padding-top: 6px;">

              <table cellspacing=0 cellpadding=0>
               <tr><td><img src=/images/m14.gif width=31 height=20></td><td background=/images/m15.gif width=154 height=20 class=me>&nbsp; &nbsp; &nbsp; MEMBER LOGIN</td></tr>
               <tr><td colspan=2 background=/images/m25.gif width=185>
 <div id=login>
</div>
<script language=Javascript>
FillName();
</script>
                   </td></tr>
               <tr><td colspan=2><img src=/images/m26.gif width=185 height=6></td></tr>
               <tr><td height=5 colspan=2></td></tr>
              </table>



              <table cellspacing=0 cellpadding=0>
               <tr><td><img src=/images/m19.gif width=31 height=20></td><td background=/images/m15.gif width=154 height=20 class=me>&nbsp; &nbsp; &nbsp; SERVICES & FEATURES</td></tr>
               <tr><td colspan=2 background=/images/m25.gif width=185>
<table cellspacing=0 cellpadding=0 width="100%">
<tr><td width=2></td><td>
<li><a href="/cgi-bin/freelancers/buyers.cgi?new=project" class=ml>Post a Project</a>
<li><a href="/cgi-bin/freelancers/buyers.cgi?new=user" class=ml>Signup</a>
<li><a href="/jobs" class=ml>Job Listings</a>
<li><a href="/featured.shtml" class=ml>Featured Projects</a>
<li><a href="/certified.shtml" class=ml>Certified Members</a>
<li><a href="/top/programmers/" class=ml>Top Programmers</a>
<li><a href="/affiliates.shtml" class=ml>Affiliate Program</a>
<li><a href="/rss" class=ml>RSS Feeds</a>
</td>
</tr>
</table>
               </td></tr>
               <tr><td colspan=2><img src=/images/m26.gif width=185 height=6></td></tr>
               <tr><td height=5 colspan=2></td></tr>
              </table>



		<form method="POST" action="/cgi-bin/freelancers/buyers.cgi" name="subproj">
		<input type="hidden" name="new" value="project">
		<input type="hidden" name="type" value="step1">
		<table cellspacing=0 cellpadding=0 width=164 align=center>
		<tr>
		<td align=center valign=top><textarea rows="3" name="description" cols="16" style="height:80px;width:164px;color:#6B80A1;background-color:#E1EBFB" onclick="document.subproj.description.value='';">Describe what you need here. Get free quotes instantly.</textarea><br>
		<INPUT TYPE="IMAGE" src="/images/post_project_big_blue.gif" width=164 height=30 alt="Post Project">
		</td>
		</tr>
		</table>
		</form>


			  <table cellspacing=0 cellpadding=0>
               <tr><td><img src=/images/m23.gif width=31 height=20></td><td background=/images/m15.gif width=154 height=20 class=me>&nbsp;&nbsp;&nbsp;THE 20 LATEST PROJECTS</td></tr>
              </table>
<table cellspacing=1 cellpadding=2 width=100%>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284574632.shtml">Simple But Need Now Web Help</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284574461.shtml">Need A Fitness Logo</a> <img src="/images/urgent2.gif" width=14 height=14 border=0 title="Urgent Project"></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284574336.shtml">Php Code Fix Asap</a> <img src="/images/urgent2.gif" width=14 height=14 border=0 title="Urgent Project"></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284574328.shtml" title="Convert / Migrate Ms Sql Database To Mysql">Convert / Migrate Ms Sql Da...</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284574261.shtml">Psd To Html</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284574211.shtml">Myspace Design</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284573987.shtml">Simple Data Entry</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284573197.shtml">Diet And Nutrition Software</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284572963.shtml" title="Integration Of Software Program Data">Integration Of Software Pro...</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284572803.shtml" title="Post Six (6) Websites With Moderate Editing">Post Six (6) Websites With ...</a> <img src="/images/urgent2.gif" width=14 height=14 border=0 title="Urgent Project"></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284572608.shtml">Post Six Sites</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284572554.shtml">Asp.net Developer</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284572238.shtml">Post 6 Sites 2</a> <img src="/images/urgent2.gif" width=14 height=14 border=0 title="Urgent Project"></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284571578.shtml" title="Backlinks Needed For Adult Dating Site">Backlinks Needed For Adult ...</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284571091.shtml" title="Wordpress Theme Install And Set Up 2">Wordpress Theme Install And...</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284570639.shtml" title="Codeigniter Ecommerce Newsletter">Codeigniter Ecommerce Newsl...</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284570636.shtml" title="Need Help Asap With Internet Explorer - Ecommerce Site">Need Help Asap With Interne...</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284570600.shtml" title="Need Real Estate Website Cms With Mls Feed">Need Real Estate Website Cm...</a></td></tr>
<tr><td class=dt1><a href="http://www.scriptlance.com/projects/1284570579.shtml">Logo Modification Needed</a></td></tr>
<tr><td class=dt2><a href="http://www.scriptlance.com/projects/1284570013.shtml" title="Datamining/scraping For Website">Datamining/scraping For Web...</a> <img src="/images/urgent2.gif" width=14 height=14 border=0 title="Urgent Project"></td></tr>
</table>

              <table cellspacing=0 cellpadding=0 width=100%>
               <tr><td height=5></td></tr>
               <tr><td align=right><a href=/cgi-bin/freelancers/buyers.cgi?new=project><img src=/images/buttons/m34.gif width=85 height=19 border=0></a> &nbsp; <a href=/programmers/projects.shtml><img src=/images/buttons/m35.gif width=60 height=19 border=0></a></td></tr>
               <tr><td height=5></td></tr>
              </table>

			  <table cellspacing=0 cellpadding=0>

               <tr><td><img src=/images/m23.gif width=31 height=20></td><td background=/images/m15.gif width=154 height=20 class=me>&nbsp;&nbsp;&nbsp;POPULAR NEW PROJECTS</td></tr>
              </table>
<table cellspacing=1 cellpadding=2 width=100%>
<tr><td class=dt2><a href="/tag/Article%20Writing">Article Writing</a></td></tr>
<tr><td class=dt1><a href="/tag/Content">Content Submission</a></td></tr>
<tr><td class=dt2><a href="/tag/Landing%20Page">Landing Pages</a></td></tr>
<tr><td class=dt1><a href="/tag/Conversion">Conversions</a></td></tr>
<tr><td class=dt2><a href="/tag/Twitter">Twitter</a></td></tr>
<tr><td class=dt1><a href="/tag/iPhone">iPhone Applications</a></td></tr>
</table>

              <table cellspacing=0 cellpadding=0 width=100%>

               <tr><td height=5></td></tr>
               <tr><td align=right><a href=/cgi-bin/freelancers/buyers.cgi?new=project><img src=/images/buttons/m34.gif width=85 height=19 border=0></a> &nbsp; <a href=/programmers/projects.shtml><img src=/images/buttons/m35.gif width=60 height=19 border=0></a></td></tr>
              </table>


             </td>
             <td width=12></td>
             <td valign=top style="padding-top: 6px;">

<table width="100%"cellpadding=0 cellspacing=0><tr><td valign=top><b><big>post 6 Sites 2</big></b>  <img src="https://www.scriptlance.com/programmers/graphics/urgent.gif" alt="Urgent!" width=56 height=14 border=0>
</td><td valign=top align=right width=140><a href="https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?new=project&clone=1284572238"><img src="/images/similar_project.gif" width=137 height=19 border=0 alt="Post Similar Project"></a></td><td valign=top align=right width=82><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?bookmark=1284572238"><IMG SRC="/images/bookmark.gif" WIDTH="79" HEIGHT="19" BORDER="0" title="Bookmark Project" alt="Bookmark Project"></a></td><td valign=top align=right width=69><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?manage_project=1284572238"><IMG SRC="/images/manage.gif" WIDTH="66" HEIGHT="19" BORDER="0" title="Manage Your Project" alt="Manage Your Project"></a></td><td valign=top align=right width=22><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?user_lists_favorite_add=jojojones&return=http://www.scriptlance.com/projects/1284572238.shtml" onmouseover="document.addfav.src='/images/favorite.png'" onmouseout="document.addfav.src='/images/favorite_grey.png'"><IMG SRC="/images/favorite_grey.png" WIDTH="19" HEIGHT="19" BORDER="0" title="Add To Favorites" name="addfav"></a></td>
<td valign=top align=right width=21><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?user_lists_ban_add=jojojones&return=http://www.scriptlance.com/projects/1284572238.shtml" onmouseover="document.addban.src='/images/blacklist.png'" onmouseout="document.addban.src='/images/blacklist_grey.png'"><IMG SRC="/images/blacklist_grey.png" WIDTH="19" HEIGHT="19" BORDER="0" title="Blacklist User" name="addban"></a></td>
	<td valign=top align=right width=21><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/report_violation.cgi?t=p&pid=1284572238" onmouseover="document.reportproject.src='/images/report_red.gif'" onmouseout="document.reportproject.src='/images/report.gif'"><IMG SRC="/images/report.gif" WIDTH="19" HEIGHT="19" BORDER="0" title="Report Project Violation" name="reportproject"></a></td></tr>	
	</table>
	<table cellspacing=0 cellpadding=0 width="100%">
		<tr>
		<td colspan=2 height=3></td>
		</tr>
		<tr>
		<td><b>Project ID:</b> 1284572238</td>
		<td align=right>
			<table cellspadding=0 cellspacing=0 align=right>
			<tr><td>
				<div class="addthis_toolbox addthis_default_style">
					<table cellspacing=1 cellpadding=0>
					<tr>
						<td><a class="addthis_button_facebook_like"></a></td>
						<td valign=top><a class="addthis_button_facebook"></a></td>
						<td valign=top><a class="addthis_button_twitter"></a></td>
						<td valign=top><a class="addthis_button_myspace"></a></td>
						<td valign=top><a class="addthis_button_live"></a></td>
						<td valign=top><a class="addthis_button_email"></a></td>
						<td valign=top><a class="addthis_button_print"></a></td>
						<td valign=top><a class="addthis_button_favorites"></a></td>
						<td valign=top><a class="addthis_button_google"></a></td>
						<td valign=top><a href="http://addthis.com/bookmark.php?v=250" class="addthis_button_compact" style="text-decoration:none;color:#115BB5;">Share</a></td>
					</tr>
					</table>
				</div>
				<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#username=scriptlance"></script>
			</td>
			</tr>
			</table>	
		</td>
		</tr>
	</table>
	
<p>
<table cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td width=218>
		<table cellspacing=0 cellpadding=0>
		<tr><td background=/images/m36.gif width=218 height=27 class=me3 align=center>PROJECT DETAILS</td></tr>
		</table>
	</td>
	<td align=right valign=top>
		<table>
		<tr><td>
		<script>
var path = '/images/';			// Put path to images here
var rating = new Array();
var lastimage = '';
function getElementById(id)
{
    if (document.getElementById && document.getElementById(id))
	return document.getElementById(id);
    else if (document.id)
    	return document.id;
    else if (document.all)
   	return document.all.id;
    else
	return null;
}
function MouseOver(theimage)
{
    var ids = theimage.id.split('-');
    var id  = ids[1];
    if (!rating[ids[0]])			// Save current rating
    {
	rating[ids[0]] = 0;
    	for (i=1; i<=5; i++)
    	{
	    image = getElementById(ids[0]+'-'+i);
	    if (image && image.src.indexOf('redstar') >= 0)
	    	rating[ids[0]]++;
	    if (image && image.src.indexOf('halfstar') >= 0)
	    	rating[ids[0]]+=0.5;
       	}
    }
    for (i=1; i<=id; i++)
    {
	image = getElementById(ids[0]+'-'+i);
	if (image)
	    image.src=path+'rate_orangestar.png';
    }
    for (i=1*id+1; i<=5; i++)
    {
	image = getElementById(ids[0]+'-'+i);
	if (image)
	    image.src=path+'rate_staror.png';
    }
}
function MouseOut(theimage)
{
    var ids = theimage.id.split('-');
    var id  = ids[1];
    for (i=1; i<=rating[ids[0]]; i++)
    {
	image = getElementById(ids[0]+'-'+i);
	if (image)
	    image.src=path+'rate_redstar.png';
    }
    if (Math.ceil(rating[ids[0]])!=rating[ids[0]])
    {
	image = getElementById(ids[0]+'-'+Math.ceil(rating[ids[0]]));
	if (image)
	    image.src=path+'rate_halfstar.png';
    }	
    for (i=Math.ceil(rating[ids[0]])+1; i<=5; i++)
    {
	image = getElementById(ids[0]+'-'+i);
	if (image)
	    image.src=path+'rate_staror.png';
    }
}
function SendRating(theimage)
{
    var ids = theimage.id.split('-');
    ajax_async('/cgi-bin/freelancers/rate_project.cgi?rating='+ids[1]+'&id='+ids[0], "response");
}
function response(XMLHttpRequestObject)
{
    	if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
	{
	    var res = XMLHttpRequestObject.responseText.split(':');
	    rating[res[0]] = res[1];
    	    MouseOut(getElementById(res[0]+'-'+1));
	    return true;
	}
	return false;
}
var XMLObjects = new Array(); 			// To save multiple instances of XMLHttpRequestObject's
// Call given url asynhronously
function ajax_async(url,callbackfuncname)
{
    var XMLHttpRequestObject = false; 
    if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
    else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");

    if(XMLHttpRequestObject)
    {
	XMLHttpRequestObject.open("GET", url, true);
	// Save to array for future use
	XMLObjects.push(XMLHttpRequestObject);
	// Create unique function for each object
        XMLHttpRequestObject.onreadystatechange = new Function(callbackfuncname+"(XMLObjects["+(XMLObjects.length-1)+"]);");
	XMLHttpRequestObject.send(null);
    }
}
</script>

	<table width="100%" cellpadding=0 cellspacing=0>
		<tr>
		<td align=right>
		
			<table cellpadding=0 cellspacing=0>
			<tr>
				<td width=150><a href="https://www.scriptlance.com/cgi-bin/freelancers/project_review.cgi?id=1284572238"><img src="/images/project_review_left.gif" width=150 height=19 border=0 title=""></a></td>
				<td width=4 background="/images/project_review_bg.gif"></td>
				<td width=88 background="/images/project_review_bg.gif"><table cellpadding=0 cellspacing=0><tr><td height=1></td></tr><tr><td>
	<img border="0" src="/images/rate_staror.png" id="1284572238-1" onmouseover="MouseOver(this)" onmouseout="MouseOut(this)" onclick="SendRating(this)" style="cursor:pointer;"><img border="0" src="/images/rate_staror.png" id="1284572238-2" onmouseover="MouseOver(this)" onmouseout="MouseOut(this)" onclick="SendRating(this)" style="cursor:pointer;"><img border="0" src="/images/rate_staror.png" id="1284572238-3" onmouseover="MouseOver(this)" onmouseout="MouseOut(this)" onclick="SendRating(this)" style="cursor:pointer;"><img border="0" src="/images/rate_staror.png" id="1284572238-4" onmouseover="MouseOver(this)" onmouseout="MouseOut(this)" onclick="SendRating(this)" style="cursor:pointer;"><img border="0" src="/images/rate_staror.png" id="1284572238-5" onmouseover="MouseOver(this)" onmouseout="MouseOut(this)" onclick="SendRating(this)" style="cursor:pointer;"></td></tr></table>
			</td>
			<td width=4 background="/images/project_review_bg.gif"></td>
			<td background="/images/project_review_bg.gif"><a href="https://www.scriptlance.com/cgi-bin/freelancers/project_review.cgi?id=1284572238" style="text-decoration:none">Comments (0)</a></td>
			<td width=4 background="/images/project_review_bg.gif"></td>
			<td width=3><img src="/images/project_review_right.gif" width=3 height=19 border=0></td>
			</tr>
			</table>
		</td></tr>	
		</table>
	
		</td></tr>
		</table>
	</td>
	</tr>
</table>
<table border="0" cellspacing="0" width="100%">
<tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=2 height=1></td></tr>
<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" width="100" class=dt1 valign=top width=150><b>Status:</td>
<td style="padding:4" class=dt1 valign=top>
Open
 <img src="https://www.scriptlance.com/programmers/graphics/urgent.gif" alt="Urgent!" width=56 height=14 border=0>

</td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt2 valign=top><b>Budget:</td>
<td style="padding:4" class=dt2 valign=top>
<i>N/A</i>
</td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt1 valign=top><b>Created:</td>
<td style="padding:4" class=dt1 valign=top>
9/15/2010 at 13:37 EST
</td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt2 valign=top><b>Bidding Ends:</td>
	<td style="padding:4" class=dt2 valign=top>
	9/29/2010 at 13:37 EST (13 days left)
</td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt1 valign=top><b>Project Creator:</td>
<td style="padding:4" class=dt1 valign=top>
	<table cellspacing=0 cellpadding=0><tr><td><a href="https://www.scriptlance.com/cgi-bin/freelancers/buyers.cgi?view=jojojones">jojojones</a>   </td></tr>
		<tr><td height=2></td></tr>
		<tr><td><small>Rating:
	(No Feedback Yet)
</td></tr>
	</table></td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt2 valign=top><b>Description:</td>
<td style="padding:4" class=dt2 valign=top>
We need six sites posted to our hosting service and edited immediately, please do not post an offering if you are not prepared to start this immediately... basic sites nothing too extavagent, but required immediately.<hr color="DDE1E8"><i>Additional Info (Added 9/15/2010 at 13:37 EST)...</i><p>System Message: This is a reposting of project <a href="http://www.scriptlance.com/projects/1284529502.shtml">post 6 Sites</a> (1284529502).
<br><br>
</td>
</tr>

<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt1 valign=top><b>Tags:</td>
<td style="padding:4" class=dt1 valign=top>
<table width="100%" cellspacing=0 cellpadding=0 border=0><tr><td valign=top><a href="/tag/Posting" style="text-decoration: none">Posting</a></td><td width=47 align=right valign=top><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?project_tags_edit=1284572238"><img src="/images/edit_small.png" border=0 width=42 height=13 title="Change Tags"></a> </td></tr></table></td>
</tr>

<tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=2 height=1></td></tr>	
</table>

<br><br>
<table><tr>
	<td><a href="https://www.scriptlance.com/cgi-bin/freelancers/forum.cgi?viewsub=1284572238"><img src="https://www.scriptlance.com/programmers/graphics/viewboard.gif" border=0 alt="View Message Board for this Project"></a></td>
	<td width=10></td>
	<td>Messages Posted: <b>0</b></td>
	</tr>
</table>
<br><br>
<a name="bids"></a>


<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td width=218>
	<table cellspacing=0 cellpadding=0>
               <tr><td background=/images/m33.gif width=218 height=27 class=me3 align=center>PROJECT BIDS</td></tr>
              </table>
</td><td align=right>
<a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?bid=1284572238"><img src="https://www.scriptlance.com/programmers/graphics/placebid.gif" border=0 alt="Place Bid"></a>
</td></tr>
</table>

<table border="0" cellspacing="0" width="100%">
<tr>
<td width=2 bgcolor="#FF9E2C"></td>
<td style="padding:4" class=dt><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?id=1284572238&order=username%20ASC#bids" style="text-decoration: none">Programmers</font></a></td>
<td style="padding:4" class=dt><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?id=1284572238&order=bid%20DESC#bids" style="text-decoration: none">Bid <img src="/programmers/graphics/arrow.gif" width=12 height=9 border=0></font></a></td>
<td style="padding:4" class=dt><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?id=1284572238&order=days%20ASC#bids" style="text-decoration: none">Delivery Time</font></a></td>
<td style="padding:4" class=dt><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?id=1284572238&order=time%20ASC#bids" style="text-decoration: none">Time of Bid</font></a></td>
<td style="padding:4" class=dt align=center><a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?id=1284572238&order=b.rating%20DESC#bids" style="text-decoration: none">Rating</font></a></td>
<td style="padding:4" width=13 class=dt>&nbsp;</td>
<td width=19 style="padding:4" class=dt>&nbsp;</td>
</tr>

	<tr>
	<td width=2 bgcolor="#FF9E2C"></td>
	<td style="padding:4" class="dt1"><a href="https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?viewprofile=adroit2009">adroit2009</a></td>
	<td style="padding:4" class="dt1">$50</td>
	<td style="padding:4" class="dt1">Immediately</td>
	<td style="padding:4" class="dt1">9/15/2010 at 13:51 EST</td><td style="padding:4" class="dt1"><center><a href="https://www.scriptlance.com/cgi-bin/freelancers/feedback.cgi?p=adroit2009"><img src="https://www.scriptlance.com/images/rating_10.gif" border=0 alt="9.57/10" title="9.57/10" width=81 height=7><br><small>(<b>19</b> reviews)</a></td><td style="padding:4" class="dt1"><a href="/escrow.shtml"><img src="/images/escrow_icon.png" width=13 height=18 border=0 title="adroit2009 only accepts payments via ScriptLance Escrow"></a></td><td style="padding:4" class="dt1" align=right><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/report_violation.cgi?t=b&pid=1284572238&id2=adroit2009" onmouseover="document.reportbid_adroit2009.src='/images/report_red.gif'" onmouseout="document.reportbid_adroit2009.src='/images/report.gif'"><IMG SRC="/images/report.gif" WIDTH="19" HEIGHT="19" BORDER="0" title="Report Bid Violation" name="reportbid_adroit2009"></a></td></tr>
	<tr>
	<td width=2 bgcolor="#FF9E2C"></td><td style="padding:4" class="dt1" colspan=8>Do u need site uploaded and make it working on ur hosting server ??
	</td></tr><tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=8 height=1></td></tr>
	<tr>
	<td width=2 bgcolor="#FF9E2C"></td>
	<td style="padding:4" class="dt2"><a href="https://www.scriptlance.com/cgi-bin/freelancers/freelancers.cgi?viewprofile=panduram8">panduram8</a></td>
	<td style="padding:4" class="dt2">$79</td>
	<td style="padding:4" class="dt2">1 day</td>
	<td style="padding:4" class="dt2">9/15/2010 at 1:58 EST</td><td style="padding:4" class="dt2"><center><small>(No Feedback Yet)</small></td><td style="padding:4" class="dt2"><a href="/escrow.shtml"><img src="/images/escrow_icon.png" width=13 height=18 border=0 title="panduram8 only accepts payments via ScriptLance Escrow"></a></td><td style="padding:4" class="dt2" align=right><A HREF="https://www.scriptlance.com/cgi-bin/freelancers/report_violation.cgi?t=b&pid=1284572238&id2=panduram8" onmouseover="document.reportbid_panduram8.src='/images/report_red.gif'" onmouseout="document.reportbid_panduram8.src='/images/report.gif'"><IMG SRC="/images/report.gif" WIDTH="19" HEIGHT="19" BORDER="0" title="Report Bid Violation" name="reportbid_panduram8"></a></td></tr>
	<tr>
	<td width=2 bgcolor="#FF9E2C"></td><td style="padding:4" class="dt2" colspan=8>i will start immediatly!
	</td></tr><tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=8 height=1></td></tr></table>
<p>
<a href="https://www.scriptlance.com/cgi-bin/freelancers/project.cgi?bid=1284572238"><img src="https://www.scriptlance.com/programmers/graphics/placebid.gif" border=0 alt="Place Bid"></a>
<br><br>
<br>
		<table border="0" cellspacing="0" width="100%">
		<tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=4 height=1></td></tr>
		<tr>
		<td width=2 bgcolor="#FF9E2C"></td><td class=dt1 width=5></td><td class=dt1 width=100><b>Related Projects:</b> </td><td class=dt1>
			<table width="100%"><tr>
			<td width="20%" align=center><a href="http://www.scriptlance.com/projects/1284572608.shtml">post six sites</a></td>
			<td width="20%" align=center><a href="http://www.scriptlance.com/projects/1284572803.shtml">post six (6) websites with moderate editing</a></td>
			<td width="20%" align=center><a href="http://www.scriptlance.com/projects/1284430679.shtml">upgrade 2 Coppermine sites from 1.4.18 to latest version</a></td>
			<td width="20%" align=center><a href="http://www.scriptlance.com/projects/1284135963.shtml">Looking for someone to post ads.</a></td>
			<td width="20%" align=center><a href="http://www.scriptlance.com/projects/1283468700.shtml">posting on forums - 10cents per post - 500 pos</a></td>
			</tr></table>
		</td><td class=dt1 width=50><a href="http://www.scriptlance.com/cgi-bin/freelancers/search.cgi?keywords=post+or+6+or+Sites+or+2&showstatus=open&desc=1">More...</a></td>
		</tr>
		<tr><td width=2 bgcolor="#FF9E2C" height=1></td><td class=dt colspan=4 height=1></td></tr>
		</table>
		<br><br>
		         </td><td width=12></td></tr>
        </table>
   </td></tr>
   <tr><td valign=bottom bgcolor=#ffffff>
        <table cellspacing=0 cellpadding=0 width=100%>
         <tr><td height=5></td></tr>
         <tr><td background=/images/m37.gif height=4></td></tr> 
         <tr><td height=5></td></tr>
        </table>
        <table cellspacing=0 cellpadding=0 width=100% height=66>
         <tr><td class=bg>
              <table cellspacing=0 cellpadding=0>
               <tr><td width=13 height=66 bgcolor=#ffffff></td>
                   <td width=183 height=66 bgcolor=#ffffff valign=top> 
                    <table cellspacing=0 cellpadding=0>
                     <tr><td>Copyright &copy; 2001 - 2010<br>ScriptLance is a trade-mark of<br><b><a href=http://www.r3n3.com class=ml3>R3N3 International Inc</a></b>
					</td></tr>
					<tr><td height=5></td></tr>
					<tr><td><center>

<a href="http://twitter.com/scriptlance"><img src="/images/twitter16.png" width=16 height=16 border=0 title="Follow ScriptLance on Twitter!"></a>

<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=scriptlance" addthis:url="http://www.scriptlance.com" addthis:title="ScriptLance Freelance Programming"><img src="https://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pub=scriptlance"></script>
<!-- AddThis Button END -->

					 </td></tr>
                    </table>
                   </td>
                   <td width=579>
                    <table cellspacing=0 cellpadding=0>
                     <tr><td><img src=/images/m38.jpg width=7 height=66></td>
                         <td>
                           <table cellspacing=0 cellpadding=0>
                            <tr><td colspan=18 height=10></td></tr>
                            <tr><td width=10></td><td class=ml2><a href="/sitemap.shtml" class=ml2>Site Map</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/rss" class=ml2>RSS</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/privacy.shtml" class=ml2>Privacy Policy</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/terms.shtml" class=ml2>Terms</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/report.shtml" class=ml2>Report Violations</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/affiliates.shtml" class=ml2>Affiliates</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/faq.shtml" class=ml2>FAQ</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/forum.shtml" class=ml2>Forum</a></td><td><img src=/images/m39.gif width=9 height=9 hspace=3></td><td class=ml2><a href="/contact.shtml" class=ml2>Contact Support</a></td></tr>
                           </table>
                           <table cellspacing=0 cellpadding=0>
                            <tr><td height=15 colspan=2></td></tr>
                            <tr><td height=27 width=10></td><td><a href=http://www.graphicsguru.com class=wdb>Graphic Design</a> by: <a href=http://www.graphicsguru.com class=ml3 target=_blank>Graphicsguru.com</a></td></tr>                            
                           </table>
                      </tr></td>
                      <tr><td height=40 colspan=2></td></tr>
                    </table>
               </td></tr>
              </table>
         </td></tr>
        </table>
   </td></tr>
  </table>

<script src="https://ssl.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-294433-1";
urchinTracker();
</script>

</body>
</html>
