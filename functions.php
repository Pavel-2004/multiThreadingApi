<?php
class apiCall{
    //regular api call one by one
    function regularGetCall($url, $vaue){
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $response = json_decode($response);
        
        return $response->$value;
        
    }
    //calling multiple APIs parallel
    //takes an array of urls for the api and a condition that has to equal a certain value
    function multiThreadCall($apiList, $condition, $value){
        //a list of all the APIs initialized with the correct options
        $lst = array();
        $counter = 0;
        //initializes the data 
        $mh = curl_multi_init();
        //initializes all of the APIs and sets the correct options (more options could be added before the "curl_multi_add_handle" statment)
        foreach($apiList as $api){
            $lst[$counter] = curl_init();
            //sets the api url to the intialized cURL
            curl_setopt($lst[$counter], CURLOPT_URL, $api);
            //allows returning of a string
            curl_setopt($lst[$counter], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $lst[$counter]);
            $counter++;
        } 
        //runs all of the calls parallel to each other
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running);
        curl_multi_close($mh);
        //checks if the condition is satisfied
        $counter = 0;
        foreach($lst as $li){
            $response = curl_multi_getcontent($li);
            $response = json_decode($response);
            if ($response->$condition == $value){
                return $apiList[$counter];
            }
            $counter++;
        }
    }
}
