
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" 
>
<head>

    

    <title>vWorker.com - Extract company info from yellow page and google sites</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    
        
      <meta HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" media="print" 
        href="/RentACoder/DotNet/2010Redesign/stylesheets/print.css"/>
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="screen" href="/RentACoder/DotNet/2010Redesign/stylesheets/ie.css"/><![endif]-->

    <style type="text/css">
    </style>
    
    <LINK REL="shortcut icon" href="/images/IconExperience/ObjectsAndPeople/ico-files/user1_monitor.ico">
<meta name="description" content="<p><span>1.<span style=&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;&quot;>       </span></span>Software will extract email address of company and will past at column.</p>
<p><span>2.<span style=&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;&quot;>       </span></span>Then it will access the website and will extract the email with filtration i.e. hr, CV, job, join, contact and will past at column</p>
<p><span>3.<span style=&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;&quot;>       </span></span><span>If hr, CV, job join, contact email are not find then copy the domain of company e.g. abc.com and will search at Google like job @abc.com in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. If hr, CV, job, join, Contact email cannot find then search like CV @abc.com and in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. Repeat this step till we find one email hr, CV, job, join. If software cannot find the email then it can automatically generate the email with hr, CV, job, join, Contact.  And paste it at columns with notification &lsquo;email not test&rsquo;  </span></p>
<p><span>4.<span style=&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;&quot;>       </span></span>It can also extract the Company name, location, category</p>
<p><span>5.<span style=&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;&quot;>       </span></span>Some company URL are not mentioned at yellow page</p>">
<meta name="keywords" content="web, development, software, networking, information systems, electronics, creative arts, writing, translations, design arts, multimedia, administrative support,business services, customer service, sales and marketing, advertising, legal, paralegal">
<meta name="title" content="vWorker.com - Extract company info from yellow page and google sites">
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
<script src="/RentACoder/DotNet/2010Redesign/javascripts/jquery.marquee.js" type="text/javascript"></script>
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
                <a href="/RentACoder/authentication/Login.asp?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633" style="text-decoration: underline"
                    >Sign In</a> | <a href="https://www.vWorker.com/Ads/authentication/GetUserId.asp?lngWId=1&txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633" style="text-decoration: underline"
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
                href="/RentACoder/Affiliates/Help.asp?intTabSelectedId=3">Affiliates</a></li>
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
                        
                                <li><a href="/RentACoder/authentication/Login.asp?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633">Sign in</a></li>
                        
                            <li class="dropdown">
                                
                                <a href="#"><img  align="AbsMiddle"   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/folder_into.png" width="16" height="16" /> Site layout...</a>
                                <span class="dropdown-tip"></span>
                                <ul>

                                    <li>
                                        
                                        <a href="/RentACoder/DotNet/2010Redesign/MoveMenu.aspx?txtReturnURL=http%3A%2F%2Fwww%2Evworker%2Ecom%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633&intTabSelectedId=1"
                                        ><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/selection_replace.png" width="16" height="16" /> Move menu</a></li>
                                    <li>
                                        
                                        <a target="_blank" href="http://www.vworker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498633&blnShowWideScreen=true&intTabSelectedId=1"
                                        ><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/selection_replace.png" width="16" height="16" /> Wide-screen page</a></li>                                
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                        <li>
                            
                            <a href="/RentACoder/DotNet/misc/Tools.aspx?intTabSelectedId=1#For_Buyers"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/objects_people_industries/16x16/plain/toolbox.png" width="16" height="16" /> Tools</a></li>
                        <li>
                            
                            <a href="/RentACoder/SoftwareBuyers/Articles/default.asp?intTabSelectedId=1"><img  align="AbsMiddle"   border="0" src="/images/IconExperience2008/v_collections_png/business_finance_data/16x16/plain/briefcase_document.png" width="16" height="16" /> Articles</a></li>
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
      $.get('/RentACoder/DotNet/misc/HideBroadcastMessage.aspx?txtForceRefresh=91520101536175270', function(data) {
           $('#idBroadcastMessage_Top').hide();
           });
    }
