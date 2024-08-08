<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
if(isset($_GET['transcript'])){
    $input=$_GET['transcript'];
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

// Output the match
// if (!is_null($match)) {
//     echo "Subject: " . $match['Subject'] . ", Noun: " . $match['Noun'] . ", Verb: " . $match['Verb'] . ", Object: " . $match['Object'] . "<br>";
// } 

require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Classification\NaiveBayes;
use Phpml\Tokenization\WordTokenizer;

// Define Burmese stop words
$stopWordsforlabel = [
    'ကျွန်တော်သည်','တပ်ရင်းမှူး','တပ်တည်','ဖွဲ့စည်းပုံ','တပ်ရင်း','တပ်မတော်','ဘယ်သူလဲ','ဘယ်မှာလဲ','ဘာလဲ','သိလား','တွေရဲ့','ရဲ့ဖွဲ့စည်းပုံ','ဖွဲ့စည်း','ထားလဲ','တိတိကျကျ','ထုတ်ပေးပါ','သိလို့ရမလား','ကို','က','မှ','တွင်','သည်','နေရာ','တွေ','ပြပါ','ပြ','ထိပ်တန်းလျှို့ဝှက်','ကို','အင်အား','သိချင်တယ်','တယ်','အင်အားကို','များများ','ဘယ်လောက်','နာမည်','တပ်မမှူး','တပ်မ','တပ်','အမည်','ကြေးနန်း','ကြေး','နန်း','မှတ်','ပုံ','တင်','အ','စီ','အ','ရင်','ခံ','စာ','အစီအရင်ခံစာ','တိုက်ပွဲ','ကျေးနန်း','ကြေးနန်းစာ','ကြေးနန်းစာမှတ်ပုံတင်','မှတ်ပုံတင်ကြေးနန်းစာ','နေ့စဉ်ကြေးနန်း','ကြေးနန်းစာပုံစံ','ထိတွေ့မှုကြေးနန်း','တိုက်ပွဲအစီအရင်ခံစာ','မြေပုံ',
];


// Load training data for label classification
$trainingData = [];
$labels = [];
$handle = fopen('data.csv', 'r');
// Skip the header row
fgetcsv($handle);
while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    // Tokenize the text
    $tokenizer = new WordTokenizer();
    $words = $tokenizer->tokenize($data[0]);

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


$inputnoun = $match['Noun'];
// Tokenize the input text
$tokenizer = new WordTokenizer();
$inputWordsnoun = $tokenizer->tokenize($inputnoun);

// Remove stop words for label classification
$filteredInputWordsLabel = array_diff($inputWordsnoun, $stopWordsforlabel);
// Convert filtered input words to string for label classification
$filteredInputTextLabel = implode(' ', $filteredInputWordsLabel);

// Predict label
$predictedLabel = $classifierLabel->predict([$filteredInputTextLabel]);


// Load training data for command classification
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

header('Content-Type: application/json; charset=utf-8');
// echo json_encode(['predictedLabel' => $predictedLabel, 'predictedCommand' => $predictedCommand], JSON_UNESCAPED_UNICODE);
echo json_encode($predictedLabel, JSON_UNESCAPED_UNICODE);

?>



