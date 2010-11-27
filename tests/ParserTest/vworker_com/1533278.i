
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" 
>
<head>

    

    <title>vWorker.com - PHP-Upload files to server-testamonial setup-Fix 2 small problems</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    
        
      <meta HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" media="print" 
        href="/RentACoder/DotNet/2010Redesign/stylesheets/print.css"/>
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="screen" href="/RentACoder/DotNet/2010Redesign/stylesheets/ie.css"/><![endif]-->

    <style type="text/css">
    </style>
    
    <LINK REL="shortcut icon" href="/images/IconExperience/ObjectsAndPeople/ico-files/user1_monitor.ico">
<meta name="description" content="<p><span style=&quot;color: black; font-size: 9pt;&quot;>I need 2 fixes to 4 existing PHP web pages, It should be very simple for someone who knows PHP programming. <br />
<br />
the pages are for collecting data from a user and storing that to a database and uploading pictures to a folder on the web site.<br />
<br />
the pages are working now but need a couple of changes:<br />
<br />
 1. have multiple upload boxes so a user can upload more then one image at a time.<br />
<br />
2. have the option to not upload any pictures if the don&rsquo;t want to but still they can continue and upload their testimonial.<br />
<br />
Security:<br />
<br />
user can only upload a JPG image<br />
<br />
the entry page is at:<br />
<A target=_blank HREF=&quot;/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fpanamahatsdirect%2Ecom%2FTestimonials%2FST1%2Ephp%3Finvoice%3D10521&quot;>http://panamahatsdirect.com/Testimonials/ST1.php?invoice=10521</a><br />
<br />
a video detailing exactly what i need is located at:<br />
<A target=_blank HREF=&quot;/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fpanamahatsdirect%2Ecom%2FTestimonials%2Fvideo%2FTestamonials%2520job%2Ehtm&quot;><span style=&quot;color: #0f66ba;&quot;>http://panamahatsdirect.com/Testimonials/video/Testamonials%20job.htm</span></a><br />
<br />
Please watch the short video before bidding.</span></p>">
<meta name="keywords" content="web, development, software, networking, information systems, electronics, creative arts, writing, translations, design arts, multimedia, administrative support,business services, customer service, sales and marketing, advertising, legal, paralegal">
<meta name="title" content="vWorker.com - PHP-Upload files to server-testamonial setup-Fix 2 small problems">
<meta NAME="Copyright" CONTENT="Copyright 2001-2010, Exhedra Solutions, Inc.">
<meta NAME="Creator" CONTENT="Exhedra Solutions, Inc">
<meta NAME="Publisher" CONTENT="Exhedra Solutions, Inc.">
<meta NAME="Distribution" CONTENT="Global">
<meta NAME="Rating" CONTENT="General">
<meta NAME="Robots" CONTENT="All"><!--Frame Buster-->
		<script language="Javascript">
		    if (top.location != self.location) 
				{
		    	top.location = self.location.href
				}
		</script>
<link rel="stylesheet" type="text/css" media="screen"  href="/RentACoder/DotNet/2010Redesign/stylesheets/screen.css" />
<script type="text/javascript" src="/CrossWeb/Javascript/javascript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!-- Javascript -->
<!--[if lte IE 6]><script src="/RentACoder/DotNet/2010Redesign/javascripts/DD_belatedPNG.js" type="text/javascript"></script><![endif]-->
<script type="text/javascript" src="/RentACoder/DotNet/2010Redesign/javascripts/jquery-qtip-1.0.0-rc3182052/jquery.qtip-1.0.0-rc3.min.js"></script><script src="/RentACoder/DotNet/2010Redesign/javascripts/application.js" type="text/javascript"></script>


</head>


<body  >

    <div class="background">
    
    
            <div class="PostHead">
                <A HREF="#mainContent" STYLE="position: absolute; left: -1000px;">Skip Navigation</A>

            </div>


            <div class="page">
              

                    <div class="header">
                        <div class="container"><div class="container-inner">

                            <div class="logo"><a href="/RentACoder/" title="vWorker - Homepage">
                                vWorker</a></div>
                            <p class="motto"><!strong>More <a href="/RentACoder/DotNet/misc/About/default.aspx#tagline_MoreCapable">capable</a>, <a href="/RentACoder/DotNet/misc/About/default.aspx#tagline_MoreAccountable">accountable</a> and <a href="/RentACoder/DotNet/misc/About/default.aspx#MoreAffordable">affordable</a>. <a href="/RentACoder/DotNet/misc/About/default.aspx#Guaranteed">Guaranteed</a>.<!/strong></p>

                            
 <div class="tools">
 
     
          <ul class="menu">
              <li class="first-child">
                <a href="/RentACoder/authentication/Login.asp?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278" style="text-decoration: underline"
                    >Sign In</a> | <a href="https://www.vWorker.com/Ads/authentication/GetUserId.asp?lngWId=1&txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278" style="text-decoration: underline"
                    >Create account</a>
          </ul>
    


</div> <!-- / #tools -->


           		
                            <div class="navigation">
                            
                               
        <ul class="main">
            <li  class="current" ><a 
                href="/RentACoder/DotNet/SoftwareBuyers/HowItWorks.aspx?intTabSelectedId=1" 
            >Employers</a></li>
            <li ><a href="/RentACoder/DotNet/SoftwareCoders/HowItWorks.aspx?intTabSelectedId=2" 
            >Workers</a></li>
            <li ><a 
                href="/RentACoder/DotNet/Affiliates/Help.aspx?intTabSelectedId=3">Affiliates</a></li>
            <li class="nav_help"><a href="/RentACoder/DotNet/misc/Help.aspx" title="Help">Help</a></li>
        </ul>  

    
           
        <ul class="secondary">
        
                        <li class="first-child">
                           
                            <a rel="nofollow" href="javascript:window.location.href='/RentACoder/SoftwareBuyers/NewBidRequest.asp?intTabSelectedId=1';"><img  align="AbsMiddle"   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_pinned.png" width="16" height="16" /> Post new project</a></li>
                        <li>
                            
                            <a href="/RentACoder/SoftwareBuyers/SearchCoders.asp?intTabSelectedId=1"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/business_finance_data/16x16/plain/businessman_find.png" width="16" height="16" /> Search workers</a></li>
                    
                    <li class="dropdown">
                        <a href="#"><img  align="AbsMiddle"   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/folder_into.png" width="16" height="16" /> My account...</a>
                        <span class="dropdown-tip"></span>
                            <ul>
                        
                                <li><a href="/RentACoder/authentication/Login.asp?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278">Sign in</a></li>
                        
                            <li class="dropdown">
                                
                                <a href="#"><img  align="AbsMiddle"   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/folder_into.png" width="16" height="16" /> Site layout...</a>
                                <span class="dropdown-tip"></span>
                                <ul>

                                    <li>
                                        
                                        <a href="/RentACoder/DotNet/2010Redesign/MoveMenu.aspx?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278&intTabSelectedId=1"
                                        ><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/selection_replace.png" width="16" height="16" /> Move menu</a></li>
                                    <li>
                                        
                                        <a target="_blank" href="http://www.vworker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533278&blnShowWideScreen=true&intTabSelectedId=1"
                                        ><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/selection_replace.png" width="16" height="16" /> Wide-screen page</a></li>                                
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                        <li>
                            
                            <a href="/RentACoder/DotNet/misc/Tools.aspx?intTabSelectedId=1#For_Buyers"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/objects_people_industries/16x16/plain/toolbox.png" width="16" height="16" /> Tools</a></li>
                        <li>
                            
                            <a href="/RentACoder/DotNet/SoftwareBuyers/Articles/default.aspx?intTabSelectedId=1"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/business_finance_data/16x16/plain/briefcase_document.png" width="16" height="16" /> Articles</a></li>
                        <li>
                            
                            <a href="/RentACoder/DotNet/SoftwareBuyers/SoftwareBuyerFAQ.aspx?intTabSelectedId=1"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/business_finance_data/16x16/plain/note.png" width="16" height="16" /> FAQ</a></li>
                        <li>
                            
                            <a href="/RentACoder/DotNet/misc/News.aspx?intTabSelectedId=1"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/computer_network_security/16x16/plain/newspaper.png" width="16" height="16" /> News</a></li>
                        
                        <li>
                            
                            <a href="/RentACoder/DotNet/misc/Help.aspx?intTabSelectedId=1#Employers"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/Help2.png" width="16" height="16" /> Help</a></li>
                        
                    
    </ul>
               		            
        	              
                            </div> <!-- / #navigation -->          		
                        </div></div> <!-- / .container -->
                    </div> <!-- / header -->

                    
                    
                <hr />          
            
                    <div class="container container-main">
                        <div class="wrapper">  
                            <div class="content"><div class="content-inner"><a name="mainContent"></a>
                                <table class="ProtectiveTable" width="100%"><tr><td> <!-- Protective table -->
                            
                            
