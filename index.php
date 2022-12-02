<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP期末報告</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="static">Conmou's Plan</div>
        <ul class="dynamic">
            <li><span>What's your plan for today...</span></li>
        </ul>
    </div>

    <div class="main-section">
        <div class="reset">
            <form>
                <input type="button" onclick="location.href='index.php'" value="- - - - - F5 - - - - -"/>
            </form>
        </div>

        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                    <input type="text" 
                    name="title"
                    style="border-color: #F5B7B1" 
                    placeholder="給我填喔"/>
                <button type="submit">Add &nbsp;<span>&#43</span></button>

                <?php } else {?>
                <input type="text" 
                    name="title" 
                    placeholder="你要做啥嘞?"/>
                <button type="submit">Add &nbsp;<span>&#43</span></button>
                <?php } ?>
            </form>
        </div>

        <?php
            session_start();
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>

        <div class="show-image">
            <?php if($todos->rowCount() > 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/gawr-gura-gura.gif" width="40%"/>
                        <br>
                        <img src="img/ellipsis6.gif" width="80px"/>
                    </div>
                </div>
            <?php } else{ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/gura.gif" width="70%"/>
                        <br>
                        <img src="img/gura-gawr-gura.gif" width="80px"/>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <div class="show-todo-section">
            <?php while($todo=$todos->fetch(PDO::FETCH_ASSOC)){ ?>
                <div class="cloume-item">
                    <span id="<?php echo $todo['id']; ?>" class="remove-to-do"> x </span>
                    <a href="index.php?action=edit&id=<?php echo $todo['id'];?>"><img src="img/edit.png" width="20px" class="edit-show"/></a>
                        <?php if($todo['checked']) { ?>
                            <input type="checkbox" 
                                    class="check-box"
                                    data-todo-id ="<?php echo $todo['id']; ?>"
                                    checked />
                            <h2 class="checked"><?php echo $todo["title"]; ?></h2>
                        <?php }else { ?>
                            <input type="checkbox" 
                                    class="check-box"
                                    data-todo-id ="<?php echo $todo['id']; ?>" />
                            <h2><?php echo $todo["title"]; ?></h2>
                        <?php } ?>
                        <br>
                        <small>created: <?php echo $todo["datetime"] ?></small>
                </div>
            <?php } ?>
        </div>

        <div class="search-to-do">
            <form action="app/search.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['seach']) && $_GET['seach'] == 'error'){ ?>
                    <input type="text"
                        name="title"
                        style="border-color: #F5B7B1"
                        placeholder="填了才能查阿!"/>
                    <button type="submit" name="Search">Search</button>
                <?php } else { ?>
                    <input type="text"
                        name="title"
                        placeholder="阿你要查啥 要先say阿?"/>
                    <button type="submit" class="search-click" name="Search">Search</button>
                <?php } ?>
            </form>
        </div>

        <div class="show-search">
            <?php
                if(isset($_SESSION['search'])){
                    $value=$_SESSION['search'];
                    $search=implode("<br>",$value);
                    echo $search;
            ?>
            <img src="img/gura-spin-guraspin-vtuber-cute-haha-wiiiy.gif" class="left"/>
            <img src="img/gura-spin-guraspin-vtuber-cute-haha-wiiiy.gif" class="right"/>
            <?php } else{ ?>
                <div class="empty">
                    <img src="img/reload-cat.gif" width="50%"/>
                </div>
            <?php } session_destroy();?>
        </div>

        <?php
            if(isset($_GET['action'])){
                require 'app/edit.php'; 
        ?>
            <div class="edit-to-do">
                <form action="app/edit.php?action=update&id=<?php echo $id ?>" method="POST" autocomplete="off">
                    <input type="text"
                            name="title"
                            value="<?php echo $title ?>"
                            placeholder="更新餒"/>
                    <button type="submit" class="update-to-do">Update</button>
                </form>
            </div>
        <?php } //} ?>
    </div>

    

    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            
            $('.remove-to-do').click(function(){
                const id=$(this).attr('id');
                //alert(id);
                $.post("app/delete.php",
                    {
                        id: id
                    },
                    (data) => {
                        if(data){
                            $(this).parent().hide(600);
                        }
                    }
                );
            });

            /*$('.edit-to-do').click(function(){
                const id=$(this).attr('edit-id');
                edit-id=< echo $todo['id']; 
            });*/

            /*$('.update-to-do').click(function(){
                const id=$(this).attr('edit-id');
            });*/
            
            $(".check-box").click(function(e){
                const id=$(this).attr('data-todo-id');
                
                $.post('app/check.php',
                    {
                        id: id
                    },
                    (data) => {
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if(data === '0'){
                                h2.addClass('checked');
                            }
                            else{
                                h2.removeClass('checked');
                            }
                        }
                    }
                );
            });

            /*$('.search-click').click(function(){
                getElementById("photo");
            });*/
        });
    </script>
</body>
</html>