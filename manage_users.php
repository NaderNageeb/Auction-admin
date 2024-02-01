<?php 
$page = "manage_users";
include("header.php") ;

//Table fileds//
$table_name = 'users';
$where_column = 'user_id';
$user_id =  '';
$username =  '';
$user_full_name =  '';
$password = '';
$user_type =  '';
$user_phone =  '';
$added_by =  '';
$added_date =  '';
//vars
$edit = '0';
$user_type_text ='';

//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> User Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete User !");      
            }
        }
//Get Info
        if($action =="edit"){
                $edit = "1";
                $get_data = Fetch_Data_Where($table_name,$where_column,$action_id);
                $_result = mysqli_fetch_array($get_data) ;

                $user_id = $_result['user_id'] ;
                $username = $_result['username'] ;
                $user_full_name = $_result['user_full_name'] ;
                $user_type = $_result['user_type'] ;
                $user_phone = $_result['user_phone'] ;

                if($user_type =="0"){
                    $user_type_text = "Admin" ;
                }elseif($user_type =="1"){
                    $user_type_text = "Manager" ;
                } 
        }
}
///ADD//
    if(isset($_POST['submit'])){

        $username = $_POST['username'] ;
        $user_full_name = $_POST['user_full_name'] ;
        $user_phone = $_POST['user_phone'] ;
        $user_type = $_POST['user_type'] ;

        $manage_users = Manage_Users($user_id , $username ,$user_full_name  , $user_type  ,$user_phone  ,$_SESSION['user_login'] ,'ADD') ;

                if($manage_users=="Inserted"){
                    $alert  = alerts(1,"<b>INSERTED :</b> User Successfully Added !");
                }elseif($manage_users=="Exist"){
                    $alert  = alerts(3,"<b>Oops :</b> User <b>$username</b> Already Exist !");     
                }
    }
///Edit//
        if(isset($_POST['edit'])){

            $user_id = $_POST['user_id'] ;
            $username = $_POST['username'] ;
            $user_full_name = $_POST['user_full_name'] ;
            $user_phone = $_POST['user_phone'] ;
            $user_type = $_POST['user_type'] ;
    
            $manage_users = Manage_Users($user_id , $username ,$user_full_name  , $user_type  ,$user_phone  ,$_SESSION['user_login'],'EDIT') ;
    
                if($manage_users=="Updated"){
                    $alert  = alerts(1,"<b>Updated :</b> User Info Successfully Updated !");
                }elseif($manage_users=="Error"){
                    $alert  = alerts(3,"<b>Oops :</b> Error While Updating User Info !");     
                }
    }
    ?>

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			    <h1 class="app-page-title">Manage Users</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
	                <div class="col-12 col-md-8">
                          
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" action="manage_users.php" method="post">
                                <input  type="hidden" name= "user_id" required="required" value="<?php echo $user_id; ?>">
								    <div class="mb-3">
									    <label for="setting-input-1" class="form-label">User Name</label>
									    <input type="text" class="form-control" name="username" placeholder="Username" id="setting-input-1" required="required" value="<?php echo $username ; ?>">
									</div>
									<div class="mb-3">
									    <label for="setting-input-2" class="form-label">User Full Name</label>
									    <input type="text" class="form-control" placeholder="user Full name" name="user_full_name" id="setting-input-2" required="required" value="<?php echo $user_full_name ;?>">
									</div>
								    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">User Phone</label>
									    <input type="number" class="form-control" pattern="[0-9]{4}-[0-9]{6}"  placeholder="User Phone" id="setting-input-3" name="user_phone" required="required" value="<?php echo $user_phone ; ?>">
									</div>

                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">User Type</label>
									    <select id="inputText3" class="form-control" name= "user_type" required="required">
                                                   
                                        <?php 
                                                   if($user_type !=""){
                                                  ?>
                                            <option value="<?php echo $user_type ?>"><?php echo $user_type_text ?></option>
                                                  <?php
                                                        }else{
                                                            ?>
                                           <option value="">Select user Type</option>
                                                        <?php
                                                        }
                                                    ?>
                                                  

                                                    <option value="0">Admin</option>
                                                    <option value="1">Manager</option>
                                        
                                                </select>
									</div>

                                    <?php 
                                            if($edit == "1"){
                                    ?>
									<button type="submit" class="btn btn-info  text-white" name="edit">Edit User</button>
                                    <?php 
                                            }else{
                                    ?>
                                     <button type="submit" class="btn app-btn-primary" name="submit">Add User</button>    
                                    <?php
                                            }
                                    ?>
							    </form>
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->

                <hr class="my-4">

                <?php 
    if(Check_Rows($table_name)>0){      
        
        $user_qeury  = Get_Data($table_name) ;
                ?>

                <h1 class="app-page-title">View Users</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">

                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                
                <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Type</th>
                <th>Date</th>
                <th>Edit</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($user_qeury)){

                $user_id = $rows['user_id'] ;
                $username = $rows['username'] ;
                $user_full_name = $rows['user_full_name'] ;
                $user_type = $rows['user_type'] ;
                $user_phone = $rows['user_phone'] ;
                $added_by = $rows['added_by'] ;
                $added_date = $rows['added_date'] ;

                if($user_type == "0"){
                        $user_type_text = 'Admin';
                }elseif($user_type == "1"){
                        $user_type_text = 'Manager';
                }
            ?>
            <tr>
                <td><?php echo $user_full_name ; ?></td>
                <td><?php echo $username ; ?></td>
                <td><?php echo $user_phone ; ?></td>
                <td><?php echo $user_type_text ; ?></td>
                <td><?php echo $added_date ; ?></td>
                <td><a href="manage_users.php?action_id=<?php echo $user_id ; ?>&action=edit" class="btn btn-info text-white">Edit</a></td>
                <td><a href="manage_users.php?action_id=<?php echo $user_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
            <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Type</th>
                <th>Date</th>
                <th>Edit</th>
                <th>DEL</th>
            </tr>
        </tfoot>
    </table>
	                </div>
            </div>
            <?php 
    }
            ?>
<!-- //if shoud endhere -->

                </div><!--//row-->
         
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
        <?php 
include("footer.php") ;
?>	    