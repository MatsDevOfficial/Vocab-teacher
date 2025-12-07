<?php $pageTitle = 'VocabMaster - AI-Powered Vocabulary Learning'; ?>
<?php ob_start(); ?>

<div class="hero-section">
    <h1 class="display-4 fw-bold mb-3">Master Your Vocabulary</h1>
    <p class="lead text-muted mb-5">Powered by AI to help you learn and remember new words</p>
    
    <form action="/" method="GET" class="row justify-content-center mb-5">
        <input type="hidden" name="action" value="lookup">
        <div class="col-md-6 col-lg-5">
            <div class="input-group">
                <input type="text" name="word" class="form-control search-box" 
                       placeholder="Enter a word to learn..." required autofocus>
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="bi bi-search me-2"></i>Look Up
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="feature-icon">
                <i class="bi bi-lightbulb"></i>
            </div>
            <h4>AI Definitions</h4>
            <p class="text-muted">Get detailed definitions, examples, synonyms, and etymology powered by AI</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="feature-icon">
                <i class="bi bi-puzzle"></i>
            </div>
            <h4>Interactive Quizzes</h4>
            <p class="text-muted">Test your knowledge with AI-generated quiz questions</p>
            <a href="/?action=quiz" class="btn btn-primary mt-3">Start Quiz</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="feature-icon">
                <i class="bi bi-heart"></i>
            </div>
            <h4>Save Favorites</h4>
            <p class="text-muted">Build your personal word collection and review anytime</p>
            <a href="/?action=favorites" class="btn btn-primary mt-3">View Favorites</a>
        </div>
    </div>
</div>

<?php if (!empty($history)): ?>
<div class="card p-4">
    <h5 class="mb-3"><i class="bi bi-clock-history me-2"></i>Recent Searches</h5>
    <div class="d-flex flex-wrap gap-2">
        <?php foreach ($history as $item): ?>
        <a href="/?action=lookup&word=<?= urlencode($item['word']) ?>" 
           class="btn btn-outline-secondary btn-sm rounded-pill">
            <?= htmlspecialchars($item['word']) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
