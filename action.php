<?php
/**
 * InToc-Plugin: Renders the page's toc inside the page content
 * Reworked form broken https://www.dokuwiki.org/plugin:inlinetoc
 *
 * @license GPL v2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Vincent Tscherter and previous
 */

use dokuwiki\Extention\ActionPlugin;

class action_plugin_intoc extends DokuWiki_Action_Plugin {

    /**
     * Register event handlers
     */
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_ACT_RENDER', 'BEFORE', $this, 'handle_act_render', array());
        $controller->register_hook('RENDERER_CONTENT_POSTPROCESS', 'AFTER', $this, 'handle_renderer_content_postprocess', array());
    }
   
	/**
	 * Make sure the other toc is not printed
	 */
    function handle_act_render(&$event, $param) {
        global $ID;
        global $INFO;
        if (p_get_metadata($ID, 'movetoc')) {
            $INFO['prependTOC'] = false;
        }
    }

    /**
     * Replace our placeholder with the actual toc content
     */
    function handle_renderer_content_postprocess(&$event, $param) {
        global $TOC;
        global $lang;
        if ($TOC) {
            $html = '<details open class="intoc"><summary>'.$lang['toc'].'</summary>'
                . html_buildlist($TOC, 'intoc', array($this, 'html_list_intoc'))
                . '</details>';
            $event->data[1] = str_replace('<!-- INTOCTARGET -->',
                                          $html,
                                          $event->data[1]);
        }
    }


	/**
	 * Callback for html_buildlist.
	 * Builds list items with intoc printable class instead of dokuwiki's toc class which isn't printable.
	 */
	function html_list_intoc($item){
	    if(isset($item['hid'])){
	        $link = '#'.$item['hid'];
	    }else{
	        $link = $item['link'];
	    }
	    return '<span class="li"><a href="'.$link.'" class="intoc">'. hsc($item['title']).'</a></span>';
	}
}