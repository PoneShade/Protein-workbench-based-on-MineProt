<?php

/*
Upload data to target repository.
Gzipped JSON request:
    {
        "name": file name
        "repo": repository name
        "text": base64-encoded file text
        "force": force overwritting or not
        "gzip": compress files or not
    }
*/

$Data = json_decode(gzdecode(file_get_contents("php://input")), true);
$File_Name = $Data["name"];
$File_Text = base64_decode($Data["text"]);
$Repo_Path = getenv("MP_REPO_PATH") . $Data["repo"];
if (!file_exists($Repo_Path)) {
    mkdir($Repo_Path);
}
$File_Path = $Repo_Path . '/' . $File_Name;
if (file_exists($File_Path) && !$Data["force"]) {
    echo "Skipping";
} else {
    echo "Importing";
    if (!$Data["gzip"]) {
        file_put_contents($File_Path, $File_Text);
    } else {
        file_put_contents($File_Path . ".gz", gzencode($File_Text));
    }
}
