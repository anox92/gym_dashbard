<?php 

require_once 'db_config.php';
require_once 'includes/header.php';


if (isset($_SESSION['admin_id'])){
    header("location: admin_dashboard.php");
}



if(isset($_POST['submitLogin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id,password FROM admins WHERE username= ? ";
    $run  = $conn->prepare($sql);
    $run->bind_param("s",$username);
    $run->execute();

    $results = $run->get_result();

    if($results->num_rows == 1){
        $admin = $results->fetch_assoc();
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            $conn->close();
            header('location: admin_dashboard.php');
        }else{
           
            $_SESSION['error'] = "Netacan password";
            $conn->close();
            header('location: index.php');
            exit();
        }
    }else{
        $_SESSION['error'] = "Netacan username";
        $conn->close();
        header('location: index.php');  
        exit();
    }
}
?>


<div class="background">
<?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show  p-3 " style="position:absolute; width:100vw;" role="alert">
                     <strong>Maple Alert!</strong> 
                     <?php  
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                     ?>
                    
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          
    <?php endif ?>
    <div class="overlay ">
        <form  method="POST" class="form p-5">
            <h1 class="text-left text-white">Log<span class=text-warning>in</span>  to your account!</h1>
                <div class="mb-3">
                    <label class="py-3 text-white">Enter your username</label>
                    <input type="text" name="username" class="form-control" placeholder="example.....">
                </div>
                <div class="mb-3">
                <label class="py-3 text-white">Enter your password</label>
                    <input type="password" name="password" class="form-control" placeholder="***********">
                </div>
                <div class="row m-auto">
                    <button name="submitLogin" class="mt-5 btn btn-warning px-5 py-2">Login</button>
                </div>
        </form>
    </div>
</div>
      

<?php require_once 'includes/footer.php'; ?>