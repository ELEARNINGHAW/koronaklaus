<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/*
*
* Supported File Formats: .XLS | .XLS | .CSV 
* 
* Table structure:
* +---------+-----------+------------+
* |   id    |   name    |    email   |
* +---------+-----------+------------+
* | int(11) | char(250) | char(300)  |
* +----+----+-----------+------------+
*
* The PHPExcel Library can designate a cell's location in a matrix as 
* (column, row) i.e. (0,1), (1,1), (2,1)...
* e.g. A1 becomes (0,1), B1 becomes (1,1) and C1 becomes (2,1).. and so on..
* Notice that the columns start from 0 and rows start from 1
*
*/
if(isset($_POST["export"]))
{
  require_once( "../db.class.php" );
  $db            = new DB( );
  
  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
 # $connect=mysqli_connect("localhost","root","","test");
 # $tblname=mysqli_real_escape_string($connect,$_POST['tblName']);
  #$query="SELECT * FROM `".$tblname."`";
  #print_r($query) ;
  $tab=$db->getKlausurenTable();
  
 
 
  
  if ($tab)
  {
    $fileExportMsg = "<label class='text-success'>Data Exported Successfully!</label>";

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $rowCount = 1;
    //setting column headings
    ##$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Name");
    ##$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,"E-mail");
  
    //Adding Data to Sheet
  
  
  
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Prüfungsfach' );
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Tag');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Datum');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Zeit');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, ' ' );
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Raum');
  
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,  'Prüfer/in');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Sem');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'SG');
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Kommentar');
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Studi 1');
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Studi 2');
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'RaumInfo');
  
    $rowCount++;
  
    
    
    foreach ( $tab as $row )
    {
    
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[ 'name'      ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[ 'wt'        ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[ 'date'      ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[ 'time'      ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, ''          );
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row[ 'rI'        ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row[ 'lastname'  ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row[ 'sem'       ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row[ 'SG'        ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row[ 'bemerkung' ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row[ 'anzstudi1' ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row[ 'anzstudi2' ]);
      $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row[ 'rInfo'     ]);
      $rowCount++;
    }
    $tblname = 'Klausurenverzeichnis';
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $file= "downloads/".time().$tblname.".xlsx";
    $objWriter->save($file);
    $fileDownload = "<label class='text-danger'><u><a href='".$file."'>Click Here </a></u> to download the file</label>";
  }
  else
  {
    $fileExportMsg = "<label class='text-danger'>Unknown Error occured!</label>";
  }

}
?>

<html>
 <head>
  <title>PHP Excel Exporter</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color: #0cb313b3;
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  input[type="file"]{
    border:1px solid gray;
  }
  
  </style>
 </head>
 <body>
  <div class="container box">
   <form method="post" enctype="multipart/form-data">
    <div class="container-fluid">
      <h3 align="center" class="text-success" style="font-weight:600;">Excel to Mysql Exporter</h3><br />
      <div class="row" style="margin-bottom:20px">
        <div class="col-md-4 col-md-offset-4 ">
          <img src="img/excel.png" height="150px" width="150px">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <label>Select Table To Export: </label>
        </div>
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
          <input type="radio" name="tblName" value=" vl_verzeichnis" checked>  Klausurenverzeichnis <br>
        </div>
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12" style="margin-top:20px">
            <input type="submit" name="export" class="btn btn-info" value="Export" style="padding:2px 20px;"/>
        </div>
      </div>
  </div>
   </form>
   <br />
   <?php
      echo @$fileExportMsg;
      echo "<br>";
      echo @$fileDownload;
      echo "<hr/>
			<p style='float:left'>* Supported Formats: .xls | .xlsx | .csv</p>
			<p style='float:right'><a href='index.php'>Importer &#8594;</a></p>";
   ?>
  </div>
 </body>
</html>