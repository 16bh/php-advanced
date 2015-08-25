<?php
class JsonApi{
    /*
     * 生成JSON格式的正确信息
     * */
    public static function jsonResult($content, $message = '', $append = array()){
        self::jsonResponse($content, 0, $message, $append);
    }



    /*
     * 生成JSON格式的错误信息
     * */
    public static function jsonError($msg){
        self::jsonResponse('', 1, $msg);
    }

    /*
     * 创建JSON格式的数据
     * */
    private static function jsonResponse($content = '', $error = "0", $message = '', $append = array()){
        $res = array(
            'error' => $error,
            'message' => $message,
            'content' => $content,
        );
        if(!empty($append)){
            foreach($append as $key => $val){
                $res[$key] = $val;
            }
        }
        $val = json_encode($res);
        exit($val);
    }
}


JsonApi::jsonResult('qwerty', 'cuowu');

?>
