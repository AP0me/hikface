<?php
function xmlToJson($reponseXML){
  return json_decode(json_encode(new SimpleXMLElement($reponseXML)));
}