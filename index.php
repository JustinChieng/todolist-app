<?php 

$database = new PDO(
    'mysql:host=localhost;dbname=todo',
    'root',
    'root'
);

$query = $database->prepare('SELECT * FROM tasks');
$query->execute();

$tasks = $query->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
 {

    

if ($_POST['action'] === 'add') {
    $statement = $database->prepare(
        "INSERT INTO tasks (`name`) 
        VALUES (:name)
        "
    );
    $statement->execute([
        'name' => $_POST['task']
    ]);

    header('Location: /');
    exit;
}

if($_POST['action'] === 'delete') {
    $statement = $database->prepare(
        'DELETE FROM tasks WHERE id = :id' 
    );
    $statement->execute([
        'id' => $_POST['task_id']
    ]);

    header('Location: /');
    exit;
}

    
}


?>




<!DOCTYPE html>
<html>
  <head>
    <title>todo assignment</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }

      /* input[id=cb] {
     display: none;
    }    */

      input[id=cb]:checked~p.strikethrough {
      text-decoration: line-through;
      color: black;
      }


    </style>
  </head>
  <body>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">My Todo List</h3>
        <div class="mt-4">
            <?php foreach ($tasks as $task): ?>
                <div class=" mb-2 d-flex justify-content-between gap-1">
                <input class="form-check-input " 
                type="checkbox" id="cb" value="" name="cb' aria-label="...">
                    <p class="strikethrough"><?php echo $task['name']; ?></p>
                    <form method="POST"
                    action="<?php echo $_SERVER['REQUEST_URI'];?>">
                    <input type="hidden"
                            name="task_id"
                            value="<?php echo $task ['id'];?>"/>
                    <input type="hidden"
                            name="action"
                            value="delete"/>
                    <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    
                </div>
            <?php endforeach; ?>
          
        </div>
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <form method="POST" 
            action="<?php echo $_SERVER['REQUEST_URI']; ?>" 
            class="d-flex justify-content-between align-item-center" >
          <input
            type="text"
            class="form-control"
            placeholder="Add new item..."
            name="task" 
            required
          />
          <input type="hidden"
          name="action"
          value="add"/>
          <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
          </form>
        </div>
      </div>
    </div> 

    

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>