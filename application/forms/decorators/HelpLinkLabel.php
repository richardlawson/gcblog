<?php
class Application_Form_Decorator_HelpLinkLabel extends Zend_Form_Decorator_Abstract{
    
	protected $_format = '<dt id="%s-label"><label for="%s">%s&nbsp;<span class="highlighted">*</span>&nbsp;<a href="#" id="%s-help" class="helplink"><img src="/images/misc/question-mark.gif" alt="help" /></a></label></dt>';
 
    public function render($content)
    {
        $element = $this->getElement();
        $id      = htmlentities($element->getId());
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
 
        $markup = sprintf($this->_format, $name, $id, $label, $id);
 
        $placement = $this->getPlacement();
        $separator = $this->getSeparator();
        switch ($placement) {
            case self::APPEND:
                return $markup . $separator . $content;
            case self::PREPEND:
            default:
                return $content . $separator . $markup;
        }
    }
}