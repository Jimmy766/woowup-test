<?php

require '../vendor/autoload.php';
use Carbon\Carbon;
use MathPHP\Statistics\Average;

class RecompraService
{
    public function execute($purchases){
        $newPurchases=$this->formatPurchases($purchases);
        $newPurchases=$this->removeUniquePurchases($newPurchases);

        return array_map($this->mapNextPurchase(),array_keys($newPurchases),$newPurchases);

    }
    private function formatPurchases($purchases){
        $newPurchases=array();
        foreach($purchases as $purchase){
            foreach($purchase['products'] as $product){
                $newPurchases[$product['sku']]['count']=
                    !isset($newPurchases[$product['sku']]['count'])? 1: $newPurchases[$product['sku']]['count']+1;

                $newPurchases[$product['sku']]['dates']=
                    !isset($newPurchases[$product['sku']]['dates'])? array($purchase['date']):
                        array_merge($newPurchases[$product['sku']]['dates'],[$purchase['date']]);
                $newPurchases[$product['sku']]['name']= $product['name'];

            }
        }
        return $newPurchases;
    }

    private function removeUniquePurchases($purchases){
        return array_filter($purchases,function($purchase){
            return $purchase['count']>1;
        });
    }
    private function mapNextPurchase():callable{
        return function($key,$item){
            $newItem=[];
            $newItem["sku"]=(string)$key;
            $newItem["name"]=$item['name'];
            $newItem["next_purchase_date"]=$this->nextPurchase($item['dates']);
            return $newItem;
        };
    }
    private function nextPurchase($dates){
        $daysBetween=[];
        $count=count($dates);
        $lastDate=new Carbon($dates[$count-1]);
        for($i=0; $i<$count-1;$i++){
            $date_first=new Carbon($dates[$i]);
            $date_second=new Carbon($dates[$i+1]);
            $difference=$date_second->diffInDays($date_first);
            $daysBetween[]=$difference;
        }
        $nextPurchase=Average::mode($daysBetween)[0];
        return $lastDate->addDays($nextPurchase)->format("yy-m-d");
    }



}