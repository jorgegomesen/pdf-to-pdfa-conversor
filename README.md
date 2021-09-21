# Conversor PDF/A

## Sobre

Ferramenta desenvolvida com o intuito de fornecer uma interface simples para a conversão de arquivos no formato PDF, para o formato PDF/A, um derivado da especificação proprietária, em conformidade com a [ISO 19005:2005](https://www.iso.org/standard/38920.html) e [ISO 32000:2008](https://www.iso.org/standard/51502.html), além de realizar o reconhecimento ótico de caracteres, também conhecido como [OCR](https://pt.wikipedia.org/wiki/Reconhecimento_%C3%B3tico_de_caracteres).

## Começando

Se você não possui instalado o gulp, rode `npm rm --global gulp` antes de prosseguir.

### Instalale também o `gulp` linha de comando

```sh
npm install --global gulp-cli
```

### Dependências

A tarefa seguinte irá instalar os pacotes necessários para o projeto.

```sh
npm install
```

### Agora basta rodar a tarefa watch

Essa tarefa ficará 'observando' os diretórios de origem - source (/src), em busca de modificações e criará os arquivos finais de distribuição (/dist) automaticamente

```sh
gulp watch
```

## Erros comuns

O upload do arquivo PDF é efetuado, processado e após o download, não é possível visuliza-lo. Verifique o diretório de upload de arquivos, localizado em **inc/uploads**, a propriedade deste diretório (ownership) deve ser do Apache (www-data), gerando um erro semelhante à: *"PHP Warning:  move_uploaded_file(): Unable to move '/tmp/php3e5AUP' to '/var/www/html/inc/uploads/"*. 

Para resolver esse problema, execute o seguinte comando: 

```sh
chown -R www-data:www-data folder
```

## TODO

Corrigir o script que faz a remoção automática dos arquivos - só funciona a primeira vez (depois é necessário recarregar a pagina).