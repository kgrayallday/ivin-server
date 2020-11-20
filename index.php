<html>
<head>
    <title> ivin app</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300|Quattrocento+Sans|Open+Sans&display=swap" rel="stylesheet">
    <!--<link href="https://fonts.googleapis.com/css?family=Jura&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Jura:300&display=swap" rel="stylesheet">

    <?php require 'iselect.php'; require 'const.php'; ?>

</head>
<body>

    <div id="header">
    <h1>IVIN</h1>
    </div>

    <div id="container">

        <div class="tabs">
            <button onClick="selectTab(event, 'today');" id="defaultOpen" class="tablinks">Today</button>
            <button onClick="selectTab(event, 'yesterday');" class="tablinks">Yesterday</button>
            <button onClick="selectTab(event, 'mtd');" class="tablinks">MTD</button>
        </div>
        
        <div class="tabsbox">

            <div id="today" class="tabcontent">
                <p><strong>Today</strong></p>
                <?php  selectToday();  ?>
            </div>
            
            <div id="yesterday" class="tabcontent">
                <p><strong>Yesterday</strong></p>
                <?php selectYesterday();  ?>
            </div>

            <div id="mtd" class="tabcontent">
                <p><strong>MTD</strong></p>
                <?php selectMTD();  ?>
            </div>
            
        </div>
    </div id="container">
    

    <div class="footer">
    <p>Designed, Created and Maintained by Kyle Gray</p>
    <p>Based in Vancouver BC, Canada</p>
    <p><a>click here to contact</a></p>
    </div class="footer">

    <script>

        document.getElementById("defaultOpen").click();

        function selectTab(evt, tabName) {
          var i, tabcontent, tablinks;

          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(tabName).style.display = "block";
          evt.currentTarget.className += " active";
        }
    </script>

</body>
</html>