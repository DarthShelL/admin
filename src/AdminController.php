<?php

namespace DarthShelL\Admin;

use App\Http\Controllers\Controller;
use DarthShelL\Grid\DataProvider;
use DarthShelL\Grid\Renderer;

class AdminController extends Controller
{
    public function index()
    {

        $provider = new DataProvider(new AdminItem());

        $provider->perPage = 10;

        $provider->setAlias([
            'id' => 'ID'
        ]);

        $provider->hideColumn('created_at', 'updated_at');
        $provider->addFilter('id', $provider::INTEGER);
        $provider->addFilter('label', $provider::STRING);

        $provider->addFormat('type', function($row) {
            $types = [
                0 => 'span',
                1 => 'link'
            ];
            return $types[$row->type];
        });

        $provider->processUpdate();

        return view('admin.index', compact('provider'));
    }
}
