<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgButtondeliverycondition extends JPlugin
{
    function plgButtondeliverycondition(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    function onDisplay($name)
    {
        //global $mainframe;

        $doc        =& JFactory::getDocument();
        //$template   = $mainframe->getTemplate();

        // button is not active in specific content components

        $getContent = $this->_subject->getContent($name);
        $present = JText::_('ALREADY EXISTS', true) ;
        $js = "
            function insertDeliveryCondition(editor) {
                var content = $getContent
                if (content.match(/\{plugin:deliveryCondition\}/i)) {
                    alert('$present');
                    return false;
                } else {
                    jInsertEditorText('{plugin:deliveryCondition}', editor);
                }
            }
            ";

        $doc->addScriptDeclaration($js);

        $button = new JObject();
        $button->set('modal', false);
        $button->set('onclick', 'insertDeliveryCondition(\''.$name.'\');return false;');
        $button->set('text', JText::_('DeliveryCondition'));
        $button->set('name', 'deliverycondition');
        // TODO: The button writer needs to take into account the javascript directive
        //$button->set('link', 'javascript:void(0)');
        $button->set('link', '#');

        return $button;
    }
}