<?php 
    require_once 'inc/functions.php';
    $confirmation = '';
    $task = $_GET['task']??'report';
    if('seed'==$task){
        seed();
        $confirmation = 'Data siding is complete';
    }else{
        $confirmation = 'Something Is wrong';
    }
    $error = '';
    $name = '';
    $age = '';
    $roll = '';
    if(isset($_POST['submit'])){
        $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_STRING );
        $age = filter_input(INPUT_POST,'age', FILTER_SANITIZE_STRING );
        $roll = filter_input(INPUT_POST,'roll', FILTER_SANITIZE_STRING );
        $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING );
        if($id){
            $update = updateStudent($id, $name, $age, $roll);
            if($update){
                header("location: index.php?task=report");
            }else{
                $error = 404;
            }
        }else{
            if($name !='' && $age !='' && $name !='' ){
                $studentSubmit = addStudent($name, $age, $roll);
                if($studentSubmit){
                    header("location: index.php?task=report");
                }else{
                    $error = 404;
                }
            }
        }

    }
    if('delete'==$task){
        $id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
        if($id>0){
            delete($id);
            header('location: index.php?task=report');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <header class="app-header">
                    <h1>Students Info</h1>
                    <p>Your Students Management Dashboard, You can change your all students information hare</p>
                    <hr>
                    <?php include_once ('templates/nav.php'); ?>
                </header>
            </div>
        </div>

        <div class="row">
            <div class="column column-60 column-offset-20">
                <div class="inner-content">
                <?php test(); ?>
                    <?php 
                        if('seed'==$task){
                            echo '<hr>';
                            echo $confirmation;
                        }
                     ?>
                    <hr>
                    <?php 
                        if('report'==$task){
                            echo "<h2>All Students data</h2>";
                            echo '<hr>';
                            generateReport();
                        } 
                    ?>
                </div>
            </div>
        </div>
        <?php if('add'==$task): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action="index.php?task=add" method="POST">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll">
                        <button type="submit" name="submit" class="button button-primary">Submit</button>
                    </form>
                </div>
            </div>
        <?php endif;  ?>

        <?php 
            if('edit'==$task):
                $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_STRING );
                $student = getStudent($id);
            if($student):
        ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action="index.php?task=edit" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?php echo $student['name']; ?>">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" value="<?php echo $student['age']; ?>">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
                        <button type="submit" name="submit" class="button button-primary">Update</button>
                    </form>
                </div>
            </div>
        <?php 
        endif;
        endif;
      ?>
    </div>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>