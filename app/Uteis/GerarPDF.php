<?php
/**
 * Created by PhpStorm.
 * User: fabio_000
 * Date: 16/08/2017
 * Time: 09:27
 */

namespace Seracademico\Uteis;


class GerarPDF extends \TCPDF
{

    /**
     * @var string
     */
    private $titulo = "";

    /**
     * @var string
     */
    private $urlImagem = "";

    //Page header
    public function Header() {

        // Set font
        $this->SetFont('helvetica', '', 9);
        // Title
        $this->Cell(190, 45, $this->titulo, 0, false, 'C', 0, '', 0, false, 'C', 'B');

        // Logo
        $this->Image($this->urlImagem, 100, 3, 20, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);

    }

    // Page footer
    public function Footer() {
        // Set font
        $this->SetFont('helvetica', '', 9);
        // Title
        $this->Cell(190, 10, $this->titulo, 0, false, 'C', 0, '', 0, false, 'C', 'M');

        // Logo
        $this->Image($this->urlImagem, 100, 265, 20, '', 'PNG', '', 'M', false, 300, '', false, false, 0, false, false, false);
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getUrlImagem()
    {
        return $this->urlImagem;
    }

    /**
     * @param string $urlImagem
     */
    public function setUrlImagem($urlImagem)
    {
        $this->urlImagem = $urlImagem;
    }

}