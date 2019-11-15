# Google Tag Manager: Developer Guidelines

Below are the directions to integrate Google Tag Manager (GTM) into web site development:

1. Including Google Tag Manager
2. Social link click tracking
3. Menu tracking
4. Search site tracking trace
5. Tracking boxes in home page / macro categories pages
6. Contact form tracking
7. Facebook search site tracking trace

##### Additional Content:

*Appendix: Codes for 'custom HTML' tag*




## 1. Including Google Tag Manager

The inclusion of Tag Manager must be present on all pages of the site.

Inclusion is subdivided into 2 snippets of code (provided by the SEO specialist) as indicated by the [official guide](https://developers.google.com/tag-manager/quickstart):

##### 1) Paste the first snippet of code as high as possible in the `<head>` section of the page (but anyway after the main targets like charset, viewport, etc ...):

``` html
<head>
.
.
.
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXX');</script>
<!-- End Google Tag Manager -->
. 
.
.
</head>
```

##### 2) Paste the second snippet of code immediately after the opening tag `<body>`:

``` html
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
```




## 2. Social link click tracking

Give a class to the social link, in the following `gtm-socialName` format. This is to facilitate the tracking of clicks on individual social links.

Some examples:

``` html
<a class="gtm-facebook" href="https://www.facebook.com">

<a class="gtm-youtube" href="https://www.youtube.com">
```

## 3. Menu Tracking

There are two standard typologies of menu tracking:

##### 1. Main menu tracing, using the `main-menu` ID associated with the HTML element that wraps the menu (the ID is already set in the default BePrime WP framework in the header.php file):

``` html
<!-- Main menu wrapper -->
<nav id="main-menu" class="...">
    <ul class="menu ...">
		<?php wp_nav_menu( . . . ); ?>
	</ul>
</nav>
```

##### 2. Side menu tracing, using the `side-menu`ID associated with the HTML element that wraps the menu:

``` html
<!-- Side menu wrapper -->
<nav id="side-menu" class="...">
    <ul class="menu ...">
		<?php wp_nav_menu( . . . ); ?>
	</ul>
</nav>
```

Using these IDs, you can use the custom HTML tag to monitor individual menu items within Tag Manager (see Appendix if you are interested in the code to use in the custom HTML tag).


## 4. Search Site Tracking Trace

To tack the terms entered in the site search bar, use the `searchform` ID associated with the HTML element` form` that contains the search fields in question (the ID is already set in the BePrime WP default format in the file `searchform.php`):

``` html
<form action="<?php echo esc_url(home_url()); ?>" id="searchform" method="get">
  <div class="input-group">
      <input type="text" id="s" class="form-control" name="s" placeholder="Search for:"/>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-secondary" id="searchsubmit" ><i class="fa fa-search"></i></button>
      </span>
  </div>
</form>
```
If you need to create a different HTML structure than the one mentioned above, please observe the following conditions:

- id `searchform ` assigned to the `form` element
- class `form-control` assigned to the  `input` element where search terms are inserted

With these IDs and Classes, you can use the custom HTML tag to track search terms within Tag Manager (see Appendix if you are interested in the code used in the custom HTML tag).


## 5. Tracking boxes in home page / macro categories pages

Tracking boxes clicks in: 

- Home page
- Macro categories as “Settori di utilizzo”, “Products”, etc...
- Sub categories

Use a `gtm-boxes` class assigned to the container of the boxes and, within that, track the clicks on the links by applying them a` gtm-box-link` class. Let's put a `gtm-box-text` class at the element used within the link to capture a text reference:

``` html
<!-- Boxes container -->
<div class="gtm-boxes">

	<div class="box1">
		<!-- link to track -->
		<a class="gtm-box-link" href="http://www.beprime.it">
			<!-- text -->
			<span class="gtm-box-text">Titolo del box</span>
		</a>
	</div>
	.
	.
	.
</div>
```


## 6. Contact form tracing

To track the contact form Contact Form 7, the following javascript code will be implemented, with the insertion of `datalayer.push` to the successful submission of the form, thus activating the`forminviato` event:

``` js
/**
 * POSSIBLES EVENTS:
 * wpcf7:invalid
 * wpcf7:spam
 * wpcf7:mailsent
 * wpcf7:mailfailed
 * wpcf7:submit
 */
 
 // Form message successfully sent
 $(".wpcf7").on('wpcf7:mailsent', function(event){
   dataLayer.push({'event': 'forminviato'});
 });
```

For custom form tracking, the procedure remains the same: to monitor the correct form submission (by code) and then insert the tracking code 'dataLayer.push({'event': 'forminviato'});

The above code remains unchanged even if there are multiple contact forms on the site, as these will be differentiated by the 'page url' variable (applied to the `forminviato` event within Tag Manager).
  
    
	
## 7. Facebook search site tracking trace	

To tack the terms entered in the site search bar, and send those to facebook, add the following data attribute `data-track="<?php echo get_search_query(); ?` to the HTML element with ID `page_search` in the file `search.php`:

``` html
. . . 

<section id="page_search" data-track="<?php echo get_search_query(); ?>

. . .

```

    

## Appendix: Codes for 'custom HTML' tag

For completeness, see below the codes used in the 'Custom HTML' tag within Tag Manager :

#### Menu Tracking

``` html
<script>
$('#main-menu').find('li a').on('click', function(){
 
 if($(this).attr('href') !== '#'){
     var label = $(this).text();
     
     dataLayer.push({
        'event' : 'eventoMenu',
        'eventCategory' : 'Main menu',
        'eventAction' : 'click',
        'eventLabel' : label
      });
  }
 
});
</script>
```

#### Search Site Tracking Trace

``` html
<script>
$('#searchform').on('submit', function(){
 
var search = $('#searchform').find('.form-control').val();
 
dataLayer.push({
    'event' : 'eventoSearch',
    'eventCategory' : 'Search',
    'eventAction' : 'click',
    'eventSearch' : search
  });
 
});
</script>
```

#### Facebook Search Site Tracking Trace

``` html
<script>
if($('#page_search').length){
 
    var searchText = $('#page_search').attr('data-track');
 
    fbq('track', 'Search', {
      search_string: searchText,
      content_type: 'product'
    });
}
</script>

```

#### Page Scrolling Tracking (on request)

``` html
<script>;
(function ($, window, document, undefined) {

	"use strict";

	var defaults = {
		minHeight: 0,
		elements: [],
		percentage: true,
		userTiming: true,
		pixelDepth: true,
		nonInteraction: true,
		gaGlobal: false,
		gtmOverride: false
	};

	var $window = $(window),
		cache = [],
		scrollEventBound = false,
		lastPixelDepth = 0,
		universalGA,
		classicGA,
		gaGlobal,
		standardEventHandler;

	$.scrollDepth = function (options) {
		var startTime = +new Date;
		options = $.extend({}, defaults, options);
		// Return early if document height is too small
		if ($(document).height() < options.minHeight) {
			return;
		}
		if (options.gaGlobal) {
			universalGA = true;
			gaGlobal = options.gaGlobal;
		} else if (typeof ga === "function") {
			universalGA = true;
			gaGlobal = 'ga';
		} else if (typeof __gaTracker === "function") {
			universalGA = true;
			gaGlobal = '__gaTracker';
		}
		if (typeof _gaq !== "undefined" && typeof _gaq.push === "function") {
			classicGA = true;
		}
		if (typeof options.eventHandler === "function") {
			standardEventHandler = options.eventHandler;
		} else if (typeof dataLayer !== "undefined" && typeof dataLayer.push === "function" && !options.gtmOverride) {
			standardEventHandler = function (data) {
				dataLayer.push(data);
			};
		}
		function sendEvent(action, label, scrollDistance, timing) {
			if (standardEventHandler) {
				standardEventHandler({
					'event': 'ScrollDistance',
					'eventCategory': 'Scroll Depth',
					'eventAction': action,
					'eventLabel': label,
					'eventValue': 1,
					'eventNonInteraction': options.nonInteraction
				});
				if (options.pixelDepth && arguments.length > 2 && scrollDistance > lastPixelDepth) {
					lastPixelDepth = scrollDistance;
					standardEventHandler({
						'event': 'ScrollDistance',
						'eventCategory': 'Scroll Depth',
						'eventAction': 'Pixel Depth',
						'eventLabel': rounded(scrollDistance),
						'eventValue': 1,
						'eventNonInteraction': options.nonInteraction
					});
				}
				if (options.userTiming && arguments.length > 3) {
					standardEventHandler({
						'event': 'ScrollTiming',
						'eventCategory': 'Scroll Depth',
						'eventAction': action,
						'eventLabel': label,
						'eventTiming': timing
					});
				}
			} else {
				if (universalGA) {
					window[gaGlobal]('send', 'event', 'Scroll Depth', action, label, 1, {
						'nonInteraction': options.nonInteraction
					});
					if (options.pixelDepth && arguments.length > 2 && scrollDistance > lastPixelDepth) {
						lastPixelDepth = scrollDistance;
						window[gaGlobal]('send', 'event', 'Scroll Depth', 'Pixel Depth', rounded(scrollDistance), 1, {
							'nonInteraction': options.nonInteraction
						});
					}
					if (options.userTiming && arguments.length > 3) {
						window[gaGlobal]('send', 'timing', 'Scroll Depth', action, timing, label);
					}
				}
				if (classicGA) {
					_gaq.push(['_trackEvent', 'Scroll Depth', action, label, 1, options.nonInteraction]);
					if (options.pixelDepth && arguments.length > 2 && scrollDistance > lastPixelDepth) {
						lastPixelDepth = scrollDistance;
						_gaq.push(['_trackEvent', 'Scroll Depth', 'Pixel Depth', rounded(scrollDistance), 1, options.nonInteraction]);
					}
					if (options.userTiming && arguments.length > 3) {
						_gaq.push(['_trackTiming', 'Scroll Depth', action, timing, label, 100]);
					}
				}
			}
		}
		function calculateMarks(docHeight) {
			return {
				'25%': parseInt(docHeight * 0.25, 10),
				'50%': parseInt(docHeight * 0.50, 10),
				'75%': parseInt(docHeight * 0.75, 10),
				// Cushion to trigger 100% event in iOS
				'100%': docHeight - 5
			};
		}
		function checkMarks(marks, scrollDistance, timing) {
			// Check each active mark
			$.each(marks, function (key, val) {
				if ($.inArray(key, cache) === -1 && scrollDistance >= val) {
					sendEvent('Percentage', key, scrollDistance, timing);
					cache.push(key);
				}
			});
		}
		function checkElements(elements, scrollDistance, timing) {
			$.each(elements, function (index, elem) {
				if ($.inArray(elem, cache) === -1 && $(elem).length) {
					if (scrollDistance >= $(elem).offset().top) {
						sendEvent('Elements', elem, scrollDistance, timing);
						cache.push(elem);
					}
				}
			});
		}
		function rounded(scrollDistance) {
			// Returns String
			return (Math.floor(scrollDistance / 250) * 250).toString();
		}
		function init() {
			bindScrollDepth();
		}
		// Reset Scroll Depth with the originally initialized options
		$.scrollDepth.reset = function () {
			cache = [];
			lastPixelDepth = 0;
			$window.off('scroll.scrollDepth');
			bindScrollDepth();
		};
		// Add DOM elements to be tracked
		$.scrollDepth.addElements = function (elems) {
			if (typeof elems == "undefined" || !$.isArray(elems)) {
				return;
			}
			$.merge(options.elements, elems);
			// If scroll event has been unbound from window, rebind
			if (!scrollEventBound) {
				bindScrollDepth();
			}
		};
		// Remove DOM elements currently tracked
		$.scrollDepth.removeElements = function (elems) {
			if (typeof elems == "undefined" || !$.isArray(elems)) {
				return;
			}
			$.each(elems, function (index, elem) {
				var inElementsArray = $.inArray(elem, options.elements);
				var inCacheArray = $.inArray(elem, cache);
				if (inElementsArray != -1) {
					options.elements.splice(inElementsArray, 1);
				}
				if (inCacheArray != -1) {
					cache.splice(inCacheArray, 1);
				}
			});
		};
		function throttle(func, wait) {
			var context, args, result;
			var timeout = null;
			var previous = 0;
			var later = function () {
				previous = new Date;
				timeout = null;
				result = func.apply(context, args);
			};
			return function () {
				var now = new Date;
				if (!previous) previous = now;
				var remaining = wait - (now - previous);
				context = this;
				args = arguments;
				if (remaining <= 0) {
					clearTimeout(timeout);
					timeout = null;
					previous = now;
					result = func.apply(context, args);
				} else if (!timeout) {
					timeout = setTimeout(later, remaining);
				}
				return result;
			};
		}
		function bindScrollDepth() {
			scrollEventBound = true;
			$window.on('scroll.scrollDepth', throttle(function () {
				var docHeight = $(document).height(),
					winHeight = window.innerHeight ? window.innerHeight : $window.height(),
					scrollDistance = $window.scrollTop() + winHeight,
					// Recalculate percentage marks
					marks = calculateMarks(docHeight),
					// Timing
					timing = +new Date - startTime;
				// If all marks already hit, unbind scroll event
				if (cache.length >= options.elements.length + (options.percentage ? 4 : 0)) {
					$window.off('scroll.scrollDepth');
					scrollEventBound = false;
					return;
				}
				// Check specified DOM elements
				if (options.elements) {
					checkElements(options.elements, scrollDistance, timing);
				}
				// Check standard marks
				if (options.percentage) {
					checkMarks(marks, scrollDistance, timing);
				}
			}, 500));
		}
		init();
	};
})(jQuery, window, document);
jQuery(function () {
	jQuery.scrollDepth();
});
</script>
```
