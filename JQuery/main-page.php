<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Shop</title>
        <!-- HEAD
                This is where you put your jQuery, Bootstrap JS library imports
            -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </head>
    <style>
        /* Style inputs */
        input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }

        /* Style the submit button */
        input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        /* Add a background color to the submit button on mouse-over */
        input[type=submit]:hover {
        background-color: #45a049;
        }
    </style>
    <body style="background-color:rgb(241, 241, 231)">
        <h2 class="text-center text-info">Buy First, Think Later! </h2>
        <div class="container">
            <form role="form" id="search-form" class="form" >
                <label for="search">Search</label>
                <input type="text" id="search" name="search" placeholder="">
                <label for="category">Category</label>
                <select id="category" name="category">
                <option value="">All</option>
                <option value="phones">Games</option>
                <option value="phones">Shoes</option>
                <option value="books">Phones</option>
                </select>
                <button id="btn" type="submit" class="btn btn-primary center-block">Submit &rarr; </button>
            </form>
        </div>
        <h4 id="results-header" class="text-center text-info"></h4>
        <!--- results from search-->
        <div id="results"></div>

        <?php
            // session_start();  
        ?>        
        <script>
            $(function(){
                $("#search-form").submit(function (event) {
                        var category = document.getElementById('category').value;
                        var search = document.getElementById('search').value;
                        var serviceURL = "http://LAPTOP-9M0FB286:8080/products/%25" + search + "%25&%25" + category + "%25";
                        $.get(serviceURL, function (data) {
                            var store = data.Product;
                            if (store == undefined) {
                                $("#results-header").html("<font color=red>The product you were looking for could not be found.<br><br></font>");
                                $("#results").html("");
                            } else {
                                // Placing the data within a table
                                var tableContent = 
                                    "<table class='table' id='results-table'>" +
                                    "<tr><th><b>Image</b></th>" +
                                        "<th><b></th></br>" +
                                        "<th><b>Product</th></br>" +
                                        "<th><b>Category</b></th>" +
                                        "<th><b>Price</b></th>" +
                                        "<th><b>Add to Cart</b></th></tr>";
                                for(var i = 0; i < store.length; i++) {
                                    var review;
                                    $.ajax({
                                            url: 'twitter/get_tweet.php',
                                            type: 'post',
                                            async: false,
                                            data: {
                                                'pname': store[i].Pname,
                                            },
                                            success: function(data){
                                                var obj = JSON.parse(data);
                                                var obj1 = JSON.parse(obj);
                                                var results = obj1.statuses;
                                                review = results[0].text;
                                                console.log(review);
                                            }
                                    });
                                    //var reviews = tweet;
                                    //console.log(review);
                                    eachRow = "<td> <img src = "+ store[i].pid + ".jpg height='100' width='100'> </td>" +
                                    "<td><br><br>Description: <br> Latest tweet:</td>" +
                                    "<td><b>" + store[i].Pname + "</b><br><br>" + store[i].Pdesc + "<br>" + review + "</td>" +
                                    "<td>" + store[i].category +  "</td>" +
                                    "<td>" + store[i].price +  "</td>" +
                                    "<td><a href='cart/cart.php?id=" + store[i].pid + "'>" +
                                    "Add To Cart</a></td>";

                                    tableContent += "<tr>" + eachRow + "<tr>";
                                };  
                                tableContent = tableContent + "</table>";
                                $("#results-header").html("");
                                $("#results").html(tableContent);
                            }
                        }) // $.get()
                            .fail(function () {
                                $("#results-header").html("<font color=red>There is a problem in retrieving the information, please try again later.<br><br></font>");
                                $("#results").html("");
                            })
                        // This prevents the submit button to continue it's default behaviour to submit so that the page doesn't refresh and stays here
                        event.preventDefault();
                    });
                });
        </script>
    </body>

</html>