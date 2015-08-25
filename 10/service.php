<?php
/**
 * @author: chenxi
 * @date: 2015-08-17
 * @version: $Id$
 */
if(isset($_POST['format'])){
    switch($_POST['format']){
        case 'csv':
            $type = 'text/csv';
            break;
        case 'json':
            $type = 'application/json';
            break;
        case 'xml':
            $type = 'text/xml';
            break;
        default:
            $type = 'text/plain';
            break;
    }

    $data = array();
    $data['timestamp'] = time();

    foreach($_POST as $k => $v){
        $data[$k] = $v;
    }

    if($type == 'application/json'){
        $output = json_encode($data);
    }elseif($type == 'text/csv'){
        $output = '';
        foreach($data as $v){
            $output .= '"'.$v.'",';
        }
        $output = substr($output, 0, -1);
    }elseif($type == 'text/plain'){
        $output = print_r($data, 1);
    }
}else{
    $type = 'text/plain';
    $output = 'this service has been incorrectly used.';
}

header("Content-Type:$type");
echo $output;