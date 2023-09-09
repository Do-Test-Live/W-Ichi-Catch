<?php
require_once ('../include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$fetch_pro = $db_handle->runQuery("SELECT * FROM `gifts`");


if(isset($_POST['update_pro'])){
    $g1 = $db_handle->checkValue($_POST['g1']);
    $g2 = $db_handle->checkValue($_POST['g2']);
    $g3 = $db_handle->checkValue($_POST['g3']);
    $g4 = $db_handle->checkValue($_POST['g4']);
    $g5 = $db_handle->checkValue($_POST['g5']);
    $g6 = $db_handle->checkValue($_POST['g6']);
    $g7 = $db_handle->checkValue($_POST['g7']);
    $g8 = $db_handle->checkValue($_POST['g8']);
    $g9 = $db_handle->checkValue($_POST['g9']);

    $update = $db_handle->insertQuery("UPDATE `gifts` SET `gift1`='$g1',`gift2`='$g2',`gift3`='$g3',`gift4`='$g4',`gift5`='$g5',`gift6`='$g6',`gift7`='$g7',`gift8`='$g8',`gift9`='$g9' WHERE id = '1'");
    if($update){
        echo "<script>
alert('Data Updated Successfully!');
window.location.href = 'login.php';
</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2>Gift Winning Probability</h2>
    <form action="#" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 1</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g1" value="<?php echo $fetch_pro[0]['gift1'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 2</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g2" value="<?php echo $fetch_pro[0]['gift2'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 3</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g3" value="<?php echo $fetch_pro[0]['gift3'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 4</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g4" value="<?php echo $fetch_pro[0]['gift4'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 5</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g5" value="<?php echo $fetch_pro[0]['gift5'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 6</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g6" value="<?php echo $fetch_pro[0]['gift6'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 7</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g7" value="<?php echo $fetch_pro[0]['gift7'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 8</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g8" value="<?php echo $fetch_pro[0]['gift8'];?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Gift 9</label>
            <input type="text" class="form-control" id="" aria-describedby="emailHelp" name="g9" value="<?php echo $fetch_pro[0]['gift9'];?>">
        </div>


        <button type="submit" name="update_pro" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
