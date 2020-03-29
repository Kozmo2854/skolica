<?php

function deleteSomething($deleteData, $deleteDataField, $deleteFile){
    $tmpFileContents = json_decode(file_get_contents($deleteFile),true);

    foreach ($tmpFileContents as $key => $dataFromFile) {
        if($dataFromFile[$deleteDataField]===$deleteData)
        {
            unset($tmpFileContents[$key]);
        }
    }
    file_put_contents($deleteFile,json_encode($tmpFileContents));
}

function createUserData($params){
    $paramsKeys=array_keys($params);
    $userData=[];


    foreach ($paramsKeys as $value) {
        $userData[$value] = $params[$value];
    }

    return $userData;
}


function prepareDataForCreating($userData, $drawFromFile){
    $tmp = file_get_contents($drawFromFile);
    if (strlen($tmp) === 0) {
        $data = [$userData];
    } else {
        $data = json_decode($tmp);
        $data[] = $userData;
    }

    if(isset($data))
        file_put_contents($drawFromFile, json_encode($data));
}

function prepareDataForUpdating($updateFile,$updateFiled,$userData){

    $tmpFileContents = json_decode(file_get_contents($updateFile),true);


    foreach ($tmpFileContents as $key => $userFromFile) {
        if($userFromFile[$updateFiled]===$userData[$updateFiled])
        {
            unset($tmpFileContents[$key]);
            $tmpFileContents[$key] = $userData;
        }
    }
    if(isset($tmpFileContents))
        file_put_contents($updateFile,json_encode($tmpFileContents));
}

?>