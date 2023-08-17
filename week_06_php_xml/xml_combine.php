<?php

include("xml_class.php");

$xml_mash = new XML_Transformer();

$xml_result = $xml_mash->GetParsedResult("xml_list.xml", "xsl_file.xsl");

echo($xml_result);

?>