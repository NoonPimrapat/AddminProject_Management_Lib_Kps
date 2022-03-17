<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/16/2022.
 *  on 3:35 PM.
 */


/**
 * @param array $data
 * @return array
 */

function getBudgetFormat($data = []) {
    $budgets = [];
    foreach ($data as $key => $value) {
        if(in_array($key,['compensation','cost','material'])){
            $buffBudgets = [];
            foreach($value as $sk => $sv){
//                var_export($value);
//                exit;
                if(in_array($sk,['item','quantity','price'])){
//                    var_export(count($value));exit;
                    foreach ($sv as $index => $val) {
                        if(trim($val) !== '') {
                            $buffBudgets[$index][$sk] = $sv[$index];
                            if(empty($buffBudgets[$index]['budget_group'])) {
                                $buffBudgets[$index]['budget_group'] = $key;
                            }
                        }else{
                            unset($buffBudgets[$index]);
                            break;
                        }

                    }
                }
            }
            $budgets = array_merge($budgets,$buffBudgets);
        }
    }
    return $budgets;
}


function getPlantFormat($data = []){
    $plants =[];
    foreach ($data as $key => $value) {
        if(in_array($key,['plant_detail','plant_time','plant_location'])) {
            foreach ($value as $index => $val) {
                if(trim($val) !== '') {
                    $plants[$index][$key] = $val;
                }
            }
        }

    }
    return $plants;
}

function convert($number)
{
    $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
    $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
    $number = str_replace(array(",", " ", "บาท"), "", $number);
    $number = explode(".",$number);
    if(count($number)>2){
        return false;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for($i=0;$i<$strlen;$i++){
        $n = substr($number[0], $i,1);
        if($n!=0){
            if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
            elseif($i==($strlen-2) AND $n==2){ $convert .= 'ยี่'; }
            elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
            else{ $convert .= $txtnum1[$n]; }
            $convert .= $txtnum2[$strlen-$i-1];
        }
    }
    $convert .= 'บาท';
    if( empty($number[1]) || $number[1]=='0' || $number[1]=='00' || $number[1]==''){
        $convert .= 'ถ้วน';
    }else{
        $strlen = strlen($number[1]);
        for($i=0;$i<$strlen;$i++){
            $n = substr($number[1], $i,1);
            if($n!=0){
                if($i==($strlen-1) AND $n==1){$convert .= 'เอ็ด';}
                elseif($i==($strlen-2) AND $n==2){$convert .= 'ยี่';}
                elseif($i==($strlen-2) AND $n==1){$convert .= '';}
                else{ $convert .= $txtnum1[$n];}
                $convert .= $txtnum2[$strlen-$i-1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}

function DateThai($submit_date)
{
    $strYear = date("Y",strtotime($submit_date))+543;
    $strMonth= date("n",strtotime($submit_date));
    $strDay= date("j",strtotime($submit_date));
    $strHour= date("H",strtotime($submit_date));
    $strMinute= date("i",strtotime($submit_date));
    $strSeconds= date("s",strtotime($submit_date));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    //  return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}