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

    $i = $_GET['remove'];
    unset($data[$i]);
    $data = array_values($data);

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
        <div class="list-container">
            <div class="form-container">
                <form class="add-form" action="index.php" method="POST">
                    <label for="todo-item">Add an item</label>
                    <input type="text" id="todo-item" name="todo-item" value="">
                    <input type="submit" value="Add">
                </form>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $newTask = [
                    "task" => htmlspecialchars($_POST['todo-item']),
                    "done" => false
                ];

                $data[] = $newTask;
            }

            $counter = 0;
            foreach ($data as $item) {

                echo '<div class="list-item"><p>';
                echo $item["task"];
                echo "</p>";
                echo "<button onclick=\"location.href='?remove=$counter'\" class=\"delete-button\">X</button>";
                echo "</div>";

                $counter += 1;
            }

            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            ?>
        </div>
    </div>
</body>
</html>