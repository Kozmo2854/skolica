<?php
function getUserData(){
    $file = file_get_contents("storage.json");
    return json_decode($file, true);
}

function saveUserData($data){

    return file_put_contents('storage.json', json_encode($data));
}