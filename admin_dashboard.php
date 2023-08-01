<?php
require_once 'db_config.php';
require_once 'includes/header.php';
require_once 'includes/footer.php';

if (!isset($_SESSION['admin_id'])){
    header("location: index.php");
}

?>
<div class="background" >
<div class="overlayDB ">
<?php require_once 'includes/navbar.php' ?>;

<div class="container">
    <?php  
        if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                     <strong>Maple welcome!</strong> 
                     <?php  echo $_SESSION['success_message'] ;
                            unset($_SESSION['success_message'])
                     ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    <?php  
        if(isset($_SESSION['delete'])): ?>
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                     <strong>Maple alert info!</strong> 
                     <?php  echo $_SESSION['delete'] ;
                            unset($_SESSION['delete'])
                     ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    <?php  
        if(isset($_SESSION['success_add_trainer'])): ?>
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                     <strong>Maple alert info!</strong> 
                     <?php  echo $_SESSION['success_add_trainer'] ;
                            unset($_SESSION['success_add_trainer'])
                     ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    <?php  
        if(isset($_SESSION['trainer_delete'])): ?>
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                     <strong>Maple alert info!</strong> 
                     <?php  echo $_SESSION['trainer_delete'] ;
                            unset($_SESSION['trainer_delete'])
                     ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    <div class="row mb-5 m-auto">
    <div class="row">
                <div class="col-md-12">
                    <h2 class="text-left py-4 text-white">Members List</h2>
                <table class="table text-white ">
                    <thead>
                        <tr>
                            <th>PDF_FILE</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>E-mail</th>
                            <th>Phone</th>
                            <th>Trainer</th>
                            <th>Photo</th>
                            <th>Training Plan</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "
                            SELECT members.*, 
                            training_plans.name AS training_plans_name,
                            trainers.name AS trainer_name,
                            trainers.l_name AS trainer_l_name 
                            FROM `members` LEFT JOIN `training_plans`
                            ON members.training_plans_id = training_plans.plan_id
                            LEFT JOIN `trainers` 
                            ON members.trainer_id = trainers.trainer_id;";
                            $run = $conn->query($sql);
                            $results = $run->fetch_all(MYSQLI_ASSOC);
                            $select_members = $results;
                            foreach($results as $result): ?>
                                <tr>
                                    <td width="8vw" >
                                        <form action="extract_pdf.php" method="POST">
                                            <input type="hidden" name="photo_path"     value="<?php echo $result['photo_path'] ?>">
                                            <input type="hidden" name="member_id"     value="<?php echo $result['member_id'] ?>">
                                            <input type="hidden" name="name" value="<?php echo $result['name'] ?>">
                                            <input type="hidden" name="l_name" value="<?php echo $result['l_name'] ?>">
                                            <input type="hidden" name="email" value="<?php echo $result['email'] ?>">
                                            <input type="hidden" name="phone_number" value="<?php echo $result['phone_number'] ?>">
                                            <input type="hidden" name="trainer_name" value="<?php echo $result['trainer_name'] ?>">
                                            <input type="hidden" name="trainer_l_name" value="<?php echo $result['trainer_l_name'] ?>">
                                            <input type="hidden" name="training_plans_name" value="<?php echo $result['training_plans_name']?>">
                                            <button class="btn btn-small btn-success">download</button>
                                        </form>
                                    </td>
                                    <td width="8vw" ><?php echo $result['name'] ?></td>
                                    <td width="8vw" ><?php echo $result['l_name'] ?></td>
                                    <td width="8vw" ><?php echo $result['email'] ?></td>
                                    <td width="8vw"><?php echo $result['phone_number'] ?></td>
                                    <td width="8vw" >
                                        <?php 
                                            if($result['trainer_name']){
                                                echo $result['trainer_name']; 
                                            }else{
                                                echo "not selected";
                                            }
                                        ?>
                                    </td>
                                    <td width="8vw">
                                    <?php if($result['photo_path'] != "static/images/"):?>
                                            <img src="<?php echo $result['photo_path'];?>"class=" col-md-12" alt="">
                                    <?php else: ?>
                                            <img src="static/images/profile.png" class=" col-md-12" alt="">
                                        <?php endif ?>
                                   </td>
                                    <td width="8vw">
                                        <?php
                                            if($result['training_plans_name']){
                                                echo $result['training_plans_name'] ;
                                            }else{
                                                echo "Plan nije odredjen.";
                                            }
                                        ?>
                                    </td>
                                    <td width="8vw" ><?php echo $result['created_at'] ?></td>
                                    <td width="8vw" >
                                        <form action="delete_member.php" method="POST">
                                            <input name="member_id" type="hidden" value="<?php echo $result['member_id'] ?>">
                                            <button  class="btn btn-sm btn-danger text-white">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                    <div class="col-md-12">
                        <h2 class="text-white py-3">Trainer List</h2>
                    <table class="table text-white ">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>E-mail</th>
                            <th>Phone</th>
                            <th>Started</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php  
                                $sql = "SELECT * FROM trainers";
                                $run = $conn->query($sql);
                                $results_f = $run->fetch_all(MYSQLI_ASSOC);
                                $select_trainers = $results_f;
                                foreach($results_f as $ersult_f):?>
                                <tr>
                                    <td><?php echo $ersult_f['name'] ?></td>
                                    <td><?php echo $ersult_f['l_name'] ?></td>
                                    <td><?php echo $ersult_f['email'] ?></td>
                                    <td><?php echo $ersult_f['phone_number'] ?></td>
                                    <td><?php echo $ersult_f['created_at'] ?></td>
                                    <td width="8vw" >
                                        <form action="delete_trainer.php" method="POST">
                                            <input name="trainer_id" type="hidden" value="<?php echo $ersult_f['trainer_id'] ?>">
                                            <button  class="btn btn-sm btn-danger text-white">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <?php endforeach; ?>
                            ?>
                        </tbody>
                    </table>
                    </div>
            </div>
        <div class="col-md-6 py-5" id="addMember">
            <h2 class="py-5  text-white fw-bold">Register Member</h2>
            <form action="register_member.php" method="POST" enctype="multipart/form-data" class="text-white">
                First Name:    <input type="text"  class="form-control" name="first_name" required> <br>
                Last Name:     <input type="text"  class="form-control" name="last_name" required>  <br>
                E-mail:        <input type="email" class="form-control" name="email" required>      <br>
                Phone Number:  <input type="text"  class="form-control" name="phone" required> <br>

                Training Plan:
                <select class="form-control" name="training_plans_id">
                    <?php 
                    
                    $sql = "SELECT * FROM training_plans";
                    $run = $conn->query($sql);
                    $results = $run->fetch_all(MYSQLI_ASSOC);
                    foreach($results as $result){
                        echo "<option value='" . $result['plan_id'] . "'> ". $result['name'] . "</option>";
                    }
                    ?>
                </select>
               
                click on box to upload image
                <input type="file" name="img" class="form-control" required>

              
                
                <div class="mt-5">
                    <button class="btn btn-lg btn-warning px-5 py-2">Register New Member</button>
                </div>
            </form>
        </div>
        <div class="col-md-6  py-5" id="addTrainer">
        <h2 class="py-5  text-white fw-bold">Register Trainer</h2>
            <form action="register_trainer.php" method="POST" class="text-white">
                First Name:    <input type="text"  class="form-control" name="first_name" required> <br>
                Last Name:     <input type="text"  class="form-control" name="last_name"  required>  <br>
                E-mail:        <input type="email" class="form-control" name="email"      required>      <br>
                Phone Number:  <input type="text"  class="form-control" name="phone"      required> <br>
                <div class="mt-5">
                    <button class="btn btn-lg btn-warning px-5 py-2">Register Trainer</button>
                </div>
            </form>
        </div>
        <div class="row my-5" id="TrainerToMember">
            <div class="col-md-6">
                <h2 class="py-3 text-white">Assing trainer to member</h2>
                <form action="assign_trainer.php" method="POST" class="text-white">
                    Select member
                    <select name="memberId" class="form-select mb-3">
                        <?php
                            foreach($select_members as $member): ?>
                                    <option value="<?php echo $member['member_id'] ?>">
                                        <?php echo $member['name']. " " . $member['l_name']; ?>
                                    </option>
                        <?php endforeach ?>
                    </select>
                    Select trainer
                    <select name="trainerId" class="form-select" >
                    <?php
                            foreach($select_trainers as $trainer): ?>
                                    <option value="<?php echo $trainer['trainer_id'] ?>">
                                        <?php echo $trainer['name']. " " . $trainer['l_name']; ?>
                                    </option>
                        <?php endforeach ?>
                    </select>
                    <button class="btn btn-warning mt-4">Assign trainer</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
   
</script>






