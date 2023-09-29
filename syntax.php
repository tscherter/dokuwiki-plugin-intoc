<?php
/**
 * InToc-Plugin: Renders the page's toc inside the page content
 * Reworked form broken https://www.dokuwiki.org/plugin:inlinetoc
 *
 * @license GPL v2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Vincent Tscherter and previous
 */

use dokuwiki\Extention\SyntaxPlugin;

class syntax_plugin_intoc extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType() {
        return 'substition';
    }

    /**
     * Where to sort in? (took the same as for ~~NOTOC~~)
     */
    function getSort() {
        return 30;
    }
    
    /**
     * What kind of type are we?
     */
    function getPType() {
            return 'block';
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~INTOC~~', $mode, 'plugin_intoc');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        return '';
    }

    /**
     * Add placeholder to cached page (will be replaced by action component)
     */
    function render($mode, Doku_Renderer $renderer, $data) {
    	
    	if ($mode == 'metadata') {
			$renderer->meta['movetoc'] = true;
			return true;
		}
    
        $renderer->doc .= '<!-- INTOCTARGET -->';
    }
}
