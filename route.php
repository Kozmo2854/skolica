<?php
        function resolveRoute($config){
            global $message;

            $route = 'userList';
            if(isset($_GET['route']) && strlen($_GET['route']) > 0) {
                $route = $_GET['route'];
            }

            switch ($route) {
                case 'loginForm':
                    if (isset($_GET['message'])) {
                        $message = $_GET['message'];
                    }
                    include('loginForm.phtml');
                    break;

                case 'login':
                    if (validateLoginForm($_POST) and login($_POST['email'], $_POST['password'])) {
                        redirect($config['baseUrl'], '&message=loggedIn');
                        exit();
                    }
                    redirect($config['baseUrl'], 'loginForm&message=invalidParams');
                    break;

                case 'registerForm':
                    include('userForm.phtml');
                    break;

                case 'register':

                    break;
                case 'userList':
                    if (isset($_GET['message']) && $_GET['message'] === 'loggedIn') {
                        $message = 'Uspesno ste se ulogovali';
                    }
                    $users = [];
                    $emailFilter = null;
                    if (isset($_GET['emailFilter'])) {
                        array_push($users, getUserByEmail($_GET['emailFilter']));
                    } else {
                        $users = getUsers();
                    }
                    include 'userList.phtml';
                    break;
                case 'userCreate':
                    $valid = validateUserForm($_POST);


                    if (!$valid) {
//                        global $message;
                        echo $valid;
                    } else {
                        if (!saveUser($_POST)) {
                            echo 'Doslo je do greske prilikom snimanja korisnika';
                        } else {
                            echo "Korisnik je uspesno sacuvan";
                        }
                    }

                    redirect($config['baseUrl'] . "userList");
                    break;
                case 'userCreateForm':
                    include('userForm.phtml');
                    break;

                case 'userUpdate':
                updateUser();
                
                redirect($config['baseUrl'] . "userList");


                    break;
                case 'userUpdateForm':
                    $user = getUserByEmail($_GET['email']);
                    include('userForm.phtml');




                    break;
                case 'userDelete' :
                    deleteUser();
                    redirect($config['baseUrl'] . "userList");

                    break;
                case 'userLogout' :
                    logOut();
                    redirect($config['baseUrl']);

                    break;

                case 'articleCreateForm' :
                    $categories= getCategory();
                    $users = getUsers();
                    include('articleForm.phtml');

                    break;
                case 'articleCreate' :
                    if (!saveArticleForm($_POST)) {
                        $message = 'Doslo je do greske prilikom snimanja clanka';
                    } else {
                        echo "Clanak uspesno sacuvan";

                    }
                    break;

                case 'articleDelete' :
                $articleTitle = $_GET["title"];
                deleteArticle();
                redirect($config["baseUrl"] . "articleList");

                break;

                case 'articleUpdateForm' :
                    $categories= array();
                    $categories= getCategory();
                    $article = getArticleByTitle($_GET['title']);
                    include 'articleForm.phtml';
                    break;
                case 'articleUpdate' :
                        saveArticle($_POST);
                    break;
                case 'articleList' :
                    $articles = array();
                    $articleFilter = null;
                    if (isset($_GET['articleFilter'])) {
                        array_push($articles, getArticleByTitle($_GET['articleFilter']));
                    } else {
                        $articles = getArticles();
                    }
                    include 'articleList.phtml';
                    break;
                case 'categoryCreateForm' :
                    $categories = array();
                    $categories = getCategory();
                    include 'categoryCreate.phtml';

                    break;
                case 'categorySave' :
                    if (!saveCategoryForm($_POST)) {
                        $message = 'Doslo je do greske prilikom snimanja';
                    } else {
                        echo "Kategorija je uspesno snimljena u bazu";
                        $categories = array();
                        $categories = getCategory();
                        include 'categoryCreate.phtml';
                    }
                    break;

                case 'deleteCategory' :
                deleteCategory();
                redirect($config["baseUrl"] . "categoryCreateForm");

                break;
                default:
                    echo "Dobrodosli na nash blog";
                    break;
            }
     }
 ?>
