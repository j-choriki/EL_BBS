<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>夏鍋食おうぜ！</title>
</head>
<body class="p-3 mb-2 bg-primary bg-gradient">
<header>
    <h1>夏鍋食おうぜ！</h1>
</header>
<main>
    <div>
    </div>
    <section>
        <form action="./index.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">ニックネーム</label>
                <input type="text" id="name" name="name" class="form-group">
            </div>
            <div class="form-group">
                <label for="post">熱い思い</label>
                <textarea name="post" id="post" cols="30" class="form-group"></textarea>
            </div>
            <div class="form-group">
                <label for="image">画像</label>
                <input type="file" id="image" name="image" class="form-group">
            </div>
            <button type="submit" class="btn btn1">届け熱い思い！！！！</button>
        </form>
    </section>

    <section>
        <?php foreach ($list as $key => $data):?>
            <div  class="border">
                <div class="flex" id="<?php echo $data['id'];?>">
                    <p>ニックネーム：<?php echo $data['name']; ?></p>
                    <p><?php echo $data['time'];?></p>
                    <div class="show_flex">
                    <p><img src="../uploads_img/<?php echo $data['id']; ?>.png" width="200"></p>
                    <p><?php echo $data['msg']?></p>
                    </div>
                    
                </div>
                
                <button class="btn_atsui"><img src="../img/netsu.jpeg" alt="" width="50"><span class="good_num"><?= $data['good']; ?><span></button>
            </div>
        
        <?php endforeach;?>
    </section>

</main>
<script src="../js/index.js"></script>
</body>
</html>