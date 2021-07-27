<?php



class EscaleraService
{

    public function execute($n){
        if($n===null || !is_numeric($n) || $n==0  ) throw new InvalidArgumentException("Debe ser un Entero mayor que 0");
        return $this->stepsCombination($n,0);
    }

    private function stepsCombination($n,$counter){
        if($n==1)
            return 1;
        if($n>0)
            return $this->stepsCombination($n-1,$counter+1)+$this->stepsCombination($n-2,$counter+1);
        if($n<0)
            return 0;
        return 1;
    }
}