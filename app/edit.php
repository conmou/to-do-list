
<?php
/*if(isset($_POST['id'])){
    require '../db_conn.php';
    
    $id=$_POST['id'];

    if(empty($id)){
        header("Location: ../index.php?edit=error");
    }
    else{
        $title=$_POST["title"];
        $stmt=$conn->prepare("UPDATE todos SET :title WHERE :id");
        $stmt->bindValue(':title',$title);
        $stmt->bindValue(':id',$id);
        //$stmt->execute([$title, $id]);
        $stmt->execute();

        if($stmt){
            header("Location: ../index.php?edit=success");
        else{
            header("Location: ../index.php");     
        }
        $conn=null;
        exit();
    }
}
else{
    header("Location: ../index.php?mess=error");
}*/

/*if(isset($_POST['id'])){
    require '../db_conn.php';
    
    $id=$_POST['id'];

    if(empty($id)){
        echo 'error';
    }
    else{
        $todos=$conn->prepare("SELECT title FROM todos WHERE id=?");
        $todos->execute([$id]);

        $todo=$todos->fetch();
        $uId=$todo['id'];

        $title=$_POST['title'];

        $res=$conn->query("UPDATE todos SET title=$title WHERE id=$uId");

        if($todo){
            $search=$todo->title;
            $_SESSION['searchu']=$search;
        }
        $conn=null;
        exit();
    }
}*/
    
/*if(isset($_POST['update'])){
    $id=$_POST['id'];
    $title=$_POST['title'];
    $stmt=$conn->prepare("UPDATE todos SET title=$title WHERE id=$id");
    header("Location: ../index.php?update=success");
}

/*if(isset($_POST['edit'])){
    require '../db_conn.php';
    
    $todos=$conn->prepare("SELECT title FROM todos WHERE id=?");
    $todos->execute([$id]);
    $todo=$todos->fetch();
    $uId=$todo['id'];
    $title=$todo['title'];

    $res=$conn->query("UPDATE todos SET title=$title WHERE id=$uId");
        /*if($res){
            echo $title;
        }
        else{
            echo "error";
        }
        $conn=null;
}*/

/*$title='';
if(isset($_GET['edit'])){
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $stmt=$conn->prepare("SELECT title FROM todos WHERE id=?");
        
    }
}*/
$sName="localhost";
$uName="root";
$pass="";
$db_name="to_do_list";

try{
    $conn=new PDO("mysql:host=$sName;dbname=$db_name",$uName,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $conn->query("SET NAMES utf8");
    //echo "成功";
}
catch(PDOException $e){
    echo "連結失敗 : ". $e->getMessage();
}
if(isset($_GET["id"])){
    $id=$_GET["id"];
}
if(isset($_GET["action"])){
    $action=$_GET["action"];
}
switch($action){
    case "update":
        $title=$_POST["title"];
        $todos=$conn->prepare("UPDATE todos SET title=:title WHERE id=:id ");
        //$todos->bindValue(':id',$id,':title',$title);
        $todos->execute(["id"=>$id,"title"=>$title]);
        //$todos=$conn->query("UPDATE todos SET title=$title WHERE id=$id");
        header("Location: ../index.php");
        break;
    case "edit":
        $todos=$conn->prepare("SELECT title FROM todos WHERE id=:id");
        //$todos->bindValue(':id',$id);
        $todos->execute(["id"=>$id]);
        $todo=$todos->fetch();
        /*$todos=$conn->query("SELECT title FROM todos WHERE id=$id");
        $todo=$todos->fetch();*/
        $title=$todo['title'];
        break;
}
?>
