<?php

class Text_Wiki_Render_Xhtml_Interwiki extends Text_Wiki_Render {
	
	var $conf = array(
		'sites' => array(
			'MeatBall' => 'http://www.usemod.com/cgi-bin/mb.pl?%s',
			'Advogato' => 'http://advogato.org/%s',
			'Wiki'	   => 'http://c2.com/cgi/wiki?%s'
		),
		'target' => '_blank'
	);
	
	
    /**
    * 
    * Renders a token into text matching the requested format.
    * 
    * @access public
    * 
    * @param array $options The "options" portion of the token (second
    * element).
    * 
    * @return string The text rendered from the token options.
    * 
    */
    
    function token($options)
    {
        $site = $options['site'];
        $page = $options['page'];
        $text = $options['text'];
        
        if (isset($this->conf['sites'][$site])) {
            $href = $this->conf['sites'][$site];
        } else {
            return $text;
        }
        
		// old form where page is at end,
		// or new form with %s placeholder for sprintf()?
		if (strpos($href, '%s') === false) {
			// use the old form
			$href = $href . $page;
		} else {
			// use the new form
			$href = sprintf($href, $page);
		}
		
		// allow for alternative targets
		$target = $this->getConf('target');
        
        // build base link
		$text = htmlspecialchars($text);
		$output = "<a href=\"$href\"";
		
		if ($target) {
			// use a "popup" window.  this is XHTML compliant, suggested by
			// Aaron Kalin.  uses the $target as the new window name.
			$target = htmlspecialchars($target);
			$output .= " onclick=\"window.open(this.href, '$target');";
			$output .= " return false;\"";
		}
		
		$output .= ">$text</a>";
		
		return $output;
    }
}
?>