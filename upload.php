<?php


// Get reference to uploaded image
$image_file = $_FILES["image"];


// Exit if no file uploaded
if (!isset($image_file)) {
    die('No file uploaded.');
}

// Exit if image file is zero bytes
if (filesize($image_file["tmp_name"]) <= 0) {
    die('Uploaded file has no contents.');
}

// Exit if is not a valid image file
$image_type = exif_imagetype($image_file["tmp_name"]);
if (!$image_type) {
    die('Uploaded file is not an image.');
}

// Get file extension based on file type, to prepend a dot we pass true as the second parameter
$image_extension = image_type_to_extension($image_type, true);
echo $myfile;

// Create a unique image name
$image_name = bin2hex(random_bytes(16));

// Assign unique image name with no image extension
$image_name_no_extension = $image_name;

// Assign a unique image name
$image_name =  $image_name . $image_extension;

// Move the temp image file to the images directory
move_uploaded_file(
    // Temp image location
    $image_file["tmp_name"],

    // New image location
    __DIR__ . "/images/" . $image_name
);

$myfile = fopen($image_name_no_extension . ".html", "w");
$txt = "<html><head>
<meta charset=\"utf-8\">
</head>
<body>

<center>
<a href=\"https://www.checkdark.com\"><h1 style=\"Margin:0;line-height:72px;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;font-size:48px;font-style:normal;font-weight:bold;color:#333333\">Check Another File</h1></a>
<table style=\"border-collapse: collapse;padding: 0;margin: 0;cellspacing=\"0\" cellpadding=\"0\" border=\"0\"\">		
		<tr><td colspan=\"3\"><img src=\"top.jpg\"></td></tr>
		<tr><td><img src=\"left.jpg\"></td><td width=\"1082\" style=\"background-color:#222222;\" align=\"center\"><img src=/images/$image_name style=\"max-height:610px;max-width:1082px;height:auto;width:auto;\"></td><td><img src=\"right.jpg\"></td></tr>
		<tr><td colspan=\"3\"><img src=\"bottom.jpg\"></td></tr>
</table>

</body>
</center>
</html>";

fwrite($myfile, $txt);
fclose($myfile);


header('Location: http://checkdark.com/' . $image_name_no_extension .'.html');
die;


?>