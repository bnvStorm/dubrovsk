<?
$curTheme = $_POST['curTheme'];
$templatePath = $_POST['TEMPLATE_PATH'];
$fileInput = $_SERVER['DOCUMENT_ROOT'].$templatePath.'/css/themes/'.$curTheme.'.css';
$fileOutput = $_SERVER['DOCUMENT_ROOT'].$templatePath.'/css/themes/theme-params.css';
if(copy($fileInput, $fileOutput)) ;{
	echo htmlspecialchars($fileOutput);
}
?>