<?php
/**
 * @version 3.0.1
 * @package embedia (formerly mosEasyMedia)
 * @copyright Copyright &copy; 2009, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 */


/**
 *
 * Some Error Codes
 */

DEFINE ('INVALID_FORMAT', '<p class="embedia_error">Invalid format. Please use { embedia media=path_to_your_file .....} format to properly render your media<br/>You can always contact us at our support <a href="http://forum.brilaps.com/" target="null">forum</a></p>');

DEFINE ('INVALID_ATTRIBUTE', '<p class="embedia_error">Invalid attribute. Valid attributes are ' . implode(', ', embediaVars::$VALID_OVERRIDE_ATTRIBUTES). '<br/>You can always contact us at our support <a href="http://forum.brilaps.com/" target="null">forum</a></p>');

DEFINE ('MISSING_PIECES', '<p class="embedia_error">Missing pieces in your embedia code. Please use { embedia media=path_to_your_file .....} format to properly render your media<br/>You can always contact us at our support <a href="http://forum.brilaps.com/" target="null">forum</a></p>');

DEFINE ('INVALID_PLAYER_HANDLER', '<p class="embedia_error">Invalid player handler. Valid player attributes are ' . implode(', ', embediaVars::$SUPPORTED_MEDIA_PLAYERS). '<br/>You can always contact us at our support <a href="http://forum.brilaps.com/" target="null">forum</a></p>');

DEFINE ('IMPOSSIBLE_ERROR', '<p class="embedia_error">Congrats! You accomplished quite the impossible. You should never see this error on your page, but incase you see it, please contact us at our support <a href="http://forum.brilaps.com/" target="null">forum</a></p>');

/**
 * Regular Expression find embedia (or moseasymedia) occurances
 */
DEFINE('DEFAULT_EMBEDIA_FIND_REGEXP', '/\{(embedia)(.*?)\}/i');

DEFINE('DEFAULT_EMBEDIA_MOSEASYMEDIA_FIND_REGEXP', '/\{(embedia|moseasymedia)(.*?)\}/i');

/**
 * Regular Expression to parse the atributes of the mambot. i.e. media=blah.mpg height=100 width=120 window="pop"
 */
DEFINE ('DEFAULT_EMBEDIA_PARSE_ATTRIB_REGEXP', '/(\w+)\s*=\s*((".*?")|(\'.*?\')|([^\s]+))/mi');

/**
 * Regular Expression to match/parse {embedia .....} attribs
 */
DEFINE ('DEFAULT_EMBEDIA_PARSE_REGEXP', '/\{(embedia|moseasymedia)\s+' . DEFAULT_EMBEDIA_PARSE_ATTRIB_REGEXP . '\}/mi');
