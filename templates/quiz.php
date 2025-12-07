<?php $pageTitle = 'Vocabulary Quiz - VocabMaster'; ?>
<?php ob_start(); ?>

<div class="card p-4">
    <h2 class="mb-4"><i class="bi bi-question-circle me-2"></i>Vocabulary Quiz</h2>
    
    <div class="mb-4">
        <label class="form-label">Enter a word to quiz yourself:</label>
        <div class="input-group">
            <input type="text" id="quiz-word" class="form-control search-box" 
                   placeholder="Enter a word..." value="<?= htmlspecialchars($_GET['word'] ?? '') ?>">
            <button type="button" class="btn btn-primary ms-2" onclick="generateQuiz()">
                <i class="bi bi-play-fill me-2"></i>Start Quiz
            </button>
        </div>
    </div>

    <?php if (!empty($favorites)): ?>
    <div class="mb-4">
        <label class="form-label text-muted">Or choose from your favorites:</label>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($favorites as $fav): ?>
            <button class="btn btn-outline-secondary btn-sm rounded-pill" 
                    onclick="document.getElementById('quiz-word').value='<?= htmlspecialchars($fav) ?>'; generateQuiz();">
                <?= htmlspecialchars($fav) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div id="quiz-container" style="display: none;">
        <hr class="my-4">
        
        <div id="quiz-loading" class="text-center py-5" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Generating quiz question...</p>
        </div>

        <div id="quiz-content" style="display: none;">
            <h4 id="quiz-question" class="mb-4"></h4>
            
            <div id="quiz-options"></div>
            
            <div id="quiz-hint" class="mt-4 p-3 bg-light rounded" style="display: none;">
                <i class="bi bi-lightbulb me-2 text-warning"></i>
                <span id="hint-text"></span>
            </div>
            
            <div id="quiz-result" class="mt-4" style="display: none;"></div>
            
            <div class="mt-4 d-flex gap-2">
                <button id="hint-btn" class="btn btn-outline-warning" onclick="showHint()">
                    <i class="bi bi-lightbulb me-2"></i>Show Hint
                </button>
                <button id="next-btn" class="btn btn-primary" onclick="generateQuiz()" style="display: none;">
                    <i class="bi bi-arrow-right me-2"></i>Next Question
                </button>
            </div>
        </div>

        <div id="quiz-error" class="text-center py-5" style="display: none;">
            <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
            <p class="mt-3" id="error-message"></p>
        </div>
    </div>
</div>

<script>
let currentQuiz = null;
let answered = false;

function generateQuiz() {
    const word = document.getElementById('quiz-word').value.trim();
    if (!word) {
        alert('Please enter a word');
        return;
    }

    answered = false;
    document.getElementById('quiz-container').style.display = 'block';
    document.getElementById('quiz-loading').style.display = 'block';
    document.getElementById('quiz-content').style.display = 'none';
    document.getElementById('quiz-error').style.display = 'none';
    document.getElementById('quiz-hint').style.display = 'none';
    document.getElementById('quiz-result').style.display = 'none';
    document.getElementById('hint-btn').style.display = 'inline-block';
    document.getElementById('next-btn').style.display = 'none';

    fetch('/?action=generate-quiz', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'word=' + encodeURIComponent(word)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('quiz-loading').style.display = 'none';
        
        if (data.error) {
            document.getElementById('quiz-error').style.display = 'block';
            document.getElementById('error-message').textContent = data.error;
            return;
        }

        currentQuiz = data;
        displayQuiz(data);
    })
    .catch(error => {
        document.getElementById('quiz-loading').style.display = 'none';
        document.getElementById('quiz-error').style.display = 'block';
        document.getElementById('error-message').textContent = 'Failed to generate quiz. Please try again.';
    });
}

function displayQuiz(quiz) {
    document.getElementById('quiz-content').style.display = 'block';
    document.getElementById('quiz-question').textContent = quiz.question;
    document.getElementById('hint-text').textContent = quiz.hint || 'No hint available';

    const options = [...quiz.wrong_answers, quiz.correct_answer];
    shuffleArray(options);

    const optionsContainer = document.getElementById('quiz-options');
    optionsContainer.innerHTML = '';

    options.forEach((option, index) => {
        const div = document.createElement('div');
        div.className = 'quiz-option';
        div.textContent = option;
        div.onclick = () => selectAnswer(div, option === quiz.correct_answer, quiz.correct_answer);
        optionsContainer.appendChild(div);
    });
}

function selectAnswer(element, isCorrect, correctAnswer) {
    if (answered) return;
    answered = true;

    const options = document.querySelectorAll('.quiz-option');
    options.forEach(opt => {
        opt.style.pointerEvents = 'none';
        if (opt.textContent === correctAnswer) {
            opt.classList.add('correct');
        }
    });

    if (isCorrect) {
        element.classList.add('correct');
        showResult(true);
    } else {
        element.classList.add('incorrect');
        showResult(false);
    }

    document.getElementById('hint-btn').style.display = 'none';
    document.getElementById('next-btn').style.display = 'inline-block';
}

function showResult(isCorrect) {
    const resultDiv = document.getElementById('quiz-result');
    resultDiv.style.display = 'block';
    
    if (isCorrect) {
        resultDiv.innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>Correct! Great job!</div>';
    } else {
        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="bi bi-x-circle me-2"></i>Not quite. The correct answer is highlighted above.</div>';
    }
}

function showHint() {
    document.getElementById('quiz-hint').style.display = 'block';
    document.getElementById('hint-btn').style.display = 'none';
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

// Auto-generate quiz if word is provided in URL
document.addEventListener('DOMContentLoaded', function() {
    const urlWord = document.getElementById('quiz-word').value;
    if (urlWord) {
        generateQuiz();
    }
});
</script>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
