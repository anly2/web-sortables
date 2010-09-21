<?php
require "sortTables.inc.php";

$table[0]['Име']   = array("Азбука", "Брой", "Варна", "Габрово");
$table[0]['ЕГН']    = array("0000000001", "0000000020", "0000000003", "0000000004");
$table[0]['Доктор'] = array("3", "1", "2", "1");

$table[1]['Owner'] = array("Александър Димитров Йорданов", "Калоян Иванов Калоянов", "Николай Петров Петров", "Георги Симеонов Стефанов");
$table[1]['Model'] = array("ME3510", "SG1602", "LG6115", "SS5210");
$table[1]['Price'] = array("449", "289", "225", "669");
?>
<html>
<head>
   <title>Test: Sorting Tables</title>

   <script type="text/javascript" src="sortTables.js.php"></script>
</head>
<body>
<?php display_table($table[0], 'border="1"', 'if(col=="Име") return "<b>"+val+"</b>"; else return val;'); ?>
<br />
&uarr; An example table that uses callback function to format <b>some</b> field values (&lt;table&gt; additionally styled for border=1)
<br /><br />
&darr; An example table that uses styles to additionally define each table element
<br />
<dd><small><big>Table elements:</big> &lt;table&gt; , &lt;td&gt; , &lt;th&gt; , &lt;tr&gt; , Odd Rows, Even Rows, Header Row</small></dd>
<br /><br />
<?php display_table($table[1], array('table'=>'border="1"', 'row_header'=>'style="background-color:#666699;"', 'row_even'=>'style="background-color:#eeeeff;"', 'row_odd'=>'style="background-color:#9999cc;"')); ?>
</body>
</html>