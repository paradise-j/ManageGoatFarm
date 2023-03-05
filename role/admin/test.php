<?php 
    session_start();
    require_once "connect.php";

        $Gtype = "3";
        $range_age = "5";


        $VM = $db->prepare("SELECT * FROM `group_g`");
        $VM->execute();

        while ($row = $VM->fetch(PDO::FETCH_ASSOC)) {
            if($Gtype == $row["gg_type"] and $range_age == $row["gg_range_age"]){
                $gg_id = $row["gg_id"];
                echo $gg_id;
                break;
            }
        }
?>

<div class="container">
   <div class="row">
      <div class='col-sm-6'>
         <div class="form-group">
            <div class='input-group date' id='datetimepicker2'>
               <input type='text' class="form-control" />
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         $(function () {
             $('#datetimepicker2').datetimepicker({
                 locale: 'ru'
             });
         });
      </script>
   </div>
</div>