<?
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");
?>
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/404.css">

<div class="page-not-found container text-center">
    <h2 style="font-size:24px">404 :(<br></h2>
    <h3><span>Страница<br>не найдена</span></h3>
</div>
<div class="go-to-main"><a href="/">На главную</a></div> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>