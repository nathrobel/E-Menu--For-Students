<?php
  require_once('./api/connect.php');
  $filters = [];
  // echo is_numeric(6);
  foreach ($_GET as $key => $value) {
    // echo $key."[".is_numeric($key).']->'.$value.'['.is_numeric($value).']<br/>';
    if(is_numeric($key) and is_numeric($value)){
      array_push($filters, $value);
    }
  }
  // echo "Filters: ".json_encode($filters)."<br/>";
  if(count($filters)>0){
    $query_tag = 'SELECT `menu` FROM `recipe_terms` WHERE';
    foreach ($filters as $value){
      $query_tag .= ' `tag` = ' . $value . ' OR';
    }
    $query_tag .= 'DER BY `menu`';
    $result_tag = $conn->query($query_tag);
    $array = [];
    $curr_recipe_id = -1;
    $curr_recipe_count = 0;
    $eligiable_menus = [];
    while($row = $result_tag->fetch_array()){
        if($row['menu']!=$curr_recipe_id){
          $curr_recipe_id = $row['menu'];
          $curr_recipe_count = 0;
        }
        $curr_recipe_count += 1;
        if($curr_recipe_count == count($filters)){
          array_push($eligiable_menus, $curr_recipe_id);
        }
    }
    // echo "Eligiable: ".json_encode($eligiable_menus).'<br/>';
    if(count($eligiable_menus)<=0){
      $query_append = ' AND `id` = -1';
    }else{
      $query_append = ' AND `id` IN ('.implode(",",$eligiable_menus).') ';
    }
  }else{
    $query_append = '';
  }
  if(empty($_GET['s'])){
    $keyword_append = ' `id` > 0 ';
  }else{
    $keyword_append = '(`name` LIKE '.anti_injection_alter('%'.$_GET['s'].'%').' OR `description` LIKE '.anti_injection_alter('%'.$_GET['s'].'%').') ';
  }
  $query = 'SELECT `id`,`name`,`description`,`calorie`,`time`,`cover` FROM `recipe` WHERE '.$keyword_append.' '.$query_append.' ;';
  // echo $query;
  $result = $conn->query($query);
?>
<!DOCTYPE html>
<html class="c86moe mmfb" lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="initial-scale=1, minimum-scale=1, width=device-width" name="viewport">
    <title>
      Search Results - E-Menu
    </title>
    <link href="https://eruthyll.net/css/maia.css" rel="stylesheet">
  </head>
  <body>
    <div class="maia-header" id="maia-header">
      <div class="maia-aux">
        <h1>
          <a href="/">
            E-Menu
          </a>
        </h1>
        <h2>
            &nbsp; Search Results
        </h2>
      </div>
    </div>
    <div id="maia-main">
      <?php
      if ( $result->num_rows>0 ) {
        while($row = $result->fetch_array()){?>
          <div class="maia-object">
          <h2><?php echo $row['name']; ?></h2>
          <?php
            if(strlen($row['cover']) > 0) {?>
              <img src="<?php echo $row['cover']; ?>" alt="Cover image">
          <?php } ?>
          <p><?php echo $row['calorie'].' cals · '.$row['time'].'min(s)'; ?></p>
          <p><?php echo $row['description']; ?><p>
          <hr />
          <p><b><a href="/recipe.html?recipeid=<?php echo $row['id']; ?>">View full context >>></a></b></p>
          </div>
        <?php }
      }else{ ?>
          <h4>No content found.</h4>
          <p>Try search again?</p>
      <?php } ?>
    </div>
    <div id="maia-signature"></div>
    <div class="maia-footer" id="maia-footer">
      <div id="maia-footer-global">
        <div class="maia-aux">
          <ul>
            <li>
                <a href="/">E-Menu for Students</a>
            </li>
            <li>
                &copy; 2021-2022 COMP10120 Group X8, Department of Computer Science, University of Manchester, UK.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>