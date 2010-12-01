<?php

//Create & Open PDF-Object
$pdf = pdf_new();
pdf_open_file($pdf);
pdf_set_info($pdf, "Author","Bob Nijman");
pdf_set_info($pdf, "Title","Sponsored by www.nijman.de");
pdf_set_info($pdf, "Creator", "See Author");
pdf_set_info($pdf, "Subject", "pdf_restore");
pdf_begin_page($pdf, 300, 300);


/*
By encapsulating the changes we make to the coordinate system
(pdf_translate() and pdf_rotate()) between pdf_save() and pdf_restore
we give these changes only local scope.
*/

/*
SMALL RECTANGLE
*/

pdf_save($pdf);
//move the origin of the coordinate system to (100,100)
pdf_translate($pdf, 100, 100);
//Rotate the coordinate system by 45 degrees.
pdf_rotate($pdf, 45);
//Draw a samll rectangle
pdf_rect($pdf, 0, 0, 20, 20);
pdf_stroke($pdf);
//Restore the graphics state to the way it was
//before we started to translate and rotate
pdf_restore($pdf);


/*
LARGER RECTANGLE
*/

pdf_save($pdf);
//move the origin of the coordinate system to (10,20)
pdf_translate($pdf, 10, 20);
//Rotate the coordinate system by 15 degrees.
pdf_rotate($pdf, 15);
//Draw a larger rectangle
pdf_rect($pdf, 0, 0, 40, 40);
pdf_stroke($pdf);
//Restore the graphics state to the way it was
//before we started to translate and rotate
pdf_restore($pdf);



//close it up
pdf_end_page($pdf);
pdf_close($pdf);
$data = pdf_get_buffer($pdf);
header('Content-type: application/pdf');
header('Content-disposition: inline; filename=nijman.pdf');
header('Content-length: ' . strlen($data));
echo $data;

?> 