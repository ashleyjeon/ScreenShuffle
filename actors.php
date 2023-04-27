<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="final.css">
        <style type="text/css">
                p {
                        margin: 0.5% auto 0.5% auto;
                }
                
                .gallery {
                                display: grid;
                                width: auto;
                        }

                h1 {
                        color: white;
                        font-size: 65px;
                        text-align: center;
                        width: 100%;
                        font-family:Georgia, 'Times New Roman', Times, serif; 
                        position: absolute;
                        top: 45%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                       
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
                        background-color: rgba(0, 0, 0, 0.85);
                        animation: zoom 0.3s ease-in-out;
                        flex-direction: column;
                        overflow-y: auto;
                }

                .modal-image {
                        height: 65%;
                        object-fit: cover;
                        display: block;
                        margin-top: 8%; /* Add margin bottom to create space between image and actorInfo */
                }

                .modal-actorInfo {
                        text-align: center;
                        display: block; /* Display actorInfo element as a block element */
                        max-height: 25%;
                        margin-bottom: 5%;
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
                <a href="default.html" class="logo"> <img src="images/logo.png" alt="Logo" height="80px"></a>
                <a href="default.html">Home</a>
                <a href="movies.html">Movies</a>
                <a href="tv_shows.html">TV Shows</a>
                <a class="active" href="actors.php">Actors</a>
                <a href="about.html">About Us</a>
                <a href="contribute.html">Contribute</a>                
        </nav>

        <header>
                <img class="banner-image" src="images/banner-actors1.jpg" 
                alt="Unsplash.com" height="400">
                <h1>Popular Actors</h1>
        <br/>

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

                $sql = "SELECT fname, lname, image, imdb FROM actors";
                $result = $conn->query($sql);

                // Building dropdown menu to select actors/actresses
                $fnames = array();
                $lnames = array();
                $images = array();
                $imdbs = array();
                if ($result->num_rows > 0) {                                
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                                $fnames[$i] = $row["fname"];
                                $lnames[$i] = $row["lname"];
                                $images[$i] = $row["image"];
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
                        var actorFirstNames = <?php echo json_encode($fnames); ?>;
                        var actorLastNames = <?php echo json_encode($lnames); ?>;
                        var actorImages = <?php echo json_encode($images); ?>;
                        var actorIMDBs = <?php echo json_encode($imdbs); ?>;

                        console.log("got arrays");
                        var gallery = "<div class='gallery' style='margin: auto'><div class='flexbox'><table style='text-align: center; margin: auto; width: auto'>";

                        for (let i = 0; i < actorFirstNames.length; i++) {
                                console.log(actorFirstNames[i]);
                                let name = actorFirstNames[i] + " " + actorLastNames[i];

                                if (i % 4 === 0) {
                                        gallery += "<tr>";
                                }
                        
                                gallery += "<td class='gallery__item'>" 
                                + "<img style='margin: 3% auto 4% auto; cursor: pointer;' src='" + actorImages[i] 
                                + "' width='180px' height='220px'><br/><p style='width: 85.5%; padding: 3% 0% 3% 0%; background-color: #f1f6fe; font-weight: bold; border-left: 10px solid #5d83c3'>" + name + "</p><br/></td>";

                                // gallery += "<td class='gallery__item'>" 
                                // + "<img style='margin: auto auto 3% auto;' src='" + actorImages[i] + "' width='180px' height='220px';" 
                                // + "<br/><br/><p><strong>" + name + "</strong></p><p><i>"+ actorFilms[i] + "</i></p>"
                                // + "<p><a href='" + actorIMDBs[i] + "' target='_blank'>IMDB profile</a></p>" + "</td>";

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
                                $("body").append("<br/>");
                                $("body").append("<p style='text-align: center; font-size: small;'><em>Click images to expand.</em></p><br/>");
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
                                                console.log(" actor is " + images.indexOf(img));
                                                let index = images.indexOf(img);
                                                imgSrc = e.target.src;
                                                //run modal function
                                                imgModal(imgSrc);
                                                openPopup(actorFirstNames[index], actorLastNames[index], actorIMDBs[index]);
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
                                        newImage.setAttribute("class", "modal-image"); // add modal-image class for the image element
                                        
                                        const actorInfo = document.createElement("p");
                                        actorInfo.setAttribute("class", "modal-actorInfo");

                                        // creating the close button
                                        const closeBtn = document.createElement("button");
                                        closeBtn.innerHTML = "✖";
                                        closeBtn.setAttribute("class", "closeBtn");
                                        
                                        //close function to close module on click
                                        closeBtn.onclick = () => {
                                                modal.remove();
                                        };
                                        
                                        modal.append(newImage, actorInfo, closeBtn);
                                }; 
                        });

                        function openPopup(first, last, IMDB) {
                                console.log('in open popup');
                                var actorFname = first;
                                var actorLname = last;

                                requestData(actorFname, actorLname, IMDB);
                        }
                        

                        function requestData(actorFname, actorLname, IMDB) {
                                console.log('in request data');
                                var request = new XMLHttpRequest();
                        
                                if (!request) {
                                        alert("Unable to create HTTPRequest object");
                                        return;
                                }
                                
                                var api_link = "http://api.tmdb.org/3/search/person?api_key=d769a465cff5b60a61415cc4a7f30648&query="
                                                + actorFname + "%20" + actorLname;
                                
                                console.log(api_link);
                                

                                if (!request) {
                                        {alert("Unable to get HTTPRequest object"); return;}
                                }
                                request.open("GET", api_link, true);
                                request.onreadystatechange = function() {
                                        console.log("ready: " + this.readyState);
                                        console.log("status: " + this.status);
                                        if (this.readyState === 4 && this.status === 200) {
                                                var data = this.responseText;
                                                var info = JSON.parse(data);
                                                var retrieved = info["results"];
                                        
                                                // $(".modal-actorInfo").append("<br><p style='color: white'>" + api_link + retrieved[0].poster_path + "</p><br>");
                                                $(".modal-actorInfo").append("<h2 style='color: white'>" + retrieved[0].name + "</h2>");
                                                $(".modal-actorInfo").append("<p style='color: white; margin: auto 18% auto 18%;'>Most Known For: <i>" + retrieved[0].known_for[0].title 
                                                                                + "</i>, <i>" + retrieved[0].known_for[1].title + "</i>, <i>" 
                                                                                + retrieved[0].known_for[2].title + "</i></p>");
                                                $(".modal-actorInfo").append("<p><a style='color: white' href='" + IMDB + "' target='_blank'>IMDB profile</a></p><br/>");
                                               
                                                console.log(retrieved[0].id);
                                                let actor_id = retrieved[0].id;
                                                openBio(actor_id);
                                        } else if (this.readyState == 4 && this.status != 200) {
                                                document.getElementById("data").innerHTML = "Unable to retrieve data";
                                        }
                                }
                                request.send();
                        }

                        function openBio(actor_id) {
                                console.log('in openBio');
                                var request = new XMLHttpRequest();
                        
                                if (!request) {
                                        alert("Unable to create HTTPRequest object");
                                        return;
                                }
                                
                                var api_link = "https://api.themoviedb.org/3/person/" + actor_id 
                                + "?api_key=d769a465cff5b60a61415cc4a7f30648&language=en-US";
                                
                                console.log(api_link);
                                
                                if (!request) {
                                        {alert("Unable to get HTTPRequest object"); return;}
                                }
                                request.open("GET", api_link, true);
                                request.onreadystatechange = function() {
                                        console.log("ready: " + this.readyState);
                                        console.log("status: " + this.status);
                                        if (this.readyState === 4 && this.status === 200) {
                                                var data = this.responseText;
                                                var info = JSON.parse(data);

                                                console.log(info.biography);

                                                $(".modal-actorInfo").append("<p style='color: white; margin: auto 18% auto 18%; text-align: center'>" + info.biography + "</p><br/><br/>");
                                        } else if (this.readyState == 4 && this.status != 200) {
                                                document.getElementById("data").innerHTML = "Unable to retrieve data";
                                        }
                                }
                                request.send();
                        }
                </script>
        </div>

        <br/>

        
</body>
</html>
