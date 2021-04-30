<?php 
    function getAPI($url){
        //$baseurl = 'http://127.0.0.1:5000/api/';
        $baseurl = 'http://api.foodapi.icu/api/';
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $baseurl.$url);

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);
        return $output;
    }

    function postAPI($url, $data){
        //$baseurl = 'http://127.0.0.1:5000/api/';
        $baseurl = 'http://api.foodapi.icu/api/';
        // create & initialize a curl session
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $baseurl.$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
         ));
        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);
    
        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);
        return $output;
    }

    function deleteAPI($url){
        //$baseurl = 'http://127.0.0.1:5000/api/';
        $baseurl = 'http://api.foodapi.icu/api/';

		$ch = curl_init();                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
		curl_setopt($ch, CURLOPT_FAILONERROR, true);                                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_URL, $baseurl.$url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json'                                                                    
		));                                                                                                                   
		 
        $output = curl_exec($ch);
        
        curl_close($curl);
		return $output;
	}
?>