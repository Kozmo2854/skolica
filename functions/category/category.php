<?php

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

?>