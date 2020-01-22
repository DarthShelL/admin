<?php


namespace DarthShelL\Admin;


class Menu
{
    public static $ITEM_SPAN = 0;
    public static $ITEM_LINK = 1;
    public static $templates = [
        0 => 'admin.menu.item-span',
        1 => 'admin.menu.item-link'
    ];
    private $items;
    private $menu_list;

    public function __construct()
    {
        $this->items = AdminItem::all();
        $this->buildMenuList();
    }

    private function buildMenuList()
    {
        // get all items where parent is null
        foreach ($this->items as $item) {
            if (is_null($item->parent)) {
                $obj = [
                    'model' => $item,
                    'sub_items' => []
                ];
                if ($item->visible == 1) {
                    $this->menu_list[] = (object)$obj;
                }
            }
        }

        // get all sub items for each item in list
        foreach ($this->menu_list as $item) {
            foreach ($this->items as $sub_item) {
                if ($item->model->id == $sub_item->parent) {
                    if ($sub_item->visible == 1) {
                        $item->sub_items[] = (object)['model' => $sub_item];
                    }
                }
            }
        }
    }

    private function prepareSubItems(array $sub_items): array
    {
        $items = [];
        foreach ($sub_items as $item) {
            $items[] = $this->renderItem($item);
        }

        return $items;
    }

    private function renderSubMenu(array $sub_items): string
    {
        $items = $this->prepareSubItems($sub_items);

        return view('admin.menu.sub-menu', compact('items'))->render();
    }

    private function renderItem(object $item): string
    {
        switch ($item->model->type) {
            case self::$ITEM_SPAN:
                $_item = [
                    'name' => $item->model->label
                ];

                if (isset($item->sub_items) && count($item->sub_items) > 0) {
                    $_item['sub_menu'] = $this->renderSubMenu($item->sub_items);
                }

                return view(self::$templates[self::$ITEM_SPAN], $_item)->render();
                break;
            case self::$ITEM_LINK:
                $_item = [
                    'name' => $item->model->label,
                    'href' => $item->model->route
                ];

                if (isset($item->sub_items) && count($item->sub_items) > 0) {
                    $_item['sub_menu'] = $this->renderSubMenu($item->sub_items);
                }

                return view(self::$templates[self::$ITEM_LINK], $_item)->render();
                break;
        }
    }

    private function prepareItems(): array
    {
        $items = [];
        foreach ($this->menu_list as $item) {
            $items[] = $this->renderItem($item);
        }

        return $items;
    }

    public function render(): string
    {
        $items = $this->prepareItems();

        return view('admin.menu.main', compact('items'))->render();
    }
}
