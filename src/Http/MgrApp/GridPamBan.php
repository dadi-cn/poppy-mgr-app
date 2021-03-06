<?php

namespace Poppy\MgrApp\Http\MgrApp;

use Poppy\MgrApp\Classes\Filter\FilterPlugin;
use Poppy\MgrApp\Classes\Filter\Query\Scope;
use Poppy\MgrApp\Classes\Grid\GridBase;
use Poppy\MgrApp\Classes\Grid\Tools\Interactions;
use Poppy\MgrApp\Classes\Table\Render\GridActions;
use Poppy\MgrApp\Classes\Table\TablePlugin;
use Poppy\System\Models\PamAccount;
use Poppy\System\Models\PamBan;
use Poppy\System\Models\SysConfig;

class GridPamBan extends GridBase
{

    public string $title = '风险拦截';

    /**
     * @inheritDoc
     */
    public function table(TablePlugin $table)
    {
        $table->add('id', "ID")->sortable()->width(90, true)->align('center');
        $table->add('type', "类型")->display(function ($type) {
            return PamBan::kvType($type);
        })->width(100, true)->align('center');
        $table->add('value', "限制值");
        $table->add('note', '备注');
        $table->add('handle', '操作')->asAction(function (GridActions $actions) {
            $row = $actions->getRow();
            $actions->default(['only', 'circle', 'plain']);
            $actions->request("删除", route_url('py-mgr-app:api.ban.delete', [data_get($row, 'id')]))->icon('Close')->danger();
        })->width(60, true);
    }

    public function filter(FilterPlugin $filter)
    {
        $types = PamAccount::kvType();
        foreach ($types as $t => $v) {
            $filter->scope($t, $v)->where('account_type', $t);
        }
    }

    public function quick(Interactions $actions)
    {
        $type = input(Scope::QUERY_NAME, PamAccount::TYPE_USER);

        // 黑名单/白名单
        $status  = sys_setting('py-mgr-page::ban.status-' . $type, SysConfig::DISABLE);
        $isBlack = sys_setting('py-mgr-page::ban.type-' . $type, PamBan::WB_TYPE_BLACK) === PamBan::WB_TYPE_BLACK;
        if ($status) {
            $actions->request('已启用', route_url('py-mgr-app:api.ban.status'))->success()->icon('Open')
                ->confirm('当前启用, 确认禁用风险拦截');
        }
        else {
            $actions->request('已禁用', route_url('py-mgr-app:api.ban.status'))->danger()->icon('TurnOff')
                ->confirm('当前禁用, 确认启用风险拦截');
        }
        if ($isBlack) {
            $actions->request('黑名单模式', route_url('py-mgr-app:api.ban.type'))->info()->default()->icon('Promotion')
                ->confirm('当前黑名单模式, 是否切换到白名单');
        }
        else {
            $actions->request('白名单模式', route_url('py-mgr-app:api.ban.type'))->primary()->default()->icon('Position')
                ->confirm('当前白名单模式, 是否切换到黑名单');
        }
        $actions->page('新增', route_url('py-mgr-app:api.ban.establish'), 'form')->icon('Plus');
    }
}
