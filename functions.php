<?php
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

function saveUser($params)
{
    $file = file_get_contents("storage.json");
    $data = json_decode($file, true);

    $lastItem = end($data);
    $lastItemId = $lastItem["id"];
    $userData = [
        "id" => ++$lastItemId,
        'email' => $params['email'],
        'password' => createPasswordHash($params['password']),
        'firstName' => $params['firstName'],
        'lastName' => $params['lastName'],
        'username' => $params['username'],
        'image' => saveImage(),
        'status' => $params['status']
    ];
    $tmp = file_get_contents('storage.json');
    if (strlen($tmp) === 0) {
        $data = [$userData];
    } else {
        $data = json_decode($tmp);
        $data[] = $userData;
    }

    return file_put_contents('storage.json', json_encode($data));
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



function saveImage()
{
    $fileName = APP_PATH . '/images/' . $_FILES['image']['name'];
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fileName)) {
        throw new \Exception("Nismo snimili sliku");
    }
    return 'images/' . $_FILES['image']['name'];
}

function registerUser($params)
{
    $data = file_get_contents('storage.json');
    $data .= json_encode(['email' => $params['email'], 'password' => $params['password']]) . PHP_EOL;
    file_put_contents('storage.json', $data);
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

function validateLoginForm(array $params)
{
    if (isset($params['email']) and isset($params['password'])) {
        if ((strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
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

function bootstrap()
{
    define('APP_PATH', __DIR__);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
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


function isLoggedIn()
{
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        return true;
    }

    return false;
}

function redirect($baseUrl, $route = '', $statusCode = 302)
{
    header('Location: ' . $baseUrl . $route, $statusCode);
}

function logOut()
{
    unset($_SESSION);
    session_destroy();
}

function createPasswordHash($password)
{
    return md5($password);
}

function validateArticleForm()
{
    if (isset($_POST['body']) && strlen($_POST['body']) < 1 || isset($_POST['category']) && strlen($_POST['category']) < 1 || isset($_POST['user']) && strlen($_POST['user']) < 1) {
        return false;
    }
    return true;

}

function saveArticleForm($params)
{
    //$fileName = saveImage();
    $articleData = [
        'title' => $params['title'],
        'description' => $params['description'],
        'body' => $params['body'],
        'category' => $params['category'],
        'user' => $params['user'],
        //'image' => $fileName,
    ];
    $tmp = file_get_contents('article.json');
    if (strlen($tmp) === 0) {
        $data = [$articleData];
    } else {
        $data = json_decode($tmp);
        $data[] = $articleData;
    }
    return file_put_contents('article.json', json_encode($data));
}

function getArticleByTitle($title)
{
    foreach (getArticles() as $article) {
        if ($title === $article->title) {
            return $article;
        }
    }

    return false;
}

function deleteArticle() {
    $data = file_get_contents('article.json');
    $dataArray = json_decode($data,true);
    $arrIndex = array();
    foreach($dataArray as $key => $value) {
        if ($key == $_GET["articleId"]) {
        $arrIndex[] = $key;
        }
    }
    foreach ($arrIndex as $i) {
        unset($dataArray[$i]);
    }
    $dataArray = array_values($dataArray);
    file_put_contents("article.json", json_encode($dataArray));

}

function getArticles()
{
    $articles = file_get_contents('article.json');
    return json_decode($articles);
}

function saveArticle($params)
{
//    $articleData = [
//        'title' => $params['title']
//    ];

    $articles = [];
    foreach (getArticles() as $article) {
        if ($article->title === trim($params['title'])) {
            $articles[] = $params;
        } else {
            $articles[] = $params;
        }

    }

    return file_put_contents('article.json', json_encode($articles));
}

function saveCategoryForm($params)
{
    $userData = [
        'category' => $params['category'],
    ];
    $tmp = file_get_contents('category.json');
    if (strlen($tmp) === 0) {
        $data = [$userData];
    } else {
        $data = json_decode($tmp);
        $data[] = $userData;
    }
    return file_put_contents('category.json', json_encode($data));
}

function getCategory()
{
    $categories = file_get_contents('category.json');
    return json_decode($categories);
}

function getCategoryByName($name)
{
    foreach(getCategory() as $category) {
        if ($name == $category->category) {
            return $category;
        }
    }
}

function deleteCategory() {
    $data = file_get_contents('category.json');
    $dataArray = json_decode($data,true);
    $arrIndex = array();
    foreach($dataArray as $key => $value) {
        if ($key == $_GET["categoryId"]) {
        $arrIndex[] = $key;
        }
    }
    foreach ($arrIndex as $i) {
        unset($dataArray[$i]);
    }
    $dataArray = array_values($dataArray);
    file_put_contents("category.json", json_encode($dataArray));
}

?>
