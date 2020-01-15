<div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>
<?php
    $photo = Photo::find_by_id(14);
    echo $photo->filename;
    //------------
    // echo DS."<br>";
    // echo SITE_ROOT."<br>";
    // echo INCLUDES_PATH."<br>";
    //-----------------
    // $photo = new Photo();
    // $photo->title = "fire01";
    // $photo->description = "big fire";
    // $photo->filename = "fire01.jpg";
    // $photo->type = "img";
    // $photo->size = "16";
    // $photo->create();
    //------------------
    // $photos = Photo::find_all();
    // foreach ($photos as $photo) {
    //     echo $photo->title."<br>";
    // }
    //----------------
    // $user = new User();
    // $user->username = "nUser03";
    // $user->save();
    //----------------
    // $user = User::find_by_id(9);
    // $user->password = "PWD001";
    // $user->save();
    //----------------
    // $user = User::find_by_id(10);
    // $user->delete();
    //-----------------
    // $user = User::find_by_id(2);
    // $user->username = "number2";
    // $user->password = "777";
    // $user->first_name = "updno1";
    // $user->last_name = "Luxy77";
    // $user->update();
    //------------------
    // $user = new User();
    // $user->username = "will02";
    // $user->password = "456";
    // $user->first_name = "hipper02";
    // $user->last_name = "bank02";
    // $user->create();
    //------------------
    // $found_user = User::find_by_id(2);
    // echo $found_user->username;
    //-------------
    // $users = User::find_all();
    // foreach ($users as $user) {
    //     echo $user->username."<br>";
    // }
    //-------------------
    // $found_user = User::find_by_id(2);
    // $user = User::instantation($found_user);
    
    // echo $user->id."<br>";
    // echo $user->username."<br>";
    // echo $user->password."<br>";
    // echo $user->first_name."<br>";
    // echo $user->last_name."<br>";
    //-------------------
    // $found_user = User::find_by_id(2);
    // echo $found_user['username'];
    //---------------
    // $result_set = User::find_all();
    // while($row = mysqli_fetch_array($result_set)){
    //     echo $row['username']."<br>";
    // }
    //-----------------
    // $sql = "SELECT * FROM users WHERE id=1";
    // $result = $database->query($sql);
    // $user_found = mysqli_fetch_array($result);
    // echo $user_found['username'];
    //-----------------
    // if($database->connection){
    //     echo "true";
    // }
?>


                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->