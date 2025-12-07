<?php $pageTitle = ($result['word'] ?? $word) . ' - VocabMaster'; ?>
<?php ob_start(); ?>

<div class="mb-4">
    <form action="/" method="GET" class="row justify-content-center">
        <input type="hidden" name="action" value="lookup">
        <div class="col-md-6 col-lg-5">
            <div class="input-group">
                <input type="text" name="word" class="form-control search-box" 
                       placeholder="Enter a word to learn..." value="<?= htmlspecialchars($word) ?>" required>
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="bi bi-search me-2"></i>Look Up
                </button>
            </div>
        </div>
    </form>
</div>

<?php if ($result && !isset($result['error'])): ?>
<div class="card word-card">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="word-title mb-2"><?= htmlspecialchars($result['word']) ?></h1>
            <?php if (!empty($result['pronunciation'])): ?>
            <p class="text-muted mb-2">
                <i class="bi bi-volume-up me-1"></i><?= htmlspecialchars($result['pronunciation']) ?>
            </p>
            <?php endif; ?>
            <?php if (!empty($result['partOfSpeech'])): ?>
            <span class="part-of-speech"><?= htmlspecialchars($result['partOfSpeech']) ?></span>
            <?php endif; ?>
        </div>
        <button class="btn favorite-btn <?= $isFavorite ? 'active' : '' ?>" 
                onclick="toggleFavorite('<?= htmlspecialchars($word) ?>', this)">
            <i class="bi bi-heart<?= $isFavorite ? '-fill' : '' ?>"></i>
        </button>
    </div>

    <div class="mb-4">
        <h5 class="text-muted mb-2">Definition</h5>
        <p class="fs-5"><?= htmlspecialchars($result['definition'] ?? '') ?></p>
    </div>

    <?php if (!empty($result['examples'])): ?>
    <div class="mb-4">
        <h5 class="text-muted mb-3">Example Sentences</h5>
        <?php foreach ($result['examples'] as $example): ?>
        <div class="example-sentence">
            <i class="bi bi-quote me-2 text-muted"></i><?= htmlspecialchars($example) ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <?php if (!empty($result['synonyms'])): ?>
        <div class="col-md-6 mb-3">
            <h5 class="text-muted mb-2">Synonyms</h5>
            <div>
                <?php foreach ($result['synonyms'] as $syn): ?>
                <a href="/?action=lookup&word=<?= urlencode($syn) ?>" class="synonym-tag text-decoration-none">
                    <?= htmlspecialchars($syn) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($result['antonyms'])): ?>
        <div class="col-md-6 mb-3">
            <h5 class="text-muted mb-2">Antonyms</h5>
            <div>
                <?php foreach ($result['antonyms'] as $ant): ?>
                <a href="/?action=lookup&word=<?= urlencode($ant) ?>" class="antonym-tag text-decoration-none">
                    <?= htmlspecialchars($ant) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($result['etymology'])): ?>
    <div class="mb-4">
        <h5 class="text-muted mb-2"><i class="bi bi-clock-history me-2"></i>Etymology</h5>
        <p><?= htmlspecialchars($result['etymology']) ?></p>
    </div>
    <?php endif; ?>

    <?php if (!empty($result['usage_notes'])): ?>
    <div class="mb-4">
        <h5 class="text-muted mb-2"><i class="bi bi-info-circle me-2"></i>Usage Notes</h5>
        <p><?= htmlspecialchars($result['usage_notes']) ?></p>
    </div>
    <?php endif; ?>

    <div class="d-flex gap-2 mt-4">
        <a href="/?action=quiz&word=<?= urlencode($word) ?>" class="btn btn-primary">
            <i class="bi bi-question-circle me-2"></i>Quiz Me
        </a>
        <a href="/" class="btn btn-outline-secondary">
            <i class="bi bi-search me-2"></i>New Search
        </a>
    </div>
</div>
<?php elseif (isset($result['error'])): ?>
<div class="card p-4 text-center">
    <div class="py-5">
        <i class="bi bi-exclamation-circle text-warning" style="font-size: 4rem;"></i>
        <h4 class="mt-3">Unable to Find Definition</h4>
        <p class="text-muted"><?= htmlspecialchars($result['error']) ?></p>
        <a href="/" class="btn btn-primary mt-3">Try Another Word</a>
    </div>
</div>
<?php elseif (empty($word)): ?>
<div class="card p-4 text-center">
    <div class="py-5">
        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
        <h4 class="mt-3">Enter a Word</h4>
        <p class="text-muted">Type a word above to get its definition and more!</p>
    </div>
</div>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
