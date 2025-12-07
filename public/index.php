<?php
session_start();

require_once __DIR__ . '/../src/HackClubAI.php';
require_once __DIR__ . '/../src/VocabularyController.php';

if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

$controller = new VocabularyController();

$action = $_GET['action'] ?? 'home';

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

switch ($action) {
    case 'lookup':
        $controller->lookup();
        break;
    case 'quiz':
        $controller->quiz();
        break;
    case 'generate-quiz':
        header('Content-Type: application/json');
        $controller->generateQuiz();
        break;
    case 'add-favorite':
        header('Content-Type: application/json');
        $controller->addFavorite();
        break;
    case 'remove-favorite':
        header('Content-Type: application/json');
        $controller->removeFavorite();
        break;
    case 'favorites':
        $controller->favorites();
        break;
    case 'history':
        $controller->history();
        break;
    default:
        $controller->home();
        break;
}
