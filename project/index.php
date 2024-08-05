<?php
    require_once("./api/connect.php");
    $tax_query = "SELECT * FROM `tax`;";
    $tax_result = $conn->query($tax_query);
    $result = [];
    for ($x = 0; $x < $tax_result->num_rows; $x++) {
        $tax_result->data_seek($x);
        $tax_data = $tax_result->fetch_array();
        
        $query_tag = "SELECT * FROM `tag` WHERE `father`=".$tax_data['id'].";";
        $result_tag = $conn->query($query_tag);
        $tags = array();
        for ($y = 0; $y < $result_tag->num_rows; $y++) {
            $result_tag->data_seek($y);
            $tag_data = $result_tag->fetch_array();
            array_push($tags, ['id'=>(int)$tag_data['id'], 'name'=>$tag_data['name']]);
        }
        
        $curr_tax = ['id' => $tax_data['id'], 'name' => $tax_data['name'], 'elements' => $tags];
        array_push($result, $curr_tax);
    }
    $filters = $result;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>E-Menu</title>
  <link rel="stylesheet" href="function.css">
  <link rel="stylesheet" href="frontpage.css">
  <link rel="stylesheet" href="search.css">
  <link rel="stylesheet" href="description.css">
  <link rel="stylesheet" href="report.css">
  <script src="popup.js"> </script>
</head>

<body>
  <div class="header">
    <img id="Logo" src="logo.png" alt="Logo" width="175" height="175">
    <h1 id="maintitle">E-Menu for Students</h1>
    <p id="par1">An ideal place for online recipes</p>
  </div>
  <form action="/search.php" method="get">
  <div class="search" action="action_page.php">
      <input type="text" placeholder="What do you want to cook today? " name="s">
      <button type="submit">&#128269;</button>
  </div>
  <div class="function" id="function-1">
    <div class="overlay"></div>
    <div class="maincon">
      <div class="close_btn" onclick="togglePopup()">&times;</div>
      <h2>Advanced Search</h2>
      <div class="wrap-collabsible">
        <br>
        <?php
            foreach ($filters as $this_category) {
                echo '<select id="tax_'.$this_category['id'].'" name="'.$this_category['id'].'" size="1" tabindex="2" class="accordion-select">';
                echo '<option value selected>Any '.$this_category['name'].'</option>';
                foreach ($this_category['elements'] as $this_tag) {
                    echo '<option value="'.$this_tag['id'].'">'.$this_tag['name'].'</option>';
                }
                echo '</select>';
            }
        ?>
          <br>
          <br>
          <br>
          <button type="submit"><img src="searchbutton.png" alt="Search" width="40" height="40"></button>
      </div>
      </form>
    </div>
  </div>
  <button onclick="togglePopup()" id="advsearch">Advanced Search</button>
  <button onclick="location.href='/lucky.php';" id="lucky">Feeling Lucky?</button>
  <div class="description">
    <h2>Description</h2>
    <p id="par2">Ever stared at your section of the fridge, with no idea of what to make?<br>
      Got dietary requirements? Feeling like a specific cuisine? Kitchen's oven is broken again? No problem; we've got
      you covered!<br>
      Use the search function to find a recipe, or narrow down your choices with the 'Advanced Search' function!</p>
  </div>

  <footer>
    <p id="parAdd"> If you have any new recipe suggestions, let us know!
      <a href="https://forms.office.com/pages/responsepage.aspx?id=B8tSwU5hu0qBivA1z6kad59lss_JtbtNhg2cshhfjydUOEI3QVkwRE1WU0lYQTlWNUFDN0hDOUE3Mi4u"
        target="_blank"> Suggestions</a>
      &nbsp; | &nbsp; If you encounter any issues, please let us know!
      <a href="https://forms.office.com/Pages/ResponsePage.aspx?id=B8tSwU5hu0qBivA1z6kadxxsuxBT9pdKmnFoW_1JARRURFk1VFkzVURWSTdXMkZFT1pNNUlSMUIxWi4u"
        target="_blank"> Report </a>
    </p>
  </footer>
</body>

</html>