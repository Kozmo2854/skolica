<?php




include('functions/config/configFunctions.php');

include('functions/article/articleFunctions.php');

include('functions/category/categoryFunctions.php');

include('functions/user/userFunctions.php');




//START OF CONFIG


// function bootstrap()
// {
//     define('APP_PATH', __DIR__);
//     session_start();
//     error_reporting(E_ALL);
//     ini_set('display_errors', 1);
// }



// function redirect($baseUrl, $route = '', $statusCode = 302)
// {
//     header('location:' . $baseUrl . $route, $statusCode);
// }


//END OF CONFIG



//START OF USER
// function validateRegisterForm($params)
// {
//     if (!is_array($params)) {
//         throw new Exception('Given param is not an array');
//     }
//     if (isset($params['email']) and isset($params['password']) and isset($params['password-2'])) {
//         if ((strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
//             (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and ($params['password-2'] === $params['password'])
//         ) {
//             return true;
//         } else {
//             echo "nije ok";
//             return false;
//         }
//     } else {
//         return false;
//     }
// }

// function validateUserForm($params)
// {
//     if (!is_array($params)) {
//         throw new Exception('Given param is not an array');
//     }
//     if (isset($params['email']) and isset($params['password']) and isset($params['password-2']) and isset($params['firstName']) and isset($params['lastName']) and isset($params['username'])) {
//         if (
//             (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) and
//             (strlen($params['password']) > 6 and strlen($params['password']) <= 14) and
//             ($params['password-2'] === $params['password']) and
//             (strlen($params['firstName']) > 2 and strlen($params['firstName']) < 32) and
//             (strlen($params['lastName']) > 2 and strlen($params['lastName']) < 32) and
//             (strlen($params['username']) > 2 and strlen($params['username']) < 32)
//         ) {
//             return true;
//         } else {
//             echo "nije ok";
//             return false;
//         }
//     } else {
//         return false;
//     }
// }

// function registerUser($params)
// {
//     $data = file_get_contents('storage.json');
//     $data .= json_encode(['email' => $params['email'], 'password' => $params['password']]) . PHP_EOL;
//     file_put_contents('storage.json', $data);
// }


// function getUserByEmail($email)
// {
//     foreach (getUsers() as $user) {
//         if ($email === $user->email) {
//             return $user;
//         }
//     }

//     return false;
// }



// function saveImage()
// {
//     $fileName = APP_PATH . '/images/' . $_FILES['image']['name'];

//     if (!move_uploaded_file($_FILES['image']['tmp_name'], $fileName)) {
//         echo "Nismo snimili sliku";
//         die();
//     }
    
//     return 'images/' . $_FILES['image']['name'];
// }



// function login($email, $password)
// {
//     $user = getUserByEmail($email);
//     if (!$user) {
//         return false;
//     }
//     if ($user->password === createPasswordHash($password)) {
//         $_SESSION['isLoggedIn'] = true;
//         return true;
//     }
//     return false;
// }

// function validateLoginForm($params)
// {
//     if (!is_array($params)) {
//         throw new Exception('Given param is not an array');
//     }
//     if (isset($params['email']) and isset($params['password'])) {
//         if (
//                 (strlen($params['email']) > 6 and strlen($params['email'] <= 20) and strstr($params['email'], '@', true)) 
//                 and
//                 (strlen($params['password']) > 6 and strlen($params['password']) <= 14)
//         ) {
//             return true;
//         } else {
//             return false;
//         }
//     } else {
//         return false;
//     }
// }



// /*
//  * Get users from file storage
//  * Return array
//  */
// function getUsers()
// {
//     $users = file_get_contents('storage.json');
//     return json_decode($users);
// }

// function isLoggedIn()
// {
//     if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
//         return true;
//     }

//     return false;
// }


// function logOut()
// {
//     unset($_SESSION);
//     session_destroy();
// }

// function createPasswordHash($password)
// {
//     return md5($password);
// }


// function createUser($params)
// {
//     $params['image'] = saveImage();
    
//     $userData = createUserData($params);

