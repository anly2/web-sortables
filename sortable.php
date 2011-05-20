<?php
if(!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST'])
   exit;
?>
function sortable(node){
   if(!node) return false;

   // Locate the table object
   var table;
   
   if(node.tagName.toLowerCase()=='table')
      table = node;
   else
      if(Array("tr", "td", "th", "tbody", "thead", "tfoot", "caption").indexOf(node.tagName.toLowerCase())>-1){
         var obj = node;
         while( (obj = obj.parentNode) && (obj.tagName.toLowerCase()!='table') ) continue;

         if(obj.tagName.toLowerCase()=='table')
            table = obj;
         else
            return false;
      }else
         return false;
   
   // CHANGEable variables
   table.diPosition       = 0; // direction_indicator_position,  0 -> Before Header, 1 -> After Header, -1 -> Not displayed
	table.sortOrderDefault = -1; // 1 -> Ascending, -1 -> Descending
	// END of CHANGEable variables

	// Not for editing!!!
	table.sortOrder = table.sortOrderDefault;
	table.sortedBy  = null;
	
   // Add event triggers
   for(ci=0; ci<table.rows[0].cells.length; ci++){
      table.rows[0].cells[ci].table      = table;
      table.rows[0].cells[ci].className += "sort header";
      table.rows[0].cells[ci].onclick    = new Function("this.table.effect("+ci+");");
   }

	// Define the sort rule
   table.sortRule = function(rowA, rowB){
      // Uses "table" reference
      // Tryed to avoid it, but relocating the table is much harder/heavier
      // Hopefully, no problems will come out of it

      // Get the actuall values to compare
      var a = rowA.cells[table.sortedBy].innerHTML;
      var b = rowB.cells[table.sortedBy].innerHTML;
                
      // If is Not_a_Number (string/alike)
      if(isNaN(a) || isNaN(b))
         return (table.sortOrder * ((a<b) - (a>b)));

      // If is number
      return table.sortOrder * (b - a);
   }

   // Define the sort function
   table.sort = function(col){
      //Toggle internal variables
      if(this.sortedBy == col)
         this.sortOrder *= -1;
      else
         this.sortOrder  =  this.sortOrderDefault;
         
      this.sortedBy = col;


      // Apply indication of the sorting
         // Remove the previous indicators
         di_collection = this.getElementsByClassName("sort direction");
         for(i=0; i<di_collection.length; i++)
            di_collection[i].parentNode.removeChild( di_collection[i] );

      	// Assemble a new indicator
         var ih  = this.rows[0].cells[col].innerHTML;                           // ih = /innerHTML shorthand/
         var di  = '<span class="sort direction '+((this.sortOrder==-1)? "down" : "up")+'">';
             di += ((this.sortOrder==-1)? "&darr;" : "&uarr;")+'</span>';        // di = /Direction Indicator/

      	// Deploy the new indicator
         if(this.diPosition != -1) // -1 -> Disabled
            this.rows[0].cells[col].innerHTML = ( (this.diPosition == 0)?  (di + ih) : (ih + di) );


      // Fetch the table values as an array
         // The reason why table.rows is not used directly is cause it's semi-array, lacking the sort method
      var arr = new Array();
      for(i=0; i<this.rows.length; i++)
         arr[i] = this.rows[i];


      // Sort the array
      arr.shift(); // Explude the first/header row
      arr.sort( this.sortRule );


      // Redisplay the table using the sorted array
         // Re-appending nodes should move them instead of applying a new copy
      for(i=0; i<arr.length; i++)
      	this.appendChild(arr[i]);
   }

   // Alias function names 
   table.effect = table.sort;
   table.sortBy = table.sort;
   table.sortby = table.sort;

   return table;
}

// Make sortable By Class
function Sortables(){
   var tables = document.getElementsByTagName('table');
   
   for(i=0; i<tables.length; i++){
      if(tables[i].className.indexOf("sortable") != -1)
      	new sortable(tables[i]);
   }
}

if(window.addEventListener)
   window.addEventListener("load", Sortables, false);
else
   if(window.attachEvent)
      window.attachEvent("onload", Sortables);
   else
      window.onload = Sortables;