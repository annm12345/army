<?php
require('connection.php');
if(isset($_GET['transcript'])) {
    $input =$_GET['transcript'];
    // $input = $_GET['transcript'];

    // Define the keywords to look for
    $keywords = ['အထက', 'ခလရ', 'ခမရ', 'အမှတ်', 'ဒတရ', 'ရတခလရ', 'ရတခမရ'];

    // Define the mapping of Burmese numerals to Arabic numerals
    $burmeseNumerals = ['တစ်', 'နှစ်', 'သုံး', 'လေး', 'ငါး', 'ခြောက်', 'ခုနှစ်', 'ရှစ်', 'ကိုး', 'တစ်ဆယ်', 'သုည'];
    $arabicNumerals = ['၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉', '၁၀', '၀'];

    // Loop through each keyword
    foreach ($keywords as $keyword) {
        // Find the position of the keyword in the input text
        $pos = mb_strpos($input, $keyword);
        if ($pos !== false) {
            // Extract the text after the keyword
            $textAfterKeyword = mb_substr($input, $pos + mb_strlen($keyword));

            // Replace Burmese numerals with Arabic numerals in the extracted text
            $textAfterKeyword = str_replace($burmeseNumerals, $arabicNumerals, $textAfterKeyword);

            // Replace the text after the keyword in the input text
            $input = mb_substr($input, 0, $pos + mb_strlen($keyword)) . $textAfterKeyword;
        }
    }

    // echo $input;
}



// Function to read CSV file and build a test model
function buildTestModel($csvFilePath) {
    $testModel = [];

    if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $subject = isset($data[0]) ? $data[0] : ''; // Check for missing subject
            $noun = isset($data[1]) ? $data[1] : '';     // Check for missing noun
            $object = isset($data[2]) ? $data[2] : '';   // Check for missing object
            $verb = isset($data[3]) ? $data[3] : '';     // Check for missing verb

            // Store data into the test model array
            $testModel[] = [
                'Subject' => $subject,
                'Noun' => $noun,
                'Object' => $object,
                'Verb' => $verb
            ];
        }
        fclose($handle);
    }

    return $testModel;
}

// Function to test the input against the test model using Levenshtein distance
function testInput($testModel, $input) {
    $match = null;

    foreach ($testModel as $row) {
        // Concatenate subject, noun, object, and verb from the row
        $rowData = $row['Subject'] . $row['Noun'] . $row['Object'] . $row['Verb'];

        // Calculate the Levenshtein distance between the input and the concatenated row data
        $distance = levenshtein($input, $rowData);

        // You may need to adjust the threshold value based on your specific use case
        // Here, we use a threshold of 5 as an example
        if ($distance <= 5) {
            $match = $row;
            break; // Exit the loop after finding the first match
        }
    }

    return $match;
}

// Path to the CSV file
$csvFilePath = 'model.csv';

// Build the test model
$testModel = buildTestModel($csvFilePath);

// Test the input against the test model
$match = testInput($testModel, $input);

// if (!is_null($match)) {
//     echo "Subject: " . $match['Subject'] . ", Noun: " . $match['Noun'] . ", Verb: " . $match['Verb'] . ", Object: " . $match['Object'] . "<br>";
// }




require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Classification\NaiveBayes;
use Phpml\Tokenization\WordTokenizer;

// Define Burmese stop words
$stopWordsforlabel = [
    'မန္တလေး','ရှာပေး','ပြည်','ရွှေညောင်','တောင်ကြီးမြို့',
    'ကို', 'က', 'ရဲ့' // Additional words to remove from input text
];

// Load training data for label classification
$trainingData = [];
$labels = [];
$handle = fopen('map_data.csv', 'r');
// Skip the header row
fgetcsv($handle);
while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    // Tokenize the text using regular expression
    preg_match_all('/\p{L}+/u', $data[0], $words);
    $words = $words[0]; // Extract words from the matches array

    // Remove stop words for label classification
    $filteredWords = array_diff($words, $stopWordsforlabel);

    // Convert filtered words to string
    $filteredText = implode(' ', $filteredWords);

    $trainingData[] = [$filteredText]; // Assuming text is in the first column
    $labels[] = $data[1]; // Assuming labels are in the second column
}
fclose($handle);

