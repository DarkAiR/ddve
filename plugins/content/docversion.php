<?php
/**
 * @version    1.00.0002 SVN: $Id: header.php 80 2010-03-21 12:52:39Z dw.ilya $
 * @package    DocVersion
 * @subpackage Base
 * @author     Factory.DocWriter.Ru {@link http://factory.docwriter.ru/}
 * @author     Created on 28-May-2011
 * @copyright  2011 Factory.DocWriter.Ru
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since      File available since Release 1.00
 */

//-- No direct access
defined('_JEXEC') or die('Direct access not alowed.');

class plgContentDocVersion extends JPlugin {
    
    // 1.5 LEGACY METHODS
    function onBeforeDisplayContent (&$row, &$params, $limitstart) {
        
        return $this->onContentBeforeDisplay(null, $row, $params, $limitstart); 
    }
    //
    
    function _getRequestVersion () {
        
        static $result;
        
        if (!isset($result)) $result = JRequest::getVar('docver', '');
        
        return $result;
    }
    
    function _isVisible ($versionFrom, $versionTo) {
        
        $result = null;
        
        $requestVersion = $this->_getRequestVersion();
        
        if ($requestVersion != '') {
            // Version requested explicitly
            if ($versionFrom != '' and $versionTo != '') {
                if (version_compare($requestVersion, $versionFrom, '>=')
                    and version_compare($requestVersion, $versionTo, '<')) {
                    $result = true;
                } else {
                    $result = false;
                }
            } elseif ($versionFrom == '' and $versionTo != '') {
                if (version_compare($requestVersion, $versionTo, '<')) {
                    $result = true;
                } else {
                    $result = false;
                }
            } elseif ($versionFrom != '' and $versionTo == '') {
                if (version_compare($requestVersion, $versionFrom, '>=')) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }
        } else {
            // Defaults to last version
            if ($versionFrom != '' and $versionTo == '') {
                $result = true;
            } else {
                $result = false;
            }
        }
        
        return $result;
    }
    
    /**
     * DocVersion before display content method
     */
    function onContentBeforeDisplay($context, &$row, &$params, $limitstart)
    { 
        if( ! strpos($row->text, '{docversion'))
        {
            //--The tag is not found in content - abort..
            return;
        }
    
        $pattern = '/\{docversion\s*:\s*(.*?)(?:-(.*?))?\s*?\}(.*?)\{\/docversion\}/ims';
        $blocks = array();
        
        preg_match_all($pattern, $row->text, $blocks);
        
        for ($i = 0; $i <= sizeof($blocks[0]) - 1; $i++) {
            $curBlock   = $blocks[0][$i];
            $curFrom    = $blocks[1][$i];
            $curTo      = $blocks[2][$i];
            $curContent = $blocks[3][$i];
            if ($curBlock) {
                $curSub = $this->_isVisible($curFrom, $curTo) ? $curContent : '';
                $curPos = strpos($row->text, $curBlock);
                $curLen = strlen($curBlock);
                if ($curPos > 0) {
                    $row->text = substr_replace($row->text, $curSub, $curPos, $curLen);
                }
            }
        }
        
        return;
    }//function
}