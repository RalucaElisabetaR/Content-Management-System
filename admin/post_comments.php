<?php include "includes/admin_header.php" ?>

<div id="wrapper">

  <!-- Navigation -->
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <h1 class="page-header">
            Welcome to Comments,
            <small>User</small>
          </h1>
          <?php
          if (isset($_POST['checkBoxArray'])) {


            foreach (($_POST['checkBoxArray']) as $commentValueId) {

              $bulk_options = $_POST['bulk_options'];

              switch ($bulk_options) {
                case 'approve':

                  $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId} ";

                  $update_to_approved_status = mysqli_query($connection, $query);

                  confirmQuery($update_to_approved_status);


                  break;


                case 'pending':

                  $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId} ";

                  $update_to_pending_status = mysqli_query($connection, $query);

                  confirmQuery($update_to_pending_status);


                  break;



                case 'delete':

                  $query = "DELETE FROM comments WHERE comment_id = {$commentValueId} ";

                  $update_to_delete = mysqli_query($connection, $query);

                  confirmQuery($update_to_delete);


                  break;
              }
            }
          }




          ?>
          <form action="" method='post'>

            <table class="table table-bordered table-hover">

              <div id="bulkOptionsContainer" class="col-xs-4">

                <select class="form-control" name="bulk_options" id="">
                  <option value="">Select Options</option>
                  <option value="approve">Approve</option>
                  <option value="pending">Reject</option>
                  <option value="delete">Delete</option>
                </select>

              </div>


              <div class="col-xs-4">

                <input type="submit" name="submit" class="btn btn-success" value="Apply">

              </div>


              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>In Response To</th>
                    <th>Date</th>
                    <th>Approve</th>
                    <th>Reject</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']);
                  $select_comments = mysqli_query($connection, $query);
                  while ($row = mysqli_fetch_assoc($select_comments)) {
                    $comment_id = $row['comment_id'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_email = $row['comment_email'];
                    $comment_status = $row['comment_status'];
                    $comment_date = $row['comment_date'];


                    echo "<tr>";

                  ?>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>
                  <?php


                    echo "<td>$comment_id </td>";
                    echo "<td>$comment_author</td>";
                    echo "<td>$comment_content</td>";

                    //
                    //        $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                    //        $select_categories_id = mysqli_query($connection,$query);
                    //
                    //        while($row = mysqli_fetch_assoc($select_categories_id)) {
                    //        $cat_id = $row['cat_id'];
                    //        $cat_title = $row['cat_title'];
                    //
                    //
                    //        echo "<td>{$cat_title}</td>";
                    //
                    //        }
                    //

                    echo "<td>$comment_email</td>";
                    echo "<td>$comment_status</td>";


                    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                    $select_post_id_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                      $post_id = $row['post_id'];
                      $post_title = $row['post_title'];

                      echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    }

                    echo "<td>$comment_date</td>";
                    echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . "'>Approve</a></td>";
                    echo "<td><a href='post_comments.php?pending=$comment_id&id=" . $_GET['id'] . "'>Reject</a></td>";
                    echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                  }
                  ?>

                </tbody>

              </table>
          </form>

          <?php


          if (isset($_GET['approve'])) {



            $the_comment_id = $_GET['approve'];
            $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = $the_comment_id ";
            $approve_comment_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=$comment_post_id");
            exit;
          }


          if (isset($_GET['pending'])) {

            $the_comment_id = $_GET['pending'];
            $query = "UPDATE comments SET comment_status = 'pending' WHERE comment_id = $the_comment_id ";
            $reject_comment_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=$comment_post_id");
            exit;
          }


          if (isset($_GET['delete'])) {
            $the_comment_id = $_GET['delete'];
            $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
            $delete_query = mysqli_query($connection, $query);
            header("Location: post_comments.php?id=$comment_post_id");
            exit;
          }


          ?>
        </div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include 'includes/admin_footer.php' ?>