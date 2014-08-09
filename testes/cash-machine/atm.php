<?php

class Bills
{
	/**
     * Bills available
     * 
     * @var array
     *
     */
    private $bills = array(10, 20, 50, 100);

    /**
     * Bills Getter
     * 
     * @return array
     *
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * Bills Setter
     * 
     * @param array $bills
     *
     */
    public function setBills(array $bills)
    {
        $this->bills = $bills;
    }   

}

class Atm
{
    /**
     * 
     * @var Bills
     */
    private $bills;

	/**
     *
     * You can configure a different set of bills upon instantiation
     * if none are given, the default is used.
     *
     */
    public function __construct(Array $differentBills = null)
    {
    	if ($differentBills === null) {
    		$bills = new Bills;
    		$this->bills = $bills->getBills();
    	}
    	else{
    		$newBills = new Bills;
    		$newBills->setBills($differentBills);
    		$this->bills = $newBills->getBills();
    	}        
    }

    /**
     *
     * Validates that amount to withdraw is int, a natural number
     * and divisible by the smallest bill in the machine
     *
     */
    private function isWithdrawable($amount)
    {
    	if ($amount % min($this->bills) === 0 && $amount > 0 && is_int($amount))
    	{
    		return true;
    	}
    	else{
    		return false;
    	}

    }

    /**
     *
     * Orders array from largest to smallest to get least amount of bills
     * selects amount of bills per denomination
     *
     */
    private function selectBills($amount)
    {
    	$orderedBills = $this->bills;
    	rsort($orderedBills);
    	for ($i=0; $i < count($orderedBills); $i++) { 
    		$totalBills = intval($amount / $orderedBills[$i]);
    		$amount -= $totalBills*$orderedBills[$i];
    		$withdrawal[$orderedBills[$i]] = $totalBills;
    	}

    	return $withdrawal;
    	
    }

    /**
     *
     * Main function
     * Validates the amount and if valid, proceeds with the withdrawal
     *
     */
    public function withdrawMoney($amount)
    {
		if($this->isWithdrawable($amount))
		{
			return json_encode($this->selectBills($amount));
		}
		else{

			return "Please withdraw amounts divisible by ".min($this->bills);
		}
    }

}

