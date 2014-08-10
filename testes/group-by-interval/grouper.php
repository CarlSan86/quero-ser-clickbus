<?php

class Set
{
	/**
     * Number Set
     * 
     * @var array
     *
     */
    private $set = array(-10,-5,5,8,15,40,2,1,11,-85,4,10,23,65,74,55,100);

    /**
     * Set Getter
     * 
     * @return array
     *
     */
    public function getSet()
    {
        return $this->set;
    }

    /** Set Setter
     * 
     * @param array $set
     *
     */
    public function setSet(array $set)
    {
        $this->set = $set;
    }   

}

class Grouper
{

	/**
     * 
     * @var set
     */
    private $set;

	/**
     *
     * You can configure a different set upon instantiation
     * if none is given, the default is used.
     *
     */
    public function __construct(Array $differentSet = null)
    {
    	if ($differentSet === null) {
    		$set = new Set;
    		$this->set = $set->getSet();
    	}
    	else{
    		$newSet = new Set;
    		$newSet->setSet($differentSet);
    		$this->set = $newSet->getSet();
    	}        
    }

    /**
     *
     * Simple ordering function
     * substitute for sort
     *
     */
    private function orderSet($set){

    	for($i = 0; $i < count($set); $i++){
            for($j = 1; $j <= $i; $j++){
                if($set[$j-1] > $set[$j]){
                    $value = $set[$j-1];
                    $set[$j-1] = $set[$j];
                    $set[$j] = $value;
                }

            }
        }

        return $set;
    }

    /**
     *
     * Main function
     * Validates that all values in array are int
     * and proceeds to classify each number by the interval
     * return JSON with classified set
     *
     */
    public function groupSetByInterval($interval){
    	if (array_filter($this->set, 'is_int') === $this->set) {
    		$set = $this->orderSet($this->set);
	        
	        for($i=0; $i < count($set); $i++){
	            $index = intval(($set[$i]-1)/$interval);
	            $setGrouped[$index][] = $set[$i];
	        }

	        $cleanSet = array();

	        foreach ($setGrouped as $index => $subSet) {
	        	array_push($cleanSet, $subSet);
	        }

    		$return = $cleanSet;
    	}
    	else{
    		throw new Exception('InvalidArgumentException');
    	}

    	return json_encode($return);    	
    }
}