<script type="text/javascript">
   function HideBroadcastMessage(){
      $.get('/RentACoder/DotNet/misc/HideBroadcastMessage.aspx?txtForceRefresh=11420101925686301', function(data) {
           $('#idBroadcastMessage_Top').hide();
           });
    }
</script>
<div id="idBroadcastMessage_Top"><table width=100% class="BroadCastMessageBackground NormalText8pt"><tr><td><b>Site Wide Message:</b>&nbsp;Posted Nov 2, 2010 1:55:02 PM <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>.</td><td align="right"><a href="#" onclick="HideBroadcastMessage();return false;"><img alt="Dismiss" class="BroadCastMessage_DismissImage" width="16" height="16" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/navigate_cross.png"  /></a><a href="#" onclick="HideBroadcastMessage();return false;">Dismiss this message</a></td></tr><tr><td colspan="2"><div class="BroadCastMessage_Inner"><!--start msg--><table ID="Table2">
					<tr>
						
						<td  valign=top><font face=verdana color="black" size=1><ol><li>The database issues from last week have been resolved and we thank you for your patience.  For those interested in what happened, you can find <a href="http://blog.vworker.com/2010/10/downtime-and-database-migration.html" target="_blank">detailed information here</a>.</li><li>Site-wide instant messaging in beta!  Employers, now you can interview workers more quickly and both employers and workers can communicate faster, quicker and easier before.  Click here to <a href="http://www.vworker.com/RentACoder/DotNet/docs/InstantMessaging.aspx">learn more</a>!</li><li>vWorker in the news: <a target=_"blank" href="http://blog.vworker.com/2010/10/vworker-cited-as-place-for-iphone-app.html">Bloomberg Business week</a> cited us as the site to go to for iPhone developers, CEO (Ian Ippolito) was <a href="http://blog.vworker.com/2010/10/radio-interview-with-ceo-of-vworker-ian.html">interviewed on the radio</a>, we were mentioned in <a href="http://blog.vworker.com/2010/09/forbescom-calls-vworker-coder-haven.html" target="_blank" rel="nofollow">Forbes magazine</a>, won the <a href="http://blog.vworker.com/2010/08/vworker-is-in-2010-inc-5000.html" target="_blank">2010 Inc 5000 award</a> for fastest growing private company for the fourth year in a row, and are showing up <a href="http://blog.vworker.com/2010/09/vworker-in-news.html" target="_blank">all over the news</a>!  Thanks for telling others about us!</li></ol></i></font></td>
					</tr>
				</table></td></div><!--end msg--></td>
</tr>
</table></div><SCRIPT LANGUAGE=JAVASCRIPT><!--
    
    var strUniqueId = '0000'; //declare variable

$(document).ready(function () {
    //generate once per page so that it caches if clicked twice (without a refresh of page)
    strUniqueId = Math.floor(Math.random()*10001);
    //alert (strUniqueId);
});
    
    
//var strUniqueId = 7801201011419256; 


    function DownloadFile(DownloadTypeId,Integer1) {
        
        var strBaseURL = '/RentACoder/DotNet/misc/DownloadFile.aspx?lngDownloadTypeId=' + DownloadTypeId + '&lngInteger1=' + Integer1 + '&txtForceRefresh=' + strUniqueId;
        var strParms = getCookie("Person");
        
        var strURL=strBaseURL + "&" + strParms;
        //alert ('value:');
        return strURL;
    }


// Sets cookie values. Expiration date is optional
//
function setCookie(name, value, expire) {
          document.cookie = name + "=" + escape(value)
          + ((expire == null) ? "" : ("; expires=" + expire.toGMTString()))
}

function getCookie(Name) {
	var search = Name + "="
	if (document.cookie.length > 0) { // if there are any cookies
		offset = document.cookie.indexOf(search) 
		if (offset != -1) { // if cookie exists 
		offset += search.length 
		// set index of beginning of value
		end = document.cookie.indexOf(";", offset) 
		// set index of end of cookie value
		if (end == -1) 
		end = document.cookie.length
		return unescape(document.cookie.substring(offset, end))
		} 
	}
}

//--></SCRIPT>
        <style type="text/css">
        .AutoResizeImageToParent{max-width:333px;}
        </style>
        
        <script type="text/javascript">
        $(document).ready(function() {
          AdjustImage_MaxWidth ();
        });

        function AdjustImage_MaxWidth() {
            /*Adjust maxwidth of all Images to the direct parent's 
            width(which should be a TD) -4 (for margins*/
            $('.AutoResizeImageToParent').css("max-width", 
                parseFloat($('.AutoResizeImageToParent').parent().css("width"))-4
                );
            } 
        </script>
    <script language="Javascript1.2"><!-- // load htmlarea
_editor_url = "/CrossWeb/include/CustomControls/RichTextBox/HTMLArea/";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
  document.write('<scr' + 'ipt src="' +_editor_url + 'editor.asp"');
  document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// --></script>

