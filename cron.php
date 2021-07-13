<html>
	<head>
		<title>Refresh Token</title>
	</head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<body>
Note: I have made this file for cron job to change my refresh token and access token every hour. You want to know how to get access token at first place . Please check other file.
<?php

$mysqli = new mysqli("localhost","<DB USERNAME","<DB PASSWORD>","<DB NAME>");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
else
{
	echo "success";
}

if($_POST['access_token'])
{
	$accesstoken=$_POST['access_token'];
	$refreshtoken=$_POST['refresh_token'];
	$sql = "UPDATE access_token SET `access_token`='$accesstoken',`refresh_token`='$refreshtoken' WHERE id=1";

if ($mysqli->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}

}
else
{



$sql = "SELECT * FROM access_token";
         $result = $mysqli->query($sql);
         $row = $result->fetch_assoc();
}
$mysqli -> close();
?>

	
<?php

$access_token=$row['access_token'];
$refresh_token=$row['refresh_token'];
?>
<form id="postform" action="" method="post">
<input type="hidden" name="access_token" class="accesstoken" value=""><br>
<input type="hidden" name="refresh_token" class="refreshtoken" value=""><br>

</form>

</body>
<?php if($access_token)
{ ?>
<script type="text/javascript">
  
$(document).ready(function(){

var access_token="<?php echo $access_token; ?>";

var refresh_token="<?php echo $refresh_token; ?>";

var settings = {
  "url": "https://login.microsoftonline.com/common/oauth2/v2.0/token",
  "type": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/x-www-form-urlencoded",
    "Authorization": "Bearer " + access_token
   // "Cookie": "fpc=Ahsmk-3o3tNPjwmyoaL0Vh_sBeumAgAAALsSZtgOAAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd"
  },
  //'ContentType' : 'application/json',
  "data": {
    "grant_type": "refresh_token",
    "client_id": "<client_id app id in tenants in microsoft azure >",
    "scope": "offline_access Sites.Read.All Sites.ReadWrite.All",
     "refresh_token":refresh_token
    //"client_secret":"3160aed0-576d-4230-b2e4-127416bfea9c"
  }
};

$.ajax(settings).done(function (response) {
  console.log(response.access_token);
  console.log(response.refresh_token);
  $('.accesstoken').attr('value',response.access_token);
  $('.accesstoken').val(response.access_token);
  $('.refreshtoken').attr('value',response.refresh_token);
  $('.refreshtoken').val(response.refresh_token);
  $('form#postform').submit();

});

});
</script>
<?php } ?>
</html>