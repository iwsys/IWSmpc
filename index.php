<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>IWS 2020 MPC WEB Interface (17.01.2020)</title>
  <script language="javascript">
    startdate = new Date();
    clockStart = startdate.getTime();
    function initStopwatch() {
      var thisTime = new Date();
      return (thisTime.getTime() - clockStart)/1000;
    }
    function getSecs() {
      var tSecs = Math.round(initStopwatch());
      var iSecs = tSecs % 60;
      var iMins = Math.round((tSecs-30)/60);
      var sSecs ="" + ((iSecs > 9) ? iSecs : "0" + iSecs);
      var sMins ="" + ((iMins > 9) ? iMins : "0" + iMins);
      document.getElementById("timer-counter").innerHTML = sMins+":"+sSecs;
      setTimeout('getSecs()', 1000);
    }
  </script>
</head>
<body onLoad="getSecs()">

  <style type="text/css">
    body {
      width: 98%;
      font-family: Arial, sans-serif;
    }
    .meinclass {
      background: -moz-linear-gradient(#dea931, #EBFFFF);
      background: -webkit-gradient(linear, 0 0, 0 100%, from(#dea931), to(#EBFFFF));
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#dea931', endColorstr='#EBFFFF');
      padding: 3px 7px;
      color: #333;
      -moz-border-radius: 18px;
      -webkit-border-radius: 18px;
      border-radius: 18px;
      border-radius: 18px;
      border: 1px solid #150101;
      width: 40%;
      height: 100px;
      font-size: 35px;
      font-weight: bold;
      margin-right: 25px;
    }
    .status {
      color: red;
      font-size: 32px;
      text-transform: uppercase;
      padding: 5px 20%;
      font-weight: bold;
      display: block;
      text-align: center;
    }
    h4 {
      margin-bottom: 3px;
      margin-top: 3px;
      background-color: #614706;
      color: #FFF;
      text-align: center;
    }
    #header {
      background-color: #dca61c;
    }
    #datablock {
      padding-left: 25px;
      text-align: right;
      margin-right: 40px;
      padding-top: 10px;
      padding-bottom: 10px;
    }
  </style>


  <div id="header">
    <?php
    echo '<h4>IWS 2020 MPD WEB INTERFACE <br>START '.date("H:i:s").'</h4>';
    ?>
    <div id="datablock">
      <span id='timer-counter' style='color:black;font-size:15px;font-weight:bold;'></span>
    </div>
  </div>
  <?php
  function function_pause(){
    echo "<span class=\"status\">Pause!</span>";
#sleep (10);
    exec("mpc pause");
  }
  if(isset($_POST['pause'])){
    function_pause();
  }

  function function_play(){
    echo "<span class=\"status\">Play!</span>";
    exec("mpc play");
  }
  if(isset($_POST['play'])){
    function_play();
  }

  function function_next(){
    #sleep (10);
    echo "<span class=\"status\">Play!</span>";
    exec("mpc next");
  }
  if(isset($_POST['next'])){
    function_next();
  }

  if(isset($_POST['prev'])){
    echo "<span class=\"status\">Play!</span>";
    exec("mpc prev");
  }

  if(isset($_POST['sleep30'])) {
   echo "<span class=\"status\">Play and sleep (30 min)!</span>";
   exec("sleep 30m && mpc pause");
 }

 if(isset($_POST['sleep60'])) {
  exec("sleep 60m && mpc pause");
}

if(isset($_POST['volon'])) {
  echo "<span class=\"status\">Play! VOLUME ON!</span>";
  exec("mpc enable 1");
}

if(isset($_POST['voloff'])) {
  echo "<span class=\"status\">Play! VOLUME OFF!</span>";
  exec("mpc disable 1");
}

exec("mpc status", $mpcst);

foreach ($mpcst as $st) {
  echo '<b>'.$st.'</b><br>';
}
?>
<form method="post" style="text-align: center;">
  <input type="submit" name="pause" value="PAUSE" class="meinclass">
  <input type="submit" name="play" value="PLAY" class="meinclass">
  <br><br>
  <input type="submit" name="prev" value="PREV" class="meinclass">
  <input type="submit" name="next" value="NEXT" class="meinclass">

  <br><br>
  <input type="submit" name="volon" value="VOL ON" class="meinclass">
  <input type="submit" name="voloff" value="VOL OFF" class="meinclass">
  <br><br>
  <input type="submit" name="sleep30" value="30 M" class="meinclass">
  <input type="submit" name="sleep60" value="60 M" class="meinclass">

</form>


<?php
echo '<hr>';
$cur = exec("mpc current");
exec("mpc playlist", $plist);
foreach ($plist as $k=>$pl) {
  if ($pl == $cur) {
    echo '<b>'.++$k.'. '.$pl.'</b><br>';
  } else {
    echo ++$k.'. '.$pl.'<br>';

  }
}
#print_r ($mpcst);
?>
<hr>
<?php
exec("mpc outputs", $outp);
echo $outp[0];
?>

</body>
</html>

