<?php

class XML_Transformer {


function XML_Transformer() {
      //constructor, this does nothing
  }

function GetParsedResult($xmlFile,$xslFile) {

	//load the xml file in
	$inputdom = new DomDocument();
	$inputdom->load($xmlFile);

	//load the xsl file in
	$xsl = new DomDocument();
	$xsl->load($xslFile);

	//define the xslt processor
	$proc = new xsltprocessor;
	$xsl = $proc->importStylesheet($xsl);
	
	//parse it
	$newdom = $proc->transformToDoc($inputdom);
	$result = $newdom->saveXML();
	
	return $result;

}

}

?>