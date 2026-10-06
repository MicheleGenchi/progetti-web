<html>

<head>
    <title>
        Ridimensiona immagine
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link href="favicon.png" rel="icon" />
</head>

<body>
    <fieldset>
        <legend>
            <h1 class="title">Resize your image</h1>
        </legend>
        <form method="get" action="./process.php" enctype="multipart/form-data">
            
            <label for="width">width : </label>
            <input type="text" name="width" id="width" value="200" placeholder="Inserire la larghezza" /></br>

            <label for="height">height : </label>
            <input type="text" name="height" id="height" value="200" placeholder="Inserire l'altezza" /></br>

            <label for="height">percent : </label>
            <input type="text" name="percent" id="percent" value="100" placeholder="Inserire la percentuale" /></br>

            <label for="height">immagine : </label>
            <input type="file" name="image" id="file" accept="image/*" /></br>
            <div id="submit">
                <input type="submit" id="submit" value="process" />
            </div>
        </form>
    </fieldset>
</body>
</html>
<script>
    var target=document.getElementById("file");
    target.addEventListener('change', function(event){
        var source=target.files[0].name;
        document.getElementById("image").setAttribute('src',source);
        console.log("file: "+source);
    }, false);
</script>
