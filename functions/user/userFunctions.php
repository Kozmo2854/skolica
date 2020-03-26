<?php

function parseUserData ($params) {
    $lastItem = end($data);
    $lastItemId = $lastItem["id"];

    $userData = [
        'id' => ++$lastItemId,
        'email' => $params['email'],
        'password' => createPasswordHash($params['password']),
        'firstName' => $params['firstName'],
        'lastName' => $params['lastName'],
        'username' => $params['username'],
        'image' => saveImage(),
        'status' => $params['status']
    ];

    return $userData;
}
function saveUser($params)
{
    $data = getUserData();

    $userData = parseUserData($params);

    $tmp = file_get_contents('storage.json');
    if (strlen($tmp) === 0) {
        $data = [$userData];
    } else {
        $data = json_decode($tmp);
        $data[] = $userData;
    }
    saveUserData($data);

}
function deleteUser() {
    $data = file_get_contents('storage.json');
    $dataArray = json_decode($data,true);
    $arrIndex = array();
    foreach($dataArray as $key => $value) {
        if ($key == $_GET["userId"]) {
            $arrIndex[] = $key;
        }
    }
    foreach ($arrIndex as $i) {
        unset($dataArray[$i]);
    }
    $dataArray = array_values($dataArray);
    file_put_contents("storage.json", json_encode($dataArray));
}
function updateUser() {
    $data = file_get_contents("storage.json");
    $dataArray = json_decode($data,true);
    foreach ($dataArray as $key =>$value) {
        if ($value["id"] == $_POST["id"]) {
            $dataArray[$key]["email"] = $_POST["email"];
            $dataArray[$key]["username"] = $_POST["username"];
            $dataArray[$key]["password"] = $_POST["password"];
            $dataArray[$key]["firstName"] = $_POST["firstName"];
            $dataArray[$key]["lastName"] = $_POST["lastName"];
            $dataArray[$key]["status"] = $_POST["status"];

        }
    }
    $dataArray = array_values($dataArray);
    file_put_contents("storage.json", json_encode($dataArray));

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
/*
 * Get users from file storage
 * Return array
 */
function getUsers()
{
    $users = file_get_contents('storage.json');
    return json_decode($users);
}
function createPasswordHash($password)
{
    return md5($password);
}
function registerUser($params)
{
    $data = file_get_contents('storage.json');
    $data .= json_encode(['email' => $params['email'], 'password' => $params['password']]) . PHP_EOL;
    file_put_contents('storage.json', $data);
}

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


function validateUserForm(array $params)
{
    if (isset($params['email']) and isset($params['password']) and
        isset($params['password-2']) and isset($params['firstName']) and
        isset($params['lastName']) and isset($params['username'])) {
        if (
            (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
            (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and
            ($params['password-2'] === $params['password']) and
            (strlen($params['firstName']) > 2 and strlen($params['firstName']) < 32) and
            (strlen($params['lastName']) > 2 and strlen($params['lastName']) < 32) and
            (strlen($params['username']) > 2 and strlen($params['username']) < 32)
            // (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
            // (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and
            // ($params['password-2'] === $params['password']) and
            // (strlen($params['firstName']) > 2 and strlen($params['firstName']) < 32 and preg_match("/[^a-zA-Z\_-]/i", $params['firstName'])) and
            // (strlen($params['lastName']) > 2 and strlen($params['lastName']) < 32 and preg_match("/[^a-zA-Z\_-]/i", $params['lastName'])) and
            // (strlen($params['username']) > 2 and strlen($params['username']) < 32 and preg_match("/[^a-zA-Z0-9\_-]/i", $params['username']))
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

function validateRegisterForm($params)
{
    if (!is_array($params)) {
        throw new Exception('Given param is not an array');
    }
    if (isset($params['email']) and isset($params['password']) and isset($params['password-2'])) {
        if ((strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
            (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and ($params['password-2'] === $params['password'])
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