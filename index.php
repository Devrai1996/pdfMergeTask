<?php
date_default_timezone_set('Asia/Kolkata');
include 'PDFMerger.php'; 
use PDFMerger\PDFMerger; 
$pdf = new PDFMerger;

$files = glob('tmp/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file)) {
    unlink($file); // delete file
  }
}

function multiple_download(array $urls, $save_path = 'tmp')
{
    $multi_handle = curl_multi_init();
    $file_pointers = [];
    $curl_handles = [];

    // Add curl multi handles, one per file we don't already have
    foreach ($urls as $key => $url) {
        $file = $save_path . '/' . basename($url);
        if(!is_file($file)) {
            $curl_handles[$key] = curl_init($url);
            $file_pointers[$key] = fopen($file, "w");
            curl_setopt($curl_handles[$key], CURLOPT_FILE, $file_pointers[$key]);
            curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
            curl_setopt($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);
            curl_multi_add_handle($multi_handle,$curl_handles[$key]);
        }
    }

    // Download the files
    do {
        curl_multi_exec($multi_handle,$running);
    } while ($running > 0);

    // Free up objects
    foreach ($urls as $key => $url) {
        curl_multi_remove_handle($multi_handle, $curl_handles[$key]);
        curl_close($curl_handles[$key]);
        fclose ($file_pointers[$key]);
    }
    curl_multi_close($multi_handle);
}

// Files to download which will be taken from DB if we have in Table
$urls = [
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD107312205540085000-1731220554008500.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/404-9012833-0137142_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-5056321-1155509_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-4455185-5905913_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-5506700-5794751_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-4536622-4767528_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-9149230-0170747_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-9633108-6061921_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539270821-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539288415-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19807895696-SLP1140616899.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19807845682-SLP1140616862.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19807815705-SLP1140616841.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD207311672227236000-2731167222723602.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD507311505021513000-5731150502151300.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-6599938-0889938_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/404-7625042-4821125_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539129367-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539114325-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-0303287-1511553_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-2326605-6486768_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-5395774-3458768_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD507311467562657000-5731146756265700.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-9537812-3735564_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-6492784-8589133_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-0857298-7415525_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539053587-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2539010985-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538984393-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538958727-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD607311237362051000-6731123736205100.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19805275520-SLP1140421224.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19805014659-SLP1140406657.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19803429605-SLP1140286741.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-7456146-3809129_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538921681-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538853123-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-9284133-0781116_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19801906394-SLP1140178106.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-5670213-6464363_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/171-0998013-5440314_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-3428884-0889148_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/403-3179019-2162765_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-2892189-3625157_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD107310867834425001-1731086783442500.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/402-9459255-6661948_shippinglabel.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538638382-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538630871-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538512662-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538508341-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/flipkartShippingLabel_OD107310694756347000-1731069475634700.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19799680099-SLP1140008175.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19799407603-SLP1139999699.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19798917481-SLP1139967832.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19798845649-SLP1139957984.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19799239237-SLP1139987041.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19798716880-SLP1139950403.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19787010456-SLP1139961489.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19797915979-SLP1139887878.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538385725-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538361501-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538330738-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/ebayShippinglabel_2538321921-15242.pdf',
'https://btesimages.s3.amazonaws.com/PdfLabelFiles/SnapDealLabel_19798049434-SLP1139897601.pdf'
];
// Starting clock time in seconds
$start_fetching = microtime(true);
$start_fetching_time = date('Y-m-d H:i:s', $start_fetching);
echo "Starting PDF Fetching at: ".$start_fetching_time." sec \n";

multiple_download($urls);

// End clock time in seconds
$end_fetching = microtime(true);
$end_fetching_time = date('Y-m-d H:i:s',$end_fetching);
echo "PDF Fetch completed at: ".$end_fetching_time." sec \n";

$execution_time = ($end_fetching - $start_fetching);
echo $execution_time." sec to fetch 100 PDFs \n";
	
$start_merging_time = date('Y-m-d H:i:s');
echo "Starting PDF merging at:".$start_merging_time." sec \n";

foreach($files as $file){ 
	if(is_file($file)) {
		$fileStr = ''.$file.'';
		$pdf->addPDF($fileStr, 'all');
	}
}
$pdf->merge('file', __DIR__ .'\merged_pdf.pdf');

$end_merging = microtime(true);
$end_merging_time = date('Y-m-d H:i:s',$end_merging);
echo "Completed PDF merging at:".$end_merging_time." sec \n";

$final_time = ($end_merging - $start_fetching);
echo $final_time." sec to fetch and merge 100 PDFs \n";
echo "Open file merged_pdf.pdf";

?>