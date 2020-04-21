<?php

function callAPI($method, $path, $data = false)
{
    $row = sqlQuery("SELECT gl_value FROM globals WHERE gl_name = 'uplx_server_key' LIMIT 1");
    $urlRow = sqlQuery("SELECT gl_value FROM globals WHERE gl_name = 'uplx_server_url' LIMIT 1");
    $token = $row ? $row['gl_value'] : '';
    $serverURL = $urlRow ? $urlRow['gl_value'] : "http://localhost:64723/api";
    $authorization = "Authorization: Bearer " . $token;
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
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
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Request Error:' . curl_error($curl);
    }

    curl_close($curl);

    return $result;
}

function createPatient($data){
    callAPI('POST', 'patient/create', $data);
}

function updatePatient($data){
    callAPI('PUT', 'patient/update', $data);
}

function getPatientDetail($icPassport,$dob){
    callAPI('GET', 'patient/details?icPassport='.$icPassport.'&dob='.$dob);
}

function createConsultation($data){
    callAPI('POST', 'consultation/create', $data);
}

function getConsultationDetail($icPassport,$dob){
    callAPI('GET', 'consultation/details?icPassport='.$icPassport.'&dob='.$dob);
}


function createPrescription($data){
    callAPI('POST', 'prescription/create', $data);
}

function getPrescriptionDetail($icPassport,$dob){
    callAPI('GET', 'prescription/details?icPassport='.$icPassport.'&dob='.$dob);
}

function createIssue($data){
    callAPI('POST', 'issue/create', $data);
}

function test(){
    return callAPI('GET', 'values');
}