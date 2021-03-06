<?php

// use the following in another file to use random function:
// 
// $myRandom = new irandom();
// echo $myRandom->rand_string(17);



class irandom{
    function rand_string($length){
        $key = '';
        $keys = array_merge(range(0,9),range('A',"Z"));
        for($i=0;$i<$length;$i++){
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }
}

?>
