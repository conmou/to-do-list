<?php
session_start();
if(isset($_POST['title'])){
    require '../db_conn.php';
    
    $title=$_POST['title'];

    if(empty($title)){
        header("Location: ../index.php?seach=error");
    }
    else{
        /*$stmt=$conn->prepare("SELECT title FROM todos  WHERE title LIKE '%?%'");
        $stmt->execute([$title]);
        if($stmt){
            while($res = $stmt->fetch()){
                echo $res;
            }
            //header("Location: ../index.php?seach=success");
        }*/
        $stmt=$conn->prepare("SELECT title FROM todos WHERE title LIKE :title");
        $stmt->bindValue(':title','%'.$title.'%');
        $stmt->execute();
        if($stmt){
            while ($res = $stmt->fetch(PDO::FETCH_OBJ)){
                /*for($i=0;$i<10;$i++)
                    $searchfinal+=$res->title;*/
                //echo $searchfinal,"<br>";
                $searchfinal=$res->title;
                $a[]=$searchfinal;
                /*echo count($searchfinal),"<br>";
                echo $searchfinal,"<br>";
                /**/
            }
            $_SESSION['search']=$a;
            header("Location: ../index.php?seach=success");
            exit();
        }
        else{
            header("Location: ../index.php"); 
        }
        $conn=null;
        exit();
    }
}
else{
    header("Location: ../index.php?seach=error");
}
?> 