</script>
<div id="idBroadcastMessage_Top"><table width=100% class="BroadCastMessageBackground NormalText8pt"><tr><td><b>Site Wide Message:</b>&nbsp;Posted Sep 13, 2010 5:34:55 PM <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>.</td><td align="right"><a href="#" onclick="HideBroadcastMessage();return false;"><img alt="Dismiss" class="BroadCastMessage_DismissImage" width="16" height="16" src="/images/IconExperience2008/v_collections_png/basic_foundation/16x16/plain/navigate_cross.png"  /></a><a href="#" onclick="HideBroadcastMessage();return false;">Dismiss this message</a></td></tr><tr><td colspan="2"><div class="BroadCastMessage_Inner"><!--start msg--><table ID="Table2">
					<tr>
						
						<td  valign=top><font face=verdana color="black" size=1>A big thank you to all site users for helping us win the <a href="http://blog.vworker.com/2010/08/vworker-is-in-2010-inc-5000.html" target="_blank">2010 Inc 5000 award for fastest growing private company</a>, for the fourth year in a row!  You've also helped us show up <a href="http://blog.vworker.com/2010/09/vworker-in-news.html" target="_blank">all over the news</a>. Thanks!</i></font></td>
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
    
    
//var strUniqueId = 96982010915153617; 


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
        <a href="javascript:ShowPopupWindowXYWithScrollbars('/RentACoder/dotnet/Docs/FindersFeeComissionSchedule.aspx',600,650)"><img   border="0" src="/images/IconExperience2008/v_collections_png/computer_network_security/128x128/plain/earth.png" width="128" height="128" /></a>
	</td><td valign="top" class="FontSize2">
	    	    <table width="100%" bgcolor="black">
					<tr>
						<td width="*"><center><font color="white">
						    
							<h1>Extract company info from yellow page and google sites<br>
							<font size="1">Project Id: 1498633</font><br>
							</b>
						</td>
						<td width="187" bgcolor="white">
						    

                            <script type="text/javascript" 
                            src="http://s7.addthis.com/js/250/addthis_widget.js#username=IanIppolito">
                            </script>
                            
							<table width="187">
							    <tr>
							        <td>
							             <img src="/vb/images/new.gif" border="0"/>
							        </td>
							        <td>
							           
							            
			        



    <a href="http://www.addthis.com/bookmark.php"     
        class="addthis_button"    
            addthis:url="http://www.vworker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498633"      
            addthis:title="Extract company info from yellow page and google sites"      
            addthis:description="<p><span>1.<span style=\&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;\&quot;>\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp; </span></span>Software will extract email address of company and will past at column.</p>\r\n<p><span>2.<span style=\&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;\&quot;>\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp; </span></span>Then it will access the website and will extract the email with filtration i.e. hr, CV, job, join, contact and will past at column</p>\r\n<p><span>3.<span style=\&quot;font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;\&quot;>\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp;\&nbsp; </span></span><span>If hr, CV, job join, contact email are not find then copy the domain of company e.g. abc.com and will search at Google like job @abc.com in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. If hr, CV, job, join, Contact email cannot find then search " 
        style="text-decoration:none;">
    </a>
							        </td>
							    </tr>
					    
								<tr>
									<td width="19" valign="top">
									    <a href="/RentACoder/misc/AddToDoListItem.asp?lngBidRequestId=1498633">
										<img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/book_blue_preferences.png" width="16" height="16" /></a>
									</td>
									<td valign="top" width="*" bgcolor="white" class="FontSize1">
										Bookmark in 
										<a href="/RentACoder/misc/AddToDoListItem.asp?lngBidRequestId=1498633">my 
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
									    
										 <a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=909851">ISolutionInc</a> <font size="1"><a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=909851#BuyerRating">(10 ratings)</font></a><br>
										<font size="1">(Employer rating 10<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/RatingLegend.aspx')"><img border=0 height=18 width=19 src="/RentACoder/images/icons/Rating4.gif"></a>)<br>
										
									</td>
								</tr>
								

									
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Non-action Ratio:<!/a></b></td>
									<td valign="top"><font size="1">
										<a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=909851#NonActionRatio">Very Good<!/a> - 21.21%</a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Employer Security Verifications:</b></td>
									<td valign="top"><font size="1">
										<a href="/RentACoder/DotNet/SoftwareBuyers/ShowBuyerInfo.aspx?lngAuthorId=909851#SecurityVerifications"><img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/user1_telephone.png" width="16" height="16" /><img   border="0" src="/images/IconExperience/ObjectsAndPeople/16x16/shadow/user1_preferences.png" width="16" height="16" />Excellent</a>
									</td>
								</tr>


								

								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Approved on:</b></td>
									<td valign="top"><font size="1">
										Sep 15, 2010<BR>3:31:37 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>
									</td>
								</tr>
							
								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Bidding Closes:</b></td>
									<td valign="top"><font size="1">
										 Sep 29, 2010<BR>3:30:50 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Viewed (by workers):</b></td>
									<td valign="top"><font size="1">
										 10 times
										</font>
									</td>
								</tr>

								
								
										        <tr>
											        <td valign="top" align="right"><font size="1">
												        <b>Deadline:</b></td>
											        <td valign="top"><font size="1">7 <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/dotnet/docs/DeadlineExplanation.aspx')">days</a>.
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
                                    <td><font size="1">Pay-for-Deliverables</font></td>
                                </tr>
								
									<tr>
										<td valign="top" align="right"><font size="1">
											<b>Max Accepted Bid:</b></td>
											
												<td valign="top"><font size="1">
													$150.00&nbsp;(<a href="javascript:ShowPopupWindowXYWithScrollbars('http://www.vWorker.com/RentACoder/misc/CurrencyConverter.asp?txtAmount=150',500,500)">USD<img   border="0" src="/images/IconExperience/@Custom/16x16/shadow/CurrencyConversion.png" width="16" height="16" /></a>)
														
												</font></td>
												
									</tr>
									
								
								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Project Type:</b></td>
									<td valign="top"><font size="1">
										 <a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/ProjectTypeLegend.aspx')">
										 Small Business Project: $100(USD) and above
										 </a>
									</td>
								</tr>

								<tr>
									<td valign="top" align="right"><font size="1">
										<b>Bidding Type:</b></td>
									<td valign="top"><font size="1"> 
										 <a href="javascript:ShowPopupWindowXYWithScrollbars('/RentACoder/dotnet/Docs/FindersFeeComissionSchedule.aspx',600,650)"><img   border="0" src="/images/IconExperience2008/v_collections_png/computer_network_security/16x16/plain/earth.png" width="16" height="16" /></a>
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
							                All
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
								<font color="#757575"><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/history2.png" width="16" height="16" />Status reports</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/chest_into.png" width="16" height="16" />Escrow Log</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/money_envelope.png" width="16" height="16" />Work acceptance</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/briefcase.png" width="16" height="16" />Assembla Tools</font><BR><font color="#757575"><img   border="0" src="/images/IconExperience/BusinessAndData/16x16/shadow/auction_hammer.png" width="16" height="16" />Mediation / Arbitration</font><BR>
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
														
														<table>
															<tr>
																<td valign=top>
																	<a href="/RentACoder/chat/default.asp?lngBidRequestId=1498633" target="_new"><img   border="0" src="/images/IconExperience/BusinessAndData/48x48/shadow/messages.png" width="48" height="48" /></a>
																</td>
																<td valign=top><font size="2">
																	<a href="/RentACoder/chat/default.asp?lngBidRequestId=1498633" target="_new">Enter chat room</a> for this project<br>
																<font size="1">(0 active users at Sep 15, 2010 3:36:17 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a>)</font>
																</td>
															</tr>
														</table>
														
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
									<div class="KonaBody"><p><span>1.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Software will extract email address of company and will past at column.</p>
<p><span>2.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Then it will access the website and will extract the email with filtration i.e. hr, CV, job, join, contact and will past at column</p>
<p><span>3.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span><span>If hr, CV, job join, contact email are not find then copy the domain of company e.g. abc.com and will search at Google like job @abc.com in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. If hr, CV, job, join, Contact email cannot find then search like CV @abc.com and in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. Repeat this step till we find one email hr, CV, job, join. If software cannot find the email then it can automatically generate the email with hr, CV, job, join, Contact.  And paste it at columns with notification &lsquo;email not test&rsquo;  </span></p>
<p><span>4.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>It can also extract the Company name, location, category</p>
<p><span>5.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Some company URL are not mentioned at yellow page</p></span><br></font>
									<br>


									<font size=2><b><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_info.png" width="16" height="16" />
                                    Requirements Interview Answers: <img src="/vb/images/new.gif"></b></font><BR />
                                    <font size=1>
                                    
                                    To help you bid more accurately, the employer was interviewed about the requirements for this project.  Below are their answers.
                                    </font>
                                    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head><title>
	Untitled Page
</title></head>
<body>
    <form name="form1" method="post" action="WizardOutput.aspx?lngBidRequestId=1498633" id="form1">
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUJMzQzMDUwMzIxD2QWAgIDD2QWAgIBD2QWBAICD2QWAgIBD2QWFmYPZBYEZg8WAh4JaW5uZXJodG1sBRQ8Yj5Qcm9qZWN0IFR5cGU6PC9iPmQCAQ8WAh8ABW1XaGF0IGtpbmQgb2Ygd29yayBkbyB5b3UgbmVlZCBkb25lPzxCUj5Tb2Z0d2FyZSByZWxhdGVkIChJbmNsdWRlcyBkZXNrdG9wIGFwcGxpY2F0aW9ucyBhbmQgaW50ZXJuZXQgd2Vic2l0ZXMpZAIBD2QWBGYPFgIfAAUVPGI+UHJvamVjdCBQYXJ0czo8L2I+ZAIBDxYCHwAFNldoYXQgZG8geW91IHdhbnQgdGhlIHdvcmtlciB0byBkbyBvbiB0aGlzIHByb2plY3Q/PEJSPmQCAw9kFgRmDxYCHwAFFjxiPlJlcS4gRG9jLiBUeXBlOjwvYj5kAgEPFgIfAAXfBFdoYXQga2luZCBvZiBkb2N1bWVudGF0aW9uIGRvIHlvdSB3YW50IGZvciB0aGlzIHByb2plY3Q/PEJSPkZvcm1hbCBkb2N1bWVudGF0aW9uIC0gQWZ0ZXIgdGFsa2luZyBiYWNrIGFuZCBmb3J0aCwgdGhlIHdvcmtlciBjcmVhdGVzIGEgZm9ybWFsIGRvY3VtZW50IGFuZC9vciBwcm90b3R5cGUsIGFzIGZvbGxvd3M6PHVsPjxsaT5Qcm90b3R5cGU6IFRoZSBhbmFseXN0IHdpbGwgY3JlYXRlIGEgbm9uLXdvcmtpbmcgbW9ja3VwIG9mIGFsbCBwYWdlcy9zY3JlZW5zIGluIHRoZSBmaW5hbCBzb2Z0d2FyZS4gIENyZWF0aW5nIGEgcHJvdG90eXBlIG1ha2VzIGl0IGVhc2llciBmb3IgdGhlIHVzZXIgdG8gdmlzdWFsaXplIHRoZSBmaW5hbCBzb2Z0d2FyZSwgYW5kIHJlZHVjZXMgbWlzdW5kZXJzdGFuZGluZ3MuPC9saT48bGk+UmVxdWlyZW1lbnRzIERvY3VtZW50OiBUaGUgYW5hbHlzdCB3aWxsIGNyZWF0ZSBhIGRvY3VtZW50IGRlc2NyaWJpbmcgZXZlcnl0aGluZyB0aGUgZmluYWwgc29mdHdhcmUgd2lsbCBkbyAob3RoZXIgdGhhbiB3aGF0IGlzIGRvY3VtZW50ZWQgaW4gdGhlIHByb3RvdHlwZS4uLmlmIHRoZSBlbXBsb3llciByZXF1aXJlZCBvbmUpLjwvbGk+PC91bD5kAgQPZBYEZg8WAh8ABRQ8Yj5Qcm9ncmFtIFR5cGU6PC9iPmQCAQ8WAh8ABbEBV2hhdCBraW5kIG9mIHNvZnR3YXJlIHNob3VsZCB0aGUgd29ya2VyIGNyZWF0ZSAoYW5kL29yIGluc3RhbGwpPzx1bD48bGk+QSBkZXNrdG9wIG9yIHNlcnZlciBwcm9ncmFtOiBUaGlzIHNvZnR3YXJlIHJ1bnMgb24gYSB1c2VyJ3Mgb3duIFBDL3dvcmtzdGF0aW9uLCBvciBvbiBhIHNlcnZlci48L2xpPjwvdWw+ZAIFD2QWAmYPFgIfAAUkPGI+RGVza3RvcCAvIHNlcnZlciBwcm9ncmFtIGluZm88L2I+ZAIGD2QWBGYPFgIfAAUbPGI+U2l6ZSBvZiBhcHBsaWNhdGlvbjo8L2I+ZAIBDxYCHwAFbkhvdyBtYW55IHNjcmVlbnMvZm9ybXMgbmVlZCB0byBiZSBjcmVhdGVkL2VkaXRlZCBpbiB0aGlzIGFwcGxpY2F0aW9uPzxCUj5JIGRvbid0IGtub3cuIDxCUj5PdGhlciBpbmZvOk5vdCBzdXJlZAIHD2QWBGYPFgIfAAUcPGI+UHJvZ3JhbW1pbmcgTGFuZ3VhZ2U6PC9iPmQCAQ8WAh8ABYwBV2hhdCBwcm9ncmFtbWluZyBsYW5ndWFnZShzKSBkbyB5b3Ugd2FudCB5b3VyIGFwcGxpY2F0aW9uIHdyaXR0ZW4gaW4/PEJSPkkgZG8ga25vdyB0aGUgbGFuZ3VhZ2UocykuPEJSPkxhbmd1YWdlcyhzKTo8QlI+PHVsPjxsaT5DIzwvbGk+PC91bD5kAggPZBYEZg8WAh8ABRo8Yj5PcGVyYXRpbmcgc3lzdGVtKHMpPC9iPmQCAQ8WAh8ABbEBV2hhdCBvcGVyYXRpbmcgc3lzdGVtcyhzKSBkbyB5b3Ugd2FudCB5b3VyIGFwcGxpY2F0aW9uIHRvIHdvcmsgb24/PEJSPkkgZG8ga25vdyB0aGUgb3BlcmF0aW5nIHN5c3RlbShzKTo8QlI+PGxpPk1pY3Jvc29mdCBXaW5kb3dzIC0tIHZlcnNpb24ocyk6IFhQLCBWaXN0YSBXaW5kb3dzIDIwMDc8L2xpPjwvdWw+ZAIJD2QWBGYPFgIfAAUQPGI+RGF0YWJhc2U6PC9iPmQCAQ8WAh8ABYkBV2lsbCB0aGlzIHByb2plY3QgaW5jbHVkZSBhIGRhdGFiYXNlPzxCUj5ZZXMsIGl0IGRvZXMgaW5jbHVkZSBhIGRhdGFiYXNlLjxCUj5EZXRhaWxzOjxCUj48dWw+PGxpPlNRTCBTZXJ2ZXIgLS0gdmVyc2lvbihzKTogMjAwODwvbGk+PC91bD5kAgoPZBYEZg8WAh8ABRw8Yj5JbnN0YWxsYXRpb24gUHJvZ3JhbTo8L2I+ZAIBDxYCHwAFe0RvZXMgdGhlIHdvcmtlciBuZWVkIHRvIGNyZWF0ZSBhbiBpbnN0YWxsYXRpb24gcHJvZ3JhbT88QlI+WWVzIEFORCB0aGUgcHJvZ3JhbSB3aWxsIGJlIGluc3RhbGxlZCBvbiBvbmx5IGEgc2luZ2xlIGNvbXB1dGVyLmQCCw9kFgRmDxYCHwAFDTxiPkxlZ2FsOjwvYj5kAgEPFgIfAAXPCjEpIEkgcmVxdWlyZSBjb21wbGV0ZSBhbmQgZnVsbHktZnVuY3Rpb25hbCB3b3JraW5nIHByb2dyYW0ocykgaW4gZXhlY3V0YWJsZSBmb3JtIGFzIHdlbGwgYXMgY29tcGxldGUgc291cmNlIGNvZGUgb2YgYWxsIHdvcmsgZG9uZSAoc28gdGhhdCBJIG1heSBtb2RpZnkgaXQgaW4gdGhlIGZ1dHVyZSkuPGJyIC8+DQoyKSBEZWxpdmVyYWJsZXMgbXVzdCBiZSBpbiByZWFkeS10by1ydW4gY29uZGl0aW9uIGFzIGZvbGxvd3MgKGRlcGVuZGluZyBvbiB0aGUgbmF0dXJlIG9mIHRoZSBkZWxpdmVyYWJsZXMpOjxiciAvPg0KMmEpIElmIHRoZXJlIGFyZSBhbnkgc2VydmVyLXNpZGUgZGVsaXZlcmFibGVzIChpbnRlbmRlZCB0byBvbmx5IGV4aXN0IGluIG9uZSBwbGFjZSBpbiB0aGUgRW1wbG95ZXIncyBlbnZpcm9ubWVudCkgdGhlbiB0aGV5IG11c3QgYmUgaW5zdGFsbGVkIGJ5IHRoZSBXb3JrZXIgaW4gcmVhZHktdG8tcnVuIGNvbmRpdGlvbiAodW5sZXNzIHNwZWNpZmllZCBlbHNld2hlcmUgYnkgdGhlIEVtcGxveWVyKS48YnIgLz4NCjJiKSBBbGwgb3RoZXIgc29mdHdhcmUgKGluY2x1ZGluZyBidXQgbm90IGxpbWl0ZWQgdG8gYW55IGRlc2t0b3Agc29mdHdhcmUgb3Igc29mdHdhcmUgdGhlIGVtcGxveWVyIGludGVuZHMgdG8gZGlzdHJpYnV0ZSkgbXVzdCBpbmNsdWRlIGEgc29mdHdhcmUgaW5zdGFsbGF0aW9uIHBhY2thZ2UgdGhhdCB3aWxsIGluc3RhbGwgdGhlIHNvZnR3YXJlIGluIHJlYWR5LXRvLXJ1biBjb25kaXRpb24gb24gdGhlIHBsYXRmb3JtKHMpIHNwZWNpZmllZCBpbiB0aGlzIHByb2plY3QgKHVubGVzcyBzcGVjaWZpZWQgZWxzZXdoZXJlIGJ5IHRoZSBFbXBsb3llcikuPGJyIC8+DQozKSBBbGwgZGVsaXZlcmFibGVzIHdpbGwgYmUgY29uc2lkZXJlZCAid29yayBtYWRlIGZvciBoaXJlIiB1bmRlciBVLlMuIENvcHlyaWdodCBsYXcuIEVtcGxveWVyIHdpbGwgcmVjZWl2ZSBleGNsdXNpdmUgYW5kIGNvbXBsZXRlIGNvcHlyaWdodHMgdG8gYWxsIHdvcmsgcHVyY2hhc2VkLjxiciAvPg0KM2IpIE5vIHBhcnQgb2YgdGhlIGRlbGl2ZXJhYmxlIG1heSBjb250YWluIGFueSA8YSBocmVmPSIvUmVudEFDb2Rlci9Tb2Z0d2FyZUNvZGVycy9GQVEuYXNwI2NvcHlyaWdodCIgdGFyZ2V0PSJibGFuayI+Y29weXJpZ2h0IHJlc3RyaWN0ZWQgM3JkIHBhcnR5IGNvbXBvbmVudHM8L2E+IChpbmNsdWRpbmcgR1BMLCBHTlUsIENvcHlsZWZ0LCBldGMuKSB1bmxlc3MgYWxsIGNvcHlyaWdodCByYW1pZmljYXRpb25zIGFyZSBleHBsYWluZWQgQU5EIEFHUkVFRCBUTyBieSB0aGUgZW1wbG95ZXIgb24gdGhlIHNpdGUgcGVyIHRoZSB3b3JrZXIncyBXb3JrZXIgTGVnYWwgQWdyZWVtZW50LjxiciAvPmQCBA9kFgICAQ9kFgJmDw8WAh4HVmlzaWJsZWhkZGSXj6T2VFAkISAPGvaWeMbrz/nDJQ==" />

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
			<td>What kind of documentation do you want for this project?<BR>Formal documentation - After talking back and forth, the worker creates a formal document and/or prototype, as follows:<ul><li>Prototype: The analyst will create a non-working mockup of all pages/screens in the final software.  Creating a prototype makes it easier for the user to visualize the final software, and reduces misunderstandings.</li><li>Requirements Document: The analyst will create a document describing everything the final software will do (other than what is documented in the prototype...if the employer required one).</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Program Type:</b></td>
			<td>What kind of software should the worker create (and/or install)?<ul><li>A desktop or server program: This software runs on a user's own PC/workstation, or on a server.</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Desktop / server program info</b></td>
			<td></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Size of application:</b></td>
			<td>How many screens/forms need to be created/edited in this application?<BR>I don't know. <BR>Other info:Not sure</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Programming Language:</b></td>
			<td>What programming language(s) do you want your application written in?<BR>I do know the language(s).<BR>Languages(s):<BR><ul><li>C#</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Operating system(s)</b></td>
			<td>What operating systems(s) do you want your application to work on?<BR>I do know the operating system(s):<BR><li>Microsoft Windows -- version(s): XP, Vista Windows 2007</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Database:</b></td>
			<td>Will this project include a database?<BR>Yes, it does include a database.<BR>Details:<BR><ul><li>SQL Server -- version(s): 2008</li></ul></td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Installation Program:</b></td>
			<td>Does the worker need to create an installation program?<BR>Yes AND the program will be installed on only a single computer.</td>
		</tr>
		<tr class="NormalRow_Small">
			<td valign="top" align="right" nowrap=""><b>Legal:</b></td>
			<td>1) I require complete and fully-functional working program(s) in executable form as well as complete source code of all work done (so that I may modify it in the future).<br />
