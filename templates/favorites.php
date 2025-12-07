<?php $pageTitle = 'My Favorites - VocabMaster'; ?>
<?php ob_start(); ?>

<div class="card p-4">
    <h2 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>My Favorite Words</h2>
    
    <?php if (empty($favorites)): ?>
    <div class="text-center py-5">
        <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
        <h4 class="mt-3">No Favorites Yet</h4>
        <p class="text-muted">Start exploring words and save your favorites!</p>
        <a href="/" class="btn btn-primary mt-3">
            <i class="bi bi-search me-2"></i>Explore Words
        </a>
    </div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($favorites as $word): ?>
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <a href="/?action=lookup&word=<?= urlencode($word) ?>" class="text-decoration-none fw-bold">
                        <?= htmlspecialchars($word) ?>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeFavorite('<?= htmlspecialchars($word) ?>', this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="mt-4">
        <a href="/?action=quiz" class="btn btn-primary">
            <i class="bi bi-question-circle me-2"></i>Quiz Me on Favorites
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
function removeFavorite(word, button) {
    fetch('/?action=remove-favorite', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'word=' + encodeURIComponent(word)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.closest('.col-md-4').remove();
            if (document.querySelectorAll('.col-md-4').length === 0) {
                location.reload();
            }
        }
    });
}
</script>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
