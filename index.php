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

if (isset($_GET['remove'])) {

    $remove_i = $_GET['remove'];
    unset($data[$remove_i]);
    $data = array_values($data);

}

if (isset($_GET['done'])) {

    $done_i = $_GET['done'];
    $data[$done_i]["done"] = true;

}
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
        <div class="form-container">
            <form class="add-form" action="index.php" method="POST">
                <label for="todo-item">Add an item</label>
                <input type="text" id="todo-item" name="todo-item" value="">
                <input type="hidden" name="action" value="add-item">
                <input type="submit" value="Add">
            </form>
        </div>
    </div>

    <div class="page-container">
        <div class="list-container">

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if ($_POST["action"] == "add-item") {
                    $newTask = [
                        "task" => htmlspecialchars($_POST['todo-item']),
                        "done" => false
                    ];

                    $data[] = $newTask;

                } else if ($_POST["action"] == "edit-item") {


                    $index = $_POST["edit-index"];
                    $data[$index]["task"] = htmlspecialchars($_POST['edit-item']);

                }

            }

            $counter = 0;
            foreach ($data as $item) {

                $editing = false;

                echo '<div class="list-item"><p>';

                if (isset($_GET['edit'])) {

                    $edit_i = $_GET['edit'];

                    if ($counter == $edit_i) {
                        $editing = true;

                        $form_text = $data[$edit_i]['task'];

                        echo '<div class="form-container">';
                        echo '<form class="edit-form" action="index.php" method="POST">';
                        echo '<label for="edit-item"></label>';
                        echo "<input type=\"text\" id=\"edit-item\" name=\"edit-item\" value=\"$form_text\">";
                        echo '<input type="hidden" name="action" value="edit-item">';
                        echo "<input type=\"hidden\" name=\"edit-index\" value=$edit_i>";
                        echo '<input type="submit" value="Save">';
                        echo '</form>';
                        echo '</div>';
                    }

                } else {
                    $edit_i = 999;
                }


                if (!$editing) {
                    echo $item["task"];

                    echo '<div class="controls-container">';

                    if ($item["done"]) {
                        echo '<div class="fake-done">✓</div>';
                    } else {
                        echo "<button onclick=\"location.href='?done=$counter'\" class=\"done-button\">✓</button>";
                    }

                    echo "<button onclick=\"location.href='?edit=$counter'\" class=\"edit-button\">Edit</button>";
                    echo "<button onclick=\"location.href='?remove=$counter'\" class=\"delete-button\">X</button>";
                    echo "</div>";
                }
                echo "</div>";

                $counter += 1;
            }

            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            ?>
        </div>
    </div>
</body>
</html>