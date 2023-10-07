<?php
namespace Inc;

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Util;

class MpdfCustom
{
    private $pdf;
    const FORMAT_A4 = 'A4';
    const FORMAT_A0 = 'A0';
    const FORMAT_A1 = 'A1';
    const FORMAT_A2 = 'A2';
    const FORMAT_A3 = 'A3';
    const FORMAT_A5 = 'A5';
    const FORMAT_A6 = 'A6';
    const FORMAT_A7 = 'A7';
    const FORMAT_TICKET = [80, 297];
    const FORMAT_A8 = 'A8';
    const FORMAT_A9 = 'A9';
    const FORMAT_A10 = 'A10';

    const ORIENTATION_VERTICAL = 'P';
    const ORIENTATION_HORIZONTAL = 'L';

    /**
     * Size ticket: 80mm
     * Default margin: 56px
     * OJO: No se puede posicionar un footer al final del papel con Mpdf
     */

    public function __construct($format = 'A4')
    {
        #margin por default del papel: 8 mm (milímetros)
        $this->pdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => $format,
            'orientation'   => self::ORIENTATION_VERTICAL,
            'margin_top'    => 8,
            'margin_bottom' => 8,
            'margin_left'   => 8,
            'margin_right'  => 8,
        ]);
        $this->setCss('/css/globals_views.css');
    }

    /**
     * @param $file_path
     * @param $dataDynamic
     * @return void
     * $dataDynamic: Before return 'stdClass': Acepta array or stdClass => internamente lo convierte a 'stdClass'
     * $file_path => Directamente apunta a 'views'
     * No es necesario poner '.tpl' al final del '$file_path'
     * Example: ('pdf/voucher_a4/index', $data)
     */
    public function setHtml(string $file_path, $dataDynamic)
    {
        $html = view($file_path, Util::convertArrToStdClass($dataDynamic));
        $this->pdf->WriteHTML($html);
    }

    /**
     * @param $file_path
     * @return void
     * $file_path => Directamente apunta a 'views'
     * EXAMPLE: '/css/globals_views.css'
     */
    public function setCss(string $file_path)
    {
        $css = file_get_contents(URL_INTERNAL_VIEWS . $file_path);
        $this->pdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);
    }

    public function addPage()
    {
        $this->pdf->AddPage();
    }

    public function setFooter($footer)
    {
        $this->pdf->SetFooter($footer);
    }

    public function setHeader($value)
    {
        $this->pdf->SetHeader($value);
    }

    public function generatePdf($filename = 'document.pdf', $downloadDirect = false)
    {
        if ($downloadDirect) {
            $this->pdf->Output($filename, 'D');
        } else {
            $this->pdf->Output($filename, 'I');
        }
    }
}
