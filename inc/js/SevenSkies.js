function submitform() { document.confirmb.submit(); }

// Slider    
$(window).load(function() {
	$('#slider').nivoSlider({
	effect:'fade',
	controlNav:false
	});
});

$(window).load(function() {
    $("#mcs_container").mCustomScrollbar("vertical",400,"easeOutCirc",1.05,"auto","yes","yes",10);
});

$(function() {
  $( "#paypalopts" ).buttonset();
});

$(function() {
  $( "input:submit" ).button();
});

var RecaptchaOptions = {
theme : 'clean'
};
$(function() {
        $( "#dialog-confirm" ).dialog({
            	autoOpen: false,
                resizable: false,
                height:160,
                modal: true,
                buttons: {
                        "Purchase !": function() {
                                document.confirmb.submit();
                        },
                        Cancel: function() {
                                $( this ).dialog( "close" );
                        }
                }
        });
        
        $( "#confirmpurchase" )
        .button()
        .click(function() {
                $( "#dialog-confirm" ).dialog( "open" );
        });
        
});



$(document).ready(function()
{
        $('#mydate').datepicker({dateFormat: 'yy-mm-dd', 
                changeMonth: true,
		changeYear: true,
    yearRange: '1950:2010' 
            });
});


$(document).ready(function() {
    $.ajax({
      type: "GET",
      url: "./inc/sysfiles/cfiles/uchecker.php",
      dataType: "html",
      data : {},
      cache: false,
      success: function(data) {
        $('.sholder').html(data);
      }
    });
})

// Acordion news
$(function()
{	
	// Accordion
	$("#accordion").accordion({header: "h3"});
	$("#accordion").accordion( "option", "collapsible", true );
	$("#accordion").accordion( "option", "active", false );

	// Tabs
	$( "#tabs" ).tabs().find( ".ui-tabs-nav" ).sortable({axis: "x"});
});

// Fancy Box
$(document).ready(function() {

	$("a#single_image").fancybox();

	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
});

// Twitter

$(document).ready(function() {
	$("#twitted").getTwitter({
		userName: "TGNStudios",
		numTweets: 3,
		loaderText: "Loading tweets...",
		slideIn: true,
		showHeading: false,
		headingText: "Latest Tweets",
		showProfileLink: false
	});
});

(function($) {
  var cache = [];
  $.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)

// Submit button
function loginSubmit()
{
    document.Lowgin.submit();
}

function registerSubmit()
{
    document.Rewgi.submit();
}

// Preloading Stuffs

jQuery.preLoadImages("./images/Loginbh.png");
jQuery.preLoadImages("./images/Home_h.png", "./images/Register_h.png", "./images/Downloads_h.png", "./images/Howto_h.png",
"./images/SDB_h.png", "./images/SA_h.png", "./images/Support_h.png", "./images/Forums_h.png", "./images/About_h.png");
// Mouseover Stuffs

$(document).ready(function(){
   $(".imgHover").hover( function() {
       var hoverImg = HoverImgOf($(this).attr("src"));
       $(this).attr("src", hoverImg);
     }, function() {
       var normalImg = NormalImgOf($(this).attr("src"));
       $(this).attr("src", normalImg);
     }
   );
});

function HoverImgOf(filename)
{
   var re = new RegExp("(.+)\\.(gif|png|jpg)", "g");
   return filename.replace(re, "$1_h.$2");
}
function NormalImgOf(filename)
{
   var re = new RegExp("(.+)_h\\.(gif|png|jpg)", "g");
   return filename.replace(re, "$1.$2");
}

/* Scrollbar jquery */