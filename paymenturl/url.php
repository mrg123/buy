<?php
$acctnoxml=file_get_contents("./acctno.xml");
$str=  explode(",", $acctnoxml);
$key=$str[0];
$acctno=$str[1];
$md5key=  md5($key."-".$acctno);
if($_POST["ParAccNoSecKey"]==$md5key)
{
    file_put_contents("./payment.xml", $_POST["ParSplaceUrl"]);

    $array=array(
            "md5key"=>$md5key,
            "ParPGWID"=>$_POST["ParPGWID"],
        "status"=>"00",
            );
    $ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $_POST["ParGetUrl"]); 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $array); 
curl_exec($ch); 
curl_close($ch); 
}else{
    $array=array(
            "md5key"=>$md5key,
            "ParPGWID"=>$_POST["ParPGWID"],
        "status"=>"01",
            );
    $ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $_POST["ParGetUrl"]); 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $array); 
curl_exec($ch); 
curl_close($ch); 
}

?>