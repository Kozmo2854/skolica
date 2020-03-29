<?php

function validateUserForm($params)
{
    if (!is_array($params)) {
        throw new Exception('Given param is not an array');
    }
    if (isset($params['email']) and isset($params['password']) and isset($params['password-2']) and isset($params['firstName']) and isset($params['lastName']) and isset($params['username'])) {
        if (
            (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
            (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and
            ($params['password-2'] === $params['password']) and
            (strlen($params['firstName']) > 2 and strlen($params['firstName']) < 32) and
            (strlen($params['lastName']) > 2 and strlen($params['lastName']) < 32) and
            (strlen($params['username']) > 2 and strlen($params['username']) < 32)
        ) {
            return true;
        } else {
            echo "nije ok";
            return false;
        }
    } else {
        return false;
    }
}

function createUser($params)
{
    $params['image'] = saveImage();
    
    $userData = createUserData($params);

    $userData = prepareDataForCreating($userData,'storage.json');
}



function updateUser($params){

    $params['image'] = saveImage();
    
    
    $params['password'] = md5($params['password']);
    unset($params['password-2']);


    $userData = createUserData($params);

    $userData = prepareDataForUpdating('storage.json','email',$userData);
}

function saveImage()
{
    $fileName = APP_PATH . '/images/' . $_FILES['image']['name'];

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fileName)) {
        echo "Nismo snimili sliku";
        die();
    }
    
    return 'images/' . $_FILES['image']['name'];
}

?>