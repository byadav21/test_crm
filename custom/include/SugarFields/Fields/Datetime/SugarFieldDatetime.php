<?php
require_once('include/SugarFields/Fields/Datetime/SugarFieldDatetime.php');

class CustomSugarFieldDatetime extends SugarFieldDatetime
{
    function getListViewSmarty($parentFieldArray, $vardef, $displayParams, $col) 
    {
        $tabindex = 1;
        $isArray = is_array($parentFieldArray);
        $fieldName = $vardef['name'];

        if ($fieldName == 'DATE_ENTERED') {
            if ( $isArray ) {
                $parentFieldArray[$fieldName] = $GLOBALS['timedate']->getDatePart($parentFieldArray[$fieldName]);
            }
            else {
                $parentFieldArray->$fieldName = $GLOBALS['timedate']->getDatePart($parentFieldArray->$fieldName);
            }
        }

        if ( $isArray ) {
            $fieldNameUpper = strtoupper($fieldName);
            if ( isset($parentFieldArray[$fieldNameUpper])) {
                $parentFieldArray[$fieldName] = $this->formatField($parentFieldArray[$fieldNameUpper],$vardef);
            } else {
                $parentFieldArray[$fieldName] = '';
            }
        } else {
            if ( isset($parentFieldArray->$fieldName) ) {
                $parentFieldArray->$fieldName = $this->formatField($parentFieldArray->$fieldName,$vardef);
            } else {
                $parentFieldArray->$fieldName = '';
            }
        }
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);

        $this->ss->left_delimiter = '{';
        $this->ss->right_delimiter = '}';
        $this->ss->assign('col',$vardef['name']);

        return $this->fetch($this->findTemplate('ListView'));
    }
}
?>
