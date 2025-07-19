<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->addExternalCss($this->GetFolder().'/style.css');

$currentSectionCode = $_GET['section'] ?? '';
$sectionId = null;

if($currentSectionCode) {
    $rsSection = CIBlockSection::GetList(
        [],
        [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'CODE' => $currentSectionCode,
            'ACTIVE' => 'Y'
        ],
        false,
        ['ID', 'NAME']
    );
    if($arSection = $rsSection->Fetch()) {
        $sectionId = $arSection['ID'];
        
        $APPLICATION->AddChainItem($arSection['NAME']);
        if($arParams['SET_TITLE'] != 'N') {
            $APPLICATION->SetTitle($arSection['NAME']);
        }
    }
}

global $arrFilter;
if($sectionId) {
    $arrFilter = [
        'SECTION_ID' => $sectionId,
        'INCLUDE_SUBSECTIONS' => 'Y'
    ];
    $arParams['FILTER_NAME'] = 'arrFilter';
    $arParams['STRICT_SECTION_CHECK'] = 'Y';
}

$rsSections = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y'
    ],
    false,
    ['ID', 'CODE', 'NAME', 'SECTION_PAGE_URL']
);
?>

<div class="news-sections">
    <a href="?" class="section-link<?=($currentSectionCode === '' ? ' active' : '')?>">Все новости</a>
    <?while($arSection = $rsSections->Fetch()):?>
        <a href="?section=<?=$arSection['CODE']?>" 
           class="section-link<?=($arSection['CODE'] == $currentSectionCode ? ' active' : '')?>">
            <?=$arSection['NAME']?>
        </a>
    <?endwhile?>
</div>

<?php
if($arParams["USE_RSS"]=="Y") {
    if(method_exists($APPLICATION, 'addheadstring')) {
        $APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" href="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" />');
    }
}

if($arParams["USE_SEARCH"]=="Y") {
    $APPLICATION->IncludeComponent(
        "bitrix:search.form",
        "flat",
        Array(
            "PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
        ),
        $component
    );
}

if($arParams["USE_FILTER"]=="Y") {
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.filter",
        "flat",
        Array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
            "PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        ),
        $component
    );
}

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "emp",
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "NEWS_COUNT" => $arParams["NEWS_COUNT"],
        "SORT_BY1" => $arParams["SORT_BY1"],
        "SORT_ORDER1" => $arParams["SORT_ORDER1"],
        "SORT_BY2" => $arParams["SORT_BY2"],
        "SORT_ORDER2" => $arParams["SORT_ORDER2"],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
        "SET_TITLE" => "N",
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "MESSAGE_404" => $arParams["MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
        "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
        "STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"] ?? 'Y',
        "PARENT_SECTION" => $sectionId,
        "PARENT_SECTION_CODE" => $currentSectionCode
    ),
    $component
);
?>