<?php

namespace DarthShelL\Admin;

use App\Http\Controllers\Controller;
use DarthShelL\Grid\DataProvider;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $parents_list = [];
        foreach (AdminItem::query()->where(['type' => 0])->get() as $parent) {
            $parents_list[$parent->id] = $parent->label;
        }

        $methods_list = ['get', 'post', 'put', 'delete', 'options', 'patch'];
        $methods = array_combine($methods_list, $methods_list);

        $_c = Helper::getControllers();
        $controllers = array_combine($_c, $_c);

        $setup = [
            'rows_per_page' => 15,
            'pages_in_paginator' => 2,
            'actions_column' => ['name' => ''],
            'row_adding_enabled' => true,
            'columns' => [
                'label' => [
                    'alias' => 'Пункт меню',
                    'filter' => DataProvider::STRING,
                    'format' => null,
                    'validation_rule' => 'required|unique:admin_items',
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::STRING, 'data' => null]
                ],
                'parent' => [
                    'alias' => 'Родитель',
                    'filter' => DataProvider::INTEGER,
                    'format' => function ($row) {
                        $m = AdminItem::find($row->parent);
                        return is_null($m) ? '-' : $m->label;
                    },
                    'validation_rule' => 'exists:admin_items,id',
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::ENUM, 'data' => $parents_list]
                ],
                'type' => [
                    'alias' => 'Тип',
                    'filter' => null,
                    'format' => function ($row) {
                        $types = [0 => 'dropdown', 1 => 'link'];
                        return $types[$row->type];
                    },
                    'validation_rule' => [
                        'required',
                        Rule::in([0, 1]),
                    ],
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::ENUM, 'data' => [0 => 'dropdown', 1 => 'link']]
                ],
                'method' => [
                    'alias' => 'HTTP метод',
                    'filter' => DataProvider::STRING,
                    'format' => null,
                    'validation_rule' => [
                        'required',
                        Rule::in($methods_list),
                    ],
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::ENUM, 'data' => $methods]
                ],
                'route' => [
                    'alias' => 'Путь',
                    'filter' => DataProvider::STRING,
                    'format' => null,
                    'validation_rule' => 'required|unique:admin_items',
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::STRING, 'data' => null]
                ],
                'controller' => [
                    'alias' => 'Контроллер',
                    'filter' => DataProvider::STRING,
                    'format' => null,
                    'validation_rule' => 'required',
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::ENUM, 'data' => $controllers]
                ],
                'action' => [
                    'alias' => 'Метод контроллера',
                    'filter' => DataProvider::STRING,
                    'format' => null,
                    'validation_rule' => 'required',
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::STRING, 'data' => null]
                ],
                'visible' => [
                    'alias' => 'Видимость',
                    'filter' => null,
                    'format' => function ($row) {
                        $v = [
                            0 => 'Нет',
                            1 => 'Да'
                        ];
                        return $v[$row->visible];
                    },
                    'validation_rule' => null,
                    'hidden' => null,
                    'inline_edit' => ['type' => DataProvider::ENUM, 'data' => [0 => 'Нет', 1 => 'Да']]
                ],
            ]
        ];

        $provider = new DataProvider(new AdminItem(), $setup);

        return view('admin.index', compact('provider'));
    }
}
