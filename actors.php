<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="final.css">
        <style type="text/css">
                .gallery {
                                display: grid;
                                width: auto;
                        }

                .gallery__item {
                        cursor: pointer;
                        overflow: hidden;
                }

                .gallery__item img {
                        object-fit: cover;
                        transition: 0.3s ease-in-out;
                }

                .gallery__item img:hover {
                        transform: scale(1.1);
                        }

                @media (max-width: 950px) {
                        .gallery {
                                grid-template-columns: repeat(2, 1fr);
                        }
                }

                @media (max-width: 550px) {
                        .gallery {
                                grid-template-columns: repeat(1, 1fr);
                        }
                }
                
                @keyframes zoom {
                        from {
                                transform: scale(0);
                        }
                        to {
                                transform: scale(1);
                        }
                }

                .modal {
                        width: 100%;
                        height: 100%;
                        position: fixed;
                        top: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        background-color: rgba(0, 0, 0, 0.733);
                        animation: zoom 0.3s ease-in-out;
                }
                
                .modal img {
                        height: 75%;
                        object-fit: cover;
                }

                button {
                        background-color: none;
                        border: none;
                        color: rgba(255, 255, 255, 0.87);
                }
                
                .closeBtn {
                        background-color: transparent;
                        font-size: 40px;
                        position: fixed;
                        top: 0;
                        right: 0;
                        cursor: pointer;
                        transition: 0.2s ease-in-out;
                }

                .closeBtn:hover {
                        color: rgb(255, 255, 255);
                }
        </style>
        <script
                src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
                crossorigin="anonymous">
        </script>
        <title>Actors</title>
</head>
<body>
        <nav>
                <a href="default.html" class="logo"> <img src="images/logo.png" alt="Logo" height="100px"></a>
                <a href="default.html">Home</a>
                <a href="movies.html">Movies</a>
                <a href="tv_shows.html">TV Shows</a>
                <a class="active" href="actors.php">Actors</a>
                <a href="about.html">About Us</a>
                <a href="contribute.html">Contribute</a>                
        </nav>

        <header>
                <img class="banner-image" src="images/banner-image.jpeg" 
                alt="Unsplash.com" height="450">
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

                $sql = "SELECT fname, lname, image, film, imdb FROM actors";
                $result = $conn->query($sql);

                // Building dropdown menu to select actors/actresses
                $names = array();
                $images = array();
                $films = array();
                $imdbs = array();
                if ($result->num_rows > 0) {                                
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                                $names[$i] = $row["fname"]." ".$row["lname"];
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
                <script language="javascript">
                        /* get actorNames array from PHP */
                        var actorNames = <?php echo json_encode($names); ?>;
                        var actorImages = <?php echo json_encode($images); ?>;
                        var actorFilms = <?php echo json_encode($films); ?>;
                        var actorIMDBs = <?php echo json_encode($imdbs); ?>;

                        //var dropdown = "<select style='margin: auto'>";
                        var gallery = "<div class='gallery' style='margin: auto'><div class='flexbox'><table style='text-align: center; margin: auto; width: auto'>";

                        for (let i = 0; i < actorNames.length; i++) {
                                console.log(actorNames[i]);
                                let name = actorNames[i];

                                if (i % 4 === 0) {
                                        gallery += "<tr>";
                                }
                                
                                gallery += "<td class='gallery__item'>" 
                                + "<img style='margin: auto auto 3% auto;' src='" + actorImages[i] + "' width='180px' height='220px';" 
                                + "<br/><br/><p><strong>" + actorNames[i] + "</strong></p><p><i>"+ actorFilms[i] + "</i></p>"
                                + "<p><a href='" + actorIMDBs[i] + "' target='_blank'>IMDB profile</a></p>" + "</td>";

                                if ((i - 3) % 4 === 0) {
                                        gallery += "</tr>";
                                }
                        }

                        //dropdown += "</select>";
                        gallery += "</div></table>";

                        var footer = "<footer><br />&copy;Screen Shuffle<footer class='navigation-align-right'>"
                                        + "</footer></footer>";

                        $(document).ready(function() {
                                // $("body").append(dropdown);
                                $("body").append(gallery);
                                $("body").append("<div class='spacer'></div>");
                                $("body").append(footer);
                                
                                const imgs = $(".gallery__item img");
                                const images = Array.from(imgs);
                                
                                console.log("length of gallery items: " + images.length);
                                let imgSrc;
                                // get images src onclick
                                images.forEach((img) => {
                                        img.addEventListener("click", (e) => {
                                                console.log("clicked");
                                                imgSrc = e.target.src;
                                                //run modal function
                                                imgModal(imgSrc);
                                        });
                                });

                                // creating the modal
                                let imgModal = (src) => {
                                        const modal = document.createElement("div");
                                        modal.setAttribute("class", "modal");
                                        
                                        // add the modal to the gallery section
                                        document.querySelector(".gallery").append(modal);
                                        
                                        // adding image to modal
                                        const newImage = document.createElement("img");
                                        newImage.setAttribute("src", src);
                                        
                                        // creating the close button
                                        const closeBtn = document.createElement("button");
                                        closeBtn.innerHTML = "✖";
                                        closeBtn.setAttribute("class", "closeBtn");
                                        
                                        //close function to close module on click
                                        closeBtn.onclick = () => {
                                                modal.remove();
                                        };
                                        
                                        modal.append(newImage, closeBtn);
                                }; 
                        });

                </script>
        </div>

        <br/>

        
</body>
</html>