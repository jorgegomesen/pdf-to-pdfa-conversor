<?php

function removeFile($filename)
{
    $dir = dirname(__FILE__) . '/uploads/';
    if (file_exists($dir . $filename)) {
        if (@unlink($dir . '/' . $filename))
            return json_encode(["data" => "Arquivo removido!"]);
        return json_encode(["error" => "Não foi possível de remover o arquivo!"]);
    }
    return json_encode(["error" => "Arquivo não encontrado!"]);
}

$post_filename = $_POST['deleteFile'];

if ($post_filename) {
    $first_pos = strpos($post_filename, '-');
    $filename_with_no_converted_str = substr($post_filename, $first_pos + 1);

    echo removeFile($post_filename);

    /* Removendo arquivo extra sendo criado */
    removeFile($filename_with_no_converted_str);

    /* Removendo diretório desnecessário sendo criado */
    rmdir(dirname(__FILE__) . '/' . substr($filename_with_no_converted_str, 0, -4));

    exit();
}

echo json_encode(["data" => "Nome do arquivo não especificado."]);