<center><table border=0 width="90%"><tr><td><center><table border=0 cellpadding="5"><tr><td align="right" valign="top">
        <a href="javascript:ShowPopupWindowXYWithScrollbars('/RentACoder/dotnet/Docs/FindersFeeComissionSchedule.aspx',600,650)"><img   border="0" src="/images/IconExperience2008/v_collections_png/objects_people_industries/128x128/plain/clock.png" width="128" height="128" /></a>
	</td><td valign="top" class="FontSize2">
	    	    <table width="100%" bgcolor="black">
					<tr>
						<td width="*"><center><font color="white">
						    
							<h1>PHP-Upload files to server-testamonial setup-Fix 2 small problems<br>
							<font size="1">Project Id: 1533278</font><br>
							</b>
						</td>
						<td width="187" bgcolor="white">
						    
                            <script type="text/javascript" 
                            src="http://://s7.addthis.com/js/250/addthis_widget.js#username=IanIppolito">
                            </script>
                            
							<table width="187">
							    <tr>
							        <td>
							             <img src="/RentACoder/images/new.png" border="0"/>
							        </td>
							        <td>
							           
							            
			        



    <a href="http://www.addthis.com/bookmark.php"     
        class="addthis_button"    
            addthis:url="http://www.vworker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533278"      
            addthis:title="PHP-Upload files to server-testamonial setup-Fix 2 small problems"      
            addthis:description="<p style=\&quot;vertical-align: baseline;\&quot;><span style=\&quot;color: black; font-size: 9pt;\&quot;>I need 2 fixes to 4 existing PHP web pages, It should be very simple for someone who knows PHP programming. <br />\r\n<br />\r\nthe pages are for collecting data from a user and storing that to a database and uploading pictures to a folder on the web site.<br />\r\n<br />\r\nthe pages are working now but need a couple of changes:<br />\r\n<br />\r\n\&nbsp;1. have multiple upload boxes so a user can upload more then one image at a time.<br />\r\n<br />\r\n2. have the option to not upload any pictures if the don\&rsquo;t want to but still they can continue and upload their testimonial.<br />\r\n<br />\r\nSecurity:<br />\r\n<br />\r\nuser can only upload a JPG image<br />\r\n<br />\r\nthe entry page is at:<br />\r\n<a href=\&quot;http://panamahatsdirect.com/Testimonials/ST1.php?invoice=10521\&quot;>http://panamahatsdirect.com/Testimonials/ST1.php?invoice=10521</a><br />\r\n<br />\r\na video detailing exactly what i need is located at:<br />\r\n<a href=\&quot;http:" 
        style="text-decoration:none;">
    </a>
							        </td>
							    </tr>
					    
								<tr>
									<td width="19" valign="top">
									    <a href="/RentACoder/misc/AddToDoListItem.asp?lngBidRequestId=1533278">
										<img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/book_blue_preferences.png" width="16" height="16" /></a>
									</td>
									<td valign="top" width="*" bgcolor="white" class="FontSize1">
										Bookmark in 
										<a href="/RentACoder/misc/AddToDoListItem.asp?lngBidRequestId=1533278">my 
										'To Do' list</a>
									</td>			

								</tr>
							</table>
						</td>
					</tr>
				</table>
      
	</td></tr></table></center></td></tr></table>

	<table width="100%" border="0" cellspacing="1" cellpadding="1">			

		<tr>
			<td>
				
			</td>			
		</tr>
		<tr>
			<td colspan="2"><center>
				
				<table border="0" cellspacing="2" cellpadding="2" width="100%">
					<tr>
						
						<td valign="top" width="50%">
							<table border="0" width="100%">
								<tr>
									<td valign="top" nowrap align="right">
										<font size="1">
										<b>Posted by:</b></td>
									<td valign="top"><font size="1">
									    <a target="_blank" href="/RentACoder/DotNet/docs/InstantMessaging.aspx#IMStatuses"><img border="0" alt="False|1"  class="clsImPresence_1207964_16"  src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/window_error.png"  width="16" height="16"></a>&nbsp;
										 <a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=1207964">Cdazell</a> <font size="1"><a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=1207964#BuyerRating">(5 ratings)</font></a><br>
										<font size="1">(Employer rating 10<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/RatingLegend.aspx')"><img border=0 height=18 width=19 src="/RentACoder/images/icons/Rating4.gif"></a>)<br>
										
									</td>
								</tr>
								

									
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Non-action Ratio:<!/a></b></td>
									<td valign="top"><font size="1">
										<a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=1207964#NonActionRatio">Above Average<!/a> - 33.33%</a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Employer Security Verifications:</b></td>
									<td valign="top"><font size="1">
										<a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=1207964#SecurityVerifications"><img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/user1_telephone.png" width="16" height="16" /><img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/user1_preferences.png" width="16" height="16" />Excellent</a>
									</td>
								</tr>


								

								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Approved on:</b></td>
									<td valign="top"><font size="1">
										Nov 4, 2010<BR>6:57:36 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>
									</td>
								</tr>
							
								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Bidding Closes:</b></td>
									<td valign="top"><font size="1">
										 Nov 18, 2010<BR>6:56:12 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Viewed (by workers):</b></td>
									<td valign="top"><font size="1">
										 13 times
										</font>
									</td>
								</tr>

								
								
							</table>
							
						</td>
						
						
						<td width="50%" valign=top>
				
							<table width="100%">
								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Phase:</b></td>
									<td valign="top"><font size="1">
										 <a href="javascript:ShowPopupWindowXY('/RentACoder/DotNet/docs/PhaseLegend.aspx',800,575)"><img border=0 height=17 width=68 src="/RentACoder/images/StatusBar/Phase2.jpg"></a><br>
										 <a href="javascript:ShowPopupWindowXY('/RentACoder/DotNet/docs/PhaseLegend.aspx',800,575)">Bidding open</a>
										 
										 
										 
									</td>
								</tr>
                            
                                <tr>
                                    <td valign="top" align="right"><font size="1"><b><a href="/RentACoder/DotNet/docs/ProjectPaymentTypes_ForBuyers.aspx" target="_blank">Payment Model</a>:</b></font></td>
                                    <td><font size="1">Pay-for-Time<br />
Buyer does not require a <a href="/RentACoder/DotNet/misc/TimeCard/DesktopApp/Overview.aspx#WebCamOptional">webcam</a></font></td>
                                </tr>
								
									<tr>
										<td valign="top" align="right"><font size="1">
											<b>Max Accepted Bid:</b></td>
											
												<td valign="top"><font size="1">
													Open to fair suggestions
														
												</font></td>
												
									</tr>
									
								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Project Type:</b></td>
									<td valign="top"><font size="1">
										 <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/ProjectTypeLegend.aspx')">
										 Very Small Business Project: under $100(USD)
										 </a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Bidding Type:</b></td>
									<td valign="top"><font size="1"> 
										 <a href="javascript:ShowPopupWindowXYWithScrollbars('/RentACoder/dotnet/Docs/FindersFeeComissionSchedule.aspx',600,650)"><img   border="0" src="/images/IconExperience2008/v_collections_png/objects_people_industries/16x16/plain/clock.png" width="16" height="16" /></a>
										 <a href="javascript:ShowPopupWindowXYWithScrollbars('/RentACoder/dotnet/Docs/FindersFeeComissionSchedule.aspx',600,650)">Open Auction</a>
										 										 
											
									</td>
								</tr>
								
								
							     <tr>
							        <td valign="top" align="right"><font size="1">
								        <b>Accepted Bidder <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/dotnet/Docs/EconomyType.aspx')">Economy Type(s)</a>:</b></td>
							        <td valign="top"><font size="1"> 
							            <table>
							                All
                                         </table>
						            </td>
							     </tr>
								
							     <tr>
							        <td valign="top" align="right"><font size="1">
								        <b>Accepted <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/dotnet/Docs/EnglishFluencyType.aspx')">English fluency(ies)</a>:</b></td>
							        <td valign="top"><font size="1"> 
							            <table>
							                <tr>
        <td valign=top><font size=1>-</font></td>

        <td valign=top><font size=1>English as a second language</font></td>
    </tr>
                                        </table>
						            </td>
							     </tr>

								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>ExpertRating Requirement:</b></td>
									<td valign="top"><font size="1">
										 None
									</td>
								</tr>
								
							</table>
						</td>	
								
					</tr>
					
					
					<tr>
						<td colspan="2"><center>
						
							
							<table>	
								
								
								<tr>	
										<td colspan=2><center><a name="AllTabs"></a>
										
		<table width="570" 
		class="TableBackground TableBorder" cellpadding="2" cellspacing="2"  
		 ID="Table8">
			<tr>
				<td width="110" bgcolor="#EEEEEE" valign=top align="center">
				    <font face="Verdana"><font size="1" ><b>Shortcuts</b><br><br>
					<img   border="0" src="/images/IconExperience2008/v_collections_png/computer_network_security/64x64/shadow/keyboard_key.png" width="64" height="64" />
					</font></td>
				<td valign=top>
				
					<table >
						<tr>
							<td valign=top><font size=1>
								<b>Communication</b><br>
								<br><a href="#Messagessummary"><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_pinned.png" width="16" height="16" />Messages summary</a><BR><a href="#Postfirstreply"><img   border="0" src="/images/IconExperience/NetworkAndSecurity/16x16/shadow/mail_forward.png" width="16" height="16" />Post first reply</a><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/messages.png" width="16" height="16" />Chat log</font><BR>
							</td>
							<td valign=top><font size=1>
								<b>During project work</b><br>
								<br>
								<font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/chest_into.png" width="16" height="16" />Escrow Log</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/@Custom/16x16/shadow/chart_gantt.png" width="16" height="16" />AccuTimeCard™ List</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/money_envelope.png" width="16" height="16" />Work acceptance</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/briefcase.png" width="16" height="16" />Assembla Tools</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/auction_hammer.png" width="16" height="16" />Mediation / Arbitration</font><BR>
							</td>
							<td valign=top><font size=1>
								<b>Other</b><BR>
								<br>
								<font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/address_book3.png" width="16" height="16" />Contact info / receipts</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_time.png" width="16" height="16" />Project phase log</font><BR><a href="#Ratings"><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_chart.png" width="16" height="16" />Ratings</a><BR>
							</td>
						</tr>
						<tr>
							<td colspan="3"><font size="1" color="black"><center><br>
							(Note:options <font color="#808080">without links</font> are not enabled for this phase.)</font></td>
						</tr>

					</table>
					</font>
				</td>
			</tr>
		</table>
									</td>
								</tr>
								
									<tr>
										<td valign="top" align="right" colspan="3">
											<a name="Chat"></a>
											<center>
											<table border="0">
												<tr>
													<td>
														<font size="1"><br>
														<center>
														
													</td>
												</tr>
											</table>
										</td>
									</tr>
									
																
								
							</table>
				
						</td>
					</tr>
				</table>
				
				

					<table width="90%">
						<tr>
							<td colspan="2">
								
								</center>
								<br>
								
								
								<font size="1">
								<b><font size="2">
									</b><b><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document.png" width="16" height="16" /> Brief Summary:
									</b></b><br>
									<ul><font size=1><li><a name="NoWorkInAdvance"></a>vWorker.com reminder: You MAY NOT post the final solution for this (and any) project before your bid is accepted and funds are fully escrowed.  Anyone who does may have their account permanently suspended.  However, you CAN post:<ul><li>On programming projects: A prototype or functional demo...as long as source code is not provided.</li><li>On graphics projects: A watermarked and low-resolution version of the work.</li></ul></li>
</font></ul><div class="KonaBody"><p><span style="color: black; font-size: 9pt;">I need 2 fixes to 4 existing PHP web pages, It should be very simple for someone who knows PHP programming. <br />
<br />
the pages are for collecting data from a user and storing that to a database and uploading pictures to a folder on the web site.<br />
<br />
the pages are working now but need a couple of changes:<br />
<br />
 1. have multiple upload boxes so a user can upload more then one image at a time.<br />
<br />
2. have the option to not upload any pictures if the don&rsquo;t want to but still they can continue and upload their testimonial.<br />
<br />
Security:<br />
<br />
user can only upload a JPG image<br />
<br />
the entry page is at:<br />
<A target=_blank HREF="/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fpanamahatsdirect%2Ecom%2FTestimonials%2FST1%2Ephp%3Finvoice%3D10521">http://panamahatsdirect.com/Testimonials/ST1.php?invoice=10521</a><br />
<br />
a video detailing exactly what i need is located at:<br />
<A target=_blank HREF="/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fpanamahatsdirect%2Ecom%2FTestimonials%2Fvideo%2FTestamonials%2520job%2Ehtm"><span style="color: #0f66ba;">http://panamahatsdirect.com/Testimonials/video/Testamonials%20job.htm</span></a><br />
<br />
Please watch the short video before bidding.</span></p></span><br></font>
									<br>


									<font size=2><b><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_info.png" width="16" height="16" />
                                    Requirements Interview Answers: <img src="/RentACoder/images/new.png"></b></font><BR />
                                    <font size=1>
                                    
                                    To help you bid more accurately, the employer was interviewed about the requirements for this project.  Below are their answers.
                                    </font>
                                    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head><title>
	Untitled Page
</title></head>
<body>
    <form name="form1" method="post" action="WizardOutput.aspx?lngBidRequestId=1533278" id="form1">
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUJMzQzMDUwMzIxD2QWAgIDD2QWAgIBD2QWBAICD2QWAgIBD2QWHmYPZBYEZg8WAh4JaW5uZXJodG1sBRQ8Yj5Qcm9qZWN0IFR5cGU6PC9iPmQCAQ8WAh8ABW1XaGF0IGtpbmQgb2Ygd29yayBkbyB5b3UgbmVlZCBkb25lPzxCUj5Tb2Z0d2FyZSByZWxhdGVkIChJbmNsdWRlcyBkZXNrdG9wIGFwcGxpY2F0aW9ucyBhbmQgaW50ZXJuZXQgd2Vic2l0ZXMpZAIBD2QWBGYPFgIfAAUVPGI+UHJvamVjdCBQYXJ0czo8L2I+ZAIBDxYCHwAFNldoYXQgZG8geW91IHdhbnQgdGhlIHdvcmtlciB0byBkbyBvbiB0aGlzIHByb2plY3Q/PEJSPmQCAw9kFgRmDxYCHwAFFjxiPlJlcS4gRG9jLiBUeXBlOjwvYj5kAgEPFgIfAAXrBFdoYXQga2luZCBvZiBkb2N1bWVudGF0aW9uIGRvIHlvdSB3YW50IGZvciB0aGlzIHByb2plY3Q/PEJSPkluZm9ybWFsIGRvY3VtZW50YXRpb24gLSBBcyB0aGUgZW1wbG95ZXIgdGFsa3MgYmFjayBhbmQgZm9ydGggYWJvdXQgdGhlIHByb2plY3Qgd2l0aCB0aGUgd29ya2VyLCB0aG9zZSBjb252ZXJzYXRpb25zIGJlY29tZSB0aGUgcmVxdWlyZW1lbnRzLlJlbWVtYmVyIHRvIGNvbW11bmljYXRlIEFMTCBvZiB0aGUgZGV0YWlscyBvZiB5b3VyIHByb2plY3Qgb24gdGhlIHZXb3JrZXIuY29tIHNpdGUuICBJZiB5b3UgZG9uJ3QsIGFuZCB0aGVyZSBpcyBhIGRpc3B1dGUsIHRoZW4gaW1wb3J0YW50IGRldGFpbHMgb2YgdGhlIGNvbnRyYWN0IHdpbGwgbm90IGJlIGRvY3VtZW50ZWQgYW5kIGNhbm5vdCBiZSB0YWtlbiBpbnRvIGFjY291bnQgaW4gYXJiaXRyYXRpb24uICBJZiB5b3UgZmVlbCB5b3UgTVVTVCBnbyBvZmZzaXRlIChmb3IgZXhhbXBsZSwgdXNpbmcgdGhlIHBob25lIG9yIElNKSB0aGVuIGFmdGVyd2FyZHMgcG9zdCBldmVyeXRoaW5nIG9uc2l0ZSBhbmQgZ2V0IHRoZSBvdGhlciBwYXJ0eSB0byBwb3N0IHRoYXQgdGhleSBhZ3JlZSB0byB0aG9zZSBjb250cmFjdHVhbCB0ZXJtcy5kAgQPZBYEZg8WAh8ABRQ8Yj5Qcm9ncmFtIFR5cGU6PC9iPmQCAQ8WAh8ABcEBV2hhdCBraW5kIG9mIHNvZnR3YXJlIHNob3VsZCB0aGUgd29ya2VyIGNyZWF0ZSAoYW5kL29yIGluc3RhbGwpPzx1bD48bGk+QW4gaW50ZXJuZXQgd2ViLXNpdGU6IFRoaXMgc29mdHdhcmUgcnVucyBvbiBhIHdlYiBzZXJ2ZXIgYW5kIHVzZXJzIHdpbGwgYWNjZXNzIGl0IHVzaW5nIHRoZWlyIGludGVybmV0IGJyb3dzZXIuPC9saT48L3VsPmQCBQ9kFgJmDxYCHwAFHTxiPkludGVybmV0IHdlYi1zaXRlIGluZm88L2I+ZAIGD2QWBGYPFgIfAAUgPGI+RGVzaWduIGFuZCBmdW5jdGlvbmFsaXR5OjwvYj5kAgEPFgIfAAV1V2hhdCBkb2VzIHRoZSBwcm9ncmFtbWluZyBvZiB0aGlzIHByb2plY3QgaW52b2x2ZT88dWw+PGxpPlByb2dyYW0gRnVuY3Rpb25hbGl0eTogTWFraW5nIHRoZSB3ZWJzaXRlICJ3b3JrIi48L2xpPjwvdWw+ZAIHD2QWBGYPFgIfAAUdPGI+TW9kZWxpbmcgYW5vdGhlciBzaXRlOjwvYj5kAgEPFgIfAAUlRG8geW91IHdpc2ggdG8gbW9kZWwgYW5vdGhlciBzaXRlPyBOb2QCCA9kFgRmDxYCHwAFFzxiPlNpemUgb2Ygd2Vic2l0ZTo8L2I+ZAIBDxYCHwAFR0hvdyBtYW55IHBhZ2VzIG5lZWQgdG8gYmUgY3JlYXRlZC9lZGl0ZWQgaW4gdGhpcyB3ZWJzaXRlPzxCUj5FeGFjdGx5IDQuZAIJD2QWBGYPFgIfAAUcPGI+UHJvZ3JhbW1pbmcgTGFuZ3VhZ2U6PC9iPmQCAQ8WAh8ABaQCV2hhdCBwcm9ncmFtbWluZyBsYW5ndWFnZShzKSBkbyB5b3Ugd2FudCB5b3VyIHdlYnNpdGUgd3JpdHRlbiBpbj88QlI+SSBkbyBrbm93IHRoZSBsYW5ndWFnZShzKS48QlI+TGFuZ3VhZ2VzKHMpOjxCUj48dWw+PGxpPkphdmFzY3JpcHQ8L2xpPjxsaT5QSFA8L2xpPjwvdWw+TWlzYy4gZGV0YWlsczogSXQgZG9zZSBjb25uZWN0IHRvIGEgTXkgU1FMIGRhdGFiYXNlIGJ1dCB0aGF0IHBhcnQgaXMgZnVuY3Rpb25pbmcgd2VsbCBhbmQgZG9zZW50IG5lZWQgYW55IHdvcmsgdGhhdCBpIGNhbiBzZWUuPGJyIC8+PEJSPmQCCg9kFgRmDxYCHwAFEDxiPkRhdGFiYXNlOjwvYj5kAgEPFgIfAAVMV2lsbCB0aGlzIHByb2plY3QgaW5jbHVkZSBhIGRhdGFiYXNlPzxCUj5ObywgaXQgZG9lcyBub3QgaW5jbHVkZSBhIGRhdGFiYXNlLmQCCw9kFgRmDxYCHwAFIjxiPkJyb3dzZXIgVHlwZShzKS9WZXJzaW9uKHMpOjwvYj5kAgEPFgIfAAWxAVdoaWNoIGJyb3dzZXIvdmVyc2lvbiBjb21iaW5hdGlvbnMgbXVzdCB0aGlzIHdlYnNpdGUgc3VwcG9ydD88QlI+PHVsPjxsaT5JRSA4LjA8L2xpPjxsaT5JRSA3LjA8L2xpPjxsaT5JRSA2LjA8L2xpPjxsaT5GaXJlZm94IDMuNjwvbGk+PGxpPkZpcmVmb3ggMy4wPC9saT48bGk+U2FmYXJpIDQxPC9saT48L3VsPmQCDA9kFgRmDxYCHwAFIjxiPlNlcnZlciBIb3N0aW5nIEVudmlyb25tZW50OjwvYj5kAgEPFgIfAAWIB1doYXQgaXMgeW91ciBzZXJ2ZXIgaG9zdGluZyBlbnZpcm9ubWVudD88QlI+SSBoYXZlIGEgc2VydmVyIGF0IGEgM3JkIHBhcnR5IGhvc3RpbmcgY29tcGFueS48QlI+VGhlIG5hbWUgb2YgdGhlIGhvc3RpbmcgY29tcGFueSBpczogUGFpcjxCUj5UaGUgc2VydmVyJ3Mgc2hhcmVkL2RlZGljYXRlZCBzdGF0dXMgaXM6IFNoYXJlZCB3aXRoIG90aGVyIHBlb3BsZS48QlI+PEJSPkNvbXBvbmVudCBDb21wYXRpYmlsaXR5IFByb3RlY3Rpb246PEJSPlNvbWV0aW1lcyBhIHdvcmtlciBtYXkgY3JlYXRlIGZlYXR1cmVzIG9uIHRoZSB3ZWJzaXRlIHRoYXQgcmVseSBvbiBjb21wb25lbnRzd2hpY2ggd29yayBmaW5lIG9uIHRoZWlyIG93biBzZXJ2ZXIsIGJ1dCB3b24ndCB3b3JrIHdpdGggeW91ciAzcmQgcGFydHkgaG9zdGluZyBjb21wYW55J3Mgc2VydmVyLiBUaGVyZSBhcmUgbWFueSByZWFzb25zIGZvciB0aGlzIGluY2x1ZGluZyB2ZXJzaW9uIGluY29tcGF0aWJpbGl0eSwgcmVzdHJpY3RlZCBwZXJtaXNzaW9ucywgZXRjLi4uIHZXb3JrZXIuY29tIG5vcm1hbGx5IHJlcXVpcmVzIHRoYXQgdGhlIHdvcmtlciB2ZXJpZnkgaW4gYWR2YW5jZSB0aGF0IHlvdXIgM3JkIHBhcnR5IGhvc3RpbmcgcHJvdmlkZXIgd2lsbCBzdXBwb3J0IHRoZSBjb21wb25lbnRzLiZuYnNwOyBJZiB0aGV5IGRvIG5vdCwgdGhlbiB0aGV5IGFyZSByZXNwb25zaWJsZSBmb3IgYW55IGluY29tcGF0aWJpbGl0aWVzLCByYXRoZXIgdGhhbiB5b3UuICBEbyB5b3Ugd2FudCB0aGlzIHByb3RlY3Rpb24gb24geW91ciBwcm9qZWN0PzxCUj5ObywgSSB3aWxsIGJlIHJlc3BvbnNpYmxlIGZvciBhbnkgY29tcG9uZW50cyBvZiB0aGUgZmluYWwgc29sdXRpb24gdGhhdCBkbyBub3Qgd29yayB3aXRoIG15IGhvc3RpbmcgY29tcGFueS5kAg0PZBYEZg8WAh8ABSI8Yj5TZXJ2ZXIgSG9zdGluZyBFbnZpcm9ubWVudDo8L2I+ZAIBDxYCHwAFigFXaWxsIHRoZSB3b3JrZXIgZGV2ZWxvcCAibGl2ZSIgb24geW91ciBzZXJ2ZXI/PEJSPk5vLiAgVGhlIHdvcmtlciBpcyByZXNwb25zaWJsZSBmb3IgY3JlYXRpbmcgdGhlaXIgb3duIGRldmVsb3BtZW50IGFuZC9vciBxYyBlbnZpcm9ubWVudC5kAg4PZBYEZg8WAh8ABR08Yj5QaHlzaWNhbCBpbnN0YWxsYXRpb246PC9iPmQCAQ8WAh8ABYkDV2hvIHdpbGwgcGVyZm9ybSB0aGUgcGh5c2ljYWwgaW5zdGFsbGF0aW9uPzxCUj5JIHdpbGwgcGVyZm9ybSB0aGUgcGh5c2ljYWwgaW5zdGFsbGF0aW9uLiAgVGhlIHdvcmtlciBpcyBvbmx5IHJlc3BvbnNpYmxlIGZvciBwcm92aWRpbmcgaW5zdHJ1Y3Rpb25zIGFuZCBhc3Npc3RhbmNlIHJlZ2FyZGluZyB3aGF0IEkgbXVzdCBkby4gIEkgdW5kZXJzdGFuZCBhbmQgYWdyZWUgdGhhdCBpZiB0aGUgd29ya2VyIHByb3ZpZGVzIGFkZXF1YXRlIGluc3RydWN0aW9ucywgYnV0IEkgYW0gdW5hYmxlIHRvIGZvbGxvdyB0aGVtLCB0aGVuIHRoaXMgaXMgYSB2YWxpZCByZWFzb24gZm9yIHRoZW0gdG8gbWlzcyB0aGUgZmluYWwgZGVhZGxpbmUgd2l0aG91dCBwZW5hbHR5IChpbiBhcmJpdHJhdGlvbikuZAIPD2QWBGYPFgIfAAUNPGI+TGVnYWw6PC9iPmQCAQ8WAh8ABYUEMSkgQWxsIGRlbGl2ZXJhYmxlcyB3aWxsIGJlIGNvbnNpZGVyZWQgIndvcmsgbWFkZSBmb3IgaGlyZSIgdW5kZXIgVS5TLiBDb3B5cmlnaHQgbGF3LiBFbXBsb3llciB3aWxsIHJlY2VpdmUgZXhjbHVzaXZlIGFuZCBjb21wbGV0ZSBjb3B5cmlnaHRzIHRvIGFsbCB3b3JrIHB1cmNoYXNlZC48YnIgLz4NCjFiKSBObyBwYXJ0IG9mIHRoZSBkZWxpdmVyYWJsZSBtYXkgY29udGFpbiBhbnkgPGEgaHJlZj0iL1JlbnRBQ29kZXIvRG90TmV0L1NvZnR3YXJlQ29kZXJzL0ZBUS5hc3B4I2NvcHlyaWdodCIgdGFyZ2V0PSJibGFuayI+Y29weXJpZ2h0IHJlc3RyaWN0ZWQgM3JkIHBhcnR5IGNvbXBvbmVudHM8L2E+IChpbmNsdWRpbmcgR1BMLCBHTlUsIENvcHlsZWZ0LCBldGMuKSB1bmxlc3MgYWxsIGNvcHlyaWdodCByYW1pZmljYXRpb25zIGFyZSBleHBsYWluZWQgQU5EIEFHUkVFRCBUTyBieSB0aGUgZW1wbG95ZXIgb24gdGhlIHNpdGUgcGVyIHRoZSB3b3JrZXIncyBXb3JrZXIgTGVnYWwgQWdyZWVtZW50LjxiciAvPmQCBA9kFgICAQ9kFgJmDw8WAh4HVmlzaWJsZWhkZGSlRqV0MGdmiv6wcL1chYT+Rtz2+g==" />

    <div>
        
<!--4/7/2010 12:14:25 PM:Ran Converter_NameChange v2.0.0.0 and replaced 0 out of 0 items found.-->
<!--4/7/2010 12:12:30 PM:Ran Converter_NameChange v2.0.0.0 and replaced 0 out of 0 items found.-->

<table id="UcBidRequestInterviewDetails1_pnlNormalDetails" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	
    <table id="UcBidRequestInterviewDetails1_tblInterviewResults">
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Project Type:</b></td>
			<td>What kind of work do you need done?<BR>Software related (Includes desktop applications and internet websites)</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Project Parts:</b></td>
			<td>What do you want the worker to do on this project?<BR></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""></td>
			<td><table>
				<tr class="NormalRow_Small">
					<td valign="top" align="right" nowrap="">Requirements:</td>
					<td>The worker will analyze the problem and propose a software-based solution to the problem.</td>
				</tr>
				<tr class="NormalRow_Small">
					<td valign="top" align="right" nowrap="">Programming:</td>
					<td>The worker will take the requirements and translate them into the language of the computer (and test it).</td>
				</tr>
				<tr class="NormalRow_Small">
					<td valign="top" align="right" nowrap="">User installation:</td>
					<td>The installer will move the software from the place it was created (which is called the development or QC environment) to where you will use it (which is called the production environment).  The installer then tests the software to make sure that the installation was done properly and completely.</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Req. Doc. Type:</b></td>
			<td>What kind of documentation do you want for this project?<BR>Informal documentation - As the employer talks back and forth about the project with the worker, those conversations become the requirements.Remember to communicate ALL of the details of your project on the vWorker.com site.  If you don't, and there is a dispute, then important details of the contract will not be documented and cannot be taken into account in arbitration.  If you feel you MUST go offsite (for example, using the phone or IM) then afterwards post everything onsite and get the other party to post that they agree to those contractual terms.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Program Type:</b></td>
			<td>What kind of software should the worker create (and/or install)?<ul><li>An internet web-site: This software runs on a web server and users will access it using their internet browser.</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Internet web-site info</b></td>
			<td></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Design and functionality:</b></td>
			<td>What does the programming of this project involve?<ul><li>Program Functionality: Making the website "work".</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Modeling another site:</b></td>
			<td>Do you wish to model another site? No</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Size of website:</b></td>
			<td>How many pages need to be created/edited in this website?<BR>Exactly 4.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Programming Language:</b></td>
			<td>What programming language(s) do you want your website written in?<BR>I do know the language(s).<BR>Languages(s):<BR><ul><li>Javascript</li><li>PHP</li></ul>Misc. details: It dose connect to a My SQL database but that part is functioning well and dosent need any work that i can see.<br /><BR></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Database:</b></td>
			<td>Will this project include a database?<BR>No, it does not include a database.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Browser Type(s)/Version(s):</b></td>
			<td>Which browser/version combinations must this website support?<BR><ul><li>IE 8.0</li><li>IE 7.0</li><li>IE 6.0</li><li>Firefox 3.6</li><li>Firefox 3.0</li><li>Safari 41</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Server Hosting Environment:</b></td>
			<td>What is your server hosting environment?<BR>I have a server at a 3rd party hosting company.<BR>The name of the hosting company is: Pair<BR>The server's shared/dedicated status is: Shared with other people.<BR><BR>Component Compatibility Protection:<BR>Sometimes a worker may create features on the website that rely on componentswhich work fine on their own server, but won't work with your 3rd party hosting company's server. There are many reasons for this including version incompatibility, restricted permissions, etc... vWorker.com normally requires that the worker verify in advance that your 3rd party hosting provider will support the components.&nbsp; If they do not, then they are responsible for any incompatibilities, rather than you.  Do you want this protection on your project?<BR>No, I will be responsible for any components of the final solution that do not work with my hosting company.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Server Hosting Environment:</b></td>
			<td>Will the worker develop "live" on your server?<BR>No.  The worker is responsible for creating their own development and/or qc environment.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Physical installation:</b></td>
			<td>Who will perform the physical installation?<BR>I will perform the physical installation.  The worker is only responsible for providing instructions and assistance regarding what I must do.  I understand and agree that if the worker provides adequate instructions, but I am unable to follow them, then this is a valid reason for them to miss the final deadline without penalty (in arbitration).</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Legal:</b></td>
			<td>1) All deliverables will be considered "work made for hire" under U.S. Copyright law. Employer will receive exclusive and complete copyrights to all work purchased.<br />
