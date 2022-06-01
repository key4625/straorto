<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Arr;
use Carbon\Carbon;
use DB;
use Livewire\Component;
class Ordinisintesi2 extends Component
{
    public $filter_consegnato, $filter_pagato, $filter_data, $datafilter;
    public $tmparray, $tmparray2;

    public function mount()
    {
        $this->filter_consegnato="da_consegnare";
        $this->filter_data="settimana";
    }
    public function render()
    {
        $orders_list = Order::query();
        if($this->filter_consegnato=="da_consegnare") $orders_list->where("evaso",0);
        if($this->filter_data=="oggi") {
            $orders_list->whereDate("data",Carbon::now()->toDateString());
        }
        if($this->filter_data=="domani"){ 
            $orders_list->whereDate("data",Carbon::tomorrow()->toDateString());
        }
        if($this->filter_data=="settimana") {
            $orders_list->whereDate("data",">",Carbon::now()->toDateString());
            $orders_list->whereDate("data","<",Carbon::now()->adddays(7)->toDateString());
        }
        $orders_list->orderby('data');
        $arr_plants = array();
        foreach($orders_list->get() as $single_order){
            foreach($single_order->plants()->get() as $single_item){
                $trovato = 99;
                foreach($arr_plants as $key=>$value){
                     if(($value['item_id'] == $single_item->id)&&($value['quantity_um'] == $single_item->pivot->quantity_um)){
                        $trovato = $key;   
                    }
                }
                if($trovato != 99){
                    $arr_plants[$trovato]['quantity'] += $single_item->pivot->quantity;
                } else {
                    $new_item = array('item_id'=>$single_item->id, 'type'=>'vegetables','name' => $single_item->nome, 'image' => $single_item->image, 'quantity'=> $single_item->pivot->quantity, 'quantity_um'=> $single_item->pivot->quantity_um, 'price_um'=> $single_item->pivot->price_um,'price'=>$single_item->pivot->price);
                    array_push($arr_plants, $new_item);
                }        
            }   
        }
        $arr_products = array();
        foreach($orders_list->get() as $single_order){
            foreach($single_order->products()->get() as $single_item){
                $trovato = 99;
                foreach($arr_products as $key=>$value){
                     if(($value['item_id'] == $single_item->id)&&($value['quantity_um'] == $single_item->pivot->quantity_um)){
                        $trovato = $key;   
                    }
                }
                if($trovato != 99){
                    $arr_products[$trovato]['quantity'] += $single_item->pivot->quantity;
                } else {
                    $new_item = array('item_id'=>$single_item->id, 'type'=>'vegetables','name' => $single_item->nome, 'image' => $single_item->image, 'quantity'=> $single_item->pivot->quantity, 'quantity_um'=> $single_item->pivot->quantity_um, 'price_um'=> $single_item->pivot->price_um,'price'=>$single_item->pivot->price);
                    array_push($arr_products, $new_item);
                }        
            }   
        }
        //$query_sql = 'select sum(orderables.quantity), plants.* from plants inner join orderables on `orderables`.`orderable_id` = `plants`.`id` where orderables.order_id in (select id from orders where data = "2022-05-31") group by orderable_id, orderables.quantity_um';
        //$query_sql = 'SELECT sum(`single_item`.quantity), orderable_id, plants.* FROM `orderables` as `single_item` INNER JOIN `plants` on orderable_id = `plants`.id where order_id in (select id from orders where data = "'.Carbon::now()->toDateString().'") group by orderable_id, quantity_um';
       
        /*$res_query = DB::table('orderables')
            ->selectRaw('sum(orderables.quantity) as qt, orderables.quantity_um, orderable_id, plants.*')
            ->whereRaw('orderables.order_id in (select id from orders where data = "'.Carbon::now()->toDateString().'")')
            ->join('plants', 'orderables.orderable_id', '=', 'plants.id')
            ->groupByRaw('orderable_id, orderables.quantity_um')
            ->get();*/
        
        return view('livewire.ordinisintesi2',['plants' => $arr_plants,'products' => $arr_products]);
    }
}