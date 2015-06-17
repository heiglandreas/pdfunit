# PDFUnit

An extension to PHPUnit to test creation of PDF-Files.

## About

Creating PDF-Files is always a bit difficult as the best comparison is a visual one.

As 2 PDF-Files can be internally completely different there is no way of comparing
them on a source-code-level. Therefore comparing them by creating an image and comparing
that to a known-good file. The differences between the two files are calculated
and measured against a threshold.

## Installation

    $ composer require org_heigl/pdfunit

## Usage


