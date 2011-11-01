<?php
class Application_Form_Decorator_FloatFix extends Zend_Form_Decorator_Abstract{
    
    public function render($content)
    {
        $element = $this->getElement();
        $id      = htmlentities($element->getId());
        $name    = htmlentities($element->getFullyQualifiedName());
 
        $markup = '<br style="clear:both"/>';
 
        $placement = $this->getPlacement();
        $separator = $this->getSeparator(); 
      	return $markup . $separator . $content . $separator . $markup;
    }
}