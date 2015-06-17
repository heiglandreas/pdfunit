# PDFUnit

An extension to PHPUnit to test creation of PDF-Files.

## About

Creating PDF-Files is always a bit difficult as the best comparison is a visual one.

As 2 PDF-Files can be internally completely different there is no way of comparing
them on a source-code-level. Therefore comparing them by creating an image and comparing
that to a known-good file. The differences between the two files are calculated
and measured against a threshold.

## Requirements

This package requires imagemagicks ```compare```-binary to be installed and available in the path.

## Installation

    $ composer require org_heigl/pdfunit

## Usage


    namespace Acme;

    use Org_Heigl\PDFUnit\TestCase;

    class PDFTest extends TestCase
    {
        public function testPdf()
        {
            $this->assertPdfDiffBelowThreshold(
                'known-good.pdf',
                0.4,
                'generated.pdf'
            );
        }
    }


This will compare ```generated.pdf``` agains ```known-good.pdf``` and checks whether the
difference is less or equals to 0.4.
