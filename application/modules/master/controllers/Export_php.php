<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpofficephpspreadsheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//untuk protection
use PhpOffice\PhpSpreadsheet\Style\Protection;

//untuk set warna
use PhpOffice\PhpSpreadsheet\Style\Color;

//untuk set kertas
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

//untuk pagebreak
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

//untuk penambahan border
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

// End load library phpspreadsheet

class Export_php extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/items'));  
        $this->isMenu();
        $this->load->model('master/items_model');
    }


	function index(){
        $data['data_items']     = $this->items_model->get_items();
        $this->template->load('body', 'master/items/items_view',$data);
	}

    function export_data(){
        $data     = $this->items_model->get_items();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Code')
            ->setCellValue('C1', 'Name')
            ->setCellValue('D1', 'Items Unit')
            ->setCellValue('E1', 'Items Group');

    //MEWARNAKAN FONT
        $font_a = array(
            'name'      => 'Times New Roman',
            'bold'      => true,
            'italic'    => true,
            'underline' => true,
            'color'     => array('argb' => 'FFFF0000'),
            'size'      => 17);

        $font_b = array(
            'name'      => 'Times New Roman',
            'bold'      => true,
            'italic'    => true,
            'underline' => true,
            'color'     => array('argb' => 'FFFF0000'),
            'size'      => 10);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->applyFromArray($font_a);
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->applyFromArray($font_b);
    //MEWARNAKAN FONT

        $i=2; 
        $no=0;
        foreach($data as $datas) {
            $no = $no+1;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $no)
                ->setCellValue('B'.$i, $datas->items_code)
                ->setCellValue('C'.$i, $datas->items_nama)
                ->setCellValue('D'.$i, $datas->items_unit)
                ->setCellValue('E'.$i, $datas->items_group);
            $i++;
        }

        // $spreadsheet->getActiveSheet()->getStyle('A1:I21')->applyFromArray(
        //     ['fill' => [
        //                 'fillType' => Fill::FILL_SOLID,
        //                 'color' => ['argb' => 'FFCCFFCC'],
        //             ],
        //             'borders' => [
        //                 'bottom'=> ['borderStyle' => Border::BORDER_THIN],
        //                 'right' => ['borderStyle' => Border::BORDER_THICK],
        //                 'left'  => ['borderStyle' => Border::BORDER_SLANTDASHDOT],
        //                 'top'    => ['borderStyle' => Border::BORDER_MEDIUMDASHED],
        //             ],
        //         ]
        // );

        $sharedStyle1 = new Style();
        $sharedStyle2 = new Style();

        $sharedStyle1->applyFromArray(
            [
                'fill' => 
                    [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFCCFFCC'],
                    ],
                'borders' => 
                    [
                        'bottom'=> ['borderStyle' => Border::BORDER_THIN],
                        'right' => ['borderStyle' => Border::BORDER_THIN],
                        'left'  => ['borderStyle' => Border::BORDER_THIN],
                        'top'   => ['borderStyle' => Border::BORDER_THIN],
                    ],
            ]
        );

        $sharedStyle2->applyFromArray(
            [
                'fill' => 
                    [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FF0000'],
                    ],
                'borders' => 
                    [
                        'bottom'=> ['borderStyle' => Border::BORDER_THIN],
                        'right' => ['borderStyle' => Border::BORDER_THICK],
                        'left'  => ['borderStyle' => Border::BORDER_SLANTDASHDOT],
                        'top'    => ['borderStyle' => Border::BORDER_MEDIUMDASHED],
                    ],
            ]
        );

        $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle1, 'A1:E1');
        $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle1, 'H1:I7');

        $spreadsheet->getActiveSheet()->setCellValue('H1', 'Description')
            ->setCellValue('I1', 'Amount');

        $spreadsheet->getActiveSheet()->setCellValue('H2', 'Paycheck received')
            ->setCellValue('I2', 100);

        $spreadsheet->getActiveSheet()->setCellValue('H3', 'Cup of coffee bought')
            ->setCellValue('I3', -1.5);

        $spreadsheet->getActiveSheet()->setCellValue('H4', 'Cup of coffee bought')
            ->setCellValue('I4', -1.5);

        $spreadsheet->getActiveSheet()->setCellValue('H5', 'Cup of tea bought')
            ->setCellValue('I5', -1.2);

        $spreadsheet->getActiveSheet()->setCellValue('H6', 'Found some money')
            ->setCellValue('I6', 8);

        $spreadsheet->getActiveSheet()->setCellValue('H7', 'Total:')
            ->setCellValue('I7', '=SUM(I2:I6)');

        $spreadsheet->getActiveSheet()->setCellValue('A24', 'Firstname')
            ->setCellValue('B24', 'Lastname')
            ->setCellValue('C24', 'Phone')
            ->setCellValue('D24', 'Fax')
            ->setCellValue('E24', 'Is Client ?');

        for ($i = 25; $i <= 74; ++$i) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, "FName $i");
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, "LName $i");
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, "PhoneNo $i");
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, "FaxNo $i");
            $spreadsheet->getActiveSheet()->setCellValue('E' . $i, true);

            // Add page breaks every 10 rows
            if ($i % 10 == 0) {
                // Add a page break
                $spreadsheet->getActiveSheet()->setBreak('A' . $i, Worksheet::BREAK_ROW);
            }
        }

        $spreadsheet->getActiveSheet()->getStyle('A25:E74')->applyFromArray(
            ['fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFFFFF00'],
                    ],
                ]
        );

        // Set print headers
        $spreadsheet->getActiveSheet()
            ->getHeaderFooter()->setOddHeader('&C&24&K0000FF&B&U&A');
        $spreadsheet->getActiveSheet()
            ->getHeaderFooter()->setEvenHeader('&C&24&K0000FF&B&U&A');

        // Set print footers
        $spreadsheet->getActiveSheet()
            ->getHeaderFooter()->setOddFooter('&R&D &T&C&F&LPage &P / &N');
        $spreadsheet->getActiveSheet()
            ->getHeaderFooter()->setEvenFooter('&L&D &T&C&F&RPage &P / &N');

        $spreadsheet->getActiveSheet()->setTitle('Invoice');


    //untuk protection (ga bisa edit)
        // $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        // $spreadsheet->getActiveSheet()
        //     ->getStyle('A2:B2')
        //     ->getProtection()->setLocked(
        //         Protection::PROTECTION_UNPROTECTED
        //     );

        // Pilih salah satu
        // $spreadsheet->getActiveSheet()->getProtection()->setPassword('PhpSpreadsheet');
        // $spreadsheet->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
        // $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        // $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        // $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);

    //untuk protection

    //Untuk Password (belum bisa di jalankan.)
        // $spreadsheet->getSecurity()->setLockWindows(true);
        // $spreadsheet->getSecurity()->setLockStructure(true);
        // $spreadsheet->getSecurity()->setLockRevision(true);
        // $spreadsheet->getSecurity()->setWorkbookPassword('123');
        // $spreadsheet->getSecurity()->setRevisionsPassword('123');
    //Untuk Password



        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        

        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

}
?>