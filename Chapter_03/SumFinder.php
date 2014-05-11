<?php
/**
 * Returns largest sum of contiguous integers
 * @param array $inputArray
 * @return array
 */
function sumFinder(array $inputArray)
{
    $arrayGroups = array();

    foreach ($inputArray as $element) {
        //initial settings
        if (!isset($previousElement)) {
            $previousElement = $element;
            $arrayGroupNumber = 0;
        }

        if (($previousElement + 1) != $element){
            $arrayGroupNumber += 1;
        }

        $arrayGroups[$arrayGroupNumber][] = $element;
        $previousElement = $element;
    }

    usort($arrayGroups,'compareArrays');
    $highestGroup = array_pop($arrayGroups);

    return(array('group'=> implode(', ', $highestGroup),'sum'=>array_sum($highestGroup)));
}

/**
 * Custom array comparison method
 * @param array $a
 * @param array $b
 * @return int
 */
function compareArrays(array $a, array $b)
{
    $sumA = array_sum($a);
    $sumB = array_sum($b);

    if ($sumA == $sumB ){
        return 0;
    }
    elseif ($sumA > $sumB){
        return 1;
    }
    else {
        return -1;
    }
}