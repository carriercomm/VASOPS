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

    /**
     * isHiddenCategory()
     * Looks to see if any category or categories passed to the function are hidden and returns true if one or more hidden categories is found else returns false.
     * @param mixed $categories
     * @return bool
     */
    static public function isHiddenCategory($categories) {
        //Get a list of all hidden categories and create an array of them
        $hiddenCategories = Category::where('hidden', '=', '1')->get();
        $hiddenCategoriesArray = array();
        foreach ($hiddenCategories as $hiddenCategory) {
            $hiddenCategoriesArray[] = $hiddenCategory->id;
        }
        if (is_array($categories)) {
            foreach ($categories as $category) {
                if (in_array($category, $hiddenCategoriesArray))
                    return true;
            }
        }
        else {
            if (in_array($categories, $hiddenCategoriesArray))
                return true;
        }
        return false;
    }

    /**
     * Returns an array of all hidden categories
     * @return array
     */
    static public function getHiddenCategoriesArray() {
        $categories = Category::where('hidden', '=', 1)->get();
        $hiddenCategories = array();
        foreach ($categories as $category) {
            $hiddenCategories[$category->id] = $hiddenCategories->name;
        }
        return $hiddenCategories;
    }
}