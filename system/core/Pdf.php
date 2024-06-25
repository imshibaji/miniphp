<?php
namespace Shibaji\Core;

use TCPDF;

class Pdf
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->AddPage();
    }

    /**
     * Uses TCPDF to generate a PDF file with specified content.
     * 
     * $pdfManager = new PdfManager();
     * $filename = 'example.pdf';
     * $content = '<h1>Hello, world!</h1><p>This is a PDF generated using TCPDF.</p>';
     *
     * if ($pdfManager->generatePdf($filename, $content)) {
     *     echo "PDF file generated successfully.";
     * } else {
     *    echo "Failed to generate PDF file.";
     * }
     * 
     * Generates a PDF file with specified content.
     *
     * @param string $filename The name of the PDF file to generate.
     * @param string $content The content to write into the PDF file.
     * @return bool True on success, false on failure.
     */
    public function generate($filename, $content)
    {
        try {
            $this->pdf->writeHTML($content);
            $this->pdf->Output($filename, 'F'); // Save to file

            return true;
        } catch (\Exception $e) {
            echo "Error generating PDF: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Reads text content from a PDF file.
     * 
     * $filename = 'example.pdf';
     * $text = $pdfManager->readPdf($filename);
     * if ($text !== false) {
     *      echo "Text content from PDF:<br>";
     *      echo nl2br($text);
     *  } else {
     *      echo "Failed to read PDF file.";
     *  }
     * 
     * Reads text content from a PDF file.
     *
     * @param string $filename The name of the PDF file to read.
     * @return string|false The text content of the PDF file or false on failure.
     */
    public function read($filename)
    {
        try {
            // Load PDF file
            $fileContent = file_get_contents($filename);

            // Initialize TCPDF parser
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseContent($fileContent);

            // Extract text from all pages
            $text = '';
            foreach ($pdf->getPages() as $page) {
                $text .= $page->getText();
            }

            return $text;
        } catch (\Exception $e) {
            echo "Error reading PDF: " . $e->getMessage();
            return false;
        }
    }
}