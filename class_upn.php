<?php
Class upn { 

	  private $binchar= "0123456789";
     private $upnchar = "0123456789ABCDEFGHJKLMNPQRTUVWXY";
     
public function decode($upn){
$replacements = array('O' => '0','I' => '1','S' => '5');
list($lng, $lat) = @explode("-", str_replace(array_keys($replacements), $replacements, strtoupper($upn)));
if (isset($lng) & isset($lat))
{
$lngstring = $this->changebase($lng,$this->upnchar,$this->binchar);
$latstring = $this->changebase($lat,$this->upnchar,$this->binchar);
$lat = (($latstring*9/50000)-90);
$lng = ($lngstring/(10000*sin(deg2rad(abs($lat)+90)))) -180;
		if (($lat >= -90 && $lat <= 90) && ($lng >= -180 && $lng <= 180)){
				return $lng.",".$lat;}
		else {return "Error: Bad UPN";}
}

else {return "Error : Bad UPN";}

}

//public function ShowPlotnumber($upn,$parameter){
//return array plot and KMZ information about it in global Database
//its UPN
#}

#public function createplot($upn,$boundary,$information){

#}



public function code($lng,$lat){

if (($lat >= -90 && $lat <= 90) && ($lng >= -180 && $lng <= 180)) 
{
$lngstring = (string)(10000*round(($lng+180)*sin(deg2rad($lat+90)),4,PHP_ROUND_HALF_UP));
$latstring= (string)(10000*round (($lat+90)*5/9,4,PHP_ROUND_HALF_UP));

return $this->changebase($lngstring,$this->binchar,$this->upnchar)."-".$this->changebase($latstring,$this->binchar,$this->upnchar);
}
else {return "Error: Bad Coordinates";}
}

	 
 

public function upndist($fromupn,$toupn){
return $fromupn;
}

//private function changes base from decimal to UPN base and backwards

private function changebase($numstring,$fromcharset,$tocharset){
     $frombase=strlen($fromcharset);
     $tobase=strlen($tocharset);
     $chars = $fromcharset;
     $tostring = $tocharset;
     $result = '';
     $length = strlen($numstring);
     
     for ($i = 0; $i < $length; $i++) {
         $number[$i] = strpos($chars, $numstring{$i});
     }
     do {
         $divide = 0;
         $newlen = 0;
         for ($i = 0; $i < $length; $i++) {
             $divide = $divide * $frombase + $number[$i];
             if ($divide >= $tobase) {
                 $number[$newlen++] = (int)($divide/$tobase);
                 $divide = $divide % $tobase;
             } elseif ($newlen > 0) {
                 $number[$newlen++] = 0;
             }
         }
         $length = $newlen;
         $result = $tostring{$divide} . $result;
     }
     while ($newlen != 0);
     return $result;
}

}
?>