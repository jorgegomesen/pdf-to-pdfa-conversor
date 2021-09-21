<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php error_reporting(0);
    header('Cache-Control: max-age=60, must-revalidate'); ?>
    <!--Import Google Icon Font -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css -->
    <link type="text/css" rel="stylesheet"
          href="<?php echo "http://$_SERVER[HTTP_HOST]"; ?>/assets/css/dist/main.min.css" media="screen,projection"/>
    <!--Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Favicon here -->
    <link rel="shortcut icon" type="image/png"
          href="<?php echo "http://$_SERVER[HTTP_HOST]"; ?>/assets/img/favicon.png"/>

    <script type="text/javascript">
        var urlPath = '<?php echo "http://$_SERVER[HTTP_HOST]"; ?>';
    </script>

    <title>Conversor PDF/A</title>
</head>

<body>
<header>
    <nav class="grey darken-3" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="index.php" class="brand-logo">Conversor PDF/A</a>
        </div>
    </nav>
</header>

<main>
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <h1 class="header center red-text text-darken-4">Selecione o PDF</h1>
            <div class="row center">
                <p class="col s8 offset-s2 warning-msg hidden"><small><i class="material-icons tiny">report_problem</i>
                        Apenas arquivos no formato PDF, são permitidos!</small></p>
            </div>
            <div class="row center">
                <form class="col s6 offset-s3" action="#">
                    <div class="file-field input-field">
                        <div class="btn red darken-4">
                            <span>Procurar</span>
                            <input id="pdf-file" type="file" accept=".pdf" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Selecione seus arquivos PDFs">
                        </div>
                        <div class="ocr-checkbox">
                            <input type="checkbox" class="filled-in" id="enable-ocr" checked="checked"/>
                            <label for="enable-ocr">Ativar reconhecimento de caracteres
                                <span class="tooltipped"
                                      data-position="bottom"
                                      data-tooltip="OCR é um acrônimo para o inglês Optical Character Recognition, é uma tecnologia para reconhecer caracteres a partir de um arquivo de imagem ou mapa de bits sejam eles escaneados, escritos a mão, datilografados ou impressos. Dessa forma, através do OCR é possível obter um arquivo de texto editável por um computador.">(OCR)</span></label>
                        </div>
                    </div>
                </form>
                <h5 class="header col s12 light">Após realizar o upload do seu arquivo, clique no botão abaixo para
                    iniciar a conversão.</h5>
            </div>
            <div class="row center">
                <a id="convert-pdf" href="#" class="btn-large waves-effect waves-light red darken-4">Converter PDF!</a>
                <a id="download-converted-pdf" href="#" class="btn-large waves-effect waves-light red darken-4"
                   style="display: none;">Download agora!</a>
            </div>
            <br><br>
            <div id="convertions-summary" class="row hide">
                <h3 class="header center red-text text-darken-4">Sumário conversões <span
                            class="convertion-progress"></span></h3>
                <ul class="collapsible"></ul>
            </div>
        </div>
    </div>
</main>

<footer class="page-footer grey darken-2">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5 class="white-text">Sobre</h5>
                <p class="grey-text text-lighten-4">Ferramenta desenvolvida com o intuito de fornecer uma interface
                    simples para a conversão de arquivos no formato <a class="red-text text-lighten-1"
                                                                       href="https://www.iso.org/standard/38920.html"
                                                                       target="_blank"><b>PDF</b></a>, para o formato <a
                            class="red-text text-lighten-1" href="https://www.iso.org/standard/51502.html"
                            target="_blank"><b>PDF/A</b></a>, um derivado da especificação proprietária, em conformidade
                    com a ISO 19005:2005 e ISO 32000:2008 e, utilizando o software de código aberto <a
                            class="red-text text-lighten-1" href="https://github.com/tesseract-ocr/" target="_blank">Tesseract</a>
                    para reconhecimento ótico de caracteres.</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col s6">
                    Acompanhe no <a class="red-text text-lighten-1"
                                    href="https://github.com/culturagovbr/PDFA-Converter" target="_blank">Github</a>
                </div>
                <div class="col s6 right-align">
                    Desenvolvido com <a class="red-text text-lighten-1" href="http://materializecss.com"
                                        target="_blank">MaterializeCSS</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="<?php echo "http://$_SERVER[HTTP_HOST]"; ?>/assets/js/dist/main.min.js"></script>
</body>
</html>
