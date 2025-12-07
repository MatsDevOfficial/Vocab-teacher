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
└── replit.md              # This file
```

## Features
- **Word Lookup**: Get AI-generated definitions, pronunciation, examples, synonyms, antonyms, etymology
- **Interactive Quiz**: Test vocabulary knowledge with AI-generated questions
- **Favorites**: Save words to a personal collection
- **History**: Track recently searched words

## Configuration
- **HACKCLUB_API_KEY**: Required secret for HackClub AI API access

## Running the Application
The application runs on PHP's built-in server on port 5000:
```bash
php -S 0.0.0.0:5000 -t public
```

## Recent Changes
- December 7, 2025: Initial project setup with full HackClub AI integration