1b) No part of the deliverable may contain any <a href="/RentACoder/DotNet/SoftwareCoders/FAQ.aspx#copyright" target="blank">copyright restricted 3rd party components</a> (including GPL, GNU, Copyleft, etc.) unless all copyright ramifications are explained AND AGREED TO by the employer on the site per the worker's Worker Legal Agreement.<br /></td>
		</tr>
	</table>
	

</td></tr></table>




    </div>
    </form>
</body>
</html>
<img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_connection.png" width="16" height="16" />
												<font size="2"><b>
												Other Requirements:</b><br>
												
												<div id="divDeliverables"></div></font><font size=1><ul>
								    
										        <li>Remember that contacting the other party outside of the site (by email, phone, etc.) on all business projects < $500 (before the employer's money is escrowed) is a <a href="/RentACoder/misc/Legal.asp">violation</a> of both the <a href="/RentACoder/SoftwareBuyers/SoftwareBuyerLegal.asp#OutContact">employer</a> and <a href="/RentACoder/SoftwareCoders/SoftwareSellerLegal.asp#OutContact">worker</a> agreements.
vWorker.com monitors all site activity for such violations and can instantly expel transgressors on the spot, so we thank you in advance for your cooperation.  
If you notice a violation please <a href="/RentACoder/misc/Feedback.asp?lngBidRequestId=1533278&intTypeOfInquiry=6">help out the site and report it</a>. Thanks for your help.
										        </li>
									        </ul></font><b><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_info.png" width="16" height="16" />
										<font size=2>
										Categories:</b></b><br>
										</font>
										 <div class="FontSize1">
										 <ul>
										    <li>
										        The categories were created by the employer, but sometimes mistakes occur.  
										        If any of these categories are incorrect, please 
										        <a href="/RentACoder/misc/Feedback.asp?intTypeOfInquiry=2&txtBody=I%27m+reporting+that+the+employer+accidentally+placed+the+following+incorrect+category%28ies%29+on+this+posting%3A&lngBidRequestId=1533278">report it and let us know</a>.
										    </li>
										    <li>
										        Like everything else on this page, these categories are part of the original contract 
										        for this project.  
										    </li>
										 </ul>
										 <font size=2>
										 <font size="2">
										 </font>Web development, User interface (UI) design, Languages, Requirements, PHP, Other (Technology), Web services, Javascript, Technology, Web programming, Other (web programming)<BR>
										 <BR></font>
							</td>
						</tr>
						
						
					</table>
					
				
			</td>
		</tr>
		

			
	<tr>
		<td><center><font size=3><hr><table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td valign=top>
						    
						    <a style="text-decoration:none;" name="Messagessummary">&nbsp;</a>
						    <img   border="0" src="/images/IconExperience/ApplicationBasics/48x48/shadow/document_pinned.png" width="48" height="48" />
						
						</td>
						<td valign=top><center>
							<b>Messages summary</b><table  cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td><font size=1>(</font></td>
									<td><font size=1><a href="#AllTabs">Back to shortcuts</a></font></td>
									
									<td><font size=1>)</font></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<center>
	<table ID="Table1">
	<tr>
		<td><center><font size="1">All monetary amounts on the site are in United States dollars.<br>
		vWorker.com is a closed auction, so workers can only see their own bids and comments.  Employers can view every posting made on their projects.</font></td>
	<tr>
		<td>
			<center>
			<font size="1"><br>
			
			<table border="0" ID="Table2" cellpadding=1 cellspacing=1>
				
				
								<tr>
									<td valign="top" width="19">
										<img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/alarmclock.png" width="16" height="16" />
									</td>
									<td valign="top"><font size="2">
										<b>Bidding Closes At:</b>
									</td>
									<td valign="top"><font size="2">
										Nov 18, 2010 6:56:12 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a><br>
									</td>
								</tr>
								
				
					<tr>
						<td valign="top" width="19">
							&nbsp;
						</td>
						
						<td nowrap valign="top"><font size="2">
							<b>Max accepted bid:</b><img src="/RentACoder/images/icons/BlankIcon.gif" width=19 height=18>
						</td>
						<td valign="top"><font size="2">
							Open to fair suggestions<img src="/RentACoder/images/icons/BlankIcon.gif" width=19 height=18>
						</td>
					</tr>	
									
			</table>
			
				<font size="2">
				
							No bids have been posted yet.
							  <a href="/RentACoder/DotNet/SoftwareCoders/FAQ.aspx?intTabSelectedId=2#ClosedBidding">Why can't I view bids from 
                other workers who are bidding against me?</a>
					<hr width="80%">
					Bidding/comment cannot be viewed until you are logged in.<br>
						<br>
						</td></tr></table>	
	<tr>
		<td><center><font size=3><hr><table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td valign=top>
						    
						    <a style="text-decoration:none;" name="Postfirstreply">&nbsp;</a>
						    <img   border="0" src="/images/IconExperience/NetworkAndSecurity/48x48/shadow/mail_forward.png" width="48" height="48" />
						
						</td>
						<td valign=top><center>
							<b>Post first reply</b><table  cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td><font size=1>(</font></td>
									<td><font size=1><a href="#AllTabs">Back to shortcuts</a></font></td>
									
									<td><font size=1>)</font></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<center><center><font size="2">
		Workers: To place a bid and/or to see any of your own pre-existing bids on this project, you must
		<a href="/RentACoder/authentication/Login.asp?txtReturnURL=%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278">
		login</a>.<br>
		<br>

		<font size="2">Employers: If this is your project, then you can 
		see all bids/comments, and/or accept one, by <a href="/RentACoder/authentication/Login.asp?txtReturnURL=%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1533278">logging in</a>.</font>
		</center>
				</center>
		</td>
	</tr>
	
		<tr>
			<td>&nbsp;</td>
		</tr>
		
	<tr>
		<td><center><font size=3><hr><table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td valign=top>
						    
						    <a style="text-decoration:none;" name="Ratings">&nbsp;</a>
						    <img   border="0" src="/images/IconExperience/ApplicationBasics/48x48/shadow/document_chart.png" width="48" height="48" />
						
						</td>
						<td valign=top><center>
							<b>Ratings</b><table  cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td><font size=1>(</font></td>
									<td><font size=1><a href="#AllTabs">Back to shortcuts</a></font></td>
									
									<td><font size=1>)</font></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<center><br>
		<table ID="Table2">
			<tr>
				<td colspan="3">
					
		<table ID="Table15">
			<tr>
				<td colspan=4><center><font size="1">This project has no ratings yet</td>
			</tr>
		</table>
		
				</td>
				</tr>
			</tr>
		</table>
				</center>
		</td>
	</tr>
	
		<tr>
			<td>&nbsp;</td>
		</tr>
	
	</table> 


<table><tr><td valign=topwidth=336 height=280 bgcolor="white"><SCRIPT LANGUAGE="JAVASCRIPT">
<!--First Impression Ad Code, Copyright 2000, Exhedra Solutions, Inc.  Please do not modify. //-->
</SCRIPT>
<SCRIPT language="JavaScript" src="http://ads2.exhedra.com/ads/ShowAd.Asp?lngSlotId=15&lngWId=-10&blnSupressOutput=False&strBgColor=white&vstrUniquePageId=&blnJScriptInclude=True" ></SCRIPT>
</td></tr></table>    	    
                        </td></tr></table> <!-- / Protective table -->            
                    </div></div> <!-- / #content -->      
                <hr />
            
<div class="sidebar">

            

    <div class="box box-search"><div class="box-inner">

          
        <div class="head">
            <h5><strong>Search</strong></h5>
        </div> <!-- / .head -->


                
            <div class="contents">

                    <form method="post" id="form1" name="form1" style="margin-bottom:0px" action="/RentACoder/misc/BidRequests/ShowBidRequests.asp?lngBidRequestListType=4&optSortTitle=2&cmSearch=Search&txtMaxNumberOfEntriesPerPage=10&lngSortColumn=-6&blnModeVerbose=True&optBiddingExpiration=1"> 


                  <fieldset>                    
                    <label class="hide">Search</label>
                    <input type="text" name="txtCriteria" id="txtCriteria" Class="SearchTextBox" />
                    <input type="submit" name="B3" id="btnFind" value="Find" Class="fancybutton SearchFind" />
                  </fieldset>
                    
                    </form>                        




            <ul>
                <li>
                   <a href="/RentACoder/SoftwareCoders/SearchWork.asp">Advanced Search</a>

                </li>
                <li><a href="/RentACoder/misc/BidRequests/ShowBidRequests.asp?lngBidRequestListType=3&optSortTitle=2&lngBidRequestCategoryId=-1&txtMaxNumberOfEntriesPerPage=10&optBidRequestPhase=2&lngSortColumn=-6&blnModeVerbose=True&optBiddingExpiration=1">Newest 
                    projects</a></li>
                <li><a href="/RentACoder/DotNet/misc/News.aspx">Latest news</a></li>
            </ul>

            </div> <!-- / .contents -->

            
      
    </div></div> <!-- / .box -->


   




    <div class="box box-highestranked"><div class="box-inner">
      
    
        <div class="head">
            <h5><strong>'All Workers' Competition.</strong></h5> 
        </div> <!-- / .head -->            
            
        <div class="contents">            
            <div class="TopWorker">
            <ol>
            <img   border="0" src="/images/IconExperience/ApplicationBasics/32x32/shadow/star_blue.png" width="32" height="32" /><a href="/RentACoder/dotnet/docs/AllCodersExplanation.aspx" >What is this list?</a><BR><ol><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1033162">cricava</a><br>
10 avg. over 
382 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=213452">Gravity Jack, Inc.</a><br>
9.8 avg. over 
61 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1151754">Lisa_G</a><br>
9.9 avg. over 
1882 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1524214">calciustec h</a><br>
9.82 avg. over 
1600 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1128689">Pop Mihai Sergiu</a><br>
10 avg. over 
165 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1774642">DX Silverligh t Team</a><br>
9.8 avg. over 
331 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=391882">PSergei</a><br>
9.87 avg. over 
481 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=896918">Dali Studio</a><br>
9.83 avg. over 
181 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=6281468">Ing. Gervasio Marchand Cassataro</a><br>
10 avg. over 
194 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=6410606">CodeAndMor e</a><br>
9.95 avg. over 
525 jobs.
</li></ol><center><font size="1">
<BR>
<a href="/RentACoder/misc/AllCoderCompleteList.asp">...See ALL workers by ranking</a><BR>

            </ol>
            </div>
        </div> <!-- / .contents -->      
    </div></div> <!-- / .box -->
    

    <div class="box box-bidrequests"><div class="box-inner">
      
        <div class="head">
            <h5><strong>Newest 
            projects.</strong></h5>
            <a class="more" href="/RentACoder/misc/BidRequests/ShowBidRequests.asp?lngBidRequestListType=3&optSortTitle=2&lngBidRequestCategoryId=-1&txtMaxNumberOfEntriesPerPage=10&optBidRequestPhase=2&lngSortColumn=-6&blnModeVerbose=True&optBiddingExpiration=1">See ALL...</a>
        </div> <!-- / .head -->
  
        <div class="contents">
        <div class="marquee-wrapper">
                <div class="marquee-topmask"></div>
                <div class="marquee-botmask"></div>
              
                <div class="marquee-postings">
                    <marquee behavior="scroll" direction="up" scrollamount="1" height="200" width="156"
                        onmouseover="this.stop();" onmouseout="this.start();"> <!-- not used speed="1" scrolldelay="240"-->
                        
                        <div class="newsticker">
                        
                        <a name=NewestBidRequests></a><ul><li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533281" target="_top">Custom Header</a></h6>

<p>By airpr23 on November 4 6:27:52 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533279" target="_top">Android Application 1104</a></h6>

<p>By softbuy143 on November 4 6:24:28 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533276" target="_top">Move Some of My iPhone Apps to Mac Apps for the Ma ...</a></h6>

<p>By **Alundus** on November 4 6:18:28 PM</p>
<p>Max Bid: $150.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533266" target="_top">Flash file - edit images</a></h6>

<p>By CJA on November 4 6:03:04 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533274" target="_top">need translation to russian</a></h6>

<p>By coolcodernyc on November 4 6:16:52 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533260" target="_top">Online Web Form</a></h6>

<p>By jcinfargo on November 4 5:56:47 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533115" target="_top">Wordpress Blog Postings</a></h6>

<p>By projectmanager1 0 on November 4 2:48:14 PM</p>
<p>Max Bid: $5.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533257" target="_top">Web DB Data Extraction</a></h6>

<p>By NeedYourInput on November 4 5:50:41 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533252" target="_top">Interspire Shopping Cart Expert/Develope r</a></h6>

<p>By Onlinewebpublis her on November 4 5:38:01 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533243" target="_top">oscmax v2 Need customers total spend to date displ ...</a></h6>

<p>By Magilla on November 4 5:29:49 PM</p>
<p>Max Bid: $25.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533239" target="_top">Web based 1 form DB query,Post to database</a></h6>

<p>By relierma on November 4 5:25:31 PM</p>
<p>Max Bid: $100.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533238" target="_top">Web Application for manage Football teams, matches ...</a></h6>

<p>By il_dandi on November 4 5:24:43 PM</p>
<p>Max Bid: $280.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533231" target="_top">Manual unpacking of packed binary</a></h6>

<p>By gems7 on November 4 5:19:44 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533223" target="_top">Simple Checkin Checkout systeem</a></h6>

<p>By Ate on November 4 5:11:00 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1533222" target="_top">Simpel Webshop - KrD</a></h6>

<p>By Ate on November 4 5:08:51 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
</ul>
                        
                        </div> <!-- / .newsticker -->
                        
                    </marquee>
                </div> <!-- / .marquee-postings -->
                
                
                
                
            </div> <!-- / .marquee-wrapper -->
    		 
    		 <center>
  		    <p>Click here to put this ticker <a href="/RentACoder/misc/LinkToUs/FreeDynamicContent.asp?blnHideChannelSubscribe=true&blnLaunchLinkInNewWindow=true#ScrollingCodeTicker"
  		    >on your own site</a> and/or get <a href="/RentACoder/misc/LinkToUs/FreeDynamicContent.asp?blnHideChannelSubscribe=true&blnLaunchLinkInNewWindow=true#NewsFeeds">live RSS newsfeeds</a>.</p>
                  </center>   



        </div> <!-- / .contents -->
      
    </div></div> <!-- / .box -->

</div> <!-- / #sidebar -->

    

                </div> <!-- / #wrapper -->	
            </div> <!-- / .container -->	
        </div> <!-- / #page -->
        
      
    
            <hr />
            <div class="footer">              
                <div class="container">                
                    <div class="nav">
                      <ul>
                        <li class="first-child"><a href="/RentACoder/DotNet/misc/News.aspx">Latest News</a>
                          </li>
                        <li><a href="/RentACoder/DotNet/misc/About/default.aspx">About Us</a></li>
                        <li><a href="/RentACoder/DotNet/SoftwareBuyers/BuyerKudos.aspx">Kudos</a></li>
                        <li><a href="/RentACoder/misc/Feedback.asp">Feedback/Contact</a></li>
                        <li><a href="/RentACoder/DotNet/Affiliates/Help.aspx">Affiliates</a></li>
                        <li><a href="/RentACoder/misc/Legal.asp">Legal</a></li>
                        <li><a target="_blank" href="http://blog.vWorker.com/">Blog</a></li>
                      </ul>
                    </div> <!-- / .nav -->
                
                    <div class="copyright">Copyright © 2001-2010 <a target=_blank href="http://www.exhedra.com"> Exhedra Solutions, Inc.</a> All rights reserved. <!br>
By using this site you agree to its <a href="/RentACoder/misc/TermsAndConditions.asp">Terms and Conditions</a>.<!br> 
<a target=_blank href="/RentACoder/DotNet/Default.aspx">vWorker.com</a>™,  &quot;<a href="/RentACoder/DotNet/Docs/SGD.aspx">Expert Guarantee</a>&quot;™  <a href="/RentACoder/DotNet/misc/TimeCard/DesktopApp/Overview.aspx">AccuTimeCard™</a> and &quot;More capable, accountable and affordable. Guaranteed.&quot;™<!BR> are trademarks of <a target=_blank href="http://www.exhedra.com"> Exhedra Solutions, Inc.</a>.  Page generated by IISPROD11 at 11/4/2010 7:02:56 PM<BR><BR>Selected vWorker specialties: <a class="black" href="/website_designers.aspx">website designers</a>, <a class="black" href="/web_design_company.aspx">website design company</a>, <a class="black" href="/web_design_services.aspx">web design services</a>.</div>
        		
                </div> <!-- / container -->	
            
                

            </div> <!-- / footer -->

        
<!--Google analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1238797-1']);
  _gaq.push(['_setDomainName', '.vworker.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!--Performable tracking code-->
<!-- Performable Code for Tracking Page Views and Visitors --> 
<script type="text/javascript"> 
  var _paq = _paq || []; 
  _paq.push(["setAccount", "585JVw"]); 
  _paq.push(["trackPageView"]); 
  (function() { 
    var pa = document.createElement('script'); pa.type = 
'text/javascript'; pa.async = true; 
    pa.src = '//analytics.performable.com/pax.js'; 
    var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(pa, s); 
  })(); 
</script>


    </div> <!-- / background-->

</body>
</html>

