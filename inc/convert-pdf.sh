#!/bin/bash
echo "Parameters"
echo '$1 = ' $1
echo '$2 = ' $2

#ORIGINAL: gs -dPDFACompatibilityPolicy=1 -dPDFA=1 -dBATCH -dNOPAUSE -sColorConversionStrategy=/RGB -sDEVICE=pdfwrite -sOutputFile=pdf-converted-to-a.pdf original.pdf
gs -dPDFACompatibilityPolicy=1 -dPDFA=2 -dBATCH -dNOPAUSE -sColorConversionStrategy=/RGB -sDEVICE=pdfwrite -sOutputFile=uploads/$2 uploads/$1