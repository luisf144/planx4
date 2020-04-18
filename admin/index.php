<?php include "includes/header.php"; ?>
   
    <div id="wrapper">
        
        <!-- Navigation -->
        <?php include "includes/navigation.php";  ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php include "includes/breadcrumb.php"; ?>
                    </div>
                </div>
                <!-- /.row -->
                
                 <?php 
                            
                $query = "SELECT * FROM posts";
                $select_all_posts = mysqli_query($connection, $query);
                $post_count = mysqli_num_rows($select_all_posts);
                                
                $query = "SELECT * FROM comments";
                $select_all_comments = mysqli_query($connection, $query);
                $comments_count = mysqli_num_rows($select_all_comments);
                                
                $query = "SELECT * FROM users";
                $select_all_users = mysqli_query($connection, $query);
                $users_count = mysqli_num_rows($select_all_users);
                                
                $query = "SELECT * FROM categories";
                $select_all_categories = mysqli_query($connection, $query);
                $categories_count = mysqli_num_rows($select_all_categories);                

                $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                $select_all_draft_posts = mysqli_query($connection, $query);
                $posts_draft_count = mysqli_num_rows($select_all_draft_posts);
                
                $query = "SELECT * FROM posts WHERE post_status = 'published'";
                $select_all_published_posts = mysqli_query($connection, $query);
                $posts_published_count = mysqli_num_rows($select_all_published_posts);
                                
                $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                $unapproved_comments = mysqli_query($connection, $query);
                $unapproved_comments_count = mysqli_num_rows($unapproved_comments);
                                
                $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                $select_all_subscribers = mysqli_query($connection, $query);
                $subscribers_count = mysqli_num_rows($select_all_subscribers);
                
                
                $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_views_count DESC LIMIT 10 ";
                $select_all_posts_most_views = mysqli_query($connection, $query);
                $posts_most_views_count = mysqli_num_rows($select_all_posts_most_views);
               
                            
                 ?>        
                                    
                       
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    
                                  <div class='huge'><?php echo $post_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                     <div class='huge'><?php echo $comments_count; ?></div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $categories_count; ?></div>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row  -->
                
                
               
                <div class="row">
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
                            
                        <?php 
                        
                            $elements_text = ['All Posts','Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 
                                              'Users', 'Subscribers', 'Categories'];
                            $elements_count = [$post_count, $posts_published_count, $posts_draft_count, $comments_count,
                                               $unapproved_comments_count, $users_count, $subscribers_count, $categories_count];
                         
                            
                            for($i = 0; $i < count($elements_text); $i++){ 
                                echo "['$elements_text[$i]', $elements_count[$i]],";
                                
                            }
                            
                        ?>    
                            
                            
                         
                          
                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                    
                    <div id="columnchart_material" class="chart-material"></div>
                </div>
                
                
                <div class="row" style="margin-top:60px">
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Posts Most Viewed', 'Count'],
                            
                        <?php 
                          
                            while($row = mysqli_fetch_assoc($select_all_posts_most_views)){
                             
                                echo "[' ". $row['post_title'] ."', ". $row['post_views_count']. "], ";
                                
                            }
                            
                        ?>    
                            
                            
                         
                          
                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material2'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                    
                    <div id="columnchart_material2" class="chart-material"></div>
                </div>
                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
    <?php include "includes/footer.php"; ?>

   