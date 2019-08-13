<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WatchList</title>
</head>
<body>
    <h4><a href="/">WatchList</a>| <?php echo $username;?></h4><hr><br>
    <hr><h4><a href="/<?php echo $username;?>/watched">Watched</a>|
            <a href="/<?php echo $username;?>/planned">Planned</a>|
            <a href="/<?php echo $username;?>/watching">Watching</a>|
            <a href="/<?php echo $username;?>/favourite">Favourite</a>
        </h4><h1><a href="/<?php echo $username;?>">All</a></h1><hr><br>
    <ul>
        <?php foreach($resultList as $wlkey => $list):?>
            <?php echo ucfirst($wlkey);?>
            <?php foreach($list as $key => $value):?>
                <li><?php echo $value;?></li>
            <?php endforeach;?>    
        <?php endforeach;?>
    </ul>
</body>
</html>