<?php
      $user = $_POST['b'];
       
      if(!empty($user)) {
            comprobar($user);
      }
       
      function comprobar($b) {
            $mysqli = new mysqli("localhost", "root", "", "arrendaoco");
            $result = $mysqli->query("SELECT user FROM usuarios where user='$b'");
            $contar = $result->num_rows;
           // $con = mysqli_connect('localhost','root');
           // mysqli_select_db('tienda', $con);
       
            //$sql = mysqli_query("select user from usuarios where user='$b'" ,$con);
             
           // $contar = mysqli_num_rows($sql);
             
            if($contar == 0){
                  echo "<span style='font-weight:bold;color:green;'>Usuario disponible.</span>";
            }else{
                  echo "<span style='font-weight:bold;color:red;'>Usuario no disponible.</span>";
            }
      }    
?>