<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
?>
<div class="test-users-list">
    <table>
        <thead>
            <tr>
                <td><?=Loc::getMessage('TEST_USER_LIST_ID')?></td>
                <td><?=Loc::getMessage('TEST_USER_LIST_NAME')?></td>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($arResult["USERS"] as $user){
                ?>
                <tr>
                    <td>
                        <?=$user["ID"]?>
                    </td>
                    <td>
                        <?=$user["NAME"]?>
                    </td>
                </tr>
                <?
            }
            ?>
        </tbody>
    </table>
    <div class="btn_nav">
        <?=$arResult["NAV_STRING"]?>
    </div>
    <div class="btn-export">
        <a href="/local/components/test/users.list/export.php?mode=csv"><?=Loc::getMessage("TEST_USER_LIST_CSV")?></a>
        <a href="/local/components/test/users.list/export.php?mode=xml"><?=Loc::getMessage("TEST_USER_LIST_XML")?></a>
    </div>
</div>
