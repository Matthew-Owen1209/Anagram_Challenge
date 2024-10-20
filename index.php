<?php

$file = null;

$contents_array = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //echo "POST request received!" . "<br>";

    if (isset($_FILES['text-file'])) {
        if ($_FILES['text-file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['text-file']['tmp_name'];
            //echo "File uploaded: " . htmlspecialchars($_FILES['text-file']['name']) . "<br>";

            $contents_array = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        } else {
            echo "<br>Error uploading: " . $_FILES['text-file']['error'] . "<br>";
        }
    } else {
        echo "<br>Error: File not set.<br>";
    }
}



// echo "<h1>Contents of the Dictionary File</h1>";
// echo "<pre>";
// print_r($contents_array);
// echo "</pre>";

$map = [];

foreach ($contents_array as $word) {
    if (strlen($word) <= 1) {
        continue;
    }

    $word_array = str_split($word);
    sort($word_array);
    $sorted_word = implode("", $word_array);

    // push the word to the map if the sorted word exists
    if (array_key_exists($sorted_word, $map)) {
        array_push($map[$sorted_word], $word);
    } else {
        $map[$sorted_word] = []; // create a new array if the sorted word does not exist
    }
}


$val_count = [];
$max_count = 0;
$anagram_result = [];
$anagram_word = "";



function getResults(&$map, &$max_count, &$anagram_result, &$anagram_word, &$val_count) {
    foreach ($map as $key => $value) {
        if (count($value) > $max_count) {
            $val_count[$key] = count($value);
            $max_count = count($value);
            $anagram_result = $value;
        }
    }
    $anagram_word = $anagram_result[0];
}

getResults($map, $max_count, $anagram_result, $anagram_word, $val_count);

//echo "Result: " . implode(", ", $anagram_result) . "<br>";
//echo "Anagram Count: " . $max_count . "<br>";

$response = [
    "result" => implode(", ", $anagram_result),
    "count" => $max_count,
    "word" => $anagram_word
];

header('Content-Type: application/json');
echo json_encode($response);


?>