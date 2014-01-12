<?php

class Category extends Eloquent {

    public $table = 'categories';
    public $timestamps = FALSE;


    static public function isParent($id) {
        $category = Category::where('id', '=', $id)->first();
        if ($category->parentid == 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    static public function getChildren($id) {
        $categories = Category::where('parentid', '=', $id)->get();
        $children = array();
        foreach ($categories as $category) {
            $children[] = $category->name;
        }
        return $children;
    }

    static public function countChildren($id) {
        $numChildren = Category::where('parentid', '=', $id)->count();
        return $numChildren;
    }
}