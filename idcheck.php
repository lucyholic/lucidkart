<?php

session_start();
require("config/config.php");
require("lib/db.php");
$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);


if (!isset($_SESSION['create']))
{
    echo '<script>alert("Invalid Access");
        window.close();</script>';
}

$message = "";
$isOK = false;

if (isset($_POST['idCheck']))
{
    $id = mysqli_real_escape_string($conn, $_POST['txtId']);
    $sql = "SELECT 0 FROM customer WHERE userId = '".$id."'";
    $result = mysqli_query($conn, $sql);

    if ($result -> num_rows != 0)
    {
        
    }    
}

?>

<div id="message">
<span style="color: red; font-weight: bold"><?= $message ?></span>
</div>

ID Duplication Check
<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" onsubmit="return ID_Check();">
<input type="text" name="txtId" id="txtId" placeholder="Enter ID" />
<input type="submit" name="idCheck" id="idCheck" value="Check" />
</form>

<script>

function ID_Check()
{
    let id = document.getElementById('txtId').value + "";
    let error = "";

    if(id.trim() == "")
        error = "Enter ID";

    if(error == "") 
        return true;
    else
    {
        document.getElementById('message').innerHTML = '<span style="color: red; font-weight: bold">' + error + '</span>';
        return false;
    }
        
}

<script>

<?php

?>