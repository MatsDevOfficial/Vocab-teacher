<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'VocabMaster - AI-Powered Vocabulary Learning' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-color: #667eea;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        .navbar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        }
        
        .search-box {
            border-radius: 50px;
            padding: 15px 25px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
        }
        
        .word-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
        }
        
        .word-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .part-of-speech {
            background: #f0f0f0;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .example-sentence {
            background: #f8f9ff;
            border-left: 4px solid var(--accent-color);
            padding: 15px 20px;
            margin: 10px 0;
            border-radius: 0 10px 10px 0;
        }
        
        .synonym-tag, .antonym-tag {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 5px;
            font-size: 0.9rem;
        }
        
        .synonym-tag {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .antonym-tag {
            background: #ffebee;
            color: #c62828;
        }
        
        .favorite-btn {
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .favorite-btn:hover {
            transform: scale(1.2);
        }
        
        .favorite-btn.active {
            color: #e91e63;
        }
        
        .quiz-option {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 15px 20px;
            margin: 10px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .quiz-option:hover {
            border-color: var(--accent-color);
            background: #f8f9ff;
        }
        
        .quiz-option.correct {
            border-color: #4caf50;
            background: #e8f5e9;
        }
        
        .quiz-option.incorrect {
            border-color: #f44336;
            background: #ffebee;
        }
        
        .hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }
        
        .loading-spinner {
            display: none;
        }
        
        .loading .loading-spinner {
            display: inline-block;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 20px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .api-warning {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-left: 4px solid #ff9800;
            padding: 15px 20px;
            border-radius: 0 10px 10px 0;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-book-half me-2"></i>VocabMaster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/"><i class="bi bi-house me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/?action=quiz"><i class="bi bi-question-circle me-1"></i>Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/?action=favorites"><i class="bi bi-heart me-1"></i>Favorites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/?action=history"><i class="bi bi-clock-history me-1"></i>History</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if (!($isConfigured ?? true)): ?>
        <div class="api-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>API Key Required:</strong> Please configure your HackClub AI API key to use all features.
        </div>
        <?php endif; ?>
        
        <?= $content ?? '' ?>
    </main>

    <footer class="text-center py-4 text-muted">
        <p>&copy; <?= date('Y') ?> VocabMaster - Powered by HackClub AI</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFavorite(word, button) {
            const isActive = button.classList.contains('active');
            const action = isActive ? 'remove-favorite' : 'add-favorite';
            
            fetch('/?action=' + action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'word=' + encodeURIComponent(word)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('active');
                    button.innerHTML = button.classList.contains('active') 
                        ? '<i class="bi bi-heart-fill"></i>' 
                        : '<i class="bi bi-heart"></i>';
                }
            });
        }
    </script>
</body>
</html>
