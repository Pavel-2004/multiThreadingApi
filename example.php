<?php
require "functions.php";
//an array of all the API URLs I wanna call
//uses a periodic table API
$lst = array(
    "https://neelpatel05.pythonanywhere.com/element/atomicname?atomicname=Mercury",
    "https://neelpatel05.pythonanywhere.com/element/atomicname?atomicname=Iron",
    "https://neelpatel05.pythonanywhere.com/element/atomicname?atomicname=Sodium"
);

$mercury = new apiCall();
#checks which one of those urls represents an element in chemistry that has an atomic mass of 200.59
echo($mercury->multiThreadCall($lst, "atomicMass", "200.59(2)"));
