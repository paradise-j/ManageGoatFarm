<!DOCTYPE html>
<?php
session_start();
$con=mysqli_connect("localhost","root","","dbproduct");
$sql="select * from product";
$result=mysqli_query($con,$sql);
if(isset($_POST["add_product"])){
      if(isset($_SESSION["shopping_cart"]))
      {
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
           if(!in_array($_GET["id"], $item_array_id))
           {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                     'item_id'               =>     $_GET["id"],
                     'item_name'               =>     $_POST["hidden_name"],
                     'item_price'          =>     $_POST["hidden_price"],
                     'item_quantity'          =>     $_POST["quantity"]
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
           }
           else
           {
                echo '<script>alert("สินค้าถูกเพิ่มแล้ว")</script>';
                echo '<script>window.location="index.php"</script>';
           }
      }
      else
      {
           $item_array = array(
                'item_id'               =>     $_GET["id"],
                'item_name'               =>     $_POST["hidden_name"],
                'item_price'          =>     $_POST["hidden_price"],
                'item_quantity'          =>     $_POST["quantity"]
           );
           $_SESSION["shopping_cart"][0] = $item_array;
      }
 }
if(isset($_GET['action'])){
  if($_GET['action']=="delete"){
  foreach ($_SESSION['shopping_cart'] as $key => $value) {
    if($value['item_id']==$_GET['id']){
        unset($_SESSION['shopping_cart'][$key]);
        echo '<script>alert("ลบเรียบร้อย")</script>';
        echo '<script>window.location="index.php"</script>';
      }
    }
  }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <br><div class="container" style="width:700px">
        <h3 align="center">ระบบตะกร้าสินค้า</h3><br>
    <?php
        while($row=mysqli_fetch_array($result)){
    ?>
    <div class="col-md-4">
        <form method="post" action="index.php?action=add&id=<?php echo $row['id'];?>">
        <div style="border:1px solid #333;background-color:white;border-radius:5px;padding:1px;margin:1px">
          <img src="<?php echo $row['img'];?>" class="img-responsive" /><br>
          <h4 class="text-info">สินค้า : <?php echo $row['name'];?></h4>
          <h4 class="text-danger">ราคา: <?php echo number_format($row['price'],2);?> บาท</h4>
          <input type="text" name="quantity" class="form-control" value="1"/>
          <input type="hidden" name="hidden_name" value="<?php echo $row['name'];?>"/>
          <input type="hidden" name="hidden_price" value="<?php echo $row['price'];?>"/>
          <input type="submit" name="add_product" style="margin-top:5px;" class="btn btn-success" value="เพิ่มลงตะกร้า" />
        </div>
        </form>
    </div>
    <?php
        }
    ?>
    <br>
    <div style="clear:both;"></div>
    <br>
      <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>สินค้า</th>
          <th>จำนวน</th>
          <th>ราคา</th>
          <th>รวม</th>
          <th>การดำเนินการ</th>
        </tr>
        <?php
          if(!empty($_SESSION["shopping_cart"])){
              $total=0;
              foreach ($_SESSION['shopping_cart'] as $key => $value) { ?>
              <tr>
                <td><?php echo $value['item_name'];?></td>
                <td><?php echo $value['item_quantity'];?></td>
                <td><?php echo number_format($value['item_price'],2);?></td>
                <td><?php echo number_format($value['item_price']*$value['item_quantity'],2);?></td>
                <td><a href="index.php?action=delete&id=<?php echo $value['item_id'];?>">ลบสินค้า</td>
              </tr>
          <?php
              $total=$total+($value['item_price']*$value['item_quantity']);
              }
          ?>
          <tr>
              <td colspan="3" align="right">ราคารวม</td>
              <td align="right">฿ <?php echo number_format($total, 2); ?></td>
              <td></td>
              </tr>
          <?php
          }
        ?>
      </table>
      <!-- <?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?> -->
    </div>
    </div>
  </body>
</html>
