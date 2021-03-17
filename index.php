<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
  <div class="row">


    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <?php


      $per_page = 6;


      if (isset($_GET['page'])) {

        $page = $_GET['page'];
      } else {
        $page = "";
      }
      if ($page == "" || $page == 1) {
        $page_1 = 0;
      } else {
        $page_1 = ($page * $per_page) - $per_page;
      }


      $post_query_count = "SELECT * FROM posts";
      $find_count = mysqli_query($connection, $post_query_count);
      $count = mysqli_num_rows($find_count);

      $count = ceil($count / $per_page);




      $query = "SELECT * FROM posts LIMIT $per_page";
      $select_all_posts_query = mysqli_query($connection, $query);


      while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = substr($row['post_content'], 0, 100);
        $post_status = $row['post_status'];
        if ($post_status == 'published') {

      ?>

          <!-- First Blog Post -->


          <h2>
            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
          </h2>
          <p class="lead">by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>" </a><?php echo $post_author; ?></p>
          <p>
            <span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?>
          </p>
          <hr />

          <a href="post.php?p_id=<?php echo $post_id; ?>"></a>

          <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="" />
          <hr />
          <p>
            <?php echo $post_content; ?>
          </p>
          <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

          <hr />



      <?php }
      }

      ?>


    </div>

    <!-- Blog Sidebar Widgets Column -->
    <?php include "includes/sidebar.php"; ?>



  </div>
  <!-- /.row -->

  <hr />
  <?php


  ?>

  <nav aria-label="...">
    <ul class="pagination">
      <li class="page-item">
        <a class='page-item' class="page-link" href='?page=<?php
                                                            if ($page > 1) {
                                                              echo $page - 1;
                                                            } else {
                                                              echo $page;
                                                            } ?>'>Previous</a>

      </li>


      <?php


      for ($i = 1; $i < $count; $i++) {

        if ($i == $page) {

          echo "<li class='page-item active'><a class='page-link' href='?page=$i'>{$i}</a></li>";
        } else {

          echo "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
        }
      }


      ?>
      <li class="page-item">
        <a class='page-item' class="page-link" href='?page=<?php
                                                            if ($page < $count) {
                                                              echo $page + 1;
                                                            } else {
                                                              echo $page;
                                                            } ?>'>Next</a>

      </li>

      </li>




      </li>


    </ul>
  </nav>
  <?php include "includes/footer.php"; ?>