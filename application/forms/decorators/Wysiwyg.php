<?php
	
class Application_Form_Decorator_Wysiwyg extends Zend_Form_Decorator_Abstract{
    
    public function render($content)
    {
        $element = $this->getElement();
        $id      = htmlentities($element->getId());
        $name    = htmlentities($element->getFullyQualifiedName());
 
        $markup = $this->buildWysiwygScript($id, 620, 500);
 
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
    
    protected function buildWysiwygScript($textAreaId, $width, $height){
    	$wysiwygScript = 
    	"<script type=\"text/javascript\"> 
			var oEdit{$textAreaId} = new InnovaEditor(\"oEdit{$textAreaId}\");
			oEdit{$textAreaId}.css = \"/css/innova_main.css\";
			oEdit{$textAreaId}.width = \"{$width}px\";
			oEdit{$textAreaId}.height = \"{$height}px\";
			oEdit{$textAreaId}.features = [\"Preview\",\"Search\",
			\"Cut\",\"Copy\",\"Paste\",\"PasteWord\",\"|\",\"Undo\",\"Redo\",\"|\",
			\"ForeColor\",\"BackColor\",\"|\", \"Image\", \"Hyperlink\",\"XHTMLSource\",\"BRK\",
			\"Paragraph\", \"|\",
			\"Numbering\",\"Bullets\",\"|\",\"Indent\",\"Outdent\",\"|\",
			\"Characters\",\"Line\",\"RemoveFormat\",
			\"TextFormatting\",\"ListFormatting\",\"BoxFormatting\",
			\"ParagraphFormatting\",\"|\",
			\"Bold\",\"Italic\",\"Underline\", \"|\",
			\"JustifyLeft\",\"JustifyCenter\",\"JustifyRight\",\"JustifyFull\"];
			oEdit{$textAreaId}.cmdAssetManager = \"modalDialogShow('/assetmanager/assetmanager.php',640,445);\";
			oEdit{$textAreaId}.mode = \"XHTMLBody\";
			oEdit{$textAreaId}.REPLACE(\"{$textAreaId}\");
		</script>";	
    	return $wysiwygScript;
    }
}
