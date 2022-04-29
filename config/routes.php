<?php

use App\Controller\{ArticleController, CommentController, SigninController, SignoutController, SignupController};

/* ARTICLE */

$router->map('GET', '/', function() {
    $articleController = new ArticleController();
    $articleController->index();
});
$router->map('GET|POST', '/article/new', function() {
    $articleController = new ArticleController();
    $articleController->new();
});
$router->map('GET', '/article/[i:id]', function(int $id) {
    $articleController = new ArticleController();
    $articleController->show($id);
});
$router->map('GET|POST', '/article/edit/[i:id]', function(int $id) {
    $articleController = new ArticleController();
    $articleController->edit($id);
});
$router->map('GET', '/article/delete/[i:id]', function(int $id) {
    $articleController = new ArticleController();
    $articleController->delete($id);
});


/* COMMENT */

$router->map('GET', '/', function() {
    $commentController = new CommentController();
    $commentController->index();
});
$router->map('GET|POST', '/article/[i:id]/comment/new', function($id) {
    $commentController = new CommentController();
    $commentController->new($id);
});
$router->map('GET', '/comment/[i:id]', function(int $id) {
    $commentController = new CommentController();
    $commentController->show($id);
});
$router->map('GET|POST', '/comment/edit/[i:id]', function(int $id) {
    $commentController = new CommentController();
    $commentController->edit($id);
});
$router->map('GET', '/comment/delete/[i:id]', function(int $id) {
    $commentController = new CommentController();
    $commentController->delete($id);
});

/* SIGNUP - SIGNIN - SIGNOUT */

$router->map('GET|POST', '/signup', function () {
    $signupController = new SignupController();
    $signupController->index();
});
$router->map('GET|POST', '/signin', function () {
    $signinController = new SigninController();
    $signinController->index();
});
$router->map('GET|POST', '/signout', function () {
    $signoutController = new SignoutController();
    $signoutController->index();
});
