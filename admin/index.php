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
                $posts_draft_count = record_count("posts", "post_status = 'draft'");
                $posts_published_count = record_count("posts", "post_status = 'published'");
                $unapproved_comments_count = record_count("comments", "comment_status = 'unapproved'");
                $subscribers_count = record_count("users", "user_role = 'subscriber'");


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
                                    
                                  <div class='huge'><?php echo $post_count =record_count("posts"); ?></div>
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
                                     <div class='huge'><?php echo $comments_count= record_count("comments"); ?></div>
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
                                    <div class='huge'><?php echo $users_count = record_count("users"); ?></div>
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
                                        <div class='huge'><?php echo $categories_count = record_count("categories"); ?></div>
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
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>

        $(document).ready(function () {
            const pusher = new Pusher('c81df1d65be31b348303', {
                cluster: 'eu',
                forceTLS: true
            });

            var notifications = pusher.subscribe('notifications');
            notifications.bind('new_user', function(data) {

                toastr.success(data + " just registered");

            });
        });

    </script>

   