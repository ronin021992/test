<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "LIMIT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("TEST_USER_LIST_LIMIT"),
            "TYPE" => "STRING",
            "DEFAULT" => "5",
        )
    )
);

