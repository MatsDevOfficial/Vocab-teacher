<?php

class VocabularyController {
    private HackClubAI $ai;

    public function __construct() {
        $this->ai = new HackClubAI();
    }

    public function home(): void {
        $isConfigured = $this->ai->isConfigured();
        $favorites = $_SESSION['favorites'] ?? [];
        $history = array_slice($_SESSION['history'] ?? [], 0, 5);
        include __DIR__ . '/../templates/home.php';
    }

    public function lookup(): void {
        $word = trim($_GET['word'] ?? '');
        $result = null;
        $isConfigured = $this->ai->isConfigured();

        if (!empty($word) && $isConfigured) {
            $result = $this->ai->getWordDefinition($word);
            
            if (!isset($result['error'])) {
                $history = $_SESSION['history'] ?? [];
                array_unshift($history, [
                    'word' => $word,
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
                $_SESSION['history'] = array_slice(array_unique($history, SORT_REGULAR), 0, 20);
            }
        }

        $favorites = $_SESSION['favorites'] ?? [];
        $isFavorite = in_array($word, $favorites);
        include __DIR__ . '/../templates/lookup.php';
    }

    public function quiz(): void {
        $isConfigured = $this->ai->isConfigured();
        $favorites = $_SESSION['favorites'] ?? [];
        include __DIR__ . '/../templates/quiz.php';
    }

    public function generateQuiz(): void {
        $word = trim($_POST['word'] ?? '');
        
        if (empty($word)) {
            echo json_encode(['error' => 'No word provided']);
            return;
        }

        $quiz = $this->ai->generateQuizQuestion($word);
        echo json_encode($quiz);
    }

    public function addFavorite(): void {
        $word = trim($_POST['word'] ?? '');
        
        if (!empty($word)) {
            $favorites = $_SESSION['favorites'] ?? [];
            if (!in_array($word, $favorites)) {
                $favorites[] = $word;
                $_SESSION['favorites'] = $favorites;
            }
            echo json_encode(['success' => true, 'favorites' => $favorites]);
        } else {
            echo json_encode(['error' => 'No word provided']);
        }
    }

    public function removeFavorite(): void {
        $word = trim($_POST['word'] ?? '');
        
        if (!empty($word)) {
            $favorites = $_SESSION['favorites'] ?? [];
            $favorites = array_values(array_filter($favorites, fn($f) => $f !== $word));
            $_SESSION['favorites'] = $favorites;
            echo json_encode(['success' => true, 'favorites' => $favorites]);
        } else {
            echo json_encode(['error' => 'No word provided']);
        }
    }

    public function favorites(): void {
        $isConfigured = $this->ai->isConfigured();
        $favorites = $_SESSION['favorites'] ?? [];
        include __DIR__ . '/../templates/favorites.php';
    }

    public function history(): void {
        $isConfigured = $this->ai->isConfigured();
        $history = $_SESSION['history'] ?? [];
        include __DIR__ . '/../templates/history.php';
    }
}
