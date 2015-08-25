<?php
    $arr = array(
        'one_1' => array(
            'id' => 1, 'pid' => 0, 'name' => '行业导航', 'color' => 'red',
            'two_1' => array(
                'id' => 5, 'pid' => 1, 'name' => '技能', 'color' => 'blue',
                'three_1' => array(
                    'id' => 8, 'pid' => 5, 'name' => '驾驶', 'color' => 'blue',
                ),
                'three_2' => array(
                    'id' => 9, 'pid' => 5, 'name' => '厨师', 'color' => 'blue',
                ),
                'three_3' => array(
                    'id' => 10, 'pid' => 5, 'name' => '美容', 'color' => 'blue',
                ),
            ),
            'two_2' => array(
                'id' => 6, 'pid' => 1, 'name' => '语言', 'color' => 'blue',
                'three_1' => array(
                    'id' => 11, 'pid' => 6, 'name' => '雅思', 'color' => 'blue',
                ),
                'three_2' => array(
                    'id' =>12, 'pid' => 6, 'name' => '托福', 'color' => 'blue',
                ),
                'three_3' => array(
                    'id' => 13, 'pid' => 6, 'name' => '口语', 'color' => 'blue',
                ),
            ),
            'two_3' => array(
                'id' => 7, 'pid' => 1, 'name' => '证书', 'color' => 'blue',
                'three_1' => array(
                    'id' => 14, 'pid' => 5, 'name' => '会计', 'color' => 'blue',
                ),
                'three_2' => array(
                    'id' => 15, 'pid' => 5, 'name' => '教师', 'color' => 'blue',
                ),
                'three_3' => array(
                    'id' => 16, 'pid' => 5, 'name' => '导游', 'color' => 'blue',
                ),
            ),    
        ),
/*
        'one_2' => array(
            'id' => 2, 'pid' => 0, 'name' => '外语培训', 'color' => 'red',
        ),

        'one_3' => array(
            'id' => 3, 'pid' => 0, 'name' => '职业技能', 'color' => 'red',
        ),

        'one_4' => array(
            'id' => 4, 'pid' => 0, 'name' => '资格认证', 'color' => 'red',
        ),
*/
    );

var_dump($arr);
?>
