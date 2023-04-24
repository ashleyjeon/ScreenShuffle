<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="final.css">
        <script
                src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
                crossorigin="anonymous">
        </script>
        <title>Actors</title>
</head>
<body>
        <nav>
               <!--  Todo: Add logo here!!! -->
                <a href="default.html" class="logo"> <img src="images/logo.png" alt="Logo" height="100px"></a>
                <a class="active" href="default.html">Home</a>
                <a href="movies.html">Movies</a>
                <a href="tv_shows.html">TV Shows</a>
                <a href="actors.php">Actors</a>
                <a href="about.html">About Us</a>
                <a href="contribute.html">Contribute</a>                
        </nav>

        <header>
                <img class="banner-image" src="images/banner-image.jpeg" 
                alt="Unsplash.com" height="250">
                <h1>Popular Actors</h1>
                
        </header>

        <?php
                $servername = "localhost";
                $username = "upmdbgmzld3rs";
                $password = "WWP4funpinkhawks!";
                $dbname = "dbkztryo44o3gp";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                // Check connection
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                } 

                $sql = "SELECT name, image, film, imdb FROM actors";
                $result = $conn->query($sql);

                // Building dropdown menu to select actors/actresses
                $names = array();
                $images = array();
                $films = array();
                $imdbs = array();
                if ($result->num_rows > 0) {                                
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                                $names[$i] = $row["name"];
                                $images[$i] = $row["image"];
                                $films[$i] = $row["film"];
                                $imdbs[$i] = $row["imdb"];

                                $i++;
                        }
                
                } else {
                        echo "0 results";
                }

                $conn->close();
        ?> 
        
        <div style="text-align: center; margin: auto; width: auto">
                <script>
                        /* get actorNames array from PHP */
                        var actorNames = <?php echo json_encode($names); ?>;
                        var actorImages = <?php echo json_encode($images); ?>;
                        var actorFilms = <?php echo json_encode($films); ?>;
                        var actorIMDBs = <?php echo json_encode($imdbs); ?>;

                        var dropdown = "<select style='margin: auto'>";
                        var gallery = "<table style='text-align: center; margin: auto; width: auto'>";

                        for (let i = 0; i < actorNames.length; i++) {
                                console.log(actorNames[i]);
                                let name = actorNames[i];
                                dropdown += "<option>" + name + "</option>";

                                if (i % 4 === 0) {
                                        gallery += "<tr>";
                                }
                                
                                console.log(actorFilms.length);
                                gallery += "<td id='" + name + "'>" + "<img src='" + actorImages[i] + "' width='180px' height='220px';" 
                                + "<br/><br/>" + actorNames[i] + "<br/>"+ actorFilms[i] + "<br/><a href='" 
                                + actorIMDBs[i] + "' target='_blank'>IMDB profile</a>" + "</td>";

                                if ((i - 3) % 4 === 0) {
                                        gallery += "</tr>";
                                }
                        }

                        dropdown += "</select>";
                        gallery += "</table>";

                        var footer = "<footer><br />&copy;Screen Shuffle<footer class='navigation-align-right'>"
                                        + "<a href='https://www.instagram.com/tuftsanimalaid/' target='_blank'>"
                                        + "<img src='images/instagram.png' alt='Instagram Icon' height='17px'></a>"
                                        + "&nbsp; &nbsp;<a href='mailto:anika.kapoor@tufts.edu' target='_blank'>"
                                        + "<img src='images/email.png' alt='Email Icon' height='17px'></a></footer></footer>";

                        $(document).ready(function() {
                                $("body").append(dropdown);
                                $("body").append(gallery);
                                $("body").append("<div class='spacer'></div>");
                                $("body").append(footer);
                                
                                $("select").change(function() {
                                        for (let i = 0; i < actorNames.length; i++) {
                                                if (actorNames[i] != this.value) {
                                                        $("#" + actorNames[i]).hide();
                                                }
                                        }
                                });   
                        });

                </script>
        </div>

        <br/>

        
</body>
</html>
