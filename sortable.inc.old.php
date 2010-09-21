<?php
function display_table($table_array, $style = '', $callback = ''){
   //Table array must be two-dimensional array with primary key the Column Name (Header) and the secondary the Row Number
   if(!is_array($table_array) || !is_array($table_array[key($table_array)])){
      trigger_error("First parameter must be a two-dimensional array, a different value given");
      return false;
   }

   echo "<script type='text/javascript'>\n";
   echo "   if(!document.tables) document.tables = new Array();\n";
   echo "   var I = document.tables.length;\n\n";
   echo "   document.tables[I] = new Array();\n";
   echo "   document.tables[I].sortKey     = '';\n";
   echo "   document.tables[I].sortReverse = -1;\n";
   echo "   document.tables[I].columns     = new Array();\n";
   foreach($table_array as $key=>$value){
      echo "\n      document.tables[I].columns['".$key."'] = new Array();\n";
      foreach($table_array[$key] as $k=>$v)
         echo "      document.tables[I].columns['".$key."']['".$k."'] = '".$v."';\n";
   }

   if($style != ''){
      if(!is_array($style))
         $style = array('table'=>$style);

      echo "\n   document.tables[I].style = new Array();\n\n";
      echo "      document.tables[I].style['table']  = '".((isset($style['table']))    ? ' '.$style['table']     : "")."';\n";
      echo "      document.tables[I].style['header'] = '".((isset($style['header']))   ? ' '.$style['header']    : "")."';\n";
      echo "      document.tables[I].style['column'] = '".((isset($style['column']))   ? ' '.$style['column']    : "")."';\n";
      echo "      document.tables[I].style['row']    = new Array();\n";
      echo "      document.tables[I].style['row'][0] = '".((isset($style['row']))        ? ' '.$style['row']        : "")."';\n";
      echo "      document.tables[I].style['row'][1] = '".((isset($style['row_odd']))    ? ' '.$style['row_odd']    : "")."';\n";
      echo "      document.tables[I].style['row'][2] = '".((isset($style['row_even']))   ? ' '.$style['row_even']   : "")."';\n";
      echo "      document.tables[I].style['row'][3] = '".((isset($style['row_header'])) ? ' '.$style['row_header'] : "")."';\n";
   }

   if(strlen(trim($callback))>0){
      if(!isset($_GLOBALS['cfi'])) $_GLOBALS['cfi'] = 0;
      echo "\n   function callback_".(++$_GLOBALS['cfi'])."(col,val){ ".$callback." }\n";
   }

   reset($table_array);
   echo "\n document.write(dump_table(I, '".key($table_array)."'".(strlen(trim($callback))>0 ? ", ".$_GLOBALS['cfi'] : "")." ));\n";
   echo "</script>\n\n\n";
}
?>