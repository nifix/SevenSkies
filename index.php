<?php
    session_start();
    error_reporting(E_ALL);
    require_once("./config/SevenSkies.config.php");
    include("./inc/sysfiles/SevenSkies.utils.php");
    include("./inc/sysfiles/SevenSkies.news.php");
    $utils = new SevenSkies\Utils();
    $news = new SevenSkies\News();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>SevenSkies - Online Fantasy MMORPG - Rush on Seven Episodes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- Save for Web Styles (Prototype.psd - Slices: All) -->
<link href="inc/css/SevenSkies.css" type="text/css" media="screen" rel="stylesheet" />
<link href="inc/js/slider/nivo-slider.css" type="text/css" media="screen"  rel="stylesheet" />
<link href="inc/css/custom-theme/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css"/>
<link href="inc/js/slider/themes/default/default.css" type="text/css" media="screen" rel="stylesheet" />
<link rel="stylesheet" href="inc/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script type="text/javascript" src="inc/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="inc/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="inc/js/slider/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="inc/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="inc/js/jquery.twitter.js"></script>
<script type="text/javascript" src="inc/js/SevenSkies.js"></script>
<script src="/xfbml/xfbml.js"></script>
<!-- End Save for Web Styles -->
</head>
<body>
<!-- Save for Web Slices (Prototype.psd - Slices: All) -->
<div class="Table_01">
	<div class="Slice_">
	</div>
	<div class="Slice002_">
		<img id="Slice002" src="images/Slice-02.png" width="1243" height="43" alt="" />
	</div>
	<div class="Slice003_">
		<img id="Slice003" src="images/Slice-03.png" width="453" height="239" alt="" />
	</div>
	<div class="Slice004_">
		<img id="Slice004" src="images/Slice-04.png" width="349" height="190" alt="" />
	</div>
	<div class="Slice005_">
		<img id="Slice005" src="images/Slice-05.png" width="441" height="239" alt="" />
	</div>
	<div class="Slice006_">
		<img id="Slice006" src="images/Slice-06.png" width="349" height="49" alt="" />
	</div>
	<div class="Slice007_">
		<img id="Slice007" src="images/Slice-07.png" width="104" height="776" alt="" />
	</div>
	<!-- MENU START HERE o/ -->
	
	
	<div class="Slice008_">
		<a href="home.ss"><img id="Slice008" class="imgHover" src="images/Home.png" width="92" height="50" alt="" /></a>
	</div>
	<div class="Slice010_">
		<a href="register.ss"><img id="Slice010" class="imgHover" src="images/Register.png" width="98" height="51" alt="" /></a>
	</div>
	<div class="Slice011_">
		<a href="downloads.ss"><img id="Slice011" class="imgHover" src="images/Downloads.png" width="120" height="51" alt="" /></a>
	</div>	
	<div class="Slice012_">
		<a href="#"><img id="Slice012" class="imgHover" src="images/Howto.png" width="120" height="50" alt="" /></a>
	</div>
	<div class="Slice013_">
		<a href="#"><img id="Slice013" class="imgHover" src="images/SDB.png" width="154" height="51" alt="" /></a>
	</div>		
	<div class="Slice014_">
		<a href="#"><img id="Slice014" class="imgHover" src="images/SA.png" width="131" height="51" alt="" /></a>
	</div>	
	<div class="Slice016_">
		<a href="#"><img id="Slice016" class="imgHover" src="images/Support.png" width="92" height="51" alt="" /></a>
	</div>
	<div class="Slice017_">
		<a href="http://tribalgamingnet.com/forum/"><img id="Slice017" class="imgHover" src="images/Forums.png" width="97" height="51" alt="" /></a>
	</div>	
	<div class="Slice018_">
		<a href="#"><img id="Slice018" class="imgHover" src="images/About.png" width="96" height="51" alt="" /></a>
	</div>
	
	
	<!-- MENU ENDS HERE \o -->
	
	
	<div class="Slice009_">
		<img id="Slice009" src="images/Slice-09.png" width="1" height="51" alt="" />
	</div>
	<div class="Slice015_">
		<img id="Slice015" src="images/Slice-15.png" width="1" height="51" alt="" />
	</div>
	<div class="Slice019_">
		<img id="Slice019" src="images/Slice-19.png" width="137" height="776" alt="" />
	</div>
	<div class="Slice020_">
		<img id="Slice020" src="images/Slice-20.png" width="92" height="1" alt="" />
	</div>
	<div class="Slice021_">
		<img id="Slice021" src="images/Slice-21.png" width="120" height="1" alt="" />
	</div>
	<div class="Slice022_">
		<img id="Slice022" src="images/Slice-22.png" width="1002" height="15" alt="" />
	</div>
	<div class="Slice023_">
		<img id="Slice023" src="images/Slice-23.png" width="198" height="2" alt="" />
	</div>
	
	<!-- Content -->
	
        <?php  
        if (!empty($_GET['px'])) { $utils->sLoadContent($_GET['px']); } else { $utils->sLoadContent(1); } 
        ?>
	
	<!-- End Content -->
        
        <!-- Left Menu -->
        
        <div class="Slice050_">
		<?php echo $utils->getMenu(); ?>
	</div>
        
        <!-- End Left Menu -->
        
	<div class="Slice025_">
		<img id="Slice025" src="images/Slice-25.png" width="195" height="2" alt="" />
	</div>
	<div class="Slice026_">
		<img id="Slice026" src="images/Slice-26.png" width="198" height="8" alt="" />
	</div>
	<div class="Slice027_">
		<img id="Slice027" src="images/Slice-27.png" width="195" height="6" alt="" />
	</div>
	<div class="Slice028_">
		<img id="Slice028" src="images/Slice-28.png" width="5" height="656" alt="" />
	</div>
	<div class="Slice029_">
            <a href="register.ss" alt="Join US Now !"><img id="Slice029" src="images/Slice-29.png" width="190" height="47" alt="" /></a>
	</div>
	<div class="Slice030_">
		<img id="Slice030" src="images/Slice-30.png" width="191" height="35" alt="" />
	</div>
	<div class="Slice031_">
		<img id="Slice031" src="images/Slice-31.png" width="7" height="654" alt="" />
	</div>
	<div class="Slice032_">
            <?php echo $utils->getLForm(); ?>
	</div>
	<div class="Slice033_">
		<img id="Slice033" src="images/Slice-33.png" width="2" height="218" alt="" />
	</div>
	<div class="Slice034_">
		<img id="Slice034" src="images/Slice-34.png" width="190" height="4" alt="" />
	</div>
	<div class="Slice035_">
		<img id="Slice035" src="images/Slice-35.png" width="8" height="159" alt="" />
	</div>
	<div class="Slice037_">
		<img id="Slice037" src="images/Slice-37.png" width="8" height="82" alt="" />
	</div>
	<div class="Slice038_">
		<img id="Slice038" src="images/Slice-38.png" width="1" height="35" alt="" />
	</div>
	<div class="Slice039_">
		<img id="Slice039" src="images/Slice-39.png" width="189" height="35" alt="" />
	</div>
	<div class="Slice041_">
		<div id="twitted"></div>
	</div>
	<div class="Slice043_">
		<img id="Slice043" src="images/Slice-43.png" width="4" height="77" alt="" />
	</div>
	<div class="Slice045_">
		<img id="Slice045" src="images/Slice-45.png" width="189" height="10" alt="" />
	</div>
	<div class="Slice046_">
		<img id="Slice046" src="images/Slice-46.png" width="189" height="37" alt="" />
	</div>
	<div class="Slice048_">
		<img id="Slice048" src="images/Slice-48.png" width="1" height="185" alt="" />
	</div>
	<div class="Slice049_">
		<img id="Slice049" src="images/Slice-49.png" width="1" height="401" alt="" />
	</div>
	<div class="Slice051_">
		<img id="Slice051" src="images/Slice-51.png" width="1" height="325" alt="" />
	</div>
	<div class="Slice052_">
		<img id="Slice052" src="images/Slice-52.png" width="189" height="43" alt="" />
	</div>
	<div class="Slice053_">
		<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/Seven-Skies-Online/204671426216042" width="189" height="271" show_faces="true" border_color="#696969" stream="false" header="true"></fb:like-box>
	</div>
	<div class="Slice054_">
		<img id="Slice054" src="images/Slice-54.png" width="190" height="3" alt="" />
	</div>
	<div class="Slice055_">
		<img id="Slice055" src="images/Slice-55.png" width="189" height="35" alt="" />
	</div>
	<div class="Slice056_">
		<img id="Slice056" src="images/Slice-56.png" width="1" height="213" alt="" />
	</div>
	<div class="Slice057_">
            <div align="center" class="sholder">
                <img src="./images/loading.gif" alt="SLoading" />
            </div>
	</div>
	<div class="Slice059_">
		<img id="Slice059" src="images/Slice-59.png" width="189" height="11" alt="" />
	</div>
	<div class="Slice060_">
		<img id="Slice060" src="images/Slice-60.png" width="189" height="11" alt="" />
	</div>
	<div class="Slice061_">
		<img id="Slice061" src="images/Slice-61.png" width="609" height="6" alt="" />
	</div>
	<div class="Slice062_">
            <div id="footer">
                <div class="fleft">SevenSkies - All Right Reserved</div>
                <div class="fright">By <b>Nifix</b> [2011]</div>
                <div class="fmid"></div>
            </div>
        </div>
	<div class="Slice063_">
		<img id="Slice063" src="images/Slice-63.png" width="1002" height="13" alt="" />
	</div>
</div>
<!-- End Save for Web Slices -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21613758-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>