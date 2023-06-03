
<?php
function uploadImage()
{
    global $BASEDIR;
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $BASEDIR . "/images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $error_message = "";
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $error_message = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error_message =  "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $uploadOk = 1;
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    }
    return (object)["success" => $uploadOk, "error_message" => $error_message, "file_name" => $file_name];
}
?>
