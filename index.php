<?php
$filename = "data.json";
$data = [];

if (file_exists($filename)) {
    $content = trim(file_get_contents($filename));

    if (!empty($content)) {
        $data = json_decode($content, true);

        if (!is_array($data)) {
            $data = [];
        }
    }
}

if (count($data) < 1) {
    $firstTask = [
        "task" => "Finish html",
        "done" => true
    ];

    $secondTask = [
        "task" => "Add php",
        "done" => false
    ];

    $thirdTask = [
        "task" => "Submit",
        "done" => false
    ];

    $fourthTask = [
        "task" => "Play SoT",
        "done" => false
    ];

    $data[][0] = $firstTask;
    $data[][1] = $secondTask;
    $data[][2] = $thirdTask;
    $data[][3] = $fourthTask;
}

file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>TODO List</title>
</head>
<body>
    <div class="page-container">
        <div class="list-container">
            <div class="form-container">
                <form class="add-form" action="/index.php?add=todo-item">
                    <label for="todo-item">Add an item</label>
                    <input type="text" id="todo-item" name="todo-item" value="">
                    <input type="submit" value="Add">
                </form>
            </div>
            <div class="list-item">
                <p>Finish html</p>
            </div>
            <div class="list-item">
                <p>Add php</p>
            </div>
            <div class="list-item">
                <p>Submit</p>
            </div>
            <div class="list-item">
                <p>Play SoT</p>
            </div>
        </div>
    </div>
</body>
</html>