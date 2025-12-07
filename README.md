# VocabMaster - AI-Powered Vocabulary Learning

## Overview
VocabMaster is a PHP-based vocabulary learning website that uses the HackClub AI API to provide intelligent word definitions, examples, and interactive quizzes.

## Project Structure
```
/
├── public/
│   └── index.php          # Main entry point and router
├── src/
│   ├── HackClubAI.php     # HackClub AI API integration
│   └── VocabularyController.php  # Controller logic
├── templates/
│   ├── layout.php         # Base layout template
│   ├── home.php           # Home page
│   ├── lookup.php         # Word lookup results
│   ├── quiz.php           # Interactive quiz
│   ├── favorites.php      # Saved favorite words
│   └── history.php        # Search history
└── README.md              # This file
```

## Features
- **Word Lookup**: Get AI-generated definitions, pronunciation, examples, synonyms, antonyms, etymology
- **Interactive Quiz**: Test vocabulary knowledge with AI-generated questions
- **Favorites**: Save words to a personal collection
- **History**: Track recently searched words

## Installation

1. Clone this repository:
```bash
git clone <repository-url>
cd vocab_webapp
```

2. Copy the example environment file:
```bash
cp .env.example .env
```

3. Edit `.env` and add your HackClub AI API key:
```
HACKCLUB_API_KEY=your_api_key_here
```

## Configuration
- **HACKCLUB_API_KEY**: Required environment variable for HackClub AI API access. Get your API key from [HackClub AI](https://ai.hackclub.com).

## Running the Application
The application runs on PHP's built-in server on port 5000:
```bash
php -S 0.0.0.0:5000 -t public
```

Then open your browser and navigate to `http://localhost:5000`

## Requirements
- PHP 7.4 or higher
- cURL extension enabled
- HackClub AI API key

## License
This project is open source and available under the MIT License.

