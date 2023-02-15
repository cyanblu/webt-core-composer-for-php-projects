<?php
require_once 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

//if isset nr
//else echo Formular

$input = '+43 1 22 33 444';

if (isset($_GET['nr'])) {
    if(!$_GET['nr'] == ''){

        $input = $_GET['nr'];
    }

    $phone = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data('tel:' . $input)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText('This is the label')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();

    header('Content-Type: ' . $phone->getMimeType());
    // Directly output the QR code

    echo $phone->getString();

} else {
    echo <<<FORMULAR
    <div>
     <form action="index.php" method="get">
        <label for="fname">Make your phone number a QR Code</label>
        <input id="num" type="text" placeholder="+43 1 22 33 444" name="nr">
        <button>Sumbit</button>
        </form>
     </div>
    FORMULAR;
}
