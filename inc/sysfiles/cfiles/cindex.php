<?php
if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
    $news = new SevenSkies\News();
}
?>
<div class="Slice024_">
    <div class="slider-wrapper theme-default">
        <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
                <a href="http://tribalgamingnet.com/forum/"><img src="images/fp/rose.jpg" alt="" title="Join us ! For the lulZ !" /></a>
                <img src="images/fp/rose2.jpg" alt="" />
                <img src="images/fp/rose3.jpg" alt="" />
                <img src="images/fp/rose4.jpg" alt="" />
            </div>
        </div>
    </div>
<div class="Slice047_">
    <div id="news-jq">
        <div id="accordion">
            <?php echo $news->printNews(); ?>
        </div>
    </div>
</div>
<div class="Slice058_">
    <div style="margin-top:40px" align="center">
        <a class="grouped_elements" rel="group1" href="./images/fbox/FS/cg_fi_2010.jpg"><img src="./images/fbox/TN/cg_fi_2010.png" alt=""/><span></span></a>
        <a class="grouped_elements" rel="group1" href="./images/fbox/FS/opptions_1.jpg"> <img src="./images/fbox/TN/opptions_1.png" alt=""/><span></span></a> 
        <a class="grouped_elements" rel="group1" href="./images/fbox/FS/ui_3.jpg"><img src="./images/fbox/TN/ui_3.png" alt=""/><span></span></a>
        <a class="grouped_elements" rel="group1" href="./images/fbox/FS/ui_6.jpg"><img src="./images/fbox/TN/ui_6.png" alt=""/><span></span></a><br />
    </div>
</div>
<script type="text/javascript">$("a.grouped_elements").fancybox();</script>
