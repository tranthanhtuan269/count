<?php
 ob_start();
 session_start();
 require_once 'db_connect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin user_tbl detail
 $res=mysql_query("SELECT * FROM user_tbl WHERE id=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);

 $query = mysql_query("SELECT * FROM code_tbl WHERE user_id=".$_SESSION['user'] . " AND DATE(created_date)=CURDATE() ORDER BY created_date DESC");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>App01</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
  <div class="row top-buffer">
    <div class="col-xs-12 col-md-offset-2 col-sm-8 col-md-offset-3 col-md-6">
      <div class="form-group">
        <input type="text" class="form-control text-center" id="inputCode" placeholder="Code" disabled>
      </div>
      <div class="form-group text-center">
        <button type="button" class="btn btn-default" id="getCodeBtn">Get Code</button>
        <a href="logout.php?logout" class="btn btn-default">Sign Out</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-md-offset-2 col-sm-8 col-md-offset-3 col-md-6" id="allCode">
    <?php
      // output data of each row
      while($row = mysql_fetch_array($query)) {
        // var_dump($row);
          echo '<input type="text" class="form-control mg-top-5 text-center" class="inputCode" value="' . $row['code'] . '" disabled>';
      }
    ?>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#getCodeBtn").click(function(){
        var request = $.ajax({
          url: "getcode.php",
          method: "POST",
          data: { id : "<?php echo $_SESSION['user']; ?>" },
          dataType: "json"
        });
         
        request.done(function( msg ) {
          // console.log(msg);
          if(typeof msg.code != 'undefined' && msg.code == 200 && msg.message == "success"){

            $("#inputCode").val(msg.data);  

            $("#allCode").prepend('<input type="text" class="form-control mg-top-5 text-center" class="inputCode" value="' + msg.data + '" disabled>');

          }else{
            alert("Request failed");
          }
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });

    });
  });
</script>
</body>
</html>
<?php ob_end_flush(); ?>