<?php

class HackClubAI {
    private string $apiKey;
    private string $baseUrl = 'https://ai.hackclub.com/chat/completions';

    public function __construct() {
        $this->apiKey = getenv('HACKCLUB_API_KEY') ?: '';
    }

    public function chat(string $prompt): ?string {
        if (empty($this->apiKey)) {
            return null;
        }

        $data = [
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ];

        $ch = curl_init($this->baseUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || $response === false) {
            return null;
        }

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? null;
    }

    public function getWordDefinition(string $word): array {
        $prompt = "You are a vocabulary expert. Provide a clear, educational response for the word \"$word\" in the following JSON format only (no other text):
{
    \"word\": \"$word\",
    \"definition\": \"A clear, concise definition\",
    \"partOfSpeech\": \"noun/verb/adjective/etc\",
    \"pronunciation\": \"phonetic pronunciation\",
    \"examples\": [\"Example sentence 1\", \"Example sentence 2\", \"Example sentence 3\"],
    \"synonyms\": [\"synonym1\", \"synonym2\", \"synonym3\"],
    \"antonyms\": [\"antonym1\", \"antonym2\"],
    \"etymology\": \"Brief origin of the word\",
    \"usage_notes\": \"Any special usage notes or tips\"
}";

        $response = $this->chat($prompt);
        
        if ($response) {
            $jsonStart = strpos($response, '{');
            $jsonEnd = strrpos($response, '}');
            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonStr = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);
                $data = json_decode($jsonStr, true);
                if ($data) {
                    return $data;
                }
            }
        }

        return [
            'word' => $word,
            'error' => 'Unable to fetch definition. Please check your API key or try again.'
        ];
    }

    public function generateQuizQuestion(string $word): array {
        $prompt = "Create a vocabulary quiz question for the word \"$word\". Return ONLY this JSON format:
{
    \"question\": \"What does '$word' mean?\",
    \"correct_answer\": \"the correct definition\",
    \"wrong_answers\": [\"wrong option 1\", \"wrong option 2\", \"wrong option 3\"],
    \"hint\": \"A helpful hint without giving away the answer\"
}";

        $response = $this->chat($prompt);
        
        if ($response) {
            $jsonStart = strpos($response, '{');
            $jsonEnd = strrpos($response, '}');
            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonStr = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);
                $data = json_decode($jsonStr, true);
                if ($data) {
                    return $data;
                }
            }
        }

        return [
            'error' => 'Unable to generate quiz question.'
        ];
    }

    public function isConfigured(): bool {
        return !empty($this->apiKey);
    }
}
