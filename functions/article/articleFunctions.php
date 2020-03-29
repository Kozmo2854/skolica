<?php

function validateArticleForm()
{
    if (isset($_POST['body']) && strlen($_POST['body']) < 1 || isset($_POST['category']) && strlen($_POST['category']) < 1 || isset($_POST['user']) && strlen($_POST['user']) < 1) {
        return false;
    }
    return true;

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

function getArticles()
{
    $articles = file_get_contents('article.json');
    return json_decode($articles);
}


function createArticle($params)
{

    $userData = createUserData($params);

    $userData = prepareDataForCreating($userData,'article.json');

}


function updateArticle($params)
{

    $userData = createUserData($params);
    
    $userData = prepareDataForUpdating('article.json','title',$userData);
}

?>