// Train the model for label classification
$classifierLabel = new NaiveBayes();
$classifierLabel->train($trainingData, $labels);

// Sample input text
$inputsub = $match['Subject'];

// Define words to remove
$wordsToRemove = ['ကို', 'က', 'ရဲ့'];

// Remove specific words from input text using regular expression
$inputsub = preg_replace('/\b(?:' . implode('|', $wordsToRemove) . ')\b/u', '', $inputsub);

// Tokenize the input text using regular expression
preg_match_all('/\p{L}+/u', $inputsub, $inputWords);
$inputWords = $inputWords[0]; // Extract words from the matches array

// Remove stop words for label classification
$filteredInputWordsSubjectLabel = array_diff($inputWords, $stopWordsforlabel);
// Convert filtered input words to string for label classification
$filteredInputTextSubjectLabel = implode(' ', $filteredInputWordsSubjectLabel);

// Predict label
$predictedsubLabel = $classifierLabel->predict([$filteredInputTextSubjectLabel]);
// echo "The Predicted label is: $predictedsubLabel\n";

$commandData = [];
$commands = [];
$commandFile = fopen('command.csv', 'r');
// Skip the header row
fgetcsv($commandFile);
while (($commandRow = fgetcsv($commandFile, 1000, ',')) !== false) {
    $commandData[] = [$commandRow[0]]; // Assuming text is in the first column
    $commands[] = $commandRow[1]; // Assuming commands are in the second column
}
fclose($commandFile);

// Train the model for command classification
$classifierCommand = new NaiveBayes();
$classifierCommand->train($commandData, $commands);

// Define stop words for command classification and their corresponding labels
$stopWordsTocommand= [
    'ရှာ' => 'search',
    'ရေး' => 'write',
    'ပြ' => 'search',
    'သွား' => 'go',
    'တိုင်း' => 'calculate',
];

// Input stop word
$inputStopWord = $match['Verb']; // Example input

// Extract the word from the input
$inputWord = null;
foreach ($stopWordsTocommand as $stopWord => $Command) {
    if (mb_strpos($inputStopWord, $stopWord, 0, 'UTF-8') !== false) {
        $inputWord = $stopWord;
        break;
    }
}

// Convert input stop word to lowercase for case insensitivity
$inputWordLower = mb_strtolower($inputWord, 'UTF-8');

// Predict command label based on stop word
$predictedCommand = $stopWordsTocommand[$inputWordLower] ?? 'unknown';

if ($predictedCommand == 'search') {
    // Check if the label is set
    if (isset($predictedsubLabel)) {
        // Get the label from the request
        $searchLabel = $predictedsubLabel;

        // Prepare SQL statement to search for the location by label
        $sql = "SELECT label FROM location_data WHERE label = ?";
        
        // Check if the database connection is successful
        if ($stmt = $con->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("s", $searchLabel);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Get the result
                $result = $stmt->get_result();

                // Check if a location with the given label exists
                if ($result->num_rows > 0) {
                    // Location found, retrieve its label
                    $row = $result->fetch_assoc();
                    $locationLabel =  $row['label'];
                    $response = ['success' => true, 'label' => $locationLabel];
                } else {
                    // Location not found
                    $response = ['success' => false, 'message' => 'Location not found.'];
                }
            } else {
                // Error executing SQL statement
                $response = ['success' => false, 'message' => 'Error executing SQL statement.'];
            }
            
            // Close the statement
            $stmt->close();
        } else {
            // Error preparing SQL statement
            $response = ['success' => false, 'message' => 'Error preparing SQL statement.'];
        }
    } else {
        // Label not provided in the request
        $response = ['success' => false, 'message' => 'Label not provided in the request.'];
    }
} else {
    // Invalid command
    $response = ['success' => false, 'message' => 'Invalid command.'];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$con->close();

?>