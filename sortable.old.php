<?php if(!isset($_SERVER['HTTP_REFERER'])) exit; ?>
// Called from "display_table()" function, defined in connection.db.php
// Alone, this library is pretty much useless

var currentTable = 'none';
function accordingToOriginal(a, b){
   var at,bt;
   with(document.tables[currentTable]){
      at = columns[sortKey][a];
      bt = columns[sortKey][b];

      if(isNaN(at) || isNaN(bt))
         return (sortReverse * ((at<bt) - (at>bt)));

      return sortReverse * (bt - at);
   }
}

function dump_table(tableID, sortBy, callbackN){
   currentTable = tableID;
   var row = 0;
   if(callbackN !=null) callback   = eval('callback_'+callbackN);

   with(document.tables[currentTable]){

      if(typeof style != 'object' || !(style instanceof Array)){
         style = new Array();
         style['table'] = '';
         style['header'] = ''; style['column'] = '';
         style['row'] = new Array();
         style['row'][0] = '';
         style['row'][1] = ''; style['row'][2] = '';
         style['row'][3] = '';
      }

      if(sortKey == sortBy) sortReverse = sortReverse*(-1);
      sortKey = sortBy;

      var result  = '<span>';
      result += '<table'+style['table']+'>';

      result += '   <tr'+((style['row'][3]!='')? style['row'][3] : style['row'][0])+'>';
      for(headerColumn in columns){
        result += '      <th'+style['header']+' onclick="this.parentNode.parentNode.parentNode.parentNode.innerHTML = dump_table('+currentTable+', \''+headerColumn+'\''+(callbackN!=null? ', \''+callbackN+'\'' : '')+');">';
        if(headerColumn == sortBy) result+= (sortReverse==-1)? "&darr; " : "&uarr; ";
        result += headerColumn+'</th>';
      }
      result += '   </tr>';
      row++;


      var tmp_arr = new Array();
      for(key in columns[sortKey])
         tmp_arr.push(key);

      tmp_arr.sort(accordingToOriginal);

      for(tai in tmp_arr){
         result += '   <tr'+((style['row'][(2-(row%2==0))]!='')? style['row'][(2-(row%2==0))] : style['row'][0])+'>';
         for(c in columns){
            result +='      <td'+style['column']+'>';
            if(typeof callback != 'undefined') result += callback(c, columns[c][tmp_arr[tai]]);
            else result += columns[c][tmp_arr[tai]]+'</td>';
         }
         result += '   </tr>';
         row++;
      }

      result += '</table>';
      result += '</span>';

      return result;
   }
   currentTable = 'none';
}