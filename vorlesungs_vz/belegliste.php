<?php
#error_reporting(1);
session_start();
error_reporting(E_ALL);
#include ("checkreferer.php");#
#$_SESSION["r"] = null;

$_SESSION[ 'where' ] = '';
$go = 0;

if ( isset ( $_GET[ 'action' ] ) )
{
  require_once( "ajax.php" );
}

if ( isset ( $_GET[ 'go' ]) )
{
  $go = $_GET[ 'go' ] ;
}

if (($_SESSION[ 'user' ][ 'ro' ] ) >= 2 )
{
  require_once( "../inc/belegliste.class.php"  );
  require_once( "../inc/db.class.php"          );
  require_once( "../inc/vz.data.class.php"     );
  require_once( "../inc/vz.render.class.php"   );
  require_once( "../inc/db.SQLL.class.php"     );
  require_once( "htmlheader.php"               );

  $dbL                    = new SQLL_DB();
  $db                     = new DB( $dbL );
  $bl                     = new Belegliste( $db );
  $data                   = new Data();
  $render                 = new Render();

  if ( $go == 3 ) ## ---- import userdata ----
  {
    $alleDozenten = $db -> getAllDozent();
    foreach ( $alleDozenten as $doz )
    { if ( $usr = $dbL -> getUserData( $doz[ 'lastname' ] ) )
      { $u = $db -> update2Dozent( $doz, $usr );
      }
    }
  }
    $can_edit               = $bl -> isChangeable();              # Bei Nutzer, die Umbuchungen vornehmen dürfen.

  if ( $go == 2 )
  {  $extVorlesungsliste = $db -> getExtKlausurplan(0 );
    $html .= $render -> renderExtKlausurListe( $extVorlesungsliste, $db,  $can_edit );
  
  }
  
  if ( $go == 1 )
  { $vorlesungsliste    = $db -> getVorlesung(0 );        # aktueller Veranstalungsplan: Studigengang - Semester - Professor
    $I[ 'alldozenten' ] = $db -> getAllDozent(); #
    $I[ 'allLVA'      ] = $db -> getLehrveranstaltung();
    $I[ 'allSG'       ] = $db -> getStudiengaenge();

    $html .= $render->renderKlausurListe( $vorlesungsliste, $I,  $can_edit  );

  }
  
  #deb($extVorlesungsliste);

     $html .= '</body></html>';
     echo $html;
}

else 
{    die("SESSION CLOESED");
}

function deb($var)
{
  echo "<pre>";
  print_r($var);
  echo "</pre>";
}
?>                         