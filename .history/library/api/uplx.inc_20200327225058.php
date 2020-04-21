<?php

function callAPI($method, $path, $data = false)
{
    $serverURL = "http://localhost:44322/api";
    $authorization = "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjODczNDBhNS1lODBiLTQzOTEtOTA3Zi0xM2M5M2FiMWVkZWUiLCJqdGkiOiJmMDUxZTI0Yi1lMTYyLTQ4NzAtODQ0MS0xOGJhY2FhMzk4MjciLCJpYXQiOiIxOS8zLzIwMjAgMjowNTo1OCBBTSIsInNpZCI6ImVkYjE4YzYxLTA1ZjMtNDkzMS05MzQzLTIwYzMzZGRjOTAxZSIsImF6cCI6IjRBMTQzOThELTA0N0MtNDc0NC05OUU2LURGMkY5RTc2MEUyRCIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6IkEkVVBYTCIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJjODczNDBhNS1lODBiLTQzOTEtOTA3Zi0xM2M5M2FiMWVkZWUiLCJuYmYiOjE1ODQ1ODM1NTgsImV4cCI6MTYxNjExOTU1NSwiaXNzIjoiVVBMWC5BUEkiLCJhdWQiOiJVUExYIEFQSSJ9.rEd_UtMZC519G2dZVD1CZJgJ_bdF6RBmh982lB0wI4A";
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        case "GET":
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $path, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array('Content-Type: application/json' , $authorization ));

    curl_setopt($curl, CURLOPT_URL, "$serverURL/$path");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function createPatient($data){
    callAPI('POST', 'patient/create', $data);
}

function getPatientDetail($icPassport,$dob){
    //callAPI('GET', 'patient/details?icPassport='.$icPassport.'&dob='.$dob);
    callAPI('GET', 'values');
}