<?php
    require_once 'vendor\autoload.php';

    use Aries\Dbmodel\Models\Task;

    $task = new Task();

    if(!isset($_POST['id'])) {
        die("Error");
    }

    $id = $_POST['id'];
    $taskInfo = $task->getTask($id);

    if(isset($_POST['submit'])) {
        $task->updateTask([
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'status' => $_POST['status']
        ]);
        header("Location: index.php");
        exit();
    }

    if(isset($_POST['delete'])) {
        $task->deleteTask($_POST['id']);
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List App</title>
    <style>
        body {
            background-color: #23272a;
            color: white;
        }

        h1 {
            font-family: 'Monaco', monospace;
        }

        input[type="submit"] {
            background-color: #30383D;
            color: white;
            border-style: none;
            border-radius: 10px;
            cursor: pointer;
            padding: 5px 10px;
        }

        button {
            background-color: #30383D;
            color: white;
            border-style: none;
            border-radius: 10px;
            cursor: pointer;
            padding: 5px 10px;
        }

        input[name="submit"] {
            margin-left: 5px;
        }

        button {
            margin-top: 5px;
        }

        .menu-buttons {
            margin-top: 5px;
            
        }

        select {
            background-color:  #30383D;
            color: white;
            padding: 3px ;
        }

        table {
            border-collapse: collapse;
            font-family: Arial;
        }

        .table-buttons {
            display:flex;
            gap: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-style: solid;
            border-color:rgb(84, 95, 102);
        }

        input[type="text"] {
            background-color: #30383D;
            border-style: none;
            padding: 5px 10px;
            color: white;
        }
    </style>
</head>
<body>
    <h1>List of Tasks</h1>
    <div>
        <?php
            // get all users from the database and return as an array then loop it inside foreach to create a list
            $tasks = $task->getTasks();
            echo '<table>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>';

                foreach ($tasks as $key => $value) {
                                          // <option value="not-completed" "' . $taskInfo['status'] == 'not-completed' ? 'selected' : '' . '">not-completed</option>
                                    // <option value="completed" "' . $taskInfo['status'] == 'completed' ? 'selected' : '' . '">completed</option>

                    if($value['id'] == $taskInfo['id'])  {
                        if($taskInfo['status'] == "completed") {
                            $status = "not-completed";
                        } else {
                            $status = "completed";
                        }
                        echo 
                        '<form method="POST" action="edit_task.php"> 
                        <tr>
                            <td> <input type="text" name="name" value="' . $taskInfo['name'] . '" required> </td>
                            <td>    
                                <select id="status" name="status">
                                    <option value="' . $taskInfo['status'] . '">' . $taskInfo['status'] . '</option>
                                    <option value="' . $status . '">' . $status . '</option>
                                </select>
                            </td>
                            <td>
                                <div class="table-buttons">
                            <input type="hidden" name="id" value="' . $value['id'] . '">
                            <input type="submit" name="submit" value="submit"> 
                                    <form method="POST" action="edit_task.php">
                                        <input type="hidden" name="id" value="' . $value['id'] . '">
                                        <input type="submit" name="delete" value="Delete">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        </form>';
                        continue;
                    }
                    echo 
                    '<tr>
                        <td>' . $value['name'] . '</td>
                        <td>' . $value['status'] . '</td>
                        <td>
                            <div class="table-buttons">
                                <form method="POST" action="edit_task.php">
                                    <input type="submit" name="submit" value="submit"> 
                                </form>
                                <form method="POST" action="add_task.php">
                                    <input type="submit" name="delete" value="Delete">
                                </form>
                            </div>
                        </td>
                    </tr>';
                }
            echo 
            '</table>';
        ?>
    </div>
    <div class = "menu-buttons">
    </div>
        <form action="index.php">
            <button>Cancel</button>
        </form>
</body>
</html>
