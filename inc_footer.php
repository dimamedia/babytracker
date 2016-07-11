<?php

//include("js/js-combiner.php");

$files = array("jquery/jquery.js",
				"foundation-sites/foundation.core.js",
				"foundation-sites/foundation.util.mediaQuery.js",
				"foundation-sites/foundation.util.keyboard.js",
				"foundation-sites/foundation.util.box.js",
				"foundation-sites/foundation.util.nest.js",
				"foundation-sites/foundation.responsiveToggle.js",
				"foundation-sites/foundation.dropdownMenu.js",
				"app.js"
			);

//jsCombiner($files, 'js-combined.min.js', true);

print <<< html
		</div>
	</div>

    <script src="{$basePath}js/jquery/jquery.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.core.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.util.mediaQuery.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.util.keyboard.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.util.box.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.util.nest.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.util.triggers.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.sticky.js"></script>
    <script src="{$basePath}js/foundation-sites/foundation.reveal.js"></script>
    <script src="{$basePath}js/app.js"></script>
html;

?>

  </body>
</html>
