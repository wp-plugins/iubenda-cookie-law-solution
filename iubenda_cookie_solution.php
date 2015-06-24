<?php
	/*
	Plugin Name: Iubenda Cookie Solution
	Plugin URI: https://www.iubenda.com
	Description: Iubenda Cookie Solution permette di gestire tutti gli aspetti della cookie law su WP.
	Author: iubenda
	Version: 1.9.14
	Author URI: https://www.iubenda.com
	*/

	if(!function_exists('file_get_html')){
		include_once 'iubenda-cookie-class/simple_html_dom.php';
	}
	
	include_once 'iubenda-cookie-class/iubenda.class.php';

	DEFINE('DEBUG', 0);
	DEFINE('VOICE_MENU', 'Iubenda Cookie Solution');
	DEFINE('URL_MENU', str_replace(' ', '_', VOICE_MENU));
	DEFINE('IUB_REGEX_PATTERN', '/<!--IUB_COOKIE_POLICY_START-->(.*)<!--IUB_COOKIE_POLICY_END-->/sU');
	DEFINE('IUB_NO_PARSE_GET_PARAM', 'iub_no_parse');


	function iub_header(){
		ob_start();
		$iub_code = get_option('iub_code');
		$str = html_entity_decode(stripslashes($iub_code));
		
		if(!Page::consent_given() && !DEBUG || $_GET[IUB_NO_PARSE_GET_PARAM]){
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

		if(Page::consent_given() && !DEBUG || $_GET[IUB_NO_PARSE_GET_PARAM]){
			return $output;
		}
		
		$page = new Page($output);
		$page->parse();
		return $page->get_converted_page();
	}

	add_filter('final_output', '__final_output');


	function iub_func($atts, $content = "") {
		return '<!--IUB_COOKIE_POLICY_START-->'.do_shortcode($content).'<!--IUB_COOKIE_POLICY_END-->';
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
