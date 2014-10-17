This sample shows the use of PMD.

But before debug it, you should change some configs in these files:

<h4>index.php</h4>
<ol>
<li>line 29: $dir="D:\workspace" //$dir should be the folder you want upload to git repository </li>
<li>line 38: "PMD-FrameWork"     //"PMD-FrameWork" is your git repository name </li>
</ol>
<h4>modules/config.php</h4>
<ol>
<li>line 8:	return $log["login"]("treemonster","******"); //The incoming parameters should be your git account</li>
</ol>

Now you can use this <b>Uploader</b> on your localhost, you can also extand its functions. I am sure that the Uploader is more esay use than Git client..
