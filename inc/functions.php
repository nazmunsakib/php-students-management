<?php
define('DB_NAME', 'c:/xampp/htdocs/PHP-projects/students-management/DB/data.txt');

function seed(){
    $students = [
        [
            "id" => 1,
            "name" => "Nazmun Sakib",
            "age" => 23,
            "roll" => 1,
        ],
        [
            "id" => 2,
            "name" => "Hasin Haydar",
            "age" => 45,
            "roll" => 2,
        ],
        [
            "id" => 3,
            "name" => "Ariful Islam",
            "age" => 22,
            "roll" => 3,
        ],
        [
            "id" => 4,
            "name" => "Leo Messi",
            "age" => 33,
            "roll" => 10,
        ],
        [
            "id" => 5,
            "name" => "Cristranu Ronaldu",
            "age" => 34,
            "roll" => 7,
        ],
    ];
    $serializeData = serialize($students);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX);
}

function generateReport(){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Roll</th>
            <th>Action</th>
        </tr>
            <?php foreach($students as $student): ?>
                <tr>
                <td><?php printf("%s", $student['name']); ?></td>
                <td><?php printf("%s", $student['age']);?></td>
                <td><?php printf("%s", $student['roll']);?></td>
                <td><?php printf("<a href='index.php?task=edit&id=%s'>Edit</a> | <a class='delete'  href='index.php?task=delete&id=%s'>Delete</a>", $student['id'],  $student['id']); ?></td>
                </tr>
            <?php endforeach; ?>
    </table>
    <?php

}

function addStudent($name, $age, $roll){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    $rollFound = false;
    foreach($students as $student){
        if($student['roll'] == $roll){
            $rollFound = true;
        }
    }
    if(!$rollFound){
        $student = [
            "id" => getId($students),
            "name" => $name,
            "age" => $age,
            "roll" => $roll,
        ];
        array_push($students, $student);
        $serializeData = serialize($students);
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        return true;
    }
    return false;
}

function test(){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);

    print_r($students);
}

function getId($students){
    $maxId = max( array_column($students, 'id'));
    return $maxId+1;
}

function getStudent($id){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $student){
        if($student['id']==$id){
            return $student;
        }
    }
    return false;
}

function updateStudent($id, $name, $age, $roll){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    $rollFound = false;
    foreach($students as $student){
        if($student['roll'] == $roll && $student['id'] != $id){
            $rollFound = true;
        }
    }
    if(!$rollFound){
        $students[$id -1]['name'] = $name;
        $students[$id -1]['age'] = $age;
        $students[$id -1]['roll'] = $roll;
        $serializeData = serialize($students);
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        return true;
    }
    return false;
}

function delete($id){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $offset=>$student){
        if( $student['id'] == $id){
            unset($students[$offset]);
        }
    }
    $serializeData = serialize($students);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX);

}