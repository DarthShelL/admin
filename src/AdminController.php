<?php

namespace DarthShelL\Admin;

use App\Http\Controllers\Controller;
use DarthShelL\Grid\DataProvider;

class AdminController extends Controller
{
    public function index()
    {

        $provider = new DataProvider(new AdminItem());

        $provider->perPage = 10;

        $provider->setAlias([
            'id' => 'ID'
        ]);

        $provider->addActionsColumn();

        $provider->hideColumn('created_at', 'updated_at');
        $provider->addFilter('id', DataProvider::INTEGER);
        $provider->addFilter('label', DataProvider::STRING);

        $provider->addFormat('parent', function ($row) {
            $m = AdminItem::find($row->parent);
            return is_null($m)?'-':$m->label;
        });
        $provider->addFormat('type', function ($row) {
            $types = [
                0 => 'dropdown',
                1 => 'link'
            ];
            return $types[$row->type];
        });
        $provider->addFormat('visible', function ($row) {
            $v = [
                0 => 'No',
                1 => 'Yes'
            ];
            return $v[$row->visible];
        });

        $provider->enableInlineEditing('label', DataProvider::STRING);

        $dropdowns = AdminItem::query()->where(['type'=>0])->get();
        $data = [];
        foreach ($dropdowns as $dd) {
            $data[$dd->id] = $dd->label;
        }
        $provider->enableInlineEditing('parent', DataProvider::ENUM, $data);

        $types = [
            0 => 'dropdown',
            1 => 'link'
        ];
        $provider->enableInlineEditing('type', DataProvider::ENUM, $types);

        $data = [];
        $methods = ['get', 'post', 'put', 'delete', 'options', 'patch'];
        foreach ($methods as $m) {
            $data[$m] = $m;
        }
        $provider->enableInlineEditing('method', DataProvider::ENUM, $data);
        $provider->enableInlineEditing('route', DataProvider::INTEGER);

        $data = [];

        $controllers = Helper::getControllers();
        foreach ($controllers as $controller) {
            $data[$controller] = $controller;
        }
        $provider->enableInlineEditing('controller', DataProvider::ENUM, $data);
        $provider->enableInlineEditing('action', DataProvider::STRING);

        $v = [
            0 => 'No',
            1 => 'Yes'
        ];
        $provider->enableInlineEditing('visible', DataProvider::ENUM, $v);
        $data = ['DarthShelL\Admin\AdminController' => 'DarthShelL\Admin\AdminController'];

        $provider->processUpdate();

        return view('admin.index', compact('provider'));
    }
}
