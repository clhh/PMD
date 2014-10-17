This sample shows the use of PMD.

Before use, you should change some configs in these files:

<ol>
index.php
<li>line 29: $dir="D:\workspace" //$dir should be the folder you want upload to git repository </li>
<li>line 38: "PMD-FrameWork"     //"PMD-FrameWork" is your git repository name </li>
</ol>
<ol>
modules/config.php
<li>line 8:	return $log["login"]("treemonster","******"); //The incoming parameters should be your git account</li>
</ol>