//     $userData = prepareDataForCreating($userData,'storage.json');
// }



// function updateUser($params){

//     $params['image'] = saveImage();

//     $params['password'] = md5($params['password']);
//     unset($params['password-2']);

//     $userData = createUserData($params);

//     $userData = prepareDataForUpdating('storage.json','email',$userData);
// }


//END OF USER

//START OF ARTICLE


// function validateArticleForm()
// {
//     if (isset($_POST['body']) && strlen($_POST['body']) < 1 || isset($_POST['category']) && strlen($_POST['category']) < 1 || isset($_POST['user']) && strlen($_POST['user']) < 1) {
//         return false;
//     }
//     return true;

// }

// function getArticleByTitle($title)
// {
//     foreach (getArticles() as $article) {
//         if ($title === $article->title) {
//             return $article;
//         }
//     }

//     return false;
// }

// function getArticles()
// {
//     $articles = file_get_contents('article.json');
//     return json_decode($articles);
// }


// function createArticle($params)
// {

//     $userData = createUserData($params);

//     $userData = prepareDataForCreating($userData,'article.json');

// }


// function updateArticle($params)
// {

//     $userData = createUserData($params);
    
//     $userData = prepareDataForUpdating('article.json','title',$userData);
// }


//END OF ARTICLE

// function saveArticleForm($params)
// {
//     //$fileName = saveImage();
//     $articleData = [
//         'title' => $params['title'],
//         'description' => $params['description'],
//         'body' => $params['body'],
//         'category' => $params['category'],
//         'user' => $params['user'],
//         //'image' => $fileName,
//     ];
//     $tmp = file_get_contents('article.json');
//     if (strlen($tmp) === 0) {
//         $data = [$articleData];
//     } else {
//         $data = json_decode($tmp);
//         $data[] = $articleData;
//     }
//     return file_put_contents('article.json', json_encode($data));
// }



//START OF CATEGORY

// function saveCategoryForm($params)
// {
//     $userData = [
//         'category' => $params['category'],
//     ];
//     $tmp = file_get_contents('category.json');
//     if (strlen($tmp) === 0) {
//         $data = [$userData];
//     } else {
//         $data = json_decode($tmp);
//         $data[] = $userData;
//     }
//     return file_put_contents('category.json', json_encode($data));
// }

// function getCategory()
// {
//     $categories = file_get_contents('category.json');
//     return json_decode($categories);
// }

//END OF CATEGORY

//START OF CRUD

// function deleteSomething($deleteData, $deleteDataField, $deleteFile){
//     $tmpFileContents = json_decode(file_get_contents($deleteFile),true);

//     foreach ($tmpFileContents as $key => $dataFromFile) {
//         if($dataFromFile[$deleteDataField]===$deleteData)
//         {
//             unset($tmpFileContents[$key]);
//         }
//     }
//     file_put_contents($deleteFile,json_encode($tmpFileContents));
// }

// function createUserData($params){
//     $paramsKeys=array_keys($params);
//     $userData=[];


//     foreach ($paramsKeys as $value) {
//         $userData[$value] = $params[$value];
//     }

//     return $userData;
// }


// function prepareDataForCreating($userData, $drawFromFile){
//     $tmp = file_get_contents($drawFromFile);
//     if (strlen($tmp) === 0) {
//         $data = [$userData];
//     } else {
//         $data = json_decode($tmp);
//         $data[] = $userData;
//     }

//     if(isset($data))
//         file_put_contents($drawFromFile, json_encode($data));
// }

// function prepareDataForUpdating($updateFile,$updateFiled,$userData){

//     $tmpFileContents = json_decode(file_get_contents($updateFile),true);


//     foreach ($tmpFileContents as $key => $userFromFile) {
//         if($userFromFile[$updateFiled]===$userData[$updateFiled])
//         {
//             unset($tmpFileContents[$key]);
//             $tmpFileContents[$key] = $userData;
//         }
//     }
//     if(isset($tmpFileContents))
//         file_put_contents($updateFile,json_encode($tmpFileContents));
// }


//END OF CRUD
?>