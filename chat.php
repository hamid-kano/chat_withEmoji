<?php
$servername = "localhost";
$username = "wars_cht";
$password = "ammar.114A!";
$dbname = "wars_cht";


session_start();
$players_id = isset($_SESSION['players_id']) ? $_SESSION['players_id'] : "-1";


$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die("Connection Failed : " . mysqli_connect_error());
} else {
    // echo "seccess!!!!";
}


if (isset($_POST['create'])) {
    createData();
}

if (isset($_POST['delete'])) {
    delete();
}


function getData()
{

    $sql = "SELECT ch.id , ch.players_id , pl.name ,ch.body , ch.date  FROM chat ch
    JOIN  p_players pl ON pl.id = ch.players_id";

    if ($result = mysqli_query($GLOBALS['con'], $sql)) {
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
}

function createData()
{

    $players_id = $_POST['players_id'];
    $body = $_POST['body'];
    $date = date("Y-m-d h:i:sa");

    $sql = "INSERT INTO chat (players_id, body, date) 
                    VALUES ('$players_id','$body','$date')";


    if (mysqli_query($GLOBALS['con'], $sql)) {

        // $_SESSION["type"] = 'success';
        // $_SESSION["msg"] = 'تمت عملية الاضافة بنجاح';
    } else {
        // $_SESSION["type"] = 'danger';
        // $_SESSION["msg"] = 'حصل خطأ أثناء عملية الاضافة';
    }
}


function delete()
{
    $id =  $_POST['id'];


    $sql = "DELETE FROM chat WHERE id=$id";

    if (mysqli_query($GLOBALS['con'], $sql)) {
        // header("Location: " . "../Qlim/index.php");
    } else {
        // header("Location: " . "../Qlim/index.php");
    }
}

?>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.5/jquery.textcomplete.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="panel panel-primary">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-comment"></span> Comments
    </div>
    <div style="overflow: scroll; max-height: 400px;" dir="rtl" class="panel-body body-panel">
        <ul class="chat">

            <?php
            $msg = getData();
            if ($msg != null)
                while ($row = mysqli_fetch_row($msg)) { ?>

                <li <?php if ($players_id == $row[1]) { ?> style="background-color: #f24342;" <?php  } else { ?> style="background-color:#33cc33;" <?php  } ?> class="msg">
                    <div class="chat-body">
                        <form action="" method="post">
                            <div>
                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                <strong style="color: white;" class="primary-font"><?php echo $row[2]; ?></strong>
                                <small style="color: white;" class="pull-left text-muted">
                                    <?php echo $row[4]; ?> <span class="glyphicon glyphicon-time">
                                    </span>
                                    <!-- <input class="btn btn-danger" id="delete" name="delete" type="submit" value="" /> -->
                                    <?php if ($players_id == $row[1] || $players_id == 1) { ?>
                                        <button class="btn btn-danger" name="delete" type="submit" style="margin-right: 10px;"> <i class="far fa-trash-alt"></i></button>
                                    <?php  }  ?>
                                </small>
                            </div>
                        </form>
                        <p>
                            <?php echo $row[3]; ?>
                        </p>
                    </div>
                </li>
            <?php  } ?>
        </ul>
    </div>
    <form action="" method="post">
        <input type="hidden" name="players_id" value="<?php echo $players_id ?>">
        <div class="panel-footer clearfix">
            <textarea id="emojionearea1" name="body" class="form-control" rows="3"></textarea>
            <span class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12" style="margin-top: 10px">
                <button class="btn btn-warning btn-lg btn-block" name="create" id="btn-chat">Send</button>
            </span>
        </div>
    </form>

</div>


<style>
    .msg {
        padding: 10px;
        border-radius: 10px;
        margin: 5px;
    }
</style>

<script>
    $(document).ready(function() {
        $("#emojionearea1").emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "bullet"
        });
    })
</script>