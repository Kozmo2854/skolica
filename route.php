<?php
        function resolveRoute($config){
            global $message;
            if(!isset($_GET['route'])){
               $route = 'home';
            } else {
               $route = $_GET['route'];
            }

            switch ($route) {
                case 'loginForm':
                    if (isset($_GET['message'])) {
                        $message = $_GET['message'];
                    }
                    include('templates/session/loginForm.phtml');
                    break;

                case 'login':
                    if (validateLoginForm($_POST) and login($_POST['email'], $_POST['password'])) {
                        redirect($config['baseUrl'], '&message=loggedIn');
                        exit();
                    }
                    redirect($config['baseUrl'], 'loginForm&message=invalidParams');
                    break;

                case 'registerForm':
                    include('templates/user/userForm.phtml');
                    break;

                case 'register':
                    include('templates/user/userForm.phtml');
                    break;
                case 'userList':
                    if (isset($_GET['message']) && $_GET['message'] === 'logedIn') {
                        $message = 'Uspesno ste se ulogovali';
                    }
                    $users = array();
                    $emailFilter = null;
                    if (isset($_GET['emailFilter'])) {
                        array_push($users, getUserByEmail($_GET['emailFilter']));
                    } else {
                        $users = getUsers();
                    }
                    include 'templates/user/userList.phtml';
                    break;
                case 'userCreateForm':
                    include('templates/user/userForm.phtml');
                    break;
                case 'userCreate':
                    if(getUserByEmail($_POST['email']))
                    {
                        echo 'Postoji user sa istim emailom';
                        break;
                    }
                    $valid = validateUserForm($_POST);
                    if (!$valid) {
                        global $message;
                        $message = $valid;
                    } else {
                        if (!createUser($_POST)) {
                            $message = 'Doslo je do greske prilikom snimanja korisnika';
                        } else {
                            echo "Korisnik je uspesno sacuvan";
                        }
                    }
                    break;
                case 'userUpdateForm':
                    $user = getUserByEmail($_GET['email']);
                    include('templates/user/userForm.phtml');

                    break;
                case 'userUpdate':
                    validateUserForm($_POST);
                    updateUser($_POST);
                    break;
                
                case 'userLogout' :
                    logOut();
                    redirect($config['baseUrl']);

                    break;
                case 'articleCreateForm' :
                    $categories= array();
                    $categories= getCategory();
                    include('templates/article/articleForm.phtml');

                    break;
                case 'articleCreate' :
                    if (!createArticle($_POST)) {
                        $message = 'Doslo je do greske prilikom snimanja clanka';
                    } else {
                        echo "Clanak uspesno sacuvan";

                    }
                    break;

                case 'articleUpdateForm' :
                    $categories= array();
                    $categories= getCategory();
                    $article = getArticleByTitle($_GET['title']);
                    include 'templates/article/articleForm.phtml';
                    break;
                case 'articleUpdate' :
                        updateArticle($_POST);
                    break;
                case 'articleList' :
                    $articles = array();
                    $articleFilter = null;
                    if (isset($_GET['articleFilter'])) {
                        array_push($article, getArticleByTitle($_GET['articleFilter']));
                    } else {
                        $articles = getArticles();
                    }
                    include 'templates/article/articleList.phtml';
                    break;
                case 'categoryCreateForm' :
                    $categories = array();
                    $categories = getCategory();
                    include 'templates/category/categoryCreate.phtml';
                    break;
                case 'categorySave' :
                    if (!saveCategoryForm($_POST)) {
                        $message = 'Doslo je do greske prilikom snimanja';
                    } else {
                        echo "Kategorija je uspesno snimljena u bazu";
                        $categories = array();
                        $categories = getCategory();
                        include 'templates/category/categoryCreate.phtml';
                    }
                    break;
                case 'deleteUser' :
                    deleteSomething($_POST['email'],'email','storage.json');
                break;
                case 'deleteArticle':
                    deleteSomething($_POST['title'],'title','article.json');
                default:
                    echo "default";
                    break;
            }


     }
 ?>
