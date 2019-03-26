<html>
<title>The bestest image gallery - Make sure to check our ?source!</title>
<h1>The bestest image gallery</h1>
<?php
if (isset($_GET["source"])) die(highlight_file(__FILE__));


session_start();
if (!isset($_SESSION["foo"])) {
    $_SESSION["foo"] = "sandbox/" . bin2hex(random_bytes(20));
    mkdir($_SESSION["foo"]);
    mkdir($_SESSION["foo"]."/img");
}
chdir($_SESSION["foo"]);

function extension_allowed($ext) {
    return in_array($ext, array('png','jpg','gif'));
}

function fetch($url, $local_file) {
    $parts = parse_url("http://" . $url);
    if (($sock = fsockopen($parts["host"], 80)) === false) {
        throw new Exception("fail");
    }
    fwrite($sock, 
        "GET {$parts["path"]} HTTP/1.0\r\n".
        "Host: {$parts["host"]}\r\n".
        "\r\n"
    );
    
    while(!feof($sock)) {
        if (fgets($sock, 1024) == "\r\n")
            break;
    }
    $result = "";
    while (!feof($sock)) {
        $result .= fgets($sock, 1024);
    }
    file_put_contents($local_file, $result);
}


function import_image($image) {
    if (preg_match("/^data:\/\/([^;\/]+);base64,(.*)$/", $image, $matches)) {
        $name = preg_replace("/[^a-z0-9\._-]+/i", "", $matches[1]);
        $parts = explode(".", $name);
        $ext = array_pop($parts);
        $name = implode(".",$parts);

        if (strlen($name) > 0 && extension_allowed($ext)) {
            $data = base64_decode($matches[2]);
            file_put_contents("./img/".$name.".".$ext, $data);
        }
    } else if (preg_match("/^http:\/\//i", $image, $matches)) {
        $url = str_replace($matches[0], "", $image);

        $img_path = parse_url($url, PHP_URL_PATH);
        if ($img_path) {
            $parts = explode("/", $img_path);
            if  (!empty($parts)) {
                $image = end($parts);
            }
        }

        $ext = pathinfo($image, PATHINFO_EXTENSION);
        if ($ext && !extension_allowed($ext)) {
            throw new Exception("invalid extension");
        }

        $image = preg_replace("/[^a-z0-9\._-]+/i", "", $image);
        if (!$image)  {
            throw new Exception("filename empty");
        }
        fetch($url, "img/" . $image);
    }
}

function show_images() {
    echo '<b>Here are your images:</b>';
    echo "<ul>";
    foreach(glob("img/*") as $img) {
        echo "<li><h3>$img</h3><img src='{$_SESSION["foo"]}/$img' /></li>";
    }
    echo "</ul>";
}

function show_form() {
    echo '<form action="/" method="post">' .
        'Upload a bunch of images:<br>'.
        '<input type="text" name="bestestimages[]" id="bestestimages" value="data://myimage.png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAADl0lEQVR4nO3ZMYrDQBREwR7j+19Zip0JHLxAVWy0IHDyaJh/tmu7zu/ftvPon/Otb33757efAanvTv0T4N1ECDERQkyEEBMhxLyOQswSQkyEEBMhxEQIMRFCTIQQc6KAmCWEmAghJkKIiRBiIoSYCCHmRAExSwgxEUJMhBATIcRECDGvoxCzhBATIcRECDERQkyEEBMhxJwoIGYJISZCiIkQYiKEmAghJkKIOVFAzBJCTIQQEyHERAgxEULM6yjELCHERAgxEUJMhBATIcRECDEnCohZQoiJEGIihJgIISZCiIkQYk4UELOEEBMhxEQIMRFCTIQQ8zoKMUsIMRFCTIQQEyHERAgxEULMiQJilhBiIoSYCCEmQoiJEGIihJgTBcQsIcRECDERQkyEEBMhxLyOQswSQkyEEBMhxEQIMRFCTIQQc6KAmCWEmAghJkKIiRBiIoSYCCHmRAExSwgxEUJMhBATIcRECDGvoxCzhBATIcRECDERQkyEEBMhxJwoIGYJISZCiIkQYiKEmAghJkKIOVFAzBJCTIQQEyHERAgxEULM6yjELCHERAgxEUJMhBATIcRECDEnCohZQoiJEGIihJgIISZCiIkQYk4UELOEEBMhxEQIMRFCTIQQ8zoKMUsIMRFCTIQQEyHERAgxEULMiQJilhBiIoSYCCEmQoiJEGIihJgTBcQsIcRECDERQkyEEBMhxLyOQswSQkyEEBMhxEQIMRFCTIQQc6KAmCWEmAghJkKIiRBiIoSYCCHmRAExSwgxEUJMhBATIcRECDGvoxCzhBATIcRECDERQkyEEBMhxJwoIGYJISZCiIkQYiKEmAghJkKIOVFAzBJCTIQQEyHERAgxEULM6yjELCHERAgxEUJMhBATIcRECDEnCohZQoiJEGIihJgIISZCiIkQYk4UELOEEBMhxEQIMRFCTIQQ8zoKMUsIMRFCTIQQEyHERAgxEULMiQJilhBiIoSYCCEmQoiJEGIihJgTBcQsIcRECDERQkyEEBMhxLyOQswSQkyEEBMhxEQIMRFCTIQQc6KAmCWEmAghJkKIiRBiIoSYCCHmRAExSwgxEUJMhBATIcRECDGvoxCzhBATIcRECDERQkyEEBMhxJwoIGYJISZCiIkQYiKEmAghJkKIOVFAzBJCTIQQEyHERAgxEULM6yjELCHERAgxEUJMhBATIcRECDEnCohZQoiJEGIihJgIISZCiN0HtAVfIctU0QAAAABJRU5ErkJggg==" size="50"><br>'.
        '<input type="text" name="bestestimages[]" id="bestestimages" value="data://myotherimage.png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAMAAABrrFhUAAAACXBIWXMAAAAcAAAAHAAPAbmPAAAAA1BMVEWz0f/VQ2ZAAAAAVUlEQVR42u39gQAAAACAIOxPvUiRBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADQBDwABN07iVQAAAABJRU5ErkJggg==" size="50" ><br>'.
        '<input type="submit" value="Upload Image" name="submit">'.
        '</form>';
}

function upload_images() {
    if (!isset($_POST["bestestimages"])) return;
    if (!is_array($_POST["bestestimages"])) return;

    foreach(glob("img/**") as $f) unlink($f);

    array_map("import_image", $_POST["bestestimages"]);
    echo "Success!! (i think)";
}

try {
    upload_images();
} catch (Exception $e) {
    die($e->getMessage());
}

show_form();
show_images();
