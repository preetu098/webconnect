<?php

function dd($data)
{
    echo "<pre>"; print_r($data);
}

function send_smtp_mail($from, $to, $subject, $message) {
    $CI = &get_instance();

    $CI->load->library('email');

    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.mailgun.org',
        'smtp_port' => 465,
        'smtp_user' => 'no-reply@www.riskbirbal.com',
        'smtp_pass' => '2bbd0bd12759bc744b5b79bec50fb983-1b237f8b-5678608a',
        'mailtype'  => 'html', 
        'charset'   => 'iso-8859-1'
    );

    $CI->email->initialize($config);
    $CI->email->set_newline("\r\n");

    $CI->email->from($from); 
    $CI->email->to($to);
    $CI->email->subject($subject); 
    $CI->email->message($message); 

    //Send mail 
    if($CI->email->send()) {
        return true;
    }
    return false;
}

function getBounceStatus($email) {

    $email = str_replace(' ', '', $email);
    
    $apiKey = 'f1219d6056657826694a248409bf50c8-19f318b0-15ec56f5';
    $domain = 'www.riskbirbal.com';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mailgun.net/v3/'.urlencode($domain).'/bounces/'.urlencode($email),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.base64_encode('api:'.$apiKey)
        ),
    ));

    $email.' '.$response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);
    return (!empty($response) && is_array($response) && isset($response['address'])) ? true : false;
}

function getStatusMap($status) {
    $statuses = [
        '3' => 'Hr Approval Pending',
        '2' => "Under process",
        '0' => "Inactive",
        "1" => "Active",
        "4" => "Rejected by HR"
    ];
    return (isset($statuses[$status])) ? $statuses[$status] : "";
}

function getDMYDate($date, $time=true) {
    if(empty($date)) {
        return '';
    }
    if($time){
       return date("d-m-Y h:i A", strtotime($date));
    }
    return date("d-m-Y", strtotime($date));
}

function getEmployeeStatus($id, $rel) {
    $status = null;
    $mode = null;
    $CI = &get_instance();
    $CI->load->model('');

    if($rel == 'Self') {
        $emp = $CI->qm->single("ri_employee_tbl","*",array('eid'=>$id, 'relation'=>$rel));
    } else {
        $emp = $CI->qm->single("ri_dependent_tbl","*",array('did'=>$id, 'reltype'=>$rel));
    }
    if($emp) {
        $status = $emp->status;
        $mode = $emp->mode;
    }
    return [
        'status' => $status,
        'statustext' => getStatusMap($status),
        'mode' => $mode
    ];
}

function updateKidIndex($cid, $pid, $eid, $relation) {
    $CI = &get_instance();

    $dup = $CI->qm->all('ri_dependent_tbl','*',array('cid'=>$cid, 'pid'=>$pid,'eid'=>$eid,'reltype'=>$relation));
                                
    $kidMaxInd = (count($dup) > 0) ? max(array_column($dup, 'rel_index')) : null;

    $rel_index = (!empty($kidMaxInd)) ? $kidMaxInd : 0;

    foreach($dup as $key => $val) {
        if(is_null($val->rel_index)) {
            if($key == 0) {
                $rel_index = (is_null($kidMaxInd)) ? $rel_index : $rel_index + 1;
            } else {
                $rel_index = $rel_index + 1;
            }
            
            $CI->qm->update('ri_dependent_tbl',['rel_index' => $rel_index],['did' => $val->did]);
        }
    }
}

function dump_data($data) {
    echo "<pre>";print_r($data);exit;
}

function diffBtDate($date)
{
    $date2 = date('Y-m-d');

    $diff = abs(strtotime($date2) - strtotime($date));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    return $days;
}

function getYMDDate($date)
{
    return date('Y-m-d',strtotime($date));
}

function getMax($cid, $pid)
{
    $CI = &get_instance();
    $periodScales = $CI->qm->all('short_period_scales','*',array('cid'=>$cid, 'pid'=>$pid));
        
    $max_val = max(array_column($periodScales, 'upto_days'));
    return $max_val;
}

function findDuplicate($data)
{
    $CI = &get_instance();
}