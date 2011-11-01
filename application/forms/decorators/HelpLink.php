<?php
class Application_Form_Decorator_HelpLink extends Zend_Form_Decorator_Abstract{
    
	protected $_format = '<a href="#" id="%s-help" class="helplink"><img src="images/misc/question-mark.gif" alt="help text" /></a>';
	
    public function render($content)
    {
        $element = $this->getElement();
        $id      = htmlentities($element->getId());
        $name    = htmlentities($element->getFullyQualifiedName());
 
        $markup = sprintf($this->_format, $id);
 
        $placement = $this->getPlacement();
        $separator = $this->getSeparator();
        switch ($placement) {
            case self::PREPEND:
                return $markup . $separator . $content;
            case self::APPEND:
            default:
                return $content . $separator . $markup;
        }
    }
}