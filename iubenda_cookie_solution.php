<?php
	/*
	Plugin Name: Iubenda Cookie Solution
	Plugin URI: https://www.iubenda.com
	Description: Iubenda Cookie Solution permette di gestire tutti gli aspetti della cookie law su WP.
	Author: iubenda
	Version: 1.9.7
	Author URI: https://www.iubenda.com
	*/

	if(!function_exists('file_get_html')){
		include_once 'simple_html_dom.php';
	}

	DEFINE('VOICE_MENU', 'Iubenda Cookie Solution');
	DEFINE('URL_MENU', str_replace(' ', '_', VOICE_MENU));
	DEFINE('IUB_REGEX_PATTERN', '/<!--IUB_COOKIE_POLICY_START-->(.*)<!--IUB_COOKIE_POLICY_END-->/sU');


	/***************************************
	*
	*  Add Iubenda JS script to the header
	*
	****************************************/

	function strpos_array($haystack, $needle){
		if(is_array($needle)){
	       foreach($needle as $need){
	       	if(strpos($haystack, $need) !== false){
	        	return true;
	        }
	       }
	     }else{
	     	if(strpos($haystack, $need) !== false) {
	        	return true;
	        }
	     }
	  	return false;
	}


	function consentGiven(){
		foreach($_COOKIE as $key => $value){
			if(strpos_array($key, array('_iub_cs-s', '_iub_cs'))){
				return true;
			}
		}
	}



	function iub_header(){
		ob_start();
		$iub_code = get_option('iub_code');
		$str = html_entity_decode(stripslashes($iub_code));
		
		if(!consentGiven()){
			$str.="\n
				<script>
					(function(){
					
						function extendObj() {
						  for (var i = 1; i < arguments.length; i++)
						  for (var key in arguments[i])
						  if (arguments[i].hasOwnProperty(key))
						  arguments[0][key] = arguments[i][key];
						  return arguments[0];
						}


						var userCallback, extend;
						
						if(typeof(_iub.csConfiguration.callback) !== 'undefined'){
							userCallback = _iub.csConfiguration.callback.onConsentGiven || function(){};
						}else{
							userCallback = function(){};
						}
		
						extend = {
						  callback: {
						    onConsentGiven: function(){
							  userCallback();
							  jQuery('noscript._no_script_iub').each(function(a,b){
								var el = jQuery(b);
								el.after(el.html());
							  });
							}
						  }
					    };
					    			
						extendObj(_iub.csConfiguration, extend);
					})();
				</script>";
		}
		
		echo $str;
	}

	add_action('wp_head', 'iub_header', 99);

	/***********************************
	*
	*  Encode all the javascript/html content fetched from this comments:
	*
	*	<!--IUB_COOKIE_POLICY_START-->
	* 	<script>..</script>
	*	<!--IUB_COOKIE_POLICY_END-->
	*
	*	AND
	*
	*	[iub-cookie-solution]
	*
	*	code
	*
	*	[/iub-cookie-solution]
	*
	************************************/

	function create_tags($html){

		$elements = $html->find("*");
		$js = '';

		foreach($elements as $e){

			switch($e->tag){
				case 'script':
					$s = $e->innertext;
					$js.= '<script type="text/plain" class="_iub_cs_activate">'.$s.'</script>';
				break;

				default:
					$js.= '<noscript class="_no_script_iub">';
					$js.= $e->outertext;
					$js.= '</noscript>';
				break;
			}

		}

		return $js;
	}


	function __shutdown(){
	    $final = '';

	    // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
	    // that buffer's output into the final output.
	    $levels = count(ob_get_level());

	    for ($i = 0; $i < $levels; $i++){
	        $final .= ob_get_clean();
	    }

	    // Apply any filters to the final output
	    echo apply_filters('final_output', $final);
	}

	add_action('shutdown', '__shutdown', 0);


	function __final_output($output){

		$auto_script_tags = array(
			'platform.twitter.com/widgets.js',
			'apis.google.com/js/plusone.js',
			'apis.google.com/js/platform.js',
			'connect.facebook.net',
			'www.youtube.com/iframe_api'
		);

		$auto_iframe_tags = array(
			'youtube.com',
			'platform.twitter.com',
			'www.facebook.com/plugins/like.php',
			'apis.google.com'
		);


		if(consentGiven()){
			return $output;
		}

		/* Replace all the comments with js/html encoded code */
		preg_match_all(IUB_REGEX_PATTERN, $output, $scripts);
		if(is_array($scripts[1])){
			$count = count($scripts[1]);
			$js_scripts = array();
			for($j=0; $j<$count; $j++){
				$html = str_get_html($scripts[1][$j], $lowercase=true, $forceTagsClosed=true, $stripRN=false);
				$js_scripts[] = create_tags($html);
			}

		    if(is_array($scripts[1]) && is_array($js_scripts)){
		    	if(count($scripts[1]) >= 1 && count($js_scripts) >= 1){
					$output = strtr($output, array_combine($scripts[1], $js_scripts));
		    	}
		    }
		}

		$html = str_get_html($output, $lowercase=true, $forceTagsClosed=true, $stripRN=false);

		if(is_object($html)){
			/* Auto match script and replace */
			$scripts = $html->find("script");
			if(is_array($scripts)){
				$count = count($scripts);
				for($j=0; $j<$count; $j++){
					$s = $scripts[$j];
					if (strpos_array($s->innertext, $auto_script_tags) !== false) {
						$class = $s->class;
						$s->class = $class . ' _iub_cs_activate';
						$s->type = 'text/plain';
					}else{
						$src = $s->src;
						if (strpos_array($src, $auto_script_tags) !== false) {
							$class = $s->class;
							$s->class = $class . ' _iub_cs_activate-inline';
							$s->type = 'text/plain';
						}
					}
				}
			}
	
			/* Auto match iframe and replace */
			$iframes = $html->find("iframe");
			if(is_array($iframes)){
				$count = count($iframes);
				for($j=0; $j<$count; $j++){
					$i = $iframes[$j];
					$src = $i->src;
					if (strpos_array($src, $auto_iframe_tags) !== false){
						$new_src = "data:text/html;base64,PGh0bWw+PGJvZHk+U3VwcHJlc3NlZDwvYm9keT48L2h0bWw+";
						$class = $i->class;
						$i->suppressedsrc = $src;
						$i->src = $new_src;
						$i->class = $class . ' _iub_cs_activate';
					}
				}
			}
		
			return $html;
			
		}else{
			return $output;
		}

	}

	add_filter('final_output', '__final_output', $output);


	function iub_func($atts, $content = "") {
		/* Shortcode function */
		$html = str_get_html($content, $lowercase=true, $forceTagsClosed=true, $stripRN=false);
		return create_tags($html);
	}


	add_shortcode('iub-cookie-policy', 'iub_func');


	/***********************************
	*
	*  Add menù item on the admin
	*
	************************************/


	function iub_admin_actions() {
    	add_options_page(VOICE_MENU, VOICE_MENU, 1, URL_MENU, 'iub_admin');
	}


 	function iub_admin(){

 		/* Handling POST DATA and FETCHING from DB */
	 	if($_POST['iub_update_form'] == 1) {

	        $iub_code = htmlentities($_POST['iub_code']);
	        update_option('iub_code', $iub_code);
	        echo '<div class="updated"><p><strong>Opzioni salvate</strong></p></div>';
	    } else {
	        $iub_code = get_option('iub_code');
	    }

	echo '
		<div class="wrap">
	     <h2> iubenda Cookie Policy Solution</h2>
		    <form name="iub_form" method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">
	     		<h4>Iubenda settings</h4>
	     		<p>
	    			Codice iubenda<br>
	     			 <textarea name="iub_code" cols="44" rows="13">'.stripslashes($iub_code).'</textarea>
	     		</p>

		        <p class="submit">
	 		       <input type="hidden" name="iub_update_form" value="1">
	 		       <input type="submit" name="Submit" value="Update">
	        	</p>
		    </form>
		    <p>
		    Per informazioni ed istruzioni su questo plugin, visita questa guida:<br>
			<a href="https://www.iubenda.com/it/help/posts/810">https://www.iubenda.com/it/help/posts/810</a>

</p>

		</div>';
 	}


	add_action('admin_menu', 'iub_admin_actions');

?>
