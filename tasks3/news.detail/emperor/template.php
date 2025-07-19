<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link href="/css/common.css" rel="stylesheet">
    <title><?=$arResult["NAME"]?> | <?=$APPLICATION->GetTitle()?></title>
</head>
<body>
<div class="article-card">
    <div class="article-card__title"><?=$arResult["NAME"]?></div>
    
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <div class="article-card__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
    <?endif?>

    <div class="article-card__content">
        <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
            <?if(is_array($arResult["DETAIL_PICTURE"])):?>
                <div class="article-card__image sticky">
                    <img 
                        src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" 
                        alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" 
                        data-object-fit="cover"
                    />
                </div>
            <?elseif($arResult["SLIDER"] && count($arResult["SLIDER"]) > 0):?>
                <div class="article-card__image sticky">
                    <img 
                        src="<?=$arResult["SLIDER"][0]["SRC"]?>" 
                        alt="<?=$arResult["SLIDER"][0]["ALT"]?>" 
                        data-object-fit="cover"
                    />
                </div>
            <?endif?>
        <?endif?>

        <div class="article-card__text">
            <div class="block-content">
                <?if($arResult["NAV_RESULT"]):?>
                    <?=$arResult["NAV_TEXT"]?>
                <?elseif($arResult["DETAIL_TEXT"] <> ''):?>
                    <?=$arResult["DETAIL_TEXT"]?>
                <?else:?>
                    <?=$arResult["PREVIEW_TEXT"]?>
                <?endif?>
            </div>

            <a class="article-card__button" href="<?=$arResult["LIST_PAGE_URL"]?>">Назад к новостям</a>
        </div>
    </div>
</div>
</body>
</html>