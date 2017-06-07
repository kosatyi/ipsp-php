<?php

/**
 * Class Ipsp_XmlData
 */
class Ipsp_XmlData extends \SimpleXMLElement{
    /**
     * @param array $array
     */
    public function arrayToXml($array=array()){
        foreach($array as $key=>$val) {
            if(is_numeric($key)) continue;
            if(is_array($val)) {
                $node = $this->addChild($key);
                $node->arrayToXml($val);
            } else {
                $this->addChild($key,$val);
            }
        }
    }
    /**
     * @return array
     */
    public function xmlToArray(){
        $result   = array();
        $children = $this->children();
        foreach($children as $item){
            if($item->count()>0)
                $result[$item->getName()] = $item->xmlToArray();
            else
                $result[$item->getName()] = (string)$item;
        }
        return $result;
    }
}