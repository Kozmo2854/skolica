<?php



function login($email, $password)
{
    $user = getUserByEmail($email);
    if (!$user) {
        return false;
    }
    if ($user->password === createPasswordHash($password)) {
        $_SESSION['isLoggedIn'] = true;
        return true;
    }
    return false;
}


function getUserByEmail($email)
{
    foreach (getUsers() as $user) {
        if ($email === $user->email) {
            return $user;
        }
    }

    return false;
}

function validateLoginForm($params)
{
    if (!is_array($params)) {
        throw new Exception('Given param is not an array');
    }
    if (isset($params['email']) and isset($params['password'])) {
        if (
                (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) 
                and
                (strlen($params['password']) > 6 and strlen($params['password']) <= 14)
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function createPasswordHash($password)
{
    return md5($password);
}


function getUsers()
{
    $users = file_get_contents('storage.json');
    return json_decode($users);
}

function isLoggedIn()
{
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        return true;
    }

    return false;
}



function logOut()
{
    unset($_SESSION);
    session_destroy();
}



?>