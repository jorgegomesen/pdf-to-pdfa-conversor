#!/bin/bash

# Script to convert PDF file to JPG images
#
# Dependencies:
# * ocrmypdf

PDF=$1

echo "Processing $PDF"
DIR=`basename "$1" .pdf`

mkdir "$DIR"

echo 'Param: ' $1 
echo 'DIR: ' "$DIR"
echo 'Name: ' "$DIR"/$DIR-ocr.pdf
echo 'Add OCR and converting to PDF-A'

ocrmypdf \
    --pdf-renderer sandwich \
    --jbig2-lossy \
    --optimize 3 \
    --pdfa-image-compression lossless \
    --force-ocr \
    --output-type pdfa \
    -l por \
    -d \
    $1 uploads/converted-$DIR.pdf

echo 'All done'
# ocrmypdf -d --pdf-renderer auto --output-type pdfa -l por --force-ocr --rotate-pages $1 "$DIR"/$DIR-ocr.pdf