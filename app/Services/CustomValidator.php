<?php namespace App\Services;
use DateTime;

class CustomValidator extends \Illuminate\Validation\Validator
{
    public function validateFoo($attribute,$value,$parameters){
        return $value == "foo";
    }

    public function validateBoo($attribute,$value,$parameters){
        return $value == "boo";
    }
    
    public function validateDatecheck($attribute,$value,$parameters){
        
        $starttime = $this->getValue('starttime');
        $endtime = $this->getValue('endtime');
        $date_borders = $this->getValue('date_borders');
        $date = $this->getValue('target_date');
        
        $starttime = new DateTime($date." ".$starttime);
        $endtime = new DateTime($date." ".$endtime);
        
        
        if($date_borders == 'next_day') {
            $endtime = $endtime->modify('+24 hours');
        }
        
        
        
        if($starttime >= $endtime) {
            return false;
        }
        
        
        
        return true;
    }
}