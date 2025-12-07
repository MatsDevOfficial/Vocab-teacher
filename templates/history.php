<?php $pageTitle = 'Search History - VocabMaster'; ?>
<?php ob_start(); ?>

<div class="card p-4">
    <h2 class="mb-4"><i class="bi bi-clock-history me-2"></i>Search History</h2>
    
    <?php if (empty($history)): ?>
    <div class="text-center py-5">
        <i class="bi bi-clock text-muted" style="font-size: 4rem;"></i>
        <h4 class="mt-3">No Search History</h4>
        <p class="text-muted">Your recently searched words will appear here.</p>
        <a href="/" class="btn btn-primary mt-3">
            <i class="bi bi-search me-2"></i>Start Searching
        </a>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Word</th>
                    <th>Searched At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $item): ?>
                <tr>
                    <td>
                        <a href="/?action=lookup&word=<?= urlencode($item['word']) ?>" class="text-decoration-none fw-bold">
                            <?= htmlspecialchars($item['word']) ?>
                        </a>
                    </td>
                    <td class="text-muted"><?= htmlspecialchars($item['timestamp']) ?></td>
                    <td>
                        <a href="/?action=lookup&word=<?= urlencode($item['word']) ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/?action=quiz&word=<?= urlencode($item['word']) ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-question-circle"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
