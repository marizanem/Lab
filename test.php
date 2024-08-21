<?php

//Implode
// $data = ["title"=>"dara", "subtitle"=>"sok", "text"=>"abc", "link"=>"#"];

// $field = implode(",", array_keys($data));
// $value = implode("','", array_values($data));

// echo $field;
// echo "<br>";
// echo $value;

//Explode
$string = "ji,jing,joong";
$name = explode(",",$string);
echo $name[2];
?>