2) Deliverables must be in ready-to-run condition as follows (depending on the nature of the deliverables):<br />
2a) If there are any server-side deliverables (intended to only exist in one place in the Employer's environment) then they must be installed by the Worker in ready-to-run condition (unless specified elsewhere by the Employer).<br />
2b) All other software (including but not limited to any desktop software or software the employer intends to distribute) must include a software installation package that will install the software in ready-to-run condition on the platform(s) specified in this project (unless specified elsewhere by the Employer).<br />
3) All deliverables will be considered "work made for hire" under U.S. Copyright law. Employer will receive exclusive and complete copyrights to all work purchased.<br />
3b) No part of the deliverable may contain any <a href="/RentACoder/SoftwareCoders/FAQ.asp#copyright" target="blank">copyright restricted 3rd party components</a> (including GPL, GNU, Copyleft, etc.) unless all copyright ramifications are explained AND AGREED TO by the employer on the site per the worker's Worker Legal Agreement.<br /></td>
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
												
												<div id="divDeliverables"><p><b>Project Brief:</b></p>
<p><span>1.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>First Extract the all URLs like that <A target=_blank HREF="/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fwww%2Eyellowpages%2Eae%2Fcategory%2Fweb%2Ddesigning%2FMzYyODBfX19BbGxfX19fIF8%3D%2F"><span>&lt;span style="background: red; color: yellow;"&gt;http://www.yellowpages.ae/category/</span><span style="color: #0000ff;">web-designing/MzYyODBfX19BbGxfX19fIF8=/</span>&lt;/span&gt;</a></p>
<p><A target=_blank HREF="/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fwww%2Eyellowpages%2Eae%2Fcategory%2Fair%2Dconditioning%2D%5F%2Ddistrict%2Dcooling%2D%5F%2Dutility%2FNTA1X19fIF9fX18gXw%3D%3D%2F"><span>&lt;span style="background: red; color: yellow;"&gt;http://www.yellowpages.ae/category/</span><span style="color: #0000ff;">air-conditioning-_-district-cooling-_-utility/NTA1X19fIF9fX18gXw==/</span>&lt;/span&gt;</a></p>
<p><span>a.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span><A target=_blank HREF="/RentACoder/DotNet/WarningPage.aspx?Source=webpage&ExternalUrl=http%3A%2F%2Fwww%2Eyellowpages%2Eae%2Fcategory%2Fmachine%2Dtools%2FMjA4NDBfX18gX19fXyBf%2F"><span>&lt;span style="background: red; color: yellow;"&gt;http://www.yellowpages.ae/category/</span><span style="color: #0000ff;">machine-tools/MjA4NDBfX18gX19fXyBf/</span>&lt;/span&gt;</a></p>
<p><span>b.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">      </span></span>After the category/ there are different category.</p>
<p><span>2.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Software will extract email address of company and will past at column.</p>
<p><span>3.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Then it will access the website and will extract the email with filtration i.e. hr, CV, job, join, contact and will past at column</p>
<p><span>4.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span><span>If hr, CV, job join, contact email are not find then copy the domain of company e.g. abc.com and will search at Google like job @abc.com in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. If hr, CV, job, join, Contact email cannot find then search like CV @abc.com and in Google first page if hr, CV, Job Join Contact email find at first page then extract that email and paste at column. Repeat this step till we find one email hr, CV, job, join. If software cannot find the email then it can automatically generate the email with hr, CV, job, join, Contact.  And paste it at columns with notification &lsquo;email not test&rsquo;  </span></p>
<p><span>5.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>It can also extract the Company name, location, category</p>
<p><span>6.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Some company URL are not mentioned at yellow page</p>
<p><span>7.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Some companies URLs are missing at yellow page but they have proper website, in that case software will extract the complete name of company and will search at Google.</p>
<p><span>a.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>Software should here be more intelligent to find the exact website URL</p>
<p><span>b.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">      </span></span>When website URL is finding then repeat the step 3, step 4, and step 5.</p>
<p><span>8.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span><span>When one category is complete then it can pause the software and  save the file as excel file .XLS  with category name i.e. IT Company.cvs and SQL DB</span></p>
<p><span>9.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">       </span></span>To do this work application should generate the log file, save it and update it after every 10 minutes</p>
<p><span>10.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">   </span></span>During extraction the email May be yellow page ask for entering the security text at that time software will pause and user will manually enter the text after that user can again click on play it will start the extraction from where the software leave.</p>
<p><span>11.<span style="font-variant: normal; font-style: normal; font-size: 7pt; font-weight: normal;">   </span></span>During extraction the email May be Google search engine ask for entering the security text at that time software will pause and user will manually enter the text after that user can again click on play it will start the extraction from where the software leave.</p></div></font><font size=1><ul>
								    
								        <li>
												    All deliverables must be <a href="/RentACoder/SoftwareCoders/SoftwareSellerLegal.asp#QuickResolution" target=_blank>uploaded to vWorker.com</a> before the deadline(s) for this project...with no exceptions.  If this contract makes it impossible for a competent person to do this, then <a href="/RentACoder/SoftwareCoders/SoftwareSellerLegal.asp#IllegalProjects" target=_blank>do not start this project</a>...but instead alert vWorker.com of an <a href="/RentACoder/SoftwareBuyers/BidReqestPostingPolicy.asp#Unarbitratable" target=_blank>un-arbitratable, illegal</a> project.
											</font><BR>
                                        </li>
                                        
										        <li>Remember that contacting the other party outside of the site (by email, phone, etc.) on all business projects < $500 (before the employer's money is escrowed) is a <a href="/RentACoder/misc/Legal.asp">violation</a> of both the <a href="/RentACoder/SoftwareBuyers/SoftwareBuyerLegal.asp#OutContact">employer</a> and <a href="/RentACoder/SoftwareCoders/SoftwareSellerLegal.asp#OutContact">worker</a> agreements.
vWorker.com monitors all site activity for such violations and can instantly expel transgressors on the spot, so we thank you in advance for your cooperation.  
If you notice a violation please <a href="/RentACoder/misc/Feedback.asp?lngBidRequestId=1498633&intTypeOfInquiry=6">help out the site and report it</a>. Thanks for your help.
										        </li>
									        </ul></font><b><font size="2"><img   border="0" src="/images/IconExperience/ApplicationBasics/16x16/shadow/document_info.png" width="16" height="16" />
										Categories:</b></b><br>
										 <font size=1>(Note:  Like everything else on this page, these categories are part of the original contract for this project.)
										 </font><BR>Microsoft Windows, Database, Languages, Requirements, Operating systems / platforms, C#, Other (Technology), SQL Server, Technology, Software Development, Desktop applications, Tech details</font><BR>
										 <BR>
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
										Sep 29, 2010 3:30:50 PM&nbsp;<a href="javascript:ShowPopupWindowWithScrollbars('/RentACoder/DotNet/docs/TimeExplanation.aspx')">EDT</a><br>
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
							$150.00&nbsp;(<a href="javascript:ShowPopupWindowXYWithScrollbars('http://www.vWorker.com/RentACoder/misc/CurrencyConverter.asp?txtAmount=150',500,500)">USD<img   border="0" src="/images/IconExperience/@Custom/16x16/shadow/CurrencyConversion.png" width="16" height="16" /></a>)<img src="/RentACoder/images/icons/BlankIcon.gif" width=19 height=18>
						</td>
					</tr>	
									
			</table>
			
				<font size="2">
				
							No bids have been posted yet.
							  <a href="/RentACoder/SoftwareCoders/FAQ.asp?intTabSelectedId=2#ClosedBidding">Why can't I view bids from 
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
		<a href="/RentACoder/authentication/Login.asp?txtReturnURL=%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633">
		login</a>.<br>
		<br>

		<font size="2">Employers: If this is your project, then you can 
		see all bids/comments, and/or accept one, by <a href="/RentACoder/authentication/Login.asp?txtReturnURL=%2FRentACoder%2Fmisc%2FBidRequests%2FShowBidRequest%2Easp%3FlngBidRequestId%3D1498633">logging in</a>.</font>
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


    	    
                        </td></tr></table> <!-- / Protective table -->            
                    </div></div> <!-- / #content -->      
                <hr />
            
<div class="sidebar">

            

    <div class="box box-search"><div class="box-inner">

          
        <div class="head">
            <h5><strong>Search</strong></h5>
        </div> <!-- / .head -->


                
            <div class="contents">

                    <form method="post" id="form1" name="form1" style="margin-bottom:0px" action="/RentACoder/misc/BidRequests/ShowBidRequests.asp?lngBidRequestListType=4&optSortTitle=2&cmSearch=Search&txtMaxNumberOfEntriesPerPage=10&lngSortColumn=-6&blnModeVerbose=True"> 


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
379 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=213452">Gravity Jack, Inc.</a><br>
9.8 avg. over 
61 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1151754">Lisa_G</a><br>
9.9 avg. over 
1867 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1524214">calciustec h</a><br>
9.81 avg. over 
1548 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1128689">Pop Mihai Sergiu</a><br>
10 avg. over 
165 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=391882">PSergei</a><br>
9.87 avg. over 
481 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=1774642">DX Silverligh t Team</a><br>
9.8 avg. over 
320 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=896918">Dali Studio</a><br>
9.83 avg. over 
181 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=6410606">CodeAndMor e</a><br>
9.95 avg. over 
523 jobs.
</li><li><a href="/RentACoder/DotNet/SoftwareCoders/ShowBioInfo.aspx?lngAuthorId=6281468">Ing. Gervasio Marchand Cassataro</a><br>
10 avg. over 
187 jobs.
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
                        scrollamount="1" > <!-- not used speed="1" scrolldelay="240"-->
                        
                        
                        <div class="newsticker">
                        
                        <a name=NewestBidRequests></a><ul><li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498696" target="_top">Question on mod-rewrite and SSL(repost)</a></h6>

<p>By davidbc on September 15 3:17:20 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498674" target="_top">Simple WordPress installation changes</a></h6>

<p>By Extra Medium on September 15 2:49:08 PM</p>
<p>Max Bid: $50.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498656" target="_top">coldfusion mail and database specialist</a></h6>

<p>By rabindra009 on September 15 2:18:00 PM</p>
<p>Max Bid: $200.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498640" target="_top">HTML Flash Website Editing</a></h6>

<p>By crisbing on September 15 1:56:33 PM</p>
<p>Max Bid: Open to fair suggestions</p><p><a href="/upload_RAC/BidRequest_Graphics/2010/09/15/blue_ridge_logo_2010_RAC_NameCryptedToProtectYourPrivacy_X2010915143243789242903106577200731348535541657373887108522355286871012.jpg" target="_new">
(Screen Shot)</a></p>
<p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498521" target="_top">Online training illustrations</a></h6>

<p>By fingerweb on September 15 11:17:05 AM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1489219" target="_top">Update web Report</a></h6>

<p>By sorton on September 1 1:52:24 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498638" target="_top">MFC Visual Studio Example Using CHTMLView </a></h6>

<p>By skraemer on September 15 1:53:40 PM</p>
<p>Max Bid: $100.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498681" target="_top">Text translation English to German (3)</a></h6>

<p>By DigEnv on September 15 2:56:11 PM</p>
<p>Max Bid: Open to fair suggestions</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498625" target="_top">Visual Basic Barcode to csv</a></h6>

<p>By brizey02 on September 15 1:36:54 PM</p>
<p>Max Bid: $45.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498610" target="_top">building a barcode reader with HEDS-1200 HP and AV ...</a></h6>

<p>By mansoor min on September 15 1:07:16 PM</p>
<p>Max Bid: $50.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498595" target="_top">watermark software with watched folder</a></h6>

<p>By laphotoparty on September 15 12:53:43 PM</p>
<p>Max Bid: $400.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498661" target="_top">((Link Building Project))I need 100 Backlinks made ...</a></h6>

<p>By joel2280 on September 15 2:27:55 PM</p>
<p>Max Bid: $15.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498645" target="_top">Magento Template modifications</a></h6>

<p>By realestores on September 15 2:01:56 PM</p>
<p>Max Bid: $250.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498644" target="_top">facebook app that adds signature to all a users po ...</a></h6>

<p>By VerticalAnswer on September 15 1:59:38 PM</p>
<p>Max Bid: $250.00</p><p>&nbsp;</p></div></li>
<li><div class="contents_disabled"><h6><a href="http://www.vWorker.com/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1498653" target="_top">Set up Cart and merchant account today, do it now</a></h6>

<p>By dodhelp on September 15 2:05:00 PM</p>
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
                        <li><a href="/RentACoder/Affiliates/Help.asp">Affiliates</a></li>
                        <li><a href="/RentACoder/misc/Legal.asp">Legal</a></li>
                        <li><a target="_blank" href="http://blog.vWorker.com/">Blog</a></li>
                      </ul>
                    </div> <!-- / .nav -->
                
                    <div class="copyright">Copyright © 2001-2010 <a target=_blank href="http://www.exhedra.com"> Exhedra Solutions, Inc.</a> All rights reserved. <!br>
By using this site you agree to its <a href="/RentACoder/misc/TermsAndConditions.asp">Terms and Conditions</a>.<!br> 
<a target=_blank href="/RentACoder/DotNet/Default.aspx">vWorker.com</a>™,  &quot;<a href="/RentACoder/DotNet/Docs/SGD.aspx">Expert Guarantee</a>&quot;™  <a href="/RentACoder/DotNet/misc/TimeCard/DesktopApp/Overview.aspx">AccuTimeCard™</a> and &quot;More capable, accountable and affordable. Guaranteed.&quot;™<!BR> are trademarks of <a target=_blank href="http://www.exhedra.com"> Exhedra Solutions, Inc.</a>.  Page generated by IISPROD09 at 9/15/2010 3:36:18 PM</div>
        		
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

<!--sitewit analytics-->
<script type="text/javascript">
var loc = (("https:" == document.location.protocol) ? "https://analytics." : "http://analytics.");
document.write(unescape("%3Cscript src='" + loc + "sitewit.com/sw.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var sw = new _sw_analytics();
sw.id='95';
sw.register_page_view();
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

