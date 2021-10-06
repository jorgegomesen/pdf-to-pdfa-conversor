(function ($) {
    /**
     * Aguarda o completo carregamento do documento e inicia a aplicação
     *
     */
    $(document).ready(function () {
        app.init();
    });

    var app = {
        init: function () {
            $(document).on('change', '#pdf-file', function () {
                if ($(this).val().replace(/^.*\./, '') === 'pdf') {
                    $('#convert-pdf').removeClass('red darken-4').addClass('green darken-1').text('Converter PDF!');
                    $('.warning-msg').addClass('hidden');
                } else {
                    $('#convert-pdf').removeClass('green darken-1').addClass('red darken-4').text('Selecione um PDF');
                    $('.warning-msg').removeClass('hidden');
                }
            });

            $(document).on('click', '.download-converted-pdf', function () {
                let file_name = $(this).data('download');
                let header_parent = $(this).parent();
                let li_parent = $(this).parent().parent();

                $.fileDownload($(this).prop('href'))
                    .done(function () {
                        app.postDownloadProcess(file_name);
                    })
                    .fail(function () {
                        $(header_parent).append('<span class="new badge red">Erro com Download</span>');
                        $(li_parent).append('<div class="collapsible-body"><p>Falha ao realizar download!</p></div>');
                        console.error('File download failed!');
                    });
                return false;
            });

            $('#convert-pdf').on('click', this.converterPDFRequest, this.converterPDF);
        },
        converterPDF: async function (evt) {
            evt.preventDefault();

            $('.collapsible').empty();

            let files = $('#pdf-file').prop('files');
            let files_len = files.length;
            let count = 1;

            if (!files_len)
                return;

            if ($('#convertions-summary').hasClass('hide'))
                $('#convertions-summary').toggleClass("hide");

            for (let file_data of files) {
                const file_name = file_data.name.toLowerCase()
                    .replace(/[^a-zA-Z0-9_.]+/g, '-')
                    .replace(/--/g, '-')
                    .replace(/-\./g, '.');

                let form_data = new FormData();

                form_data.append('file', file_data);

                /* Testando extensão */
                if (/application\/pdf/g.test(file_data.type)) {
                    $('.warning-msg').addClass('hidden');
                    $('.file-path-wrapper > input').removeClass('invalid').addClass('valid');

                    form_data.append('ocr-enabled', $('#enable-ocr').is(':checked') ? true : false);

                    try {
                        const php_script_response = JSON.parse(await evt.data(form_data));

                        $('.file-field > .btn, .file-path-wrapper').removeClass('disabled');
                        $('.file-path-wrapper > input, #enable-ocr').removeAttr('disabled');

                        let list_item_upload_resp = `
                        <li>
                            <div class="collapsible-header">${file_data.name}<span class="new badge green">OK</span>
                            <a class="download-converted-pdf" 
                                href="${urlPath}/inc/download-pdfa.php?filename=${php_script_response.data}"
                                data-download="${php_script_response.data}">
                                <i class="material-icons">file_download</i>
                            </a>
                            </div>
                        </li>
                        `;

                        $('.collapsible').append(list_item_upload_resp);
                        $('.convertion-progress').text(`(${count++} / ${files_len})`);
                    } catch (err) {
                        err = JSON.parse(err.responseText);

                        $('.file-field > .btn, .file-path-wrapper').removeClass('disabled');
                        $('.file-path-wrapper > input, #enable-ocr').removeAttr('disabled');

                        let list_item_upload_resp = `
                        <li>
                            <div class="collapsible-header">${file_data.name}<span class="new badge red">ERROR</span></div>
                            <div class="collapsible-body"><p>${err.erro}</p></div>
                        </li>
                        `;

                        $('.collapsible').append(list_item_upload_resp);
                    }

                    continue;
                }

                let list_item_upload_resp = `
                        <li>
                            <div class="collapsible-header">${file_data.name}<span class="new badge red">ERROR</span></div>
                            <div class="collapsible-body"><p>Não possui uma extensão válida. É aceito apenas arquivos de formato PDF.</p></div>
                        </li>
                        `;

                $('.collapsible').append(list_item_upload_resp);

                $('.warning-msg').removeClass('hidden');
                $('.file-path-wrapper > input').removeClass('valid').addClass('invalid');
                // console.error('A extensão do arquivo não parece ser do tipo PDF;', 'Arquivo do tipo: ', extension.toUpperCase());

            }

            $('#download-converted-pdf')
                .removeClass('teal darken-3')
                .addClass('red darken-4')
                .text('Download agora!')
                .hide();

            $('#convert-pdf').show();

        },

        converterPDFRequest: function (form_data) {
            return $.ajax({
                url: urlPath + '/inc/convert-pdf.php',
                type: 'POST',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                responseType: "json",
                data: form_data,
                beforeSend: function (php_script_response) {
                    $('.file-field > .btn, .file-path-wrapper').addClass('disabled');
                    $('.file-path-wrapper > input, #enable-ocr').attr('disabled', true);

                    $('#convert-pdf').hide();
                    $('#download-converted-pdf')
                        .removeClass('red darken-4')
                        .addClass('orange darken-4')
                        .text('Processando, aguarde...')
                        .show();

                    let $s = 0;

                    setInterval(function () {
                        if ($s == 0) {
                            $('#download-converted-pdf').text('Ainda Processando, aguarde...');
                            $s++;
                        } else if ($s == 1) {
                            $('#download-converted-pdf').text('Espere, melhor pegar um café!');
                            $s++;
                        } else if ($s == 2) {
                            $('#download-converted-pdf').text('Aguente mais um pouco.');
                            $s++;
                        } else if ($s == 3) {
                            $('#download-converted-pdf').text('Quase lá...');
                            $s++;
                        } else {
                            $('#download-converted-pdf').text('Seja paciente, ainda processando!');
                            // $s = 0;
                        }
                    }, 7000)
                }
            });
        },

        postDownloadProcess: function (file_name) {
            $.post('inc/delete-pdf.php', {deleteFile: file_name});
        }
    };
})(jQuery);