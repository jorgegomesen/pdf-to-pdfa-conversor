<?php
header('Content-Type: application/json; charset=utf-8');


function scanDirForOldFiles($dir)
{
    $ignored = array('.', '..', '.gitkeep', '.htaccess');

    $files = array();

    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored))
            continue;

        $files[$file] = filemtime($dir . '/' . $file);

        $file_stats = stat($dir . '/' . $file);

        // Delete files older than 1 minute
        if ($file_stats[9] < (time() - 60)) {
            $chmoding = @chmod($dir . '/' . $file, 0777);
            $deleting = @unlink($dir . '/' . $file);

            /* Removendo diretório desnecessário sendo criado associado ao pdf */
            rmdir('./' . substr($file, 0, -4));
        }

    }
}

scanDirForOldFiles("./uploads/");

$php_file_upload_errors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);

if (0 < $_FILES['file']['error']) {
    echo "Error: {$php_file_upload_errors[$_FILES['file']['error']]}<br>";
    exit;
}

try {
    $filename = preg_replace('/[^a-zA-Z0-9_.]+/i', '-', strtolower($_FILES['file']['name']));
    $filename = str_replace('--', '-', $filename);
    $filename = str_replace('-.', '.', $filename);

    $moved = move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . '/uploads/' . $filename);

    if ($moved) {
        if ($_POST['ocr-enabled']) {
            // echo dirname(__FILE__) . '/convert-pdf.sh '. $filename .' converted-' . $filename;
            $result = shell_exec(dirname(__FILE__) . '/ocr.sh ' . 'uploads/' . $filename);
            // var_dump($result, $result2);
        } else {
            $result = shell_exec(dirname(__FILE__) . '/convert-pdf.sh ' . $filename . ' converted-' . $filename);
        }

        $do_chmod = shell_exec('chmod 777 -R uploads/');

        if (!$result || !file_exists("uploads/converted-$filename")) {
            http_response_code(500);
            echo json_encode(['erro' => 'Arquivo de tamanho elevado ou contém conteúdo inadequado para conversão PDFa, como exemplo, o uso de imagens com canal alpha, transparência ou que exceda o tamanho máximo de pixels de 256000000.']);
            exit;
        }

        http_response_code(200);
        echo json_encode(['data' => 'converted-' . $filename, 'result' => $result]);
        exit;
    }

    http_response_code(500);
    echo json_encode(['erro' => "Não foi possível de mover o arquivo."]);
} catch (Exception $err) {
    http_response_code($err->getCode());
    echo json_encode(['erro' => $err->getMessage()]);
}
