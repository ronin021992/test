<?php
namespace TEST\Components\UsersList;

use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\UserTable;
use Bitrix\Main\Engine\Contract\Controllerable;

class UsersListComponent extends \CBitrixComponent implements Controllerable
{

    public function configureActions()
    {
        return [
            'getUsers' => [
                'prefilters' => [],
            ],
            'getCSV' => [
                'prefilters' => [],
            ],
        ];
    }

    public function getUsersAction($post)
    {
        $limit = $post["limit"];
        $offset = $post["limit"]*($post["page"]-1);

        $usersList = $this->getUsers($limit, $offset);
        return $usersList;
    }

    public function executeComponent()
    {

        $cache = Cache::createInstance();
        $cacheId = 'users_list_' . md5(serialize($this->arParams));
        $cacheTime = 864000;
        $cacheDir = 'users_list';

        $cache->abortDataCache();
        if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
            $this->arResult = $cache->getVars();
        } elseif ($cache->startDataCache()) {

            /*Получаем выборку пользователей*/
            $this->arResult["USERS"] = $this->getUsers($this->arParams['LIMIT']);

            /*Получаем кол-во пользователей*/
            $sql = "SELECT COUNT(ID) FROM b_user";
            $connection = Application::getConnection();
            $countUsers = $connection->queryScalar($sql);

            /*Формируем навигацию*/
            $this->arResult["NAV_STRING"] = "";
            $count = ceil($countUsers / $this->arParams['LIMIT']);
            for ($i=1; $i<=$count; $i++){
                $this->arResult["NAV_STRING"] .= '<a data-page="'.$i.'" data-limit="'.$this->arParams['LIMIT'].'">'.$i.'</a>';
            }

            $cache->endDataCache($this->arResult);

        }
        $this->includeComponentTemplate();
    }

    private function getUsers($limit = 5, $offset = 0){

        $userList = UserTable::getList(
            array(
                'order' => array('ID' => 'ASC'),
                'select' => array('ID', 'NAME'),
                'filter' => array(),
                'limit' => $limit,
                'offset' => $offset
            )
        )->fetchAll();

        return $userList;

    }

}